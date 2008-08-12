<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//


	include_once($_SERVER['DOCUMENT_ROOT'].'/webEdition/we/include/we_classes/tools/weToolTree.class.php');


	class weNavigationTree extends weToolTree {


		function weNavigationTree($frameset='',$topFrame='',$treeFrame='',$cmdFrame=''){
				parent::weToolTree($frameset,$topFrame,$treeFrame,$cmdFrame);
		}

		function getJSTreeFunctions(){

			$out=weTree::getJSTreeFunctions();

			$out.='
				function doClick(id,typ){
					var node='.$this->topFrame.'.get(id);
					'.$this->topFrame.'.resize.right.editor.edbody.we_cmd("tool_navigation_edit",node.id);
				}
				'.$this->topFrame.'.loaded=1;
			';
			return $out;

		}


 		function getJSTreeCode(){
 			return parent::getJSTreeCode() .
 				we_htmlElement::jsElement('
 					drawTree.selection_table="'.NAVIGATION_TABLE.'";
 				');
 		}

}

?>