<?php
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


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_html_tools.inc.php");
htmlTop();
?>
<?php print STYLESHEET; ?>
<script language="JavaScript" type="text/javascript" src="<?php print JS_DIR; ?>windows.js"></script>
<script language="JavaScript" type="text/javascript"><!--
var w = new jsWindow("","live",100,100,350,220,true,false);
var d = w.wind.document;
d.open();
d.writeln("TEST");
d.close();

//-->
</script>
</head>
	<body>
	</body>
</html>