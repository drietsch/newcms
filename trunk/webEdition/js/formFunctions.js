// functions for normal input fields

weInput = function() {}
weInput.setValue = function(elementName, optionValue) {
	
	if (elem = document.we_form[elementName]) {
		elem.value = optionValue;
	}
}

weInput.getValue = function(elementName) {
	
	if (elem = document.we_form[elementName]) {
		return elem.value;
	}
}

// select
function weSelect(){}
weSelect.addOption = function (selectName, optionValue, optionText) {
	
	if (elem = document.we_form[selectName]) {
		
		var newOpt = document.createElement("option");
		if (optionValue) {
			newOpt.setAttribute("value", optionValue);
		} else {
			newOpt.setAttribute("value", optionText);
		}
		
		var textNode = document.createTextNode(optionText);
		newOpt.appendChild(textNode);
		
		elem.appendChild(newOpt);
	}
}

weSelect.removeOptions = function (selectName) {
	
	var sel = document.we_form[selectName];
	if (sel) {
		sel.innerHTML = '';
	}
}

weSelect.setOptions = function(selectName, optionsList) {
	
	// first remove all existing options
	weSelect.removeOptions(selectName);
	
	var sel = document.we_form[selectName];
	
	if (sel) {
		// now add all new options
		for (var i = 0; i < optionsList.length; i++) {
			
			weSelect.addOption(selectName, optionsList[i]['value'], optionsList[i]['text']);
			
			if (i == (optionsList.length-1)) {
				weSelect.selectOption(selectName, optionsList[i]['value']);
			}
		}
	}
}

weSelect.updateOption = function (selectName, optionValue, newText, newValue) {
	
	if (elem = document.we_form[selectName]) {
		
		for (i=0; i<elem.options.length;i++) {
			
			if (elem.options[i].value == optionValue) {
				if (newValue) {
					elem.options[i].value = newValue;
				}
				elem.options[i].innerHTML = '';
				var textNode = document.createTextNode(newText);
				elem.options[i].appendChild(textNode);
			}
		}
	}
}

weSelect.removeOption = function (selectName, optionValue) {
	
	if (elem = document.we_form[selectName]) {
		
		for (i=0; i<elem.options.length;i++) {
			
			if (elem.options[i].value == optionValue) {
				elem.removeChild(elem.options[i]);
			}
		}
	}
}
	
weSelect.selectOption = function (selectName, optionValue) {
	
	if (elem = document.we_form[selectName]) {
		for (i=0; i<elem.options.length;i++) {
			
			if (elem.options[i].value == optionValue) {
				elem.selectedIndex = i;
				elem.options[i].setAttribute("selected", "selected");
			}
		}
	}
}

