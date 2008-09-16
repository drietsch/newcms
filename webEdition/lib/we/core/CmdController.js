/**
 * webEdition SDK
 *
 * LICENSE_TEXT
 *
 * TODO insert license text
 *
 * @category   we
 * @package    we_core
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/licence     LICENCE_TYPE  TODO insert license type and url
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