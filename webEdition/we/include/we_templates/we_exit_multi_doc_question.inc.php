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


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_html_tools.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/global.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/alert.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/contenttypes.inc.php");

htmlTop($l_global["question"]);

$yesCmd = "yes_cmd_pressed();";
$cancelCmd = "self.close();";

$nextCmd = $_REQUEST["we_cmd"][1];

$ctLngs = '
var ctLngs = new Object();';

foreach ($l_contentTypes as $key => $lng) {
	$ctLngs .= "
	ctLngs[\"$key\"] = \"$lng\";";
}

$untitled = $GLOBALS["l_global"]["untitled"];

print <<< EOFEOF
<script type="text/javascript">

$ctLngs

function yes_cmd_pressed() {
	
	var allHotDocuments = top.opener.top.weEditorFrameController.getEditorsInUse();
	for (frameId in allHotDocuments) {
		
		if ( allHotDocuments[frameId].getEditorIsHot() ) {
			allHotDocuments[frameId].setEditorIsHot(false);
		
		}
	}
	$nextCmd
	self.close();
}

function setHotDocuments() {
	
	var allHotDocuments = top.opener.top.weEditorFrameController.getEditorsInUse();
	var liStr = "";
	
	var _hotDocumentsOfCt = new Object();
	
	for (frameId in allHotDocuments) {
		
		if ( allHotDocuments[frameId].getEditorIsHot() ) {
			
			if ( !_hotDocumentsOfCt[allHotDocuments[frameId].getEditorContentType()] ) {
				_hotDocumentsOfCt[allHotDocuments[frameId].getEditorContentType()] = new Array();
			
			}
			_hotDocumentsOfCt[allHotDocuments[frameId].getEditorContentType()].push( allHotDocuments[frameId] );
		}
	}
	
	for ( ct in _hotDocumentsOfCt ) {
		
		var liCtElem = document.createElement("li");
		liCtElem.innerHTML = ctLngs[ct];
		
		var ulCtElem = document.createElement("ul");
		for (var i=0; i<_hotDocumentsOfCt[ct].length; i++) {
		
			var liPathElem = document.createElement("li");
			
			if ( _hotDocumentsOfCt[ct][i].getEditorDocumentText() ) {
				liPathElem.innerHTML = _hotDocumentsOfCt[ct][i].getEditorDocumentPath();
			} else {
				liPathElem.innerHTML = "<em>$untitled</em>";
			}
			
			ulCtElem.appendChild(liPathElem);
		}
		liCtElem.appendChild( ulCtElem );
		document.getElementById("ulHotDocuments").appendChild( liCtElem );
	}
}
</script>
<style type="text/css">
ul {
	list-style-type		: none;
	margin				: 0;
}
#ulHotDocuments {
	font-weight			: bold;
	padding				: 0 0 1px 2px;

}
#ulHotDocuments li {
	padding-top			: 3px;
}
#ulHotDocuments li ul {
	margin				: 0;
	padding				: 0 0 1px 10px;
}
#ulHotDocuments li ul li {
	font-weight			: normal;
}
</style>
EOFEOF;

$content = '
<div>
	' . $l_alert["exit_multi_doc_question"] . '
	<br />
	<br />
	<div style="width: 350px; height: 150px; background: white; overflow: auto;">
		<ul id="ulHotDocuments">
		
		</ul>
	</div>
</div>
';

print STYLESHEET;
?>
</head>

<body class="weEditorBody" onload="setHotDocuments();" onBlur="self.focus();">
	<?php print htmlYesNoCancelDialog($content,IMAGE_DIR."alert.gif",true,false,true,$yesCmd,"",$cancelCmd); ?>
</body>

</html>