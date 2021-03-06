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


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/alert.inc.php");

?>
	case "browse_users":
            <?php if(we_hasPerm("NEW_USER") || we_hasPerm("NEW_GROUP") || we_hasPerm("SAVE_USER")|| we_hasPerm("SAVE_GROUP") || we_hasPerm("DELETE_USER") || we_hasPerm("DELETE_GROUP")):?>
	        new jsWindow(url,"browse_users",-1,-1,500,300,true,false,true);
             <?php else:
             	print we_message_reporting::getShowMessageCall($l_alert["no_perms"], WE_MESSAGE_ERROR);
             endif ?>
	break;
        case "edit_users":
        case "edit_users_ifthere":
            <?php if(we_hasPerm("NEW_USER") || we_hasPerm("SAVE_USER") || we_hasPerm("NEW_GROUP") || we_hasPerm("SAVE_GROUP") || we_hasPerm("DELETE_USER") || we_hasPerm("DELETE_GROUP")):?>
                new jsWindow(url,"edit_module",-1,-1,970,760,true,true,true,true);
            <?php else:
            	print we_message_reporting::getShowMessageCall($l_alert["no_perms"], WE_MESSAGE_ERROR);
            endif?>

	break;
        case "new_user":
        case "save_user":
        case "new_group":
	case "new_alias":
        case "exit_users":
        case "delete_user":
	case "new_organization":
         <?php if(we_hasPerm("EDIT_USER")):?>
             var fo=false;
             for(var k=jsWindow_count-1;k>-1;k--){
               eval("if(jsWindow"+k+"Object.ref=='edit_module'){ jsWindow"+k+"Object.wind.content.we_cmd('"+arguments[0]+"');fo=true;wind=jsWindow"+k+"Object.wind}");
               if(fo) break;
	          }
	          if(wind) wind.focus();
          <?php else:
			print we_message_reporting::getShowMessageCall($l_alert["no_perms"], WE_MESSAGE_ERROR);
          endif?>
        break;
        case "doctypes":
            <?php if(we_hasPerm("CAN_SEE_TEMPLATES")):?>
                new jsWindow(url,"doctypes",-1,-1,720,670,true,true,true);
            <?php else:
				print we_message_reporting::getShowMessageCall($l_alert["no_perms"], WE_MESSAGE_ERROR);
            endif?>
	    break;
        case "unlock":
			top.YAHOO.util.Connect.asyncRequest('GET', url, { success : weDummy, failure : weDummy });
			//		we_repl(self.load,url,arguments[0]);
	    break;

	     case "add_owner":
         case "del_owner":
	     case "del_all_owners":
	     case "del_user":
	     case "add_user":
	     	if(arguments[0] == "del_all_users" && arguments[3]){
	     		url += '#f'+arguments[3];
	     	}
 			if(!we_sbmtFrm(top.weEditorFrameController.getActiveDocumentReference().frames["1"],url)){
				url += "&we_transaction="+arguments[2];
				we_repl(top.weEditorFrameController.getActiveDocumentReference().frames["1"],url,arguments[0]);
			}
			break;

         case "chooseAddress":
                new jsWindow(url,"chooseAddress",-1,-1,400,590,true,true,true,true);
         		break;
        case "changeR":
			we_repl(self.load,url,arguments[0]);
			break;
