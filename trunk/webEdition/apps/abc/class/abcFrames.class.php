<?php
					
include_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we.inc.php');

include_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_classes/tools/weToolFrames.class.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_classes/html/we_forms.inc.php');

include_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/apps/abc/language/language_' . $GLOBALS['WE_LANGUAGE'] . '.inc.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/apps/abc/class/abcView.class.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/apps/abc/class/abcTree.class.php');

class abcFrames extends weToolFrames {

	function abcFrames() {
		$this->toolName = 'abc';
		$this->toolClassName = 'abc';
		$this->toolUrl = '/webEdition/apps/' . $this->toolName . '/';
		$this->toolDir = $_SERVER['DOCUMENT_ROOT'] . $this->toolUrl;
		
		$_frameset = $this->toolUrl . 'edit_' . $this->toolName . '_frameset.php';
		$this->weModuleFrames($_frameset);
		$this->Table = '';
		
				$this->TreeSource = 'custom::';
				
		$this->Tree=new abcTree();
		$this->View = new abcView($_frameset,'top.content');
		$this->Model = &$this->View->Model;
		$this->setupTree('','top.content','top.content.resize.left.tree','top.content.cmd');
		
	}

}
		?>