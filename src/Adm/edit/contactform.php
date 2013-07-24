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
?>
<div class="col width-70" style="float: left;">
    <fieldset class="adminform" style="border: 1px dashed silver;">
        <legend>

            <?php $this->txt('CF.CONFIG_TITLE'); ?>

        </legend>

        <table class="admintable" cellspacing="1">

            <tr class="row<?php echo++$row % 2; ?>" style="vertical-align:middle;">

                <td class="key" style="padding: 8px;">

                    <label for="other_email">

                        <?php $this->txt('CF.CONFIG_OTHER_EMAIL_FIELD_LABEL'); ?>

                    </label>

                </td>

                <td>

                    <?php $this->field('text', 'field.other_email', 'value:field.other_email', array('id' => 'other_email', 'size' => 30, 'maxlength' => 255, 'class' => 'inputbox')); ?>

                </td>

                <td style="padding: 8px;">

                    <?php $this->txt('CF.CONFIG_OTHER_EMAIL_FIELD_DESC'); ?>

                </td>

            </tr>

            <tr class="row<?php echo++$row % 2; ?>" style="vertical-align:middle;">

                <td class="key" style="padding: 8px;">

                    <label for="title">

                        <?php $this->txt('CF.CONFIG_FORM_TITLE_FIELD_LABEL'); ?>

                    </label>

                </td>

                <td>

                    <?php $this->field('text', 'field.title', 'value:field.title', array('id' => 'title', 'size' => 30, 'maxlength' => 255, 'class' => 'inputbox')); ?>

                </td>

                <td style="padding: 8px;">

                    <?php $this->txt('CF.CONFIG_FORM_TITLE_FIELD_DESC'); ?>

                </td>

            </tr>

            <tr class="row<?php echo++$row % 2; ?>" style="vertical-align:middle;">

                <td class="key" style="padding: 8px;">

                    <label for="display">

                        <?php $this->txt('CF.CONFIG_DISPLAY_LABEL'); ?>

                    </label>

                </td>

                <td>

                    <?php $this->field('select', 'field.display', $this->get('displays'), 'value:field.display', false, 'id=display, size=1, class=inputbox spCfgNumberSelectList'); ?>

                </td>

                <td style="padding: 8px;">

                    <?php $this->txt('CF.CONFIG_DISPLAY_DESC'); ?>

                </td>

            </tr>

            <tr class="row<?php echo++$row % 2; ?>" style="vertical-align:middle;">

                <td class="key" style="padding: 8px;">

                    <label for="style">

                        <?php $this->txt('CF.CONFIG_MEDIABOX_STYLE_LABEL'); ?>

                    </label>

                </td>

                <td>

                    <?php $this->field('select', 'field.style', $this->get('styles'), 'value:field.style', false, 'id=style, size=1, class=inputbox spCfgNumberSelectList'); ?>

                </td>

                <td style="padding: 8px;">

                    <?php $this->txt('CF.CONFIG_MEDIABOX_STYLE_DESC'); ?>

                </td>

            </tr>

            <tr class="row<?php echo++$row % 2; ?>">
                <td class="key">
                    <label for="display_icons">
                        <?php $this->txt('CF.DISPLAY_ICONS'); ?>
                    </label>
                </td>
                <td>
                    <?php $this->field('states', 'field.display_icons', 'value:field.display_icons', 'display_icons', 'yes_no', 'class=inputbox'); ?>
                </td>
            </tr>

            <tr class="row<?php echo++$row % 2; ?>" style="vertical-align:middle;">

                <td class="key" style="padding: 8px;">

                    <label for="mediabox_link_text">

                        <?php $this->txt('CF.CONFIG_MEDIABOX_LINK_TEXT_LABEL'); ?>

                    </label>

                </td>

                <td>

                    <?php $this->field('text', 'field.mediabox_link_text', 'value:field.mediabox_link_text', array('id' => 'mediabox_link_text', 'size' => 30, 'maxlength' => 255, 'class' => 'inputbox')); ?>

                </td>

                <td style="padding: 8px;">

                    <?php $this->txt('CF.CONFIG_MEDIABOX_LINK_TEXT_DESC'); ?>

                </td>

            </tr>
            <tr class="row<?php echo++$row % 2; ?>">
                <td class="key">
                    <?php $this->txt('CF.URL_FIELD_WIDTH'); ?>
                </td>
                <td>
                    <?php $this->field('text', 'field.width', 'value:field.width', 'id=field_width, size=5, maxlength=10, class=inputbox, style=text-align:center;'); ?>&nbsp;px.
                </td>
            </tr>
            <tr class="row<?php echo++$row % 2; ?>">
                <td class="key">
                    <?php $this->txt('CF.URL_MAX_LENGTH'); ?>
                </td>
                <td>
                    <?php $this->field('text', 'field.maxLength', 'value:field.maxLength', 'id=field_max_length, size=5, maxlength=10, class=inputbox, style=text-align:center;'); ?>
                </td>
            </tr>
            <tr class="row<?php echo++$row % 2; ?>">
                <td class="key">
                    <?php $this->txt('CF.VALIDATE_MX'); ?>
                </td>
                <td>
                    <?php $this->field('states', 'field.validateUrl', 'value:field.validateUrl', 'validateUrl', 'yes_no', 'class=inputbox'); ?>
                </td>
            </tr>
            <tr class="row<?php echo++$row % 2; ?>">
                <td class="key">
                    <?php $this->txt('CF.BOTS_PROTECT'); ?>
                </td>
                <td>
                    <?php $this->field('states', 'field.botProtection', 'value:field.botProtection', 'botProtection', 'yes_no', 'class=inputbox'); ?>
                </td>
            </tr>

        </table>

    </fieldset>
</div>
