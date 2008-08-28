/**
 * webEdition CMS
 *
 * LICENSETEXT_CMS
 *
 *
 * @category   we
 * @package    we_base
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/licence     LICENSETEXT_CMS  TODO insert license type and url
 */

function we_textarea(name,value,cols,rows,width,height,autobr,autobrName,showAutobr,showRTF,language,classname,style,wrap,changehandler,xml,id,showSpell){
	this.TAName = name;
	this.name = "weTextarea"+(weTextarea_count++);
	this.obj = this.name+"Object";
	this.autobr = (autobr=="on") ? true : false;
	this.nl2br = we_textarea_nl2br;
	this.br2nl = we_textarea_br2nl;
	this.appendText = we_textarea_appendText;
	this.htmlspecialchars = we_textarea_htmlspecialchars;
	this.ButtonNormal = we_textarea_ButtonNormal;
	this.ButtonOverUp = we_textarea_ButtonOverUp;
	this.ButtonOverDown = we_textarea_ButtonOverDown;
	this.ButtonDown = we_textarea_ButtonDown;
	this.xml = xml;
	this.id = id;

	if(style.length){
		if(style.substring(style.length-1,style.length) != ";"){
			style += ";";
		}
	}
	if(width){
		style += "width:"+width+"px;";
	}
	if(height){
		style += "height:"+height+"px;";
	}
	val = value ? value : "";

	if(val){
		val = val.replace(/##\|n##/gi,"\n");
		val = val.replace(/<##scr#ipt##/gi,"<script");
		val = val.replace(/<\/##scr#ipt##/gi,"</script");
		val = val.replace(/##\|lt\;\?##/gi,"<?");

	}
	out = '<input type="hidden" name="';

	out += autobrName;
	out += '" value="';
	out += this.autobr ? 'on' : 'off';
	out += '"><table border="0" cellpadding="0" cellspacing="0" background="/webEdition/images/backgrounds/aquaBackground.gif">';
	if(showAutobr || showRTF){
		out += '<tr><td><table border="0" cellpadding="0" cellspacing="0">';
	}
	if(showAutobr){


		out += '<td><input type="checkbox" name="check';
		out += name;
		out += '" id="check';
		out += name;
		out += '" onClick="if(self.'+this.name+'Object){';
		out += this.name;
		out += 'Object.translate(this);this.form.elements[\''+autobrName+'\'].value=(this.checked ? \'on\' : \'off\');}"';
		out += this.autobr ? ' checked' : '';
		out += '>&nbsp;</td><td style=" color:black;font-weight: bold; font-size: 10px; font-family: Verdana, Geneva, Arial, Helvetica, sans-serif;cursor: pointer;" onClick="if(self.'+this.name+'Object){var cb=document.getElementById(\'check'+name+'\');cb.checked=cb.checked ? false : true;'+this.name+'Object.translate(cb);cb.form.elements[\''+autobrName+'\'].value=(cb.checked ? \'on\' : \'off\');}">autobr</td>';
	}

	if(showAutobr && (showRTF || showSpell)){
		out += '<td style="color:black;font-weight: bold; font-size: 10px; font-family: Verdana, Geneva, Arial, Helvetica, sans-serif">&nbsp;</td><td><div unselectable="on" style="border-right: #999999 solid 1px; font-size: 0px; height:22px; width:2px;"></div></td><td style="color:black;font-weight: bold; font-size: 10px; font-family: Verdana, Geneva, Arial, Helvetica, sans-serif">&nbsp;</td>';
	}
	if(showRTF){

		out += '<td unselectable="on"><div unselectable="on">'+"\n";
		out += '<img  style="border: 0px; margin: 1px;" unselectable="on" width="23" height="22" src="/webEdition/images/wysiwyg/rtf.gif"'+"\n";
		out += 'onmouseover="'+this.name+'Object.ButtonOverUp(this)"'+"\n";
		out += 'onmouseout="'+this.name+'Object.ButtonNormal(this)"'+"\n";
		out += 'onmousedown="'+this.name+'Object.ButtonOverDown(this)"'+"\n";
		out += 'onclick="window.open(\'/webEdition/wysiwyg/importRtfDialog.php?we_dialog_args[ntxt]=1&we_dialog_args[taname]='+escape(this.name)+'\',\'importRtf\',\'height=600,width=680,scrollbars=1\');"></div></td>';

		//out += '<td><a href="#" onclick="window.open(\'/webEdition/wysiwyg/importRtfDialog.php?we_dialog_args[ntxt]=1&we_dialog_args[taname]='+escape(this.name)+'\',\'importRtf\',\'height=600,width=680,scrollbars=1\');">';
		//out += '<div unselectable="on" style="border:1px solid transparent; padding: 1px" onMouseOver="'+this.name+'Object.ButtonOverUp(this)" onMouseOut="'+this.name+'Object.ButtonNormal(this)" onMouseDown="'+this.name+'Object.ButtonOverDown(this)"><img border="0" src="/webEdition/images/wysiwyg/rtf.gif" width="23" height="22"></div>';
		//out += '</a></td>';
	}

	if(showSpell) {

		out += '<td unselectable="on"><div unselectable="on">'+"\n";
		out += '<img  style="border: 0px; margin: 1px;" unselectable="on" width="23" height="22" src="/webEdition/images/wysiwyg/spellcheck.gif"'+"\n";
		out += 'onmouseover="if(self.'+this.name+'Object){'+this.name+'Object.ButtonOverUp(this);}"'+"\n";
		out += 'onmouseout="if(self.'+this.name+'Object){'+this.name+'Object.ButtonNormal(this);}"'+"\n";
		out += 'onmousedown="if(self.'+this.name+'Object){'+this.name+'Object.ButtonOverDown(this);}"'+"\n";
		out += 'onclick="window.open(\'/webEdition/wysiwyg/spellcheck.php?editname=areatmp_'+escape(name)+'\',\'spellchechecker\',\'height=450,width=500,scrollbars=0\');"></div></td>';


	}

	if(showAutobr || showRTF){
		out += '</table></td></tr>';
	}

	out += '<tr><td><textarea name="areatmp_';
	out += name;
	out += '"';
	out += classname ? ' class="'+classname+'"' : '';
	out += cols ? ' cols="'+cols+'"' : '';
	out += wrap ? ' wrap="'+wrap+'"' : '';
	out += rows ? ' rows="'+rows+'"' : '';
	out += id ? ' id="'+id+'"' : '';
	out += style ? ' style="'+style+'"' : '';
	out += ' '+changehandler+'="if (_EditorFrame){_EditorFrame.setEditorIsHot(true)};this.form.elements[\'';
	out += name;
	out += '\'].value=(';
	out += this.name;
	out += 'Object.autobr ? ';
	out += this.name;
	out += 'Object.nl2br(this.value,' + (this.xml ? 'true' : 'false') + ') : this.value);" onblur="if(self.'+this.name+'Object){this.form.elements[\'';
	out += name;
	out += '\'].value=(';
	out += this.name+'Object.autobr ? ';
	out += this.name;
	out += 'Object.nl2br(this.value,' + (this.xml ? 'true' : 'false') + ') : this.value);}">';
	if(val) out += this.htmlspecialchars(this.autobr ? this.br2nl(val) : val);
	out += '</textarea>';
	out += '<input type="hidden" name="';
	out += name;
	out += '" value=""></td></tr></table>';
	this.form = null;
	document.writeln(out);
	for(var i=0; i<document.forms.length; i++){
		if(document.forms[i].elements[name]){
			this.form = document.forms[i];
			break;
		}
	}
	if(this.form != null){
		this.form.elements[name].value = val;
	}

	this.translate = we_textarea_translate;
	eval(this.obj + "=this");
}

function we_textarea_translate(check){
	if(check.checked){
		this.autobr=true;
		check.form.elements["areatmp_"+this.TAName].value=this.br2nl(check.form.elements[this.TAName].value);
	}else{
		this.autobr=false;
		check.form.elements["areatmp_"+this.TAName].value=check.form.elements[this.TAName].value;
	}
}

function we_textarea_appendText(text){
	this.form.elements[this.TAName].value += text;
	if(this.autobr){
	 	this.form.elements["areatmp_"+this.TAName].value = this.br2nl(this.form.elements[this.TAName].value);
	}else{
		this.form.elements["areatmp_"+this.TAName].value=this.form.elements[this.TAName].value;
	}
}


function we_textarea_nl2br(i,xml){
	if(! xml){
		i = i.replace(/\r\n/g,"<br>");
		i = i.replace(/\n/g,"<br>");
		i = i.replace(/\r/g,"<br>");
		return i.replace(/<br>/g,"<br>\n");
	}else{
		i = i.replace(/\r\n/g,"<br />");
		i = i.replace(/\n/g,"<br />");
		i = i.replace(/\r/g,"<br />");
		return i.replace(/<br *\/>/g,"<br />\n");
	}
}
function we_textarea_br2nl(i){
	i = i.replace(/\n\r/g,"");
	i = i.replace(/\r\n/g,"");
	i = i.replace(/\n/g,"");
	i = i.replace(/\r/g,"");
	return i.replace(/<br *\/?>/gi,"\n");
}

function we_textarea_htmlspecialchars(i){
	i = i.replace(/&/g,"&amp;");
	i = i.replace(/"/g,"&quot;");
	i = i.replace(/'/g,"&#039;");
	i = i.replace(/</g,"&lt;");
	i = i.replace(/>/g,"&gt;");
	return i;
}

function we_textarea_ButtonNormal(bt){
	bt.style.border = "0px groove";
	bt.style.margin = "1px";
}

function we_textarea_ButtonOverUp(bt){
	bt.style.margin = "0px";
	bt.style.borderBottom = "#000000 solid 1px";
	bt.style.borderLeft = "#CCCCCC solid 1px";
	bt.style.borderRight = "#000000 solid 1px";
	bt.style.borderTop = "#CCCCCC solid 1px";
}

function we_textarea_ButtonOverDown(bt){
	bt.style.margin = "0px";
	bt.style.borderBottom = "#CCCCCC solid 1px";
	bt.style.borderLeft = "#000000 solid 1px";
	bt.style.borderRight = "#CCCCCC solid 1px";
	bt.style.borderTop = "#000000 solid 1px";
}

function we_textarea_ButtonDown(bt){
	bt.style.margin = "0px";
	bt.style.backgroundImage = "url(webEdition/images/java_menu/background_dark.gif)";
	bt.style.borderBottom = "#CCCCCC solid 1px";
	bt.style.borderLeft = "#000000 solid 1px";
	bt.style.borderRight = "#CCCCCC solid 1px";
	bt.style.borderTop = "#000000 solid 1px";
}

weTextarea_count = 0;
