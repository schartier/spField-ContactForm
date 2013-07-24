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

class SPContactForm{
    private static $_instance;

    private $params;

    private function SPContactForm(){
        SPLang::load('SpApp.contactform');

        $head = SPFactory::header();
        $head->addJsFile('contactformbox');

        JHTML::_('behavior.formvalidation');

        $this->params = new JObject();
        $this->params->set('cfpLink', JURI::base() . 'index.php?option=com_sobipro&'.SOBI_TASK.'=contactform.modal&sid='.Sobi::Section().'&tmpl=component');
        $this->params->set('formAction', JURI::base() . 'index.php?option=com_sobipro&'.SOBI_TASK.'=contactform.send&sid='.Sobi::Section().'&tmpl=component');
        $this->params->set('successMessage', Sobi::Txt('CF.SUCCESS'));
        $this->params->set("sendingMessage", Sobi::Txt('CF.SENDING_MSG'));
        $this->params->set("senderNameMissing", Sobi::Txt('CF.SENDER_NAME_MISSING'));
        $this->params->set("senderEmailMissing", Sobi::Txt('CF.SENDER_EMAIL_MISSING'));
        $this->params->set("subjectMissing", Sobi::Txt('CF.SUBJECT_MISSING'));
        $this->params->set("messageMissing", Sobi::Txt('CF.MESSAGE_MISSING'));
        $this->params->set("correctErrors", Sobi::Txt('CF.CORRECT_ERRORS'));
        $this->params->set("wrongCaptcha", Sobi::Txt('CF.CAPTCHA_REQUIRE'));
        $this->params->set('label', Sobi::Reg('contactform.mediabox_link_text.value', Sobi::Txt('CF.DEFAULT_TEXT_FOR_MEDIABOX')));
        $this->params->set('style', Sobi::Reg('contactform.style.value', 'light'));
        $this->params->set('title', Sobi::Reg('contactform.title.value', Sobi::Txt('CF.DEFAULT_TITLE')));
    }

    public static function getInstance(){
        if(!self::$_instance){
            $_instance = new SPContactForm();
        }

        return $_instance;
    }

    /**
     *
     * @param JObject $params
     * @param string  $view     (form | popup | modal)
     * @param bool    $return   Determines wether we should return the string or output it
     * @return string
     */
    public function display($params, $view = 'form', $return = false){

        $head = SPFactory::header();

        if($view != 'modal'){
            // Merge default params and new params
            // overwritting default values with new params
            $paramstmp = new JObject($this->params->getProperties());

            if( $paramstmp->setProperties($params->getProperties()) ){
                $params = $paramstmp;
            }

            $params->set("tmpId", 'cfpForm_' . rand(1, 99999));

            $json = $params->get('tmpId') . '=' . json_encode( $params ) . ';';
            $head->addJsCode($json);
        }
        if($view == 'popup'){
            $params->set('display', 'modal');
        }

        $head->addCssFile('contactform.styles.blank');
        $head->addCssFile('contactform.styles.'.$params->get('style', 'light').'.style');

        if($params->get('display_icons', false)){
            $head->addCssFile('contactform.styles.icons');
        }

        $mailto = $params->get('mailto');
        if (!$mailto || !strlen($mailto))
            return ($view=='modal')?Sobi::Txt('CF.MAILTO_MISSING'):"";

        $user = JFactory::getUser();

        if(!$params->get('sender_name', false) && $user->get('id'))
                $params->set('sender_name', $user->get('name'));

        if(!$params->get('sender_email', false) && $user->get('id'))
                $params->set('sender_email', $user->get('email'));

        $width = $params->get('width');
        if(!$width)
            $width = 'auto';
        if (substr($width, -2) != 'px' && substr($width, -1) != '%')
            $params->set('width', $width . 'px');

        if($return)
            ob_start ();

        include implode(DS, array(dirname(__FILE__), 'displays', $view . '.php'));

        if($return)
            return ob_get_length()?ob_get_clean ():"";
    }
}
