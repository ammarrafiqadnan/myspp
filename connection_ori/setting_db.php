<?php
$ip = $_SERVER['HTTP_HOST'];


if($ip=='localhost'){

	//$actual_link = 'http://localhost/myspp/apps/index.php?data='.$data;
	$username="root"; //------------your username usually root
	$password="";//---------your password
	$database="spamenu";//----the name of the database
	$DB_hostname='localhost';

	$schema1 = 'spp_ref';
	$schema2 = 'spp_calon';
} else {

	$username="sppadmin"; //------------your username usually root
	$password="Spp@dmin1234"; // PWD baru 2
	$database="spa8i"; //"dbemuallaf";//----the name of the database
	$DB_hostname="10.29.25.145";
	$schema1 = 'spp_ref';
	$schema2 = 'spp_calon';
}


$conn = mysqli_connect($DB_hostname, $username, $password, $database);
if (mysqli_connect_errno())
{
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    //you need to exit the script, if there is an error
    exit();
}
//$conn->debug=1;
$conn = ADONEWConnection('mysqli');
$conn->Connect($DB_hostname, $username, $password, $database);
//exit;
?>
