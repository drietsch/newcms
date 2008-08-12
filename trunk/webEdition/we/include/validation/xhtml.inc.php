<?php

   /**
	* @return  void
	* @param   string $element
	* @param   array $attribs
	* @desc    This function checks if given attribs are elements of a certain xhtml-element
               changes attribs if removeWrong is true
	        
	*/
	function validateXhtmlAttribs($element, &$attribs, $xhtmlType, $showWrong, $removeWrong){
	    
	    // This function is only included if necessary, so include language files here.
	    include($_SERVER['DOCUMENT_ROOT'].'/webEdition/we/include/we_language/' . $GLOBALS['WE_LANGUAGE'] . '/validation.inc.php');
	    
		if($xhtmlType == "transitional"){ //	use xml-transitional
            include($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/validation/xhtml_10_transitional.inc.php');
			//   the array $_validAtts and $_reqAtts are set inside this include-file
		} else {                          //	use xml-strict
		    include($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/validation/xhtml_10_strict.inc.php');
		    //   the array $_validAtts and $_reqAtts are set inside this include-file
		}
		
		if(isset($_validAtts[$element])){	//	element exists
			//	check if all parameters are allowed.
			foreach($attribs AS $k => $v){
				if(!in_array($k, $_validAtts[$element]) && !in_array( str_replace('pass_', '', $k), $_validAtts[$element]) ){
					
				    $removeText = '';

				    if ($removeWrong){
				        $removeText = ' ' . $l_xhtml_debug['removed_element']['text'];
			            unset($attribs[$k]);
				    }
				    			    
				    if ($showWrong){
				        if(isset($_SESSION['prefs']['xhtml_show_wrong_text']) && $_SESSION['prefs']['xhtml_show_wrong_text']){
                            print '<p>' . sprintf($l_xhtml_debug['wrong_attribute']['text'] . $removeText, $k, $element) . '</p>';
				        }
				        if(isset($_SESSION['prefs']['xhtml_show_wrong_js']) && $_SESSION['prefs']['xhtml_show_wrong_js']){
				        	print we_htmlElement::jsElement(we_message_reporting::getShowMessageCall(sprintf(sprintf($l_xhtml_debug['wrong_attribute']['error_log'],$k,$element) . $removeText), WE_MESSAGE_ERROR));
				        }
				        if(isset($_SESSION['prefs']['xhtml_show_wrong_error_log']) && $_SESSION['prefs']['xhtml_show_wrong_error_log']){
				            error_log(sprintf($l_xhtml_debug['wrong_attribute']['error_log'],$k,$element) . $removeText);
				        }
				    }
				}
			}
			
			//	check if all required parameters are there.
			if(array_key_exists($element, $_reqAtts)){
				foreach($_reqAtts[$element] AS $required){

					if(!array_key_exists($required, $attribs)){
					    
					    if ($showWrong){
                            if(isset($_SESSION['prefs']['xhtml_show_wrong_text']) && $_SESSION['prefs']['xhtml_show_wrong_text']){
                                print '<p>' . sprintf($l_xhtml_debug['missing_attribute']['text'],$required,$element) . '</p>';
                            }
                            if(isset($_SESSION['prefs']['xhtml_show_wrong_js']) && $_SESSION['prefs']['xhtml_show_wrong_js']){
                            	print we_htmlElement::jsElement(we_message_reporting::getShowMessageCall( sprintf($l_xhtml_debug['missing_attribute']['error_log'],$required,$element) , WE_MESSAGE_ERROR));
                            	
                            }
                            if(isset($_SESSION['prefs']['xhtml_show_wrong_error_log']) && $_SESSION['prefs']['xhtml_show_wrong_error_log']){
                                error_log(sprintf($l_xhtml_debug['missing_attribute']['error_log'],$required,$element));
                            }
                        }
					}
				}
			}
		
		} else {  //	element does not exist
            if ($showWrong) {
                if(isset($_SESSION['prefs']['xhtml_show_wrong_text']) && $_SESSION['prefs']['xhtml_show_wrong_text']){
                    print '<p>' . sprintf($l_xhtml_debug['wrong_element']['text'],$element) . '</p>';
                }
                if(isset($_SESSION['prefs']['xhtml_show_wrong_js']) && $_SESSION['prefs']['xhtml_show_wrong_js']){
                	print we_htmlElement::jsElement(we_message_reporting::getShowMessageCall( sprintf($l_xhtml_debug['wrong_element']['error_log'], $element) , WE_MESSAGE_ERROR));
                }
                if(isset($_SESSION['prefs']['xhtml_show_wrong_error_log']) && $_SESSION['prefs']['xhtml_show_wrong_error_log']){
                    error_log(sprintf($l_xhtml_debug['wrong_element']['error_log'],$element));
                }
            }
            if ($removeWrong){
                //  nothing
            }
		}
	}
?>