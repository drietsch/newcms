<?php

/**
 * webEdition CMS
 *
 * LICENSETEXT_CMS
 *
 *
 * @category   we
 * @package    we_base
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/licence     LICENSETEXT_CMS  TODO insert license type and url
 */

include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_html_tools.inc.php");
protect();
htmlTop();


$showDocuments = we_hasPerm("CAN_SEE_DOCUMENTS") || we_hasPerm("ADMINISTRATOR");
$showTemplates = we_hasPerm("CAN_SEE_TEMPLATES") || we_hasPerm("ADMINISTRATOR");
if(defined("OBJECT_TABLE")){
	$showObjects = we_hasPerm("CAN_SEE_OBJECTFILES") || we_hasPerm("ADMINISTRATOR");
	$showClasses = we_hasPerm("CAN_SEE_OBJECTS") || we_hasPerm("ADMINISTRATOR");
}else{
	$showObjects = false;
	$showClasses = false;
}

$_treewidth = isset($_COOKIE["treewidth_main"]) ? $_COOKIE["treewidth_main"]  : WE_TREE_DEFAULT_WIDTH;

?>
<script language="JavaScript" type="text/javascript" src="<?php print JS_DIR; ?>images.js"></SCRIPT>
<script language="JavaScript" type="text/javascript" src="<?php print JS_DIR; ?>we_tabs.js"></SCRIPT>
<script language="JavaScript" type="text/javascript">



	function we_cmd(){
		var args = "";
		var url = "<?php print WEBEDITION_DIR; ?>we_cmd.php?"; for(var i = 0; i < arguments.length; i++){ url += "we_cmd["+i+"]="+escape(arguments[i]); if(i < (arguments.length - 1)){ url += "&"; }}
		switch(arguments[0]){
			case "load":
				var op = top.makeFoldersOpenString();
				parent.we_cmd("load",arguments[1],0,op,top.treeData.table);
				break;
			default:
				for(var i = 0; i < arguments.length; i++){
					args += 'arguments['+i+']' + ( (i < (arguments.length-1)) ? ',' : '');
				}
				eval('parent.we_cmd('+args+')');
		}
	}

	function setTab(table){
		if(we_tabs == null){
			setTimeout("setTab('"+table+"')",500);
			return;
		}
		switch(table){
			case "<?php print FILE_TABLE; ?>":
				we_tabs[0].setState(TAB_ACTIVE,false,we_tabs);
				break;
			case "<?php print TEMPLATES_TABLE; ?>":
				we_tabs[1].setState(TAB_ACTIVE,false,we_tabs);
				break;
			<?php
			if( defined("OBJECT_FILES_TABLE") ){
			?>
			case "<?php print OBJECT_FILES_TABLE; ?>":
				we_tabs[2].setState(TAB_ACTIVE,false,we_tabs);
				break;
			case "<?php print OBJECT_TABLE; ?>":
				we_tabs[3].setState(TAB_ACTIVE,false,we_tabs);
				break;

			<?php
			}
			?>
		}
	}

	<?php
		/**
		 * GET WIDTH AND HEIGHT OF VERTICAL TABS
		 */

		// Documents
		if (file_exists($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/v-tabs/documents_normal.gif")) {
			$_v_tab_documents = getimagesize($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/v-tabs/documents_normal.gif");
		}

		// Templates
		if (file_exists($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/v-tabs/templates_normal.gif")) {
			$_v_tab_templates = getimagesize($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/v-tabs/templates_normal.gif");
		}

		// Check for other tabs if Object module installed
		if (defined("OBJECT_TABLE")) {
			// Objects
			if (file_exists($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/v-tabs/objects_normal.gif")) {
				$_v_tab_objects = getimagesize($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/v-tabs/objects_normal.gif");
			}

			// Classes
			if (file_exists($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/v-tabs/classes_normal.gif")) {
				$_v_tab_classes = getimagesize($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/v-tabs/classes_normal.gif");
			}
		}

	?>

	var we_tabs = new Array(
		new we_tab('#','<?php print WEBEDITION_DIR; ?>we/include/we_language/<?php print $GLOBALS["WE_LANGUAGE"]; ?>/v-tabs/documents_normal.gif', '<?php print WEBEDITION_DIR; ?>we/include/we_language/<?php print $GLOBALS["WE_LANGUAGE"]; ?>/v-tabs/documents_active.gif', '<?php print WEBEDITION_DIR; ?>we/include/we_language/<?php print $GLOBALS["WE_LANGUAGE"]; ?>/v-tabs/documents_disabled.gif', <?php isset($_v_tab_documents[0]) ? (print $_v_tab_documents[0]) : (print "19") ?>, <?php isset($_v_tab_documents[1]) ? (print $_v_tab_documents[1]) : (print "83") ?>, <?php print ($showDocuments ? "TAB_ACTIVE" : "TAB_DISABLED"); ?>, "if(top.deleteMode){we_cmd('exit_delete', '<?php print FILE_TABLE; ?>');};treeOut();we_cmd('load', '<?php print FILE_TABLE; ?>' ,0)"),
		new we_tab('#','<?php print WEBEDITION_DIR; ?>we/include/we_language/<?php print $GLOBALS["WE_LANGUAGE"]; ?>/v-tabs/templates_normal.gif', '<?php print WEBEDITION_DIR; ?>we/include/we_language/<?php print $GLOBALS["WE_LANGUAGE"]; ?>/v-tabs/templates_active.gif', '<?php print WEBEDITION_DIR; ?>we/include/we_language/<?php print $GLOBALS["WE_LANGUAGE"]; ?>/v-tabs/templates_disabled.gif', <?php isset($_v_tab_templates[0]) ? (print $_v_tab_templates[0]) : (print "19") ?>, <?php isset($_v_tab_templates[1]) ? (print $_v_tab_templates[1]) : (print "83") ?>, <?php print ($showTemplates ? "TAB_ACTIVE" : "TAB_DISABLED"); ?>, "if(top.deleteMode){we_cmd('exit_delete', '<?php print TEMPLATES_TABLE; ?>');};treeOut();we_cmd('load', '<?php print TEMPLATES_TABLE; ?>', 0)")
		<?php if(defined("OBJECT_TABLE")): ?>,
			new we_tab('#','<?php print WEBEDITION_DIR; ?>we/include/we_language/<?php print $GLOBALS["WE_LANGUAGE"]; ?>/v-tabs/objects_normal.gif', '<?php print WEBEDITION_DIR; ?>we/include/we_language/<?php print $GLOBALS["WE_LANGUAGE"]; ?>/v-tabs/objects_active.gif', '<?php print WEBEDITION_DIR; ?>we/include/we_language/<?php print $GLOBALS["WE_LANGUAGE"]; ?>/v-tabs/objects_disabled.gif', <?php isset($_v_tab_objects[0]) ? (print $_v_tab_objects[0]) : (print "19") ?>, <?php isset($_v_tab_objects[1]) ? (print $_v_tab_objects[1]) : (print "83") ?>, <?php print ($showObjects ? "TAB_ACTIVE" : "TAB_DISABLED"); ?>, "if(top.deleteMode){we_cmd('exit_delete', '<?php print OBJECT_FILES_TABLE; ?>');};treeOut();we_cmd('load', '<?php print OBJECT_FILES_TABLE; ?>', 0)"),
			new we_tab('#','<?php print WEBEDITION_DIR; ?>we/include/we_language/<?php print $GLOBALS["WE_LANGUAGE"]; ?>/v-tabs/classes_normal.gif', '<?php print WEBEDITION_DIR; ?>we/include/we_language/<?php print $GLOBALS["WE_LANGUAGE"]; ?>/v-tabs/classes_active.gif', '<?php print WEBEDITION_DIR; ?>we/include/we_language/<?php print $GLOBALS["WE_LANGUAGE"]; ?>/v-tabs/classes_disabled.gif', <?php isset($_v_tab_classes[0]) ? (print $_v_tab_classes[0]) : (print "19") ?>, <?php isset($_v_tab_classes[1]) ? (print $_v_tab_classes[1]) : (print "83") ?>, <?php print ($showClasses ? "TAB_ACTIVE" : "TAB_DISABLED"); ?>, "if(top.deleteMode){we_cmd('exit_delete', '<?php print OBJECT_TABLE; ?>');};treeOut();we_cmd('load', '<?php print OBJECT_TABLE; ?>', 0)")
		<?php endif ?>
	);

	var oldWidth = <?php print WE_TREE_DEFAULT_WIDTH; ?>;

	function toggleTree() {


		var resizeframe = parent.parent.document.getElementById("resizeframeid");
		var cols = resizeframe.cols;
		var pairs = cols.split(",");
		var w = top.getTreeWidth();

		if (w <= 22) {
			var newWidth = oldWidth+4;
			top.setTreeWidth(newWidth);
			top.setTreeArrow("left");
			top.storeTreeWidth(newWidth);
		} else {
			oldWidth = w;
			top.setTreeWidth(22);
			top.setTreeArrow("right");
			top.storeTreeWidth(22);
		}



		<?php if($GLOBALS["BROWSER"] == "SAFARI") { ?>
		parent.parent.bm_content_frame.bm_resize.calculateStartWidth();
		<?php } ?>

	}

	function treeOut() {


		var resizeframe = parent.parent.document.getElementById("resizeframeid");
		var cols = resizeframe.cols;
		var pairs = cols.split(",");
		var w = top.getTreeWidth();

		if (w <= 22) {
			var newWidth = oldWidth;
			top.setTreeWidth(newWidth);
			top.setTreeArrow("left");
			top.storeTreeWidth(newWidth);

			<?php if($GLOBALS["BROWSER"] == "SAFARI") { ?>
			parent.parent.bm_content_frame.bm_resize.calculateStartWidth();
			<?php } ?>

		}




	}

</script>
	</head>
	<body bgcolor="#ffffff" leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" style="background-image: url(<?php print IMAGE_DIR; ?>v-tabs/background.gif);background-repeat:repeat-y;border-top:1px solid black;">
		<div style="position:absolute;top:8px;left:5px;z-index:10;border-top:1px solid black;">
					<script language="JavaScript" type="text/javascript"><!--
						for (var i=0; i<we_tabs.length;i++) {
							we_tabs[i].write();
							document.writeln('<br>');
						}
						<?php
							if (isset($_REQUEST["table"]) && $_REQUEST["table"]){
									print "var defTab = '".$_REQUEST["table"]."';\n";
							}else{
								if ($showDocuments) {
									print "var defTab = '".FILE_TABLE."';\n";
								} else if($showTemplates) {
									print "var defTab = '".TEMPLATES_TABLE."';\n";
								} else if($showObjects) {
									print "var defTab = '".OBJECT_FILES_TABLE."';\n";
								} else if($showClasses) {
									print "var defTab = '".OBJECT_TABLE."';\n";
								} else {
									print "var defTab = '';\n";
								}
							}
						?>
						setTab(defTab);
					//-->
					</script>
		</div>
		<img id="arrowImg" src="<?php print IMAGE_DIR ?>button/icons/direction_<?php print ($_treewidth <= 22) ? "right" : "left"; ?>.gif" width="9" height="12"style="position:absolute;bottom:13px;left:5px;border:1px solid gray;padding:0 1px;cursor: pointer;" onclick="toggleTree();">
	</body>
</html>