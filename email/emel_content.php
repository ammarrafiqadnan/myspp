<?php
//include 'emel/setup.php';

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

//Enable SMTP debugging
// 0 = off (for production use)
// 1 = client messages
// 2 = client and server messages
$mail->SMTPDebug = 0;

//Ask for HTML-friendly debug output
$mail->Debugoutput = 'html';

//Set the hostname of the mail server
$mail->Host = 'postmaster.1govuc.gov.my';
// use
// $mail->Host = gethostbyname('smtp.gmail.com');
// if your network does not support SMTP over IPv6

//Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
$mail->Port = 25;

//Set the encryption system to use - ssl (deprecated) or tls
//$mail->SMTPSecure = 'tls';

//Whether to use SMTP authentication
//$mail->SMTPAuth = false;

//Username to use for SMTP authentication - use full email address for gmail
//$mail->Username = "eparlimen@jpnin.gov.my";

//Password to use for SMTP authentication
//$mail->Password = "Eparlimen.4321";

// UNTUK UJIAN SAHAJA
//$email_to = 'nfikri8@gmail.com';

if($kod_emel=='E1'){
	
	// proses reset email lupa kata laluan data
	
	//Set e-mail content
	$body = "<body style='font-family:verdana; font-size:15px;'>";
	$body .= "<br><b>Assalamualaikum w.b.t</b>";
	$body .= "<br><br>";
	$body .= "<br>Tuan/Puan ";
	$body .= "<br><br>";
	$body .= "<br>Kata laluan tuan/puan telah diset semula seperti berikut: ";
	$body .= "<br>";
	$body .= "<br>Nama : ".$NAMA;
	$body .= "<br>ID Pengguna : ".$NOKP;
	$body .= "<br>Kata Laluan : ".$NOKP;
	$body .= "<br><br>";
	$body .="Sila log masuk ke Sistem e-Daie (e-daie.islam.gov.my) dengan menggunakan kata laluan seperti di atas. 
		Tuan/Puan perlu menukar kata laluan kepada kata laluan baru yang mengandungi 12 aksara dengan gabungan huruf besar, huruf kecil, angka dan simbol.";
	$body .= "<br><br>";
	$body .= "Sekian Terima Kasih.";
	$body .= "<br><br>";
	$body .= "<b>Pentadbir Sistem e-Daie</b>";
	$body .= "<br>";
	$body .= "*E-mel ini adalah cetakan komputer. Tandatangan tidak diperlukan.*";
	$body .= "</body>";
	//Set the subject line
	$mail->Subject = 'Emel Pemberitahuan Lupa Kata Laluan';

} else if($kod_emel=='E2'){
	
	//Set agih aduan content
	$body = "<body style='font-family:verdana; font-size:15px;'>";
	$body .= "Assalamualaikum w.b.t";
	$body .= "<br><br>";
	$body .= "Tuan/Puan,";
	$body .= "<br><br>";
	$body .= "Sukacita dimaklumkan bahawa permohonan telah <b>Diterima</b> seperti butiran berikut.";
	$body .= "<br>No. Permohonan : ".$Rujukan;
	$body .= "<br>Nama Program : ".$Program;
	$body .= "<br>Tajuk Ceramah : ".$TajukProgram;
	$body .= "<br>Tarikh Mohon : ".$TarikhMohon;
	$body .= "<br><br>";
	$body .= "Sekian Terima Kasih.";
	$body .= "<br><br>";
	$body .= "Pentadbir Sistem(e-Daie)";
	$body .= "<br><br>";
	$body .= "*E-mel ini adalah cetakan komputer. Tandatangan tidak diperlukan.*";
	$body .= "</body>";
	//Set the subject line
	$mail->Subject = 'Emel Pemberitahuan Permohonan Penceramah';

} else if($kod_emel=='E3'){

	//Set e-mail pengesahan Aplikasi MyNCR content
	$body = "<body style='font-family:verdana; font-size:15px;'>";
	$body .= "Assalamualaikum w.b.t";
	$body .= "<br><br>";
	$body .= "<b>Tuan/Puan,</b>";
	//$body = "<body style='font-family:verdana; font-size:15px;'>";
	$body .= "<br><br>";
	$body .= "Terima kasih kerana menggunakan Sistem e-Daie";
	$body .= "<br><br>";
	$body .= "Pendaftaran tuan/puan sebagai pengguna sistem telah berjaya dilaksanakan seperti butiran berikut: ";
	$body .= "<br>Nama : ".$Nama;
	$body .= "<br>No.Kad Pengenalan : ".$NOKP;
	$body .= "<br>Emel : ".$Emel;
    $body .= "<br>Telefon Yang Boleh Dihubungi : ".$Tel;
	$body .= "<br>Bagi kali pertama log masuk, ID Pengguna dan kata laluan adalah menggunakan No. Kad Pengenalan. Tuan/Puan perlu 
	menukar kata laluan baru yang mengandungi 12 aksara dengan kombinasi huruf besar, huruf 
	kecil, nombor dan simbol bagi tujuan keselamatan ";
	$body .= "<br><br>";
	$body .= "Terima kasih,";
	$body .= "<br><br>";
	$body .= "<br><b>Pentadbir Sistem eDaie</b>";
//	$body .= "<br><br>";
	$body .= "<br>*E-mel ini adalah cetakan komputer. Tandatangan tidak diperlukan.*";
	$body .= "</body>";
	//Set the subject line
	$mail->Subject = 'Pengesahan Pendaftaran Permohonan Penceramah';
	

} else if($kod_emel=='E4'){

	//Set e-mail content
	$body = "<body style='font-family:verdana; font-size:15px;'>";
	$body .= "Assalamualaikum w.b.t";
	$body .= "<br><br>";
	$body .= 'Sila klik <a href="http://www.sppim.gov.my/aduan/myncr/appapk/MyNCR.apk">disini</a> untuk proses muat turun dan install ke dalam telefon pintar anda.';
	$body .= "<br><br>";
	$body .= "Pendaftaran aplikasi berdasarkan maklumat berikut  ";
	$body .= "<br>Nama : ".$rsc->fields['fld_staff'];
	$body .= "<br>No. Telefon : ".$rsc->fields['fld_tel'];
	$body .= "<br>Emel : ".$rsc->fields['fld_email'];
	//$body .= "Emel to ".$email." telah<br><br><strong>Dihantar".$email_to."".$email_name."</strong>.<br> untuk Tindakan Tuan / Puan, <br>";
	$body .= "<br><br>";
	$body .= "Sila log masuk ke dalam sistem untuk mendaftarkan <b>No. unik id telefon bimbit</b> setelah anda berjaya <i>install</i> aplikasi MyNCR.";
	$body .= "<br><br>";
	$body .= "url : http://www.sppim.gov.my/aduan/login.php";
	$body .= "<br><br>";
	$body .= "ID Pengguna & Kata Laluan : (no kad pengenalan)";
	$body .= "<br><br>";
	$body .= "Terima kasih,";
	$body .= "<br>";
	$body .= "Pentadbir MyNCR";
	$body .= "<br><br>";
	$body .= "*E-mel ini adalah cetakan komputer. Tandatangan tidak diperlukan.*";
	$body .= "</body>";
	//Set the subject line
	$mail->Subject = 'Muat Turun Aplikasi Mobile';

} else if($kod_emel=='E5'){
	
	//Set agih aduan content
	$body = "<body style='font-family:verdana; font-size:15px;'>";
	$body .= "Assalamualaikum w.b.t";
	$body .= "<br><br>";
	$body .= "Tuan/Puan,";
	$body .= "<br><br>";
	$body .= "Terima kasih atas maklum balas yang telah dikemukakan di Sistem e-Daie. 
		Pihak JAKIM akan menyemak maklum balas tersebut dan respon akan diberikan menggunakan alamat e-mel yang telah didaftarkan";
	$body .= "<br><br>";
	//$body .= "Maklumbalas  tuan/puan akan disemak oleh pegawai kami. Maklum balas tuan/puan akan dibalas melalui emel yang didaftarkan.";
	//$body .= "<br>No. Aduan : ".$aduan_id;
	//$body .= "Emel to ".$email." telah<br><br><strong>Dihantar".$email_to."".$email_name."</strong>.<br> untuk Tindakan Tuan / Puan, <br>";
	$body .= "<br><br>";
	$body .= "Sekian, terima kasih.";
	$body .= "<br><br>";
	$body .= "<b>Pentadbir Sistem e-Daie</b>";
	$body .= "*E-mel ini adalah cetakan komputer. Tandatangan tidak diperlukan.*";
	$body .= "</body>";
	//Set the subject line
	$mail->Subject = 'Maklum Balas Sistem e-Daie';

} else if($kod_emel=='E6'){
	// PENGESAHAN PENYELIA - SOKONG
	//Set agih aduan content
	//$email_to = 'edaie@islam.gov.my'; $email_name='Urusetia eDaie';
	$email_to = 'nizamms@gmail.com'; $email_name='NizamMS';
	$body = "<body style='font-family:verdana; font-size:15px;'>";
	$body .= "Assalamualaikum w.b.t";
	$body .= "<br><br>";
	$body .= "Tuan/Puan,";
	$body .= "<br><br>";
	$body .= "Untuk makluman tuan/puan, Permohonan (".$no_permohonan.") bagi penceramah bernama ".$Nama_Penceramah." 
		telah diluluskan oleh Penyelia. 
		Pihak urusetia perlu menyokong permohonan ini untuk membolehkan notifikasi diterima oleh Pemohon.";
	$body .= "<br><br>";
	$body .= "Sekian Terima Kasih.";
	$body .= "<br><br>";
	$body .= "<b>Pentadbir Sistem eDaie</b>";
	$body .= "*E-mel ini adalah cetakan komputer. Tandatangan tidak diperlukan.*";
	$body .= "</body>";
	//Set the subject line
	$mail->Subject = 'E-MEL PERMOHONAN DILULUSKAN OLEH PENYELIA';

} else if($kod_emel=='E7'){
	// KELULUSAN PENYELIA - TIDAK SOKONG
	//Set agih aduan content
	//$email_to = 'edaie@islam.gov.my'; $email_name='Urusetia eDaie';
	$email_to = 'nizamms@gmail.com'; $email_name='NizamMS';
	$body = "<body style='font-family:verdana; font-size:15px;'>";
	$body .= "Assalamualaikum w.b.t";
	$body .= "<br><br>";
	$body .= "Tuan/Puan,";
	$body .= "<br><br>";
	$body .= "Untuk makluman tuan/puan, Permohonan (".$no_permohonan.")  bagi penceramah bernama ".$Nama_Penceramah." 
		tidak diluluskan oleh Penyelia. 
		Pihak urusetia perlu memilih penceramah lain untuk tindakan selanjutnya.";
	$body .= "<br><br>";
	//$body .= "Maklumbalas  tuan/puan akan disemak oleh pegawai kami. Maklum balas tuan/puan akan dibalas melalui emel yang didaftarkan.";
	//$body .= "<br>No. Aduan : ".$aduan_id;
	//$body .= "Emel to ".$email." telah<br><br><strong>Dihantar".$email_to."".$email_name."</strong>.<br> untuk Tindakan Tuan / Puan, <br>";
	$body .= "Sekian Terima Kasih.";
	$body .= "<br><br>";
	$body .= "<b>Pentadbir Sistem eDaie</b>";
	$body .= "*E-mel ini adalah cetakan komputer. Tandatangan tidak diperlukan.*";
	$body .= "</body>";
	//Set the subject line
	$mail->Subject = 'E-MEL PERMOHONAN TIDAK DILULUSKAN OLEH PENYELIA';

} else if($kod_emel=='E8'){
	//Set agih aduan content
	$body = "<body style='font-family:verdana; font-size:15px;'>";
	$body .= "Assalamualaikum w.b.t";
	$body .= "<br><br>";
	$body .= "Tuan/Puan,";
	$body .= "<br><br>";
	$body .= "Sukacita dimaklumkan bahawa permohonan telah <b>Diluluskan</b>.";
	$body .= "<br>No. Permohonan : ".$Rujukan;
	$body .= "<br>Nama Program : ".$Program;
	$body .= "<br>Tajuk Ceramah : ".$TajukProgram;
	//$body .= "<br>Tarikh Mohon : ".$TarikhMohon;

	$body .= "<br><br>";
	$body .= "Pihak penganjur boleh membuat cetakan surat kelulusan bagi proses selanjutnya.";

	$body .= "<br><br>";
	$body .= "Sekian Terima Kasih.";
	$body .= "<br><br>";
	$body .= "Urusetia Pengurusan Pendakwah(eDaie)";
	$body .= "<br><br>";
	$body .= "*E-mel ini adalah cetakan komputer. Tandatangan tidak diperlukan.*";
	$body .= "</body>";
	//Set the subject line
	$mail->Subject = 'Emel Pemberitahuan Kelulusan Permohonan Penceramah';

} else if($kod_emel=='E9'){

	//Set agih aduan content
	$body = "<body style='font-family:verdana; font-size:15px;'>";
	$body .= "Assalamualaikum w.b.t";
	$body .= "<br><br>";
	$body .= "Tuan/Puan,";
	$body .= "<br><br>";
	$body .= "Dimaklumkan bahawa permohonan telah <b>Ditolak</b>.";
	$body .= "<br>No. Permohonan : ".$Rujukan;
	$body .= "<br>Nama Program : ".$Program;
	$body .= "<br>Tajuk Ceramah : ".$TajukProgram;
	//$body .= "<br>Tarikh Mohon : ".$TarikhMohon;

	$body .= "<br><br>";
	$body .= "Pihak penganjur boleh membuat rayuan atau membuat permohonan semula.";

	$body .= "<br><br>";
	$body .= "Sekian Terima Kasih.";
	$body .= "<br><br>";
	$body .= "Urusetia Pengurusan Pendakwah(eDaie)";
	$body .= "<br><br>";
	$body .= "*E-mel ini adalah cetakan komputer. Tandatangan tidak diperlukan.*";
	$body .= "</body>";
	//Set the subject line
	$mail->Subject = 'Emel Pemberitahuan Penolakan Permohonan Penceramah';

}


//print $body; //exit;
//Set who the message is to be sent from
$mail->setFrom('edaie@islam.gov.my', 'Emel Notifikasi Sistem Maklumat Pengurusan Pendakwah (eDaie)');  //edaie@islam.gov.my

//Set an alternative reply-to address
$mail->addReplyTo('edaie@islam.gov.my', 'Sistem Maklumat Pengurusan Pendakwah');

//Set who the message is to be sent to
$mail->AddAddress($email_to, $email_name);
if(!empty($emel_cc)){
	$mail->AddCC($emel_cc, 'Webmaster Sistem');
}
// $mail->AddCC('unit_sistem@jpnin.gov.my', 'Unit Teknikal E-Parlimen');

//Replace the plain text body with one created manually
$mail->AltBody = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
$mail->MsgHTML($body);

//print_r($mail); exit;

//Attach an image file
//$mail->addAttachment('images/ebelanja.jpg');

//send the message, check for errors
if (!$mail->send()) {
    echo "Mailer Error: " . $mail->ErrorInfo;
} else {
   // echo "Message sent!";
}
?>

