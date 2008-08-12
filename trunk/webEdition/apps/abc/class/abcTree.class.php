<?php
					
	include_once($_SERVER['DOCUMENT_ROOT'].'/webEdition/we/include/we_classes/tools/weToolTree.class.php');


	class abcTree extends weToolTree{


		function abcTree($frameset='',$topFrame='',$treeFrame='',$cmdFrame=''){

				weToolTree::weToolTree($frameset,$topFrame,$treeFrame,$cmdFrame);
				$this->setTreeIconDir(WE_TOOLS_PATH . 'abc/layout/icons/');

		}

 		function getJSTreeFunctions(){

			$out=weTree::getJSTreeFunctions();

			$out.='
				function doClick(id,typ){
					var node='.$this->topFrame.'.get(id);

					'.$this->topFrame.'.resize.right.editor.edbody.we_cmd("tool_abc_edit",node.id);

				}
				'.$this->topFrame.'.loaded=1;
			';
			return $out;

		}

		function getJSTreeCode(){

 			return parent::getJSTreeCode() .
 				we_htmlElement::jsElement('
 					drawTree.selection_table="'.''.'";
 				');
 		}
 	
	}
	
		?>