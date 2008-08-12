// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//
// $Id: activex_plugin.js,v 1.9 2007/05/23 15:39:31 holger.meyer Exp $

function installWarning(msg) {
	return confirm(msg);
}

function installAx14(msg) {
	if (installWarning(msg)) {
		xpi = {'Mozilla ActiveX PlugIn':'http://www.webedition.de/download/EditorPlugin/mozactivex14.xpi'};
		InstallTrigger.install(xpi);
	}
}

function installAx15(msg) {
	if (installWarning(msg)) {
		xpi = {'Mozilla ActiveX PlugIn':'http://www.webedition.de/download/EditorPlugin/mozactivex15.xpi'};
		InstallTrigger.install(xpi);
	}
}

function installAx16(msg) {
	if (installWarning(msg)) {
		xpi = {'Mozilla ActiveX PlugIn':'http://www.webedition.de/download/EditorPlugin/mozactivex16.xpi'};
		InstallTrigger.install(xpi);
	}
}

function installAx17(msg) {
	if (installWarning(msg)) {
		xpi = {'Mozilla ActiveX PlugIn':'http://www.webedition.de/download/EditorPlugin/mozactivex17.xpi'};
		InstallTrigger.install(xpi);
	}
}

function installFF10(msg) {
	if (installWarning(msg)) {
		xpi = {'Mozilla ActiveX PlugIn':'http://www.webedition.de/download/EditorPlugin/mozactivex-ff-10.xpi'};
		InstallTrigger.install(xpi);
	}
}

function installFF103(msg) {
	if (installWarning(msg)) {
		xpi = {'Mozilla ActiveX PlugIn':'http://www.webedition.de/download/EditorPlugin/mozactivex-ff-103-2.xpi'};
		InstallTrigger.install(xpi);
	}
}

function installFF104(msg) {
	if (installWarning(msg)) {
		xpi = {'Mozilla ActiveX PlugIn':'http://www.webedition.de/download/EditorPlugin/mozactivex-ff-104.xpi'};
		InstallTrigger.install(xpi);
	}
}

function installFF106(msg) {
	if (installWarning(msg)) {
		xpi = {'Mozilla ActiveX PlugIn':'http://www.webedition.de/download/EditorPlugin/mozactivex-ff-106.xpi'};
		InstallTrigger.install(xpi);
	}
}

function installFF107(msg) {
	if (installWarning(msg)) {
		xpi = {'Mozilla ActiveX PlugIn':'http://www.webedition.de/download/EditorPlugin/mozactivex-ff-107.xpi'};
		InstallTrigger.install(xpi);
	}
}

function installFF15(msg) {
	if (installWarning(msg)) {
		xpi = {'Mozilla ActiveX PlugIn':'http://www.webedition.de/download/EditorPlugin/mozactivex-ff-15.xpi'};
		InstallTrigger.install(xpi);
	}
}