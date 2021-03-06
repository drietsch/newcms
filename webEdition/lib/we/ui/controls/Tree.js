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
 * Class for handling we_ui_controls_Tree Element
 * 
 * @category   we
 * @package    we_ui
 * @subpackage we_ui_controls
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/licenses/lgpl-3.0.html  LGPL
 */

function we_ui_controls_Tree(treeId) 
{
	
	/**
	 * id of the element
	 *
	 * @var object
	 */
	this.id = treeId;


	/**
	 * root node of the tree 
	 *
	 */
	this.rootNode = eval("tree_"+this.id+".getRoot();");
	
		
	/**
	 * adds a node
	 *
	 * @param integer id 
	 * @param string text
	 * @param string contentType
	 * @return integer ParentId
	 */
	 
	this.addNode = function(id, text, contentType, parentId) {
	
		text = text.replace(/</g,"&lt;");
		text = text.replace(/>/g,"&gt;");
		
		if(parentId>0) {
			var mParentNode = eval("tree_"+this.id+".getNodeByProperty('id',parentId);");
		}   
		else {
			var mParentNode = this.rootNode;
		}

		if((mParentNode.childrenRendered && mParentNode!="RootNode") || mParentNode=="RootNode") {
			var myobj = { 
					label: "<span title=\""+id+"\" id=\"spanText_"+this.id+"_"+id+"\">"+text+"</span>",
					id: id,
					text: text,
					title: id		
			};
			
			var childNode = new YAHOO.widget.TextNode(myobj, mParentNode, false);
			if(contentType!="folder") {
				childNode.isLeaf = true;	
			}
			childNode.labelStyle = contentType;
			
			eval("tree_"+this.id+"_activEl = childNode.data.id");
	
			eval("tree_"+this.id+".draw();"); 
			
		}
	}
	
	/**
	 * moves a node
	 *
	 * @param integer id 
	 * @param integer newParentId
	 */
	this.moveNode = function(id, newParentId) {

		var mNode = eval("tree_"+this.id+".getNodeByProperty('id',id);");	
						
		eval("tree_"+this.id+".popNode(mNode);");
		
		if(newParentId==0) {
			mNode.appendTo(this.rootNode);
		}
		else {
			var mParentNode = eval("tree_"+this.id+".getNodeByProperty('id',newParentId);");
			if(mParentNode.childrenRendered) {
				mNode.appendTo(mParentNode);
			}
		}
				
		eval("tree_"+this.id+".draw();");      
		
	}

	/**
	 * marks a node
	 *
	 * @param integer id 
	 * @param boolean mark
	 */
	this.markNode = function(id, mark) {

		var mNodeSpan = document.getElementById('spanText_'+this.id+'_'+id+'');

		if(mNodeSpan) {
			if(mark) {
				mNodeSpan.className = "selected";
			}
			else {
				mNodeSpan.className = "";
			}
		}
	}
	
	/**
	 * unmark all nodes
	 *
	 */
	this.unmarkAllNodes = function() {

		var nodes = eval("tree_"+this.id+"._nodes");
		for (var i in nodes) {
            var n = nodes[i];
            this.markNode(n.data.id, false);
        }
	}
	
	/**
	 * renames a node
	 *
	 * @param integer id 
	 * @param string text
	 */
	this.renameNode = function(id, text) {
		
		text = text.replace(/</g,"&lt;");
		text = text.replace(/>/g,"&gt;");
		var mNode = eval("tree_"+this.id+".getNodeByProperty('id',id);");
		mNode.label = "<span title=\""+id+"\" id=\"spanText_"+this.id+"_"+id+"\">"+text+"</span>";
		mNode.text = text;
		var mNodeSpan = document.getElementById('spanText_'+this.id+'_'+id+'');
		mNodeSpan.innerHTML = text;
		
	}

	/**
	 * removes a node
	 *
	 * @param integer id 
	 */
	this.removeNode = function(id) {

		var mNode = eval("tree_"+this.id+".getNodeByProperty('id',id);");
		
		eval("tree_"+this.id+".removeNode(mNode);");
		
		eval("tree_"+this.id+".draw();");  

	}
	
	/**
	 * return the parentId of a node
	 *
	 * @param integer id 
	 */
	this.getParentId = function(id) {

		var mNode = eval("tree_"+this.id+".getNodeByProperty('id',id);");   
		
		var parentNode = mNode.parent;    
		
		var parentId = 0;
		if(parentNode.data) {
			parentId = parentNode.data.id;
		}
		
		return parentId;
		
	}
	
	
	/**
	 * return the label of a node
	 *
	 * @param integer id 
	 */
	this.getLabel = function(id) {

		var mNode = eval("tree_"+this.id+".getNodeByProperty('id',id);");   

		return mNode.data.text;      
		
	}
	
	/**
	 * check if id exists in tree
	 *
	 * @param integer id 
	 * return boolean
	 */
	this.idExists = function(id) {

		var mNode = eval("tree_"+this.id+".getNodeByProperty('id',id);");   

		if(mNode==null) {
			return false;
		}   
		return true; 
		
	}
	
	/**
	 * check if label exists in tree
	 *
	 * @param integer id 
	 * return boolean
	 */
	this.labelExists = function(label) {

		var mNode = eval("tree_"+this.id+".getNodeByProperty('text',label);");   

		if(mNode==null) {
			return false;
		}   
		return true;      
		
	}
}

