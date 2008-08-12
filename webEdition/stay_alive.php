<?php
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