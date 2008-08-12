<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//


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