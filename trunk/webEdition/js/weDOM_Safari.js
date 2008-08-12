function weDOM(window) {
	this.window = window;
	this.document = window.document;
	this.selection = null;
	this.range = null;
	this.selectedNode = null;
	this.resetSelectionBackup();
}

weDOM.prototype.updateSelection = function() {
	this.selection = this.window.getSelection();
	// if there is no selection but there is a saved selection => restore selection
	if ((!(this.selection && this.selection.baseNode && this.selection.extentNode)) && (this.baseNodeBackup != null)) {
		this.selection.setBaseAndExtent(this.baseNodeBackup, this.baseOffsetBackup, this.extentNodeBackup, this.extentOffsetBackup);
	} else if (this.selection) {
		this.baseNodeBackup = this.selection.baseNode;
		this.baseOffsetBackup = this.selection.baseOffset;
		this.extentNodeBackup = this.selection.extentNode;
		this.extentOffsetBackup = this.selection.extentOffset;
	}
}

weDOM.prototype.setSelectionBackup = function(baseNode, baseOffset, extentNode, extentOffset) {
	this.baseNodeBackup = baseNode;
	this.baseOffsetBackup = baseOffset;
	this.extentNodeBackup = extentNode;
	this.extentOffsetBackup = extentOffset;
}

weDOM.prototype.resetSelectionBackup = function() {
	this.baseNodeBackup = null;
	this.baseOffsetBackup = 0;
	this.extentNodeBackup = null;
	this.extentOffsetBackup = 0;
}

weDOM.prototype.updateRange = function() {
	this.range = this.getRange();
}

weDOM.prototype.getRange = function() {
	var foo;
	var baseNode     = null;
	var baseOffset   = 0;
	var extentNode   = null;
	var extentOffset = 0;



	// get the normal selection
	this.updateSelection();
	if (this.selection && this.selection.baseNode && this.selection.extentNode) {
		// check if selection is reversed
		var reverse = false;

		if (	(this.selection.baseNode == this.selection.extentNode) &&
				(this.selection.baseOffset > this.selection.extentOffset)
			) {
			reverse = true;
		} else {
			var anchestor = this.getCommonAncestorContainer();
			var nd = this.findNextNode(anchestor, this.selection.extentNode, false);
			while (nd) {
				if (nd == this.selection.baseNode) {
					reverse = true;
					break;
				}
				nd = this.findNextNode(anchestor, nd, false);
			}
		}

		baseNode = reverse ? this.selection.extentNode : this.selection.baseNode;
		baseOffset = reverse ? this.selection.extentOffset : this.selection.baseOffset;
		extentNode = reverse ? this.selection.baseNode : this.selection.extentNode;
		extentOffset = reverse ? this.selection.baseOffset : this.selection.extentOffset;


		// #############  Safari Bug when selection with doubleclick, offsets are not correct => correct it #############
		var selTxt = (""+this.selection);


		if (	(this.selection.type == 'Range') &&
				(selTxt.length > 0) &&
				(baseNode.nodeType == weDOM.TEXT_NODE) &&
				(baseOffset == baseNode.nodeValue.length) &&
				(baseNode.parentNode.nextSibling != null) &&
				(baseNode.parentNode.nextSibling.nodeType == weDOM.TEXT_NODE) &&
				(baseNode.parentNode.nextSibling.nodeValue.substring(0,selTxt.length) == selTxt)
			)  {
			baseNode = baseNode.parentNode.nextSibling;
			baseOffset = 0;
			extentNode = baseNode;
			extentOffset = selTxt.length;
		} else if (	(this.selection.type == 'Range') &&
				(baseNode == extentNode) &&
				(baseOffset == extentOffset) &&
				(baseNode.nodeType == weDOM.TEXT_NODE)
			){
			var sel = "" +this.selection;
			var ind = baseNode.nodeValue.lastIndexOf(sel,baseOffset);
			if (ind > -1 ) {
				baseOffset = ind;
				extentOffset = baseOffset + sel.length;
			} else {
				var nn = this.findNextNode(this.document.body,baseNode);
				while (nn && (nn.nodeType != weDOM.TEXT_NODE) && nn.nodeValue != sel) {
					nn = this.findNextNode(this.document.body,nn);
				}
				if (nn) {
					baseNode = nn;
					baseOffset = 0;
					extentNode = baseNode;
					extentOffset = baseOffset + sel.length;
				}
			}
		} else if (	(this.selection.type == 'Range') &&
					(baseNode.nodeType == weDOM.TEXT_NODE) &&
					(baseNode.nodeValue.length == baseOffset) &&
					(extentNode.nodeType == weDOM.TEXT_NODE) &&
					(extentNode.nodeValue.length == extentOffset)
				) {
			baseNode = extentNode;
			baseOffset = 0;
		} else if (	(baseNode.nodeType == weDOM.TEXT_NODE) &&
					(baseNode.nodeValue.length == baseOffset) &&
					(extentNode.nodeType != weDOM.TEXT_NODE) &&
					(extentNode==baseNode.nextSibling)
				) {
			baseNode = extentNode;
			baseOffset = 0;
			extentOffset = 1;
		}


		// ######### end of Safari correcttion #################

		// create an empty dom range
		var range = this.document.createRange();

		if (range) {
			if (this.selection.type == 'Caret') {
				try {
					range.setStart(baseNode,baseOffset);
					range.setEnd(extentNode,extentOffset);
				} catch(e) {
					try {
						range.setStart(baseNode,baseOffset);
						range.setEnd(baseNode,baseOffset);
					} catch(e) {
						try {
							range.setStart(extentNode,extentOffset);
							range.setEnd(extentNode,extentOffset);
						} catch(e) {
							try {
								range.setStartBefore(baseNode);
								range.setEndAfter(baseNode);
							} catch(e) {
								return false;
							}
						}
					}
				}
			} else if (this.selection.type == 'Range') {
				try {
					if (baseNode.nodeType == weDOM.TEXT_NODE) {
						range.setStart(baseNode,baseOffset);
					} else {
						range.setStartBefore(baseNode);
					}
					if (extentNode.nodeType == weDOM.TEXT_NODE) {
						range.setEnd(extentNode,extentOffset);
					} else {
						range.setEndAfter(extentNode);
					}
				} catch(e) {
					try {
						range.setStart(baseNode,baseOffset);
						range.setEnd(baseNode,baseOffset);
					} catch(e) {
						try {
							range.setStart(extentNode,extentOffset);
							range.setEnd(extentNode,extentOffset);
						} catch(e) {
							return false;
						}
					}
				}
			}

			return range;
		}
	}
	return null;
}

