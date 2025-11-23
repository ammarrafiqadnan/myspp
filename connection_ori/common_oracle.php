<?php
$ip = $_SERVER['HTTP_HOST'];
$oraerr='';

if($ip=='localhost'){

	//$actual_link = 'http://localhost/myspp/apps/index.php?data='.$data;
	$username="root"; //------------your username usually root
	$password="";//---------your password
	$database="spamenu";//----the name of the database
	$DB_hostname='localhost';
	$schema1 = 'spamenu';
	$schema2 = 'spa8i';

	$conn_ora = ADONEWConnection('mysqli');
	$conn_ora->Connect($DB_hostname, $username, $password, $database);

} else {
	$connOra = odbc_connect('sppdevdb_dsn', 'esmsm_data', 'abc123');
	if ($connOra) {
	    //echo "Oracle ODBC connection successful!";
	    //odbc_close($connOra);
	} else {
    		//echo "Oracle ODBC connection failed!";
		$oraerr="Oracle ODBC connection failed!";
	}

}
?>