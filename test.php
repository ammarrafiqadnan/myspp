<?php 
//phpinfo(); 
include 'connection/common.php';
/*
require_once('connection/adodb.inc.php');

	$username="esmsm_data"; //------------your username usually root
	$password="abc123"; // PWD baru 2
	$database="sppdevdb"; //"dbemuallaf";//----the name of the database
	$DB_hostname="10.29.202.61";
	// $schema1 = 'spamenu';
	// $schema2 = 'spa8i';
	$conn_ora = ADONEWConnection('odbc');
	$conn_ora->Connect($DB_hostname, $username, $password, $database);

	$user = "esmsm_data"; 
    $password = "abc123";
    $SQLQuery = "SELECT s_calon8i_seq.NEXTVAL AS vals FROM dual";
    $RecordSet = odbc_exec($conn_ora, $SQLQuery);

*/
print "<br>".get_client_ipadd();
print "<br>".get_client_ip();


        print "<br>1.".$_SERVER['HTTP_CLIENT_IP'];

        print "<br>2.".$_SERVER['HTTP_X_FORWARDED_FOR'];

        print "<br>3.".$_SERVER['HTTP_X_FORWARDED'];

        print "<br>4.".$_SERVER['HTTP_FORWARDED_FOR'];

        print "<br>5.".$_SERVER['HTTP_FORWARDED'];

        print "<br>6.".$_SERVER['REMOTE_ADDR'];



// if user from the share internet  
    if(!empty($_SERVER['HTTP_CLIENT_IP'])) {  
        echo 'IP address = '.$_SERVER['HTTP_CLIENT_IP'];  
    }  
    //if user is from the proxy  
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {  
        echo 'IP address = '.$_SERVER['HTTP_X_FORWARDED_FOR'];  
    }  
    //if user is from the remote address  
    else{  
        echo 'IP address = '.$_SERVER['REMOTE_ADDR'];  
    }    
?>