weDOM.prototype.getSelectedChildren = function(childsName) {
	childsName = childsName.toLowerCase();
	var obj = new Object();
	obj.parent = null;
	obj.selectedChilds = null;
	obj.firstSelected = this.range.startContainer;
	obj.lastSelected = this.range.endContainer;
	obj.firstIndex = -1;
	obj.lastIndex = -1;
	obj.firstChild = null;
	obj.lastChild = null;
	while (obj.firstSelected != null && obj.firstSelected.nodeName.toLowerCase() != childsName) {
		obj.firstSelected = obj.firstSelected.parentNode;
	}
	while (obj.lastSelected != null && obj.lastSelected.nodeName.toLowerCase() != childsName) {
		obj.lastSelected = obj.lastSelected.parentNode;
	}

	if (obj.lastSelected != null && obj.firstSelected != null) {
		obj.parent = (obj.firstSelected.parentNode == obj.lastSelected.parentNode) ? obj.lastSelected.parentNode : null;
		obj.selectedChilds = new Array();
		if (obj.parent != null) {
			for (var i=0; i<obj.parent.childNodes.length; i++) {
				if (obj.parent.childNodes[i].nodeName.toLowerCase() == childsName) {
					if (obj.parent.childNodes[i] == obj.firstSelected) {
						obj.firstIndex = i;
					}
					if (obj.firstIndex > -1) {
						obj.selectedChilds.push(obj.parent.childNodes[i]);
					}
					if (obj.parent.childNodes[i] == obj.lastSelected) {
						obj.lastIndex = i;
						break;
					}
				}
			}
			obj.firstChild = obj.parent.firstChild;
			while (obj.firstChild && obj.firstChild.nodeName.toLowerCase() != childsName) {
				obj.firstChild = obj.firstChild.nextSibling;
			}
			obj.lastChild = obj.parent.lastChild;
			while (obj.lastChild && obj.lastChild.nodeName.toLowerCase() != childsName) {
				obj.lastChild = obj.lastChild.previousSibling;
			}
		}
	}

	return obj;
}

weDOM.prototype.createTextNode = function(txt) {
	return this.document.createTextNode(txt)
}

weDOM.prototype.insertText = function(text) {
	this.insertNode(this.createTextNode(text));
}

weDOM.prototype.insertHTML = function(html) {
	var buffer = this.createElement("DIV");
	buffer.innerHTML = html;
	var bufferRange = document.createRange();
	bufferRange.selectNodeContents(buffer);
	var elem =bufferRange.extractContents();
	this.insertNode(elem);
}

weDOM.copyAttributes = function(from,to){
	var attr = from.attributes;
	for(var i=0;i< attr.length;i++){
		if(attr[i].specified){
			to.setAttribute(attr[i].nodeName,attr[i].nodeValue);
		}
	}
}

