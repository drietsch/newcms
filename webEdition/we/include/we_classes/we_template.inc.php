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


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_classes/we_document.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_live_tools.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_linklist.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_tagParser.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/parser.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/cache.inc.php");

/* a class for handling templates */
class we_template extends we_document
{
    //######################################################################################################################################################
    //##################################################################### Variables ######################################################################
    //######################################################################################################################################################

    /* Name of the class => important for reconstructing the class from outside the class */
    var $ClassName="we_template";

    /* Icon which is shown at the tree-menue  */
    var $Icon="template.gif";
    var $Published="1";

	var $EditPageNrs = array(WE_EDITPAGE_PROPERTIES,WE_EDITPAGE_INFO,WE_EDITPAGE_CONTENT,WE_EDITPAGE_PREVIEW,WE_EDITPAGE_PREVIEW_TEMPLATE,WE_EDITPAGE_VARIANTS);

    var $DocTypes;

    var $InWebEdition = true;
    var $Table = TEMPLATES_TABLE;
    var $MasterTemplateID = 0;
    var $TagWizardCode; // bugfix 1502
    var $TagWizardSelection; // bugfix 1502
    var $IncludedTemplates = "";
	var $ContentType="text/weTmpl";

    //######################################################################################################################################################
    //##################################################################### FUNCTIONS ######################################################################
    //######################################################################################################################################################


    //##################################################################### INIT FUNCTIONS ######################################################################

   /* Constructor */
    function we_template()
    {
        $this->we_document();
        $this->CacheType = defined("WE_CACHE_TYPE") ? WE_CACHE_TYPE : "none";
        $this->CacheLifeTime = defined("WE_CACHE_LIFETIME") ? WE_CACHE_LIFETIME : 0;
		array_push($this->persistent_slots,"MasterTemplateID","IncludedTemplates","CacheType","CacheLifeTime", "TagWizardCode", "TagWizardSelection");
    }

    function copyDoc($id){
  		if($id){
			$temp = new we_template();
			$temp->InitByID($id,TEMPLATES_TABLE);
			$parentIDMerk=$this->ParentID;
			if($this->ID==0){
				for($i=0;$i<sizeof($this->persistent_slots);$i++){
					if($this->persistent_slots[$i] != "elements")
						eval('$this->'.$this->persistent_slots[$i].'=$temp->'.$this->persistent_slots[$i].';');
				}
				$this->CreationDate=time();
				$this->ID=0;
				$this->OldPath="";
				$this->Filename .= "_copy";
				$this->Text=$this->Filename.$this->Extension;
				$this->setParentID($parentIDMerk);
				$this->Path=$this->ParentPath.$this->Text;
				$this->OldPath=$this->Path;
			}
			$temp->resetElements();
			while(list($k,$v) = $temp->nextElement("txt")){
				$this->setElement($k,$temp->getElement($k),"txt");
			}
			$this->EditPageNr=0;
		}
    }





    //##################################################################### EDITOR FUNCTION ######################################################################

    /* must be called from the editor-script. Returns a filename which has to be included from the global-Script */
    function editor()
    {
        switch($this->EditPageNr){
            case WE_EDITPAGE_PROPERTIES:
                return "we_templates/we_editor_properties.inc.php";
            case WE_EDITPAGE_INFO:
                return "we_templates/we_editor_info.inc.php";
            case WE_EDITPAGE_CONTENT:
                $GLOBALS["we_editmode"] = true;
                return "we_templates/we_srcTmpl.inc.php";
            case WE_EDITPAGE_PREVIEW:
                $GLOBALS["we_editmode"] = true;
                $GLOBALS["we_file_to_delete_after_include"] = TMP_DIR."/".md5(uniqid(rand()));
                saveFile($GLOBALS["we_file_to_delete_after_include"],$this->i_getDocument());
                return $GLOBALS["we_file_to_delete_after_include"];
                break;
            case WE_EDITPAGE_PREVIEW_TEMPLATE:
                $GLOBALS["we_editmode"] = false;
                $GLOBALS["we_file_to_delete_after_include"] = TMP_DIR."/".md5(uniqid(rand()));
                saveFile($GLOBALS["we_file_to_delete_after_include"],$this->i_getDocument());
                return $GLOBALS["we_file_to_delete_after_include"];
                break;
            case WE_EDITPAGE_VARIANTS:
                $GLOBALS["we_editmode"] = true;
                return 'we_templates/we_editor_variants.inc.php';
                break;
            default:
                $this->EditPageNr = WE_EDITPAGE_PROPERTIES;
                $_SESSION["EditPageNr"] = WE_EDITPAGE_PROPERTIES;
                return "we_templates/we_editor_properties.inc.php";
        }
    }

