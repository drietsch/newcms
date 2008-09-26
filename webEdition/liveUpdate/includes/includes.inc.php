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
 * @package    webEdition_update
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/copyleft/gpl.html  GPL
 */

define('LIVEUPDATE_DIR', $_SERVER['DOCUMENT_ROOT'] . '/webEdition/liveUpdate/');

require_once(LIVEUPDATE_DIR . 'classes/liveUpdateHttp.class.php');
require_once(LIVEUPDATE_DIR . 'classes/liveUpdateResponse.class.php');
require_once(LIVEUPDATE_DIR . 'classes/liveUpdateFrames.class.php');
require_once(LIVEUPDATE_DIR . 'classes/liveUpdateFunctions.class.php');
require_once(LIVEUPDATE_DIR . 'classes/liveUpdateTemplates.class.php');

require_once(LIVEUPDATE_DIR . 'conf/mapping.inc.php');
require_once(LIVEUPDATE_DIR . 'conf/conf.inc.php');
require_once(LIVEUPDATE_DIR . 'includes/define.inc.php');
include_once(LIVEUPDATE_LANGUAGE_DIR . 'liveUpdate.inc.php');


?>