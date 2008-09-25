<?php
/**
 * webEdition CMS
 *
 * This source is part of webEdition CMS. webEdition CMS is
 * free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * any later version.
 *
 * The GNU General Public License can be found at
 * http://www.gnu.org/copyleft/gpl.html.
 * A copy is found in the textfile
 * webEdition/licenses/webEditionCMS/License.txt
 *
 * @category   webEdition
 * @package    webEdition_toolfactory
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/copyleft/gpl.html  GPL
 */

$translate = we_core_Local::addTranslation('apps.xml');

$dialog = new we_ui_dialog_YesNoCancelDialog();


$dialog->setMessage($translate->_('The document has been changed.') . "\n" . $translate->_('Would you like to save your changes?'));
$dialog->setYesAction("weCmdController.fire(dialog.args.yesCmd);");
$dialog->setNoAction("weCmdController.fire(dialog.args.noCmd);");

echo $dialog->getHTML();