    //##################################################################### PARSE FUNCTIONS ######################################################################
	function checkEndtags($tagname,$eq,$tags){
		$start=0;
		$end=0;
		for($i=0;$i<sizeof($tags);$i++){
			if(!ereg("ifNoJavaScript",$tags[$i])){
				if($eq){
					if(ereg('<we:'.$tagname.'[> ]',$tags[$i])) $start ++;
					if(ereg('</we:'.$tagname.'[> ]',$tags[$i])) $end ++;
				}else{
					if(ereg('<we:'.$tagname,$tags[$i])) $start ++;
					if(ereg('</we:'.$tagname,$tags[$i])) $end ++;
				}
			}
		}
		if($start != $end){
			return parseError(sprintf($GLOBALS["l_parser"]["start_endtag_missing"],$tagname.((!$eq) ? "..." : "")));
		}
		return "";
	}
	function removeDoppel($tags){
		$out = array();
		for($i=0;$i<sizeof($tags);$i++){
			if(!in_array($tags[$i],$out)) array_push($out,$tags[$i]);
		}
		return $out;
	}

	function findIfStart($tags,$nr){
		if ($nr == 0) {
			return -1;
		} else {
			$foo = array();
			$regs = array();
			for ($i = $nr; $i >= 0; $i--) {
				if (ereg('</we:if([^> ]+) ?>?', $tags[$i], $regs)) {
					$foo[trim($regs[1])] = isset($foo[trim($regs[1])]) ? abs($foo[trim($regs[1])]) + 1 : 1;
				} else if (ereg('<we:if([^> ]+) ?>?', $tags[$i], $regs)) {
					$tagname = trim($regs[1]);
					if (sizeof($foo) == 0) {
						return $i;
					} else if (isset($foo[$tagname]) && abs($foo[$tagname])) {
						$foo[$tagname] = abs($foo[$tagname]) - 1;
					} else {
						return $i;
					}
				}
			}
		}
		return -1;
	}

	function findIfEnd($tags,$nr){
		if($nr == sizeof($tags)) return -1;
		$foo = array();
		$regs = array();
		for($i = $nr;$i < sizeof($tags);$i++){
			if(ereg('<we:if([^> ]+) ?>?',$tags[$i],$regs)){
				$foo[trim($regs[1])] = isset($foo[ trim($regs[1]) ]) ? abs( $foo[ trim($regs[1]) ] ) + 1 : 1;
			}else if(ereg('</we:if([^> ]+) ?>?',$tags[$i],$regs)){
				$tagname = trim($regs[1]);
				if(sizeof($foo) == 0) return $i;
				else if( isset($foo[$tagname]) && abs($foo[$tagname]) ){
				    $foo[$tagname] = abs($foo[$tagname]) -1;
	            }
				else return $i;
			}
		}
		return -1;
	}

	function checkElsetags($tags){
		for($i=0;$i<sizeof($tags);$i++){
			if(ereg('<we:else',$tags[$i])){
				$ifStart = $this->findIfStart($tags,$i);
				if($ifStart == -1) return parseError($GLOBALS["l_parser"]["else_start"]);
				if($this->findIfEnd($tags,$i) == -1 ) return parseError($GLOBALS["l_parser"]["else_end"]);
			}
		}
		return "";
	}

