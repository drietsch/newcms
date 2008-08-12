<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//


    include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we.inc.php");
    include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".  $GLOBALS["WE_LANGUAGE"] . "/SEEM.inc.php");
    include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_button.inc.php");

    class we_SEEM{
        

    	/**
         * we_SEEM::getClassVars
         *
         * @desc    This function is a workaround for using variables within a "static" class.
         			in this case it is only used in in normal mode and has no effect in super-easy-edit-mode.
         			
		 * @param	string	name of the variable
         * @return  string	value of the variable
         */
        function getClassVars($name){
        	
        	return "";
        	//	here are all variables.
        	if($_SESSION["we_mode"] == "normal"){
        		$vtabSrcDocs = "top.Vtabs.we_cmd('load','" . FILE_TABLE . "',0);top.we_cmd('exit_delete');";
        		if(defined("OBJECT_FILES_TABLE")){
        			if(we_hasPerm("CAN_SEE_OBJECTFILES")){
        				$vtabSrcObjs = "top.Vtabs.we_cmd('load','" . OBJECT_FILES_TABLE . "',0);top.we_cmd('exit_delete');";
        			} else {
        				$vtabSrcObjs = "top.we_cmd('exit_delete');";
        			}
	        		
        		}
        	} else {
        		$vtabSrcDocs = "";
	        	$vtabSrcObjs = "";
        	}
        	
        	
        	if(isset($_SESSION["we_mode"]) && $_SESSION["we_mode"] == "normal"){
        		
        		if(isset($$name)){
        			
        			return $$name;
        		} else {
        			return "";
        		}
        		
        	} else {
        		return "";
        	}
    	}
    	
    	
        /**
        * we_SEEM::parseDocument()
        * @desc     Parses all links/forms in the webededition preview or edit mode of a given HTML, PHP code.
                    Pressing these links/ Submitting these forms has the same effect, than selecting the correspondent document in the
                    Tree-Menue on the left side. Extern docs (with parameters) are also opened within webEdition.
        *
        * @see      we_SEEM::getAllHrefs
        * @see      we_SEEM::parseLinksForEditMode
        * @see      we_SEEM::parseLinksForPreviewMode
        * @see      we_SEEM::getAllForms
        * @see      we_SEEM::parseFormsForEditMode
        * @see      we_SEEM::parseFormsForPreviewMode
        *
        * @param    code    string
        * @return   code    string with parsed links
        */
        function parseDocument($code){

        	//  #########################################################
            //  Parse all links of the webedition-document (Preview Mode)
            //  Pressing the link inside the Preview of webedtion must show
            //  the same behaviour like selecting the document in the file
            //  Browser on the left side.
            
            //  First get all Hrefs of the document
            //  $linkarray[0] - Array of all inside the "<a ... >"
            //  $linkarray[1] - Array of all between -><a href="<-
            //  $linkarray[2] - Array of all between <a href="->...<-?test=1" ...
            //  $linkarray[3] - Array of all get-Parameters: <a href="...->?test=1&..."<- ...
            //  $linkarray[4] - Array of all after the href (styles and stuff)<a href="...?test=1"-> ... <->
            //  All these informations are needed to replace the old link with a new one
            $linkArray = we_SEEM::getAllHrefs($code);

            if(isset($GLOBALS["we_doc"]) && $GLOBALS["we_doc"]->EditPageNr == WE_EDITPAGE_CONTENT && !defined("WE_SIDEBAR")) {
               
                //  The edit-mode only changes SEEM-links
                $code = we_SEEM::parseLinksForEditMode($code, $linkArray);
            }
            
            if(!isset($GLOBALS["we_doc"]) || $GLOBALS["we_doc"]->EditPageNr == WE_EDITPAGE_PREVIEW || $GLOBALS["we_doc"]->EditPageNr == WE_EDITPAGE_PREVIEW_TEMPLATE || defined("WE_SIDEBAR")){
                
                //  in the preview mode all found links in the document shall be changed
                $code = we_SEEM::parseLinksForPreviewMode($code, $linkArray);
            }
            
            
            
            //  #########################################################
            //  Now deal with all form-tags and submit-buttons
            //  they shall be replaced in edit-mode
            //  $allForms[0] - contains the original formular - this is needed to be replaced
            //  if no form is found in $code, then false is returned.
            //  This must be done always
            
            $allForms = we_SEEM::getAllForms($code);

            //  if in editMode, remove all forms but the "we_form"
            if(isset($GLOBALS["we_doc"]) && $GLOBALS["we_doc"]->EditPageNr == WE_EDITPAGE_CONTENT && !defined("WE_SIDEBAR")){
                
                $code = we_SEEM::parseFormsForEditMode($code, $allForms);
            }
            //  we are in preview mode or open an extern document - parse all found forms
            if(!isset($GLOBALS["we_doc"]) || $GLOBALS["we_doc"]->EditPageNr == WE_EDITPAGE_PREVIEW || defined("WE_SIDEBAR")){
                
                $code = we_SEEM::parseFormsForPreviewMode($code, $allForms);
            }
            
            //  All is done - return the code
            return $code;
        }
        
        
       /**
        * we_SEEM::parseLinksForEditMode
        * 
        * @desc     This function parses the given code for the edit-mode.
                    It will change all Links with a SEEM attribute
        *
        * @see      we_SEEM::getSEEM_Links
        * @see      we_SEEM::replaceSEEM_Links
        *
        * @param    code        string of the complete source code
        * @param    linkArray   array of all found links in the document
        *
        * @return string of the source code with changed links
        */
        function parseLinksForEditMode($code, $linkArray){

            //  Take all links with a seem="<attrib>" and put them in a new Array
            //  $SEEM_Links[0] - Array of all found "<a ... >"
            //  $SEEM_Links[1] - Array of all between href="<- ... ->", this is the path to the document
            //  $SEEM_Links[2] - Array containing the the value of SEEM="<attrib>"
            //  if no array is returned - false is returned.
            $SEEM_Links = we_SEEM::getSEEM_Links($linkArray);

            //  if an array is returned, modify the code
            if($SEEM_Links && is_array($SEEM_Links)){
                $code = we_SEEM::replaceSEEM_Links($code, $SEEM_Links);
            }
            return $code;
        }
        
        
       /**
        * we_SEEM::parseLinksForPreviewMode
        * 
        * @desc     This function parses the given code for the preview-mode.
        *
        * @see      we_SEEM::onlyUseHyperlinks
        * @see      we_SEEM::cleanLinks
        * @see      we_SEEM::findRelativePaths
        * @see      we_SEEM::getDocIDsByPaths
        * @see      we_SEEM::replaceLinks
        * 
        * @param    code        string of the complete source code
        * @param    linkArray   array of all found links in the document
        *
        * @return   string of the source code with changed links
        */
        function parseLinksForPreviewMode($code, $linkArray){
        	
        	$SEEM_Links = we_SEEM::getSEEM_Links($linkArray);
            //  if an array is returned, modify the code
            if($SEEM_Links && is_array($SEEM_Links)){
                $code = we_SEEM::replaceSEEM_Links($code, $SEEM_Links);
            }
            $linkArray = we_SEEM::removeSEEMLinks($linkArray);
        	
            //  Remove all other Stuff from the linkArray
            //  Here all further SEEM - Links are removed as well
            if($linkArray && is_array($linkArray)){
            	
            	$linkArray = we_SEEM::onlyUseHyperlinks($linkArray);

	            //  if an array is returned in onlyUseHyperlinks, then parse the $code, otherwise return the same code.
	            if($linkArray && is_array($linkArray)){
	
	                //  Remove all javascript, or target stuff, from links, they could disturb own functionality
	                //  Important are $linkArray[1][*] and $linkArray[4][*]
	                $linkArray = we_SEEM::cleanLinks($linkArray);
	
	                //  $linkArray[5] - Array of the relative translation of given Link-targets, only with webEdition-Docs
	                $linkArray[5] = we_SEEM::findRelativePaths($linkArray[2]);
	
	                //  $linkArray[6] - Array which contains the docIds of the Documents, or -1
	                $linkArray[6] = we_SEEM::getDocIDsByPaths($linkArray[5]);
	                
	                //	$linkArray[7] - Array which contains the content-types of the documents or ''
	                $linkArray[7] = we_SEEM::getDocContentTypesByID($linkArray[6]);
		            
	                if(defined("WE_SIDEBAR")) {
	                    $code = we_SEEM::replaceLinksForSidebar($code, $linkArray);
		            	
	                } else {
		                $code = we_SEEM::replaceLinks($code, $linkArray);
		                
	                }
	            }
            }
            return $code;
        }

       /**
        * we_SEEM::parseFormsForPreviewMode
        * 
        * @desc     This function parses all forms for the Preview mode, they will behave like viewing
                    the page outside webEdition.
        *
        * @see      we_SEEM::getPathsFromForms
        * @see      we_SEEM::findRelativePaths
        * @see      we_SEEM::getDocIDsByPaths
        * @see      we_SEEM::rebuildForms
        *
        * @param   code        string src-code of the document
        * @param   allForms    array with all forms found in the code
        * @return  code        string
        */
        function parseFormsForPreviewMode($code, $allForms){
            
            if($allForms && is_array($allForms)){
                
                //  $allForms[1] - the actions of the forms, or -1, when action is missing, then we must take the doc-ID
                $allForms[1] = we_SEEM::getPathsFromForms($allForms);
            
                //  $allForms[1] now has the relative translation of paths if possible
                $allForms[1] = we_SEEM::findRelativePaths($allForms[1]);
        
                //  $allForms[2] contains all doc-ids of the found forms
                $allForms[2] = we_SEEM::getDocIDsByPaths($allForms[1]);
                
                $code = we_SEEM::rebuildForms($code, $allForms);
            }
            return $code;
        }
        
        /**
         * we_SEEM::parseFormsForEditMode
         * 
         * @desc    This function removes all forms from the code in the edit mode.
                    Also 'input type="submits"' will be changed to 'input type="button"'
         *
         * @see     we_SEEM::removeAllButWE_FORM
         * @see     we_SEEM::changeSubmitToButton
         *
         * @param   code        string the srcCode of the document
         * @param   allForms    array with all found forms
         * @return  code        the new code
         */
        function parseFormsForEditMode($code, $allForms){

            //  remove all forms but the form with name "we_form" from the code.
            //  also remove all tags where forms where closed and add one at the end of the file.
            //  This makes some problems, if forms are given in some HTML-Preview fields.
//            $code = we_SEEM::removeAllButWE_FORM($code, $allForms);
            
            //  now we must change all submit-buttons to normal buttons
//            $code = we_SEEM::changeSubmitToButton($code);
            
            return $code;
        }
        
        /**
         * we_SEEM::changeSubmitToButton
         * 
         * @desc    Changes submit buttons in given code to normal buttons
         *
         * @param   code        string, source code of the document
         * @return  code        string only with the "we_form", needed to edit the page
         */
        function changeSubmitToButton($code){

            //  Searchpattern for all <input ..> in the code
            $pattern = "/<input[^>]*type=[\"|']?submit[\"|']?[^>]*>/si";
            preg_match_all($pattern, $code, $allInputs);

            //  Replace the input type="submit" with input type="button"
            for($i=0;$i<sizeof($allInputs[0]);$i++){

            	$attribs = we_SEEM::getAttributesFromTag($allInputs[0][$i]);
            	// THIS FUNCTION IS NOT USED ATM
            	$tmpInput = "<input onclick=\"#\"";
            	
            	for($j=0;$j<sizeof($attribs);$j++){
                    
					while(list($key, $value) = each($attribs)){

						if(strtolower($key) == "type" && strtolower($value) == "submit"){
							$tmpInput .= " " . $key . "=\"button\"";
						} else {
							$tmpInput .= " " . $key . "=\"" . $value . "\"";
                        }
					}
				}
                $tmpInput .= ">";
				$code = str_replace($allInputs[0][$i],$tmpInput,$code);
            }
            return $code;
        }
        
        /**
         * we_SEEM::removeAllButWE_FORM
         * 
         * @desc    Removes all <forms> from the $code but the "we_form"
         *
         * @param   formArray   array with all found forms from the document
         * @param   code        string, source code of the document
         * @return  code        string only with the "we_form", needed to edit the page
         */
        function removeAllButWE_FORM($code, $formArray){
            
            $newForms = array();
            $deletedForms = false;
            for($i=0;$i<sizeof($formArray[0]);$i++){
                
                $attribs = we_SEEM::getAttributesFromTag($formArray[0][$i]);
                $we_form = false;
                while(list($key, $value) = each($attribs)){
                    if($key == "name" && $value == "we_form"){
                        $we_form = true;
                    }
                }
                
                //  it is not the "we_form" so delete it from the code
                if(!$we_form){
                    $code = str_replace($formArray[0][$i],"<!--removed from SEEM-->", $code);
                    $deletedForms = true;
                }
                
                if($deletedForms){
                    $code = str_replace("</form>","",$code);
                    $code .= "</form>";
                }
            }
            return $code;
        }
        
        
        /**
         * we_SEEM::replaceSEEM_Links()
         * 
         * @desc    This function replaces the SEEM-Links added by the Tag-Parser.
         *
         * @param   oldcode         string This is the original code of the document.
         * @param   SEEM_LinkArray  array filled with the seem - Links,
                                    [0] is the old link, which must be replaced
                                    [1] contains the id of the document
                                    [2] contains the SEEM-attribute, p.ex "include"
          
         * @return   code           string the new code, where all seem_links are replaced with new functionality
         */
        function replaceSEEM_Links($code, $SEEM_LinkArray){
            
        	$we_button = new we_button();
        	
        	if(isset($GLOBALS["we_doc"]) && $GLOBALS["we_doc"]->EditPageNr == WE_EDITPAGE_CONTENT){
        		$mode = "edit";
        	} else{
        		$mode = "preview";
        	}
        	
            for($i = 0; $i < sizeof($SEEM_LinkArray[0]); $i++){
            	
            	if(isset($_SESSION["we_mode"]) && $_SESSION["we_mode"] == "seem" && $GLOBALS["we_doc"]->EditPageNr == WE_EDITPAGE_CONTENT){	//	in Super-Easy-Edit-Mode only in Editmode !!!
            	
	                switch ($SEEM_LinkArray[2][$i]){
	                    
	                    //  Edit an included document from webedition.
	                    case "edit_image":
	                    	$handler = "if(top.edit_include){top.edit_include.close();}top.edit_include=window.open('/webEdition/we_cmd.php?we_cmd[0]=edit_include_document&we_cmd[1]=" . FILE_TABLE . "&we_cmd[2]=" . $SEEM_LinkArray[1][$i] . "&we_cmd[3]=image/*&we_cmd[4]=" . FILE_TABLE . "&we_cmd[5]=" . $SEEM_LinkArray[1][$i] . "&we_cmd[6]=" . $_REQUEST["we_transaction"] . "&we_cmd[7]='" . ",'_blank','width=800,height=600,status=yes');return true;";
	                        $code = str_replace($SEEM_LinkArray[0][$i] . "</a>", $we_button->create_button("image:btn_edit_image", "javascript:$handler", true), $code);
	                    	break;
	                    case "include" :
	                        //  a new window is opened which stays as long, as the browser is closed, or the window is closed manually
	                        $handler = "if(top.edit_include){top.edit_include.close();}top.edit_include=window.open('/webEdition/we_cmd.php?we_cmd[0]=edit_include_document&we_cmd[1]=" . FILE_TABLE . "&we_cmd[2]=" . $SEEM_LinkArray[1][$i] . "&we_cmd[3]=text/webedition&we_cmd[4]=" . FILE_TABLE . "&we_cmd[5]=" . $SEEM_LinkArray[1][$i] . "&we_cmd[6]=" . $_REQUEST["we_transaction"] . "&we_cmd[7]='" . ",'_blank','width=800,height=600,status=yes');return true;";
	                        $code = str_replace($SEEM_LinkArray[0][$i] . "</a>", $we_button->create_button("image:btn_edit_include", "javascript:$handler", true), $code);
	                        break;
	                    
	                    case "object" :

	                    	$handler = "top.doClickDirect('" . $SEEM_LinkArray[1][$i] . "','objectFile','" . OBJECT_FILES_TABLE . "');";
							$code = str_replace($SEEM_LinkArray[0][$i] . '</a>', $we_button->create_button("image:btn_edit_object", "javascript:$handler", true) . "</a>", $code);
	                    	break;
	                    
	                    default : 
	                        break;
	                }
            	} else {	//	we are in normal mode, so just delete the links
            		$code = str_replace($SEEM_LinkArray[0][$i] . '</a>', "", $code);
            	}
            }
            return $code;
        }
        
        /**
        * we_SEEM::getSEEM_Links()
        * 
        * @desc     Looks for special Links within the from function getAllHrefs(). found links
                    are saved in returned array
        *
        * @param    oldArray    array with all found hyperlinks of getAllHrefs()
        * @return   $newArray   array with the SEEM-Links
        */
        function getSEEM_Links($oldArray){
            
            $newArray = array();
            
            for($i=0,$j=0;$i < sizeof($oldArray[0]); $i++){
                if(preg_match("/ seem=\"(.*)\"/", $oldArray[0][$i], $seem_attrib)){
                    
                    $newArray[0][$j] = $oldArray[0][$i];
                    $newArray[1][$j] = $oldArray[2][$i];
                    $newArray[2][$j] = $seem_attrib[1];
                    $j++;
                    
                } else {
                    //  this link has no function="seem" inside, so it isn't taken to newArray
                }
            }
                
            if(sizeof($newArray) == 0){
                return false;
            } else {
                return $newArray;
            }
        }
        
        /**
        * we_SEEM::cleanLinks()
        * @desc     Removes any attributes from the given links, which can affect with webEdition.
                    p.ex target, some java-script eventhandlers
        *
        * @param    $linkArray  array with <a hrefs ... > in the document
        * @return               links without attributes, which can affect bad with webEdition.
        */
        function cleanLinks($linkArray){
            
            $trenner = "[\040|\n|\t|\r]*";
            $pattern[0] = "/" . $trenner . "onclick" . $trenner . "=/i";
            $repl[0]    = " thiswasonclick=";
            $pattern[1] = "/" . $trenner . "onmouseover" . $trenner . "=/i";
            $repl[1]    = " thiswasonmouseover=";
            $pattern[2] = "/" . $trenner . "onmouseout" . $trenner . "=/i";
            $repl[2]    = " thiswasonmouseout=";
            $pattern[3] = "/" . $trenner . "ondblclick" . $trenner . "=/i";
            $repl[3]    = " thiswasondblclick=";
            
            for($i=0; $i < sizeof($linkArray[0]); $i++){
                $linkArray[1][$i] = preg_replace($pattern, $repl, $linkArray[1][$i]);
                $linkArray[4][$i] = preg_replace($pattern, $repl, $linkArray[4][$i]);
            }
            return $linkArray;
        }
        
        
        function replaceLinksForSidebar($srcCode, $linkArray) {

        	//	This is Code, to have the same effect like pressing a vertical tab
            $destCode = $srcCode;
            
            for($i=0; $i<sizeof($linkArray[0]); $i++){
                
                
                if($linkArray[6][$i] != -1){		//  The target of the Link is a webEdition - Document.
                    
                    if($linkArray[3][$i] != ""){	//  we have several parameters, deal with them
                    	
                        $theParameterArray = we_SEEM::getAttributesFromGet($linkArray[3][$i], "we_cmd");
                        
                        if(array_key_exists ("we_objectID", $theParameterArray)){	//	target is a object
                        	
                        	$javascriptCode = " onclick=\"" . we_SEEM::getClassVars("vtabSrcObjs") . "top.weSidebar.load('" . $linkArray[2][$i] . "');\" onMouseOver=\"top.info('ID: " . $theParameterArray["we_objectID"] . "');\" onMouseOut=\"top.info(' ')\" ";
                        	
                        } else {	//	target is a normal file.
                        	$theParameters = we_SEEM::arrayToParameters($theParameterArray, "", array("we_cmd") );
                        	$javascriptCode = " onclick=\"" . we_SEEM::getClassVars("vtabSrcDocs") . "top.weSidebar.load('" . $linkArray[2][$i] . "');\"  onMouseOver=\"top.info('ID: " . $linkArray[6][$i] . "');\" onMouseOut=\"top.info(' ')\" ".$linkArray[4][$i]." ";
                        }
                        
                    } else {	//  without parameters
						
                        //$javascriptCode = " onclick=\"" . we_SEEM::getClassVars("vtabSrcDocs") . "top.weSidebar.load('" . $linkArray[2][$i] . "');return true;\" onMouseOver=\"top.info('ID: " . $linkArray[6][$i] . "');\" onMouseOut=\"top.info(' ')\" ".$linkArray[4][$i]." ";
                        $javascriptCode = "  onMouseOver=\"top.info('ID: " . $linkArray[6][$i] . "');\" onMouseOut=\"top.info(' ')\" " . $linkArray[4][$i] . " ";

                    }

                    $destCode = str_replace($linkArray[0][$i], "<" . $linkArray[1][$i] . "" . $linkArray[2][$i] . "\""  . $javascriptCode . ">", $destCode);
                    
                }
                
            }
            
            return $destCode;
                
        }
        
        /**
        * we_SEEM::replaceLinks()
        * @desc     Here all the found links in the examined code are replaced.
        * 
        * @param    srcCode     string the source code
        * @param    linkArray   array with all links
        * @return   code        string the new HTML code with for SEEM changed links
        */
        function replaceLinks($srcCode, $linkArray){
	        //	This is Code, to have the same effect like pressing a vertical tab
            $destCode = $srcCode;

            for($i=0; $i<sizeof($linkArray[0]); $i++){
                
                if($linkArray[6][$i] != -1){		//  The target of the Link is a webEdition - Document.
                    
                    if($linkArray[3][$i] != ""){	//  we have several parameters, deal with them

                        $theParameterArray = we_SEEM::getAttributesFromGet($linkArray[3][$i], "we_cmd");
                        
                        if(array_key_exists ("we_objectID", $theParameterArray)){	//	target is a object
                        	
                        	$javascriptCode = " onclick=\"" . we_SEEM::getClassVars("vtabSrcObjs") . "top.doClickDirect('" . $theParameterArray["we_objectID"] . "','objectFile','" . OBJECT_FILES_TABLE . "');\" onMouseOver=\"top.info('ID: " . $theParameterArray["we_objectID"] . "');\" onMouseOut=\"top.info(' ')\" ";
                        	
                        } else {	//	target is a normal file.
                        	$theParameters = we_SEEM::arrayToParameters($theParameterArray, "", array("we_cmd") );
                        	$javascriptCode = " onclick=\"" . we_SEEM::getClassVars("vtabSrcDocs") . "top.doClickWithParameters('" . $linkArray[6][$i] . "','" . $linkArray[7][$i] . "','" . FILE_TABLE . "', '" . $theParameters . "');\"  onMouseOver=\"top.info('ID: " . $linkArray[6][$i] . "');\" onMouseOut=\"top.info(' ')\" ";
                        }
                        
                    } else {	//  without parameters
						
                        $javascriptCode = " onclick=\"" . we_SEEM::getClassVars("vtabSrcDocs") . "top.doClickDirect(" . $linkArray[6][$i] . ",'" . $linkArray[7][$i] . "','" . FILE_TABLE . "');return true;\" onMouseOver=\"top.info('ID: " . $linkArray[6][$i] . "');\" onMouseOut=\"top.info(' ')\" ";

                    }
                    $destCode = str_replace($linkArray[0][$i], "<" . $linkArray[1][$i] . "javascript://" . $linkArray[4][$i] . $javascriptCode . ">", $destCode);
                
                //  The target is NO webEdition - Document
                } else {
                    
                    //  Target document is on another Web-Server - leave webEdition !!!!!
                    if( substr($linkArray[5][$i],0,7) == "http://" || substr($linkArray[5][$i],0,8) == "https://" ){
                        $javascriptCode = " onclick=\"if(confirm('" . $GLOBALS["l_we_SEEM"]["ext_document_on_other_server_selected"] . "')){ window.open('" . $linkArray[5][$i] . $linkArray[3][$i] ."','_blank');top.info(' '); } else { return false; };\" onMouseOver=\"top.info('" . $GLOBALS["l_we_SEEM"]["info_ext_doc"] . "');\" onMouseOut=\"top.info(' ');\" ";
                        $destCode = str_replace($linkArray[0][$i], "<" . $linkArray[1][$i] . "javascript://" . $linkArray[4][$i] . $javascriptCode . ">", $destCode);
                    
                    } else {	//  Target is on the same Web-Server - open doc with webEdition.
                        
                        if(substr($linkArray[5][$i],0,22) == "/webEdition/we_cmd.php"){	//  it is a command link - use open_document_with_parameters
                            
                            //  Work with the parameters ...
                            $theParameters = "";
                            
                            if($linkArray[3][$i] != ""){
                                $theParameterArray = we_SEEM::getAttributesFromGet($linkArray[3][$i],"we_cmd");
                                $theParameters = we_SEEM::arrayToParameters($theParameterArray, "", array("we_cmd") );
                            }
                            
                            if(array_key_exists ("we_objectID", $theParameterArray)){	//	target is a object
                        	
                        		$javascriptCode = " onclick=\"" . we_SEEM::getClassVars("vtabSrcObjs") . "top.doClickDirect('" . $theParameterArray["we_objectID"] . "','objectFile','" . OBJECT_FILES_TABLE . "');\" onMouseOver=\"top.info('ID: " . $theParameterArray["we_objectID"] . "');\" onMouseOut=\"top.info(' ')\" ";
                        	
                        	} else {
                        		
                        		$javascriptCode = " onclick=\"top.doClickWithParameters('" . $GLOBALS["we_doc"]->ID . "','text/webedition','" . FILE_TABLE . "', '" . $theParameters . "');top.info(' ');\" onMouseOver=\"top.info('" . $GLOBALS["l_we_SEEM"]["info_doc_with_parameter"] . "');\" onMouseOut=\"top.info(' ');\"";
                        	}

                            $destCode = str_replace($linkArray[0][$i], "<" . $linkArray[1][$i] . "javascript://\"" . $javascriptCode . $linkArray[4][$i] . " >", $destCode);
                            
                        } else {
                        	//	This is a javascript:history link, to get back to the last document.
                        	if(substr($linkArray[2][$i],0,10) == "javascript" && strpos($linkArray[2][$i],"history")){
                       			$javascriptCode = " onclick=\"" . we_message_reporting::getShowMessageCall($GLOBALS["l_we_SEEM"]["link_does_not_work"], WE_MESSAGE_FRONTEND) . "\" onMouseOver=\"top.info('" . $GLOBALS["l_we_SEEM"]["info_link_does_not_work"] . "')\" onMouseOut=\"top.info('');\"";
    	                        $destCode = str_replace($linkArray[0][$i], "<" . $linkArray[1][$i] . "javascript://\"" . $linkArray[4][$i] . $javascriptCode . ">", $destCode);
                            
                        	} else {
                        		
	                        	//  Check, if the current document was changed ...
	                            $javascriptCode = " onclick=\"if(confirm('" . $GLOBALS["l_we_SEEM"]["ext_doc_selected"] . "')){top.doExtClick('" . $linkArray[5][$i] . $linkArray[3][$i] . "');top.info(' ');} else { return false; };\" onMouseOver=\"top.info('" . $GLOBALS["l_we_SEEM"]["info_ext_doc"] . "');\" onMouseOut=\"top.info(' ')\" ";
	                            $destCode = str_replace($linkArray[0][$i], "<" . $linkArray[1][$i] . "javascript://\"" . $linkArray[4][$i] . $javascriptCode . ">", $destCode);
                        	}
                        }
                    }
                }
            }
            return $destCode;
        }
        
        /**
        * we_SEEM::getAllHrefs()
        *
        * @desc     Returns array with all <a hrefs ...> of the given HTML-Code
        *
        * @param    code        string Some HTML, PHP-Code
        * @return   allLinks    array containing all <a href ...>-Tags, the targets and parameters
        */
        function getAllHrefs($code){

            $trenner = "[\040|\n|\t|\r]*";

            //  <a href="(Ziele)(?Parameter)" ...> Ziele und Parameter eines Links ermitteln.
            //  $pattern = "/<(a".$trenner."[^>]+href".$trenner."[=\"|=\'|=\\\\|=]*".$trenner.")([^\'\">\040? ]*)([^\"\' \040\\\\]*)(".$trenner."[^>]*)>/sie";
            //  Now no more mistake, when href=\" ... \" ...
            $pattern = "/<(a".$trenner."[^>]+href".$trenner."[=\"|=\'|=|=\\\\]*".$trenner.")([^\'\">\040? \\\]*)([^\"\' \040\\\\>]*)(".$trenner."[^>]*)>/sie";

            preg_match_all($pattern, $code, $allLinks);
            //ERROR_LOG2($allLinks);
            return $allLinks;
        }

        
        /**
        * we_SEEM::findRelativePaths()
        * @desc     Replaces all relative Paths which point to the webEdition-Server, by the relative Translation
        *
        * @see      we_SEEM::translateRelativePath
        *
        * @param    foundPaths      array with all paths in the document
        * @return   relativePaths   array with the relative translation of the paths
        */
        function findRelativePaths($foundPaths){

            $relativePaths = array();
            for($i=0; $i<sizeof($foundPaths); $i++){
                $relativePaths[$i] = str_replace(getServerProtocol(true) . SERVER_NAME . (defined("HTTP_PORT") ? ":" . HTTP_PORT : ""), "", $foundPaths[$i]);
                $relativePaths[$i] = we_SEEM::translateRelativePath($relativePaths[$i]);
            }
            return $relativePaths;
        }
        
        /**
        * we_SEEM::translateRelativePath()
        * @desc     Found paths must be translated to the relative path from the document root of the webserver
        *
        * @param    path            string a path found in a link
        * @return   path            string absulute translation of the path matching from the DOCUMENT_ROOT
        */
        function translateRelativePath($path){
			
        	//	Take the path of the doc to find out, if the same doc is target
        	//	or from the url of the document (only when extern)
        	//	or none, when the full path is known (getJavaScriptCommandForOneLink)
            $tmpPath = isset($GLOBALS["we_doc"]) ? $GLOBALS["we_doc"]->Path : (isset($_REQUEST["url"]) ? str_replace( getServerProtocol(true) . SERVER_NAME . (defined("HTTP_PORT") ? ":" . HTTP_PORT : ""), "", $_REQUEST["url"]) : "");

            //  extern or as absolut recognized paths shall not be changed.
            if(substr($path,0,1) != "/" && substr($path,0,7) != "http://" && substr($path,0,8) != "https://" ){
                $tmpPath = substr($tmpPath,0,strrpos($tmpPath,'/'));
                while(substr($path,0,3) == "../"){

                	$path = substr($path,3);
                    $tmpPath = substr($tmpPath,0,strrpos($tmpPath,'/'));
                }
                $tmpPath .= "/" . $path;
                return $tmpPath;
            } else {
                return $path;
            }
        }
        
        /**
        * we_SEEM::getDocIDsByPaths()
        * @desc     This function searches the DocID from a given array of Paths. It is used to look for targets of links
                    and targets of forms.
        *
        * @see      we_SEEM::getDocIDbyPath
        *
        * @param    docPaths    array of Paths to documents
        * @return   docIds      array with the document-id ofthe correspending document
        *
        */
        function getDocIDsByPaths($docPaths){
            

            $docIds = array();
            for($i=0; $i<sizeof($docPaths); $i++){
                
                //  if the link still begins with "http://", the links points to no we-document, so we neednt look for his id
                //	all links to same webServer have been removed
                if(substr($docPaths[$i],0,7) == "http://" || substr($docPaths[$i],0,8) == "https://"){
                    $docIds[$i] = -1;
                } else {
                    $docIds[$i] = we_SEEM::getDocIDbyPath($docPaths[$i]);
                }
            }
            return $docIds;
        }
        
        /**
        * we_SEEM::getDocIDbyPath()
        * @desc     Looks for the document-ID of a document with a certain path, if no document was found, -1 is returned
        *
        * @param    docPath         string path on the server.
        * @param    tbl             string table to look for the paths
        * @return   ID              string Document-ID to which the path belongs to or -1
        */
        function getDocIDbyPath($docPath, $tbl=""){

            if ($tbl == "") {
                $tbl = FILE_TABLE;
            }

            $db = new DB_WE();
            $query = "
                SELECT ID
                FROM " . $tbl . "
                WHERE Path='" . $docPath . "'
            ";
            $db->query($query);

            if ($db->num_rows() == 1){

                $db->next_record();
                return $db->f("ID");
            } else {
                return -1;
            }
        }
        
        
        /**
        * we_SEEM::removeSEEMLinks()
        * @desc     All SEEM-Links are removed from the array, they will be handled seperately
        * 
        * @param    oldArray        array with all found hrefs
        * @return   array
        */
        function removeSEEMLinks($oldArray){
        	
        	$newArray = array();
            
            for($i=0,$j=0;$i < sizeof($oldArray[2]); $i++){
                if(preg_match("/ seem=\"(.*)\"/", $oldArray[0][$i])){
                    //  This link is a SEEM Link, this is handled seperately - so it will be removed
                } else {
                    $newArray[0][$j] = $oldArray[0][$i];
                    $newArray[1][$j] = $oldArray[1][$i];
                    $newArray[2][$j] = $oldArray[2][$i];
                    $newArray[3][$j] = $oldArray[3][$i];
                    $newArray[4][$j] = $oldArray[4][$i];
                    $j++;
                }
            }
            if(sizeof($newArray) == 0){
                return false;
            } else {
                return $newArray;
            }
        }
        
        /**
        * we_SEEM::onlyUseHyperlinks()
        * @desc     All unnecessary links (like mailto, javascript, ..) are removed from the found links. If all links are
                    removed from the array false is returned. In this function other protocols like ftp can be removed as well
        * 
        * @param    oldArray        array with all found hrefs
        * @return   newArray        array - false if all links were removed or array of hyperlinks
        */
        function onlyUseHyperlinks($oldArray){
            
            $newArray = array();
            
            for($i=0,$j=0;$i < sizeof($oldArray[2]); $i++){
                if(substr($oldArray[2][$i],0,1) == "#" || substr($oldArray[2][$i],0,10) == "javascript" && substr($oldArray[2][$i],0,18) != "javascript:history"  || substr($oldArray[2][$i],0,6) == "mailto" || substr($oldArray[2][$i],0,9) == "document:" || substr($oldArray[2][$i],0,7) == "object:"){
                    //  this link must not be changed - so it will be removed
                } else {
                    $newArray[0][$j] = $oldArray[0][$i];
                    $newArray[1][$j] = $oldArray[1][$i];
                    $newArray[2][$j] = $oldArray[2][$i];
                    $newArray[3][$j] = $oldArray[3][$i];
                    $newArray[4][$j] = $oldArray[4][$i];
                    $j++;
                }
            }
                
            if(sizeof($newArray) == 0){
                return false;
            } else {
                return $newArray;
            }
        }
        
        /**
         * we_SEEM::getAllForms
         * 
         * @desc    This function searches all <form>-tags in the given code and saves them in an array
         *
         * @param   code        string   the source code of a special document
         * @return  allForms    array with all found form-tags
         */
        function getAllForms($code){
            
            $pattern = "/<form[^>]*>/sie";
            
            preg_match_all($pattern, $code, $allForms);
            
            return $allForms;
        }
        
        /**
         * we_SEEM::getPathsFromForms
         * 
         * @desc Searches the action of the given <form>-tags - if no action is given -1 is returned
         *
         * @param   formArray   array with all forms
         * @return  thePaths    array with all actions of the given form-tags
         */
        function getPathsFromForms($formArray){
            
            $thePaths = array();
            
            for($i=0;$i<sizeof($formArray[0]);$i++){
                
                $theAttribs = we_SEEM::getAttributesFromTag($formArray[0][$i]);
                if(isset($theAttribs["action"])){
                    
                    $thePaths[$i] = $theAttribs["action"];
                } else {
                    
                    $thePaths[$i] = isset($GLOBALS["we_doc"]) ? $GLOBALS["we_doc"]->Path : $_REQUEST["filepath"];
                }
            }
            return $thePaths;
        }
        
        /**
         * we_SEEM::getAttributesFromGet
         * 
         * @desc    Searches a string for get-Parameters and gives them back in an array.
                    The string must begin (and should end) with "&", name, value pairs must be seperated with "="
         *
         * @param   $paraStr    string with all get-Parameters
         * @param   $ignor      string variablenames which begin with this are ignored
         * 
         * @return  $code       string with the replaced forms
         */
        function getAttributesFromGet($paraStr, $ignor){
            
            $attribs = array();
            
            if(substr($paraStr, 0,1) == "?"){
                $paraStr = "&" . substr($paraStr,1) . "&";
            }
            preg_match_all('/([^&]*=[^&]*)&/U', $paraStr, $parameters);
            
            //  now get the single attributes and remember path
            for($j=0;$j<sizeof($parameters[1]);$j++){

                list($key, $value) = explode('=',$parameters[1][$j]);
                 if(substr($key,0,strlen($ignor)) != $ignor){
                    $attribs[$key] = $value;
                }
            }
            return $attribs;
        }
        
        /**
         * we_SEEM::getAttributesFromTag
         * 
         * @desc    Searches a tag for Parameters and gives them back in an assoziative array.
         *
         * @param   tag         string the complete <form> tag
         * 
         * @return  attribs     array (assoziative) with name/value pairs of the Parameters in the form
         */
        function getAttributesFromTag($tag){

            $attribs = array();
            
            $trenner = '[\040|\n|\t|\r]*';
    
            preg_match_all("/(\w+)".$trenner."=".$trenner."[\"|\']?([^\"|\'|\040|>]*)[\"|\']?/i", $tag, $parameters);
            
            for($j=0;$j<sizeof($parameters[1]);$j++){
                
                $attribs[$parameters[1][$j]] = $parameters[2][$j];
            }
            return $attribs;
        }
        
        /**
         * we_SEEM::rebuildForms
         * 
         * @desc    Replaces all possible forms in the document, so they will be opened within webEdition
         *
         * @param   code        string of the source code
         * @param   formArray   array with all form tags and their actions
         * 
         * @return  code        string the new code
         */
        function rebuildForms($code, $formArray){
            
            for($i=0;$i<sizeof($formArray[0]);$i++){
                
                $theAttribs = we_SEEM::getAttributesFromTag($formArray[0][$i]);
                
                $newForm = "<form";
                
                if ( $formArray[2][$i] == -1 && (substr($formArray[1][$i], 0, 7) == "http://"  || substr($formArray[1][$i],0,8) == "https://") ) { // Formular is on another webServer
                	
                	$newForm .= " onsubmit='if(confirm(\"" . $GLOBALS["l_we_SEEM"]["ext_form_target_other_server"] . "\")){return true;} else {return false;};' target='_blank'";
                        
                        while(list($key, $value) = each($theAttribs)){
                            
                            //  the target must be changed and shall open in a new window
                            if(strtolower($key) == "target"){
                            
                            } else {
                                $newForm .= " " . $key . "=\"" . $value . "\"";
                            }
                        }
                        if(substr($newForm,strlen($newForm),1) != ">"){
                           $newForm .= ">";
                        }
                	
                } else {
                	
                	// target is a webEdition Document
	                if($formArray[2][$i] != -1 || substr($formArray[1][$i],0,22) == "/webEdition/we_cmd.php"){
	                	$newForm .= " target=\"load\" action=\"/webEdition/we_cmd.php\"";
	                	
	                } else {
	                	$newForm .= " target=\"load\" action='/webEdition/we_cmd.php' onsubmit='if(confirm(\"" . $GLOBALS["l_we_SEEM"]["ext_form_target_we_server"] . "\")){return true;} else {return false;};'";
	                	
	                }
	                while(list($key, $value) = each($theAttribs)){
	                        
	                    if(strtolower($key) == "target" || strtolower($key) == "action"){
	                    } else {
	                        $newForm .= " " . $key . "=\"" . $value . "\"";
	                    }
	                }
	                if(substr($newForm,strlen($newForm),1) != ">"){
	                    $newForm .= ">";
	                }
	                //  Now add some hidden fields.
	                $newForm .= "<input type=\"hidden\" name=\"we_cmd[0]\" value=\"open_form_in_editor\"><input type=\"hidden\" name=\"original_action\" value=\"" . $formArray[1][$i] . "\" />";
                	
                }
                
                $code = str_replace($formArray[0][$i], $newForm, $code);
            }
            return $code;
        }
        
        
        
        /**
         * we_SEEM::arrayToParameters
         *
         * @desc    Takes all values from the "array" and generates an get-String from this data.
                    Ignores parameters with names in $ignor. Returns the string with parameters
         *
         * @param   array       array
         * @param   arrayname   string
         * @param   ignor       array
         * @return  string
         */
        function arrayToParameters($array, $arrayname, $ignor){
        	
        	//	possible improvement - handle none arrays first!!!!!
			
        	$ignor = array_merge($ignor, array_keys($_COOKIE));
        	
            $parastr = "";
            foreach ($array AS $key => $val){
                if( !in_array($key, $ignor) ){
                    if($arrayname != ""){
                    	$key = "[" . $key . "]";
                    }
                    if(is_array($val)){
                        $parastr .= we_SEEM::arrayToParameters($val, $arrayname . $key, $ignor);
                    } else if($val != ""){
                        $parastr .= "&" . $arrayname . $key . "=" . $val;
                    }
                }
            }
            return strlen($parastr) > 255 ? substr($parastr, 0 , 255) : $parastr;
        }
        
        /**
	     *
         * Gets the correct JavaScript-command for one single link.
         * The result is the same like selecting the document in the left side in the
         * document-tree
         *
         * @param   link   		string
         * @return  string
         */
        function getJavaScriptCommandForOneLink($link){
        	
        	$linkArray = we_SEEM::getAllHrefs($link);

        	//  Remove all other Stuff from the linkArray
            //  Here all SEEM - Links are removed as well
            $linkArray = we_SEEM::onlyUseHyperlinks($linkArray);

            //  if an array is returned in onlyUseHyperlinks, then parse the $code, otherwise return the same code.
            if($linkArray && is_array($linkArray)){

                //  Remove all javascript, or target stuff, from links, they could disturb own functionality
                //  Important are $linkArray[1][*] and $linkArray[4][*1]
                $linkArray = we_SEEM::cleanLinks($linkArray);

                //  $linkArray[5] - Array of the relative translation of given Link-targets, only with webEdition-Docs
                $linkArray[5] = we_SEEM::findRelativePaths($linkArray[2]);
				
                //  $linkArray[6] - Array which contains the docIds of the Documents, or -1
                $linkArray[6] = we_SEEM::getDocIDsByPaths($linkArray[5]);
                
                //	$linkArray[7] - contains the ContentTypes of the target, or ''
                $linkArray[7] = we_SEEM::getDocContentTypesByID($linkArray[6]);

                $code = we_SEEM::link2we_cmd($linkArray);
            }
        	return $code;
        }
        
        /**
         * Parses a single link (with several data stored in $linkarray) to a we_cmd!
         *
         * @param   linkArray	array
         * @return  string
         */
        function link2we_cmd($linkArray){
        	
        	$i = 0;
        	
        	$code = "";
        	
	        //  The target of the Link is a webEdition - Document.
	        if($linkArray[6][$i] != -1){
	        	
	        	if($linkArray[3][$i] != ""){	//  we have several parameters, deal with them

	                $theParameterArray = we_SEEM::getAttributesFromGet($linkArray[3][$i], "we_cmd");
	                
	                if(array_key_exists ("we_objectID", $theParameterArray)){	//	target is a object
	                	
	                	$code = "" . we_SEEM::getClassVars("vtabSrcObjs") . "top.doClickDirect('" . $theParameterArray["we_objectID"] . "','objectFile','" . OBJECT_FILES_TABLE . "');";
	                	
	                } else {	//	target is a normal file.
	                	$theParameters = we_SEEM::arrayToParameters($theParameterArray, "", array("we_cmd") );
	                	$code = "" . we_SEEM::getClassVars("vtabSrcDocs") . "top.doClickWithParameters('" . $linkArray[6][$i] . "','" . $linkArray[7][$i] . "','" . FILE_TABLE . "', '" . $theParameters . "');";
	                }
	                
	            } else {	//	No Parameters
	
	                $code = "" . we_SEEM::getClassVars("vtabSrcDocs") . "top.doClickDirect(" . $linkArray[6][$i] . ",'" . $linkArray[7][$i] . "','" . FILE_TABLE . "');";
	
	            }

	            //  The target is NO webEdition - Document
	        } else {
	            
	            //  Target document is on another Web-Server - leave webEdition !!!!!
	            if( substr($linkArray[5][$i],0,7) == "http://" ){

	                $code = "window.open('" . $linkArray[5][$i] . $linkArray[3][$i] ."','_blank');";
	            
	            //  Target is on the same Werb-Server - open doc with webEdition.
	            } else {
	                //  it is a command link - use open_document_with_parameters
	                
	                if(substr($linkArray[5][$i],0,22) == "/webEdition/we_cmd.php"){
	                    
	                    //  Work with the parameters ...
	                    $theParameters = "";
	                    
	                    if($linkArray[3][$i] != ""){
	                        $theParametersArray = we_SEEM::getAttributesFromGet($linkArray[3][$i], "we_cmd");
	                        $theParameters = we_SEEM::arrayToParameters($theParametersArray, "", array("we_cmd") );
	                    }
	                    
	                    if(!isset($GLOBALS["we_doc"])){
                            $GLOBALS["we_doc"]->ID = $_SESSION["we_data"][$theParametersArray["we_transaction"]][0]["ID"];
	                    }
	                    
	                    if(isset($theParameterArray) && is_array($theParameterArray) && array_key_exists ("we_objectID", $theParameterArray)){	//	target is a object
                        	
	                    	$code = "top.doClickDirect('" . $theParameterArray["we_objectID"] . "','objectFile','" . OBJECT_FILES_TABLE . "')";
                        	
                        } else {
                        	
                        	$code = "top.doClickWithParameters('" . $GLOBALS["we_doc"]->ID . "','text/webedition','" . FILE_TABLE . "', '" . $theParameters . "')";
                        }
	                    
	                } else {
	                	
	                    //  we cant save data so we neednt make object
	                    //	not recognized change of document
	                    $code = "top.doExtClick('" . $linkArray[5][$i] . $linkArray[3][$i] . "');";
	                }
	            }
	        }
        	return $code;
        }
        
        
       /**
        * @return array
        * @param array $_docIDArray
        * @desc Searchs the contentTypes of the gibven document ids - saves them in an array and returns them
        */
        function getDocContentTypesByID($_docIDArray){
        	
        	$_docContentTypes = array();
        	
        	$_len = sizeof($_docIDArray);
        	
        	for( $i=0; $i<$_len; $i++){
        		
        		if($_docIDArray[$i] != -1){
        			
        			
        			$_docContentTypes[$i] = we_SEEM::getDocContentTypeByID($_docIDArray[$i]);
        			
        		} else {
        			$_docContentTypes[$i] = '';
        		}
        	}
        	return $_docContentTypes;
        }
        
        
        /**
        * @return string
        * @param int $id
        * @desc Looks for the ContentType of the document with the given id and returns it
        */
        function getDocContentTypeByID($id){
        	
            $db = new DB_WE();
            
            $query = "
                SELECT ContentType
                FROM " . FILE_TABLE . "
                WHERE ID='" . $id . "'
            ";
            $db->query($query);

            if ($db->num_rows() == 1){

                $db->next_record();

                return $db->f("ContentType");
            } else {
                return '';
            }
        }
        
        
        /**
         * we_SEEM::addEditButtonToTag
         *
         * @desc    This function adds an edit-button to a tag, when in SEEM-Mode.
         			The button has the same effect, like switching the tab at the top of the page.
         			disabled at moment
		 *
         * @return  string
         */
        function addEditButtonToTag($which = "edit"){
			
        	if($GLOBALS["we_transaction"] != "" && $GLOBALS["we_doc"]->EditPageNr == WE_EDITPAGE_PREVIEW && isset($_SESSION["we_mode"]) && $_SESSION["we_mode"] == "seem"){

        		return "";
			} else {
				
				return "";
			}
        }
    }
?>