weDOM.prototype.insertNode = function(node) {
	var outNode = node;

	this.updateRange();
	if (!this.range.collapsed) {
		this.range.extractContents();
	}
	var pos = this.range.startOffset;
	var container = this.range.startContainer;
	// insert text in a textnode => do optimized insertion
	if ((container.nodeType == weDOM.TEXT_NODE) && (node.nodeType == weDOM.TEXT_NODE)) {
		container.insertData(pos, node.nodeValue);
		// select Node
		this.selection.setBaseAndExtent(container, pos, container, pos+node.length);
		return node;
	} else {
		// when inserting non text into a textnode
		if (container.nodeType == weDOM.TEXT_NODE) {
			// create 2 new textnodes
			// and put the node between
			var textNode = container;
			container = textNode.parentNode;
			var text = textNode.nodeValue;

			// text before the split
			var textBefore = text.substr(0,pos);
			// text after the split
			var textAfter = text.substr(pos);

			if (! textAfter) {
				if (textNode.nextSibling) {
					container.insertBefore(node, textNode.nextSibling);
				} else {
					container.appendChild(node);
				}
			} else {
				var beforeNode = this.createTextNode(textBefore);
				var afterNode = this.createTextNode(textAfter);
				container.insertBefore(beforeNode, textNode);
				container.insertBefore(node, textNode);
				textNode.nodeValue = afterNode.nodeValue;
			}

			outNode = node;
		} else {
			// insert the node
			this.updateRange();
			afterNode = this.range.startContainer.nextSibling;
			if (afterNode != null) {
				this.range.startContainer.parentNode.insertBefore(node, afterNode);
				outNode = node;
			} else {
				try {
					if (	(container.nodeName.toLowerCase() != "br") &&
							(container.nodeName.toLowerCase() != "hr") &&
							(container.nodeName.toLowerCase() != "img")
						) {
						container.appendChild(node);
						outNode = node;
					} else {
						container.parentNode.insertBefore(node, container);
					}
				} catch(e) {
					var parentNode = container.parentNode;
					parentNode.replaceChild(node, container);
					outNode = node;
				}
			}
		}
	}
	if (outNode.nodeType != weDOM.DOCUMENT_FRAGMENT_NODE) {
		this.selectNode(outNode);
	}
	return outNode;
}

weDOM.prototype.surroundNode = function(insertNode, removeInChildren) {

	this.updateRange();
	// if selection is a range and not a caret (use the corrected range object to determine)
	if (!(this.range.startContainer = this.range.endContainer && this.range.startOffset == this.range.endOffset)) {
		insertNode.appendChild(this.range.extractContents());
		if (removeInChildren) {
			var regex = new RegExp("</?"+insertNode.nodeName+"[^>]*>","gi");
			insertNode.innerHTML = insertNode.innerHTML.replace(regex,"");
		}
		this.range.insertNode(insertNode);
		this.selectNode(insertNode);
	}
	return;
}

weDOM.prototype.setCaret = function(node,offset) {
	this.selection.setBaseAndExtent(node, offset, node, offset);
}

weDOM.prototype.selectNode = function(startNode, endNode, startOffset, endOffset) {

	this.selectedNode = startNode.nodeName;

	if (endNode) {
		this.selection.setBaseAndExtent(startNode, startOffset, endNode, endOffset);
	} else {
		if (startNode.childNodes && startNode.childNodes.length) {
			this.selection.setBaseAndExtent(startNode, 0, startNode, 0);
		} else {
			for (var i=0; i<startNode.parentNode.childNodes.length; i++) {
				if (startNode == startNode.parentNode.childNodes[i]) {
					this.selection.setBaseAndExtent(startNode.parentNode, i, startNode.parentNode, i+1);
				}
			}
		}
	}
}


weDOM.prototype.getImageFromSelection = function(updateRange) {
	if (updateRange) this.updateRange();
	if (this.range.startContainer == this.range.endContainer && this.range.startContainer.nodeName.toLowerCase() == "img") {
		return this.range.startContainer;
	} else if (	this.range.startContainer.childNodes &&
				this.range.startContainer.childNodes.length &&
				this.range.startContainer.childNodes.length - 1 >= this.range.startOffset &&
				this.range.startContainer.childNodes[this.range.startOffset].nodeName.toLowerCase() == "img") {
					return this.range.startContainer.childNodes[this.range.startOffset];
	}
	return null;
}

weDOM.prototype.getRuleFromSelection = function(updateRange) {
	if (updateRange) this.updateRange();

	if (this.range.startContainer == this.range.endContainer && this.range.startContainer.nodeName.toLowerCase() == "hr") {
		return this.range.startContainer;
	} else {
		var frag = this.range.cloneContents();
		var childnode = (frag && frag.firstChild) ? frag.firstChild : false;
		while (childnode) {
			if (childnode.nodeName.toLowerCase() == "hr") {
				return childnode;
			}
			childnode = childnode.nextSibling;
		}

	}
	return null;
}

weDOM.prototype.getParentNodeFromSelection = function() {

	var startnode;
	var endnode;

	this.updateRange();
	if (this.range) {
		if (this.range.commonAncestorContainer.nodeName.toLowerCase() == '#text') {
			return this.range.commonAncestorContainer.parentNode;
		} else {
			// Safari td selection endContainer is maybe at start of next Container => correct it
			if (	(this.range.endOffset == 0) &&
					(this.range.endContainer.nodeName.toLowerCase() == '#text') &&
					(this.range.endContainer.parentNode.nodeName.toLowerCase() == "td")
				) {
				startnode=this.range.startContainer;
				while (startnode && (startnode.nodeName.toLowerCase() != "body")) {
					endnode=this.range.endContainer.parentNode.previousSibling;
					while (endnode && (endnode.nodeName.toLowerCase() != "body")) {
						if (startnode == endnode) {
							return startnode;
						}
						endnode=endnode.parentNode;
					}
					startnode=startnode.parentNode;
				}
			}
			return this.range.commonAncestorContainer;
		}
	}
}


