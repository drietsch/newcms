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
 * @package    webEdition_base
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/copyleft/gpl.html  GPL
 */

include_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we.inc.php');
  
protect();

if(!isset($_REQUEST['id']) || $_REQUEST['id']=='') {
	exit();
}
if(!isset($_REQUEST['path']) || $_REQUEST['path']=='') {
	exit();
}
if(!isset($_REQUEST['size']) || $_REQUEST['size']=='') {
	exit();
}
if(!isset($_REQUEST['extension']) || $_REQUEST['extension']=='') {
	exit();
}

$imageId = abs($_REQUEST['id']);
$imagePath = addslashes($_REQUEST['path']);
$imageSize = abs($_REQUEST['size']);

$whiteList = array();
$exts = isset($GLOBALS["WE_CONTENT_TYPES"]["image/*"]["Extension"]) ? $GLOBALS["WE_CONTENT_TYPES"]["image/*"]["Extension"] : "";
if(!empty($exts)){
	$whiteList = makeArrayFromCSV($exts);
}

if (!in_array($_REQUEST['extension'], $whiteList)) {
	exit();
}

$imageExt = substr($_REQUEST['extension'], 1, strlen($_REQUEST['extension']));

include_once($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_classes/base/we_image_edit.class.php");

$thumbpath = we_image_edit::createPreviewThumb($imagePath, $imageId, $imageSize, $imageSize, substr($_REQUEST['extension'], 1));
  
header("Content-type: image/" . $imageExt . "");
  
readfile($_SERVER["DOCUMENT_ROOT"] . $thumbpath);

?>