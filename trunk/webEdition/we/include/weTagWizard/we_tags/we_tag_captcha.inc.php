<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_textAttribute.class.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_selectAttribute.class.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_choiceAttribute.class.php');

$GLOBALS['weTagWizard']['weTagData']['needsEndtag'] = false;

$GLOBALS['weTagWizard']['attribute']['id653_width'] = new weTagData_textAttribute('653', 'width', true, '');
$GLOBALS['weTagWizard']['attribute']['id654_height'] = new weTagData_textAttribute('654', 'height', true, '');
$GLOBALS['weTagWizard']['attribute']['id655_maxlength'] = new weTagData_textAttribute('655', 'maxlength', false, '');
$GLOBALS['weTagWizard']['attribute']['id682_path'] = new weTagData_textAttribute('682', 'path', false, '');
$GLOBALS['weTagWizard']['attribute']['id662_subset'] = new weTagData_selectAttribute('662', 'subset', array(new weTagDataOption('alphanum', false, ''), new weTagDataOption('alpha', false, ''), new weTagDataOption('num', false, '')), false, '');
$GLOBALS['weTagWizard']['attribute']['id673_skip'] = new weTagData_textAttribute('673', 'skip', false, '');
$GLOBALS['weTagWizard']['attribute']['id671_fontcolor'] = new weTagData_choiceAttribute('671', 'fontcolor', array(new weTagDataOption('#000000', false, ''), new weTagDataOption('#ffffff', false, ''), new weTagDataOption('#ff0000', false, ''), new weTagDataOption('#00ff00', false, ''), new weTagDataOption('#0000ff', false, ''), new weTagDataOption('#ffff00', false, ''), new weTagDataOption('#ff00ff', false, ''), new weTagDataOption('#00ffff', false, '')), false,true, '');
$GLOBALS['weTagWizard']['attribute']['id658_fontsize'] = new weTagData_textAttribute('658', 'fontsize', false, '');
$GLOBALS['weTagWizard']['attribute']['id674_bgcolor'] = new weTagData_choiceAttribute('674', 'bgcolor', array(new weTagDataOption('#ffffff', false, ''), new weTagDataOption('#cccccc', false, ''), new weTagDataOption('#888888', false, '')), false,false, '');
$GLOBALS['weTagWizard']['attribute']['id681_transparent'] = new weTagData_selectAttribute('681', 'transparent', array(new weTagDataOption('false', false, ''), new weTagDataOption('true', false, '')), false, '');
$GLOBALS['weTagWizard']['attribute']['id675_style'] = new weTagData_choiceAttribute('675', 'style', array(new weTagDataOption('strikeout', false, ''), new weTagDataOption('fullcircle', false, ''), new weTagDataOption('fullrectangle', false, ''), new weTagDataOption('outlinecircle', false, ''), new weTagDataOption('outlinerectangle', false, '')), false,true, '');
$GLOBALS['weTagWizard']['attribute']['id676_stylecolor'] = new weTagData_choiceAttribute('676', 'stylecolor', array(new weTagDataOption('#cccccc', false, ''), new weTagDataOption('#ff0000', false, ''), new weTagDataOption('#00ff00', false, ''), new weTagDataOption('#0000ff', false, ''), new weTagDataOption('#00ffff', false, ''), new weTagDataOption('#ff00ff', false, ''), new weTagDataOption('#ffff00', false, '')), false,true, '');
$GLOBALS['weTagWizard']['attribute']['id677_angle'] = new weTagData_textAttribute('677', 'angle', false, '');
$GLOBALS['weTagWizard']['attribute']['id721_align'] = new weTagData_selectAttribute('721', 'align', array(new weTagDataOption('random', false, ''), new weTagDataOption('center', false, ''), new weTagDataOption('left', false, ''), new weTagDataOption('right', false, '')), false, '');
$GLOBALS['weTagWizard']['attribute']['id665_valign'] = new weTagData_selectAttribute('665', 'valign', array(new weTagDataOption('random', false, ''), new weTagDataOption('top', false, ''), new weTagDataOption('middle', false, ''), new weTagDataOption('bottom', false, '')), false, '');
$GLOBALS['weTagWizard']['attribute']['id717_font'] = new weTagData_textAttribute('717', 'font', false, '');
$GLOBALS['weTagWizard']['attribute']['id657_fontpath'] = new weTagData_textAttribute('657', 'fontpath', false, '');
$GLOBALS['weTagWizard']['attribute']['id663_case'] = new weTagData_selectAttribute('663', 'case', array(new weTagDataOption('mix', false, ''), new weTagDataOption('upper', false, ''), new weTagDataOption('lower', false, '')), false, '');
$GLOBALS['weTagWizard']['attribute']['id680_type'] = new weTagData_selectAttribute('680', 'type', array(new weTagDataOption('gif', false, ''), new weTagDataOption('jpg', false, ''), new weTagDataOption('png', false, '')), false, '');
$GLOBALS['weTagWizard']['attribute']['id669_stylenumber'] = new weTagData_textAttribute('669', 'stylenumber', false, '');
?>