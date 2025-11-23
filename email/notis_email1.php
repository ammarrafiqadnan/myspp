<?php
include 'mail_send.php';

// PENERIMA EMEL
$kepada = 'nizamms@gmail.com';
$nama_penerima = "Hairul Nizam";

// PENGHANTAR EMEL
$dari = "nizamms@gmail.com";

// SALINA KEPADA
$cc = '';

// TAJUK EMEL
$tajuk="Hantar Emel Ujian";

// KANDUNGAN EMEL
$mesej = "<b>This is HTML message.</b>";
$mesej .= "<h1>This is headline.</h1>"; 

// mail_send($tajuk, $mesej, $kepada, $nama_penerima, $dari, $cc);
mail_smtp($tajuk, $mesej, $kepada, $nama_penerima, $dari, $cc);
?>