<?php
require 'PHPMailerAutoload.php';

$mail = new PHPMailer;

//$mail->SMTPDebug = 3;                               // Enable verbose debug output

$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = 'smtp1.example.com;smtp2.example.com';  // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = 'dataspe';                 // SMTP username
$mail->Password = 'Mr.Robot434dabest';                           // SMTP password
$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
$mail->Port = 21;                                    // TCP port to connect to

$mail->From = 'hidayumutalib@gmail.com';
$mail->FromName = 'Mailer';
$mail->addAddress('hidayumutalib@gmail.com', 'Joe User');     // Add a recipient
$mail->addAddress('hidayumutalib@gmail.com');               // Name is optional
$mail->addReplyTo('hidayumutalib@gmail.com', 'Information');
$mail->addCC('hidayumutalib@gmail.com');
$mail->addBCC('hidayumutalib@gmail.com');

$mail->WordWrap = 50;                                 // Set word wrap to 50 characters
$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
$mail->isHTML(true);                                  // Set email format to HTML

$mail->Subject = 'Here is the subject';
$mail->Body    = 'This is the HTML message body <b>in bold!</b>';
$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

if(!$mail->send()) {
    echo 'Message could not be sent.';
    // echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo 'Message has been sent';
}

?>

<?php
// $to = "hidayumutalib@gmail.com";
// $subject = "Test mail";
// $message = "Hello! This is a test email message.";
// $from = "hidayumutalib@gmail.com";
// $headers = "From:" . $from;
// mail($to,$subject,$message,$headers);
// if(mail($to,$subject,$message,$headers)){
//   echo "Email successfully sent.";  
// } else {
//     echo 'failed';
// }

// $from = "hidayumutalib@gmail.com";
// $to = "hidayumutalib@gmail.com";
// $subject = "Checking PHP mail";
// $message = "PHP mail works just fine";
// $headers = "From:" . $from;
// if(mail($to,$subject,$message, $headers)) {
//     echo "The email message was sent.";
// } else {
//     echo "The email message was not sent.";
// }

?>

