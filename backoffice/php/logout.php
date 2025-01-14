<?php
	session_start();
	session_destroy();
?> 
<script language="JavaScript">
alert("You are successfully logged out from system");
window.location="index.php";
</script>