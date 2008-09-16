<?php
/**
 * webEdition CMS
 *
 * LICENSETEXT_CMS
 *
 *
 * @category   webEdition
 * @package    webEdition_toolfactory
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/licence     LICENSETEXT_CMS  TODO insert license type and url
 */

$translate = we_core_Local::addTranslation('apps.xml');

$dialog = new we_ui_dialog_YesNoCancelDialog();


$dialog->setMessage($translate->_('The document has been changed.') . "\n" . $translate->_('Would you like to save your changes?'));
$dialog->setYesAction("weCmdController.fire(dialog.args.yesCmd);");
$dialog->setNoAction("weCmdController.fire(dialog.args.noCmd);");

echo $dialog->getHTML();