weDOM.prototype.getLangSpan = function(){
	var obj = this.getParentNodeFromSelection();
	while (obj && (weDOM.inlineTags.indexOf(" "+obj.nodeName.toLowerCase()+" ") > -1) ){
		if(obj.nodeName.toLowerCase() == "span" && obj.lang){
			return obj;
		}
		obj = obj.parentNode;
	}
	return null;
}

weDOM.prototype.getCommonAncestorContainer = function() {
	this.updateSelection();
	var nodes = new Array();
	var baseNode = this.selection.baseNode ? this.selection.baseNode : this.baseNodeBackup;
	var extentNode = this.selection.extentNode ? this.selection.extentNode : this.extentNodeBackup;

	while (baseNode != null && baseNode.nodeName.toLowerCase() != "body") {
		nodes.push(baseNode.parentNode);
		baseNode=baseNode.parentNode;
	}

	while (extentNode != null && extentNode.nodeName.toLowerCase() != "body") {
		for (var i=0; i<nodes.length; i++) {
			if (extentNode.parentNode == nodes[i]) {
				return extentNode.parentNode;
			}
		}
		extentNode=extentNode.parentNode;
	}

	return null;
}

weDOM.prototype.getLastSurroundNode = function(updateRange) {
	if (updateRange) this.updateRange();
	if (	this.range &&
			this.range.startContainer.parentNode ==  this.range.endContainer.parentNode &&
			this.range.startContainer == this.range.startContainer.parentNode.firstChild &&
			this.range.startOffset == 0 &&
			this.range.endContainer == this.range.endContainer.parentNode.lastChild &&
			(this.range.endOffset == (this.range.endContainer.nodeType == weDOM.TEXT_NODE) ? this.range.endContainer.length :  1)
	) {
		var node = this.range.startContainer.parentNode;
		while (node.parentNode && node.parentNode.firstChild == node.parentNode.lastChild) {
			node = node.parentNode;
		}
		return node;
	}
	return null;
}

weDOM.prototype.findNextNode = function(root, node, noChildren) {
	var cnode = node;
	if (node && node.firstChild && (! noChildren)) {
		return node.firstChild;
	} else {
		while (node && (node != root) && (! node.nextSibling)) {
			node = node.parentNode;
		}
		if (node && (node != root)) {
			// IE Fix
			if (node.nextSibling == cnode) {
				return false;
			}
			return node.nextSibling;
		} else {
			return false;
		}
	}
}

weDOM.prototype.findPreviousNode = function(root, node) {
	if (root == node) {
		while (node && node.lastChild) {
			node = node.lastChild;
		}
	} else if (node) {
		if (node.previousSibling) {
			node = node.previousSibling;
			while (node && node.lastChild) {
				node = node.lastChild;
			}
		} else {
			node = node.parentNode;
		}
	}
	if (node && (node != root)) {
		return node;
	} else {
		return false;
	}
}

weDOM.prototype.getHTMLCode = function(rootNode, outputRootNode){
	var isIE = navigator.userAgent.toLowerCase().indexOf("MSIE") > -1;
	var html = "";
	if (rootNode == null) {
		return '';
	}
	switch (rootNode.nodeType) {
	    case weDOM.DOCUMENT_FRAGMENT_NODE: // document fragment
			var nodeHTML = '';
			var childnode = rootNode.firstChild;
			while (childnode) {
				nodeHTML += this.getHTMLCode(childnode,true);
				childnode = childnode.nextSibling;
			}
			return nodeHTML;
	    case weDOM.ELEMENT_NODE: // element
			var closed;
			var i;
			var root_tag = (rootNode.nodeType == weDOM.ELEMENT_NODE) ? rootNode.nodeName.toLowerCase() : '';

			if(root_tag == "pre"){
				this.pre = true;
			}
			if(this.pre && root_tag == "br"){
				html += "\n";
				break;
			}
			if (outputRootNode) {
				closed = (!(rootNode.hasChildNodes() || (weDOM.emptyTags.indexOf(" " + root_tag + " ") == -1)));
				html += "<" + rootNode.nodeName.toLowerCase();
				var attrs = rootNode.attributes;
				for(i = 0; i < attrs.length; ++i){
					var a = attrs.item(i);
					var name=a.nodeName.toLowerCase();
					if(root_tag == "area" && a.nodeValue){
						// do nothing
					}else if (!a.specified) {
						continue;
					}
					if (/_moz|contenteditable|_msh/.test(name)) {
						continue;
					}
					var value;
					if (name != "style") {
						if(weDOM.booleanAttributes.indexOf(" " + name + " ") > -1){
							value=name;
						}else{
							if (typeof rootNode[a.nodeName] != "undefined" && name != "href" && name != "src") {
								value = rootNode[a.nodeName];
							} else {
								value = a.nodeValue;
							}
						}
						if(name=="shape"){
							value = value.toLowerCase();
						}
						if(!isNaN(value)){
							value = rootNode.getAttribute(name);
						}
						if(isIE && root_tag=="img"){
							// Workarround for width & height BUG
							if(name=="width" && !value){
								var re = new RegExp("width=[\"']?([^ '\">]+)","g");
								var m = re.exec(rootNode.outerHTML);
								if(m!=null){
									value =m[1];
								}
							}else if(name=="height" && !value){
								var re = new RegExp("height=[\"']?([^ '\">]+)","g");
								var m = re.exec(rootNode.outerHTML);
								if(m!=null){
									value =m[1];
								}
							}
						}
					} else{
						value = a.nodeValue;
					}
					if (/(_moz|^$)/.test(value) && name!="alt") {
						continue;
					}

					html += " " + name + '="' + value + '"';
				}
				html += closed ? " />" : ">";
			}
			if(weDOM.nlAfterStartTag.indexOf(" " + root_tag + " ") > -1){
				html += "\n";
			}
			if (rootNode.nodeName.toLowerCase() == 'script') {
				html += "\n" + rootNode.innerHTML.trim() + "\n";
			} else {
				for (i = rootNode.firstChild; i; i = i.nextSibling) {
					html += this.getHTMLCode(i, true);
				}
			}
			// Ende Tag
			if (outputRootNode && !closed) {
				html += "</" + rootNode.nodeName.toLowerCase() + ">";
				if(weDOM.nlAfterEndTag.indexOf(" " + root_tag + " ") > -1){
					html += "\n";
				}
			}
			if(root_tag == "pre"){
				this.pre = false;
			}
			break;
	    case weDOM.TEXT_NODE: // Text
	    	if(rootNode.nodeValue){

	    		if(this.nodeDone == rootNode){
	    			this.nodeDone = null;
	    			break;
	    		}
	    		if(isIE){
	    			this.nodeDone = rootNode;
	    		}
	    		if(rootNode.nodeValue == "\n"){
	    			break;
	    		}
				html = rootNode.nodeValue.trim2().htmlentities();
			}
			break;
	    case weDOM.COMMENT_NODE: // Comment
			html = "<!--" + rootNode.nodeValue + "-->";
			break;
	}

	html = weDOM.weCorrectListTags(html,"ul");
	html = weDOM.weCorrectListTags(html,"ol");

	return html;
}

