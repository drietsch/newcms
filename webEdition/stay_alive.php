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

session_start();
?>
<html>
<head>
</head>
<body>
<!-- ping -->
<script language="JavaScript" type="text/javascript">
<!--
	setTimeout("self.location='stay_alive.php?r=<?php print rand(); ?>'", (5 *60000) );
//-->
</script>
</body>
</html>