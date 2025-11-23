<?php
include '../connection/common.php';
$pages=isset($_REQUEST["pages"])?$_REQUEST["pages"]:"";
$prn=isset($_REQUEST["prn"])?$_REQUEST["prn"]:"";
$id=isset($_REQUEST["id"])?$_REQUEST["id"]:"";
$filename=isset($_REQUEST["filename"])?$_REQUEST["filename"]:"";
if(!empty($pages)){ $pages=$pages.".php"; }

if($filename == 'senarai_pemohon'){
	$tkh_mula=isset($_REQUEST["tkh_mula"])?$_REQUEST["tkh_mula"]:"";
    $tkh_akhir=isset($_REQUEST["tkh_akhir"])?$_REQUEST["tkh_akhir"]:"";
    $skim=isset($_REQUEST["skim"])?$_REQUEST["skim"]:"";
    $turutan=isset($_REQUEST["turutan"])?$_REQUEST["turutan"]:"";
    $negeri=isset($_REQUEST["negeri"])?$_REQUEST["negeri"]:"";
    $status=isset($_REQUEST["status"])?$_REQUEST["status"]:"";
    $carian=isset($_REQUEST["carian"])?$_REQUEST["carian"]:"";
} else if($filename == 'dokumen_pemohon'){
	$filename=isset($_REQUEST["filename"])?$_REQUEST["filename"]:"";
	$id_pemohon=isset($_REQUEST["id_pemohon"])?$_REQUEST["id_pemohon"]:"";
	$doc=isset($_REQUEST["doc"])?$_REQUEST["doc"]:"";
} else if($filename == 'semua_dokumen_pemohon'){
	$filename=isset($_REQUEST["filename"])?$_REQUEST["filename"]:"";
	$id_pemohon=isset($_REQUEST["id_pemohon"])?$_REQUEST["id_pemohon"]:"";
}
// print $pages;exit();
if($prn=='WORD'){
	header("Content-Type: application/vnd.ms-word");
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("content-disposition: attachment;filename=".$filename."-".date('Ymd').".doc");
} else if($prn=='EXCEL'){
	header("Content-Type: application/vnd.ms-excel");
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("content-disposition: attachment;filename=".$filename."-".date('Ymd').".xls");
}
?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=windows-1252">
<title>mySPP</title>
<!--<link href="css/printsurat.css" rel="stylesheet" type="text/css" media="screen">
    <link href="../css/bootstrap.css" type="text/css" rel="stylesheet" media="all">
    <link href="../css/style.css" type="text/css" rel="stylesheet" media="all">-->
<style type="text/css">
FONT{FONT-SIZE: 12px;FONT-FAMILY: Arial;COLOR: #000000}
TABLE{FONT-SIZE: 12px;FONT-FAMILY: Arial;COLOR: #000000}
TH{FONT-SIZE: 12px;FONT-FAMILY: Arial;COLOR: #000000}
TD{FONT-SIZE: 12px;FONT-FAMILY: Arial;COLOR: #000000}
BODY{FONT-SIZE: 12px;FONT-FAMILY: Arial;COLOR: #000000}
P{FONT-SIZE: 12px;FONT-FAMILY: Arial;COLOR: #000000}
DIV{FONT-SIZE: 12px;FONT-FAMILY: Arial;COLOR: #000000}

.title{
	background-color:#CCCCCC;
	font-weight:bold;
}
.td_data{
	border-bottom-style:dotted; 
	border-bottom-width:thin;
}
@media screen {
  div.divHeader {
    display: none;
  }
  div.divFooter {
    display: none;
  }
}
@media print {
  div.divHeader {
	text-align:right;
    position: fixed;
    top: 0;
  }
  div.divFooter {
    position: fixed;
    bottom: 0;
	width:100%;
  }
}

.header, .header-space {
  height: 20px;
}
.footer, .footer-space {
  height: 12px;
}
@page {
	margin-left:17mm;
	margin-right:17mm;
	margin-top:5mm;
  	margin-bottom: 5mm
}
.header {
  position: fixed;
  top: 0;
}
.footer {
  position: fixed;
  bottom: 0;
}
</style>
</head>
<body style="width: 100%;">
	
<table border="0" style="width: 100%;">
	<thead>
		<tr><td>
			<div class="header-space">&nbsp;</div>
		</td></tr>
	</thead>
	
	<tbody>
		<tr><td>
			<table align="center" border="0" cellpadding="0" cellspacing="0" width="98%">
				<tbody>
					<tr>
						<td valign="top">
							<?php if(!empty($pages)){ include $pages; } ?>
						</td>
					</tr>
				</tbody>
			</table>
		</td></tr>
	</tbody>
	
	<tfoot><tr><td>
		<div class="footer-space">&nbsp;</div>
		</td></tr>
	</tfoot>
</table>




<?php if(empty($prn)){ ?>
<!-- <div class="divHeader" style="width:100%">
	<table width="98%" border=0>
  	<tr>
      	<td width="20%" align="left" valign="bottom"><img src="images/jata.png" width="85" height="70" /></td>
          <td width="60%" align="center"><h4><?=$tajuk;?></h4></td>
      	<td width="20%" align="right" valign="middle"><img src="images/logo_jakim.png" width="80" height="80" /></td>
      </tr>
  </table>
</div> -->
<div class="divFooter">
	<table width="97%" border=0>
		<tr>
			<td align="left"><i>Dicetak oleh <?=$_SESSION['SESS_UNAME'];?> pada <?=date("d/m/Y");?></i></td>
			<td align="right"><i>Sumber : Sistem mySPP</i></td>
		</tr>
	</table>
	<!--<div>
		<div style="float:left;text-align:left;" align="ledt"><i>Dicetak oleh <?=$_SESSION['SESS_UNAME'];?> pada <?=date("d/m/Y");?></i></div>
		<div style="float:right;text-align:right;" align="right"><i>Sumber : Dashboard Pelan Tindakan Sosial Islam</i></div>
	</div>-->
</div>
<?php } ?>
</body>
</html>