weDOM.weCorrectListTags = function(invalue,nodeName){
	var found = null;
	var regex = new RegExp("</li>[ \n\r\t]*<"+nodeName,"gi");
	while(found = invalue.match(regex)){
		var repl = found[0];

		var pos = invalue.indexOf(repl);
		// suche ul endtag
		var posULStartTag = invalue.indexOf("<"+nodeName,pos+1);
		var posULStartTag2 = invalue.indexOf("<"+nodeName,posULStartTag+1);
		var posULEndTag = invalue.indexOf("</"+nodeName,posULStartTag+1);
		var endtagcount = 0;
		var starttagposFinal = posULStartTag;
		while((posULStartTag2 > -1) && (posULEndTag >  posULStartTag2)){
			posULStartTag = posULStartTag2;
			posULStartTag2 = invalue.indexOf("<"+nodeName,posULStartTag+1);
			endtagcount++;
		}
		while(endtagcount){
			posULEndTag = invalue.indexOf("</"+nodeName,posULEndTag+1);
			endtagcount--;
		}
		invalue = (pos ? invalue.substring(0,pos) : "") + invalue.substring(pos+5,posULEndTag+5) + "</li>" + (((posULEndTag+5) < invalue.length) ? invalue.substring(posULEndTag+5,invalue.length) : "");
	}

	return invalue;
}

weDOM.prototype.getSelectedHTML = function(updateRange) {
	if (updateRange) {
		this.updateRange();
	}
	return this.getHTMLCode(this.range.cloneContents(),true);
}

weDOM.prototype.getSelectedText = function(updateSelection) {
	if (updateSelection) {
		this.updateSelection();
	}
	return "" + this.selection;
}

weDOM.prototype.surroundInlineTag = function(tagName, attributes) {
	var text = this.getSelectedText(true);
	var sur_node = this.isSurrounded(tagName);
	if (sur_node != null) {
		this.removeParentnode(sur_node);
	} else if (text.length > 0){
		var newNode = this.createElement(tagName);
		if (attributes != null) {
			for (var aname in attributes) {
				weDOM.setRemoveAttribute(newNode, aname, attributes[aname]);
			}
		}
		this.surroundNode(newNode, weDOM.multiInlineTags.indexOf(" " + tagName.toLowerCase() + " ") == -1);
		return newNode;
	}
	return null;
}

weDOM.prototype.surroundBlockTag = function(tagName, attributes) {
	var text = this.getSelectedText(true);
	var sur_node = this.getSurroundedBlockTag();
	if (sur_node == null) {
		var newNode = this.createElement(tagName);
		if (attributes != null) {
			for (var aname in attributes) {
				weDOM.setRemoveAttribute(newNode, aname, attributes[aname]);
			}
		}
		var startContainer = this.range.startContainer;
		if (this.range.startContainer != this.range.endContainer) {
			var lastNode = this.range.startContainer;
			var nextNode = this.findNextNode(this.editContainer, this.range.startContainer, false);
			while (nextNode && (nextNode.nodeType == weDOM.TEXT_NODE || weDOM.inlineTags.indexOf(" " + nextNode.nodeName.toLowerCase() + " ") > -1)) {
				lastNode = nextNode;
				nextNode = this.findNextNode(this.editContainer, nextNode, false);
			}
			if (lastNode) {
				var endOffset = (lastNode.nodeType == weDOM.TEXT_NODE) ? lastNode.nodeValue.length : 1;
				this.selection.setBaseAndExtent(this.range.startContainer, this.range.startOffset, lastNode, endOffset);
			}
		}
		this.surroundNode(newNode, true);
		return newNode;
	} else {
		if (sur_node.nodeName.toLowerCase() != tagName.toLowerCase()) {
			var newNode = this.document.createElement(tagName);
			this.changeParentnode(sur_node,newNode);
			this.selectNode(newNode);
		}
	}
	return null;
}


