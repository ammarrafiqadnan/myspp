<?php
$to = "nizamms@gmail.com";
$subject = "My subject";
$txt = "Hello world!Testinggggg";
$headers = "From: azlan@dvs.gov.my" . "\r\n" .
"CC: nizamms@yahoo.com";

mail($to,$subject,$txt,$headers);
?>
