<?php
/**
 * ------------------------------------------------------------------------
 * Plugin ContactForm for SobiPro  -  Joomla! 1.7 to 2.5
 * ------------------------------------------------------------------------
 * @copyright   Copyright (C) 2011-2012 Chartiermedia.com - All Rights Reserved.
 * @license     GNU/GPLv3, http://www.gnu.org/copyleft/gpl.html
 * @author:     Sebastien Chartier
 * @link:       http://www.chartiermedia.com
 * ------------------------------------------------------------------------
 *
 * @package	Joomla.Plugin
 * @subpackage  ContactFormPro
 * @version     1.12 (February 20, 2012)
 * @since	1.7
 */
// No direct access
defined('_JEXEC') or die;

/**
 * Helper class for ContactFormPro
 *
 * @author Sebastien Chartier
 */
class SP_CFHelper {

    static function displayCaptcha() {
        return self::displayMathGuard();
    }

    static function validateCaptcha() {
        return self::validateMathGuard();
    }

    private static function displayMathGuard() {
        require_once(dirname(__FILE__) . DS . 'captcha' . DS . 'mathGuard.class.php');

        $attributes = array();
        $attributes['id'] = 'mathguard_answer_cfp';

        $html = '';
        $html .= '<label class="requiredField" id="label-mathguard_answer" >'
                . Sobi::Txt("CF.MATHGUARD_SECURITY_QUESTION") . ' : </label> ';
        $html .= mathGuardImproved::returnQuestion($attributes);

        return $html;
    }

    private static function validateMathGuard() {
        require_once(dirname(__FILE__) . DS . 'captcha' . DS . 'mathGuard.class.php');

        foreach(JRequest::get('POST') as $key => $value){
            if(preg_match('/^captcha_code.*/', $key)){
                return mathGuardImproved::checkResult($key, $value);
            }
        }

        return false;
    }

    static function shutdownFunction(){

    }