weDOM.hasAttribute = function(elem,name){
	if(elem && elem.hasAttribute){
		return elem.hasAttribute(name);
	}else{
		return false;
	}
}

weDOM.prototype.removeParentnode = function(node) {
	var count = 0;
	for (var foo=node.firstChild; foo; foo=foo.nextSibling) {
		count++;
	}
	if (count == node.childNodes.length) {
		var parent = node.parentNode;
		if (parent) {
			while (node.firstChild) {
				parent.insertBefore(node.firstChild, node);
			}
			parent.removeChild(node);
		}
	}
}

weDOM.prototype.changeParentnode = function(node, newNode) {
	var count = 0;
	for (var foo=node.firstChild; foo; foo=foo.nextSibling) {
		count++;
	}
	if (count == node.childNodes.length) {
		var parent = node.parentNode;
		if (parent) {
			while (node.firstChild) {
				newNode.appendChild(node.firstChild);
			}
			parent.insertBefore(newNode, node);
			parent.removeChild(node);
		}
	}
}

weDOM.prototype.getTableCell = function() {
	var cell = this.getParentNodeFromSelection();
	while (	(cell) &&
			(cell.nodeName.toLowerCase() != "td") &&
			(cell.nodeName.toLowerCase() !=  "th") &&
			(cell.nodeName.toLowerCase() != "body")
		) {
		cell = cell.parentNode;
	}

	if ((! cell) || (cell.nodeName.toLowerCase() == "body")) {
		return null;
	} else {
		return cell;
	}
}

weDOM.prototype.isSurrounded = function(tagName, blockTags) {

	blockTags = (blockTags == null) ? false : blockTags;

	parentNode = this.getParentNodeFromSelection();
	while (	(parentNode != null) &&
			(parentNode.nodeName.toLowerCase() != "body") &&
			(blockTags || (weDOM.inlineTags.indexOf(" " + parentNode.nodeName.toLowerCase() + " ") != -1)) &&
			(parentNode.nodeName.toLowerCase() != tagName.toLowerCase())
		) {
		parentNode = parentNode.parentNode;
	}
	if ( (parentNode != null) && (parentNode.nodeName.toLowerCase() == tagName.toLowerCase())) {
		return parentNode;
	}
	return null;
}

weDOM.prototype.getSurroundedBlockTag = function() {


	this.updateRange();

	parentNode = this.getParentNodeFromSelection();
	while (	(parentNode != null) &&
			(parentNode.nodeName.toLowerCase() != "body") &&
			(weDOM.inlineTags.indexOf(" " + parentNode.nodeName.toLowerCase() + " ") != -1)
		) {
		parentNode = parentNode.parentNode;
	}
	if ( (parentNode != null) && (weDOM.formatblockTags.indexOf(" " + parentNode.nodeName.toLowerCase() + " ") != -1)) {
		if (parentNode.innerText == this.getSelectedText() || (this.range && this.range.collapsed)) {
			return parentNode;
		} else {
			return null;
		}
	}
	return null;
}

weDOM.setAttribute = function(node, aname, avalue) {
	node.setAttribute(aname, avalue);
}

weDOM.setRemoveAttribute = function(node, aname, avalue) {
	if (avalue) {
		weDOM.setAttribute(node, aname, avalue);
	} else {
		weDOM.removeAttribute(node, aname);
	}
}

weDOM.getNumTableRows = function(table){
	if(table.childNodes.length){
		var tbody = weDOM.getTableBody(table);
		if(tbody != null){
			return tbody.childNodes.length;
		}
	}
	return 0;
}

weDOM.getNumTableCols = function(table){
	if(table.hasChildNodes()){
		var tbody = weDOM.getTableBody(table);
		if(tbody != null){
			var tr = (tbody.childNodes[0].nodeName == "TR") ? tbody.childNodes[0] : null;
			if(tr != null){
				var z = 0;
				for(var i=0; i< tr.childNodes.length; i++){
					if(isGecko){
						if(tr.childNodes[i].colspan != undefined){
							z += parseInt(""+tr.childNodes[i].colspan);
						}else{
							z++;
						}
					}else{
						if(tr.childNodes[i].colSpan != undefined){
							z += parseInt(""+tr.childNodes[i].colSpan);
						}else{
							z++;
						}
					}
				}
				return z;
			}
		}
	}
	return 0;
}

weDOM.getNodeNumber = function(node) {
	var nodeNr = 1;
	var name = node.nodeName;
	while (node = node.previousSibling) {
		if (node.nodeName == name) nodeNr++;
	}
	return nodeNr;
}

