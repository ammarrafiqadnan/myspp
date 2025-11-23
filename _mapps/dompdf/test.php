<?php
namespace Dompdf;
require_once 'autoload.inc.php';

$dompdf = new Dompdf(); 
$dompdf->loadHtml('
<table border=1 align=center width=400>
<tr><td>Name : </td><td>nama</td></tr>
<tr><td>Email : </td><td>email</td></tr>
<tr><td>Age : </td><td>umur</td></tr>
<tr><td>Country : </td><td>Negara</td></tr>
</table>
');
$dompdf->setPaper('A4', 'landscape');
$dompdf->render();
$dompdf->stream("",array("Attachment" => false));
exit(0);

?>