	function parseTemplate()
	{
	    $code = $this->getTemplateCode(true);

	 	$tp = new we_tagParser();
		$code = str_replace("<?xml",'<?php print "<?xml"; ?>',$code);
		//$code = preg_replace('/(< *\/? *we:[^>]+>\n)/i','\1'."\n",$code);
		$tags = $tp->getAllTags($code);
		$code = eregi_replace('(</?form[^>]*>)','<?php if(!isset($GLOBALS["we_editmode"]) || !$GLOBALS["we_editmode"]): ?>\1<?php endif ?>',$code);
		$foo = $this->checkElsetags($tags);if($foo) return $foo;
		$foo = $this->checkEndtags("if",0,$tags);if($foo) return $foo;

		$d = dir($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_tags");
		$needEndtags=array();
		while (false !== ($entry=$d->read())) {
			if(substr($entry,0,7) == "we_tag_" && substr($entry,0,9) != "we_tag_if"){
				$foo = $_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_tags/".$entry;

				$file = file($foo);
				foreach($file as $foo){
					if(preg_match('/\$GLOBALS\["needs_endtag"\][\s*]=[\s*][{\',"}]*([a-zA-Z0-9]*)[{\',"}]*;/i',$foo,$reg) && ($reg[1]=="1" || $reg[1]=="true")){

						$foo = eregi_replace('^we_tag_([^\.]+)\..+$','\1',$entry);
						array_push($needEndtags,$foo);
					}
				}
			}
		}

		$d->close();
		foreach($needEndtags as $tagname){
			$foo = $this->checkEndtags($tagname,1,$tags);if($foo) return $foo;
		}

		$tp->parseTags($tags,$code);

		/*$tags = $this->removeDoppel($tags);
		for($i=0;$i<sizeof($tags);$i++){
			$tp->parseTag($tags[$i],$code);
		}*/


		// Code must be executed every time a template is included,
		// so it must be executed during the caching process when a cacheable document
		// is called for the first time and every time the document come from the cache
		// Because of this reason the following code must be putted out directly and(!)
		// echoed in templates with CacheType = document
		$pre_code = '<?php
	// Activate the webEdition error handler
	include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/base/we_error_handler.inc.php");
	we_error_handler(false);

	include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_global.inc.php");
	include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_tag.inc.php");
	$GLOBALS["DB_WE"] = new DB_WE;
	$GLOBALS["weEconda"]=array("HTML"=>"","JS"=>"");
	';
	$pre_code .= 'if($GLOBALS["we_doc"]){
		$GLOBALS["WE_DOC_ID"] = $GLOBALS["we_doc"]->ID;
		if(!isset($GLOBALS["WE_MAIN_ID"])) $GLOBALS["WE_MAIN_ID"] = $GLOBALS["we_doc"]->ID;
		if(!isset($GLOBALS["WE_MAIN_DOC"])) $GLOBALS["WE_MAIN_DOC"] = clone($GLOBALS["we_doc"]);
		if(!isset($GLOBALS["WE_MAIN_DOC_REF"])) $GLOBALS["WE_MAIN_DOC_REF"] = &$GLOBALS["we_doc"];
		if(!isset($GLOBALS["WE_MAIN_EDITMODE"])) $GLOBALS["WE_MAIN_EDITMODE"] = isset($GLOBALS["we_editmode"]) ? $GLOBALS["we_editmode"] : "";
		$GLOBALS["WE_DOC_ParentID"] = $GLOBALS["we_doc"]->ParentID;
		$GLOBALS["WE_DOC_Path"] = $GLOBALS["we_doc"]->Path;
		$GLOBALS["WE_DOC_IsDynamic"] = $GLOBALS["we_doc"]->IsDynamic;
		$GLOBALS["WE_DOC_FILENAME"] = $GLOBALS["we_doc"]->Filename;
		$GLOBALS["WE_DOC_Category"] = isset($GLOBALS["we_doc"]->Category) ? $GLOBALS["we_doc"]->Category : "";
		$GLOBALS["WE_DOC_EXTENSION"] = $GLOBALS["we_doc"]->Extension;
		$GLOBALS["TITLE"] = $GLOBALS["we_doc"]->getElement("Title");
		$GLOBALS["KEYWORDS"] = $GLOBALS["we_doc"]->getElement("Keywords");
		$GLOBALS["DESCRIPTION"] = $GLOBALS["we_doc"]->getElement("Description");
		$GLOBALS["CHARSET"] = $GLOBALS["we_doc"]->getElement("Charset");
		$__tmp = explode("_",$GLOBALS["we_doc"]->Language);
		$__lang = strtolower($__tmp[0]);
		if ($__lang) {
			$__parts = split("_", $GLOBALS["WE_LANGUAGE"]);
			$__last = array_pop($__parts);
			// Charset of page is not UTF-8 but languge files of page are UTF-8
			// Then change language files to non UTF-8 pedant if available
			if (count($__parts) && $__last === "UTF-8" && $GLOBALS["CHARSET"] !== "UTF-8") {
				$__lang = $__parts[0];
				if (file_exists($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$__lang)) {
					$GLOBALS["WE_LANGUAGE"] = $__lang;
					include($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/date.inc.php");
				}


			// Charset of page is  UTF-8 but languge files of page are not UTF-8
			// Then change language files to UTF-8 pedant if available
			} else if ($__last !== "UTF-8" && $GLOBALS["CHARSET"] === "UTF-8") {
				$__lang = $GLOBALS["WE_LANGUAGE"] . "_UTF-8";
				if (file_exists($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$__lang)) {
					$GLOBALS["WE_LANGUAGE"] = $__lang;
					include($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/date.inc.php");
				}
			}
		}
	}
	';
	$pre_code .= '?>';
		if($this->CacheType=="document" && $this->CacheLifeTime > 0) {
			$pre_code .= "<?php echo '".str_replace("'", "\'", $pre_code)."'; ?>";
		}


		$head = '
<?php if(isset($GLOBALS["we_editmode"]) && $GLOBALS["we_editmode"] ){ ?>
<?php print STYLESHEET_BUTTONS_ONLY . SCRIPT_BUTTONS_ONLY; ?>
<script language="JavaScript" type="text/javascript" src="<?php print JS_DIR; ?>windows.js"></script>
<?php include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_editors/we_editor_script.inc.php"); ?>
<?php } else if(defined("WE_ECONDA_STAT") && defined("WE_ECONDA_PATH") && WE_ECONDA_STAT  && WE_ECONDA_PATH !="" && !$GLOBALS["we_doc"]->InWebEdition) { 
	include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/weTracking/econda/weEcondaImplementHeader.inc.php");
} ?>';

		$preContent = '<?php if (isset($GLOBALS["we_editmode"]) && $GLOBALS["we_editmode"]) { ?>
<form name="we_form" method="post" onsubmit="return false;"><?php $GLOBALS["we_doc"]->pHiddenTrans() ?>
<?php } ?>';

		$postContent = '<?php if (isset($GLOBALS["we_editmode"]) && $GLOBALS["we_editmode"]) { ?>
</form>
<?php } else if(defined("WE_ECONDA_STAT") && defined("WE_ECONDA_PATH") && WE_ECONDA_STAT  && WE_ECONDA_PATH !="" && !$GLOBALS["we_doc"]->InWebEdition) { 
	include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/weTracking/econda/weEcondaImplement.inc.php");
} ?>';

		if($this->hasStartAndEndTag("html",$code) && $this->hasStartAndEndTag("head",$code) && $this->hasStartAndEndTag("body",$code)){
			$pre_code = '<?php $GLOBALS["WE_HTML_HEAD_BODY"] = true; ?>'.$pre_code;

			//#### parse base href
			$code = eregi_replace('(</title>)','\1'.'<?php if(isset($GLOBALS["we_baseHref"]) && $GLOBALS["we_baseHref"]): ?><base href="<?php print $GLOBALS["we_baseHref"] ?>" /><?php endif ?>',$code);

			$code = eregi_replace("</head>","$head</head>",$code);

			$code = str_replace("?>","__WE_?__WE__",$code);
			$code = str_replace("=>","__WE_=__WE__",$code);

			$code = eregi_replace("(<body[^>]*)(>)","\\1<?php if(isset(\$GLOBALS[\"we_editmode\"]) && \$GLOBALS[\"we_editmode\"]) print ' onUnload=\"doUnload()\"'; ?>\\2$preContent",$code);

			$code = str_replace("__WE_?__WE__","?>",$code);
			$code = str_replace("__WE_=__WE__","=>",$code);

			$code = eregi_replace("(</body>)","$postContent\\1",$code);

		}else if(!$this->hasStartAndEndTag("html",$code) && !$this->hasStartAndEndTag("head",$code) && !$this->hasStartAndEndTag("body",$code)){
			$code = '<?php if( (!isset($GLOBALS["WE_HTML_HEAD_BODY"]) || !$GLOBALS["WE_HTML_HEAD_BODY"] ) && (isset($GLOBALS["we_editmode"]) && $GLOBALS["we_editmode"])): ?><?php $GLOBALS["WE_HTML_HEAD_BODY"] = true; ?><html><head><title></title><?php if(isset($GLOBALS["we_baseHref"]) && $GLOBALS["we_baseHref"]): ?><base href="<?php print $GLOBALS["we_baseHref"] ?>" /><?php endif ?>
'.$head.'</head>
<body <?php if(isset($we_editmode) && $we_editmode) print " onUnload=\"doUnload()\""; ?>>
'.$preContent.'<?php endif ?>'.$code.'<?php if((!isset($WE_HTML_HEAD_BODY) || !$WE_HTML_HEAD_BODY ) && (isset($we_editmode) && $we_editmode)): ?>'.$postContent.'
</body></html><?php $WE_HTML_HEAD_BODY = true; ?><?php endif ?>';

		}else{
			return parseError($GLOBALS["l_parser"]["html_tags"]);
		}
		$code .= '<?php if(isset($GLOBALS["we_editmode"]) && $GLOBALS["we_editmode"] ): ?><script language="JavaScript" type="text/javascript">setTimeout("doScrollTo();",100);</script><?php endif ?>';

		return $pre_code.$code;
	}