weDOM.getNodePath = function(node) {
	var nodePath = new Array();
	var obj = new Object();
	obj.nodeName = node.nodeName;
	obj.nodeNumber = weDOM.getNodeNumber(node);
	nodePath.push(obj);
	while (	(node = node.parentNode) &&
			(node.nodeName.toLowerCase() != "body")
		) {
		obj = new Object();
		obj.nodeName = node.nodeName;
		obj.nodeNumber = weDOM.getNodeNumber(node);
		nodePath.push(obj);
	}
	return nodePath;
}

weDOM.findNodeFromPath = function(container, nodePath) {
	if (container == null || nodePath == null ) {
		return null;
	}
	var node = container;
	for (var i=nodePath.length-1; i>=0; i--) {
		var nodeNumber = 0;
		for (var n=0; n<node.childNodes.length; n++) {
			if (node.childNodes[n].nodeName == nodePath[i].nodeName) {
				nodeNumber++;
				if (nodeNumber == nodePath[i].nodeNumber) {
					node = node.childNodes[n];
					break;
				}
			}
		}
	}
	if (node == container) {
		return null;
	}
	return node;
}

weDOM.getLastTableCell = function(row){
	if(row.hasChildNodes()){
		for(var i=row.childNodes.length-1; i>=0; i--){
			if(row.childNodes[i].nodeName=="TD" || row.childNodes[i].nodeName=="TH"){
				return row.childNodes[i];
			}
		}
	}
	return null;
}

weDOM.getTableBody = function(table){
	if(table.hasChildNodes()){
		for(var i=0; i< table.childNodes.length; i++){
			if(table.childNodes[i].nodeName=="TBODY"){
				return table.childNodes[i];
			}
		}
	}
	return table;
}

weDOM.removeAttribute = function(node, attribute) {
	node.removeAttribute(attribute);
}

weDOM.prototype.createElement = function(nodeName) {
	return this.document.createElement(nodeName);
}

String.prototype.htmlentities = function() {
	return this.replace(/&/ig, "&amp;").replace(/>/ig, "&gt;").replace(/</ig, "&lt;").replace(/\x22/ig, "&quot;");
}

String.prototype.trim = function() {
   return this.replace(/^\s+|\s+$/g,"");
}

String.prototype.trim2 = function() {
   return this.replace(/^\s{2,}|\s{2,}$/g," ");
}

// call this function only when you know that cursor is within <nodeName>
weDOM.prototype.selectionAtEndOfNode = function(nodeName) {
	var node = this.range.endContainer;
	nodeName = nodeName.toLowerCase();
	while (	node != null &&
			node.nodeName.toLowerCase() != nodeName &&
			(node == node.parentNode.lastChild || node.parentNode.lastChild.nodeName.toLowerCase() == "br" || (node.parentNode.lastChild.nodeValue && node.parentNode.lastChild.nodeValue.trim().length == 0))
	) {
		node = node.parentNode;
	}
	if (	(node.nodeName.toLowerCase() == nodeName) &&
			(	(this.range.endContainer == node && this.range.endOffset == 0) ||
				(this.range.endContainer.nodeValue && this.range.endContainer.nodeValue.length == this.range.endOffset)
			)
		){
		return node;
	}
	return null;
}

// call this function only when you know that cursor is within <nodeName>
weDOM.prototype.selectionAtStartOfNode = function(nodeName) {
	var node = this.range.startContainer;
	nodeName = nodeName.toLowerCase();
	while (node != null && node.nodeName.toLowerCase() != nodeName &&
			(node == node.parentNode.firstChild || (node.parentNode.firstChild.nodeType==weDOM.TEXT_NODE && node.parentNode.firstChild.nodeValue.length==0)) ) {
		node = node.parentNode;
	}
	if (	(node.nodeName.toLowerCase() == nodeName) &&
			(this.range.startOffset == 0)
		){
		return node;
	}
	return null;
}

weDOM.isEmptyTextNode = function(node) {
	if (node.nodeType == weDOM.TEXT_NODE) {
		if (node.nodeValue.length == 0) {
			return true;
		} else if (node.nodeValue.replace(/[\r\n]/,"").length == 0) {
			return true;
		} else if (node.nodeValue == String.fromCharCode(160)) {
			return true;
		}
	}
	return false;
}

weDOM.getFirstChild = function(node) {
	var node = node.firstChild;
	while(node && weDOM.isEmptyTextNode(node)) {
		node = node.nextSibling;
	}
	return node;
}

weDOM.getLastChild = function(node) {
	var node = node.lastChild;
	var brCount = 0;
	while(node && (weDOM.isEmptyTextNode(node) || (brCount == 0 && node.nodeName.toLowerCase() == "br"))) {
		if (node.nodeName.toLowerCase() == "br") brCount++;
		node = node.previousSibling;
	}
	return node;
}

weDOM.isLastNodeOfParent = function(node, parent) {
	while (	node != null &&
			node != parent &&
			node == weDOM.getLastChild(node.parentNode)
	) {
		node = node.parentNode;
	}
	return node == parent;
}

weDOM.emptyNode = function(node) {
	for (var i=node.childNodes.length-1; i>=0; i--) {
		node.removeChild(node.childNodes[i]);
	}
}

