<?php
  include_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we.inc.php');
  
  protect();
  
  $imageId = $_REQUEST['id'];
  $imagePath = $_REQUEST['path'];
  $imageSize = $_REQUEST['size'];
  $imageExt = substr($_REQUEST['extension'], 1, strlen($_REQUEST['extension']));
  
  include_once($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_classes/base/we_image_edit.class.php");
  $thumbpath = we_image_edit::createPreviewThumb($imagePath, $imageId, $imageSize, $imageSize, substr($_REQUEST['extension'], 1));
  
  header("Content-type: image/" . $imageExt . "");
  
  readfile($_SERVER["DOCUMENT_ROOT"] . $thumbpath);
?>