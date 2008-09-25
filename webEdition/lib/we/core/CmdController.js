/**
 * webEdition SDK
 *
 * This source is part of the webEdition SDK. The webEdition SDK is
 * free software; you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License
 * the Free Software Foundation; either version 3 of the License, or
 * any later version.
 *
 * The GNU Lesser General Public License can be found at
 * http://www.gnu.org/licenses/lgpl-3.0.html.
 * A copy is found in the textfile 
 * webEdition/licenses/webEditionSDK/License.txt
 *
 *
 * @category   we
 * @package    we_core
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/licenses/lgpl-3.0.html  LGPL
 */
function we_core_CmdController() {

	this.cmds = new Array();
	
	this.register = function(cmdid, cmdName, fn, scope, checkFn) {
		var obj = new Object();
		obj.checkFn = checkFn ? checkFn : null;
		obj.cmd = {"cmdName": cmdName};
		obj.fn = fn;
		obj.scope = scope ? scope : window;
		obj.id = cmdid;
		this.cmds.push(obj);
	}
	
	this.unregister = function(cmdid) {
		var newCmds = [];
		var l = this.cmds.length;
		for (var i=0; i<l; i++) {
			if (this.cmds[i].id !== cmdid) {
				newCmds.push(this.cmds[i]);
			}
		}
		this.cmds = newCmds;
	}
	
	this.fire = function(cmdObj) {
		var l = arguments.length;
		var i;
		var args = [];
		
		l = this.cmds.length;
		for (i=0; i<l; i++) {
			if (this.cmds[i].cmd.cmdName == cmdObj.cmdName && this.cmds[i].checkFn !== null) {
				if (this.cmds[i].checkFn.call(this.cmds[i].scope, cmdObj) === false) {
					return;
				}
			}
		}
		for (i=0; i<l; i++) {
			if (this.cmds[i].cmd.cmdName == cmdObj.cmdName && this.cmds[i].fn !== null) {
				this.cmds[i].fn.call(this.cmds[i].scope, cmdObj);
			}
		}
	}
	
	this.cmdOk = function(cmdObj) {
		if (typeof(cmdObj.followCmd) != "undefined") {
			this.fire(cmdObj.followCmd);
		}
	}
	
	this.cmdError = function(cmdObj) {
		if (typeof(weEventController) != undefined && weEventController !== null) {
			if (cmdObj.errorType) {
				switch (cmdObj.errorType) {
					case "notice":
						weEventController.fire("cmdNotice", cmdObj);
						break;
					case "warning":
						weEventController.fire("cmdWarning", cmdObj);
						break;
					case "error":
						weEventController.fire("cmdError", cmdObj);
						break;
				}
			} else {
				weEventController.fire("cmdError", cmdObj);
			}
		}
	}
}

we_core_CmdController.__instance = null;

we_core_CmdController.getInstance = function() {
	if (we_core_CmdController.__instance == null) {
		we_core_CmdController.__instance = new we_core_CmdController();
	}
	return we_core_CmdController.__instance;
}