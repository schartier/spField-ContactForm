<?php
/**
 * ------------------------------------------------------------------------
 * ContactFrom Field For SobiPro
 * ------------------------------------------------------------------------
 * @copyright   Copyright (C) 2011-2012 Chartiermedia.com - All Rights Reserved.
 * @license     GNU/GPL, http://www.gnu.org/copyleft/gpl.html
 * @author:     Sebastien Chartier
 * @link:     http://www.chartiermedia.com
 * ------------------------------------------------------------------------
 *
 * @package	SobiPro.Field
 * @subpackage  ContactForm
 * @version     1.12
 * @since	1.7
 */
defined('SOBIPRO') || exit('Restricted access');

SPLoader::loadController('controller');

class SPContactFormCtrl extends SPController {

    /**
     * @var string
     */
    protected $_defTask = 'send';

    /**
     * @var string
     */
    protected $_type = 'contactform';

    public function execute() {
        $this->_task = strlen($this->_task) ? $this->_task : $this->_defTask;
        SPLang::load('SpApp.contactform');
        switch ($this->_task) {
            case 'send':
                $this->send();
                break;
            case 'form':
            case 'modal':
                $params = new JObject($_POST);

                $clss = SPLoader::loadClass('opt.fields.contactform.form');
                $spContactForm = call_user_func(array($clss, 'getInstance'));
                $spContactForm->display($params, $this->_task, false);

                break;
            default:
                Sobi::Error(get_class($this), 'Task not found: ' . $this->_task, SPC::WARNING, 404, __LINE__, __FILE__);
                break;
        }
    }

    private function send(){
        $response->status = 0;
        $response->message = "";

        try{
            SPLoader::loadClass('opt.fields.contactform.helper');

            ob_start(null);
            ob_implicit_flush(false);
            $response = SP_CFHelper::sendmail();
            ob_end_clean();
        } catch(Exception $ex){
            header('HTTP/1.1 409 Conflict');
            $response->message = $ex->message;
        }

        SPFactory::mainframe()->cleanBuffer();
        echo json_encode($response);
        exit();
    }
}