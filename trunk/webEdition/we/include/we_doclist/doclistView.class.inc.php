<?php
// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//

/**
 * @abstract class making the view for the document list
 * @author Thomas Kneip
 * @copyright Copyright (c) 2000 - 2007, living-e AG
 * @since 5.1.0.0 - 14.10.2007
 */

include_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_tools/weSearch/language/language_' . $GLOBALS ['WE_LANGUAGE'] . '.inc.php');
include_once($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_language/" . $GLOBALS ["WE_LANGUAGE"] . "/contenttypes.inc.php");
include_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_tools/weSearch/class/searchtoolView.class.php');
include_once($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_classes/weMetaData/weMetaData.class.php");
include_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_exim/weContentProvider.class.php');


class doclistView {
	/**
	 * @abstract create javascript for document list
	 * @return javascript code
	 */
	function getSearchJS() {
		$we_button = new we_button ( );
				
		$h = 0;
		$addinputRows = "";
		if ($GLOBALS ['we_doc']->searchclassFolder->mode) {
			$h += 30;
			//add height of each input row to calculate the scrollContent-height
			$addinputRows = 'for(i=0;i<newID;i++) {
                scrollheight = scrollheight + 26;
              }';
		}
		
		$IE6 = false;
		//workaround for z-index ans selects in ie6
		if (($GLOBALS ['BROWSER'] == "IE")) {
			$foo = explode ( ";", $_SERVER["HTTP_USER_AGENT"] );
			$version = abs ( eregi_replace ( "[^0-9\\.]", "", $foo [1] ) );
			if ($version < 7) {
				$IE6 = true;
			}
		}
		if ($IE6) {
			$showHideSelects = 'var AnzahlSelects = document.getElementsByTagName("select");
                for (var k = 0; k <= AnzahlSelects.length; k++ ) {
                  var selectAnzahl = AnzahlSelects[k];
                  var sATop = absTop(selectAnzahl);
                  var sAHeight = selectAnzahl.offsetHeight;
                  var sABottom = eval(sATop+sAHeight);
                  var sALeft = absLeft(selectAnzahl);
                  var sAWidth = selectAnzahl.offsetWidth;
                  var sARight = eval(sALeft+sAWidth);

                  if(elem.offsetTop-20<sATop && eval(elem.offsetTop+elemHeight+50)>sABottom && elem.offsetLeft<sARight && eval(elem.offsetLeft+elemWidth)>sALeft) {
                    selectAnzahl.style.visibility = "hidden";
                  }
                  else {
                    selectAnzahl.style.visibility = "visible";
                  }
                }';
			
			$showSelects = 'var AnzahlSelects = document.getElementsByTagName("select");
              for (var k = 0; k <= AnzahlSelects.length; k++ ) {
                var selectAnzahl = AnzahlSelects[k];
                if(selectAnzahl.style.visibility == "hidden") {
                  selectAnzahl.style.visibility = "visible";
                }
              }';
		} else {
			$showHideSelects = '';
			$showSelects = '';
		}
		
		$_js = we_htmlElement::jsElement ( '
    
      var ajaxURL = "/webEdition/rpc/rpc.php";
      var ajaxCallbackResultList = {
        success: function(o) {
          if(typeof(o.responseText) != "undefined" && o.responseText != "") {
            document.getElementById("scrollContent_doclist").innerHTML = o.responseText;
            makeAjaxRequestParametersTop();
            makeAjaxRequestParametersBottom();
          }
        },
        failure: function(o) {
          alert("Failure");
        }
      }
      var ajaxCallbackParametersTop = {
        success: function(o) {
          if(typeof(o.responseText) != "undefined" && o.responseText != "") {
            document.getElementById("parametersTop").innerHTML = o.responseText;
          }
        },
        failure: function(o) {
          alert("Failure");
        }
      }
      var ajaxCallbackParametersBottom = {
        success: function(o) {
          if(typeof(o.responseText) != "undefined" && o.responseText != "") {
            document.getElementById("parametersBottom").innerHTML = o.responseText;
          }
        },
        failure: function(o) {
          alert("Failure");
        }
      }
      
      var ajaxCallbackgetMouseOverDivs = {
        success: function(o) {
          if(typeof(o.responseText) != "undefined" && o.responseText != "") {
            document.getElementById("mouseOverDivs_doclist").innerHTML = o.responseText;
          }
        },
        failure: function(o) {
          alert("Failure");
        }
      }
      
      function search(newSearch) {
      
      	if('.searchtoolsearch::checkRightTempTable().' && '.searchtoolsearch::checkRightDropTable().') {
   			'.we_message_reporting::getShowMessageCall ( $GLOBALS ["l_weSearch"] ["noTempTableRightsDoclist"], WE_MESSAGE_NOTICE ).'
      	}
      	else {
	        if(newSearch) {
	          document.we_form.searchstart.value=0;
	        }
	        makeAjaxRequestDoclist();
	    }
      }
      
      function makeAjaxRequestDoclist() {
        getMouseOverDivs();
        var args = "";
        var newString = "";
        for(var i = 0; i < document.we_form.elements.length; i++) {
          newString = document.we_form.elements[i].name;
          args += "&we_cmd["+escape(newString)+"]="+escape(document.we_form.elements[i].value);
        }
        var scroll = document.getElementById("scrollContent_doclist");
        scroll.innerHTML = "<table border=\'0\' width=\'100%\' height=\'100%\'><tr><td align=\'center\'><img src=' . IMAGE_DIR . 'logo-busy.gif /><div id=\'scrollActive\'></div></td></tr></table>";  
        YAHOO.util.Connect.asyncRequest("POST", ajaxURL, ajaxCallbackResultList, "protocol=json&cns=doclist&cmd=GetSearchResult&classname=we_folder&id=' . $GLOBALS ['we_doc']->ID . '&we_transaction=' . $_REQUEST ['we_transaction'] . '"+args+"");
      }

      function makeAjaxRequestParametersTop() {
        var args = "";
        var newString = "";
        for(var i = 0; i < document.we_form.elements.length; i++) {
          newString = document.we_form.elements[i].name;
          args += "&we_cmd["+escape(newString)+"]="+escape(document.we_form.elements[i].value);
        }
          YAHOO.util.Connect.asyncRequest("POST", ajaxURL, ajaxCallbackParametersTop, "protocol=json&cns=doclist&cmd=GetSearchParameters&position=top&classname=we_folder&id=' . $GLOBALS ['we_doc']->ID . '&we_transaction=' . $_REQUEST ['we_transaction'] . '"+args+"");
      }
      
      function makeAjaxRequestParametersBottom() {
        var args = "";
        var newString = "";
        for(var i = 0; i < document.we_form.elements.length; i++) {
          newString = document.we_form.elements[i].name;
          args += "&we_cmd["+escape(newString)+"]="+escape(document.we_form.elements[i].value);
        }
          YAHOO.util.Connect.asyncRequest("POST", ajaxURL, ajaxCallbackParametersBottom, "protocol=json&cns=doclist&cmd=GetSearchParameters&position=bottom&classname=we_folder&id=' . $GLOBALS ['we_doc']->ID . '&we_transaction=' . $_REQUEST ['we_transaction'] . '"+args+"");
      }
      
      function getMouseOverDivs() {
        var args = "";
        var newString = "";
        for(var i = 0; i < document.we_form.elements.length; i++) {
          newString = document.we_form.elements[i].name;
          args += "&we_cmd["+escape(newString)+"]="+escape(document.we_form.elements[i].value);
        }  
        YAHOO.util.Connect.asyncRequest("POST", ajaxURL, ajaxCallbackgetMouseOverDivs, "protocol=json&cns=doclist&cmd=GetMouseOverDivs&whichsearch=doclist&classname=we_folder&id=' . $GLOBALS ['we_doc']->ID . '&we_transaction=' . $_REQUEST ['we_transaction'] . '"+args+"");
      }
      
      function switchSearch(mode) {
        
        document.we_form.mode.value=mode;
        var defSearch = document.getElementById("defSearch");
        var advSearch = document.getElementById("advSearch");
        var advSearch2 = document.getElementById("advSearch2");
        var advSearch3 = document.getElementById("advSearch3");
        var scrollContent = document.getElementById("scrollContent_doclist");
        
        scrollheight = 30;
        
        var elem = document.getElementById("filterTable");
        newID = elem.rows.length-1;
                
        for(i=0;i<newID;i++) {
          scrollheight = scrollheight + 26;
        }

        if (mode==1) {
          scrollContent.style.height = (scrollContent.offsetHeight - scrollheight) +"px";
          defSearch.style.display = "none";
          advSearch.style.display = "block";
          advSearch2.style.display = "block";
          advSearch3.style.display = "block";
        }else {
          scrollContent.style.height = (scrollContent.offsetHeight + scrollheight) +"px";
          defSearch.style.display = "block";
          advSearch.style.display = "none";
          advSearch2.style.display = "none";
          advSearch3.style.display = "none";
        }
        
      }
      
      function openToEdit(tab,id,contentType){
        
        top.weEditorFrameController.openDocument(tab,id,contentType);
      
      }
        
      
      function setOrder(order){     
      
	      columns = new Array("Text", "SiteTitle", "CreationDate", "ModDate");
	      for(var i=0;i<columns.length;i++) {
	        if(order!=columns[i]) {
	          deleteArrow = document.getElementById(""+columns[i]+"");
	          deleteArrow.innerHTML = "";
	        }
	      }
	      arrow = document.getElementById(""+order+"");
	      foo = document.we_form.elements["order"].value;
	
	      if(order+" DESC"==foo){
	        document.we_form.elements["order"].value=order;
	        arrow.innerHTML = "<img border=\"0\" width=\"11\" height=\"8\" src=\"' . IMAGE_DIR . 'arrow_sort_asc.gif\" />";
	      }else{
	        document.we_form.elements["order"].value=order+" DESC";
	        arrow.innerHTML = "<img border=\"0\" width=\"11\" height=\"8\" src=\"' . IMAGE_DIR . 'arrow_sort_desc.gif\" />";
	      }
	      search(false);    
      }
      
      function setview(setView){
      
        document.we_form.setView.value=setView;
        
        search(false);

      }
      
      elem = null;
      
      function showImageDetails(picID){
        elem = document.getElementById(picID);
        elem.style.visibility = "visible";
          
      }
      
      function hideImageDetails(picID){
        elem = document.getElementById(picID);
        elem.style.visibility = "hidden";
        elem.style.left = "-9999px"; 
        
        ' . $showSelects . '
      }

      
      document.onmousemove = updateElem;

      function updateElem(e) {
        
        var h = window.innerHeight ? window.innerHeight : document.body.offsetHeight;
        var w = window.innerWidth ? window.innerWidth : document.body.offsetWidth;
        
        var x = (document.all) ? window.event.x + document.body.scrollLeft : e.pageX;
        var y = (document.all) ? window.event.y + document.body.scrollTop  : e.pageY;
        
        if (elem != null && elem.style.visibility == "visible") {
  
          elemWidth = elem.offsetWidth;
          elemHeight = elem.offsetHeight;
          elem.style.left = (x + 10) + "px";  
          elem.style.top = (y - 120) + "px";

          if((w-x)<400 && (h-y)<250) {  
            elem.style.left = (x - elemWidth - 10) + "px";  
            elem.style.top = (y - elemHeight - 10) + "px";
          }
          else if((w-x)<400) {
            elem.style.left = (x - elemWidth - 10) + "px";  
          }
          else if((h-y)<250) {  
            elem.style.top = (y - elemHeight - 10) + "px";
          }
          
          ' . $showHideSelects . '
          
        }
      }
      
      function absLeft(el) {
           return (el.offsetParent)? 
          el.offsetLeft+absLeft(el.offsetParent) : el.offsetLeft;
        }
    
       function absTop(el) {
          return (el.offsetParent)? 
        el.offsetTop+absTop(el.offsetParent) : el.offsetTop;
        }

      
      function sizeScrollContent() {
      
        var elem = document.getElementById("filterTable");
        newID = elem.rows.length-1;
        
        scrollheight = ' . $h . ';
        
        ' . $addinputRows . '
        
        var h = window.innerHeight ? window.innerHeight : document.body.offsetHeight;
        var scrollContent = document.getElementById("scrollContent_doclist");
        
        var height = ' . ($GLOBALS ['BROWSER'] == "IE" ? 200 : 180) . ';
        if((h - height)>0) {
          scrollContent.style.height=h - height;
        }
        if((scrollContent.offsetHeight - scrollheight)>0){
          scrollContent.style.height = (scrollContent.offsetHeight - scrollheight) +"px";
        }
      }
    
      function init() {
      
        sizeScrollContent();
        
      }
      
      function reload() {
      
        top.we_cmd("reload_editpage");
      
      }
            
      function next(anzahl){
        var scrollActive = document.getElementById("scrollActive");
   		if(scrollActive==null) {
          document.we_form.elements[\'searchstart\'].value = parseInt(document.we_form.elements[\'searchstart\'].value) + anzahl;
        
          search(false);
        }
      }
  
      function back(anzahl){
        var scrollActive = document.getElementById("scrollActive");
   		if(scrollActive==null) {
          document.we_form.elements[\'searchstart\'].value = parseInt(document.we_form.elements[\'searchstart\'].value) - anzahl;
      
          search(false);
        }
        
      }

      var rows = ' . (isset ( $_REQUEST ["searchFields"] ) ? count ( $_REQUEST ["searchFields"] ) - 1 : 0) . ';

      function newinput() {

        var searchFields = "' . str_replace ( "\n", "\\n", addslashes ( htmlSelect ( 'searchFields[__we_new_id__]', $GLOBALS ['we_doc']->searchclassFolder->getFields ( "__we_new_id__", "doclist" ), 1, "", false, 'class="defaultfont" id="searchFields[__we_new_id__]" onChange="changeit(this.value, __we_new_id__);" ' ) ) ) . '";
        var locationFields = "' . str_replace ( "\n", "\\n", addslashes ( htmlSelect ( 'location[__we_new_id__]', $GLOBALS ['we_doc']->searchclassFolder->getLocation (), 1, "", false, 'class="defaultfont" id="location[__we_new_id__]"  ' ) ) ) . '";
        var search = "' . addslashes ( htmlTextInput ( 'search[__we_new_id__]', 24, "", "", " class=\"wetextinput\" id=\"search[__we_new_id__]\" ", "text", 190 ) ) . '";
      
        var elem = document.getElementById("filterTable");
        newID = elem.rows.length-1;
        rows++;
        
        var scrollContent = document.getElementById("scrollContent_doclist");
        scrollContent.style.height = scrollContent.offsetHeight - 26 +"px";
        
        
        if(elem){
          var newRow = document.createElement("TR");
            newRow.setAttribute("id", "filterRow_" + rows);

            var cell = document.createElement("TD");
            cell.innerHTML=searchFields.replace(/__we_new_id__/g,rows)+"<input type=\"hidden\" value=\"\" name=\"hidden_searchFields["+rows+"]\"";
            newRow.appendChild(cell);

          cell = document.createElement("TD");
          cell.setAttribute("id", "td_location["+rows+"]");
            cell.innerHTML=locationFields.replace(/__we_new_id__/g,rows);
            newRow.appendChild(cell);
  
          cell = document.createElement("TD");
          cell.setAttribute("id", "td_search["+rows+"]");
            cell.innerHTML=search.replace(/__we_new_id__/g,rows);
            newRow.appendChild(cell);
  
            cell = document.createElement("TD");
            cell.setAttribute("id", "td_delButton["+rows+"]");
            cell.innerHTML=\'' . $we_button->create_button ( "image:btn_function_trash", "javascript:delRow('+rows+')" ) . '\';
            newRow.appendChild(cell);
            
          elem.appendChild(newRow);
        }
      }
      
      
      function changeit(value, rowNr){
      	var setValue = document.getElementsByName("search["+rowNr+"]")[0].value;
        var from = document.getElementsByName("hidden_searchFields["+rowNr+"]")[0].value;
        
        var searchFields = "' . str_replace ( "\n", "\\n", addslashes ( htmlSelect ( 'searchFields[__we_new_id__]', $GLOBALS ['we_doc']->searchclassFolder->getFields ( "__we_new_id__", "doclist" ), 1, "", false, 'class="defaultfont" id="searchFields[__we_new_id__]" onChange="changeit(this.value, __we_new_id__);" ' ) ) ) . '";
        var locationFields = "' . str_replace ( "\n", "\\n", addslashes ( htmlSelect ( 'location[__we_new_id__]', $GLOBALS ['we_doc']->searchclassFolder->getLocation (), 1, "", false, 'class="defaultfont" id="location[__we_new_id__]"  ' ) ) ) . '";
        var search = "' . addslashes ( htmlTextInput ( 'search[__we_new_id__]', 24, "", "", " class=\"wetextinput\" id=\"search[__we_new_id__]\" ", "text", 190 ) ) . '";
      
        var row = document.getElementById("filterRow_"+rowNr);
        var locationTD = document.getElementById("td_location["+rowNr+"]");    
        var searchTD = document.getElementById("td_search["+rowNr+"]");  
        var delButtonTD = document.getElementById("td_delButton["+rowNr+"]");  
        var location = document.getElementById("location["+rowNr+"]");  

        if(value=="Content") {
          if (locationTD!=null) {
            location.disabled = true;
          }
          row.removeChild(searchTD);
          
          if (delButtonTD!=null) {
            row.removeChild(delButtonTD);
          }
          cell = document.createElement("TD");
          cell.setAttribute("id", "td_search["+rowNr+"]");
            cell.innerHTML=search.replace(/__we_new_id__/g,rowNr);
            row.appendChild(cell);
            
            cell = document.createElement("TD");
            cell.setAttribute("id", "td_delButton["+rowNr+"]");
            cell.innerHTML=\'' . $we_button->create_button ( "image:btn_function_trash", "javascript:delRow('+rowNr+')" ) . '\';
            row.appendChild(cell);            
        }
        else if(value=="temp_category") {
          if (locationTD!=null) {
            location.disabled = true;
          }
          row.removeChild(searchTD);
                              
          var innerhtml= "<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\"><tbody><tr><td>\n"
              + "<input class=\"wetextinput\" name=\"search["+rowNr+"]\" size=\"58\" value=\"\"  id=\"search["+rowNr+"]\" readonly=\"1\" style=\"width: 190px;\" onblur=\"this.className=\'wetextinput\';\" onfocus=\"this.className=\'wetextinputselected\'\" type=\"text\">\n"
              + "</td><td><input value=\"\" name=\"searchParentID["+rowNr+"]\" type=\"hidden\"></td><td><img src=\"/webEdition/images/pixel.gif\" border=\"0\" height=\"4\" width=\"5\"></td><td>\n"
              + "<table title=\"' . $GLOBALS ['l_button'] ['select'] ['value'] . '\" class=\"weBtn\" style=\"width: 70px\" onmouseout=\"weButton.out(this);\" onmousedown=\"weButton.down(this);\" onmouseup=\"if(weButton.up(this)){we_cmd(\'openCatselector\',document.we_form.elements[\'searchParentID["+rowNr+"]\'].value,\'' . CATEGORY_TABLE . '\',\'document.we_form.elements[\\\\\'searchParentID["+rowNr+"]\\\\\'].value\',\'document.we_form.elements[\\\\\'search["+rowNr+"]\\\\\'].value\',\'\',\'\',\'0\',\'\',\'\');}\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\n" 
              + "<tbody><tr><td class=\"weBtnLeft\"></td><td class=\"weBtnMiddle\" style=\"width: 58px\" unselectable=\"on\">\n"
              + "' . $GLOBALS ['l_button'] ['select'] ['value'] . '\n"
              + "</td><td class=\"weBtnRight\"></td></tr></tbody></table></td></tr></tbody></table>\n";
              
              
          cell = document.createElement("TD");
          cell.setAttribute("id", "td_search["+rowNr+"]");
            cell.innerHTML=innerhtml;
            row.appendChild(cell);    
            
          if (delButtonTD!=null) {
            row.removeChild(delButtonTD);
          }
                    
          cell = document.createElement("TD");
            cell.setAttribute("id", "td_delButton["+rowNr+"]");
            cell.innerHTML=\'' . $we_button->create_button ( "image:btn_function_trash", "javascript:delRow('+rowNr+')" ) . '\';
            row.appendChild(cell);
        }
        else if(value=="temp_template_id" || value=="MasterTemplateID") {
          if (locationTD!=null) {
            location.disabled = true;
          }
          row.removeChild(searchTD);
                    
          var innerhtml= "<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\"><tbody><tr><td>\n"
              + "<input class=\"wetextinput\" name=\"search["+rowNr+"]\" size=\"58\" value=\"\"  id=\"search["+rowNr+"]\" readonly=\"1\" style=\"width: 190px;\" onblur=\"this.className=\'wetextinput\';\" onfocus=\"this.className=\'wetextinputselected\'\" type=\"text\">\n"
              + "</td><td><input value=\"\" name=\"searchParentID["+rowNr+"]\" type=\"hidden\"></td><td><img src=\"/webEdition/images/pixel.gif\" border=\"0\" height=\"4\" width=\"5\"></td><td>\n"
              + "<table title=\"' . $GLOBALS ['l_button'] ['select'] ['value'] . '\" class=\"weBtn\" style=\"width: 70px\" onmouseout=\"weButton.out(this);\" onmousedown=\"weButton.down(this);\" onmouseup=\"if(weButton.up(this)){we_cmd(\'openDocselector\',document.we_form.elements[\'searchParentID["+rowNr+"]\'].value,\'' . TEMPLATES_TABLE . '\',\'document.we_form.elements[\\\\\'searchParentID["+rowNr+"]\\\\\'].value\',\'document.we_form.elements[\\\\\'search["+rowNr+"]\\\\\'].value\',\'\',\'\',\'0\',\'\',\'\');}\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\n" 
              + "<tbody><tr><td class=\"weBtnLeft\"></td><td class=\"weBtnMiddle\" style=\"width: 58px\" unselectable=\"on\">\n"
              + "' . $GLOBALS ['l_button'] ['select'] ['value'] . '\n"
              + "</td><td class=\"weBtnRight\"></td></tr></tbody></table></td></tr></tbody></table>\n";
              
              
          cell = document.createElement("TD");
          cell.setAttribute("id", "td_search["+rowNr+"]");
            cell.innerHTML=innerhtml;
            row.appendChild(cell);    
            
          if (delButtonTD!=null) {
            row.removeChild(delButtonTD);
          }
                    
          cell = document.createElement("TD");
            cell.setAttribute("id", "td_delButton["+rowNr+"]");
            cell.innerHTML=\'' . $we_button->create_button ( "image:btn_function_trash", "javascript:delRow('+rowNr+')" ) . '\';
            row.appendChild(cell);
        }
        else if(value=="temp_doc_type") {
          if (locationTD!=null) {
            location.disabled = true;
          }
          row.removeChild(searchTD);
          if (delButtonTD!=null) {
            row.removeChild(delButtonTD);
          }
          
          search = "' . str_replace ( "\n", "\\n", addslashes ( htmlSelect ( 'search[__we_new_id__]', $GLOBALS ['we_doc']->searchclassFolder->getDoctypes (), 1, "", false, 'class="defaultfont" style="width:190px;" id="search[__we_new_id__]" ' ) ) ) . '";
          
          var cell = document.createElement("TD");
            cell.setAttribute("id", "td_search["+rowNr+"]");
            cell.innerHTML=search.replace(/__we_new_id__/g,rowNr);
          row.appendChild(cell);
          
          cell = document.createElement("TD");
            cell.setAttribute("id", "td_delButton["+rowNr+"]");
            cell.innerHTML=\'' . $we_button->create_button ( "image:btn_function_trash", "javascript:delRow('+rowNr+')" ) . '\';
            row.appendChild(cell);
          
        }
        else if(value=="Status") {
          if (locationTD!=null) {
            location.disabled = true;
          }
          row.removeChild(searchTD);
          if (delButtonTD!=null) {
            row.removeChild(delButtonTD);
          }
          
          search = "' . str_replace ( "\n", "\\n", addslashes ( htmlSelect ( 'search[__we_new_id__]', $GLOBALS ['we_doc']->searchclassFolder->getFieldsStatus (), 1, "", false, 'class="defaultfont" style="width:190px;" id="search[__we_new_id__]" ' ) ) ) . '";
          
          var cell = document.createElement("TD");
            cell.setAttribute("id", "td_search["+rowNr+"]");
            cell.innerHTML=search.replace(/__we_new_id__/g,rowNr);
          row.appendChild(cell);
          
          cell = document.createElement("TD");
            cell.setAttribute("id", "td_delButton["+rowNr+"]");
            cell.innerHTML=\'' . $we_button->create_button ( "image:btn_function_trash", "javascript:delRow('+rowNr+')" ) . '\';
            row.appendChild(cell);
          
        }
        else if(value=="Speicherart") {
          if (locationTD!=null) {
            location.disabled = true;
          }
          row.removeChild(searchTD);
          if (delButtonTD!=null) {
            row.removeChild(delButtonTD);
          }
          
          search = "' . str_replace ( "\n", "\\n", addslashes ( htmlSelect ( 'search[__we_new_id__]', $GLOBALS ['we_doc']->searchclassFolder->getFieldsSpeicherart (), 1, "", false, 'class="defaultfont" style="width:190px;" id="search[__we_new_id__]" ' ) ) ) . '";
          
          var cell = document.createElement("TD");
            cell.setAttribute("id", "td_search["+rowNr+"]");
            cell.innerHTML=search.replace(/__we_new_id__/g,rowNr);
          row.appendChild(cell);
        
          cell = document.createElement("TD");
            cell.setAttribute("id", "td_delButton["+rowNr+"]");
            cell.innerHTML=\'' . $we_button->create_button ( "image:btn_function_trash", "javascript:delRow('+rowNr+')" ) . '\';
            row.appendChild(cell);
        
        }
        else if(value=="Published" || value=="CreationDate" || value=="ModDate") {

          row.removeChild(locationTD);
          
          locationFields = "' . str_replace ( "\n", "\\n", addslashes ( htmlSelect ( 'location[__we_new_id__]', $GLOBALS ['we_doc']->searchclassFolder->getLocation ( "date" ), 1, "", false, 'class="defaultfont" id="location[__we_new_id__]"  ' ) ) ) . '";
          
          var cell = document.createElement("TD");
            cell.setAttribute("id", "td_location["+rowNr+"]");
            cell.innerHTML=locationFields.replace(/__we_new_id__/g,rowNr);
          row.appendChild(cell);
          
          row.removeChild(searchTD);
          
          var innerhtml= "<table id=\"search["+rowNr+"]_cell\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\"><tbody><tr><td></td><td></td><td>\n"
              + "<input class=\"wetextinput\" name=\"search["+rowNr+"]\" size=\"55\" value=\"\" maxlength=\"10\" id=\"search["+rowNr+"]\" readonly=\"1\" style=\"width: 100px; \" onblur=\"this.className=\'wetextinput\';\" onfocus=\"this.className=\'wetextinputselected\'\" type=\"text\">\n"
              + "</td><td>&nbsp;</td><td><a href=\"#\">\n"
              + "<table id=\"date_picker_from"+rowNr+"\" class=\"weBtn\" onmouseout=\"weButton.out(this);\" onmousedown=\"weButton.down(this);\" onmouseup=\"if(weButton.up(this)){;}\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\n" 
              + "<tbody><tr><td class=\"weBtnLeft\"></td><td class=\"weBtnMiddle\" unselectable=\"on\">\n"
              + "<img src=\"/webEdition/images/button/icons/date_picker.gif\" class=\"weBtnImage\">\n"
              + "</td><td class=\"weBtnRight\"></td></tr></tbody></table></a></td></tr></tbody></table>\n";
              
              
          cell = document.createElement("TD");
          cell.setAttribute("id", "td_search["+rowNr+"]");
            cell.innerHTML=innerhtml;
            row.appendChild(cell);    
            
            Calendar.setup({inputField:"search["+rowNr+"]",ifFormat:"%d.%m.%Y",button:"date_picker_from"+rowNr+"",align:"Tl",singleClick:true});
          
          if (delButtonTD!=null) {
            row.removeChild(delButtonTD);
          }
                    
          cell = document.createElement("TD");
            cell.setAttribute("id", "td_delButton["+rowNr+"]");
            cell.innerHTML=\'' . $we_button->create_button ( "image:btn_function_trash", "javascript:delRow('+rowNr+')" ) . '\';
            row.appendChild(cell);
          
        }
        else {
          row.removeChild(searchTD);
          
          if (locationTD!=null) {
            row.removeChild(locationTD);
          }
          if (delButtonTD!=null) {
            row.removeChild(delButtonTD);
          }

          var cell = document.createElement("TD");
            cell.setAttribute("id", "td_location["+rowNr+"]");
            cell.innerHTML=locationFields.replace(/__we_new_id__/g,rowNr);
			row.appendChild(cell);
      
          var cell = document.createElement("TD");
            cell.setAttribute("id", "td_search["+rowNr+"]");
            cell.innerHTML=search.replace(/__we_new_id__/g,rowNr);
          row.appendChild(cell);
        
          cell = document.createElement("TD");
            cell.setAttribute("id", "td_delButton["+rowNr+"]");
            cell.innerHTML=\'' . $we_button->create_button ( "image:btn_function_trash", "javascript:delRow('+rowNr+')" ) . '\';
            row.appendChild(cell);   
        }
        if(from=="temp_template_id" || from=="ContentType" || from=="temp_doc_type" || from=="temp_category" || from=="Status" || from=="Speicherart" || from=="Published" || from=="CreationDate" || from=="ModDate" 
           || value=="temp_template_id" || value=="ContentType" || value=="temp_doc_type" || value=="temp_category" || value=="Status" || value=="Speicherart" || value=="Published" || value=="CreationDate" || value=="ModDate") {
        	document.getElementById("search["+rowNr+"]").value = "";
		}
		else {
		    document.getElementById("search["+rowNr+"]").value = setValue;
		}
       
        document.getElementsByName("hidden_searchFields["+rowNr+"]")[0].value = value;
        
      }
      
      function checkAllPubChecks() {
			
		var checkAll = document.getElementsByName("publish_all");
		var checkboxes = document.getElementsByName("publish_docs_doclist");
		var check = false;

		if(checkAll[0].checked) {
			check = true;
		}
		for(var i = 0; i < checkboxes.length; i++) {
			checkboxes[i].checked = check;
		}
		
	}
	
	function publishDocs() {
	
		var checkAll = document.getElementsByName("publish_all");
		var checkboxes = document.getElementsByName("publish_docs_doclist");
		var check = false;
		
		for(var i = 0; i < checkboxes.length; i++) {
			if(checkboxes[i].checked) {
				check = true;
				break;
			}
		}
		
		if(checkboxes.length==0) {
			check = false;
		}
		
		if(check==false) {
			' . we_message_reporting::getShowMessageCall($GLOBALS['l_weSearch']['notChecked'], WE_MESSAGE_NOTICE) . '
		}
		else {
	
			Check = confirm("'.$GLOBALS['l_weSearch']['publish_docs'].'");
				if (Check == true) {	
					publishDocsAjax();
				}
		}
	}
	
	 var ajaxCallbackPublishDocs = {
	    success: function(o) {
	    
	     	// reload current document => reload all open Editors on demand

			var _usedEditors =  top.weEditorFrameController.getEditorsInUse();
			for (frameId in _usedEditors) {

				if ( _usedEditors[frameId].getEditorIsActive() ) { // reload active editor
					_usedEditors[frameId].setEditorReloadAllNeeded(true);
					_usedEditors[frameId].setEditorIsActive(true);

				} else {
					_usedEditors[frameId].setEditorReloadAllNeeded(true);
				}
			}
			_multiEditorreload = true;

			//reload tree
			top.we_cmd("load", top.treeData.table ,0);
			document.getElementById("resetBusy").innerHTML = "";
	     	' . we_message_reporting::getShowMessageCall($GLOBALS['l_weSearch']['publishOK'], WE_MESSAGE_NOTICE) . '
	     
	    },
	    failure: function(o) {
	     alert("Failure");
	    }
	 }
	
	function publishDocsAjax() {
				
		var args = "";
		var check = "";
		var checkboxes = document.getElementsByName("publish_docs_doclist");
		for(var i = 0; i < checkboxes.length; i++) {
			if(checkboxes[i].checked) {
		    	if(check!="") check += ",";
		    	check += checkboxes[i].value;
			}
		}
		args += "&we_cmd[0]="+escape(check);
		var scroll = document.getElementById("resetBusy");
		scroll.innerHTML = "<table border=\'0\' width=\'100%\' height=\'100%\'><tr><td align=\'center\'><img src=' . IMAGE_DIR . 'logo-busy.gif /></td></tr></table>";  

		YAHOO.util.Connect.asyncRequest("POST", ajaxURL, ajaxCallbackPublishDocs, "protocol=json&cns=tools/weSearch&cmd=PublishDocs&"+args+"");
		
	}
      
      function calendarSetup(x){
        for(i=0;i<x;i++) {
          if(document.getElementById("date_picker_from"+i+"") != null) {
            Calendar.setup({inputField:"search["+i+"]",ifFormat:"%d.%m.%Y",button:"date_picker_from"+i+"",align:"Tl",singleClick:true});
          }
        }
      }
  
      function delRow(id) {
      
        var scrollContent = document.getElementById("scrollContent_doclist");
        scrollContent.style.height = scrollContent.offsetHeight + 26 +"px";
      
        var elem = document.getElementById("filterTable");
        if(elem){
          trows = elem.rows;
          rowID = "filterRow_" + id;
  
              for (i=0;i<trows.length;i++) {
                if(rowID == trows[i].id) {
                  elem.deleteRow(i);
                }
              }
        }
        
      }
      
    ' );
		
		return $_js;
	}
	
	/**
	 * @abstract create search dialog-box
	 * @return html for search dialog box
	 */
	function getSearchDialog() {
		$we_button = new we_button ( );
		$out = '<table cellpadding="0" cellspacing="0" id="defSearch" border="0" width="550" style="margin-left:20px;display:' . ($GLOBALS ['we_doc']->searchclassFolder->mode ? 'none' : 'block') . ';">
        <tr>
        <td class="weDocListSearchHeadline">' . $GLOBALS ['l_weSearch'] ["suchen"] . '
        </td>
        <td>' . getPixel ( 10, 2 ) . '
        </td>
        <td>' . getPixel ( 40, 2 ) . '' . $we_button->create_button ( "image:btn_direction_right", "javascript:switchSearch(1)", false ) . '</td>
        <td width="100%">' . getPixel ( 10, 2 ) . '
        </td>
        </tr>
        </table>';
		
		$out .= '<table cellpadding="0" cellspacing="0" border="0" id="advSearch" width="550" style="margin-left:20px;display:' . ($GLOBALS ['we_doc']->searchclassFolder->mode ? 'block' : 'none') . ';">
        <tr>
        <td class="weDocListSearchHeadline">' . $GLOBALS ['l_weSearch'] ["suchen"] . '
        </td>
        <td>' . getPixel ( 10, 2 ) . '
        </td>
        <td>' . getPixel ( 40, 2 ) . '' . $we_button->create_button ( "image:btn_direction_down", "javascript:switchSearch(0)", false ) . '</td>
        <td width="100%">' . getPixel ( 10, 2 ) . '
        </td>
        </tr>
        </table>';
		
		$out .= '<table cellpadding="2" cellspacing="0"  id="advSearch2" border="0" style="margin-left:20px;display:' . ($GLOBALS ['we_doc']->searchclassFolder->mode ? 'block' : 'none') . ';">
        <tbody id="filterTable">
        <tr>
          <td>' . $GLOBALS ['we_doc']->HiddenTrans () . '</td>
        </tr>';
		
		$r = array ( );
		$r2 = array ( );
		$r3 = array ( );
		if (isset ( $GLOBALS ['we_doc']->searchclassFolder->search ) && is_array ( $GLOBALS ['we_doc']->searchclassFolder->search )) {
			foreach ( $GLOBALS ['we_doc']->searchclassFolder->search as $k => $v ) {
				$r [] = $GLOBALS ['we_doc']->searchclassFolder->search [$k];
			}
		}
		if (isset ( $GLOBALS ['we_doc']->searchclassFolder->searchFields ) && is_array ( $GLOBALS ['we_doc']->searchclassFolder->search )) {
			foreach ( $GLOBALS ['we_doc']->searchclassFolder->searchFields as $k => $v ) {
				$r2 [] = $GLOBALS ['we_doc']->searchclassFolder->searchFields [$k];
			}
		}
		if (isset ( $_REQUEST ['location'] ) && is_array ( $_REQUEST ['location'] )) {
			$m = 0;
			foreach ( $_REQUEST ['searchFields'] as $k => $v ) {
				if (isset ( $_REQUEST ['location'] [$k] )) {
					$r3 [$m] = $_REQUEST ['location'] [$k];
				} else {
					$r3 [$m] = "disabled";
				}
				$m ++;
			}
		}
		
		$GLOBALS ['we_doc']->searchclassFolder->search = $r;
		$GLOBALS ['we_doc']->searchclassFolder->searchFields = $r2;
		$GLOBALS ['we_doc']->searchclassFolder->location = $r3;
		
		for($i = 0; $i < $GLOBALS ['we_doc']->searchclassFolder->height; $i ++) {
			$button = $we_button->create_button ( "image:btn_function_trash", "javascript:delRow(" . $i . ");", true, "", "", "", "", false );
			
			$locationDisabled = "";
			$handle = "";
			
			$searchInput = htmlTextInput ( "search[" . $i . "]", 30, (isset ( $GLOBALS ['we_doc']->searchclassFolder->search ) && is_array ( $GLOBALS ['we_doc']->searchclassFolder->search ) && isset ( $GLOBALS ['we_doc']->searchclassFolder->search [$i] ) ? $GLOBALS ['we_doc']->searchclassFolder->search [$i] : ''), "", " class=\"wetextinput\"  id=\"search['.$i.']\" ", "text", 190 );
			
			if (isset ( $GLOBALS ['we_doc']->searchclassFolder->searchFields [$i] ) && ($GLOBALS ['we_doc']->searchclassFolder->searchFields [$i] == "Content" || $GLOBALS ['we_doc']->searchclassFolder->searchFields [$i] == "Status" || $GLOBALS ['we_doc']->searchclassFolder->searchFields [$i] == "Speicherart" || $GLOBALS ['we_doc']->searchclassFolder->searchFields [$i] == "temp_template_id" || $GLOBALS ['we_doc']->searchclassFolder->searchFields [$i] == "temp_doc_type" || $GLOBALS ['we_doc']->searchclassFolder->searchFields [$i] == "temp_category")) {
				$locationDisabled = "disabled";
			}
			
			if (isset ( $GLOBALS ['we_doc']->searchclassFolder->searchFields [$i] )) {
				if ($GLOBALS ['we_doc']->searchclassFolder->searchFields [$i] == "Status") {
					$searchInput = htmlSelect ( "search[" . $i . "]", $GLOBALS ['we_doc']->searchclassFolder->getFieldsStatus (), 1, (isset ( $GLOBALS ['we_doc']->searchclassFolder->search ) && is_array ( $GLOBALS ['we_doc']->searchclassFolder->search ) && isset ( $GLOBALS ['we_doc']->searchclassFolder->search [$i] ) ? $GLOBALS ['we_doc']->searchclassFolder->search [$i] : ""), false, 'class="defaultfont" style="width:190px;" id="search[' . $i . ']" ' );
				}
				if ($GLOBALS ['we_doc']->searchclassFolder->searchFields [$i] == "Speicherart") {
					$searchInput = htmlSelect ( "search[" . $i . "]", $GLOBALS ['we_doc']->searchclassFolder->getFieldsSpeicherart (), 1, (isset ( $GLOBALS ['we_doc']->searchclassFolder->search ) && is_array ( $GLOBALS ['we_doc']->searchclassFolder->search ) && isset ( $GLOBALS ['we_doc']->searchclassFolder->search [$i] ) ? $GLOBALS ['we_doc']->searchclassFolder->search [$i] : ""), false, 'class="defaultfont" style="width:190px;" id="search[' . $i . ']" ' );
				}
				if ($GLOBALS ['we_doc']->searchclassFolder->searchFields [$i] == "Published" || $GLOBALS ['we_doc']->searchclassFolder->searchFields [$i] == "CreationDate" || $GLOBALS ['we_doc']->searchclassFolder->searchFields [$i] == "ModDate") {
					$handle = "date";
					$searchInput = $this->getDateSelector ( "", "search[" . $i . "]", "_from" . $i, $GLOBALS ['we_doc']->searchclassFolder->search [$i] );
				}
				if ($GLOBALS ['we_doc']->searchclassFolder->searchFields [$i] == "temp_doc_type") {
					$searchInput = htmlSelect ( "search[" . $i . "]", $GLOBALS ['we_doc']->searchclassFolder->getDocTypes (), 1, (isset ( $GLOBALS ['we_doc']->searchclassFolder->search ) && is_array ( $GLOBALS ['we_doc']->searchclassFolder->search ) && isset ( $GLOBALS ['we_doc']->searchclassFolder->search [$i] ) ? $GLOBALS ['we_doc']->searchclassFolder->search [$i] : ""), false, 'class="defaultfont" style="width:190px;" id="search[' . $i . ']" ' );
				}
				
				if ($GLOBALS ['we_doc']->searchclassFolder->searchFields [$i] == "MasterTemplateID" || $GLOBALS ['we_doc']->searchclassFolder->searchFields [$i] == "temp_template_id") {
					$_linkPath = $GLOBALS ['we_doc']->searchclassFolder->search [$i];
					
					$_rootDirID = 0;
					$_cmd = "javascript:we_cmd('openDocselector',document.we_form.elements['searchParentID[" . $i . "]'].value,'" . TEMPLATES_TABLE . "','document.we_form.elements[\\'searchParentID[" . $i . "]\\'].value','document.we_form.elements[\\'search[" . $i . "]\\'].value','','" . session_id () . "','$_rootDirID','','text/weTmpl')";
					$_button = $we_button->create_button ( 'select', $_cmd, true, 70, 22, '', '', false );
					$selector = htmlFormElementTable ( htmlTextInput ( 'search[' . $i . ']', 58, $_linkPath, '', 'readonly ', 'text', 190, 0 ), '', 'left', 'defaultfont', we_htmlElement::htmlHidden ( array ('name' => 'searchParentID[' . $i . ']', "value" => "" ) ), getPixel ( 5, 4 ), $_button );
					
					$searchInput = $selector;
				}
				if ($GLOBALS ['we_doc']->searchclassFolder->searchFields [$i] == "temp_category") {
					$_linkPath = $GLOBALS ['we_doc']->searchclassFolder->search [$i];
					
					$_rootDirID = 0;
					
					$_cmd = "javascript:we_cmd('openCatselector',document.we_form.elements['searchParentID[" . $i . "]'].value,'" . CATEGORY_TABLE . "','document.we_form.elements[\\'searchParentID[" . $i . "]\\'].value','document.we_form.elements[\\'search[" . $i . "]\\'].value','','" . session_id () . "','$_rootDirID','','')";
					$_button = $we_button->create_button ( 'select', $_cmd, true, 70, 22, '', '', false );
					$selector = htmlFormElementTable ( htmlTextInput ( 'search[' . $i . ']', 58, $_linkPath, '', 'readonly', 'text', 190, 0 ), '', 'left', 'defaultfont', we_htmlElement::htmlHidden ( array ('name' => 'searchParentID[' . $i . ']', "value" => "" ) ), getPixel ( 5, 4 ), $_button );
					
					$searchInput = $selector;
				}
			}
			
			$out .= '
        <tr id="filterRow_' . $i . '">
          <td>'.hidden ( "hidden_searchFields[" . $i . "]", isset($GLOBALS ['we_doc']->searchclassFolder->searchFields[$i]) ? $GLOBALS ['we_doc']->searchclassFolder->searchFields[$i] : "" ).'' . htmlSelect ( "searchFields[" . $i . "]", $GLOBALS ['we_doc']->searchclassFolder->getFields ( $i, "doclist" ), 1, (isset ( $GLOBALS ['we_doc']->searchclassFolder->searchFields ) && is_array ( $GLOBALS ['we_doc']->searchclassFolder->searchFields ) && isset ( $GLOBALS ['we_doc']->searchclassFolder->searchFields [$i] ) ? $GLOBALS ['we_doc']->searchclassFolder->searchFields [$i] : ""), false, 'class="defaultfont" id="searchFields[' . $i . ']" onChange="changeit(this.value, ' . $i . ');" ' ) . '</td>
          <td id="td_location[' . $i . ']">' . htmlSelect ( "location[" . $i . "]", $GLOBALS ['we_doc']->searchclassFolder->getLocation ( $handle ), 1, (isset ( $GLOBALS ['we_doc']->searchclassFolder->location ) && is_array ( $GLOBALS ['we_doc']->searchclassFolder->location ) && isset ( $GLOBALS ['we_doc']->searchclassFolder->location [$i] ) ? $GLOBALS ['we_doc']->searchclassFolder->location [$i] : ""), false, 'class="defaultfont" ' . $locationDisabled . ' id="location[' . $i . ']" ' ) . '</td>
          <td id="td_search[' . $i . ']">' . $searchInput . '</td>
          <td id="td_delButton[' . $i . ']">' . $button . '</td>
        </tr>
        ';
		}
		
		$out .= '</tbody></table>';
		
		$out .= '<table cellpadding="0" cellspacing="0" id="advSearch3" border="0" style="margin-left:20px;display:' . ($GLOBALS ['we_doc']->searchclassFolder->mode ? 'block' : 'none') . ';">
        <tr>
          <td colspan="4">' . getPixel ( 20, 10 ) . '</td>
        </tr>
        <tr>
          <td width="215">' . $we_button->create_button ( "add", "javascript:newinput();" ) . '</td>
          <td width="155"></td>
          <td width="188" align="right">' . $we_button->create_button ( "search", "javascript:search(true);" ) . '</td>
          <td></td>
        </tr>
      
        </table>';
		
		$out .= we_htmlElement::jsElement ( "calendarSetup(" . $GLOBALS ['we_doc']->searchclassFolder->height . ");" );
		
		return $out;
	}
	
	/**
	 * @abstract executes the search and writes the result into arrays
	 * @return array with search results
	 */
	function searchProperties() {
		
		$DB_WE = new DB_WE ( );
		$content = array ( );
		$foundItems = 0;
		$_result = array ( );
		$saveArrayIds = array ( );
		$searchText = array ( );
		$_SESSION ['weSearch'] ['foundItems'] = 0;
		
		foreach ( $_REQUEST ['we_cmd'] as $k => $v ) {
			if (stristr ( $k, 'searchFields[' ) && !stristr ( $k, 'hidden_' )) {
				$_REQUEST ['we_cmd'] ['searchFields'] [] = $v;
			}
			if (stristr ( $k, 'location[' )) {
				$_REQUEST ['we_cmd'] ['location'] [] = $v;
			}
			if (stristr ( $k, 'search[' )) {
				$_REQUEST ['we_cmd'] ['search'] [] = $v;
			}
		}
		
		if (isset ( $_REQUEST ["we_cmd"] ['obj'] )) {
			$obj = $_REQUEST ["we_cmd"] ['obj'];
			$thisObj = new doclistView ( );
		} else {
			$obj = $GLOBALS ['we_doc'];
			$thisObj = $this;
		}
		
		if (isset ( $_REQUEST ["searchstart"] )) {
			$obj->searchclassFolder->searchstart = $_REQUEST ["searchstart"];
		}
		
		$_table = FILE_TABLE;
		
		if (isset ( $_REQUEST ["we_cmd"] ['searchFields'] )) {
			$searchFields = $_REQUEST ["we_cmd"] ['searchFields'];
		} else {
			$searchFields = $obj->searchclassFolder->searchFields;
		}
		if (isset ( $_REQUEST ["we_cmd"] ['search'] )) {
			$searchText = $_REQUEST ["we_cmd"] ['search'];
		} else {
			$searchText = $obj->searchclassFolder->search;
		}
		if (isset ( $_REQUEST ["we_cmd"] ['location'] )) {
			$location = $_REQUEST ["we_cmd"] ['location'];
		} else {
			$location = $obj->searchclassFolder->location;
		}
		if (isset ( $_REQUEST ["we_cmd"] ['order'] )) {
			$_order = $_REQUEST ["we_cmd"] ['order'];
		} else {
			$_order = $obj->searchclassFolder->order;
		}
		if (isset ( $_REQUEST ["we_cmd"] ['setView'] )) {
			$_view = $_REQUEST ["we_cmd"] ['setView'];
		} else {
			$_view = $obj->searchclassFolder->setView;
		}
		if (isset ( $_REQUEST ["we_cmd"] ['searchstart'] )) {
			$_searchstart = $_REQUEST ["we_cmd"] ['searchstart'];
		} else {
			$_searchstart = $obj->searchclassFolder->searchstart;
		}
		if (isset ( $_REQUEST ["we_cmd"] ['anzahl'] )) {
			$_anzahl = $_REQUEST ["we_cmd"] ['anzahl'];
		} else {
			$_anzahl = $obj->searchclassFolder->anzahl;
		}
		
		for($i = 0; $i < count ( $searchText ); $i ++) {
			if (isset ( $searchText [$i] )) {
				$searchText [$i] = trim ( $searchText [$i] );
			}
		}
		
		$where = "";
		$op = " AND ";
		$obj->searchclassFolder->settable ( $_table );
		
		
		if(searchtoolsearch::checkRightTempTable()=="1" && searchtoolsearch::checkRightDropTable()=="1") {
			print we_htmlElement::jsElement(
   				we_message_reporting::getShowMessageCall ( $GLOBALS ["l_weSearch"] ["noTempTableRightsDoclist"], WE_MESSAGE_NOTICE )   
			);
		}
		else {
					
				
			if ($obj->ID != 0) {
				
				
				$obj->searchclassFolder->createTempTable ();
				
				for($i = 0; $i < count ( $searchFields ); $i ++) {
					
					$w = "";
					if (isset ( $searchText [0] )) {
						if (isset ( $searchText [$i] )) {
							$searchString = $searchText [$i];
						} else {
							$searchString = $searchText [0];
						}
					}
					if (isset ( $searchString ) && $searchString != "") {
						
						
						if (($searchFields [$i] == "Text" || ($searchFields [$i] != "Content" && $searchFields [$i] != "Status" && $searchFields [$i] != "Speicherart" && $searchFields [$i] != "CreatorName" && $searchFields [$i] != "WebUserName" && $searchFields [$i] != "temp_category"))) {
						 if(isset( $searchFields [$i]) && isset($location [$i])) {     	
							$where .= $obj->searchclassFolder->searchfor ( $searchString, $searchFields [$i], $location [$i], $_table );
						  }
						}
						
						if ($searchFields [$i] == "Content") {
							$w = $obj->searchclassFolder->searchContent ( $searchString, $_table );
							if ($where == "" && $w == "") {
								$where .= " AND 0";
							} elseif ($where == "" && $w != "") {
								$where .= " AND " . $w;
							} elseif($w!="") {
								$where .= $op . " " . $w;
							}
						}
						
						if ($searchFields [$i] == "Title") {
							$w = $obj->searchclassFolder->searchInTitle ( $searchString, $_table );
							if ($where == "" && $w == "") {
								$where .= " AND 0";
							} elseif ($where == "" && $w != "") {
								$where .= " AND " . $w;
							} elseif($w!="") {
								$where .= $op . " " . $w;
							}
						}
						
						if ($searchString != "" && ($searchFields [$i] == "Status" || $searchFields [$i] == "Speicherart")) {
							if ($_table == FILE_TABLE) {
								$w = $obj->searchclassFolder->getStatusFiles ( $searchString, $_table );
								$where .= $w;
							}
						}
						
						if ($searchString != "" && ($searchFields [$i] == "CreatorName" || $searchFields [$i] == "WebUserName")) {
							$w = $obj->searchclassFolder->searchSpecial ( $searchString, $_table, $searchFields [$i], $location [$i] );
							$where .= $w;
						}
						
						if ($searchFields [$i] == "temp_category") {
							$w = $obj->searchclassFolder->searchCategory ( $searchString, $_table, $searchFields [$i] );
							$where .= $w;
						}
					}
				}
				
				$where .= $obj->searchclassFolder->ofFolderOnly ( $obj->ID );
				
				if ($where != "") {
					$whereQuery = "1 " . $where . "";
					
					if($_table==FILE_TABLE) {
						$whereQuery .= " AND ((RestrictOwners='0' OR RestrictOwners= '".$_SESSION["user"]["ID"]."') OR (Owners LIKE '%,".$_SESSION["user"]["ID"].",%'))";
					}
					
					if(defined("OBJECT_FILES_TABLE")) {
						if($_table==OBJECT_FILES_TABLE) {
							$whereQuery .= " AND ((RestrictOwners='0' OR RestrictOwners= '".$_SESSION["user"]["ID"]."') OR (Owners LIKE '%,".$_SESSION["user"]["ID"].",%'))";
						}
					}
					if(defined("OBJECT_TABLE")) {
						if($_table==OBJECT_TABLE) {
							$whereQuery .= "AND ((RestrictUsers='0' OR RestrictUsers= '".$_SESSION["user"]["ID"]."') OR (Users LIKE '%,".$_SESSION["user"]["ID"].",%')) ";
						}
					}

					$obj->searchclassFolder->setwhere ( $whereQuery );
						
					$obj->searchclassFolder->insertInTempTable ( $whereQuery, $_table );
					
					$foundItems = $obj->searchclassFolder->countitems ( $whereQuery, $_table );
						
					$_SESSION ['weSearch'] ['foundItems'] = $foundItems;
									
					$obj->searchclassFolder->selectFromTempTable ( $_searchstart, $_anzahl, $_order );
					
					while ( $obj->searchclassFolder->next_record () ) {
						if (! isset ( $saveArrayIds [$obj->searchclassFolder->Record ['ContentType']] [$obj->searchclassFolder->Record ['ID']] )) {
							$saveArrayIds [$obj->searchclassFolder->Record ['ContentType']] [$obj->searchclassFolder->Record ['ID']] = $obj->searchclassFolder->Record ['ID'];
							$_result [] = array_merge ( array ('Table' => $_table ), $obj->searchclassFolder->Record );
						}
					}
				}
			}
		}

		if ($_SESSION ['weSearch'] ['foundItems'] > 0) {

			$_db2 = new DB_WE ( );
			
			$q = "DROP TABLE IF EXISTS `" . SEARCH_TEMP_TABLE . "`";
			$_db2->query ( $q );
			
			
			foreach ( $_result as $k => $v ) {
				$_result [$k] ["Description"] = "";
				if ($_result [$k] ["Table"] == FILE_TABLE && $_result [$k] ['Published'] >= $_result [$k] ['ModDate'] && $_result [$k] ['Published'] != 0) {
					$DB_WE->query ( "SELECT a.ID, c.Dat FROM (" . FILE_TABLE . " a LEFT JOIN " . LINK_TABLE . " b ON (a.ID=b.DID)) LEFT JOIN " . CONTENT_TABLE . " c ON (b.CID=c.ID) WHERE a.ID='" . $_result [$k] ["ID"] . "' AND b.Name='Description' AND b.DocumentTable='" . FILE_TABLE . "'" );
					while ( $DB_WE->next_record () ) {
						$_result [$k] ["Description"] = $DB_WE->f ( 'Dat' );
					}
				} else {
					$query2 = "SELECT DocumentObject  FROM " . TEMPORARY_DOC_TABLE . " WHERE DocumentID = '" . $_result [$k] ["ID"] . "' AND DocTable = '" . FILE_TABLE . "' AND Active = '1'";
					$_db2->query ( $query2 );
					while ( $_db2->next_record () ) {
						$tempDoc = unserialize ( $_db2->f ( 'DocumentObject' ) );
						if (isset ( $tempDoc [0] ['elements'] ['Description'] ) && $tempDoc [0] ['elements'] ['Description'] ['dat'] != "") {
							$_result [$k] ["Description"] = $tempDoc [0] ['elements'] ['Description'] ['dat'];
						}
					}
				}
			}
		
			
			$content = $thisObj->makeContent ( $_result, $_view );
		}
		
		return $content;
	}
	
	function makeHeadLines() {
		$headline [0] ["dat"] = '<a href="javascript:setOrder(\'Text\');">' . $GLOBALS ['l_weSearch'] ['dateiname'] . '</a> <span id="Text" >' . $this->getSortImage ( 'Text' ) . '</span>';
		$headline [1] ["dat"] = '<a href="javascript:setOrder(\'SiteTitle\');">' . $GLOBALS ['l_weSearch'] ['seitentitel'] . '</a> <span id="SiteTitle" >' . $this->getSortImage ( 'SiteTitle' ) . '</span>';
		$headline [2] ["dat"] = '<a href="javascript:setOrder(\'CreationDate\');">' . $GLOBALS ['l_weSearch'] ['created'] . '</a> <span id="CreationDate" >' . $this->getSortImage ( 'CreationDate' ) . '</span>';
		$headline [3] ["dat"] = '<a href="javascript:setOrder(\'ModDate\');">' . $GLOBALS ['l_weSearch'] ['modified'] . '</a> <span id="ModDate" >' . $this->getSortImage ( 'ModDate' ) . '</span>';
		
		return $headline;
	}
	
	function getSortImage($for) {
		if (isset ( $_REQUEST ['order'] )) {
			$order = $_REQUEST ['order'];
		} else {
			$order = $GLOBALS ['we_doc']->searchclassFolder->order;
		}
		if (strpos ( $order, $for ) === 0) {
			if (strpos ( $order, 'DESC' )) {
				return '<img border="0" width="11" height="8" src="' . IMAGE_DIR . 'arrow_sort_desc.gif" />';
			}
			return '<img border="0" width="11" height="8" src="' . IMAGE_DIR . 'arrow_sort_asc.gif" />';
		}
		return getPixel ( 11, 8 );
	}
	
	function makeContent($_result, $view) {
		$DB_WE = new DB_WE ( );
		
		$we_PathLength = 30;
		
		$resultCount = count ( $_result );
		
		for($f = 0; $f < $resultCount; $f ++) {
			$fontColor = "black";
			if (isset ( $_result [$f] ["Published"] )) {
				$published = ((($_result [$f] ["Published"] != 0) && ($_result [$f] ["Published"] < $_result [$f] ["ModDate"]) && ($_result [$f] ["ContentType"] == "text/html" || $_result [$f] ["ContentType"] == "text/webedition" || $_result [$f] ["ContentType"] == "objectFile")) ? - 1 : $_result [$f] ["Published"]);
				
				if ($_result [$f] ["ContentType"] != "folder") {
					if ($published == 0) {
						$fontColor = "red";
					} elseif ($published == - 1) {
						$fontColor = "#3366CC";
					}
				}
			}
			$ext = isset ( $_result [$f] ["Extension"] ) ? $_result [$f] ["Extension"] : "";
			$Icon = isset ( $GLOBALS ["WE_CONTENT_TYPES"] [$_result [$f] ["ContentType"]] ) ? we_getIcon ( $_result [$f] ["ContentType"], $ext ) : "link.gif";
			
			if ($view == 0) {
				$publishCheckbox = (($_result[$f]["ContentType"]=="text/webedition" || $_result[$f]["ContentType"]=="text/html" || $_result[$f]["ContentType"]=="objectFile") && we_hasPerm('PUBLISH')) ? we_forms::checkbox($_result[$f]["docID"]."_".$_result[$f]["docTable"], 0, "publish_docs_doclist", "", false, "middlefont", "") : getPixel(20,10);
	            
				$content [$f] [0] ["dat"] = $publishCheckbox;
				$content [$f] [1] ["dat"] = '<img src="' . ICON_DIR . $Icon . '" border="0" width="16" height="18" />';
				$content [$f] [2] ["dat"] = '<a href="javascript:openToEdit(\'' . $_result [$f] ["docTable"] . '\',\'' . $_result [$f] ["docID"] . '\',\'' . $_result [$f] ["ContentType"] . '\')" style="text-decoration:none;color:' . $fontColor . ';" class="middlefont" title="' . $_result [$f] ["Text"] . '"><u>' . shortenPath ( $_result [$f] ["Text"], $we_PathLength );
				//$content[$f][2]["dat"] = '<nobr>'. $GLOBALS['l_contentTypes'][$_result[$f]['ContentType']] .'</nobr>';
				$content [$f] [3] ["dat"] = '<nobr>' . shortenPath ( $_result [$f] ["SiteTitle"], $we_PathLength ) . '</nobr>';
				$content [$f] [4] ["dat"] = '<nobr>' . ($_result [$f] ["CreationDate"] ? date ( $GLOBALS ['l_weSearch'] ["date_format"], $_result [$f] ["CreationDate"] ) : "-") . '</nobr>';
				$content [$f] [5] ["dat"] = '<nobr>' . ($_result [$f] ["ModDate"] ? date ( $GLOBALS ['l_weSearch'] ["date_format"], $_result [$f] ["ModDate"] ) : "-") . '</nobr>';
			} else 

			{
				$fs = file_exists ( $_SERVER["DOCUMENT_ROOT"] . $_result [$f] ["Path"] ) ? filesize ( $_SERVER["DOCUMENT_ROOT"] . $_result [$f] ["Path"] ) : 0;
				$filesize = $fs < 1000 ? $fs . ' byte' : ($fs < 1024000 ? round ( ($fs / 1024), 2 ) . ' kb' : round ( ($fs / (1024 * 1024)), 2 ) . ' mb');
				
				if ($_result [$f] ["ContentType"] == "image/*") {
					$smallSize = 64;
					$bigSize = 140;
					
					if ($fs > 0) {
						$imagesize = getimagesize ( $_SERVER["DOCUMENT_ROOT"] . $_result [$f] ["Path"] );
						if (file_exists ( $_SERVER["DOCUMENT_ROOT"] . '/webEdition/preview/' . $_result [$f] ["docID"] . "_'.$smallSize.'_'.$smallSize.'" . strtolower ( $_result [$f] ["Extension"] ) )) {
							$thumbpath = '/webEdition/preview/' . $_result [$f] ["docID"] . "_'.$smallSize.'_'.$smallSize.'" . strtolower ( $_result [$f] ["Extension"] );
							$imageView = "<img src='$thumbpath' border='0'></a>";
						} else {
							$imageView = "<img src='/webEdition/thumbnail.php?id=" . $_result [$f] ["docID"] . "&size=" . $smallSize . "&path=" . $_result [$f] ["Path"] . "&extension=" . $_result [$f] ["Extension"] . "' border='0'></a>";
						}
						if (file_exists ( $_SERVER["DOCUMENT_ROOT"] . '/webEdition/preview/' . $_result [$f] ["docID"] . "_'.$bigSize.'_'.$bigSize.'" . strtolower ( $_result [$f] ["Extension"] ) )) {
							$thumbpathPopup = '/webEdition/preview/' . $_result [$f] ["docID"] . "_'.$bigSize.'_'.$bigSize.'" . strtolower ( $_result [$f] ["Extension"] );
							$imageViewPopup = "<img src='$thumbpathPopup' border='0'></a>";
						} else {
							$imageViewPopup = "<img src='/webEdition/thumbnail.php?id=" . $_result [$f] ["docID"] . "&size=" . $bigSize . "&path=" . $_result [$f] ["Path"] . "&extension=" . $_result [$f] ["Extension"] . "' border='0'></a>";
						}
					} else {
						$imagesize = array (0, 0 );
						$thumbpath = '/webEdition/images/icons/doclist/image.gif';
						$imageView = "<img src='$thumbpath' border='0' />";
						$imageViewPopup = "<img src='$thumbpath' border='0' />";
					}
				} else {
					$imagesize = array (0, 0 );
					$imageView = '<img src="' . IMAGE_DIR . "/icons/doclist/" . $Icon . '" border="0" width="64" height="64" />';
					$imageViewPopup = '<img src="' . IMAGE_DIR . "/icons/doclist/" . $Icon . '" border="0" width="64" height="64" />';
				}
				
				$content [$f] [0] ["dat"] = '<a href="javascript:openToEdit(\'' . $_result [$f] ["docTable"] . '\',\'' . $_result [$f] ["docID"] . '\',\'' . $_result [$f] ["ContentType"] . '\')" style="text-decoration:none" class="middlefont" title="' . $_result [$f] ["Text"] . '">' . $imageView . '</a>';
				
				$creator = $_result [$f] ["CreatorID"] ? id_to_path ( $_result [$f] ["CreatorID"], USER_TABLE, $DB_WE ) : $GLOBALS ['l_weSearch'] ["nobody"];
				
				if ($_result [$f] ["ContentType"] == "text/webedition") {
					if ($_result [$f] ["Published"] >= $_result [$f] ["ModDate"] && $_result [$f] ["Published"] != 0) {
						$templateID = $_result [$f] ["TemplateID"];
					} else {
						$templateID = $_result [$f] ["temp_template_id"];
					}
					$templateText = $GLOBALS ['l_weSearch'] ["no_template"];
					if ($templateID != "") {
						$sql = "SELECT ID, Text FROM " . TEMPLATES_TABLE . " WHERE ID = $templateID";
						$DB_WE->query ( $sql );
						while ( $DB_WE->next_record () ) {
							$templateText = shortenPath ( $DB_WE->f ( 'Text' ), 20 ) . " (ID=" . $DB_WE->f ( 'ID' ) . ")";
						}
					}
				} else {
					$templateText = "";
				}
				
				$_defined_fields = weMetaData::getDefinedMetaDataFields ();
				$metafields = array ( );
				$_fieldcount = sizeof ( $_defined_fields );
				if ($_fieldcount > 6)
					$_fieldcount = 6;
				for($i = 0; $i < $_fieldcount; $i ++) {
					$_tagName = $_defined_fields [$i] ["tag"];
					
					if (weContentProvider::IsBinary ( $_result [$f] ["docID"] )) {
						$DB_WE->query ( "SELECT a.ID, c.Dat FROM (" . FILE_TABLE . " a LEFT JOIN " . LINK_TABLE . " b ON (a.ID=b.DID)) LEFT JOIN " . CONTENT_TABLE . " c ON (b.CID=c.ID) WHERE b.DID='" . $_result [$f] ["docID"] . "' AND b.Name='" . $_tagName . "' AND b.DocumentTable='" . FILE_TABLE . "'" );
						$metafields [$_tagName] = "";
						while ( $DB_WE->next_record () ) {
							$metafields [$_tagName] = shortenPath ( $DB_WE->f ( 'Dat' ), 45 );
						}
					}
				}
				
				$content [$f] [1] ["dat"] = shortenPath ( $_result [$f] ["SiteTitle"], 17 );
				$content [$f] [2] ["dat"] = '<a href="javascript:openToEdit(\'' . $_result [$f] ["docTable"] . '\',\'' . $_result [$f] ["docID"] . '\',\'' . $_result [$f] ["ContentType"] . '\')" style="text-decoration:none;color:' . $fontColor . ';"  title="' . $_result [$f] ["Text"] . '"><u>' . shortenPath ( $_result [$f] ["Text"], 17 ) . '</u></a>';
				$content [$f] [3] ["dat"] = '<nobr>' . ($_result [$f] ["CreationDate"] ? date ( $GLOBALS ['l_weSearch'] ["date_format"], $_result [$f] ["CreationDate"] ) : "-") . '</nobr>';
				$content [$f] [4] ["dat"] = '<nobr>' . ($_result [$f] ["ModDate"] ? date ( $GLOBALS ['l_weSearch'] ["date_format"], $_result [$f] ["ModDate"] ) : "-") . '</nobr>';
				$content [$f] [5] ["dat"] = '<a href="javascript:openToEdit(\'' . $_result [$f] ["docTable"] . '\',\'' . $_result [$f] ["docID"] . '\',\'' . $_result [$f] ["ContentType"] . '\')" style="text-decoration:none;" class="middlefont" title="' . $_result [$f] ["Text"] . '">' . $imageViewPopup . '</a>';
				$content [$f] [6] ["dat"] = $filesize;
				$content [$f] [7] ["dat"] = $imagesize [0] . " x " . $imagesize [1];
				$content [$f] [8] ["dat"] = shortenPath ( $GLOBALS ['l_contentTypes'] [$_result [$f] ['ContentType']], 22 );
				$content [$f] [9] ["dat"] = '<span style="color:' . $fontColor . ';">' . shortenPath ( $_result [$f] ["Text"], 30 ) . '</span>';
				$content [$f] [10] ["dat"] = shortenPath ( $_result [$f] ["SiteTitle"], 45 );
				$content [$f] [11] ["dat"] = shortenPath ( $_result [$f] ["Description"], 100 );
				$content [$f] [12] ["dat"] = $_result [$f] ['ContentType'];
				$content [$f] [13] ["dat"] = shortenPath ( $creator, 22 );
				$content [$f] [14] ["dat"] = $templateText;
				$content [$f] [15] ["dat"] = $metafields;
				$content [$f] [16] ["dat"] = $_result [$f] ["docID"];
			}
		}
		
		return $content;
	}
	
	/**
	 * @abstract generates html for search result
	 * @return string, html search result
	 */
	function getSearchParameterTop($foundItems) {
		$out = "";
		
		$we_button = new we_button ( );
		
		$anzahl = array (10 => 10, 25 => 25, 50 => 50, 100 => 100 );
		
		if (isset ( $_REQUEST ["we_cmd"] ['obj'] )) {
			$thisObj = new doclistView ( );
		} else {
			$thisObj = $this;
		}
		
		if (isset ( $_REQUEST ["we_cmd"] ['order'] )) {
			$order = $_REQUEST ["we_cmd"] ['order'];
		} else {
			$order = $GLOBALS ['we_doc']->searchclassFolder->order;
		}
		if (isset ( $_REQUEST ["we_cmd"] ['mode'] )) {
			$mode = $_REQUEST ["we_cmd"] ['mode'];
		} else {
			$mode = $GLOBALS ['we_doc']->searchclassFolder->mode;
		}
		if (isset ( $_REQUEST ["we_cmd"] ['setView'] )) {
			$setView = $_REQUEST ["we_cmd"] ['setView'];
		} else {
			$setView = $GLOBALS ['we_doc']->searchclassFolder->setView;
		}
		if (isset ( $_REQUEST ["we_cmd"] ['anzahl'] )) {
			$_anzahl = $_REQUEST ["we_cmd"] ['anzahl'];
		} else {
			$_anzahl = $GLOBALS ['we_doc']->searchclassFolder->anzahl;
		}
		if (isset ( $_REQUEST ['id'] )) {
			$id = $_REQUEST ['id'];
		} else {
			$id = $GLOBALS ['we_doc']->ID;
		}
		if (isset ( $_REQUEST ['we_cmd'] ['we_transaction'] )) {
			$we_transaction = $_REQUEST ['we_cmd'] ['we_transaction'];
		} else {
			$we_transaction = $GLOBALS ['we_transaction'];
		}

		
		$out .= hidden ( "we_transaction", $we_transaction );
		$out .= hidden ( "order", $order );
		$out .= hidden ( "todo", "" );
		$out .= hidden ( "mode", $mode );
		$out .= hidden ( "setView", $setView );
		
		$out .= '<table border="0" cellpadding="0" cellspacing="0">
         <tr>
          <td>' . getPixel ( 19, 12 ) . '</td>
          <td style="font-size:12px;width:125px;">' . $GLOBALS ['l_weSearch'] ["eintraege_pro_seite"] . ':</td>
          <td class="defaultgray" style="width:60px;">' . htmlSelect ( "anzahl", $anzahl, 1, $_anzahl, "", 'onChange=\'this.form.elements["searchstart"].value=0;search(false);\'' ) . '
          </td>
          <td>' . $thisObj->getNextPrev ( $foundItems ) . '</td>
          <td>' . getPixel ( 10, 12 ) . '</td>
          <td style="width:50px;">
          ' . $we_button->create_button ( "image:btn_new_dir", "javascript:top.we_cmd('new_folder','" . FILE_TABLE . "','','folder','" . $id . "')", true, 40, "", "", "", false ) . '
          </td>
          <td>
          ' . $we_button->create_button ( "image:iconview", "javascript:setview(1);", true, 40, "", "", "", false ) . '
          </td>
          <td>
          ' . $we_button->create_button ( "image:listview", "javascript:setview(0);", true, 40, "", "", "", false ) . '
          </td>
        </tr>
        <tr>
          <td colspan="12">' . getPixel ( 1, 12 ) . '</td>
        </tr>
        </table>';
		
		return $out;
	}
	
	function getSearchParameterBottom($foundItems) {
		if (isset ( $_REQUEST ["we_cmd"] ['obj'] )) {
			$thisObj = new doclistView ( );
		} else {
			$thisObj = $this;
		}
		
		$we_button = new we_button();
		
		 $publishButton = "";
         $publishButtonCheckboxAll = "";

		 if (we_hasPerm('PUBLISH')) {
		 		$publishButtonCheckboxAll = we_forms::checkbox("1", 0, "publish_all", "", false, "middlefont", "checkAllPubChecks()");
			    $publishButton = $we_button->create_button("publish", "javascript:publishDocs();",true,100,22,"","");
			}
		
		$out = '<table border="0" cellpadding="0" cellspacing="0" style="margin-top:20px;">
         <tr>
          <td>' . $publishButtonCheckboxAll . '</td>
          <td style="font-size:12px;width:125px;">' . $publishButton . '</td>
          <td class="defaultgray" style="width:60px;" id="resetBusy">' . getPixel ( 30, 12 ) . '</td>
          <td style="width:370px;">' . $thisObj->getNextPrev ( $foundItems ) . '</td>
        </tr>
        </table>';
		
		return $out;
	}
	
	/**
	 * @abstract generates html for paging GUI
	 * @return string, html for paging GUI
	 */
	function getNextPrev($we_search_anzahl) {
		$we_button = new we_button ( );
		
		if (isset ( $_REQUEST ["we_cmd"] ['obj'] )) {
			$obj = $_REQUEST ["we_cmd"] ['obj'];
			$anzahl = $_SESSION ['weSearch'] ['anzahl'];
			$searchstart = $_SESSION ['weSearch'] ['searchstart'];
		} else {
			$obj = $GLOBALS ['we_doc'];
			$anzahl = $obj->searchclassFolder->anzahl;
			$searchstart = $obj->searchclassFolder->searchstart;
		}
		
		$out = '<table cellpadding="0" cellspacing="0" border="0"><tr><td>';
		
		if ($searchstart) {
			$out .= $we_button->create_button ( "back", "javascript:back(" . $anzahl . ");" );
		} else {
			
			$out .= $we_button->create_button ( "back", "", true, 100, 22, "", "", true );
		}
		
		$out .= '</td><td>' . getPixel ( 10, 2 ) . '</td>
        <td class="defaultfont"><b>' . (($we_search_anzahl) ? $searchstart + 1 : 0) . '-';
		
		if (($we_search_anzahl - $searchstart) < $anzahl) {
			$out .= $we_search_anzahl;
		} else {
			
			$out .= $searchstart + $anzahl;
		}
		
		$out .= ' ' . $GLOBALS ["l_global"] ["from"] . ' ' . $we_search_anzahl . '</b></td>' . '<td>' . getPixel ( 10, 2 ) . '</td>' . '<td>';
		
		if (($searchstart + $anzahl) < $we_search_anzahl) {
			$out .= $we_button->create_button ( "next", "javascript:next(" . $anzahl . ");" );
		} else {
			
			$out .= $we_button->create_button ( "next", "", true, 100, 22, "", "", true );
		}
		$out .= '</td>' . '<td>' . getPixel ( 10, 2 ) . '</td>' . '<td>';
		
		$pages = array ( );
		for($i = 0; $i < ceil ( $we_search_anzahl / $anzahl ); $i ++) {
			$pages [($i * $anzahl)] = ($i + 1);
		}
		
		$page = ceil ( $searchstart / $anzahl ) * $anzahl;
		
		$select = htmlSelect ( "page", $pages, 1, $page, false, "onChange=\"this.form.elements['searchstart'].value = this.value; search(false);\"" );
		
		if (! isset ( $_REQUEST ['we_cmd'] ['setInputSearchstart'] )) {
			if (! defined ( "searchstart" )) {
				define ( "searchstart", true );
				$out .= hidden ( "searchstart", $searchstart );
			}
		}
		
		$out .= $select;
		
		$out .= '</td>' . '</tr>' . '</table>';
		
		return $out;
	}
	
	/**
	 * @abstract writes the complete html code
	 * @return string, html
	 */
	function getHTMLforDoclist($content) {
		
		$marginLeft = "0";

		$out = '<table width="100%" border="0" cellspacing="0" cellpadding="0" style="width:100%;">
          <tr>
            <td class="defaultfont">';
		
		foreach ( $content as $i => $c ) {
			
			$_forceRightHeadline = (isset ( $c ["forceRightHeadline"] ) && $c ["forceRightHeadline"]);
			
			$icon = (isset ( $c ["icon"] ) && $c ["icon"]) ? ('<img src="' . IMAGE_DIR . 'icons/' . $c ["icon"] . '" width="64" height="64" alt="" style="margin-left:20px;">') : "";
			
			$headline = (isset ( $c ["headline"] ) && $c ["headline"]) ? ('<div class="weMultiIconBoxHeadline" style="margin-bottom:10px;">' . $c ["headline"] . '</div>') : "";
			
			$mainContent = (isset ( $c ["html"] ) && $c ["html"]) ? $c ["html"] : "";
			
			$leftWidth = (isset ( $c ["space"] ) && $c ["space"]) ? abs ( $c ["space"] ) : 0;
			
			$leftContent = $icon ? $icon : (($leftWidth && (! $_forceRightHeadline)) ? $headline : "");
			
			$rightContent = '<div class="defaultfont">' . ((($icon && $headline) || ($leftContent === "") || $_forceRightHeadline) ? ($headline . '<div>' . $mainContent . '</div>') : '<div>' . $mainContent . '</div>') . '</div>';
			
			$out .= '<div style="margin-left:' . $marginLeft . 'px" >';
			
			if ($leftContent || $leftWidth) {
				if ((! $leftContent) && $leftWidth) {
					$leftContent = "&nbsp;";
				}
				$out .= '<div style="float:left;width:' . $leftWidth . 'px">' . $leftContent . '</div>';
			}
			
			$out .= $rightContent;
			
			$out .= '</div>' . (($GLOBALS ["BROWSER"] == "IE") ? '<br>' : '');
			
			if ($i < (count ( $content ) - 1) && (! isset ( $c ["noline"] ))) {
				$out .= '<div style="border-top: 1px solid #AFB0AF;margin:10px 0 10px 0;clear:both;"></div>';
			}
		}
				
		$boxHTML = $out . '</td></tr></table>';
		
		return $boxHTML;
	}
	
	function getDateSelector($_label, $_name, $_btn, $value) {
		$we_button = new we_button ( );
		$btnDatePicker = $we_button->create_button ( "image:date_picker", "javascript:", null, null, null, null, null, null, false, $_btn );
		$oSelector = new we_htmlTable ( array ("cellpadding" => "0", "cellspacing" => "0", "border" => "0", "id" => $_name . "_cell" ), 1, 5 );
		$oSelector->setCol ( 0, 2, null, htmlTextInput ( $name = $_name, $size = 55, $value, $maxlength = 10, $attribs = 'id="' . $_name . '" class="wetextinput" readonly="1"', $type = "text", $width = 100 ) );
		$oSelector->setCol ( 0, 3, null, "&nbsp;" );
		$oSelector->setCol ( 0, 4, null, we_htmlElement::htmlA ( array ("href" => "#" ), $btnDatePicker ) );
		
		return $oSelector->getHTMLCode ();
	}
}
?>