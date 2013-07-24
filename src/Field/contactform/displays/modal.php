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
SPLoader::loadClass('opt.fields.contactform.helper');
?>

<div class="clearfix cfp_icons">
    <div class="cfp_title"><?php echo $params->get('title'); ?></div>
<form method="post"
      action="<?php echo $params->get('formAction'); ?>"
      onsubmit="ContactFormBox.sendMessage(this, <?php echo $params->get('tmpId'); ?>); return false;">
    <div class="cfp_field sender_name">
        <div class="cfp_label">
            <label for="sender_name"
                   class="hasTip"
                   title="<?php echo Sobi::Txt('CF.YOURNAME_LABEL') . '::' . Sobi::Txt('CF.YOURNAME_DESC'); ?>">
<?php echo Sobi::Txt('CF.YOURNAME_LABEL'); ?>
            </label>
        </div>
        <div class="cfp_input">
            <input class="inputbox required"
                   type="text"
                   id="sender_name"
                   name="sender_name"
                   onblur="document.formvalidator.validate(this);"
                   value="<?php echo htmlspecialchars($params->get('sender_name')); ?>"
                   size="<?php echo $params->get('sender_name_size', 40) ?>"
                   maxlength="128" />
        </div>
    </div>
    <div class="cfp_field sender_email">
        <div class="cfp_label">
            <label class="hasTip"
                   for="sender_email"
                   title="<?php echo Sobi::Txt('CF.YOUREMAIL_LABEL') . '::' . Sobi::Txt('CF.YOUREMAIL_DESC'); ?>">
<?php echo Sobi::Txt('CF.YOUREMAIL_LABEL'); ?>
            </label>
        </div>
        <div class="cfp_input">
            <input class="inputbox required validate-email"
                   type="text"
                   id="sender_email"
                   name="sender_email"
                   onblur="document.formvalidator.validate(this);"
                   size="<?php echo $params->get('sender_email_size', 40); ?>"
                   maxlength="256"
                   value="<?php echo htmlspecialchars($params->get('sender_email', '')); ?>" />
        </div>
    </div>
    <div class="cfp_field subject">
        <div class="cfp_label">
            <label class="hasTip"
                   for="subject"
                   title="<?php echo Sobi::Txt('CF.SUBJECT_LABEL') . '::' . Sobi::Txt('CF.SUBJECT_DESC'); ?>">
<?php echo Sobi::Txt('CF.SUBJECT_LABEL'); ?>
            </label>
        </div>
        <div class="cfp_input">
            <input class="inputbox required"
                   data-validators="required"
                   type="text"
                   id="subject"
                   onblur="document.formvalidator.validate(this);"
                   name="subject"
                   maxlength="256"
                   size="<?php echo $params->get('subject_size', 40); ?>"
                   value="<?php echo $params->get('subject', ''); ?>" />
        </div>
    </div>
    <div class="cfp_field message">
        <div class="cfp_label">
            <label class="hasTip"
                   for="message"
                   title="<?php echo Sobi::Txt('CF.MESSAGE_LABEL') . '::' . Sobi::Txt('CF.MESSAGE_DESC'); ?>">
<?php echo Sobi::Txt('CF.MESSAGE_LABEL'); ?>
            </label>
        </div>
        <div class="cfp_input">
            <textarea id="message"
                      class="inputbox required"
                      name="message"
                      onblur="document.formvalidator.validate(this);"><?php
echo htmlspecialchars(trim($params->get('message', '')));
?></textarea>
        </div>
    </div>
    <div class="cfp_field captcha">
        <?php echo SP_CFHelper::displayCaptcha(); ?>
    </div>
    <div class="cfp_field receive_copy">
            <input class="inputbox required"
                   type="checkbox"
                   id="receive_copy"
                   name="receive_copy"
                   maxlength="256"
                   style="width:30px !important;"
                   <?php echo $this->params->get('receive_copy', '0')?'checked="true"':''; ?>
                   value="1" />
<?php echo SPLang::txt('CF.RECEIVE_COPY'); ?>
    </div>
    <input type="hidden"
           id="encoding"
           name="encoding"
           value="<?php echo $params->get('encoding', 'UTF-8'); ?>" />

<?php echo JHtml::_('form.token'); ?>

    <input type="hidden"
           id="mailto"
           name="mailto"
           value="<?php echo $params->get('mailto', ''); ?>"
           class="required" />
    <?php if($params->get('other_email')): ?>
    <input type="hidden"
           id="other_email"
           name="other_email"
           value="<?php echo $params->get('other_email'); ?>" />
    <?php endif; ?>
    <div class="cfp_field">
        <div class="cfp_submit">
            <button type="submit"
                   id="submit"
                   name="submit"
                   class="button">
                <?php echo SPLang::txt('CF.SEND'); ?>
            </button>
        </div>
    </div>
</form>
    <div style="clear:both;"></div>
</div>