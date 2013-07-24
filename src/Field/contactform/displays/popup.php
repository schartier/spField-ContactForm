<?php
/**
 * ------------------------------------------------------------------------
 * Plugin ContactFormPro for Joomla! 1.7 - 2.5
 * ------------------------------------------------------------------------
 * @copyright   Copyright (C) 2011-2012 Chartiermedia.com - All Rights Reserved.
 * @license     GNU/GPL, http://www.gnu.org/copyleft/gpl.html
 * @author:     Sebastien Chartier
 * @link:     http://www.chartiermedia.com
 * ------------------------------------------------------------------------
 *
 * @package	Joomla.Plugin
 * @subpackage  ContactFormPro
 * @version     1.12
 * @since	1.7
 */

defined('_JEXEC') or die;
?>

<a href="<?php echo $params->get('cfpLink'); ?>"
    class="cfpLink"
    rel='<?php echo $params->get('tmpId'); ?>'>
    <?php echo stripslashes($params->get('label')); ?>
</a>