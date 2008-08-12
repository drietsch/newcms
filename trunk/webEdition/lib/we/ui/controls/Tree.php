<?php


/* webEdition SDK
 *
 * LICENSE_TEXT
 *
 * TODO insert license text
 *
 * @category   we
 * @package    we_ui
 * @subpackage we_ui_controls
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/licence     LICENCE_TYPE  TODO insert license type and url
 * @version    $Id: Tree.php,v 1.20 2008/07/25 14:36:25 thomas.kneip Exp $
 */

/**
 * @see we_ui_abstract_AbstractElement
 */
Zend_Loader::loadClass('we_ui_abstract_AbstractElement');

/**
 * Class to display a YUI tree
 * 
 * @category   we
 * @package    we_ui
 * @subpackage we_ui_controls
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/license     LICENSE_TYPE  TODO insert license type and url
 */
class we_ui_controls_Tree extends we_ui_abstract_AbstractElement
{
	
	protected $_nodes = array();
	
	protected $_openNodes = array();
	
	protected $_sessionName = '';
		
	public function getOpenNodes() 
	{
		return $this->_openNodes;	
	}
	
	public function setOpenNodes($_openNodes)
	{
		$this->_openNodes = $_openNodes;
	}
	
	public function getNodes() 
	{
		return $this->_nodes;	
	}
	
	public function setNodes($_nodes)
	{
		$this->_nodes = $_nodes;
	}
		
	protected $_table = '';
	
	
	public function getTable() 
	{
		return $this->_table;	
	}
	
	public function setTable($_table)
	{
		$this->_table = $_table;
	}
	
	/**
	 * Constructor
	 * 
	 * Sets object propeties if set in $properties array
	 * 
	 * @param array $properties associative array containing named object properties
	 * @return void
	 */
	public function __construct($properties = null) 
	{
		parent::__construct($properties);
		
		// add needed CSS files
		$this->addCSSFile(we_ui_layout_Themes::computeCSSURL(__CLASS__));
		
		// add needed JS Files
		$this->addJSFile(we_ui_controls_Tree::computeJSURL(__CLASS__));
		
		// add needed JS Files
		$this->addJSFile($GLOBALS['__WE_BASE_URL__'] . '/js/libs/yui/yahoo-min.js');
		$this->addJSFile($GLOBALS['__WE_BASE_URL__'] . '/js/libs/yui/event-min.js');
		$this->addJSFile($GLOBALS['__WE_BASE_URL__'] . '/js/libs/yui/connection-min.js');
		$this->addJSFile($GLOBALS['__WE_BASE_URL__'] . '/js/libs/yui/json-min.js');
		$this->addJSFile('/webEdition/lib/we/core/JsonRpc.js');
		$this->addJSFile($GLOBALS['__WE_BASE_URL__'] . '/js/libs/yui/treeview/treeview-min.js');

	}
	
	public static function doSelect($_table, $parentID = 0, $start = 0, $anzahl = 0)
	{
		$db = we_io_DB::sharedAdapter();
		
		$table = $_table;
		$limit = ($start===0 && $anzahl===0) ? '' : (is_numeric($start)&& is_numeric($anzahl)) ? 'limit '.abs($start).','.abs($anzahl).'' : '';
		$query = "SELECT " . addslashes($table) . ".*,LOWER(Text) AS lowtext, abs(Text) as Nr, (Text REGEXP '^[0-9]') as isNr FROM `".addslashes($table)."` WHERE ParentID='$parentID' ORDER BY IsFolder DESC, isNr DESC,Nr ,lowtext , Text $limit ";
		$nodes = $db->fetchAll($query);
		
		return $nodes;
	}
	
	public static function doCustom()
	{
		$controller = Zend_Controller_Front::getInstance();
		$appName = $controller->getParam('appName');
		
		if(isset($_SESSION['apps']['customData'])) {
			unset($_SESSION['apps']['customData']);
		}
		
		$_SESSION['apps']['customData'][] = 
			array(
	            'ID' => 'customId1',
		        'ParentID' => 0,
		        'Text' => 'custom 1',
		        'ContentType' => $appName.'/item',
		        'IsFolder' => 0
			)
		;
		
		$_SESSION['apps']['customData'][] = 
			array(
	            'ID' => 'customId2',
		        'ParentID' => 0,
		        'Text' => 'custom 2',
		        'ContentType' => $appName.'/item',
		        'IsFolder' => 0
			)
		;
		
		return $_SESSION['apps']['customData'];
        
	}
		
