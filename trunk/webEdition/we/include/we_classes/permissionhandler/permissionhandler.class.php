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
     * class    permissionhandler
     * @desc    This class looks for the needed permissions to perform a single
                action. Actions are normaly submitted via we_cmds. There are two
                ways to use this class.
                a - get all needed permissions for a requested command.
                b - checks, if the user has the right to perform the requested action.
     *
     */
    class permissionhandler{

        /**
         * permissionhandler::getPermissionsForAction()
         * @desc    This function looks in the array $knownActions for the needed
                    permissions for an action.
                    It returns either an array of permissions, or "none", when no
                    permission is needed for this action, or the action is not
                    listed.
         *
         * @param   requestedAction     string - the action the user wants to do (we_cmd[0])
         * @param   paramater           string - a parameter to specify the action
         *
         * @return  array               of the needed Permissions
         */
        function getPermissionsForAction($requestedAction, $parameter){
        	
        	/*
		        Here is the Array, which gives the connection between the action the user wants to make
		        and the needed permissions.
		        - first index is the action, the user wants to make
		        - the second is a paramter the action needs.
		        - the last is an array of strings containing all permissions, the user must have
		          each entry of the array reflects a condition, when one condition matches - the action is allowed.
		        - Several AND conditions in one conditionstring are seperated with ","
		
		          here are two example usages:
		
		          $knownActions["switch_edit_page"]["WE_EDITPAGE_PROPERTIES"] = array("CAN_SEE_PROPERTIES");
		          action: switch editPage to property-page - needed right is "CAN_SEE_PROPERTIES"
		          
		          $knownActions["another_action"]["another_para"] = array("Right1","Right2,Right3");
		          action: another_action with another_para - needed right can be: Right1 OR Right2 AND Right3
		          
		    */
		    $knownActions = array();
		    //	The first entries are no we_cmd[0], but sometimes needed.
		    $knownActions["switch_edit_page"]["WE_EDITPAGE_PROPERTIES"] = array("CAN_SEE_PROPERTIES");
		    $knownActions["switch_edit_page"][0] = array("CAN_SEE_PROPERTIES");
		    $knownActions["switch_edit_page"]["WE_EDITPAGE_INFO"] = array("CAN_SEE_INFO");
		    $knownActions["switch_edit_page"][2] = array("CAN_SEE_INFO");
		    $knownActions["switch_edit_page"]["WE_EDITPAGE_VALIDATION"] = array("CAN_SEE_VALIDATION");
		    $knownActions["switch_edit_page"][10] = array("CAN_SEE_VALIDATION");
		    
		    //	Is user allowed to work in normal mode or only in SEEM
		    $knownActions["work_mode"]["normal"] = array("CAN_WORK_NORMAL_MODE");
		    $knownActions["header"]["with_java"] = array("CAN_SEE_MENUE");
        	
		    
		    
            if(isset($knownActions[$requestedAction][$parameter])){
                return $knownActions[$requestedAction][$parameter];
            } else {
                return "none";
            }
        }

        /**
         * permissionhandler::isUserAllowedForAction()
         * @desc    When a user is allowed to do an action with a certain parameter,
                    true is returned, otherwise false.
         *
         * @see     permissionhandler::getPermissionsForAction
         *
         * @param   requestedAction     string - the action the user wants to do (we_cmd[0])
         * @param   paramater           string - a parameter to specify the action
         *
         * @return  boolean
         */
        function isUserAllowedForAction($requestedAction, $parameter){

            $neededPerm = permissionhandler::getPermissionsForAction($requestedAction, $parameter);

            //  An array is returned, check the rights.
            if(is_array($neededPerm)){
				
                while(list($key, $val) = each($neededPerm)){

                    $allowed = true;

                    $perms = explode(",", $val);
                    for($i = 0; $i < sizeof($perms); $i++){

                        if(!we_hasPerm($perms[$i])){
                            $allowed = false;
                            break;
                        }
                    }

                    if($allowed){
                        return true;
                    }
                }
            //  no permissions are needed for this action
            } else {

                return true;
            }
            return false;
        }
    }
?>