	function hasStartAndEndTag($tagname,$code){
		return eregi('< ?/ ?'.$tagname.'[^>]*>',$code) && eregi('< ?'.$tagname.'[^>]*>',$code) && eregi('< ?'.$tagname.'[ >]',$code) && eregi('< ?/ ?'.$tagname.'[ >]',$code);
	}

### NEU###

	function i_isElement($Name){
		return (substr($Name,0,8) == "variant_" || $Name == "data" || $Name == "Charset" || $Name == "completeData" || $Name == "allVariants");
	}

	function i_setElementsFromHTTP() {
		parent::i_setElementsFromHTTP();
		//get clean variants
		$regs = array();
		foreach($_REQUEST as $n=>$v){
			if(ereg('^we_'.$this->Name.'_variant',$n,$regs)){
				if(is_array($v)){
					foreach($v as $n2=>$v2){
						if(isset($this->elements[$n2]) && $this->elements[$n2]['type']=='variant' && $v2==0){
							unset($this->elements[$n2]);
						}
					}
				}
			}
		}
	}

	function i_getDocument($includepath=""){
		$this->_updateCompleteCode();
		$d = $this->parseTemplate();
        return $d;
  	}

	function i_writeSiteDir($doc){
		return true;
	}

	function i_writeMainDir($doc){
		if($this->i_isMoved()){
			deleteLocalFile($this->getRealPath(1));
		}
		return saveFile($this->getRealPath(),$doc);
	}

