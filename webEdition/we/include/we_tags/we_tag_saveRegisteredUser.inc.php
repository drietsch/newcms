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


function we_tag_saveRegisteredUser($attribs,$content){

	$userexists = we_getTagAttribute("userexists",$attribs);
	$userempty = we_getTagAttribute("userempty",$attribs);
	$passempty = we_getTagAttribute("passempty",$attribs);
	if(isset($attribs['register'])) {
		$registerallowed = we_getTagAttribute("register",$attribs,true,true);
	} else {
		$registerallowed = true;
	}
	$protected = makeArrayFromCSV(we_getTagAttribute("protected",$attribs));

	if(defined("CUSTOMER_TABLE") && isset ($_REQUEST["s"])){
		include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/modules/customer.inc.php");
		include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_modules/customer/weCustomer.php");

		if(isset($_REQUEST["s"]["Password2"])) {
			unset($_REQUEST["s"]["Password2"]);
		}

                                           // new user ...                    || existing user
		if(isset($_REQUEST["s"]["ID"]) && (!isset($_SESSION["webuser"]["ID"]) || $_REQUEST["s"]["ID"] == $_SESSION["webuser"]["ID"])){

			if($_REQUEST["s"]["ID"]<=0 && $registerallowed){ // neuer User

				if($_REQUEST["s"]["Password"]!="" && $_REQUEST["s"]["Username"]!=""){ // wenn password und Username nicht leer
					$exists = weCustomer::customerNameExist($_REQUEST["s"]["Username"]);

					if(!$exists){ // username existiert noch nicht!

						$names = "";
						$values = "";

						// Start Schnittstelle fuer save-Funktion
						if(file_exists($_SERVER["DOCUMENT_ROOT"]."/WE_CUSTOMER_EXTERNAL_FN.php")){
							include_once($_SERVER["DOCUMENT_ROOT"]."/WE_CUSTOMER_EXTERNAL_FN.php");
							we_customer_saveFN($_REQUEST["s"]);
						}
						// Ende Schnittstelle fuer save-Funktion

						// skip protected Fields
						if(sizeof($protected) > 0) {
							foreach($_REQUEST["s"] as $name => $val) {
								if(in_array($name, $protected)) {
									unset($_REQUEST["s"][$name]);
								}
							}
						}
						we_saveCustomerImages();
						foreach($_REQUEST["s"] as $name=>$val){
							if($name=="Username"){ ### QUICKFIX !!!
								$names.="Path,";
								$values.="'/".addslashes($val)."',";
								$names.="Text,";
								$values.="'".addslashes($val)."',";
								$names.="Icon,";
								$values.="'customer.gif',";
							}
							if($name != "Text" && $name != "Path" && $name != "Icon"){
								$names.=$name.",";
								$values.="'".addslashes($val)."',";
							}
						}

						$names = ereg_replace('^(.*),$','\1',$names);
						$values = ereg_replace('^(.*),$','\1',$values);

						if($values && $names){
							// User in DB speichern
							$GLOBALS["DB_WE"]->query("INSERT INTO ".CUSTOMER_TABLE."(".$names.") VALUES(".$values.")");

							// User in session speichern
							$GLOBALS["DB_WE"]->query("SELECT ID FROM ".CUSTOMER_TABLE." WHERE Username='".$_REQUEST["s"]["Username"]."'");
							if($GLOBALS["DB_WE"]->next_record()){
								$uID=$GLOBALS["DB_WE"]->f("ID");
								$u = getHash("SELECT * from ".CUSTOMER_TABLE." WHERE ID='".$uID."'",$GLOBALS["DB_WE"]);
								$_SESSION["webuser"]=$u;
								$_SESSION["webuser"]["registered"] = true;

								$memberSinceExists=false;
								$foo = $GLOBALS["DB_WE"]->metadata(CUSTOMER_TABLE);
								for($i=0;$i<sizeof($foo);$i++){
									if($foo[$i]["name"] == "MemberSince"){
										$memberSinceExists=true;
										break;
									}
								}
								if($memberSinceExists){
									$GLOBALS["DB_WE"]->query("UPDATE ".CUSTOMER_TABLE." SET MemberSince='".time()."' WHERE ID='".$_SESSION["webuser"]["ID"]."'");
								}
								$lastAccessExists=false;
								for($i=0;$i<sizeof($foo);$i++){
									if($foo[$i]["name"] == "LastAccess"){
										$lastAccessExists=true;
										break;
									}
								}
								if($lastAccessExists){
									$GLOBALS["DB_WE"]->query("UPDATE ".CUSTOMER_TABLE." SET LastAccess='".time()."' WHERE ID='".$_SESSION["webuser"]["ID"]."'");
								}
								$GLOBALS["DB_WE"]->query("UPDATE ".CUSTOMER_TABLE." SET LastLogin='".time()."' WHERE ID='".$_SESSION["webuser"]["ID"]."'");
								echo '<a name="emos_name" title="register" rel="'.md5($uID).'" rev="0" ></a>';

							}
						}


					} elseif($_REQUEST["s"]["ID"] == $_SESSION["webuser"]["ID"]) { // Username existiert schon!

						if(!$userexists){
							$userexists = $l_customer["username_exists"];
						}

						// Eingabe in Session schreiben, damit die eingegebenen Werte erhalten bleiben!
						if(isset($_REQUEST["s"])){
							$_SESSION["webuser"]=$_REQUEST["s"];
						}
						echo '<a name="emos_name" title="register" rel="'.md5($_REQUEST["s"]["ID"]).'" rev="1" ></a>';

						print getHtmlTag('script',array('type'=>'text/javascript'), 'history.back(); ' . we_message_reporting::getShowMessageCall(sprintf($userexists,$_REQUEST["s"]["Username"]), WE_MESSAGE_FRONTEND));
					}

				}else{ // Password oder Username leer!
					// Eingabe in Session schreiben, damit die eingegebenen Werte erhalten bleiben!
					if(isset($_REQUEST["s"])){
						$_SESSION["webuser"]=$_REQUEST["s"];
					}

					if(strlen($_REQUEST["s"]["Username"]) == 0){


						if(!$userempty){
							$userempty = $l_customer["username_empty"];
						}
                        print getHtmlTag('script',array('type'=>'text/javascript'), 'history.back();' . we_message_reporting::getShowMessageCall($userempty, WE_MESSAGE_FRONTEND));

					}else if(strlen($_REQUEST["s"]["Password"]) == 0){

						if(!$passempty){
							$passempty = $l_customer["password_empty"];
						}

						echo '<a name="emos_name" title="register" rel="noUser" rev="1" ></a>';
						print getHtmlTag('script',array('type'=>'text/javascript'), 'history.back();' . we_message_reporting::getShowMessageCall($passempty, WE_MESSAGE_FRONTEND));
					}
				}

			}else{ // existierender User (Daten werden von User geaendert)!!

					error_log2($_SESSION["webuser"]);
				
					if(strlen($_REQUEST["s"]["Password"]) == 0){
					if(!$passempty){
						$passempty = $l_customer["password_empty"];
					}
					print getHtmlTag('script',array('type'=>'text/javascript'), 'history.back();' . we_message_reporting::getShowMessageCall($passempty, WE_MESSAGE_FRONTEND));

				}else{

					$Username = isset($_REQUEST["s"]["Username"]) ?  $_REQUEST["s"]["Username"] : "";

					$GLOBALS["DB_WE"]->query("SELECT ID FROM ".CUSTOMER_TABLE." WHERE Username='".$Username."' AND ID<> '".$_REQUEST["s"]["ID"]."'");
					if(!$GLOBALS["DB_WE"]->next_record()){ // es existiert kein anderer User mit den neuen Username oder username hat sich nicht geaendert
						$set_a=array();
						if(isset($_REQUEST["s"])){

							// Start Schnittstelle fuer change-Funktion
							if(file_exists($_SERVER["DOCUMENT_ROOT"]."/WE_CUSTOMER_EXTERNAL_FN.php")){
								include_once($_SERVER["DOCUMENT_ROOT"]."/WE_CUSTOMER_EXTERNAL_FN.php");
								we_customer_saveFN($_REQUEST["s"]);
							}
							// Ende Schnittstelle fuer change-Funktion

							// skip protected Fields
							if(sizeof($protected) > 0) {
								foreach($_REQUEST["s"] as $name => $val) {
									if(in_array($name, $protected)) {
										unset($_REQUEST["s"][$name]);
									}
								}
							}

							we_saveCustomerImages();

							foreach($_REQUEST["s"] as $name=>$val){
								if($name=="Username"){ ### QUICKFIX !!!
									array_push($set_a, "Path='/".$val."'");
									array_push($set_a, "Text='".$val."'");
									array_push($set_a, "Icon='customer.gif'");
								}
								if($name!="ID" && $name != "Path" && $name != "Text" && $name != "Icon"){
									array_push($set_a, $name."='".$val."'");
								}
							}

						}

						if(sizeof($set_a)){
							$set=implode(",",$set_a);
							$GLOBALS["DB_WE"]->query("UPDATE ".CUSTOMER_TABLE." SET ".$set." WHERE ID='".$_REQUEST["s"]["ID"]."'");
						}

					}else{

						if(!$userexists){
							$userexists = $l_customer["username_exists"];
						}

						print getHtmlTag('script',array('type'=>'text/javascript'), 'history.back(); ' . we_message_reporting::getShowMessageCall(sprintf($userexists,$_REQUEST["s"]["Username"]), WE_MESSAGE_FRONTEND) );
					}

					//die neuen daten in die session schreiben
					$u = getHash("SELECT * from ".CUSTOMER_TABLE." WHERE ID='".$_REQUEST["s"]["ID"]."'",$GLOBALS["DB_WE"]);

					$_SESSION["webuser"]=$u;
					$_SESSION["webuser"]["registered"] = true;
				}
			}

		}
	}
}


