<?php
/**
 * webEdition CMS
 *
 * LICENSETEXT_CMS
 *
 *
 * @category   we
 * @package    we_base
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/licence     LICENSETEXT_CMS  TODO insert license type and url
 */


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_html_tools.inc.php");

htmlTop();
?>
</head>


<frameset rows="*" framespacing="0" border="0" frameborder="NO" onLoad="self.focus()">
<frame src="<?php print $_REQUEST["url"]; ?>" name="contBrowse" scrolling="auto">
</frameset>
<body bgcolor="white">
</body>
</html>