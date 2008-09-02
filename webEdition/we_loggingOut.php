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
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/global.inc.php");

if (isset($_SESSION)){
    while(list($name, $val) = each($_SESSION)){
        unset($_SESSION[$name]);
    }
}
$_SESSION = array();
header("location: " . WEBEDITION_DIR ."index.php");


?>
<html>
<head>
<title>webEdition (c) living-e AG</title>
</head>
<body>
<?php echo $GLOBALS["l_global"]["redirect_to_login_failed"] . '<a href="' . WEBEDITION_DIR .'index.php">' . $GLOBALS["l_global"]["redirect_to_login_name"] . '</a>'; ?> 
</body>
</html>