function we_saveCustomerImages() {

	if(isset($_FILES["WE_SF_IMG_DATA"]["name"]) && is_array($_FILES["WE_SF_IMG_DATA"]["name"])) {
		$webuserId = isset($_SESSION["webuser"]["ID"]) ? $_SESSION["webuser"]["ID"] : 0;
		foreach($_FILES["WE_SF_IMG_DATA"]["name"] as $imgName=>$filename) {
			$imgId = isset($_SESSION["webuser"][$imgName]) ? $_SESSION["webuser"][$imgName] : 0;
			$_foo = id_to_path($imgId);
			if (!$_foo) {
				$imgId = 0;
			}

			if (isset($_REQUEST["WE_SF_DEL_CHECKBOX_" . $imgName]) && $_REQUEST["WE_SF_DEL_CHECKBOX_" . $imgName]==1) {
				if ($imgId) {
					$imgDocument = new we_imageDocument();
					$imgDocument->initByID($imgId);
					if ($imgDocument->WebUserID == $webuserId) {
						//everything ok, now delete
						$GLOBALS["NOT_PROTECT"] = true;
						include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_delete_fn.inc.php");
						deleteEntry($imgId, FILE_TABLE);
						$GLOBALS["NOT_PROTECT"] = false;
						// reset image field
						$_SESSION["webuser"][$imgName] = 0;
						$_REQUEST["s"][$imgName] = 0;
					}
				}
			} else if ($filename) {
				// file is selected, check to see if it is an image
				$ct = getContentTypeFromFile($filename);
				if ($ct == "image/*") {

					$_serverPath = TMP_DIR."/".md5(uniqid(rand(),1));
					move_uploaded_file($_FILES["WE_SF_IMG_DATA"]["tmp_name"][$imgName], $_serverPath);

					include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/base/we_thumbnail.class.php");
					$we_size = we_thumbnail::getimagesize($_serverPath);

					if (count($we_size) > 0) {

						$tmp_Filename = $imgName . "_" .md5(uniqid(rand(),1)) . "_" . preg_replace("/[^A-Za-z0-9._-]/", "", $_FILES["WE_SF_IMG_DATA"]["name"][$imgName]);

						$_fileName = eregi_replace('^(.+)\..+$',"\\1",$tmp_Filename);
						$_extension = (strpos($tmp_Filename,".") > 0) ? eregi_replace('^.+(\..+)$',"\\1",$tmp_Filename) : "";
						$_text = $_fileName . $_extension;

						//image needs to be scaled
						if ( (isset($_SESSION["webuser"]['imgtmp'][$imgName]["width"]) && $_SESSION["webuser"]['imgtmp'][$imgName]["width"])  ||
							(isset($_SESSION["webuser"]['imgtmp'][$imgName]["height"]) && $_SESSION["webuser"]['imgtmp'][$imgName]["height"])) {
								$fh = fopen($_serverPath,"rb");
								$imageData = fread($fh, filesize($_serverPath));
								fclose($fh);
								$thumb = new we_thumbnail();
								$thumb->init("dummy", $_SESSION["webuser"]['imgtmp'][$imgName]["width"], $_SESSION["webuser"]['imgtmp'][$imgName]["height"], $_SESSION["webuser"]['imgtmp'][$imgName]["keepratio"],
									$_SESSION["webuser"]['imgtmp'][$imgName]["maximize"], false, '', "dummy", 0, "", "", $_extension, $we_size[0],$we_size[1], $imageData,"",$_SESSION["webuser"]['imgtmp'][$imgName]["quality"]);

								$imgData = "";
								$thumb->getThumb($imgData);

								$fh = fopen($_serverPath,"wb");
								fwrite($fh, $imgData);
								fclose($fh);

								$we_size = we_thumbnail::getimagesize($_serverPath);
						}

						$_imgwidth = $we_size[0];
						$_imgheight = $we_size[1];
						$_type = $_FILES["WE_SF_IMG_DATA"]["type"][$imgName];
						$_size = $_FILES["WE_SF_IMG_DATA"]["size"][$imgName];

						$imgDocument = new we_imageDocument();

						if ($imgId) {
							// document has already an image
							// so change binary data
							$imgDocument->initByID($imgId);
						}

						$imgDocument->Filename = $_fileName;
						$imgDocument->Extension = $_extension;
						$imgDocument->Text = $_text;

						if (!$imgId) {
						    $imgDocument->setParentID($_SESSION["webuser"]['imgtmp'][$imgName]["parentid"]);
						}

						$imgDocument->Path=$imgDocument->getParentPath().(($imgDocument->getParentPath() != "/") ? "/" : "").$imgDocument->Text;

						$imgDocument->setElement("width",$_imgwidth,"attrib");
						$imgDocument->setElement("height",$_imgheight,"attrib");
						$imgDocument->setElement("origwidth",$_imgwidth);
						$imgDocument->setElement("origheight",$_imgheight);
						$imgDocument->setElement("type",'image/*',"attrib");

						$imgDocument->setElement("data",$_serverPath,"image");

						$imgDocument->setElement("filesize",$_size,"attrib");

						$imgDocument->Table=FILE_TABLE;
						$imgDocument->Published=time();
						$imgDocument->WebUserID = $webuserId;
						$imgDocument->we_save();
						$newId=$imgDocument->ID;

						$_SESSION["webuser"][$imgName] = $newId;
						$_REQUEST["s"][$imgName] = $newId;
					}

				}

			}
		}

	}
}

?>