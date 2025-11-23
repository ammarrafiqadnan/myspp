<?php

// $filename =$_GET['reportname'];
$fileDir = "/var/www/upload/";
$filename = $fileDir."20230414145982/840414145982_univ1c.pdf";
file_exists($filename)or die("No File available");
header("Content-Type: application/pdf");
$fp = fopen($filename, 'rb');
fpassthru($fp);

?>