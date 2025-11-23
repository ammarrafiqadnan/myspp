<?php

$maxRetries = 3;
$retryDelay = 5; // seconds

$connOra = null;
for ($retryCount = 1; $retryCount <= $maxRetries; $retryCount++) {
	echo "Try to connect Oracle !!!!!!\n";
    $connOra = odbc_connect('oracle_dsn', 'esmsm_data', 'abc123');

    if ($connOra) {
        echo "Connected successfully!\n";
        break; // Connection successful, exit the loop
    } else {
        echo "Connection attempt {$retryCount} failed.\n";

        if ($retryCount < $maxRetries) {
            echo " Retrying in {$retryDelay} seconds...\n";
            sleep($retryDelay);
        }
    }
}

$sqlData = "SELECT  A.SKI_KOD AS SKI_KOD, B.DISKRIPSI AS DISKRIPSI, TO_CHAR(CL.TARIKH_KEMASKINI_SPP, 'DD/MM/YYYY') as TARIKH_DAFTAR, 
			case when a.tarikh_daftar > '23-SEP-2012' then TO_CHAR(ADD_MONTHS(CL.TARIKH_KEMASKINI_SPP,12)-1, 'DD/MM/YYYY') 
			else TO_CHAR(ADD_MONTHS(A.TARIKH_UBAHSUAI,12)-1, 'DD/MM/YYYY') end as tarikh_luput 
			FROM ESMSM_ADMIN.SKIM_DIPOHON A, ESMSM_ADMIN.SKIM B, ESMSM_ADMIN.DAFTAR_CALON C, ESMSM_ADMIN.CALON CL 
			WHERE A.SKI_KOD = B.KOD AND A.SAH_YT = 'Y' AND A.CAL_NO_PENGENALAN = C.NO_PENGENALAN AND A.SKI_KOD = C.SKIM 
			AND CL.NO_KP_BARU = '840414145982' AND A.SKI_KOD not in ('1308','2756','4206','5777') AND A.CAL_NO_PENGENALAN = CL.NO_PENGENALAN  
			ORDER BY C.KEUTAMAAN, A.SKI_KOD ";
			
			//if($_SESSION['SESS_UID']=='20230414145982'){ print $sqlData; }
print $sqlData; 
			
//print ";";
			//$data = odbc_exec($connOra,$sqlData);
print ".";
			//$row = odbc_fetch_array( $data );
//print "..";
			//$tkh_daftar = $row['TARIKH_DAFTAR'];
//print "...";
			//$tkh_tamat = $row['TARIKH_LUPUT'];
print  $row['SKI_KOD'];
?>