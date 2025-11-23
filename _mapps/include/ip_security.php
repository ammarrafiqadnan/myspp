<?php
$ipget = $_SERVER['REMOTE_ADDR'];
$timecount = microtime();
$timecount = explode(" ", $timecount);
$timecount = $timecount[1] + $timecount[0];
$start_time = $timecount;
$isuser_dalaman=0;
//echo $ipget;
//$ipget = '172.17.16.6';
$ips = substr($ipget, 0,3);
//echo $ips;
if($ips!='172' && $ips!='127'){
	/*include("auth/secure.php");
	include("auth/secure.php");
	include("auth/secure.php");
	//echo "<br>".$ip;
	$ref = $_SERVER['REQUEST_URI'];
	if(!isset($user->authenticated)){ ?>
		<script language='Javascript'>
			alert('Sila klik pada login untuk masuk ke dalam portal.');
		</script>
		<meta http-equiv="refresh" content="0; URL=index.php?ref=<?php print $ref;?>"> 
	<?
		exit();
	}*/
	$syarat = " AND isintranet = '0' ";
	$isuser_dalaman=1;
	// END AUTH
} else {
	if($ipget=='172.17.16.6'){
		$syarat = " AND isintranet = '0' "; // INI UNTU INTRANET USER SAHAJA
		/*include("auth/secure.php");
		include("auth/secure.php");
		include("auth/secure.php");
		//echo "<br>".$ip;
		$ref = $_SERVER['REQUEST_URI'];
		if(!isset($user->authenticated)){ ?>
			<script language='Javascript'>
				alert('Sila klik pada login untuk masuk ke dalam portal.');
			</script>
			<meta http-equiv="refresh" content="0; URL=index.php?ref=<?php print $ref;?>"> 
		<?
			exit();
		}*/
		// END AUTH
	} else {
		$syarat = " AND isintranet IN ('1','0') ";
	}
}

?>