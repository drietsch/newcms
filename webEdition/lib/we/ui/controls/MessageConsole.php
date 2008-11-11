<?php
/**
 * webEdition SDK
 *
 * This source is part of the webEdition SDK. The webEdition SDK is
 * free software; you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License
 * the Free Software Foundation; either version 3 of the License, or
 * any later version.
 *
 * The GNU Lesser General Public License can be found at
 * http://www.gnu.org/licenses/lgpl-3.0.html.
 * A copy is found in the textfile 
 * webEdition/licenses/webEditionSDK/License.txt
 *
 *
 * @category   we
 * @package    we_ui
 * @subpackage we_ui_controls
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/licenses/lgpl-3.0.html  LGPL
 */

/**
 * @see we_ui_abstract_AbstractElement
 */
Zend_Loader::loadClass('we_ui_abstract_AbstractElement');

/**
 * Class to display the message console button.
 * 
 * @category   we
 * @package    we_ui
 * @subpackage we_ui_controls
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/licenses/lgpl-3.0.html  LGPL
 */
class we_ui_controls_MessageConsole extends we_ui_abstract_AbstractElement
{

	/**
	 * class for HeaderFont
	 */
	const kHeaderFontClass = 'we_ui_controls_MessageConsoleHeaderText';

	/**
	 * class for HeaderIconNormalClass
	 */
	const kHeaderIconNormalClass = 'we_ui_controls_MessageConsoleHeaderIconNormal';

	/**
	 * class for HeaderIconOverClass
	 */
	const kHeaderIconOverClass = 'we_ui_controls_MessageConsoleHeaderIconOver';

	/*
	 * Name of Console
	 * 
	 * @var string;
	 */
	protected $_consoleName = "NoName";

	/**
	 * Constructor
	 * 
	 * Sets object properties if set in $properties array
	 * 
	 * @param array $properties associative array containing named object properties
	 * @return void
	 */
	public function __construct($properties = null)
	{
		parent::__construct($properties);
		
		// add needed JS Files
		$this->addJSFile($GLOBALS['__WE_BASE_URL__'] . '/js/messageConsoleImages.js');
		$this->addJSFile($GLOBALS['__WE_BASE_URL__'] . '/js/messageConsoleView.js');
		
		// add needed CSS Files
		$this->addCSSFile(we_ui_layout_Themes::computeCSSURL(__CLASS__));
	
	}

	/**
	 * Renders and returns HTML of MessageConsole
	 *
	 * @return string
	 */
	protected function _renderHTML()
	{
		$translate = we_core_Local::addTranslation('messageConsole.xml');
		
		$page = we_ui_layout_HTMLPage::getInstance();
		
		$noticeText = str_replace('"', '\"', $translate->_('New notice'));
		$warningText = str_replace('"', '\"', $translate->_('New warning'));
		$errorText = str_replace('"', '\"', $translate->_('New error'));
		
		$js = <<<EOS
		
var _msgNotice  = "$noticeText";
var _msgWarning = "$warningText";
var _msgError   = "$errorText";


var _console_$this->_consoleName = new messageConsoleView( '$this->_consoleName', window );
_console_$this->_consoleName.register();

onunload=function() {
	_console_$this->_consoleName.unregister();
}

EOS;
		$page->addInlineJS($js);
		
		$headerClass = self::kHeaderFontClass;
		$iconClassNormal = self::kHeaderIconNormalClass;
		$iconClassOver = self::kHeaderIconOverClass;
		
		$imgPath = $GLOBALS['__WE_BASE_URL__'] . '/images/messageConsole/notice.gif';
		return <<<EOHTML

<div>
	<table>
	<tr>
		<td valign="middle">
		<span class="$headerClass" id="messageConsoleMessage$this->_consoleName" style="display: none;">
			--
		</span>
		</td>
		<td>
			<div onclick="_console_$this->_consoleName.openMessageConsole();" class="$iconClassNormal" onmouseover="this.className=&quot;$iconClassOver&quot;" onmouseout="this.className=&quot;$iconClassNormal&quot;"><img id="messageConsoleImage$this->_consoleName" src="$imgPath" /></div>
		</td>
	</tr>
	</table>
</div>
EOHTML;
	}

	/**
	 * @return unknown
	 */
	public function getConsoleName()
	{
		return $this->_consoleName;
	}

	/**
	 * @param unknown_type $consoleName
	 */
	public function setConsoleName($consoleName)
	{
		$this->_consoleName = $consoleName;
	}

}

?>