	public static function getTreeIconClass($contentType, $extension='')  
	{

		return we_ui_layout_Image::getIconClass($contentType, $extension='');
		
	}
	
	public function getNodeObject($id, $text) 
	{
		//$doOnClick = "alert(&quot;".$id."&quot;);";
		 
		$out = 'var myobj = { ';
				$out .= 'label: "<span title=\"'.$id.'\" id=\"spanText_' . $this->_id . '_'.$id.'\">'.$text.'</span>"';
				//$out .= ',';
				//$out .= 'href: "javascript:'.$doOnClick.'"';
				$out .= ',';
				$out .= 'id: "'.$id.'"';
				$out .= ',';
				$out .= 'text: "'.$text.'"';
				$out .= ',';
				$out .= 'title: "'.$id.'"';			
		$out .= '}; ';
		
		return $out;
	}
	
	protected function getNodesJS()  
	{
		
		$out = 'var root = tree_' . $this->_id . '.getRoot();';
		$nodes = $this->getNodes();
		if(!empty($nodes)) {
			foreach ($nodes as $k => $v) {
				$out .= $this->getNodeObject(htmlentities($v['ID'],ENT_QUOTES),htmlentities($v['Text'], ENT_QUOTES));
				$out .= 'var tmpNode = new YAHOO.widget.TextNode(myobj, root, false);';
				$out .= 'tmpNode.labelStyle = "'.$this->getTreeIconClass($v['ContentType']).'";';
				if($this->getTreeIconClass($v['ContentType'])!=='folder') {
					$out .= 'tmpNode.isLeaf = true;';	
				}
				$session = new Zend_Session_Namespace($this->_sessionName);					
				if(in_array($v['ID'],$session->openNodes) && $v['IsFolder']) {
					$out .= 'YAHOO.widget.TreeView.getNode(\'' . $this->_id . '\',tmpNode.index).toggle();';
					$out .= 'tmpNode.labelStyle = "'.$this->getTreeIconClass('folderOpen').'";';
				}				
			}
		}
		
		return $out;
	}
	
	
	protected function getDatasource() 
	{
		$controller = Zend_Controller_Front::getInstance();
		$appPath = $controller->getParam('appPath');
		include($appPath.'/conf/meta.conf.php');
		if(substr($metaInfo['datasource'], 0, 6)==='table:' && we_io_DB::tableExists($metaInfo['maintable'])) {
			return 'table';
		}
		elseif(substr($metaInfo['datasource'], 0, 7)==='custom:') {
			return 'custom';
		}
		
		return 'custom';
		
	}
	
	
	protected function setUpData() 
	{
		$this->_sessionName = 'openNodes_'.$this->_id;
		if($this->getDatasource()==='table') {
			$nodes = $this->doSelect($this->getTable());
		}
		elseif($this->getDatasource()==='custom') {
			$nodes = $this->doCustom();
		}
		$this->setNodes($nodes);
	}
	
