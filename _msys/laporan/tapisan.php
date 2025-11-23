<link href="../vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
<link href="../vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
<link href="../vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
<link href="../vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">
<script>
function do_proses(url){
	var kluster = document.myspp.kluster.value;
	if(kluster==''){
		alert("Sila pilih maklumat kluster terlebih dahulu");
	} else {
		document.myspp.action=url;		
		document.myspp.target='_self';
		document.myspp.submit();
	}
}
</script>
<!-- Select2 -->
<link rel="stylesheet" href="../plugins/select2/css/select2.min.css">
<link rel="stylesheet" href="../plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">

<?php
$m=isset($_GET["m"])?$_GET["m"]:"";

$actual_link =  str_replace("&m=1","",$actual_link);	
$_SESSION['SESSADM_BACKLINK']=$actual_link;
$_SESSION['SESS_LINKBACK']=$actual_link.'&m=1';


if($m==1){
	
	$kluster=isset($_SESSION['kluster'])?$_SESSION['kluster']:"";
	$bm=isset($_SESSION['bm'])?$_SESSION['bm']:"";
	$gred=isset($_SESSION['gred'])?$_SESSION['gred']:"";
	$umur1=isset($_SESSION['umur1'])?$_SESSION['umur1']:"";
	$umur2=isset($_SESSION['umur2'])?$_SESSION['umur2']:"";
	$cgpa1=isset($_SESSION['cgpa1'])?$_SESSION['cgpa1']:"";
	$cgpa2=isset($_SESSION['cgpa2'])?$_SESSION['cgpa2']:"";
	$bmi=isset($_SESSION['bmi'])?$_SESSION['bmi']:"";
	$oku=isset($_SESSION['oku'])?$_SESSION['oku']:"";
	

} else {

	$kluster=isset($_REQUEST["kluster"])?$_REQUEST["kluster"]:"";
	$bm=isset($_REQUEST["bm"])?$_REQUEST["bm"]:"";
	$gred=isset($_REQUEST["gred"])?$_REQUEST["gred"]:"";
	$umur1=isset($_REQUEST["umur1"])?$_REQUEST["umur1"]:"";
	$umur2=isset($_REQUEST["umur2"])?$_REQUEST["umur2"]:"";
	$cgpa1=isset($_REQUEST["cgpa1"])?$_REQUEST["cgpa1"]:"";
	$cgpa2=isset($_REQUEST["cgpa2"])?$_REQUEST["cgpa2"]:"";
	$bmi=isset($_REQUEST["bmi"])?$_REQUEST["bmi"]:"";
	$oku=isset($_REQUEST["oku"])?$_REQUEST["oku"]:"";

	$_SESSION['kluster']=$kluster;
	$_SESSION['bm']=$bm;
	$_SESSION['gred']=$gred;
	$_SESSION['umur1']=$umur1;
	$_SESSION['umur2']=$umur2;
	$_SESSION['cgpa1']=$cgpa1;
	$_SESSION['cgpa2']=$cgpa2;
	$_SESSION['bmi']=$bmi;
	$_SESSION['oku']=$oku;
}
?>

        <header class="panel-heading"  style="background-color:rgb(38, 167, 228)">
            <h6 class="panel-title"><font color="#000000" size="3"><b><?php print strtoupper($menu);?></b></font></h6>
        </header>

	<div class="box" style="background-color:#F2F2F2">
            <div class="panel-body">
                <div class="box-body">
                
                    <input type="hidden" name="kod" id="kod" value="<?php if(!empty($cgpa_kod)){ print $rs->fields['kod']; }?>"/>

                    <div class="col-md-12">

			<?php $rskluster = $conn->query("SELECT * FROM $schema1.`ref_kluster_main` WHERE is_deleted=0 AND status=0"); ?>
                        <div class="row" style="padding-bottom: 10px;">
                            <label for="tajuk" class="col-sm-2 control-label"><b>Kluster <font color="#FF0000">*</font> : </b></label>
                            <div class="col-md-9">
                                <?php
                                    //$sql3 = "SELECT * FROM $schema1.`ref_kluster` WHERE `status`=0";
                                    //$rskluster = $conn->query($sql3);
                                ?>
                                <select name="kluster" id="kluster" class="form-control select2">
                                    <option value="">Sila pilih</option>
                                    <?php while(!$rskluster->EOF){ $kluster_code = $rskluster->fields['kod']; ?>    
                                        <option value="<?=$kluster_code;?>" <?php if($kluster==$kluster_code){ print 'selected'; }?>><?php print $rskluster->fields['diskripsi'];?></option>
                                    <?php $rskluster->movenext(); } ?>
                                </select>
                            </div> 
                        </div>

                        <div class="row" style="padding-bottom: 10px;">
                            <label for="tajuk" class="col-sm-2 control-label"><b>Kriteria <font color="#FF0000">*</font> : </b></label>
                            <label for="tajuk" class="col-sm-2 control-label">Subjek BM</label>
                            <div class="col-md-2">
                                <select name="bm" class="form-control"> 
					<option value="">Sila pilih</option>
					<option value="PMR" <?php if($bm=='PMR'){ print 'selected'; }?>>PMR</option>
					<option value="SPM" <?php if($bm=='SPM'){ print 'selected'; }?>>SPM</option>
				</select>
                            </div>   
                            <div class="col-md-1"></div>   
                            <div class="col-md-1">Gred</div> 
                            <div class="col-md-2">
                                <select name="gred" class="form-control"> 
					<option value="">Sila pilih</option>
					<option value="A+" <?php if($gred=='A+'){ print 'selected'; }?>>A+</option>
					<option value="A" <?php if($gred=='A'){ print 'selected'; }?>>A</option>
					<option value="A-" <?php if($gred=='A-'){ print 'selected'; }?>>A-</option>
					<option value="B+" <?php if($gred=='B+'){ print 'selected'; }?>>B+</option>
					<option value="B" <?php if($gred=='B'){ print 'selected'; }?>>B</option>
					<option value="C+" <?php if($gred=='C+'){ print 'selected'; }?>>C+</option>
					<option value="C" <?php if($gred=='C'){ print 'selected'; }?>>C</option>
				</select>

                            </div>  
                          
                        </div>

                        <div class="row" style="padding-bottom: 10px;">
                            <label for="tajuk" class="col-sm-2 control-label"></label>
                            <label for="tajuk" class="col-sm-1 control-label">Umur</label>
                            <div class="col-md-1">
                                <input type="text" class="form-control" name="umur1" id="umur1" value="<?=$umur1;?>"> 
                            </div> 
                            <div class="col-md-1">
                                <small>hingga</small>
                                
                            </div> 
                            <div class="col-md-1">
                                <input type="text" class="form-control" name="umur2" id="umur2" value="<?=$umur2;?>">
                            </div>  
                        
			    <label for="tajuk" class="col-sm-1 control-label"></label>
                            <label for="tajuk" class="col-sm-1 control-label">CGPA</label>
                            <div class="col-md-1">
                                <input type="text" class="form-control" name="cgpa1" id="cgpa1" value="<?=$cgpa1;?>"> 
                            </div> 
                            <div class="col-md-1">
                                <small>hingga</small>
                                
                            </div> 
                            <div class="col-md-1">
                                <input type="text" class="form-control" name="cgpa2" id="cgpa2" value="<?=$cgpa2;?>">
                            </div>  
                        </div>

                        <div class="row" style="padding-bottom: 10px;">
                            <label for="tajuk" class="col-sm-2 control-label"></label>
                            <label for="tajuk" class="col-sm-1 control-label">BMI</label>
                            <div class="col-md-4">
                                <select name="bmi" class="form-control">
					<option value="">Sila pilih</option>
					<option value="1" <?php if($bmi==1){ print 'selected'; }?>>Kurang Berat Badan (Kurang dari 18.5) </option>
					<option value="2" <?php if($bmi==2){ print 'selected'; }?>>Berat Badan Unggul (18.5 - 24.9)</option>
					<option value="3" <?php if($bmi==3){ print 'selected'; }?>>Berlebihan Berat Badan (25 - 30)</option>
					<option value="4" <?php if($bmi==4){ print 'selected'; }?>>Obes Tahap 1 (30 - 34.9)</option>
					<option value="5" <?php if($bmi==5){ print 'selected'; }?>>Obes Tahap 2 (35 - 39.9)</option>
					<option value="6" <?php if($bmi==6){ print 'selected'; }?>>Obes Tahap 3 (Lebih 40)</option>
				</select> 
                            </div>
                            <label for="tajuk" class="col-sm-1 control-label"></label>
                            <label for="tajuk" class="col-sm-1 control-label">OKU</label>
                            <div class="col-md-3">
                                <select name="oku" class="form-control">
					<option value="">Sila pilih</option>
					<option value="2"<?php if($oku==2){ print 'selected'; }?>>Tidak</option>
					<option value="1"<?php if($oku==1){ print 'selected'; }?>>Ya</option>
				</select> 
                            </div>
                        </div>


                        <div class="modal-footer" style="padding:0px;">
                            <button type="button" class="btn btn-primary mt-sm mb-sm" onclick="do_proses('<?=$actual_link;?>')"><i class="fa fa-save"></i> Proses</button>
                        </div>
                    </div>

                
                </div>
            </div>
                <div class="box-body">
		<div class="col-md-12">

