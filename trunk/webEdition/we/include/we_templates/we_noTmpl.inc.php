<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_tag.inc.php");
?><html>

	<head>
<?php if(isset($we_editmode) && $we_editmode): ?>
<?php print STYLESHEET; ?>
<?php endif ?>
<?php if($we_doc->getElement("Charset")): ?>
		<meta http-equiv="Content-Type" content="text/html; charset=<?php print $we_doc->getElement("Charset"); ?>">
<?php endif ?>
<?php if($we_doc->getElement("Keywords")): ?>
		<meta name="keywords" content="<?php print $we_doc->getElement("Keywords") ?>">
<?php endif ?>
<?php if($we_doc->getElement("Description")): ?>
		<meta name="description" content="<?php print $we_doc->getElement("Description") ?>">
<?php endif ?>
		<title><?php print $we_doc->getElement("Title") ?></title>
<?php if(isset($we_editmode) && $we_editmode): ?>
<script language="JavaScript" type="text/javascript" src="<?php print JS_DIR; ?>windows.js"></script>
<?php include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_editors/we_editor_script.inc.php"); ?>
<?php else: ?>
<?php print we_tag("textarea", array("name"=>"HEAD")); ?>
<?php endif ?>
	</head>
<?php if(isset($we_editmode) && $we_editmode): ?>
<body bgcolor="white" marginwidth="15" marginheight="15" leftmargin="15" topmargin="15">
<form name="we_form" method="post"><?php $we_doc->pHiddenTrans() ?>
<?php

$foo = '<pre class="defaultfont">&lt;html&gt;
	&lt;head&gt;
';
if($we_doc->getElement("Keywords")){
$foo .= '		&lt;meta name="keywords" content="'.$we_doc->getElement("Keywords").'"&gt;
';
}
if($we_doc->getElement("Charset")){
$foo .= '		&lt;meta http-equiv="Content-Type" content="text/html; charset=' . $we_doc->getElement("Charset") . '"&gt;
';
}
if($we_doc->getElement("Description")){
$foo .= '		&lt;meta name="description" content="'.$we_doc->getElement("Description").'"&gt;
';
}
$foo .= '		&lt;title&gt;'.$we_doc->getElement("Title").'&lt;/title&gt;
</pre>
	'.we_tag("textarea", array("name"=>"HEAD","rows"=>"8","cols"=>80,"wrap"=>"virtual","style"=>"width: 600px;")).'<br>
<pre class="defaultfont">	&lt;/head&gt;
	&lt;body '.we_tag("input", array("type"=>"text","size"=>"60","name"=>"BODYTAG","style"=>"width: 480px;")).'&gt;</pre>
'.we_tag("textarea", array("name"=>"BODY","rows"=>"15","cols"=>80,"wrap"=>"virtual","style"=>"width: 600px;")).'
<pre class="defaultfont">	&lt;/body&gt;
&lt;/html&gt;</pre>';

?>
<?php print htmlMessageBox(667,650,$foo); ?>
</form>
</body>
<?php else: ?>
	<body<?php print " ".we_tag("input", array("name"=>"BODYTAG")); ?>>
<?php printElement( we_tag("textarea", array("name"=>"BODY"), "")); ?>
	</body>
<?php endif ?>
</html>

