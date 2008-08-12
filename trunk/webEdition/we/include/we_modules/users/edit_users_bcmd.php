<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/alert.inc.php");

if(isset($_REQUEST["ucmd"])){
    switch($_REQUEST["ucmd"]){
        case "new_group":
    	    if(!we_hasPerm("NEW_GROUP")){                 
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
            
            $user_object->initType(1);
            
            $_SESSION["user_session_data"] = $user_object->getState();
            
            print '
                <script language="JavaScript" type="text/javascript">
                    top.content.user_resize.user_right.user_editor.user_edheader.location="' . WE_USERS_MODULE_PATH . 'edit_users_edheader.php";
                    top.content.user_resize.user_right.user_editor.user_properties.location="' . WE_USERS_MODULE_PATH . 'edit_users_properties.php";
                    top.content.user_resize.user_right.user_editor.user_edfooter.location="' . WE_USERS_MODULE_PATH . 'edit_users_edfooter.php";
                </script>';
    	    break;
        
        case "new_alias":                            
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
            
            $user_object->initType(2);
            
            $_SESSION["user_session_data"] = $user_object->getState();
            print '
                <script language="JavaScript" type="text/javascript">
                    top.content.user_resize.user_right.user_editor.user_edheader.location="' . WE_USERS_MODULE_PATH . 'edit_users_edheader.php";
                    top.content.user_resize.user_right.user_editor.user_properties.location="' . WE_USERS_MODULE_PATH . 'edit_users_properties.php";
                    top.content.user_resize.user_right.user_editor.user_edfooter.location="' . WE_USERS_MODULE_PATH . 'edit_users_edfooter.php";
                </script>';
    	    break;
    
        case "search":
            print '                     
                <script language="JavaScript" type="text/javascript">                     
                    top.content.user_resize.user_right.user_editor.user_properties.location="' . WE_USERS_MODULE_PATH . 'edit_users_sresults.php?kwd='.$_REQUEST["kwd"].'";
                </script>';
            break;
            
        case "display_alias":
            if($uid && $ctype && $ctable){                                                
                print '
                    <script language="JavaScript" type="text/javascript">
                        top.content.usetHot();                               
                        top.content.user_resize.user_right.user_editor.user_edheader.location="' . WE_USERS_MODULE_PATH . 'edit_users_edheader.php?uid=".$uid."&ctype=".ctype."&ctable=".$ctable;
                        top.content.user_resize.user_right.user_editor.user_properties.location="' . WE_USERS_MODULE_PATH . 'edit_users_properties.php?uid=".$uid."&ctype=".ctype."&ctable=".$ctable;
                        top.content.user_resize.user_right.user_editor.user_edfooter.location="' . WE_USERS_MODULE_PATH . 'edit_users_edfooter.php?uid=".$uid."&ctype=".ctype."&ctable=".$ctable;
                    </script>';                                
            }
            break;
    }
}
?>