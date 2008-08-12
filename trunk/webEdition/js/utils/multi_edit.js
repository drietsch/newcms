// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//
// $Id: multi_edit.js,v 1.12 2008/03/31 13:40:12 alexander.lindenstruth Exp $

	function multi_edit(parentId,form,itemNum,but,width,editable) {

		this.variantCount = 0;
		this.itemCount = 0;
		this.currentVariant = 0;
		this.button = "";
		this.defWidth = width;
		this.name = "me" + Math.round(Math.random()*10000);
		this.parent = document.getElementById(parentId);
		this.form = form;
		this.editable = editable;
		this.delRelatedItems = false;

		this.createItemHidden = function (name){

			var item = document.createElement("input");
			item.setAttribute("name",name);
			item.setAttribute("id",name);
			item.setAttribute("type","hidden");
			form.appendChild(item);

			//this.form.appendChild(item);
			this.parent.appendChild(item);

			item = null;
		}

		this.updateHidden = function(item,value){
			this.form.elements[this.name+"_variant"+this.currentVariant+"_"+this.name+"_"+item].value=value;
		}

		this.addVariant = function (){
			for(var i=0;i<this.itemCount;i++){
				this.createItemHidden(this.name+"_variant"+this.variantCount+"_"+this.name+"_item"+i);
			}
			this.variantCount++;
		}

		this.deleteVariant = function (variant){
			if(variant<(this.variantCount-1)){
				for(var i=variant+1;i<this.variantCount;i++){
					for(var j=0;j<this.itemCount;j++){
						this.form.elements[this.name+"_variant"+(i-1)+"_"+this.name+"_item"+j].value = this.form.elements[this.name+"_variant"+i+"_"+this.name+"_item"+j].value;
					}
				}
			}

			this.variantCount--;
			for(var z=0;z<this.itemCount;z++){
				var item = document.getElementById(this.name+"_variant"+this.variantCount+"_"+this.name+"_item"+z);
				//this.form.removeChild(item);
				this.parent.removeChild(item);
			}
			if(variant<(this.variantCount-1)) this.currentVariant=variant;
			else this.currentVariant=this.variantCount-1;

			this.showVariant(this.currentVariant);

		}

		this.addItem = function (){

			if(arguments[0]){
				this.button = arguments[0];
			}

			var butt=this.button.replace("#####placeHolder#####",this.name+".delItem("+this.itemCount+")");

			var set = document.createElement("div");
			set.setAttribute("id",this.name+"_item"+this.itemCount);

			if(this.editable == true){
				set.innerHTML = "<table style=\"margin-bottom:5px;\" cellpadding=0 cellspacing=0 border=0><tr valign=\"middle\"><td style=\"width:"+this.defWidth+"\"><input name=\""+this.name+"_item"+this.itemCount+"\" id=\""+this.name+"_item_input_"+this.itemCount+"\" type=\"text\" style=\"width:"+this.defWidth+"\" onkeyup=\""+this.name+".updateHidden(\'item"+this.itemCount+"\',this.value)\" class=\"wetextinput\"></td><td>&nbsp;</td><td>" + butt + "</td></tr></table>";
			}
			else{
				set.innerHTML = "<table style=\"margin-bottom:5px;\" cellpadding=0 cellspacing=0 border=0><tr valign=\"middle\"><td style=\"width:"+this.defWidth+"\"><label id=\""+this.name+"_item_label_"+this.itemCount+"\" class=\"defaultfont\"></td><td>&nbsp;</td><td>" + butt + "</td></tr></table>";
			}

			this.parent.appendChild(set);

			set = null;

			for(var j=0;j<this.variantCount;j++){
				this.createItemHidden(this.name+"_variant"+j+"_"+this.name+"_item"+this.itemCount);
			}

			this.itemCount++;
		}

		this.delItem = function(child){
			this.itemCount--;
			for(var i=0;i<this.variantCount;i++){
				if(child<this.itemCount){
					for(var j=child+1;j<(this.itemCount+1);j++){
						this.form.elements[this.name+"_variant"+i+"_"+this.name+"_item"+(j-1)].value = this.form.elements[this.name+"_variant"+i+"_"+this.name+"_item"+j].value;
					}
				}
				var item = document.getElementById(this.name+"_variant"+i+"_"+this.name+"_item"+this.itemCount);
				//this.form.removeChild(item);
				this.parent.removeChild(item);
			}

			var item1 = document.getElementById(this.name+"_item"+this.itemCount);
			this.parent.removeChild(item1);
			if(this.delRelatedItems) {
				document.getElementById("updateScores").value=true;
				elemRow = document.getElementById("row_scores_"+child);
				elemRow.parentNode.removeChild(elemRow);
				var xcount=child+1;
				while(elemRow = document.getElementById("row_scores_"+xcount)){
				 	elemRow.setAttribute('id',"row_scores_"+(xcount-1));
				 	var elemX;
				 	if(elemX=document.getElementById("scores_"+xcount)) {
				 		elemX.setAttribute('id',"scores_"+(xcount-1));
				 		elemX.setAttribute('name',"scores_"+(xcount-1));
				 	}
				 	xcount++;
				}
			}
			this.showVariant(this.currentVariant);
		}
		
		this.setItem = function (variant,item,value){
			this.form.elements[this.name+"_variant"+variant+"_"+this.name+"_item"+item].value=value;
		}

		this.setRelatedItems = function (item) {
			this.relatedItems[this.itemCount] = item; 
		}
		
		this.showVariant = function (variant){
			for(var i=0;i<this.itemCount;i++){
				if(variant!=this.currentVariant && this.editable) this.setItem(this.currentVariant,i,this.form.elements[this.name+"_item"+i].value);
				if(this.editable) this.form.elements[this.name+"_item"+i].value=this.form.elements[this.name+"_variant"+variant+"_"+this.name+"_item"+i].value;
				else {
					var item = document.getElementById(this.name+"_item_label_"+i);
					item.innerHTML = this.form.elements[this.name+"_variant"+variant+"_"+this.name+"_item"+i].value;
				}
			}
			this.currentVariant=variant;
		}

		this.button = but;
		for(i=0;i<itemNum;i++){
			this.addItem();
		}

		eval(this.name + "=this");
	}