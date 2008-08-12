<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+


class leWizardTemplateBase {

	/**
	 * occurd errors
	 *
	 * @var array
	 */
	var $_Errors = array();

	/**
	 * occurd errors as string for output
	 *
	 * @var string
	 */
	var $Errors = "";

	/**
	 * Javascripts to display
	 *
	 * @var array
	 */
	var $_Javascripts = array();

	/**
	 * Javascripts for output
	 *
	 * @var string
	 */
	var $Javascript = "";

	/**
	 * Output if Online Installer Template is not used
	 *
	 * @var string
	 */
	var $Output = "";

	/**
	 * Should the online installer tamplate be used
	 *
	 * @var boolean
	 */
	var $UseOnlineInstallerTemplate = true;


	function leWizardTemplateBase() {
		$this->__construct();

	}


	function __construct() {

	}


	function addError($ErrorMessage) {
		$this->_Errors[] = $ErrorMessage;

	}


	function addErrors($Errors = array()) {
		$this->_Errors = array_merge($this->Errors, $Errors);

	}


	function addJavascript($Javascript) {
		$this->_Javascripts[] = $Javascript;

	}


	function setButtons(&$nextStep, &$backStep) {

		if ($nextStep) {
			$this->addJavascript('parent.leWizardForm.setInputField("leWizard", "' . $nextStep->getWizardName() . '");');
			$this->addJavascript('parent.leWizardForm.setInputField("leStep", "' . $nextStep->getName() . '");');

			if(isset($_REQUEST['liveUpdateSession']) && $_REQUEST['liveUpdateSession'] != "") {
				$this->addJavascript('parent.leWizardForm.setInputField("liveUpdateSession", "' . $_REQUEST['liveUpdateSession'] . '");');

			}

		}

		if ($backStep) {
			$this->addJavascript('parent.backUrl = "' . $backStep->getUrl() . (isset($_REQUEST['liveUpdateSession']) && $_REQUEST['liveUpdateSession'] != "" ? "&liveUpdateSession=" . $_REQUEST['liveUpdateSession'] : "") . '&backStep=true";');

		}

	}


	function getProgressBarJs(&$CurrentStep) {

		// enable/disable the progress bar
		return 'parent.leWizardProgress.enable(' . ($CurrentStep->ProgressBarVisible ? "true" : "false") . ');';

	}


	function getButtonJs(&$CurrentStep) {

		// enable/disable buttons
		$ButtonNames = array(
			"next",
			"back",
			"function_reload"
		);

		$ReturnValue = "";

		foreach ($ButtonNames as $Button) {
			if(in_array($Button, $CurrentStep->EnabledButtons)) {
				$ReturnValue .= 'parent.weButton.enable("' . $Button . '");';

			} else {
				$ReturnValue .= 'parent.weButton.disable("' . $Button . '");';

			}

		}

		return $ReturnValue;

	}


	function getOutput(&$CurrentStep) {


		if($CurrentStep->liveUpdateHttpResponse) {
			$Output	=	"<script type=\"text/javascript\">"
					.	$this->getButtonJs($CurrentStep)
					.	$this->getProgressBarJs($CurrentStep);
			
			if(sizeof($this->_Javascripts) > 0) {
				$this->_Javascripts = array_reverse($this->_Javascripts);
				foreach ($this->_Javascripts as $Javascript) {
					$Output	.=	$Javascript . "\n";

				}

			}
			
			$Output	.=	"</script>"
					.	$CurrentStep->liveUpdateHttpResponse->getOutput();
					
			return $Output;

		}

		if($this->UseOnlineInstallerTemplate) {

			$this->addJavascript($this->getButtonJs($CurrentStep));

			$this->addJavascript($this->getProgressBarJs($CurrentStep));

			// update the status
			if($CurrentStep->ShowInStatusBar) {
				$this->addJavascript('parent.leWizardStatus.update("' . $CurrentStep->getWizardName() . '", "' . $CurrentStep->getName() . '");');

			}

			if (sizeof($this->_Errors) > 0) {
				for ($i = 0; $i < sizeof($this->_Errors); $i++) {
					$this->Errors .= "<h1 class=\"error\">{$this->_Errors[$i]}</h1>\n";

				}

			} else {
				if ($CurrentStep->AutoContinue >= 0) {
					$CurrentStep->Content .= "<br /><br /><div class=\"defaultfont\">" .  sprintf($GLOBALS["lang"]["Template"]["autocontinue"], "<span id=\"secondTimer\">" . $CurrentStep->AutoContinue . "</span>") . "</div>";

					$this->addJavascript("parent.leWizardForm.forward();");
				}

			}

			// set focus
			$this->addJavascript('parent.window.focus();');

			// replace content
			$this->addJavascript('parent.leWizardContent.replaceElement(document.getElementById("leWizardContent"));');

			if(isset($CurrentStep->Language['headline']) && $CurrentStep->Language['headline'] != "") {
				$this->addJavascript('parent.leWizardContent.replaceHeadline("' . $CurrentStep->Language['headline'] . '");');

			} else {
				$this->addJavascript('parent.leWizardContent.replaceHeadline("");');

			}

			if(isset($CurrentStep->Language['description']) && $CurrentStep->Language['description'] != "") {
				$this->addJavascript('parent.leWizardContent.replaceDescription("' . $CurrentStep->Language['description'] . '");');

			} else {
				$this->addJavascript('parent.leWizardContent.replaceDescription("");');

			}

			if(sizeof($this->_Javascripts) > 0) {
				$this->_Javascripts = array_reverse($this->_Javascripts);
				$this->Javascript .= '<script type="text/javascript">';
				foreach ($this->_Javascripts as $Javascript) {
					$this->Javascript .= $Javascript . "\n";

				}
				$this->Javascript .= '</script>';

			}

			$Content = (isset($CurrentStep->Language['content']) && trim($CurrentStep->Language['content']) != "") ? trim($CurrentStep->Language['content']) . "<br />" : "";
			$Content .= $CurrentStep->Content;

			$Output = <<<EOF
<html>
<head>
</head>
<body>
	<div id="leWizardContent">
		{$this->Errors}
		<p>
			{$Content}
		</p>
	</div>
	{$this->Javascript}
</body>
</html>
EOF;

			return $Output;

		} else {
			return $this->Output;

		}

	}

}

?>