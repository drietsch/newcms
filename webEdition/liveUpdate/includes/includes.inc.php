<?php
/**
 * webEdition CMS
 *
 * LICENSETEXT_CMS
 *
 *
 * @category   we
 * @package    we_update
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/licence     LICENSETEXT_CMS  TODO insert license type and url
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