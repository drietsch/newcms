<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+


class leWizardStatus {

	var $id = "";

	function __construct($id = "leWizardStatus") {

		$this->leWizardStatus($id);

	}


	function leWizardStatus($id = "leWizardStatus") {

		$this->id = $id;

	}


	function getCSS() {

		$IMAGE_DIR = IMAGE_DIR;

		$CSS = <<<EOF
<style type="text/css">
ul {
	margin				: 2px 0px 2px 0px;
	padding-top			: 0px;
	padding-left		: 18px;
	line-height			: 14px;
	list-style			: none;
	font-size			: 11px;
}

li {
}

ul#{$this->id}Bar {
	margin				: 0px;
	padding				: 0px;
}

ul#{$this->id}Bar li {
	line-height			: 14px;
	padding				: 2px 2px 2px 0px;
	margin				: 0px;
}

li.{$this->id}UpcomingStep {
	color				: #cccccc;
}

ul li.{$this->id}UpcomingStep ul {
	display				: none;
}

ul li ul li.{$this->id}UpcomingStep {
	font-weight			: normal;
	list-style-image	: url("{$IMAGE_DIR}leWizardStatus/upcoming.gif");
}

li.{$this->id}FinishedStep {
	color				: black;
}

ul li.{$this->id}FinishedStep ul {
	display				: none;
}

ul li ul li.{$this->id}FinishedStep {
	font-weight			: normal;
	list-style-image	: url("{$IMAGE_DIR}leWizardStatus/finished.gif");
}

li.{$this->id}ActiveStep {
	font-weight			: bold;
	display				: list-item;
}

ul li.{$this->id}ActiveStep ul {
	display				: list-item;
}

ul li ul li.{$this->id}ActiveStep {
	list-style-image	: url("{$IMAGE_DIR}leWizardStatus/active.gif") ! important;
}
</style>

EOF;

		return $CSS;

	}


	function getJSCode() {

		$JS = <<<EOF
<script type="text/javascript">
function leWizardStatus() {}


leWizardStatus.getChildNodes = function(myElem, filter) {

	if (!myElem) {
		var _childs = [];
		return _childs;
	}


	var childs = myElem.childNodes;

	if (filter) {

		var _childs = [];

		for (var i = 0; i < childs.length; i++) {

			if(childs[i].nodeName == filter) {

				_childs.push(childs[i]);
			}
		}
		return _childs;

	} else {
		return childs;

	}

}


leWizardStatus.update = function(wizard, step) {

	if(document.getElementById("{$this->id}Bar") == undefined) {
		return;

	}

	var ulWizards = "{$this->id}Bar";

	var liWizard = "liWizard_" + wizard;
	var liWizardStep = "liWizardStep_" + wizard + "__" + step;


	// all wizards up to {wizard} are done
	var liWizards = leWizardStatus.getChildNodes(document.getElementById(ulWizards), "LI");

	var setClassWizardStep = "{$this->id}FinishedStep";
	var setClassWizard = "{$this->id}FinishedStep";

	for (var i = 0; i < liWizards.length; i++) {

		var ulWizardStepsArray = leWizardStatus.getChildNodes(liWizards[i], "UL");
		var liWizardSteps = leWizardStatus.getChildNodes(ulWizardStepsArray[0], "LI");

		var isIterationStep = false;

		liWizards[i].className = setClassWizard

		for (var j=0; j<liWizardSteps.length; j++) {
			isIterationStep = false;
			liWizardSteps[j].className = setClassWizardStep;

			if (liWizardSteps[j].id == liWizardStep) {
				liWizardSteps[j].className = "{$this->id}ActiveStep";

				if ( liWizardSteps[j].getAttribute("iterationStep") ) {

				} else {

				}

				liWizards[i].className = "{$this->id}ActiveStep";
				setClassWizardStep = "{$this->id}UpcomingStep";
				setClassWizard = "{$this->id}UpcomingStep";

			} else {
				liWizardSteps[j].className = setClassWizardStep;

			}

		}

	}

}
</script>

EOF;

		return $JS;

	}


	function get(&$WizardCollection, $ShowMoreComponents = true, $Wizard = null, $Step = null) {

		$StatusBar = "<ul id=\"" . $this->id . "Bar\">";

		if($Wizard != null) {
			$NextWizardStyle = "FinishedStep";

		} else {
			$NextWizardStyle = "UpcomingStep";

		}

		// wizardnames/stepnames for the progress on left side
		foreach ($WizardCollection->Wizards as $_wizard) {

			if($Wizard == $_wizard->Name) {
				$WizardStyle = "ActiveStep";
				$NextWizardStyle = "UpcomingStep";

			} else {
				$WizardStyle = $NextWizardStyle;
			}

			$StatusBar	.= "<li id=\"liWizard_{$_wizard->Name}\" class=\"{$this->id}{$WizardStyle}\">" . $GLOBALS['lang']['Wizard'][$_wizard->Name]['title']
						. "<ul id=\"ulWizard_{$_wizard->Name}\" class=\"{$this->id}{$WizardStyle}\">";


			$Steps = $_wizard->WizardSteps;
			if (sizeof($Steps)) {

				if($Step != null) {
					$NextStepStyle = "FinishedStep";

				} else {
					$NextStepStyle = "UpcomingStep";

				}

				foreach ($Steps as $_step) {

					if($Step == $_step->Name) {
						$StepStyle = "ActiveStep";
						$NextStepStyle = "UpcomingStep";
						$NextWizardStyle = "UpcomingStep";

					} else {
						$StepStyle = $NextStepStyle;
					}

					$Attribute = "";
					if(!$_step->ShowInStatusBar) {
						$Attribute .= " style=\"display: none;\"";
					}

					if ($_step->IterationStep) {
						$Attribute .= " iterationStep=\"true\"";

					}
					$StatusBar .= "<li$Attribute id=\"liWizardStep_" . $_wizard->Name . "__" . $_step->Name . "\" class=\"{$this->id}{$StepStyle}\">" . $_step->Language['title'] . "</li>";


				}

			}
			$StatusBar .= "</ul></li>";

		}

		if($ShowMoreComponents) {
			$StatusBar .= "<li id=\"_replaceableWizardStep\" class=\"{$this->id}UpcomingStep\">" . $GLOBALS['lang']['Template']['moreComponentsToCome'] . "</li>";

		}

		$StatusBar .= "</ul>";

		return $StatusBar;

	}

}

?>