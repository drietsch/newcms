<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/top_feeds.inc.php");

$iDefCols = 2;
$small = 202;
$large = 432;
$iDlgWidth = 480;

$sc1 =  array();
$sc2 =  array();

// define shortcuts
$shortCuts_left = array();
$shortCuts_right = array();

if(defined('FILE_TABLE') && we_hasPerm('CAN_SEE_DOCUMENTS')) {
	$shortCuts_left[] = 'open_document';
	$shortCuts_left[] = 'new_document';
	$shortCutsDocs = '1';
} else {
	$shortCutsDocs = '0';
}

if(defined('TEMPLATES_TABLE')) {
	$shortCutsTemplates = (we_hasPerm('CAN_SEE_TEMPLATES')) ? '1' : '0';
	if(we_hasPerm('NEW_TEMPLATE')) {
		$shortCuts_left[] = 'new_template';
	}
} else {
	$shortCutsTemplates = '0';
}
$shortCuts_left[] = 'new_directory';
if(defined('FILE_TABLE') && we_hasPerm('CAN_SEE_DOCUMENTS')) {
	$shortCuts_left[] = 'unpublished_pages';
}
if (defined('OBJECT_FILES_TABLE') && we_hasPerm('CAN_SEE_OBJECTFILES')) {
	$shortCuts_right[] = 'unpublished_objects';
	$shortCutsObjects = '1';
} else {
	$shortCutsObjects = '0';
}
if (defined('OBJECT_FILES_TABLE') && we_hasPerm('NEW_OBJECTFILE')) {
	$shortCuts_right[] = 'new_object';
}

if(defined('OBJECT_TABLE')) {
	$shortCutsClasses = (we_hasPerm('CAN_SEE_OBJECTS'))? '1' : '0';
	if (we_hasPerm('NEW_OBJECT')) {
		$shortCuts_right[] = 'new_class';
	}
} else {
	$shortCutsClasses = '0';
}
if(we_hasPerm('EDIT_SETTINGS')) {
	$shortCuts_right[] = 'preferences';
}

$aPrefs['sct'] = array(
	'width' => $small,
	'height' => 210,
	'res' => 0,
	'cls' => 'red',
	'csv' => implode(',',$sc1).';'.implode(',',$sc2),
	'dlgHeight' => 435,
	'isResizable' => 1
);
// http://www.living-e.de/de/pressezentrum/pr-mitteilungen/rss2.xml
// aHR0cDovL3d3dy5saXZpbmctZS5kZS9kZS9wcmVzc2V6ZW50cnVtL3ByLW1pdHRlaWx1bmdlbi9yc3MyLnhtbA==
// http://www.webedition.de/de/Presse/Pressemeldungen/rss2.xml
// aHR0cDovL3d3dy53ZWJlZGl0aW9uLmRlL2RlL1ByZXNzZS9QcmVzc2VtZWxkdW5nZW4vcnNzMi54bWw=
$aPrefs['rss'] = array(
	'width' => $small,
	'height' => 307,
	'res' => 0,
	'cls' => 'yellow',
	'csv' => base64_encode('http://www.webedition.de/de/Presse/Pressemeldungen/rss2.xml').',111000,0,110000,1',
	'dlgHeight' => 480,
	'isResizable' => 1
);
$aPrefs['mfd'] = array(
	'width' => $small,
	'height' => 210,
	'res' => 0,
	'cls' => 'lightCyan',
	'csv' => $shortCutsDocs.$shortCutsTemplates.$shortCutsObjects.$shortCutsClasses.';0;5;00;',
	'dlgHeight' => 435,
	'isResizable' => 1
);
$aPrefs['msg'] = array(
	'width' => $small,
	'height' => 100,
	'res' => 0,
	'cls' => 'lightCyan',
	'csv' => '',
	'dlgHeight' => 140,
	'isResizable' => 1
);
$aPrefs['usr'] = array(
	'width' => $small,
	'height' => 210,
	'res' => 0,
	'cls' => 'lightCyan',
	'csv' => '',
	'dlgHeight' => 140,
	'isResizable' => 1
);
$aPrefs['upb'] = array(
	'width' => $small,
	'height' => 210,
	'res' => 0,
	'cls' => 'lightCyan',
	'csv' => $shortCutsDocs.$shortCutsObjects,
	'dlgHeight' => 190,
	'isResizable' => 1
);
$aPrefs['mdc'] = array(
	'width' => $small,
	'height' => 307,
	'res' => 0,
	'cls' => 'white',
	'csv' => ';10;',
	'dlgHeight' => 450,
	'isResizable' => 1
);
$aPrefs['pad'] = array(
	'width' => $large,
	'height' => 307,
	'res' => 1,
	'cls' => 'blue',
	'csv' => base64_encode($l_cockpit['notepad_defaultTitle_DO_NOT_TOUCH']).',30020',
	'dlgHeight' => 560,
	'isResizable' => 0
);
$aPrefs['plg'] = array(
	'width' => $large,
	'height' => 210,
	'res' => 1,
	'cls' => 'white',
	'csv' => '00000000000;',
	'dlgHeight' => 435,
	'isResizable' => 1
);

$aCfgProps = array(
	array(
		array(
			"pad",
			"blue",
			1,
			base64_encode($l_cockpit['notepad_defaultTitle_DO_NOT_TOUCH']).',30020'
		),
		array(
			"mfd",
			"green",
			1,
			$shortCutsDocs.$shortCutsTemplates.$shortCutsObjects.$shortCutsClasses . ';0;5;00;'
		)
	),
	array(
		array(
			"rss",
			"yellow",
			1,
			base64_encode('http://www.webedition.de/de/Presse/Pressemeldungen/rss2.xml').',111000,0,110000,1',
		),
		array(
			"sct",
			"red",
			1,
			implode(',',$shortCuts_left).';'.implode(',',$shortCuts_right)
		)
	)
);

for ($i=0;$i<count($aTopRssFeeds);$i++) {
	foreach ($aTopRssFeeds[$i] as $k=>$v) {
		$aTopRssFeeds[$i][$k] = base64_encode($v);
	}
}
array_push($aCfgProps,$aTopRssFeeds);

$jsPrefs = "
function weConf(){
	this.js_load_=['windows','utils/dimension','utils/prototypes','utils/cockpit'];
	this.color_scheme_={'white':'#FFFFFF','lightCyan':'#F1F5FF','blue':'#CCE4FC','green':'#E2FDC7','orange':'#FBF2C9','red':'#FDE4CB','yellow':'#FDFDBA'};
	this.label_={'font-family':'Arial,Helvetica,sans-serif','font-size':15,'color':'#FFFFFF','font-weight':'bold'};
	this.general_={'cls_collapse':".($small+23).",'cls_expand':".($large+22).",'w_collapse':".$small.",'w_expand':".$large.",'wh_edge':11,'w_icon_bar':40,'iDlgWidth':".$iDlgWidth."};
";

foreach ($aPrefs as $type=>$_prefs) {
	$jsPrefs .= "\tthis.".$type."_props_={'width':".$_prefs["width"].",'height':".$_prefs["height"].
		",'res':".$_prefs["res"].",'cls':'".$_prefs["cls"]."','iDlgHeight':".$_prefs["dlgHeight"]."};\n";
}
$jsPrefs .= "\tthis.blend_={'fadeIn':1,'fadeOut':1,'v':400};
};
var _noResizeTypes=['pad'];
var oCfg=new weConf();
";

?>