    /**
     * Sends email for ContactFormPro.
     *
     * Message information is extract from Post vars.
     *
     * @return string   HTML results
     */
    static function sendmail() {
        // Function must return json, prevent Joomla! from displaying
        // regular
        //register_shutdown_function(self::shutdownFunction());
        jimport('joomla.mail.helper');

        $response->status = 1001;
        $response->message = "";

        if (JRequest::getString("error_message"))
            $response->message .= html_entity_decode(urldecode(JRequest::getString("error_message")));
        else
            $response->message .= '<p>' . Sobi::Txt('CF.GENERIC_ERROR') . '</p>';


        if (!JRequest::checkToken()) {
            $response->status = 9999;
            $response->message .= '<p>' . JText::_('JINVALID_TOKEN') . '</p>';
        }

        $debug = JRequest::getVar('debug');

        $mailto = JRequest::getVar('mailto');
        $mailto = str_replace("#", "@", $mailto);

        if (!$mailto) {
            $response->status = 1101;
            $response->message .= '<p>' . Sobi::Txt('CF.MAILTO_MISSING') . '</p>';
        }else{
            $mailto = explode(';', $mailto);
        }

        $sender_email = JRequest::getVar('sender_email');
        if (!$sender_email || !JMailHelper::isEmailAddress($sender_email)) {
            $response->status = 1201;
            $response->message .= '<p>' . Sobi::Txt('CF.SENDER_EMAIL_MISSING') . '</p>';
        }

        $message = stripslashes(JRequest::getVar('message'));
        if (!$message || $message == '') {
            $response->status = 1301;
            $response->message .= '<p>' . Sobi::Txt('CF.MESSAGE_MISSING') . '</p>';
        }

        $sender_name = stripslashes(JRequest::getVar('sender_name'));
        if (!$sender_name || $sender_name == '') {
            $response->status = 1401;
            $response->message .= '<p>' . Sobi::Txt('CF.SENDER_NAME_MISSING') . '</p>';
        }

        $subject = stripslashes(JRequest::getVar('subject'));
        if (!$subject || $subject == '') {
            $response->status = 1501;
            $response->message .= '<p>' . Sobi::Txt('CF.SUBJECT_MISSING') . '</p>';
        }

        if (!self::validateCaptcha()) {
            $response->status = 1601;
            $response->message .= '<p>' . Sobi::Txt('CF.CAPTCHA_REQUIRE') . '</p>';
        }

        if ($response->status > 1001)
            return $response;

        $encoding = JRequest::getVar('encoding');
        $encoding || ($encoding = "UTF-8");

        // header injection test
        // An array of e-mail headers we do not want to allow as input

        $headers = array('Content-Type:',
            'MIME-Version:',
            'Content-Transfer-Encoding:',
            'bcc:',
            'cc:');

        // An array of the input fields to scan for injected headers

        $fields = array('mailto',
            'sender_name',
            'sender_email',
            'subject',
        );

        // iterate over variables and search for headers

        foreach ($fields as $field) {

            foreach ($headers as $header) {

                if (strpos(JRequest::getVar($field), $header) !== false) {

                    JError::raiseError(403, '');
                }
            }
        }

        unset($headers, $fields);

        $emailSubject = sprintf(Sobi::Txt('CF.EMAIL_SUBJECT'), $sender_name);

        // add header
        $emailBody = '
            <p><b>' . Sobi::Txt('CF.SUBJECT_LABEL') . '</b>: ' . JMailHelper::cleanBody($subject) . '</p>
            <p></p>
            <p><b>' . Sobi::Txt('CF.MESSAGE_LABEL') . ' : </b></p>
            <p>' . JMailHelper::cleanBody(nl2br($message)) . '</p>
            <p></p>
            <p>' . $sender_name . '
                <br />' . $sender_email . '</p>
            <p></p>
            <p></p>
            <p><small>: ' .
                $_SERVER['HTTP_REFERER'] . '</small></p>';

        $emailBody = mb_convert_encoding($emailBody, 'HTML-ENTITIES', $encoding);

        $adminemail = JRequest::getString('other_email');
        if($adminemail){
            $bcc = explode(';', $adminemail);
            //$adminemail = explode(';', $adminemail);
            //$error_info .= CFPHelper::_send_email($sender_name, $sender_email, $adminemail, $emailSubject, $emailBody, true);
        }else{
            $bcc = array();
        }

        if(JRequest::getBool('receive_copy')){
            $bcc[] = $sender_email;
            //$error_info .= CFPHelper::_send_email($sender_name, $sender_email, $sender_email, $emailSubject, $emailBody, true);
        }

        // send email
        $error_info = self::_send_email($sender_name, $sender_email, $mailto, $emailSubject, $emailBody, $bcc, true);

        if ($error_info == '') {
            $response->status = 1;
            if (JRequest::getString("success_message"))
                $response->message = html_entity_decode(urldecode(JRequest::getString("success_message")));
            else
                $response->message = Sobi::Txt('CF.SUCCESS');
        } else {
            $response->status = 1501;

            if ($debug || JDEBUG)
                $response->message = $error_info;
        }
        
        return $response;
    }

    /**
     *
     * @param Object $response
     */
    private static function responseToHTML($response){
        ?>
        <div class="cfp_msg_inner">
            <div class="cfp_msg_inner_top">
                <div class="cfp_msg_res <?php echo ($response->status == 1)?'success':'failure'; ?>">
                    <span class="cfp_msg_res_txt">
                        <?php echo Sobi::Txt('CF.CORRECT_ERRORS'); ?>
                    </span>
                </div>
            </div>
        </div>
        <?php
    }

    /**
     * Internal function to send email
     *
     * @param String $sender_name
     * @param String $sender_email
     * @param String $recipient
     * @param String $subject
     * @param String $body
     * @param bool $isHTML
     *
     * @return string   Returns the error message, if any!
     */
    private static function _send_email($sender_name, $sender_email, $recipient, $subject, $body, $bcc, $isHTML=false) {

        $config =& JFactory::getConfig();
        $sender = array(
            $config->getValue('config.mailfrom'),
            $config->getValue('config.fromname')
        );

        // set sender
        $replyto = array(
            $sender_email,
            $sender_name
        );

        // set mail data
        $mailer = & JFactory::getMailer();

        $mailer->addReplyTo($replyto);

        $mailer->addBCC($bcc);

        $mailer->addRecipient($recipient);

        $mailer->setSender($sender);

        $mailer->isHTML($isHTML);

        $mailer->setSubject($subject);

        $mailer->setBody($body);

        // send email
        ob_start();
        $send = & $mailer->Send();
        $error = ob_get_clean();

        return $error;
    }

}