	function i_filenameNotAllowed(){
		return false;
	}


	/**
	 * returns if this template contains fields required for a shop-document.
	 *
	 * if paramter checkField is true, this function checks also, if there are
	 * already fields selected for the variants.
	 *
	 * @param boolean $checkFields
	 * @return boolean
	 */
	function canHaveVariants($checkFields = false){
		if(!defined('SHOP_TABLE')) return false;
		$fieldnames = $this->getVariantFieldNames();
		return in_array('shoptitle',$fieldnames) && in_array('shopdescription',$fieldnames);
	}

	/**
	 * @desc 	the function returns the array with selected variant field names and field attributes/types
	 * @return	array with the selected filed names and attributes
	 * @param	none
	 */
	function getVariantFields(){
		$ret = array();
		$fields = $this->getAllVariantFields();
		if(empty($fields)) return $fields;
		$element_names = array();
		$names = array_keys($this->elements);
		foreach($names as $name){
			if(substr($name,0,8)=='variant_') $element_names[] = substr($name,8);
		}
		foreach($fields as $name=>$value){
			if(in_array($name,$element_names)){
				$ret[$name] = $value;
			}
		}
		return $ret;
	}

	/**
	 * @desc 	the function returns the array with all variant field names
	 * @return	array with the varinat filed names
	 * @param	none
	 */
	function getVariantFieldNames(){
		if(!defined('SHOP_TABLE')) return array();
		$fields = $this->getAllVariantFields();
		return array_keys($fields);
	}

	/**
	 * @desc 	the function returns the array with all template field names and field attributes/types;
	 * 			if there is no fields in the elements, the template code will be parsed
	 * @return	array with the filed names and attributes
	 * @param	none
	 */
	function getAllVariantFields(){
		if(isset($this->elements['allVariants'])){
			return $this->elements['allVariants']['dat'];
		} else {
			return array();
		}
	}

	/**
	 * @desc 	the function parses the template code and returns all template field names and field attributes/types
	 * @return	array with the filed names and attributes
	 * @param	none
	 */
	function readAllVariantFields(){

		include_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_classes/we_webEditionDocument.inc.php');

		$variant_tags = array('input','link','textarea','img','select');
		$templateCode = $this->getTemplateCode();
		$tp = new we_tagParser();
		$tags = $tp->getAllTags($templateCode);

		$blocks = array();
		$out = array();

		foreach($tags as $tag) {
			if (eregi('<we:([^> /]+)',$tag,$regs)) { // starttag found
				$tagname = $regs[1];
				if (eregi('name="([^"]+)"',$tag,$regs) && ($tagname != "var") && ($tagname != "field")) { // name found
					$name = $regs[1];

					$size = sizeof($blocks);
					if($size) {
						$foo = $blocks[$size-1];
						$blockname = $foo["name"];
						$blocktype = $foo["type"];
						switch($blocktype) {
							case "block":
								$name = we_webEditionDocument::makeBlockName($blockname,$name);
								break;
							case "list":
								$name = we_webEditionDocument::makeListName($blockname,$name);
								break;
							case "linklist":
								$name = we_webEditionDocument::makeLinklistName($blockname,$name);
								break;
						}
					}


					$attributes = eregi_replace("<we:$tagname",'',$tag);

					$foo = array();
					$attribs = '';
					preg_match_all('/([^=]+)= *("[^"]*")/',$attributes,$foo,PREG_SET_ORDER);
					for($i=0;$i<sizeof($foo);$i++){
						$attribs .= '"'.trim($foo[$i][1]).'"=>'.trim($foo[$i][2]).',';
					}

					@eval('$att = array('.$attribs.');');

					if(in_array($tagname,$variant_tags)) {
						if($tagname=='input' && isset($att['type']) && $att['type']=='date'){
							// do nothing
						} else {
							$out[$name] = array(
								'type' => $tagname,
								'attributes' =>  $att
							);
						}
						//additional parsing for selects
						if($tagname=='select') {
							$spacer = "[\040|\n|\t|\r]*";
							$selregs = array();
							if (eregi('(<we:select [^name]*name'.$spacer.'[=\"|=\'|=\\\\|=]*'.$spacer . $att['name'] . '[\'\"]*[^>]*>)(.*)<'.$spacer.'/'.$spacer.'we:select'.$spacer.'>',$templateCode,$selregs)) {
								$out[$name]['content'] = $selregs[2];
							}
						}

					}

					switch($tagname) {
						case "block":
						case "list":
						case "linklist":
							$foo = array(
								"name"=>$name,
								"type"=>$tagname
									);
							array_push($blocks,$foo);
							break;
					}
				}
			} else if(eregi('</we:([^> ]+)',$tag,$regs)) { // endtag found
				$tagname = $regs[1];
				switch($tagname) {
						case "block":
						case "list":
						case "linklist":
							if(sizeof($blocks)) array_pop($blocks);
							break;
				}
			}
		}
		ksort($out);
		return $out;
	}

