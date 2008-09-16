<?php
/**
 * webEdition CMS
 *
 * LICENSETEXT_CMS
 *
 *
 * @category   webEdition
 * @package    webEdition_base
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/licence     LICENSETEXT_CMS  TODO insert license type and url
 */

include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/utils/"."rndGenPass.inc.php");

function we_tag_sessionField($attribs,$content) {
	$foo = attributFehltError($attribs,"name","sessionField");if($foo) return $foo;

	$name = we_getTagAttribute("name",$attribs);
	$xml = we_getTagAttribute("xml",$attribs,"",true);
	$removeFirstParagraph = we_getTagAttribute("removefirstparagraph",$attribs,0,true,true);
	$autobrAttr = we_getTagAttribute("autobr",$attribs,"",true);
	$checked = we_getTagAttribute("checked",$attribs,"",true);
	$values = we_getTagAttribute("values",$attribs);
	$type = we_getTagAttribute("type",$attribs);
	$size = we_getTagAttribute("size",$attribs);
	$dateformat = we_getTagAttribute("dateformat",$attribs);
	$value = we_getTagAttribute("value",$attribs);
	$orgVal = (isset($_SESSION["webuser"][$name]) && (strlen($_SESSION["webuser"][$name]) > 0)) ? $_SESSION["webuser"][$name] : (($type=="radio") ? "" : $value);


	   $autofill = we_getTagAttribute("autofill",$attribs,false);
    if($autofill) {
              $condition = array('caps'=>3, 'small'=>4, 'nums'=>3, 'specs'=>2);
               $pass=new rndConditionPass(7,$condition);
                $orgVal=$pass->PassGen();
                //echo $tmppass;

    }

    switch($type) {
		case "select":

            $newAtts = removeAttribs($attribs, array('checked','type','options','selected','onchange','onChange','name','value','values','onclick','onClick','mode','choice','pure','rows','cols','maxlength','wysiwyg'));
			return we_getSelectField('s['.$name.']',$orgVal,$values,$newAtts,true);
		case "choice":

        	$newAtts = removeAttribs($attribs, array('checked','type','options','selected','onchange','onChange','name','value','values','onclick','onClick','mode','choice','pure','maxlength','rows','cols','wysiwyg'));

			$mode = we_getTagAttribute("mode",$attribs);
			return we_getInputChoiceField('s['.$name.']',$orgVal, $values, $newAtts, $mode);
		case "textinput":
			$choice = we_getTagAttribute("choice",$attribs,"",true);
			if($choice) { // because of backwards compatibility

                $newAtts = removeAttribs($attribs, array('checked','type','options','selected','onchange','onChange','name','value','values','onclick','onClick','mode','choice','pure','wysiwyg','maxlength','rows','cols'));
	            $newAtts['name'] = 's['.$name.']';

				$optionsAr = makeArrayFromCSV(we_getTagAttribute("options",$attribs));
				$isin = 0;
				$options = '';
				for($i=0;$i<sizeof($optionsAr);$i++) {
					if ($optionsAr[$i]==$orgVal) {
					    $options .= getHtmlTag('option',array('value'=>htmlspecialchars($optionsAr[$i]),'selected'=>'selected'),$optionsAr[$i]) . "\n";
						$isin=1;
					}
					else {
						$options .= getHtmlTag('option',array('value'=>htmlspecialchars($optionsAr[$i])),$optionsAr[$i]) . "\n";
					}
				}
				if(!$isin) {
					$options .= getHtmlTag('option',array('value'=>htmlspecialchars($orgVal),'selected'=>'selected'),htmlspecialchars($orgVal)) . "\n";
				}
  				return getHtmlTag('select',$newAtts, $options,true);
  			} else {
                $newAtts = removeAttribs($attribs, array('checked','type','options','selected','onchange','onChange','name','value','values','onclick','onClick','mode','choice','pure','wysiwyg','rows','cols'));
  			    return we_getInputTextInputField('s['.$name.']',$orgVal,$newAtts);
			}
		case "textarea":
            $pure = we_getTagAttribute("pure",$attribs,"",true);
			if($pure){

			    $newAtts = removeAttribs($attribs, array('checked','type','options','selected','onchange','onChange','name','value','values','onclick','onClick','mode','choice','pure','size','wysiwyg'));
				return we_getTextareaField('s['.$name.']',$orgVal,$newAtts);

			} else {
    			include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_forms.inc.php");
    			include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/js/we_textarea_include.inc.php");
    			$pure = we_getTagAttribute("pure",$attribs,"",true);
    			$autobr = $autobrAttr ? "on" : "off";
    			$showAutobr = isset($attribs["autobr"]);
    			return we_forms::weTextarea('s['.$name.']',$orgVal,$attribs,$autobr,"autobr",$showAutobr,$GLOBALS["we_doc"]->getHttpPath(),false,false,$xml,$removeFirstParagraph,"");
			}
		case "radio":
			if((!isset($_SESSION["webuser"][$name])) && $checked) {
			    $orgVal = $value;
			}

			$newAtts = removeAttribs($attribs, array('checked','type','options','selected','onchange','onChange','name','value','values','onclick','onClick','mode','choice','pure','rows','cols','wysiwyg'));

 			return we_getInputRadioField('s['.$name.']',$orgVal,$value,$newAtts);
		case "checkbox":

		    $newAtts = removeAttribs($attribs, array('checked','type','options','selected','name','value','values','onclick','onClick','mode','choice','pure','rows','cols','wysiwyg'));

			if((!isset($_SESSION["webuser"][$name])) && $checked){
                $orgVal = 1;
			}
 			return we_getInputCheckboxField('s['.$name.']',$orgVal,$newAtts);
 		case "password":
 		    $newAtts = removeAttribs($attribs, array('checked','options','selected','onChange','name','value','values','onclick','onClick','mode','choice','pure','rows','cols','wysiwyg'));
	        $newAtts['name'] = 's['.$name.']';
            $newAtts['value'] = htmlspecialchars($orgVal);
            return getHtmlTag('input',$newAtts);
		case "print":
			if (is_numeric($orgVal) && !empty($dateformat)) {
				return date($dateformat, $orgVal);
			} elseif (!empty($dateformat) && $weTimestemp=strtotime($orgVal)) {
				return date($dateformat, $weTimestemp);
			}
			return $orgVal;
		case "hidden":
            $_hidden['type'] = 'hidden';
            $_hidden['name'] = 's['.$name.']';
            $_hidden['value'] = $orgVal;
            $_hidden['xml'] = $xml;
            return getHtmlTag('input', $_hidden);

		case "img":

			$we_button = new we_button();
			include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/parser.inc.php");

			$foo = attributFehltError($attribs, "parentid", "sessionField");if($foo) return $foo;

			if (!isset($_SESSION["webuser"]['imgtmp'])) {
				$_SESSION["webuser"]['imgtmp'] = array();
			}
			if (!isset($_SESSION["webuser"]['imgtmp'][$name])) {
				$_SESSION["webuser"]['imgtmp'][$name] = array();
			}

			$_SESSION["webuser"]['imgtmp'][$name]["parentid"] = we_getTagAttribute("parentid",$attribs, "0");
			$_SESSION["webuser"]['imgtmp'][$name]["width"] = we_getTagAttribute("width",$attribs,0);
			$_SESSION["webuser"]['imgtmp'][$name]["height"] = we_getTagAttribute("height",$attribs,0);
			$_SESSION["webuser"]['imgtmp'][$name]["quality"] = we_getTagAttribute("quality",$attribs,"8");
			$_SESSION["webuser"]['imgtmp'][$name]["keepratio"] = we_getTagAttribute("keepratio",$attribs,"",true, true);
			$_SESSION["webuser"]['imgtmp'][$name]["maximize"] = we_getTagAttribute("maximize",$attribs,"",true);
			$_SESSION["webuser"]['imgtmp'][$name]["id"] = $orgVal ? $orgVal : '';

			$_foo = id_to_path($_SESSION["webuser"]['imgtmp'][$name]["id"]);
			if (!$_foo) {
				$_SESSION["webuser"]['imgtmp'][$name]["id"] = 0;
			}

			$bordercolor = we_getTagAttribute("bordercolor",$attribs, "#006DB8");
			$checkboxstyle = we_getTagAttribute("checkboxstyle",$attribs);
			$inputstyle = we_getTagAttribute("inputstyle",$attribs);
			$checkboxclass = we_getTagAttribute("checkboxclass",$attribs);
			$inputclass = we_getTagAttribute("inputclass",$attribs);
			$checkboxtext = we_getTagAttribute("checkboxtext",$attribs, $GLOBALS["l_parser"]["delete"]);

			if($_SESSION["webuser"]['imgtmp'][$name]["id"]){
			    $attribs["id"] = $_SESSION["webuser"]['imgtmp'][$name];
			}

			unset($attribs["width"]);
			unset($attribs["height"]);


			$imgId = $_SESSION["webuser"]['imgtmp'][$name]["id"];

			include_once($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/"."we_classes/we_document.inc.php");
			$imgTag = we_document::getFieldByVal($imgId, "img");

			$checked = '';


			return '<table border="0" cellpadding="2" cellspacing="2" style="border: solid ' . $bordercolor . ' 1px;">
				<tr>
					<td class="weEditmodeStyle" colspan="2" align="center">' .
					$imgTag . '
						<input type="hidden" name="s[' . $name . ']" value="'.$_SESSION["webuser"]['imgtmp'][$name]["id"].'" /></td>
				</tr>
				<tr>
					<td class="weEditmodeStyle" colspan="2" align="left">
						<input'.($size ? ' size="'.$size.'"' : '').' name="WE_SF_IMG_DATA['.$name.']" type="file" accept="'.IMAGE_CONTENT_TYPES.'"'.($inputstyle ? (' style="'.$inputstyle.'"') : '').($inputclass ? (' class="'.$inputclass.'"') : '').' />
					</td>
				</tr>
				<tr>
					<td class="weEditmodeStyle" colspan="2" align="left">
						<table border="0" cellpadding="0" cellspacing="0">
							<tr>
								<td style="padding-right: 5px;">
									<input style="border:0px solid black;" type="checkbox" id="WE_SF_DEL_CHECKBOX_' . $name . '" name="WE_SF_DEL_CHECKBOX_' . $name . '" value="1" '.$checked.'/>
								</td>
								<td>
									<label for="WE_SF_DEL_CHECKBOX_' . $name . '"'.($checkboxstyle ? (' style="'.$checkboxstyle.'"') : '').($checkboxclass ? (' class="'.$checkboxclass.'"') : '').'>'.$checkboxtext.'</label>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>';

	}
}
?>