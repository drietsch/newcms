<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+

include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_button.inc.php");

// print HTML head
htmlTop($GLOBALS['lang']['Template']['title']);

// generate needed buttons
$we_button = new we_button();
$ButtonBack = $we_button->create_button('back', 'javascript:leWizardForm.back();', true, 100, 22, "", "", true, false);
$ButtonNext = $we_button->create_button('next', 'javascript:leWizardForm.next();', true, 100, 22, "", "", false, false);
$ButtonReload = $we_button->create_button('image:function_reload', 'javascript:leWizardForm.reload();', true, 40, 22, "", "", true, false);

// Preview
$ButtonClose = $we_button->create_button('close', 'javascript:top.frames[\'leLoadFrame\'].hidePreview();', true, 100, 22, "", "", false, false);
$ButtonBackPreview = $we_button->create_button('image:direction_left', 'javascript:top.frames[\'leLoadFrame\'].backPreview();', true, 40, 22, "", "", false, false);
$ButtonNextPreview = $we_button->create_button('image:direction_right', 'javascript:top.frames[\'leLoadFrame\'].nextPreview();', true, 40, 22, "", "", false, false);

?>

	<!-- Use status styles for FirstStepsWizard -->
	<link type="text/css" rel="stylesheet" href="<?php echo CSS_DIR; ?>global.php" media="screen" />

	<!-- Use status styles for FirstStepsWizard -->
	<link type="text/css" rel="stylesheet" href="<?php echo CSS_DIR; ?>first_steps_wizard.css.php" media="screen" />

	<!-- Use status styles for Buttons -->
	<link type="text/css" rel="stylesheet" href="<?php echo CSS_DIR; ?>we_button.css" media="screen" />

	<!-- JavaScript for Buttons -->
	<script type="text/javascript" src="<?php echo JS_DIR; ?>weButton.js"></script>

	<!-- JavaScript Status Bar -->
	<script type="text/javascript" src="<?php echo JS_DIR; ?>leWizard/leWizardForm.js"></script>
	
	<script type="text/javascript" src="<?php echo JS_DIR; ?>windows.js"></script>

	<script type="text/JavaScript">
		var nextUrl = "";
		var backUrl = "";
		var repeatUrl = "";
	</script>

<?php

	// Status Bar
	$Status = new leWizardStatus();
	echo $Status->getCSS();
	echo $Status->getJSCode();

	// ProgressBar
	$Progress = new leWizardProgress();
	echo $Progress->getCSS();
	echo $Progress->getJSCode();

	// Content
	$Content = new leWizardContent();
	echo $Content->getCSS();
	echo $Content->getJSCode();

?>

</head>

<body>

<form action="<?php print WEBEDITION_DIR . 'we_cmd.php' ?>" target="leLoadFrame" method="post" name="leWebForm">
<input type="hidden" name="we_cmd[0]" value="<?php echo $_REQUEST['we_cmd'][0]; ?>" />
<input type="hidden" name="leWizard" value="" />
<input type="hidden" name="leStep" value="" />
<input type="hidden" name="liveUpdateSession" value="" />

<div id="leWizardTitle">
	<?php echo $GLOBALS['lang']['Template']['headline']; ?>
</div>

<div id="leWizardStatus">
	<!--<?php echo $Status->get($WizardCollection, false, null, null); ?>-->
</div>

<div id="leWizard">
	<div id="leWizardBorderLeft"></div>
	<div id="leWizardContentLeft">
		<div id="leWizardHeadline">

		</div>
		<?php echo $Content->get(); ?>
		<div id="leWizardPostContent">
		<?php echo $ButtonReload; ?>
		<?php echo $Progress->get(); ?>
		</div>
	</div>
	<div id="leWizardContentRight">
		<div id="leWizardEmoticon">

		</div>
		<?php echo $Content->getDescription(); ?>
		<?php echo $ButtonBack; ?>
		<?php echo $ButtonNext; ?>
	</div>
	<div id="leWizardBorderRight"></div>

</div>

<div id="leWizardPreviewContainer"></div>

<div id="leWizardPreview">
	<div id="leWizardPreviewImageContainer"><img src="#" id="leWizardPreviewImage" width="1" height="1" border="0" alt="" /></div>
	<div id="leWizardPreviewText" class="defaultfont"></div>
	<?php echo $ButtonBackPreview; ?>
	<?php echo $ButtonNextPreview; ?>
	<?php echo $ButtonClose; ?>
</div>

<div id="debug" style="visibility: <?php echo (isset($_REQUEST['debug']) ? "block" : "hidden" ); ?>">
	<iframe src="<?php print $WizardCollection->getFirstStepUrl(); ?>" name="leLoadFrame" width="620" height="100" frameborder="0"></iframe>
</div>


<script type="text/javascript">
	document.onkeypress = leWizardForm.checkSubmit;
</script>


</body>
</html>