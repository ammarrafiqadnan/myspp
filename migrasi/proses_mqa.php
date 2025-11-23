<?php
include '../connection/common.php';
$row = 1;
$conn->debug=true;
if (($handle = fopen("mqa14.csv", "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 2000, ",")) !== FALSE) {
        $num = count($data);
        //echo "<p> $num fields in line $row: <br /></p>\n";
        $a = trim($data[0]);
        $b = trim($data[1]);
	$c = trim($data[2]);
	$d = trim($data[3]);
	
	//print "<br>DATA: ".$bil." :". $kodipt ." : ".$ipt." : ".$kategori." : ".$neg;
	//$rs = $conn->query("SELECT * FROM $schema1.padanan_institusi_pengkhususan WHERE KOD=".tosql($kodipt));	
	
	//if(!$rs->EOF){

	//} else {
		$sql = "INSERT INTO $schema1.padanan_institusi_pengkhususan(kod_institusi, kod_pengkhususan, peringkat_kelulusan, kategori)";
		$sql .= " VALUES('{$a}', '{$b}', '{$c}', '{$d}')"; 
		//print "<br>".$sql;
		$conn->execute($sql);
	//}	

	$bil++;
			
     }
}
print "JUM:".$bil;
?>