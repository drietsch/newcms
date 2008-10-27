

$translate = we_core_Local::addTranslation('apps.xml');

$dialog = new we_ui_dialog_YesNoCancelDialog();


$dialog->setMessage($translate->_('The document has been changed.') . "\n" . $translate->_('Would you like to save your changes?'));
$dialog->setYesAction("weCmdController.fire(dialog.args.yesCmd);");
$dialog->setNoAction("weCmdController.fire(dialog.args.noCmd);");

echo $dialog->getHTML();
