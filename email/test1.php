<html>
   
   <head>
      <title>Sending HTML email using PHP</title>
   </head>
   
   <body>
      
      <?php
         include 'mail_send.php';
         // $to = "nizamms@gmail.com";
         // $subject = "This is subject";
         
         // $message = "<b>This is HTML message.</b>";
         // $message .= "<h1>This is headline.</h1>";
         
         // $header = "From:abc@somedomain.com \r\n";
         // $header .= "Cc:afgh@somedomain.com \r\n";
         // $header .= "MIME-Version: 1.0\r\n";
         // $header .= "Content-type: text/html\r\n";
         
         // $retval = mail ($to,$subject,$message,$header);
         
         // if( $retval == true ) {
         //    echo "Message sent successfully...";
         // }else {
         //    echo "Message could not be sent...";
         // }

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
	print "done";
      ?>
      
   </body>
</html>