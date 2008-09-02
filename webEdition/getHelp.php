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


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we.inc.php");
htmlTop();

?>
<script language="JavaScript" type="text/javascript" src="<?php print JS_DIR ?>windows.js"></script>
<script language="JavaScript" type="text/javascript"><!--
url="http://help.webedition.de/index.php?language=<?php print $GLOBALS["WE_LANGUAGE"] ?>";
self.location=url;              
//-->
</script>
</head>

<body bgcolor="white">
</body>

</html>