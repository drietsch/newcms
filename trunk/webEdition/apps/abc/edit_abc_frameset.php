<?php
					
include_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we.inc.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/apps/abc/class/abcFrames.class.php');

protect();

$what = isset($_REQUEST["pnt"]) ? $_REQUEST["pnt"] : "frameset";

$weFrame=new abcFrames();
$weFrame->View->processVariables();
$weFrame->View->processCommands();
$weFrame->getHTML($what);
		?>