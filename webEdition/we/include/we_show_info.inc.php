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

include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/" . "we.inc.php");
include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/" . "we_html_tools.inc.php");

htmlTop();

print STYLESHEET . "\n";

?>
</head>
<body bgcolor="white" marginwidth="0" marginheight="0" leftmargin="0"
	topmargin="0" onBlur="self.close()" onClick="self.close()"
	onload="self.focus();">
<center>
			<?php
			include ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/" . "we_templates/we_info.inc.php");
			?>
		</center>
</body>
</html>
