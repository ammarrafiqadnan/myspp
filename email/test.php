<?php
$email = "nizamms@gmail.com";
$emel_name = "Hairul Nizam";

//Set e-mail content
$body = "<body style='font-family:verdana; font-size:15px;'>";
$body .= "Assalamualaikum,";
$body .= "<br><br>";
$body .= "Maklumat pengemaskinian  dan penghantaran maklumat terkini.";
$body .= "<br><br><br>";
$body .= "..:::::Notifikasi Emel Permakluman:::::..<br>>>>>Sistem EAMH<<<<<br>jabatan Perkhidmatan Vaterina";
$body .= "<br><br><em>** Emel Ini Dijana Oleh Sistem DVS Tidak perlu dibalas **</em>";
$body .= "</body>";

	/**
	 * This example shows settings to use when sending via Google's Gmail servers.
 */
//SMTP needs accurate times, and the PHP time zone MUST be set
//This should be done in your php.ini, but this is how to do it if you don't have access to that
date_default_timezone_set('Asia/Kuala_Lumpur');
require 'PHPMailerAutoload.php';

//Create a new PHPMailer instance
$mail = new PHPMailer;

//Tell PHPMailer to use SMTP
$mail->isSMTP();
$mail->CharSet = "utf-8";// set charset to utf8

//Enable SMTP debugging
// 0 = off (for production use)
// 1 = client messages
// 2 = client and server messages
$mail->SMTPDebug = 2;


//Ask for HTML-friendly debug output
$mail->Debugoutput = 'html';

//Set the hostname of the mail server
// $mail->Host = 'postmaster.mygovuc.gov.my';
// use
$mail->Host = gethostbyname('localhost');
// $mail->Host = gethostbyname('aspmx.l.google.com');
// if your network does not support SMTP over IPv6

//Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
$mail->Port = 25;
// $mail->Port = 587;

//Whether to use SMTP authentication
$mail->SMTPAuth = false;
//Set the encryption system to use - ssl (deprecated) or tls
$mail->SMTPSecure = 'tls';
$mail->SMTPAuth = false;// Enable SMTP authentication


/*
$mail->isSMTP();// Set mailer to use SMTP
$mail->CharSet = "utf-8";// set charset to utf8
$mail->SMTPAuth = false;// Enable SMTP authentication
$mail->SMTPSecure = 'tls';// Enable TLS encryption, `ssl` also accepted

$mail->Host = 'postmaster.mygovuc.gov.my';// Specify main and backup SMTP servers
$mail->Port = 25;// TCP port to connect to
*/

$mail->SMTPOptions = array(
    'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
    )
);
$mail->isHTML(true);// Set email format to HTML

//$mail->Username = 'Sender Email';// SMTP username
//$mail->Password = 'Sender Email Password';// SMTP password




//print $body; exit;
$mail->setFrom('eamh@dvs.gov.my', 'Emel Notifikasi Pendaftaran Pengguna');
//Set an alternative reply-to address
$mail->addReplyTo('eamh@dvs.gov.my', 'Sistem e-AMH');
//Set who the message is to be sent to
$email = 'nizamms@gmail.com'; $emel_name='Test Pengguna'; 
$mail->AddAddress($email, $emel_name);
//$mail->addAddress('nizamms@gmail.com', 'Admin Sistem');

//Set e-mail content

//Set the subject line
$mail->Subject = 'Emel Pemberitahuan Pendaftaran Pengguna';
//Replace the plain text body with one created manually
$mail->AltBody = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
$mail->MsgHTML($body);

//send the message, check for errors
if (!$mail->send()) {
	echo "Mailer Error: " . $mail->ErrorInfo;
	exit;
} else {
	print '<script language="javascript">alert("Emel telah dihantar kepada Pengguna Sistem")</script>';
   // echo "Message sent!";
}

?>