	function formMasterTemplate() {
		$yuiSuggest =& weSuggest::getInstance();
		$we_button = new we_button();
		$table = TEMPLATES_TABLE;
		$textname = 'MasterTemplateNameDummy';
		$idname = 'we_'.$this->Name.'_MasterTemplateID';
		$myid = $this->MasterTemplateID ? $this->MasterTemplateID : '';
		$path = f("SELECT Path FROM $table WHERE ID='$myid'","Path",$this->DB_WE);
		$alerttext=str_replace("'","\\\\\\'",$GLOBALS["l_we_class"]["same_master_template"]);
		$button = $we_button->create_button("select", "javascript:we_cmd('openDocselector',document.we_form.elements['$idname'].value,'$table','document.we_form.elements[\\'$idname\\'].value','document.we_form.elements[\\'$textname\\'].value','opener._EditorFrame.setEditorIsHot(true);if(currentID==$this->ID){" . we_message_reporting::getShowMessageCall($alerttext, WE_MESSAGE_ERROR) . "opener.document.we_form.elements[\\'$idname\\'].value=\'\';opener.document.we_form.elements[\\'$textname\\'].value=\\'\\';}','".session_id()."','','text/weTmpl',1)");
		$trashButton = $we_button->create_button("image:btn_function_trash", "javascript:document.we_form.elements['$idname'].value='';document.we_form.elements['$textname'].value='';YAHOO.autocoml.selectorSetValid('yuiAcInputMasterTemplate');_EditorFrame.setEditorIsHot(true);", true, 27, 22);

		$yuiSuggest->setAcId("MasterTemplate");
		$yuiSuggest->setContentType("folder,text/weTmpl");
		$yuiSuggest->setInput($textname,$path);
		$yuiSuggest->setLabel('');
		$yuiSuggest->setMayBeEmpty(1);
		$yuiSuggest->setResult($idname,$myid);
		$yuiSuggest->setSelector("Docselector");
		$yuiSuggest->setTable($table);
		$yuiSuggest->setWidth(388);
		$yuiSuggest->setSelectButton($button);
		$yuiSuggest->setTrashButton($trashButton);
		
		return $yuiSuggest->getHTML();
	}

	function isUsedByDocuments(){

		$paths = array();

		if ($this->ID == 0) {
			return $paths;
		}
		$this->DB_WE->query("SELECT ID, Path FROM ".FILE_TABLE." WHERE temp_template_id='".$this->ID."' OR ((temp_template_id = '' OR temp_template_id = 0) AND TemplateID = '".$this->ID."')");
		while($this->DB_WE->next_record()) {
			$paths[$this->DB_WE->f('ID')] = $this->DB_WE->f('Path');

		}
		return $paths;

	}

	function formTemplateDocuments() {
		if($this->ID == 0) {
			return $GLOBALS["l_we_class"]["no_documents"];
		}
		$we_button = new we_button();
		$textname = 'TemplateDocuments';

		$path = $this->isUsedByDocuments();


		if(sizeof($path) == 0) {
			return $GLOBALS["l_we_class"]["no_documents"];
		}

		$button = $we_button->create_button("open", "javascript:top.weEditorFrameController.openDocument('".FILE_TABLE."', document.we_form.elements['TemplateDocuments'].value, 'text/webedition');");
		$foo = $this->htmlSelect($textname, $path, 1, "", false, "", "value", 388);
		return $this->htmlFormElementTable($foo,
			"",
			"left",
			"defaultfont",
			"",
			getPixel(20,4),
			$button);
	}

