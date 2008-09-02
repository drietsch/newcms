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

function leWizardForm() {}

leWizardForm.ForwardInterval = null;

leWizardForm.next = function() {
	if(weButton.isEnabled("next")) {
		window.clearInterval(leWizardForm.ForwardInterval);
		document.leWebForm.submit();

	}

}

leWizardForm.forceNext = function() {
	window.clearInterval(leWizardForm.ForwardInterval);
	document.leWebForm.submit();

}


leWizardForm.back = function() {
	if(weButton.isEnabled("back")) {
		window.clearInterval(leWizardForm.ForwardInterval);
		window.frames["leLoadFrame"].document.location = backUrl;

	}

}


leWizardForm.reload = function() {
	// reload uses nextUrl - there was an error
	if(weButton.isEnabled("reload")) {
		window.clearInterval(leWizardForm.ForwardInterval);
		window.frames["leLoadFrame"].document.location = nextUrl;

	}

}


leWizardForm.proceedUrl = function() {
	window.clearInterval(leWizardForm.ForwardInterval);
	window.frames["leLoadFrame"].document.location = nextUrl;

}


leWizardForm.setInputField = function(name, value) {
	document.leWebForm[name].value = value;

}


leWizardForm.evalCheckBox = function(field, onChecked, onNotChecked) {
	if(field.checked) {
		eval(onChecked);

	} else {
		eval(onNotChecked);

	}

}


leWizardForm.checkSubmit = function(source) {

	// IE
	if (null!=window.event) {
		w = window.event;

	// Netscape/Mozilla
	} else if(null!=source) {
		w = source;

	// schade
	} else {
		w = null;

	}

	if (null!=w) {
		// check if enter is pressed
		if (13==w.keyCode) {
			window.clearInterval(leWizardForm.ForwardInterval);
			leWizardForm.next();

		}

	}

}


leWizardForm.setFocus = function(name) {
	field = eval('document.leWebForm.' + name);
	if(field != undefined) {
		// do it twice, cause ie ignores sometimes the first call
		field.focus();
		field.focus();

	}

}

leWizardForm.forward = function() {

	var elem = document.getElementById("secondTimer");
	if (elem) {
		var counter = elem.innerHTML;
		switch (counter) {
			case "1":
				elem.innerHTML = 0;
				window.clearInterval(leWizardForm.ForwardInterval);
				leWizardForm.forceNext();
				break;

			default:
				elem.innerHTML = (counter - 1);
				leWizardForm.ForwardInterval = window.setTimeout('leWizardForm.forward()', 1000);
				break;

		}

	} else {
		leWizardForm.ForwardInterval = window.setTimeout('leWizardForm.forward()', 1000);

	}

}