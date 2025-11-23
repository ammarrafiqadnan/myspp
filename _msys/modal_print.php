<?php include '../connection/common.php'; ?>
<?php
$urlw = $_GET['win'];
$win = base64_decode($_GET['win']);
$get_win = explode(";", $win);
$pages = $get_win[0]; // piece1
$id = $get_win[1]; // piece1
$id2 = $get_win[2]; // piece1
if(!empty($_SESSION["s_logid"]) && $_SESSION["s_logid"]=='admin'){
	print "PG: ".$pages . " / " . $id;
}
// include_once 'function_proses.php';

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:w="urn:schemas-microsoft-com:office:word" xmlns="http://www.w3.org/TR/REC-html40">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="icon" type="image/png" href="../images/jakim.png">
<title></title>
<style media="display" type="text/css">
body,table,tr,td{
	FONT-SIZE: 12px;FONT-FAMILY: Arial;COLOR: #000000;
}
</style>
<style media="print" type="text/css">
body,table,tr,td{
	FONT-SIZE: 12px;FONT-FAMILY: Arial;COLOR: #000000;
}
.printButton { display: none; }

@media all{
 .page-break { display:none; }
}

@media print{
 .page-break { display:block; page-break-before:always; }
}
</style>
<script language="javascript" type="text/javascript">	
function do_close(){
	//parent.emailwindow.hide();
	window.close();
}
function handleprint(){
	window.print();
}
function do_submit(url){
	document.simpeni.action = url;
	document.simpeni.target = '_self';
	document.simpeni.submit();
}

</script>

</head>
<body>
<form name="simpeni" method="post" action="">
<table width="98%" align="center" cellpadding="4" cellspacing="0" border="0">
	<tr>
    	<td>
			<?php //print $pages;?>
			<?php include $pages;?>
        </td>
    </tr>
</table>
<?php if(empty($type)){ ?>
<div class="printButton" align="center">
<table border="0" align="center" cellpadding="1" cellspacing="0">
	<tr><td>
        <input type="hidden" name="n" value="<?php print $n;?>" /><input type="hidden" name="a" value="<?php print $a;?>" />
             <input type="hidden" name="url" value="<?php print $urlw;?>" />
	</td></tr>
</table>
</div>
<?php } ?>
</form>
</body>
</html>
<?php $conn->close(); ?>