<?php
if($_SESSION['SESSADM_ULOG']=='700526015475' || $_SESSION['SESSADM_ULOG']=='admin'){
//$conn->debug=true;
}
if(!empty($kluster)){
$sql = "SELECT * FROM $schema1.padanan_kluster_bidang A, $schema1.padanan_bidang_pengkhususan B 
WHERE A.kod_bidang=B.kod_bidang AND A.kod_kluster=".tosql($kluster);
$sql .= " GROUP BY kod_pengkhususan ORDER BY kod_pengkhususan";

$sql ="SELECT B.kod, B.DISKRIPSI, B.`kod` AS PKOD FROM $schema1.`ref_padanan_kluster` A, $schema1.`ref_pengkhususan` B 
	WHERE A.kod_pengkhususan=B.kod AND A.is_deleted=0 AND A.kod_kluster=".tosql($kluster);
 	//AND A.kod_mpelajaran=".tosql($rs->fields['kod_mpelajaran'])." AND A.kod_bidang=".tosql($rs->fields['kod_bidang']);

$sql ="SELECT A.kod_pengkhususan FROM $schema1.`ref_padanan_kluster` A 
	WHERE A.is_deleted=0 AND A.kod_kluster=".tosql($kluster);
 	//AND A.kod_mpelajaran=".tosql($rs->fields['kod_mpelajaran'])." AND A.kod_bidang=".tosql($rs->fields['kod_bidang']);

$rs = $conn->query($sql);
$bil=0; $strkod="'XXXX'";
while(!$rs->EOF){
	//print "<br>".$rs->fields['kod_pengkhususan'];
	if($bil==0){
		$strkod="'".$rs->fields['kod_pengkhususan']."'";
	} else {
		$strkod.=",'".$rs->fields['kod_pengkhususan']."'";
	}
	$bil++;
	$rs->movenext();
}

//print $strkod;



if($bm=='PMR'){
	$sqlt = ", $schema2.calon_srp C ";
	$sqlbm = " AND C.id_pemohon=B.id_pemohon AND C.matapelajaran='002' AND C.gred>=".tosql($gred);
} else if($bm=='SPM'){
	$sqlt = ", $schema2.calon_spm C ";
	$sqlbm = " AND C.id_pemohon=B.id_pemohon AND C.matapelajaran='103' AND C.gred>=".tosql($gred);

}

$sql = "SELECT A.id_pemohon,A.nama_penuh, A.ICNo,A.d_cipta,A.d_kemaskini,A.pengakuan, A.status_pemohon, B.diskripsi2 
        FROM $schema2.calon A, $schema2.ref_negeri B, $schema2.senarai_panggilan_temuduga C, $schema2.panggilan_temuduga D, $schema2.calon_jawatan_dipohon E
        WHERE A.negeri=B.kod AND (A.d_kemaskini >=".tosql($dby)." OR A.d_cipta >=".tosql($dby).") AND A.ICNo=C.noKP AND A.id_pemohon=E.id_pemohon";
        $sql .= " AND A.pengakuan='Y' AND C.kod_panggilan_temuduga=D.kod  AND C.is_deleted=0";

$sql = "SELECT B.*, Z.diskripsi2 FROM $schema2.calon_ipt A, $schema2.calon B, $schema2.ref_negeri Z $sqlt 
	WHERE A.id_pemohon=B.id_pemohon $sqlbm";
$sql .= " AND B.negeri=Z.kod AND B.pengakuan='Y'";

if(!empty($strkod)){ $sql .=" AND A.pengkhususan IN ($strkod) "; }
if(!empty($umur1) && !empty($umur2)){
	$sql .= " AND B.umur BETWEEN $umur1 AND $umur2 ";
} else if(!empty($umur1) && empty($umur2)){
	$sql .= " AND B.umur >= $umur1";
	//$sql .= " AND B.umur = $umur1";
}
if(!empty($cgpa1) && !empty($cgpa2)){
	$sql .= " AND A.cgpa BETWEEN $cgpa1 AND $cgpa2 ";
} else if(!empty($cgpa1) && empty($cgpa2)){
	$sql .= " AND A.cgpa>= $cgpa1 ";
	//$sql .= " AND A.cgpa= $cgpa1 ";
}

if(!empty($bmi)){
	if($bmi==1){
		$sql .= " AND B.bmi <=18.5 ";
	} else if($bmi==2){
		$sql .= " AND B.bmi BETWEEN 18.5 AND 24.99 ";
	} else if($bmi==3){
		$sql .= " AND B.bmi BETWEEN 25.0 AND 29.99 ";
	} else if($bmi==3){
		$sql .= " AND B.bmi BETWEEN 30.0 AND 34.99 ";
	} else if($bmi==4){
		$sql .= " AND B.bmi BETWEEN 35.0 AND 39.99 ";
	} else if($bmi==5){
		$sql .= " AND B.bmi >=40 ";
	}
}

if(!empty($oku)){
	if($oku==2){
		$sql .= " AND B.oku IS NULL ";
	} else if($oku==1){
		$sql .= " AND B.oku IS NOT NULL ";
	}
}


//$conn->debug=true;
//$rs = $conn->query($sql);

/*
while(!$rsData->EOF){
	print "<br>".$rsData->fields['nama_penuh'].":".$rsData->fields['ICNo'];
	$bil++;
	$rsData->movenext();
}
*/
//}
//$conn->debug=true;
        include '../include/list_head.php';
        include '../include/page_list.php';

?>

   <div class="box-body" style="background-color:#F2F2F2">
        <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
            <thead  style="background-color:rgb(38, 167, 228)">
                <th width="5%"><font color="#000000"><div align="center">Bil</div></font></th>
                <th width="28%" id="namaPemohon" name="namaPemohon">
                    <font color="#000000">
                        <div align="center">Nama Pemohon/Daftar/Kemaskini</div>
                    </font>
                </th>
                <th width="10%">
                    <font color="#000000">
                        <div align="center">No. Kad Pengenalan</div>
                    </font>
                </th>
                <th width="10%">
                    <font color="#000000">
                        <div align="center">Negeri</div>
                    </font>
                </th>
                <th width="25%"><font color="#000000"><div align="center">Skim Jawatan</div></font></th>
                <th width="13%">
                    <font color="#000000">
                        <div align="center">Status</div>
                    </font>
                </th>
                <th width="10%" class="d-print-none"><font color="#000000"><div align="center">Tindakan</div></font></th>
            </thead>
            <tbody>
        
            <?php 
                $cnt = 0;
			    $bil = 0; 
                
                //if(($rs1->fields['total']) > 0){
				if(!$rs->EOF){
                    while(!$rs->EOF){ $bil2=0; 
                        $bil = $cnt + ($PageNo-1)*$PageSize; ?>	
                        <?php 
                            // $conn->debug=true;
                            $sql = "SELECT C.DISKRIPSI, C.KOD, A.id_pemohon, A.kod_jawatan FROM $schema2.calon_jawatan_dipohon A, $schema1.ref_skim C  WHERE A.kod_jawatan=C.KOD AND A.id_pemohon=".tosql($rs->fields['id_pemohon']);

                            

                            $sql .= " ORDER BY A.seq_no ASC";

                            $rsJawatan = $conn->query($sql);

                            $conn->debug=false;
                            $sqlPTemuduga = "SELECT B.kod, B.tajuk FROM $schema2.senarai_panggilan_temuduga A, $schema2.panggilan_temuduga B WHERE A.noKP=".tosql($rs->fields['ICNo']). " AND A.kod_panggilan_temuduga=B.kod";

                            $rsPanggilanTemuduga = $conn->query($sqlPTemuduga);

                            $sqlKTemuduga = "SELECT B.kod, B.tajuk FROM $schema2.senarai_keputusan_temuduga A, $schema2.keputusan_temuduga B WHERE A.noKP=".tosql($rs->fields['ICNo']). " AND A.kod_keputusan_temuduga=B.kod";

                            $rsKeputusanTemuduga = $conn->query($sqlKTemuduga);
                            // $conn->debug=false;
                        ?>
                        <tr>
                            <td align="center"><?=++$bil;?></td>
                            <td align="left">
                                <?=$rs->fields['nama_penuh']?> <br><br>
                                Daftar &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <?=DisplayDate($rs->fields['d_cipta']);  print '&nbsp;&nbsp;('.DisplayMasa($rs->fields['d_cipta']).')';?><br>
                                Kemas Kini : <?=DisplayDate($rs->fields['d_kemaskini']);  print '&nbsp;&nbsp;('.DisplayMasa($rs->fields['d_kemaskini']).')';?>
                            </td>
                            <td align="center"><?=$rs->fields['ICNo']?></td>
                            <td align="center"><?=$rs->fields['diskripsi2']?></td>
                            <td>
                                <?php  while(!$rsJawatan->EOF){ 
                                    print ++$bil2.'. '.$rsJawatan->fields['DISKRIPSI'].'<br>';
                                $rsJawatan->movenext(); } ?>
                            </td>
                            <td align="center">
                                <?php if($rs->fields['pengakuan'] == 'Y' && $rs->fields['status_pemohon'] == 'Y'){ ?>
                                    <span class="badge" style="background-color: green;">Hantar</span><br><br>
                                    <?php if(!$rsPanggilanTemuduga->EOF){ 
                                        print 'Panggilan Temu Duga : <a href="index.php?data='.base64_encode('muatnaikExcel/senarai_pemohon_panggilan_temuduga;PENGURUSAN;Senarai Panggilan Temu Duga;;;'.$rsPanggilanTemuduga->fields['kod']).'&carian='.$rs->fields['ICNo'].'">'.$rsPanggilanTemuduga->fields['tajuk'].'</a>';

                                        if(!$rsKeputusanTemuduga->EOF){ 
                                            print '<br><br>';
                                        }
                                    }

                                    if(!$rsKeputusanTemuduga->EOF){ 
                                        print 'Keputusan Temu Duga : <a href="index.php?data='.base64_encode('muatnaikExcel/senarai_pemohon_keputusan_temuduga;PENGURUSAN;Senarai Keputusan Temu Duga;;;'.$rsKeputusanTemuduga->fields['kod']).'&carian='.$rs->fields['ICNo'].'">'.$rsKeputusanTemuduga->fields['tajuk'].'</a>';
                                    }
                                    ?>

                                <?php } else { ?>
                                    <span class="badge" style="background-color: #ed9c28;">Draf</span>
                                <?php } ?>


                            </td>
                            <td align="center" class="d-print-none">
                                <a href="index.php?data=<?php print base64_encode('pemohon/maklumat_pemohon;Senarai Pemohon;Nama: '.$rs->fields['nama_penuh'].' (No.K/P: '.$rs->fields['ICNo'].');;;;'); ?>&id_pemohon=<?=$rs->fields['id_pemohon']?>">
                                    <button type="button" class="btn btn-sm btn-success">
                                        <span style="cursor:pointer;color:red" title="Maklumat Terperinci Pemohon">
                                            <i class="fa fa-search" style="color: #FFFFFF;"></i>
                                        </span>
                                    </button>
                                </a>
                                <button type="button" class="btn btn-sm btn-info" onclick="do_print('cetak.php?pages=pemohon/dokumen_print_all&prn=&id_pemohon=<?=$rs->fields['id_pemohon'];?>&filename=semua_dokumen_pemohon')">
                                    <span style="cursor:pointer;" title="Cetak Semua Dokumen Pemohon">
                                        <i class="fa fa-print" style="color: #FFFFFF;"></i>
                                    </span>
                                </button>
                            </td>
                        </tr>
                    <?php 
                    $cnt = $cnt + 1;
                    $rs->movenext(); } 
                } else { ?>
                    <tr>
                        <td colspan="7" align="center">Tiada rekod dijumpai</td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <div class="card-footer">
        <?php 
            $href_f=$actual_link."&table_search=".$table_search;
            include 'include/list_footer.php'; 
        ?>  
    </div>
    </div>
</div>
<?php
} 
?>

	</div>
     </div>
  </div>  

<script>
    $(function () {
        //Initialize Select2 Elements
        $('.select2').select2();
        //Initialize Select2 Elements
        $('.select2bs4').select2({
            theme: 'bootstrap4',
            maximumSelectionLength: 25,

            language: {
                // You can find all of the options in the language files provided in the
                // build. They all must be functions that return the string that should be
                // displayed.
                maximumSelected: function (e) {
                    var t = "PERHATIAN ! Telah Mencapai Had Maksimum Negeri";
                    // + e.maximum + " item";
                    e.maximum != 1;
                    return t;
                    // return t + ' - Upgrade Now and Select More';
                }
            }
            
        });
    });
</script>
<script src="../plugins/jquery/jquery.min.js"></script>
<script src="../plugins/select2/js/select2.full.min.js"></script>

          