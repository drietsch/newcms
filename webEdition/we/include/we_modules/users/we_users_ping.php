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
if($_SESSION["user"]["ID"]) $DB_WE->query("UPDATE ".USER_TABLE." SET Ping=".time()." WHERE ID=".$_SESSION["user"]["ID"]);
?>

<script type="text/javascript" src="/webEdition/js/libs/yui/yahoo-min.js"></script>
<script type="text/javascript" src="/webEdition/js/libs/yui/event-min.js"></script>
<script type="text/javascript" src="/webEdition/js/libs/yui/connection-min.js"></script>

<script language="JavaScript" type="text/javascript">




var ajaxURL = "/webEdition/rpc/rpc.php";
var ajaxCallback = {
	success: function(o) {
		if(typeof(o.responseText) != 'undefined' && o.responseText != '') {
			eval("var result=" + o.responseText);
			if (result.Success) {
				var num_users = result.DataArray.num_users;
				if (top.weEditorFrameController) {
					var _ref = top.weEditorFrameController.getActiveDocumentReference();
					if (_ref && _ref.setUsersOnline && _ref.setUsersListOnline) {
						_ref.setUsersOnline(num_users);
						var usersHTML = result.DataArray.users;
						if (usersHTML) {
							_ref.setUsersListOnline(usersHTML);
						}
					}
				}
			<?php if (defined("MESSAGING_SYSTEM")) { ?>
				if (top.header.header_msg.update) {
					var newmsg_count = result.DataArray.newmsg_count;
					var newtodo_count = result.DataArray.newtodo_count;
				
					top.header.header_msg.update(newmsg_count, newtodo_count);
				}
				
			<?php } ?>
				setTimeout("YUIdoAjax()",<?php print PING_TIME; ?>*1000);
			
			}
		}
	},
	failure: function(o) {
		alert("Error: Unable to call RPC: Ping!");
	}
}

function YUIdoAjax() {
	YAHOO.util.Connect.asyncRequest('POST', ajaxURL, ajaxCallback, 'protocol=json&cmd=Ping');
}

//setTimeout("self.location='we_users_ping.php?r=<?php print rand() ?>'",<?php print PING_TIME ?>*1000);
</script>
</head>
<body bgcolor="white" onload="YUIdoAjax();">
</body>
</html>