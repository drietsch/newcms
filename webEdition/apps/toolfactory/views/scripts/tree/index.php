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

$controller = Zend_Controller_Front::getInstance();
$appName = $controller->getParam('appName');

$page = we_ui_layout_HTMLPage::getInstance();

$page->addJSFile('/webEdition/js/windows.js');
$page->addJSFile('/webEdition/js/we_showMessage.js');
$page->addJSFile('/webEdition/js/images.js');

$nodes = array();

$TreeDiv = new we_ui_layout_Div();
$TreeDiv->setId('TreeDiv');
$TreeDiv->setStyle('margin:5px 0px 0px 5px;overflow:auto;');

$tree = new toolfactory_ui_controls_Tree();
$tree->setId('tree_toolfactory');

$InfoField = new we_ui_layout_Div();
$InfoField->setId('infoField');
$InfoField->setStyle('position:absolute;bottom:0px;height:40px;background:url(/webEdition/images/edit/editfooterback.gif);left:0px;width:100%;margin:0px;');

$InfoFieldId = new we_ui_layout_Div();
$InfoFieldId->setId('infoFieldId');
$InfoFieldId->setStyle('margin:5px 10px;font-size:11px;');

$js = '
	var weTree = new we_ui_controls_Tree("' . $tree->getId() . '");
	
	YAHOO.util.Event.addListener(window, "load", function() {
		tree_' . $tree->getId() . '.subscribe("labelClick", function(node) { 
			weTree.unmarkAllNodes();
			weTree.markNode(node.data.id, true);
			tree_' . $tree->getId() . '_activEl = node.data.id;

			weCmdController.fire({cmdName:"app_'.$appName.'_open", id:node.data.id}); 
			
			return false;
		});
	});
	
	YAHOO.util.Event.addListener("'.$TreeDiv->getId().'", "mouseover", function(e) {
		var elTarget = YAHOO.util.Event.getTarget(e);    
	    var a = "ygtvlabelel";
	    var span = "spanText_' . $tree->getId() . '_";
        if(a == elTarget.id.substring(0, a.length) || span == elTarget.id.substring(0, span.length)) { 
        	var node = tree_' . $tree->getId() . '.getNodeByProperty(\'title\',elTarget.title);
        	if(node!=null) {
            	showInfoId(node.data.text);
            }
        } else { 
            showInfoId("");
        } 
	});
	

	
	function showInfoId(text) {
		var field = document.getElementById("'.$InfoFieldId->getId().'");
		if(text!=""){
			field.style.display="block";
			field.innerHTML = "ID:"+text;
		} 
		else {
			field.style.display="none";
			field.innerHTML = "";
		}
 	}
 	
 	weGetTop().onload = resizeTreeDiv;
 	weGetTop().onresize = resizeTreeDiv;
 	
 	function resizeTreeDiv(){
 		var h = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight;
		document.getElementById(\''.$TreeDiv->getId().'\').style.height = eval(h-50)+"px";
	}

	weEventController.register("delete", function(data, sender) {
		if (data.model.ID) {
			weTree.removeNode(data.model.ID);
		}
	
	});
	
	weEventController.register("save", function(data, sender) {
		if (data.model.ID) {
			if (data.newBeforeSaving) {
				if (data.model.IsFolder) {
					weTree.addNode(data.model.ID, data.model.Text, "folder", data.model.ParentID);
				} else {
					weTree.addNode(data.model.ID, data.model.Text, "' . $tree->getTreeIconClass($appName.'/item') . '", data.model.ParentID);
				}
			} else {
				var newParentId = data.model.ParentID;
				var oldParentId = weTree.getParentId(data.model.ID);
	
				var newLabel = data.model.Text;
				var oldLabel = weTree.getLabel(data.model.ID);
				
				if (newParentId != oldParentId) {
					weTree.moveNode(data.model.ID, newParentId);
				}
				
				if (newLabel != oldLabel) {
					weTree.renameNode(data.model.ID, newLabel);
				}
			}
			
		}
	});
';

$TreeDiv->addElement($tree);
$page->addElement($TreeDiv);
$page->addInlineJS($js);

$InfoField->addElement($InfoFieldId);
$page->addElement($InfoField);

echo $page->getHTML();