weDOM.isBreakedListNode = function(li) {
	return 		(	li.childNodes.length == 1 &&
					li.firstChild.nodeName.toLowerCase() == "br"
				 ) ||
				 (	li.childNodes.length == 2 &&
				 	li.firstChild.nodeName.toLowerCase() == "br" &&
				 	li.lastChild.nodeValue &&
				 	li.lastChild.nodeValue.length == 1 &&
				 	li.lastChild.nodeValue.charCodeAt(0) == 10
				 );
}

weDOM.getSameNextSibling = function(node) {
	var returnNode = node.nextSibling;
	while (returnNode && returnNode.nodeName.toLowerCase() != node.nodeName.toLowerCase()) {
		returnNode = returnNode.nextSibling;
	}
	return returnNode;
}

weDOM.getSamePreviousSibling = function(node) {
	var returnNode = node.previousSibling;
	while (returnNode && returnNode.nodeName.toLowerCase() != node.nodeName.toLowerCase()) {
		returnNode = returnNode.previousSibling;
	}
	return returnNode;
}

weDOM.debug = function(text, clear) {
	text = "" + text;
	if (clear) document.getElementById("debug").value = "";
	document.getElementById("debug").value += text + "\n------------------------------\n";
}

weDOM.debug2 = function(text, clear) {
	text = "" + text;
	if (clear) document.getElementById("debug2").value = "";
	document.getElementById("debug2").value += text + "\n------------------------------\n";
}

weDOM.debugNode = function(node,txt,clear) {
	if (txt) {
		weDOM.debug(txt+"\n"+weDOM.getNode(node),clear);
	} else {
		weDOM.debug(weDOM.getNode(node),clear);
	}
}

weDOM.nodeInContainer = function(node, container) {
	do {
		if (container == node) {
			return true;
		}
		node = node.parentNode;
	} while (node)

	return false;
}

weDOM.getNode = function(node) {
	if (node == null) return null;
	var text = 'nodeName: ' + node.nodeName + "\n";
	text += 'nodeType: ' + node.nodeType + "\n";
	text += 'nodeValue: ' + node.nodeValue + "\n";
	if (node.nodeValue != null) text += 'nodeValue.length: ' + node.nodeValue.length + "\n";
	if (node.nodeValue) text += 'charcode(0): ' + node.nodeValue.charCodeAt(0) + "\n";
	text += 'innerHTML: ' + node.innerHTML;
	return text;
}

weDOM.debugRange = function(range) {
	var text = 'startContainer: ' + weDOM.getNode(range.startContainer) + "\n";
	text += 'startOffset: ' + range.startOffset + "\n";
	text += 'endContainer: ' + weDOM.getNode(range.endContainer) + "\n";
	text += 'endOffset: ' + range.endOffset + "\n";
	text += 'collapsed: ' + range.collapsed;
	weDOM.debug(text);
}

weDOM.debugSelection = function(selection) {
	var text = 'baseNode: ' + weDOM.getNode(selection.baseNode) + "\n";
	text += 'baseOffset: ' + selection.baseOffset + "\n";
	text += 'extentNode: ' + weDOM.getNode(selection.extentNode) + "\n";
	text += 'extentOffset: ' + selection.extentOffset + "\n";
	text += 'anchorNode: ' + weDOM.getNode(selection.anchorNode) + "\n";
	text += 'anchorOffset: ' + selection.anchorOffset + "\n";
	text += 'focusNode: ' + weDOM.getNode(selection.focusNode) + "\n";
	text += 'focusOffset: ' + selection.focusOffset + "\n";
	text += 'isCollapsed: ' + selection.isCollapsed + "\n";
	text += 'type: ' + selection.type;
	weDOM.debug(text);
}



/********************** DEFINES *******************/

weDOM.debugwin = null;
weDOM.debugText = null;
weDOM.debugClear = false;

weDOM.ELEMENT_NODE                   = 1;
weDOM.ATTRIBUTE_NODE                 = 2;
weDOM.TEXT_NODE                      = 3;
weDOM.CDATA_SECTION_NODE             = 4;
weDOM.ENTITY_REFERENCE_NODE          = 5;
weDOM.ENTITY_NODE                    = 6;
weDOM.PROCESSING_INSTRUCTION_NODE    = 7;
weDOM.COMMENT_NODE                   = 8;
weDOM.DOCUMENT_NODE                  = 9;
weDOM.DOCUMENT_TYPE_NODE             = 10;
weDOM.DOCUMENT_FRAGMENT_NODE         = 11;
weDOM.NOTATION_NODE                  = 12;

weDOM.START_TO_START = 0;
weDOM.START_TO_END   = 1;
weDOM.END_TO_END     = 2;
weDOM.END_TO_START   = 3;
weDOM.emptyTags = " base meta link hr br basefont param img area input isindex col ";
weDOM.inlineTags = " a abbr acronym b big blink cite code del em font i ins kbd label q s samp select small span strike strong sub sup textarea tt u var ";
weDOM.formatblockTags = " h1 h2 h3 h4 h5 h6 pre address p div blockquote ";
weDOM.multiInlineTags = " font span ";
weDOM.booleanAttributes = " nowrap ismap declare noshade checked disabled readonly multiple selected noresize defer";
weDOM.nlAfterStartTag = " table tr ul ol th tbody br ";
weDOM.nlAfterEndTag = " table tr td ul ol th tbody p li h1 h2 h3 h4 h5 h6 pre code div ";