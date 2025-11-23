<?php
session_start();
include '../common_log.php';
//include '../email/setup.php';

/**
 * This example shows settings to use when sending via Google's Gmail servers.
 */
//SMTP needs accurate times, and the PHP time zone MUST be set
//This should be done in your php.ini, but this is how to do it if you don't have access to that
date_default_timezone_set('Asia/Kuala_Lumpur');
require '../email/PHPMailerAutoload.php';

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

$pengguna=isset($_REQUEST["IDP"])?$_REQUEST["IDP"]:"";
$emel=isset($_REQUEST["email"])?$_REQUEST["email"]:"";
$token=isset($_REQUEST["token"])?$_REQUEST["token"]:"";

$passwd = substr(uniqid(),0,8);

//$pengguna='admin';
//$emel = "nizamms@gmail.com";
//$emel_name = "Hairul Nizam";

//Set e-mail content
$body = "<body style='font-family:verdana; font-size:15px;'>";
$body .= "Assalamualaikum,";
$body .= "<br><br>";
$body .= "Maklumat pengemaskinian katalaluan anda adalah seperti berikut:";
$body .= "<br>ID Pengguna: ".$pengguna;
$body .= "<br>Katalaluan: ".$passwd;

$body .= "<br><br><br>";
$body .= "..:::::Notifikasi Emel Permakluman:::::..<br>>>>>Sistem PTSI<<<<<br>Jabatan Kemajuan Islam Malaysia";
$body .= "<br><br><em>** Emel Ini Dijana Oleh Sistem PTSI Jakim. Tidak perlu dibalas **</em>";
$body .= "</body>";


$tarikh = date("Y-m-d H:i:s");
//$conn->debug=true;
if($_SESSION['token']==$token){
	$sql = "SELECT * FROM _tbl_users WHERE isdeleted=0 AND username=".tosql($pengguna)." AND emel=".tosql($emel);
	$rs = $conn->query($sql);
	$err = '';
	if($rs->recordcount()>=1){
		$email = $emel; 
		$emel_name = $rs->fields['nama']; 
		if(!$rs->EOF){
			$pss = md5($passwd);
			$rsu = $conn->execute("UPDATE _tbl_users SET passwords=".tosql($pss)." WHERE id=".tosql($rs->fields['id']));
			if($rsu){
				$err=$rs->fields['username'];
				$mail->setFrom('webmaster@islam.gov.my', 'Emel Notifikasi Katalaluan');
				//Set an alternative reply-to address
				$mail->addReplyTo('webmaster@islam.gov.my', 'Sistem PTSI');
				//Set who the message is to be sent to
				//$email = 'nizamms@gmail.com'; $emel_name='Penyelia SPH Jakim'; 
				$mail->AddAddress($email, $emel_name);
				//$mail->addAddress('nizamms@gmail.com', 'Admin Sistem');
				//Set e-mail content
				//Set the subject line
				$mail->Subject = 'Emel Pemberitahuan Katalaluan';
				//Replace the plain text body with one created manually
				$mail->AltBody = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
				$mail->MsgHTML($body);
				
				//send the message, check for errors
				if (!$mail->send()) {
					$err="ERR_SEND"; //echo "Mailer Error: " . $mail->ErrorInfo;
					//exit;
				} else {
					$err="SEND";
				}
			} else {
				$err='';
			}
			//$err = 'OK';
		}
	
	} else {
		
		$err='ERR_SEND';
	}
} else {
	$err='ERR_SEND';
}

header("Content-Type: text/json");
print json_encode($err); 
?>