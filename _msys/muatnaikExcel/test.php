<?php
session_start();
//include '../../connection/common.php';
ob_clean();
//$connOra = odbc_connect('oracle_dsn', 'esmsm_data', 'abc123');
//include '../../connection/common_oracle.php';

$connOra = odbc_connect('oracle_dsn', 'esmsm_data', 'abc123');
if ($connOra) {
    echo "Oracle ODBC connection successful!";
    //odbc_close($connOra);
} else {
	//echo "Oracle ODBC connection failed!";
	print "Oracle ODBC connection failed!";
}

$ic='980624086700';
$sql = "SELECT CL.NO_KP_BARU FROM ESMSM_ADMIN.SKIM_DIPOHON A, ESMSM_ADMIN.SKIM B, ESMSM_ADMIN.DAFTAR_CALON C, ESMSM_ADMIN.CALON CL 
WHERE A.SKI_KOD = B.KOD  AND A.SAH_YT = 'Y' AND A.CAL_NO_PENGENALAN = C.NO_PENGENALAN 
AND A.SKI_KOD = C.SKIM  AND A.CAL_NO_PENGENALAN = CL.NO_PENGENALAN AND CL.NO_KP_BARU = '".$ic."'"; 
//AND CL.NO_KP_BARU  = '" + icno + "'"; //880212295153


$result = odbc_exec($connOra,$sql);
if ($result) {
	if($row = odbc_fetch_array( $result )){
		print "<br>DATA2".$row['NO_KP_BARU'];
		
		
		$sqlData = "SELECT  A.SKI_KOD SKI_KOD, B.DISKRIPSI DISKRIPSI, TO_CHAR(CL.TARIKH_KEMASKINI_SPP, 'DD/MM/YYYY') as TARIKH_DAFTAR, 
			case when a.tarikh_daftar > '23-SEP-2012' then TO_CHAR(ADD_MONTHS(CL.TARIKH_KEMASKINI_SPP,12)-1, 'DD/MM/YYYY') 
			else TO_CHAR(ADD_MONTHS(A.TARIKH_UBAHSUAI,12)-1, 'DD/MM/YYYY') end as tarikh_luput 
		FROM ESMSM_ADMIN.SKIM_DIPOHON A, ESMSM_ADMIN.SKIM B, ESMSM_ADMIN.DAFTAR_CALON C, ESMSM_ADMIN.CALON CL 
		WHERE A.SKI_KOD = B.KOD AND A.SAH_YT = 'Y' AND A.CAL_NO_PENGENALAN = C.NO_PENGENALAN AND A.SKI_KOD = C.SKIM 
			AND CL.NO_KP_BARU = '".$ic."' AND A.SKI_KOD not in ('1308','2756','4206','5777') AND A.CAL_NO_PENGENALAN = CL.NO_PENGENALAN  
		ORDER BY C.KEUTAMAAN, A.SKI_KOD ";

		$data = odbc_exec($connOra,$sqlData);
		if ($data) {
			while($row = odbc_fetch_array( $data )){
				print "<br>".$row['SKI_KOD'];
				print " : ".$row['DISKRIPSI'];
				print " : ".$row['TARIKH_DAFTAR'];
				print " : ".$row['TARIKH_LUPUT'];
			}
		}

	}
}

?>