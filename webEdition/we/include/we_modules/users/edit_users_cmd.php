<?php

/**
 * webEdition CMS
 *
 * This source is part of webEdition CMS. webEdition CMS is
 * free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * any later version.
 *
 * The GNU General Public License can be found at
 * http://www.gnu.org/copyleft/gpl.html.
 * A copy is found in the textfile
 * webEdition/licenses/webEditionCMS/License.txt
 *
 * @category   webEdition
 * @package    webEdition_base
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/copyleft/gpl.html  GPL
 */


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_html_tools.inc.php");
include_once(WE_USERS_MODULE_DIR . "we_users_util.php");
include_once(WE_USERS_MODULE_DIR . "we_users.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/" . $GLOBALS["WE_LANGUAGE"] . "/modules/users.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/alert.inc.php");

htmlTop();
protect();

    if(file_exists(WE_USERS_MODULE_DIR . "edit_users_bcmd.php")){
        include_once(WE_USERS_MODULE_DIR . "edit_users_bcmd.php");
    }
    if(isset($_REQUEST["ucmd"])){
        switch($_REQUEST["ucmd"]){
            case "new_user":
                if(!we_hasPerm("NEW_USER")){
                        print '<script language="JavaScript" type="text/javascript">' . we_message_reporting::getShowMessageCall($l_alert["access_denied"], WE_MESSAGE_ERROR) . '</script>';
                        break;
                }
                $user_object=new we_user();

                if(isset($_REQUEST["cgroup"]) && $_REQUEST["cgroup"]){
                    $user_group = new we_user();
                    if($user_group->initFromDB($_REQUEST["cgroup"])){
                        $user_object->ParentID=$_REQUEST["cgroup"];
                    }
                }
                $user_object->initType(0);

                $_SESSION["user_session_data"]=$user_object->getState();
                print '
                    <script language="JavaScript" type="text/javascript">
                        top.content.user_resize.user_right.user_editor.user_edheader.location="' . WE_USERS_MODULE_PATH . 'edit_users_edheader.php";
                        top.content.user_resize.user_right.user_editor.user_properties.location="' . WE_USERS_MODULE_PATH . 'edit_users_properties.php";
                        top.content.user_resize.user_right.user_editor.user_edfooter.location="' . WE_USERS_MODULE_PATH . 'edit_users_edfooter.php";
                    </script>';
        	    break;
            case "display_user":
                if($_REQUEST["uid"]){
                    $user_object=new we_user();
                    $user_object->initFromDB($_REQUEST["uid"]);

        		    if(!we_hasPerm("ADMINISTRATOR") && $user_object->checkPermission("ADMINISTRATOR")){
                        print '<script language="JavaScript" type="text/javascript">' . we_message_reporting::getShowMessageCall($l_alert["access_denied"], WE_MESSAGE_ERROR) . '</script>';
        			    $user_object=new we_user();
                        break;
                    }

                    $_SESSION["user_session_data"]=$user_object->getState();
                    $setgroup="";
                    if($user_object->Type==1){
                        $setgroup='top.content.cgroup='.$user_object->ID.";\n";
                    }
                    print '
                       <script language="JavaScript" type="text/javascript">
                           top.content.usetHot();
                           '.$setgroup.'
                           top.content.user_resize.user_right.user_editor.user_edheader.location="' . WE_USERS_MODULE_PATH . 'edit_users_edheader.php";
                           top.content.user_resize.user_right.user_editor.user_properties.location="' . WE_USERS_MODULE_PATH . 'edit_users_properties.php";
                           top.content.user_resize.user_right.user_editor.user_edfooter.location="' . WE_USERS_MODULE_PATH . 'edit_users_edfooter.php";
                        </script>';
                }
              	break;
            case "save_user":
            	$isAcError = false;
		    	include_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_classes/weSelectorQuery.class.inc.php');
		    	$weAcQuery = new weSelectorQuery();

            	 // bugfix #1665 for php 4.1.2: "-" moved to the end of the regex-pattern
				if(isset($_REQUEST[$_REQUEST['obj_name'] . '_username']) && !eregi("^[A-Za-z0-9._-]+$", $_REQUEST[$_REQUEST['obj_name'] . '_username'])) {
            		print '<script language="JavaScript" type="text/javascript">' . we_message_reporting::getShowMessageCall($GLOBALS["l_global"]["username_wrong_chars"], WE_MESSAGE_ERROR) . '</script>';
                    break;
            	} else if(!isset($_SESSION["user_session_data"])){
                    print '<script language="JavaScript" type="text/javascript">' . we_message_reporting::getShowMessageCall($l_alert["no_perms"], WE_MESSAGE_ERROR) . '</script>';
                    break;
                } else {
					if(isset($_REQUEST[$_REQUEST['obj_name'] . '_ParentID']) && !empty($_REQUEST[$_REQUEST['obj_name'] . '_ParentID']) && $_REQUEST[$_REQUEST['obj_name'] . '_ParentID']>0) {
				    	$weAcResult = $weAcQuery->getItemById($_REQUEST[$_REQUEST['obj_name'] . '_ParentID'],USER_TABLE,array("IsFolder"),false);
				    	if (!is_array($weAcResult) || $weAcResult[0]['IsFolder']==0) {
		                    print '<script language="JavaScript" type="text/javascript">' . we_message_reporting::getShowMessageCall($l_alert["no_perms"], WE_MESSAGE_ERROR) . '</script>';
		                    break;
				    	}
					}
                	$i=0;
                	while (isset($_REQUEST[$_REQUEST['obj_name'].'_Workspace_'.FILE_TABLE.'_'.$i]) && !empty($_REQUEST[$_REQUEST['obj_name'].'_Workspace_'.FILE_TABLE.'_'.$i])) {
				    	$weAcResult = $weAcQuery->getItemById($_REQUEST[$_REQUEST['obj_name'].'_Workspace_'.FILE_TABLE.'_'.$i], FILE_TABLE,array("IsFolder"));
				    	if (!is_array($weAcResult) || $weAcResult[0]['IsFolder']==0) {
		                    $isAcError = true;
		                    break;
				    	}
                		$i++;
                	}
                	$i=0;
                	while (isset($_REQUEST[$_REQUEST['obj_name'].'_Workspace_'.TEMPLATES_TABLE.'_'.$i]) && !empty($_REQUEST[$_REQUEST['obj_name'].'_Workspace_'.TEMPLATES_TABLE.'_'.$i])) {
				    	$weAcResult = $weAcQuery->getItemById($_REQUEST[$_REQUEST['obj_name'].'_Workspace_'.TEMPLATES_TABLE.'_'.$i],TEMPLATES_TABLE,array("IsFolder"));
				    	if (!is_array($weAcResult) || $weAcResult[0]['IsFolder']==0) {
		                    $isAcError = true;
		                    break;
				    	}
                		$i++;
                	}
                	$i=0;
                	while (isset($_REQUEST[$_REQUEST['obj_name'].'_Workspace_'.NAVIGATION_TABLE.'_'.$i]) && !empty($_REQUEST[$_REQUEST['obj_name'].'_Workspace_'.NAVIGATION_TABLE.'_'.$i])) {
				    	$weAcResult = $weAcQuery->getItemById($_REQUEST[$_REQUEST['obj_name'].'_Workspace_'.NAVIGATION_TABLE.'_'.$i],NAVIGATION_TABLE,array("IsFolder"));
				    	if (!is_array($weAcResult) || $weAcResult[0]['IsFolder']==0) {
		                    $isAcError = true;
		                    break;
				    	}
                		$i++;
                	}
                	if (defined("OBJECT_FILES_TABLE")) {
	                	while (isset($_REQUEST[$_REQUEST['obj_name'].'_Workspace_'.OBJECT_FILES_TABLE.'_'.$i]) && !empty($_REQUEST[$_REQUEST['obj_name'].'_Workspace_'.OBJECT_FILES_TABLE.'_'.$i])) {
					    	$weAcResult = $weAcQuery->getItemById($_REQUEST[$_REQUEST['obj_name'].'_Workspace_'.OBJECT_FILES_TABLE.'_'.$i],OBJECT_FILES_TABLE,array("IsFolder"));
					    	if (!is_array($weAcResult) || $weAcResult[0]['IsFolder']==0) {
			                    $isAcError = true;
			                    break;
					    	}
	                		$i++;
	                	}
                	}
                	
               		if (defined("NEWSLETTER_TABLE")) {
	                	while (isset($_REQUEST[$_REQUEST['obj_name'].'_Workspace_'.NEWSLETTER_TABLE.'_'.$i]) && !empty($_REQUEST[$_REQUEST['obj_name'].'_Workspace_'.NEWSLETTER_TABLE.'_'.$i])) {
					    	$weAcResult = $weAcQuery->getItemById($_REQUEST[$_REQUEST['obj_name'].'_Workspace_'.NEWSLETTER_TABLE.'_'.$i],NEWSLETTER_TABLE,array("IsFolder"));
					    	if (!is_array($weAcResult) || $weAcResult[0]['IsFolder']==0) {
			                    $isAcError = true;
			                    break;
					    	}
	                		$i++;
	                	}
               		}

                	if ($isAcError) {
                   		print '<script language="JavaScript" type="text/javascript">' . we_message_reporting::getShowMessageCall($l_users["workspaceFieldError"], WE_MESSAGE_ERROR) . '</script>';
                		break;
                	}
                    $user_object=new we_user();
                    $user_object->setState($_SESSION["user_session_data"]);
                }
                if(!we_hasPerm("ADMINISTRATOR") && $user_object->checkPermission("ADMINISTRATOR")){
                    print '<script language="JavaScript" type="text/javascript">' . we_message_reporting::getShowMessageCall($l_alert["access_denied"], WE_MESSAGE_ERROR) . '</script>';
        		    $user_object = new we_user();
                    break;
                }
                $oldperm = false;
                $oldperm = $user_object->checkPermission("ADMINISTRATOR");
                if($user_object){

                    if(!we_hasPerm("SAVE_USER") && ($user_object->Type==0 || $user_object->Type==2) && $user_object->ID!=0){
                   		print '<script language="JavaScript" type="text/javascript">' . we_message_reporting::getShowMessageCall($l_alert["access_denied"], WE_MESSAGE_ERROR) . '</script>';
                    	break;
	                }
	        	    if(!we_hasPerm("NEW_USER") && ($user_object->Type==0 || $user_object->Type==2) && $user_object->ID==0){
	                    print '<script language="JavaScript" type="text/javascript">' . we_message_reporting::getShowMessageCall($l_alert["access_denied"], WE_MESSAGE_ERROR) . '</script>';
	                    break;
	                }
	                if(!we_hasPerm("SAVE_GROUP") && $user_object->Type==1 && $user_object->ID!=0){
	                    print '<script language="JavaScript" type="text/javascript">' . we_message_reporting::getShowMessageCall($l_alert["access_denied"], WE_MESSAGE_ERROR) . '</script>';
	                    break;
	                }
	        	    if(!we_hasPerm("NEW_GROUP") && $user_object->Type==1  && $user_object->ID==0){
	                    print '<script language="JavaScript" type="text/javascript">' . we_message_reporting::getShowMessageCall($l_alert["access_denied"], WE_MESSAGE_ERROR) . '</script>';
	                    break;
	                }
	                if(isset($_REQUEST["oldtab"]))
	                	$user_object->preserveState(abs($_REQUEST["oldtab"]),$_REQUEST["old_perm_branch"]);

	                $id = $user_object->ID;
	                if($user_object->username=="" && $user_object->Type!=2){
	                    print '
	                        <script language="JavaScript" type="text/javascript">
	                        	' . we_message_reporting::getShowMessageCall($l_users["username_empty"], WE_MESSAGE_ERROR) . '
	                        </script>';
	                    break;
	                }

	    	        if($user_object->Alias==0 && $user_object->Type==2){
	                    print '
	                        <script language="JavaScript" type="text/javascript">
	                            ' . we_message_reporting::getShowMessageCall($l_users["username_empty"], WE_MESSAGE_ERROR) . '
	                        </script>';
	                    break;
	                }
	    	        $DB_WE->query("SELECT ID,username FROM ".USER_TABLE." WHERE ID<>'".$user_object->ID."' AND username='".$user_object->username."'");
	                if($DB_WE->next_record() && $user_object->Type!=2){
	                    print '
	                        <script language="JavaScript" type="text/javascript">
	                        	' . we_message_reporting::getShowMessageCall(sprintf($l_users["username_exists"],$user_object->username), WE_MESSAGE_ERROR) . '
	                        </script>';
	                    break;
	                }
	                if(($oldperm) && (!$user_object->checkPermission("ADMINISTRATOR")) && ($user_object->isLastAdmin())){
	                    print '
	                        <script language="JavaScript" type="text/javascript">
	                        	' . we_message_reporting::getShowMessageCall($l_users["modify_last_admin"], WE_MESSAGE_ERROR) . '
	                        </script>';
	                    break;
	                }

	    	        $foo = array();
	    	        if(isset($GLOBALS["BIG_USER_MODULE"]) && $GLOBALS["BIG_USER_MODULE"] && $user_object->ID && in_array("busers",$GLOBALS["_pro_modules"])){
	                    $foo = getHash("SELECT ParentID FROM ".USER_TABLE." WHERE ID=".$user_object->ID,$user_object->DB_WE);
	                } else {
	                    $foo["ParentID"]=0;
	                }
	                $ret = $user_object->saveToDB();
	        	    $_SESSION["user_session_data"]=$user_object->getState();

	        	    //	Save seem_startfile to DB when needed.
                	if (isset($_REQUEST["seem_start_file"])){
                	 	if(($_REQUEST["seem_start_file"] && $_REQUEST["seem_start_file"] != 0) || (isset($_SESSION["save_user_seem_start_file"][$_REQUEST["uid"]]))  ){
                			$tmp = new DB_WE();

	                		if(isset($_REQUEST["seem_start_file"])){
	                			//	save seem_start_file from REQUEST
	                			$seem_start_file = $_REQUEST["seem_start_file"];
	                			if ($user_object->ID == $_SESSION['user']['ID']) { // change preferences if user edits his own startfile
	                				$_SESSION['prefs']['seem_start_file'] = $seem_start_file;
	                			}
	                		} else {
	                			//	Speichere seem_start_file aus SESSION
	                			$seem_start_file = $_SESSION["save_user_seem_start_file"][$_REQUEST["uid"]];
	                		}
	                		$tmp->query("UPDATE ".PREFS_TABLE." SET seem_start_file='" . $seem_start_file . "' WHERE userID=". $_REQUEST["uid"]);
	   						unset($tmp);
	   						unset($seem_start_file);
	   						if (isset($_SESSION["save_user_seem_start_file"][$_REQUEST["uid"]])) {
	   							unset($_SESSION["save_user_seem_start_file"][$_REQUEST["uid"]]);
	   						}
	                	}
	                }

	        	    if($ret == -5){
	    	    	    print '<script language="JavaScript" type="text/javascript">' . we_message_reporting::getShowMessageCall( $l_users["user_path_nok"], WE_MESSAGE_ERROR) . '</script>';
	    	        } else {
	                	if($id){
	                	    $tree_code = 'top.content.updateEntry('.$user_object->ID.','.$user_object->ParentID.',"'.$user_object->Text.'",'.($user_object->checkPermission("ADMINISTRATOR") ? 1 : 0).');';
	                	} else {
	                	    $tree_code = 'top.content.makeNewEntry("user.gif",'.$user_object->ID.','.$user_object->ParentID.',"'.$user_object->Text.'",false,"'.(($user_object->Type==1)?("folder"):(($user_object->Type==2) ? ("alias") : ("user"))).'","'.USER_TABLE.'",'.($user_object->checkPermission("ADMINISTRATOR") ? 1 : 0).');';
	                	}

	    	    	    if($user_object->Type==2){
	    	    	        $savemessage =  we_message_reporting::getShowMessageCall( sprintf($l_users["alias_saved_ok"],$user_object->Text), WE_MESSAGE_NOTICE);
	    	    	    } else if($user_object->Type==1){
	    	    	    	$savemessage =  we_message_reporting::getShowMessageCall( sprintf($l_users["group_saved_ok"],$user_object->Text), WE_MESSAGE_NOTICE);
	    	    	    } else {
	    	    	    	$savemessage =  we_message_reporting::getShowMessageCall( sprintf($l_users["user_saved_ok"],$user_object->Text), WE_MESSAGE_NOTICE);
	    	    	    }

	                	if($user_object->Type == 0){
	                	    $tree_code .= 'top.content.cgroup='.$user_object->ParentID.";\n";
	                	}
	                	print '
	                        <script language="JavaScript" type="text/javascript">
	                        	top.content.usetHot();
	                            '.$tree_code.'
	                            '.$savemessage.'
	                            '.$ret.'
	                      </script>';
					}
                }
        	    break;
            case "delete_user":
                if(isset($_SESSION["user_session_data"]) && $_SESSION["user_session_data"]){
        	        $user_object = new we_user();
                    $user_object->setState($_SESSION["user_session_data"]);

                    if($user_object->ID == $_SESSION["user"]["ID"]){
						print '<script language="JavaScript" type="text/javascript">' . we_message_reporting::getShowMessageCall( $l_users["delete_user_same"], WE_MESSAGE_ERROR ) . '</script>';
						break;
					}

					if(isUserInGroup($_SESSION["user"]["ID"],$user_object->ID)){
						print '<script language="JavaScript" type="text/javascript">' . we_message_reporting::getShowMessageCall( $l_users["delete_group_user_same"], WE_MESSAGE_ERROR ) . '</script>';
						break;
					}

                    if(!we_hasPerm("ADMINISTRATOR") && $user_object->checkPermission("ADMINISTRATOR")){
                        print '<script language="JavaScript" type="text/javascript">' . we_message_reporting::getShowMessageCall( $l_alert["access_denied"], WE_MESSAGE_ERROR ) . '</script>';
        		        $user_object = new we_user();
                        break;
           	        }
        	        if(!we_hasPerm("DELETE_USER") && $user_object->Type==0){
                        print '<script language="JavaScript" type="text/javascript">' . we_message_reporting::getShowMessageCall( $l_alert["access_denied"], WE_MESSAGE_ERROR ) . '</script>';
                        break;
                    }
                    if(!we_hasPerm("DELETE_GROUP") && $user_object->Type==1){
                        print '<script language="JavaScript" type="text/javascript">' . we_message_reporting::getShowMessageCall( $l_alert["access_denied"], WE_MESSAGE_ERROR ) . '</script>';
                        break;
                    }

					if(isset($GLOBALS["user"]) && $user_object->Text == $GLOBALS["user"]["Username"]){
						print '<script language="JavaScript" type="text/javascript">' . we_message_reporting::getShowMessageCall( $l_alert["user_same"], WE_MESSAGE_ERROR ) . '</script>';
						break;
					}

                    if($user_object->checkPermission("ADMINISTRATOR")){
                        if($user_object->isLastAdmin()){
                            print '
                                <script language="JavaScript" type="text/javascript">
                                	' . we_message_reporting::getShowMessageCall($l_users["modify_last_admin"], WE_MESSAGE_ERROR) . '
                                </script>';
                                exit();
                        }
                    }
                    $question="";

                    if($user_object->Type==1){
                         $question = sprintf($l_users["delete_alert_group"],$user_object->Text);
                    } else if($user_object->Type==2){
                        $question = sprintf($l_users["delete_alert_alias"],$user_object->Text);
                    } else {
                        $question = sprintf($l_users["delete_alert_user"],$user_object->Text);
                    }
                    print '
                        <script language="JavaScript" type="text/javascript">
                            if(confirm("'.$question.'")){
                                top.content.user_cmd.location="' . WE_USERS_MODULE_PATH . 'edit_users_cmd.php?ucmd=do_delete";
                            }
                        </script>';
                }
                break;
            case "do_delete":
                if($_SESSION["user_session_data"]){
        	        $user_object = new we_user();
        		    $user_object->setState($_SESSION["user_session_data"]);
                    if(!we_hasPerm("DELETE_USER") && $user_object->Type==0){
                        print '<script language="JavaScript" type="text/javascript">' . we_message_reporting::getShowMessageCall( $l_alert["access_denied"], WE_MESSAGE_ERROR ) . '</script>';
                        break;
                    }
                    if(!we_hasPerm("DELETE_GROUP") && $user_object->Type==1){
                        print '<script language="JavaScript" type="text/javascript">' . we_message_reporting::getShowMessageCall( $l_alert["access_denied"], WE_MESSAGE_ERROR ) . '</script>';
                        break;
                    }
                    if($user_object->deleteMe()){
                        print '
                        <script language="JavaScript" type="text/javascript">
							top.content.deleteEntry('.$user_object->ID.');
							top.content.user_resize.user_right.user_editor.user_edheader.location="'.WEBEDITION_DIR.'html/grayWithTopLine.html";
    						top.content.user_resize.user_right.user_editor.user_properties.location="'.WEBEDITION_DIR.'we_cmd.php?we_cmd[0]=mod_home&mod=users";
    						top.content.user_resize.user_right.user_editor.user_edfooter.location="'.WEBEDITION_DIR.'html/gray.html";
                        </script>';
                        unset($_SESSION["user_session_data"]);
                    }
                }
                break;

            case "check_user_display":
                if($_REQUEST["uid"]){
                    if(isset($GLOBALS["BIG_USER_MODULE"]) && $GLOBALS["BIG_USER_MODULE"] && in_array("busers",$GLOBALS["_pro_modules"])){
                        $foo=getHash("SELECT ParentID FROM ".USER_TABLE." WHERE ID=".$_SESSION["user"]["ID"],$DB_WE);
                    } else {
                        $foo["ParentID"]=0;
                    }

                    $mpid = $foo["ParentID"];

                    if(isset($GLOBALS["BIG_USER_MODULE"]) && $GLOBALS["BIG_USER_MODULE"] && in_array("busers",$GLOBALS["_pro_modules"])){
                        $foo = getHash("SELECT ParentID FROM ".USER_TABLE." WHERE ID=".$_REQUEST["uid"],$DB_WE);
                    } else {
                        $foo["ParentID"]=0;
                    }

                    $pid = $foo["ParentID"];
                    $search = true;
                    $found = false;
                    $first = true;

                    while($search){
                        if($mpid == $pid){
                            $search = false;
                            if(!$first){
                                $found=true;
                            }
                        }
                        $first = false;
                        if($pid == 0){
                            $search = false;
                        }
                        if(isset($GLOBALS["BIG_USER_MODULE"]) && $GLOBALS["BIG_USER_MODULE"] && in_array("busers",$GLOBALS["_pro_modules"])){
                            $foo = getHash("SELECT ParentID FROM ".USER_TABLE." WHERE ID=".$pid,$DB_WE);
                            if(empty($foo)) {
                            	$foo["ParentID"] = 0;
                            }
                        } else {
                            $foo["ParentID"] = 0;
                        }
                        $pid = $foo["ParentID"];
                        }

                    if($found || we_hasPerm("ADMINISTRATOR")){
                        print '
                            <script language="JavaScript" type="text/javascript">
                                top.content.we_cmd(\'display_user\','.$_REQUEST["uid"].')
                            </script>';
                    } else {
                        print '<script language="JavaScript" type="text/javascript">' . we_message_reporting::getShowMessageCall( $l_alert["access_denied"], WE_MESSAGE_ERROR ) . '</script>';
                    }
                }
                break;
        }
    }
?>
</head>
<body>
</body>
</html>