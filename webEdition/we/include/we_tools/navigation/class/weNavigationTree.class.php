<?php
/**
 * webEdition CMS
 *
 * LICENSETEXT_CMS
 *
 *
 * @category   webEdition
 * @package    webEdition_base
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/licence     LICENSETEXT_CMS  TODO insert license type and url
 */

include_once ($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_classes/tools/weToolTree.class.php');

class weNavigationTree extends weToolTree
{

	function weNavigationTree($frameset = '', $topFrame = '', $treeFrame = '', $cmdFrame = '')
	{
		parent::weToolTree($frameset, $topFrame, $treeFrame, $cmdFrame);
	}

	function getJSTreeFunctions()
	{
		
		$out = weTree::getJSTreeFunctions();
		
		$out .= '
				function doClick(id,typ){
					var node=' . $this->topFrame . '.get(id);
					' . $this->topFrame . '.resize.right.editor.edbody.we_cmd("tool_navigation_edit",node.id);
				}
				' . $this->topFrame . '.loaded=1;
			';
		return $out;
	
	}

	function getJSTreeCode()
	{
		return parent::getJSTreeCode() . we_htmlElement::jsElement(
				'
 					drawTree.selection_table="' . NAVIGATION_TABLE . '";
 				');
	}

}

?>