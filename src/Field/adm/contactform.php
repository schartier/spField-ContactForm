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
defined( 'SOBIPRO' ) || exit( 'Restricted access' );
SPLoader::loadClass( 'opt.fields.contactform' );


class SPField_ContactformAdm extends SPField_Contactform implements SPFieldInterface
{

	public function onFieldEdit( &$view )
	{
		SPLang::load( 'SpApp.contactform' );

                $displays = array(
                    'form' => 'form',
                    'popup' => 'popup'
                    );
                $view->assign($displays, 'displays');

                $styles_dir = SPLoader::translatePath('contactform.styles', 'css', true, false);
                foreach( scandir($styles_dir) as $file){

                    if( is_dir( $styles_dir . DS . $file )
                        && substr($file, 0, 1) != '.'){

                        $styles[$file] = $file;

                    }

                }

                $view->assign($styles, 'styles');
	}

	public function save( &$attr )
	{
            if( isset( $attr[ 'allowedProtocols' ] ) ) {
			$attr[ 'allowedProtocols' ] = explode( '|', $attr[ 'allowedProtocols' ] );
		}
		$myAttr = $this->getAttr();
		$properties = array();
		if( count( $myAttr ) ) {
			foreach ( $myAttr as $property ) {
				$properties[ $property ] = isset( $attr[ $property ] ) ? ( $attr[ $property ] ) : null;
			}
		}
		$attr[ 'params' ] = $properties;
	}
}