	protected function _renderHTML() 
	{
		
		$this->setUpData();
		$session = new Zend_Session_Namespace($this->_sessionName);
		if(!isset($session->openNodes)) {
			$session->openNodes = $this->getOpenNodes();
		}

		$js = '
			var tree_' . $this->_id . ' = new YAHOO.widget.TreeView("'.$this->_id.'");
			var tree_' . $this->_id . '_activEl = 0;       

			(function() {

				function tree_' . $this->_id . '_Init() { 
					
					tree_' . $this->_id . '.setDynamicLoad(loadNodeData); 
							
					'.$this->getNodesJS().'
							
					tree_' . $this->_id . '.subscribe("collapse", function(node) { 
						var sUrl = "/webEdition/lib/we/ui/controls/TreeSuggest.php?sessionname=' . $this->_sessionName . '&id=" + node.data.id +  "&close=1";
					    var callback = {
					        success: function(oResponse) {
					        	var _node = document.getElementById(node.labelElId);
								_node.className = "'.$this->getTreeIconClass('folder').'";
					        },
					        failure: function(oResponse) {
					        }
					    };
					    YAHOO.util.Connect.asyncRequest("GET", sUrl, callback);
					}); 
					
					tree_' . $this->_id . '.subscribe("expand", function(node) { 
						var sUrl = "/webEdition/lib/we/ui/controls/TreeSuggest.php?sessionname=' . $this->_sessionName . '&id=" + node.data.id + "&close=0";
					    var callback = {
					        success: function(oResponse) {
								var _node = document.getElementById(node.labelElId);
								_node.className = "'.$this->getTreeIconClass('folderOpen').'";
					        },
					        failure: function(oResponse) {
					        }
					    };
					    YAHOO.util.Connect.asyncRequest("GET", sUrl, callback);
					}); 

					tree_' . $this->_id . '.draw(); 
				}
				
				function loadNodeData(node, fnLoadComplete)  {
				    
					var nodeId = node.data.id;
					var nodeTable = encodeURI("'.$this->getTable().'");
				    var nodeLabel = encodeURI(node.label);
				
				    //prepare URL for XHR request:
				    var sUrl = "/webEdition/lib/we/ui/controls/TreeSuggest.php?treeclass=' . get_class($this) . '&datasource=' . $this->getDatasource() . '&sessionname=' . $this->_sessionName . '&id=" + nodeId + "&table=" + nodeTable;
				    
				    //prepare our callback object
				    var callback = {
				    
				        //if our XHR call is successful, we want to make use
				        //of the returned data and create child nodes.
				        success: function(oResponse) {
				            YAHOO.log("XHR transaction was successful.", "info", "example");
				          //console.log(oResponse.responseText);
				            var oResults = eval("(" + oResponse.responseText + ")");
				            if((oResults.ResultSet.Result) && (oResults.ResultSet.Result.length)) {
				                //Result is an array if more than one result, string otherwise
				                if(YAHOO.lang.isArray(oResults.ResultSet.Result)) {
				                    for (var i=0, j=oResults.ResultSet.Result.length; i<j; i++) {
				                    	'.$this->getNodeObject('"+oResults.ResultSet.Id[i]+"','"+oResults.ResultSet.Result[i]+"').'
				                    	var tmpNode = new YAHOO.widget.TextNode(myobj, node, oResults.ResultSet.open[i]);
				                    	tmpNode.labelStyle = oResults.ResultSet.LabelStyle[i];                  
				                    	if(tmpNode.labelStyle!=="folder") {
				                    		tmpNode.isLeaf = true;
				                    	}
				                    	if(oResults.ResultSet.open[i]) {
				                    		tmpNode.labelStyle = "folderOpen";
				                    	}
				                    }
				                } else {
				                    //there is only one result; comes as string:
									'.$this->getNodeObject('"+oResults.ResultSet.Id+"','"+oResults.ResultSet.Result+"').'
				                    var tmpNode = new YAHOO.widget.TextNode(myobj, node, false);
				                    tmpNode.labelStyle = oResults.ResultSet.LabelStyle;
				                    if(tmpNode.labelStyle!=="folder") {
				                    	tmpNode.isLeaf = true;
				                    }
				                    if(oResults.ResultSet.open) {
				                    	tmpNode.labelStyle = "folderOpen";
				                    }
				                }
				            }
				            oResponse.argument.fnLoadComplete();
				        },
				        
				        failure: function(oResponse) {
				            YAHOO.log("Failed to process XHR transaction.", "info", "example");
				            oResponse.argument.fnLoadComplete();
				        },
				        
				        argument: {
				            "node": node,
				            "fnLoadComplete": fnLoadComplete
				        },
				        
				        timeout: 7000
				    };
				    
				    YAHOO.util.Connect.asyncRequest("GET", sUrl, callback);
				}

				YAHOO.util.Event.addListener(window, "load", tree_' . $this->_id . '_Init); 

			})();
		';
		
		$page = we_ui_layout_HTMLPage::getInstance();
		$page->addInlineJS($js);
		
		return '<div id="'.htmlspecialchars($this->_id).'"></div>';
	}
	
}
