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
include_once(WE_MESSAGING_MODULE_DIR . "we_messaging.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/modules/messaging.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_button.inc.php");

protect();
$messaging = new we_messaging($_SESSION["we_data"]['we_messagin_setting']);
$messaging->set_login_data($_SESSION["user"]["ID"], $_SESSION["user"]["Username"]);
$messaging->init($_SESSION["we_data"]['we_messagin_setting']);

?>
<html>
<head>
    <title><?php echo $l_messaging['settings'] ?></title>
    <script language="JavaScript" type="text/javascript" src="/webEdition/js/we_showMessage.js"></script>
    <script language="JavaScript" type="text/javascript">
    <!--
<?php

if( isset($_REQUEST['mcmd']) && $_REQUEST['mcmd'] == 'save_settings' && isset($_REQUEST['check_step'])) {
    if ($messaging->save_settings(array('check_step' => $_REQUEST['check_step']))) {
    ?>
    	<?php print we_message_reporting::getShowMessageCall( $l_messaging['saved'], WE_MESSAGE_NOTICE ); ?>
        window.close();
    //-->
    </script>
</head>
<body></body>
</html>
<?php
    exit;
    }
}
?>
    function save() {
		document.settings.submit();
	}
	//-->
    </script>

<?php
    protect();
    
    print STYLESHEET;

    $we_button = new we_button();
?>

<body class="weDialogBody">
<form name="settings" action="<?php print WE_MESSAGING_MODULE_PATH; ?>messaging_settings.php" method="post">
<?php
if ( isset( $_REQUEST['we_transaction'] ) ) {
	echo hidden('we_transaction', $_REQUEST['we_transaction']);
}
echo hidden('mcmd', 'save_settings');

$heading = $l_messaging['settings'];
$t_vals = array('-1' => '0', '1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5', '10' => '10', '15' => '15', '30' => '30', '45' => '45', '60' => '60');
$settings = $messaging->get_settings();
$check_step = isset($settings['check_step']) ? $settings['check_step'] : "";

$input_tbl = '<table>
<tr>
    <td class="defaultfont">' . $l_messaging['check_step'] . '</td>
    <td>' . html_select('check_step', 1, $t_vals, $check_step) . '</td>
	<td class="defaultfont">' . $l_messaging['minutes'] . '</td>
</tr>
</table>';

$_buttons = $we_button->position_yes_no_cancel(	$we_button->create_button("save", "javascript:save()"),
											"",
											$we_button->create_button("cancel", "javascript:window.close();")
											)
											;

echo htmlDialogLayout($input_tbl, $heading, $_buttons);


?>

</form>
</body>
</html>