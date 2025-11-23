<?php
date_default_timezone_set('Asia/Kuala_Lumpur');

function mail_send($tajuk, $mesej, $kepada, $emel_name, $dari, $cc){
	$to = $kepada;
	$subject = $tajuk;

	$message = nl2br($mesej);

	$header = "From:".$dari." \r\n";
	if(!empty($cc)){ $header .= "Cc:".$cc." \r\n"; }
	$header .= "MIME-Version: 1.0\r\n";
	$header .= "Content-type: text/html\r\n";

	//print $to.":".$tajuk.":".$mesej.":".$header;

	$retval = mail ($to,$subject,$message,$header);

	if( $retval == true ) {
		// echo "Message sent successfully...";
		$err = 'OK';
	}else {
		// echo "Message could not be sent...";
		$err = 'ERR';
	}

	return $err;
}


function mail_smtp($tajuk, $mesej, $kepada, $emel_name, $dari, $cc){
	require_once 'PHPMailerAutoload.php';

	//Create a new PHPMailer instance
	$mail = new PHPMailer;

	//Tell PHPMailer to use SMTP
	$mail->isSMTP();

	//Enable SMTP debugging
	// 0 = off (for production use)
	// 1 = client messages
	// 2 = client and server messages
	$mail->SMTPDebug = 0;

	//Ask for HTML-friendly debug output
	$mail->Debugoutput = 'html';

	//Set the hostname of the mail server
	//$mail->Host = '10.24.251.125';
	  $mail->Host = 'postmaster.mygovuc.gov.my';

	// use
	// $mail->Host = gethostbyname('smtpgoogle.com');
	// if your network does not support SMTP over IPv6

	//Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
	$mail->Port = 25;

	//Set the encryption system to use - ssl (deprecated) or tls
	$mail->SMTPSecure = 'tls';

	//Whether to use SMTP authentication
	$mail->SMTPAuth = false;

	$mail->SMTPOptions = array(
    		'ssl' => array(
        	'verify_peer' => false,
        	'verify_peer_name' => false,
        	'allow_self_signed' => true
    		)
	);
	$mail->isHTML(true);// Set email format to HTML


	//print $body; exit;
	// $mail->setFrom('webmaster@spp.gov.my', 'Emel Notifikasi Pendaftaran Pengguna');
	$mail->setFrom($dari, $tajuk);
	//Set an alternative reply-to address
	// $mail->addReplyTo('webmaster@spp.gov.my', 'Sistem MySPP');
	$mail->addReplyTo($dari, 'Sistem e-AMH');
	//Set who the message is to be sent to
	// $email = 'nizamms@gmail.com'; $emel_name='Test Pengguna'; 
	// $email = $kepada; $emel_name; 
	$mail->AddAddress($kepada, $emel_name);
	//$mail->AddBCC("webmaster@spp.gov.my", 'Webmaster Sistem');

	//Set e-mail content

	//Set the subject line
	// $mail->Subject = 'Emel Pemberitahuan Pendaftaran Pengguna';
	$mail->Subject = $tajuk;
	//Replace the plain text body with one created manually
	// $mail->AltBody = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
	$mail->MsgHTML($mesej);

	//send the message, check for errors
	if (!$mail->send()) {
		// echo "Mailer Error: " . $mail->ErrorInfo;
		$err =  $mail->ErrorInfo;
		// exit;
	} else {
		// print '<script language="javascript">alert("Emel telah dihantar kepada Pengguna Sistem")</script>';
	   	// echo "Message sent!";
		$err = 'OK';
	}

	return $err;
}
?>