	function formCacheTempl() {
		global $l_we_cache;


		$content = '
			<table border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td colspan="3" class="defaultfont">' . $l_we_cache['cache_type']. '<br />
						' . $this->htmlSelect('we_' . $this->Name . '_CacheType', array('none' => $l_we_cache['cache_type_none'], 'tag' => $l_we_cache['cache_type_wetag'], 'document' => $l_we_cache['cache_type_document'], 'full' => $l_we_cache['cache_type_full']), 1, $this->CacheType, false, "", "value", 508)	 . '</td>
				</tr>
				<tr>
					<td>
						'.getPixel(20,4).'</td>
					<td>
						'.getPixel(20,2).'</td>
					<td>
						'.getPixel(100,2).'</td>
				</tr>
				<tr>
					<td class="defaultfont" colspan="3">' . $l_we_cache['cache_lifetime'] . '</td>
				</tr>
				<tr>
					<td colspan="3">
						' . $this->htmlTextInput('we_' . $this->Name . '_CacheLifeTime', 24, $this->CacheLifeTime, 5, "", "text", 390) .
						$this->htmlSelect("we_tmp_" . $this->Name . "_select[CacheLifeTime]", $l_we_cache['cacheLifeTimes'], 1, $this->CacheLifeTime, false,"onChange=\"_EditorFrame.setEditorIsHot(true);document.forms[0].elements['we_" . $this->Name . "_CacheLifeTime'].value=this.options[this.selectedIndex].value;document.forms[0].elements['we_" . $this->Name . "_CacheLifeTime'].value=this.options[this.selectedIndex].value;\" onBlur=\"_EditorFrame.setEditorIsHot(true);\"","value",118) . '</td>
				</tr>
			</table>';
		return $content;
	}

	/**
	 * @desc 	this function returns the code of the unparsed template
	 * @return	array with the filed names and attributes
	 * @param	boolean $completeCode if true then the function returns the code of the complete template (with master template and included templates)
	 */
	function getTemplateCode($completeCode=true) {
		return $completeCode ? $this->getElement("completeData") : $this->getElement("data");
	}


	function _getAttribsArray($attributes) {
		$foo = array();
		$attribs = '';
		preg_match_all('/([^=]+)= *("[^"]*")/', $attributes, $foo, PREG_SET_ORDER);
		for ($i=0; $i<sizeof($foo); $i++){
			$attribs .= '"'.trim($foo[$i][1]).'"=>'.trim($foo[$i][2]).',';
		}
		$att = array();
		@eval('$att = array('.$attribs.');');
		return $att;
	}

	function _updateCompleteCode() {
		$code = $this->getTemplateCode(false);

		// find all we:master Tags
		$masterTags = array();

		preg_match_all("|(<we:master([^>+]*)>)([\\s\\S]*?)</we:master>|", $code, $regs, PREG_SET_ORDER);
				

		foreach ($regs as $reg) {
			$attribs = $this->_getAttribsArray(isset($reg[2]) ? $reg[2] : "");
			$name = isset($attribs["name"]) ? $attribs["name"] : "";
			if ($name) {
				if (!isset($masterTags[$name])) {
					$masterTags[$name] = array();
				}
				$masterTags[$name]["all"] = $reg[0];
				$masterTags[$name]["startTag"] = $reg[1];
				$masterTags[$name]["content"] = isset($reg[3]) ? $reg[3] : "";
				$code = str_replace($reg[0],"",$code);
			}
		}



		if ($this->MasterTemplateID != 0) {
			
			$_templates = array();
			getUsedTemplatesOfTemplate($this->MasterTemplateID, $_templates);
			if (in_array($this->ID, $_templates)) {
				$code = $GLOBALS["l_parser"]["template_recursion_error"];
			} else {
				// we have a master template. => surround current template with it
				// first get template code
				$templObj = new we_template();
				$templObj->initByID($this->MasterTemplateID,TEMPLATES_TABLE);
				$masterTemplateCode = $templObj->getTemplateCode(true);
				
				$contentTags = array();
				preg_match_all("|<we:content ?([^>+]*)/?>|", $masterTemplateCode, $contentTags, PREG_SET_ORDER);
	
				foreach ($contentTags as $reg) {
					$all = $reg[0];
					$attribs = $this->_getAttribsArray($reg[1]);
					$name = isset($attribs["name"]) ? $attribs["name"] : "";
					if ($name) {
						$we_masterTagCode = isset($masterTags[$name]["content"]) ? $masterTags[$name]["content"] : "";
						
						$masterTemplateCode = str_replace($all, $we_masterTagCode, $masterTemplateCode);
					} else {
						$masterTemplateCode = str_replace($all, $code, $masterTemplateCode);
					}
				}
	
				$code = str_replace('</we:content>', '', $masterTemplateCode);
			}
		}
		$this->IncludedTemplates = "";
		// look for included templates (<we:include type="template" id="99">)
		$tp = new we_tagParser();
		$tags = $tp->getAllTags($code);
		// go through all tags
		foreach($tags as $tag) {
			$regs = array();
			// search for include tag
			if (preg_match('|^<we:include ([^>]+)>$|i',$tag,$regs)) { // include found
			// get attributes of tag
				$attributes = $regs[1];
				$foo = array();
				$attribs = '';
				preg_match_all('/([^=]+)= *("[^"]*")/', $attributes, $foo, PREG_SET_ORDER);
				for($i=0;$i<sizeof($foo);$i++){
					$attribs .= '"'.trim($foo[$i][1]).'"=>'.trim($foo[$i][2]).',';
				}
				@eval('$att = array('.$attribs.');');
				// if type-attribute is equal to "template"
				if (isset($att["type"]) && $att["type"]=="template") {

					// if path is set - look for the id of the template
					if (isset($att["path"]) && $att["path"]) {
						// get id of template
						$templId = path_to_id($att['path'], TEMPLATES_TABLE);
						if ($templId) {
							$att["id"] = $templId;
						}
					}
					
					// if id attribute is set and greater 0
					if (isset($att["id"]) && abs($att["id"]) > 0) {
						$_templates = array();
						getUsedTemplatesOfTemplate($att["id"], $_templates);
						if (in_array($this->ID, $_templates)) {
							$code = str_replace($tag,$GLOBALS["l_parser"]["template_recursion_error"],$code);
						} else {
							// get code of template
							$templObj = new we_template();
							$templObj->initByID($att["id"],TEMPLATES_TABLE);
							$completeCode = (!(isset($att["included"]) && ($att["included"]=="false" || $att["included"]==="0" || $att["included"]=="off")));
							$includedTemplateCode = $templObj->getTemplateCode($completeCode);
							// replace include tag with template code
							$code = str_replace($tag,$includedTemplateCode,$code);
							$this->IncludedTemplates .= "," . abs($att["id"]);
						}
					}
				}
			}
		}
		if (strlen($this->IncludedTemplates) > 0) {
			$this->IncludedTemplates .= ",";
		}
		$this->setElement("completeData",$code);
	}

