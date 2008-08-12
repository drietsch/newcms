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