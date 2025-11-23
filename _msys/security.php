<?php
session_start();
if(empty($_SESSION['SESSADM_UID'])){
	if (file_exists('../index.php')) {
		$files = '../index.php';
		//print "ADA1";
	} else if(file_exists('index.php')) {
		$files = 'index.php';
		///print "ADA2";
	}
	//print "FILE: ".$_SESSION['SESSADM_UID']." : ".$_SESSION['SESSADM_sistem']." : ".$files; exit;	
?>
<script language="javascript" type="text/javascript">
	window.open('<?=$files;?>','_parent');
	
</script>
<?php 
exit;
} 
//$_SESSION['token']='';
//print $_SESSION['token'];
?>