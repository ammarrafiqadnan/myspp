<?php
$id_pemohon=isset($_REQUEST["id_pemohon"])?$_REQUEST["id_pemohon"]:"";
$doc=isset($_REQUEST["doc"])?$_REQUEST["doc"]:"";
$tmp = explode('.', $doc);
$ext = end($tmp);

// $filename =$_GET['reportname'];
$fileDir = "/var/www/upload/";
$filename = $fileDir.$id_pemohon."/".$doc;
file_exists($filename)or die("No File available");
//header("Content-Type: application/pdf");
//$fp = fopen($filename, 'rb');
//fpassthru($fp);

header("Content-type: application/pdf");
header('Content-Disposition: inline; filename="$file"'); 
header('Content-Transfer-Encoding: binary');
header('Accept-Ranges: bytes');
header("Content-Length: " . filesize($filename));
// Send the file to the browser.
readfile('data:application/pdf;base64;'.$filename);
?>