<?php

$filename = "2023930111016453/930111016453_spm1.jpeg";
$fileDir = "/var/www/images/";
$file = $fileDir . $filename;
if (file_exists($file))
{
     $b64image = base64_encode(file_get_contents($file));
     echo "<img src = 'data:image/png;base64,$b64image'>";
}

?>