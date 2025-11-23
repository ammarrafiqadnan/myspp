<? if ($_SESSION["hdsecurity"] <> '8TP@M03') { ?>

<?php
$_SESSION = array();
session_destroy();
?>
<script language="JavaScript1.2">
	window.open('index.php','_parent');
</script>
<? } ?>
