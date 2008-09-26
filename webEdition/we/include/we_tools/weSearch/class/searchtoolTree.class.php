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

include_once ($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_classes/tools/weToolTree.class.php');

class searchtoolTree extends weToolTree
{

	function searchtoolTree($frameset = '', $topFrame = '', $treeFrame = '', $cmdFrame = '')
	{
		
		weToolTree::weToolTree($frameset, $topFrame, $treeFrame, $cmdFrame);
		$this->setTreeIconDir('/webEdition/we/include/we_tools/weSearch/layout/icons/');
	
	}

	function getJSTreeFunctions()
	{
		
		$out = weTree::getJSTreeFunctions();
		
		$out .= '
				function doClick(id,typ){
					var node=' . $this->topFrame . '.get(id);

					' . $this->topFrame . '.resize.right.editor.edbody.we_cmd("tool_weSearch_edit",node.id);

				}
				' . $this->topFrame . '.loaded=1;
			';
		return $out;
	
	}

	function getJSTreeCode()
	{
		
		return parent::getJSTreeCode() . we_htmlElement::jsElement(
				'
 					drawTree.selection_table="' . SUCHE_TABLE . '";
 				');
	}

}

?>