	function we_save($resave=0){
		$this->Extension = $GLOBALS["WE_CONTENT_TYPES"]["text/weTmpl"]["Extension"];
		$this->_updateCompleteCode();
		if(defined('SHOP_TABLE')) {
			$this->elements['allVariants'] = array();
			$this->elements['allVariants']['type'] = 'variants';
			$this->elements['allVariants']['dat'] = serialize($this->readAllVariantFields($this->elements['completeData']['dat']));
		}

		// Check if the cachetype was changed and delete all
		// cachefiles of the documents based on this template
		$this->DB_WE->query("SELECT CacheType FROM ".TEMPLATES_TABLE." WHERE ID = '".$this->ID."'");
		$OldCacheType = "";
		while($this->DB_WE->next_record()) {
			$OldCacheType = $this->DB_WE->f('CacheType');
		}
		if($OldCacheType != "" && $OldCacheType != "none" && $OldCacheType != $this->CacheType) {
			$this->DB_WE->query("SELECT ID FROM ".FILE_TABLE." WHERE temp_template_id='".$this->ID."' OR ((temp_template_id = '' OR temp_template_id = 0) AND TemplateID = '".$this->ID."')");
			while($this->DB_WE->next_record()) {
				$cacheDir = weCacheHelper::getDocumentCacheDir($this->DB_WE->f('ID'));
				weCacheHelper::clearCache($cacheDir);
			}
		}

		$_ret = we_document::we_save($resave);
		if ($_ret) {
			$tmplPathWithTmplExt = parent::getRealPath();
			if (file_exists($tmplPathWithTmplExt)) {
				unlink($tmplPathWithTmplExt);
			}
		}
		if(defined('SHOP_TABLE')) {
			$this->elements['allVariants']['dat'] = unserialize($this->elements['allVariants']['dat']);
		}
		return $_ret;
	}

	function we_load($from=LOAD_MAID_DB) {
		we_document::we_load($from);
		$this->Extension = $GLOBALS["WE_CONTENT_TYPES"]["text/weTmpl"]["Extension"];
		$this->_updateCompleteCode();
		if(defined('SHOP_TABLE') && isset($this->elements['allVariants'])) {
			$this->elements['allVariants']['dat'] = @unserialize($this->elements['allVariants']['dat']);
			if(!is_array($this->elements['allVariants']['dat'])){
				$this->elements['allVariants']['dat'] = $this->readAllVariantFields($this->elements['completeData']['dat']);
			}
		}
	}

	// .tmpl mod

	function getRealPath($old=false){
		return preg_replace('/.tmpl$/i','.php', parent::getRealPath($old));
	}

}

?>
