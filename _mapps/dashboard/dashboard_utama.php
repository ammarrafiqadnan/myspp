<?php
// include '../biodata/sql_biodata.php';

$maxRetries = 3;
$retryDelay = 5; // seconds
$connOra = null;
for ($retryCount = 1; $retryCount <= $maxRetries; $retryCount++) {
    //echo "Try to connect Oracle !!!!!!\n";
    $connOra = odbc_connect('oracle_dsn', 'esmsm_data', 'abc123');

    if ($connOra) {
        //echo "Connected successfully!\n";
        break; // Connection successful, exit the loop
    } else {
        //echo "Connection attempt {$retryCount} failed.\n";

        if ($retryCount < $maxRetries) {
            //echo " Retrying in {$retryDelay} seconds...\n";
            sleep($retryDelay);
        }
    }
}

$user = get_user($conn,$_SESSION['SESS_UID']);
// if($user['id_pemohon']
$data = get_biodata($conn,$_SESSION['SESS_UID']);
// print_r($data);
$rsTkh = $conn->query("SELECT * FROM $schema2.`calon_tarikh` WHERE `id_pemohon`=".tosql($_SESSION['SESS_UID']));
//$rsSejarah = $conn->query("SELECT * FROM $schema2.`calon_tarikh_sejarah` WHERE `id_pemohon`=".tosql($_SESSION['SESS_UID']));
/*
$getGambar = get_gambar($conn,$_SESSION['SESS_UID']);
if(!empty($getGambar['gambar'])){
    $gambar = "/upload/".$_SESSION['SESS_UID']."/".$getGambar['gambar'];
} else { $gambar= '../images/person.jpg'; }
*/

$rsGambar = $conn->query("SELECT * FROM $schema2.`calon_gambar` WHERE `id_pemohon`=".tosql($_SESSION['SESS_UID']));
if(!$rsGambar->EOF){
       	$sijil_pic1 = "/var/www/upload/".$_SESSION['SESS_UID']."/".$rsGambar->fields['gambar'];
} else {
       	$sijil_pic1 = '../images/person.jpg';
}

if (file_exists($sijil_pic1)){
	$b64image = base64_encode(file_get_contents($sijil_pic1));
	$gambar = "data:image/png;base64,$b64image";
}

?>
<script type="text/javascript">
function do_cetak(URL){
    document.myspp.action = URL+'&prn=OK';
    document.myspp.target = '_blank';
    document.myspp.submit();
}
</script>
<style>
table {
    display: block;
    overflow-x: auto;
}
</style>
        <div class="box" style="background-color:#F2F2F2">

            <div class="box-body">
            <input type="hidden" name="id" value="" />
            <div class="x_panel">
            <header class="panel-heading"  style="background-color:rgb(38, 167, 228)">
                <div class="panel-actions">
                <!--<a href="#" class="fa fa-caret-down"></a>
                <a href="#" class="fa fa-times"></a>-->
                </div>
                <h6 class="panel-title"><font color="#000000"><b>Dashboard</b></font></h6> 
            </header>
            </div>
            </div>
	    
            <div class="box-body" style="background-color:#F2F2F2; padding: 30px">
                <h4><b><u>Maklumat Pemohon</u></b></h4> <br> 
                <div class="form-group">
                    <div class="col-sm-9">
                        <div class="row">
                            <label for="nama" class="col-sm-4 control-label"><b>No. Kad Pengenalan<div style="float:right">:</div></b></label>
                            <div class="col-sm-8"><b><?php print strtoupper($_SESSION['SESS_UIC']);?></b></div>
                        </div>
                        <div class="row">
                            <label for="nama" class="col-sm-4 control-label"><b>Nama Penuh<div style="float:right">:</div></b></label>
                            <div class="col-sm-8"><b><?php print strtoupper($_SESSION['SESS_UNAME']);?></b></div>
                        </div>
                        <div class="row">
                            <label for="nama" class="col-sm-4 control-label"><b>Alamat Surat Menyurat<div style="float:right">:</div></b></label>
                            <div class="col-sm-8">
                                <?php //$conn->debug=true;
                                print strtoupper($data['addr1']);
                                if(!empty($data['addr2'])){ print "<br>".strtoupper($data['addr2']); }
                                if(!empty($data['addr3'])){ print "<br>".strtoupper($data['addr3']); }
                                ?>
                            </div>
                        </div>
                        <div class="row">
                            <label for="nama" class="col-sm-4 control-label"><b><div style="float:right"></div></b></label>
                            <div class="col-sm-8"><?php if(!empty($data['poskod'])){ print strtoupper($data['poskod']).',';} ?> <?php  if(!empty($data['bandar'])){ print strtoupper($data['bandar']).','; }?>
                            <?php print strtoupper(dlookup("$schema2.ref_negeri", "diskripsi", "kod=".tosql($data['negeri']))); ?></div>
                        </div>
                        
                        <div class="row">
                            <label for="nama" class="col-sm-4 control-label"><b>Emel<div style="float:right">:</div></b></label>
                            <div class="col-sm-8"><?php print $_SESSION['SESS_EMEL'];?></div>
                        </div>
                        <div class="row">
                            <label for="nama" class="col-sm-4 control-label"><b>No. Telefon<div style="float:right">:</div></b></label>
                            <div class="col-sm-4"><?php print $data['no_depan'];?>-<?php print $data['no_tel'];?></div>
                        </div>
                        <div class="row">
                            <label for="nama" class="col-sm-4 control-label"><b>Tarikh Lahir<div style="float:right">:</div></b></label>
                            <div class="col-sm-4"><?php print DisplayDate($data['dob']);?></div>
                        </div>
                        <!--<div class="row">
                            <label for="nama" class="col-sm-4 control-label"><b>Jantina<div style="float:right">:</div></b></label>
                            <div class="col-sm-4"><?php if($data['jantina']==1){ print 'LELAKI'; } else { print 'PEREMPUAN'; }?></div>
                        </div>
                        <div class="row">
                            <label for="nama" class="col-sm-4 control-label"><b>Keturunan<div style="float:right">:</div></b></label>
                            <div class="col-sm-4"><?php print dlookup("$schema1.`ref_keturunan`","keturunan","kod_keturunan=".tosql($data['keturunan']));?></div>
                        </div> 
                        <div class="row">
                            <label for="nama" class="col-sm-4 control-label"><b>Agama<div style="float:right">:</div></b></label>
                            <div class="col-sm-4"><?php print dlookup("$schema1.`ref_agama`","agama","kod_agama=".tosql($data['agama']));?></div>
                        </div>-->
                        <?php if(!empty($data['oku'])){ ?>
                        <div class="row">
                            <label for="nama" class="col-sm-4 control-label"><b>OKU<div style="float:right">:</div></b></label>
                            <div class="col-sm-4">
                                <?php print dlookup("$schema1.`ref_kecacatan_calon`","DISKRIPSI","KOD=".tosql($data['oku']));?>
                                    
                            </div>
                            <div class="col-sm-4"><b>No. OKU :</b> <?=$data['no_rujukan_oku'];?></div>
                        </div>
                        <?php } ?>
                        <?php if($data['masih_khidmat']=='Y'){ ?>
                        <div class="row">
                            <label for="nama" class="col-sm-4 control-label"><b>Status Perkhidmatan Awam<div style="float:right">:</div></b></label>
                            <label for="nama" class="col-sm-8 control-label">SEDANG BERKHIDMAT <!--<b>dengan Perkhidmatan Awam / Kerajaan Tempatan / Badan Berkanun / Polis</b>--></label>
                        </div>
                        <?php } ?>
                        <!-- 
                        <div class="row">
                            <label for="nama" class="col-sm-4 control-label"><b>Status Kewarganegaraan<div style="float:right">:</div></b></label>
                            <div class="col-sm-4"><?php print $data['warganegara'];?></div>
                        </div> -->
                    </div>
                    <div class="col-md-3">
                        <div class="col-sm-12" align="center">
                            <img src="<?=$gambar;?>" width="130" height="150">
                        </div>
                    </div>
                </div>
        <!--<label for="nama" class="col-sm-12 control-label" style="border: 1px solid rgb(38, 167, 228); text-align: justify;">
                <h4><b><u>Perakuan Pemohon</u></b></h4>

                <h5>
                    Di bawah Seksyen 5, Akta Suruhanjaya-suruhanjaya Perkhidmatan 1957 (Semakan 1989), seseorang pemohon yang memberi maklumat palsu atau mengelirukan kepada Suruhanjaya berkaitan sesuatu permohonan untuk mendapatkan pekerjaan atau pelantikan adalah melakukan kesalahan dan jika disabitkan boleh dihukum penjara selama tempoh dua (2) tahun atau denda dua ribu Ringgit Malaysia (RM2,000) atau kedua-duanya sekali. 
                </h5>
        </label>-->
                

                <?php
		//$conn->debug=true;
                $sqlJ = "SELECT * FROM $schema2.`calon_jawatan_dipohon` A, $schema1.`ref_skim` B WHERE A.`kod_jawatan`=B.`KOD`";
                $sqlJ .= " AND A.`id_pemohon`=".tosql($_SESSION['SESS_UID']);  
                $sqlJ .= " ORDER BY A.`seq_no` ASC";
                $rsJawatan1 = $conn->query($sqlJ); $bil=0;

                $bl=0; $J1=''; $J2=''; $J3=''; $Jawatan = '<font style="color:red">Tidak Lengkap. Sila semak semula maklumat diisi</font>';
                while(!$rsJawatan1->EOF){
                    if($bl==0){
                        $J1 = $rsJawatan1->fields['DISKRIPSI'];
                    } else if($bl==1){ 
                        $J2 = $rsJawatan1->fields['DISKRIPSI'];
                    } else {
                        $J3 = $rsJawatan1->fields['DISKRIPSI'];
                    }
                    $bl++; $Jawatan='Lengkap';
                    $rsJawatan1->movenext();
                }
                ?>
                <?php $href_cetakB = "modal_print.php?win=".base64_encode('cetakan/cetak_permohonan.php;'.$_SESSION['SESS_UID']); ?>
        <br>
	
        <div class="form-group">
                    <div class="col-sm-12">
                        <div class="row">

                <h4><b><u>Status Permohonan Terkini</u></b></h4><br>
		<div class="form-group">
						<div class="row">
							<div class="card">
									<label for="nama" class="col-sm-12 control-label" style="border: 1px solid rgb(38, 167, 228);"><b>NOTA : </b>
										<ul>
									<li>Jumlah permohonan jawatan terhad kepada 3 jawatan sahaja dengan tempoh sah laku pendaftaran adalah satu (1) tahun sahaja. Sila rujuk Tarikh Luput.</li> 
										<li>Rekod dan maklumat yang dipaparkan akan dikemaskini dari semasa ke semasa oleh SPP.</li>
								</ul>
									</label>

							  </div>


							
						</div>
					</div
<?php

            /*$sqlData = "SELECT  A.SKI_KOD SKI_KOD, B.DISKRIPSI DISKRIPSI, TO_CHAR(CL.TARIKH_KEMASKINI_SPP, 'DD/MM/YYYY') as TARIKH_DAFTAR, 
			case when a.tarikh_daftar > '23-SEP-2012' then TO_CHAR(ADD_MONTHS(CL.TARIKH_KEMASKINI_SPP,12)-1, 'DD/MM/YYYY') 
			else TO_CHAR(ADD_MONTHS(A.TARIKH_UBAHSUAI,12)-1, 'DD/MM/YYYY') end as tarikh_luput 
			FROM ESMSM_ADMIN.SKIM_DIPOHON A, ESMSM_ADMIN.SKIM B, ESMSM_ADMIN.DAFTAR_CALON C, ESMSM_ADMIN.CALON CL 
			WHERE A.SKI_KOD = B.KOD AND A.SAH_YT = 'Y' AND A.CAL_NO_PENGENALAN = C.NO_PENGENALAN AND A.SKI_KOD = C.SKIM 
			AND CL.NO_KP_BARU = '".$_SESSION['SESS_UIC']."' AND A.SKI_KOD not in ('1308','2756','4206','5777') AND A.CAL_NO_PENGENALAN = CL.NO_PENGENALAN  
			ORDER BY C.KEUTAMAAN, A.SKI_KOD ";
	*/
		$tkh_papar='';

	if(!empty($rsTkh->fields['tkh_upd_perakuan'])){
		$tkh_peraku=$rsTkh->fields['tkh_upd_perakuan'];
	} else { $tkh_peraku=''; }

	    $tkhkemaskini = $tkh_peraku; //$rsTkh->fields['tkh_upd_perakuan'];
            $sqlData = "SELECT TARIKH_KEMASKINI_SPP, TO_CHAR(ADD_MONTHS(TARIKH_KEMASKINI_SPP,12)-1, 'DD/MM/YYYY') AS TARIKH_LUPUT 
            FROM s_calon where no_kp_baru=".tosql($_SESSION['SESS_UIC'])." AND indicator_desc='BERSIH DAN DIDAFTAR'";
            $sqlData .= " AND TARIKH_KEMASKINI_SPP IS NOT NULL";
	    //$sqlData .= " AND TO_DATE(TO_CHAR(TARIKH_KEMASKINI_SPP,'YYYY-MM-DD' ),'YYYY-MM-DD')=TO_DATE($tkhkemaskini ,'DD-MM-YYYY') ";
	    $sqlData .= " ORDER BY TARIKH_KEMASKINI_SPP DESC";	

		//echo $sqlData;
			$data = odbc_exec($connOra,$sqlData);
			
			if($row = odbc_fetch_array( $data )){
				$tkh_daftar = $row['TARIKH_KEMASKINI_SPP'];
				$tkh_tamat = $row['TARIKH_LUPUT'];
			} else {
				$tkh_daftar='';
				$tkh_tamat='';
			}

	if($tkh_daftar==$tkh_peraku){ $tkh_papar='SAMA'; } else { $tkh_papar=''; }
	if(empty($tkh_daftar) && empty($tkh_peraku)){ $tkh_papar=''; }
	//if(!empty($tkh_peraku)){ $tkh_papar='SAMA'; } else { $tkh_papar=''; }
        if($_SESSION['SESS_UIC']=='990913026148' || $_SESSION['SESS_UIC']=='840414145982'){ print ".".$tkh_daftar.":".$tkh_peraku.":".$tkh_papar; }

?>

                <div class="form-group">
                    <div class="col-sm-12">
                        <div class="row">
                            <table width="700px" cellpadding="5" cellspacing="0" border="1" class="table">
                                <tr style="font-weight: bold;">
                                    <td width="3%" rowspan="2" align="center">Bil</td>
                                    <td width="97%" colspan="9" align="center">Tarikh dan Masa Kemaskini Maklumat</td>
                                </tr>
                                <tr style="font-weight: bold;">
                                    <td width="8%" align="center">Pemohon</td>
                                    <td width="8%" align="center">Perkhidmatan Awam</td>
                                    <td width="8%" align="center">Akademik</td>
                                    <td width="8%" align="center">Bukan Akademik</td>
                                    <td width="25%" align="center">Jawatan Dimohon</td>
                                    <td width="8%" align="center">Tarikh Perakuan & Hantar</td>
                                    <td width="10%" align="center">Cetakan Slip</td>
                                    <td width="8%" align="center">Tarikh Penerimaan</td>
                                    <td width="8%" align="center">Tarikh Luput<?//=$tkh_papar;?></td>
                                </tr>
                                <?php if(empty($tkh_papar)){ ?>
                                <tr>
                                    <td align="center">1.</td>
                                    <td align="center"><?php if(!empty($rsTkh->fields['tkh_upd_biodata'])){ print DisplayDateT($rsTkh->fields['tkh_upd_biodata']); } ?></td>
                                    <td align="center"><?php if(!empty($rsTkh->fields['tkh_upd_awam'])){ print DisplayDateT($rsTkh->fields['tkh_upd_awam']); } ?></td>
                                    <td align="center"><?php if(!empty($rsTkh->fields['tkh_upd_akademik'])){ print DisplayDateT($rsTkh->fields['tkh_upd_akademik']); } ?></td>
                                    <td align="center"><?php if(!empty($rsTkh->fields['tkh_upd_koko'])){ print DisplayDateT($rsTkh->fields['tkh_upd_koko']); } ?></td>
                                    <td align="left">
                                        <div align="center"><?php if(!empty($rsTkh->fields['tkh_upd_jawatan'])){ print DisplayDateT($rsTkh->fields['tkh_upd_jawatan']); } ?></div><br>
                                        1. <?=strtoupper($J1);?>
                                        <?php 
                                        if(!empty($J2)){ print "<br>2. ".strtoupper($J2); } 
                                        if(!empty($J3)){ print "<br>3. ".strtoupper($J3); }
                                        ?>
                                    </td>
                                    <td align="center"><?php if(!empty($rsTkh->fields['tkh_upd_perakuan'])){ print DisplayDateT($rsTkh->fields['tkh_upd_perakuan']); } ?></td>
                                    
                                        <?php if(!empty($tkh_papar)){ ?>
                                        <img src="../images/printer.png" width="25px" title="Sila klik untuk cetak maklumat" onclick="do_cetak('<?=$href_cetakB;?>')" style="cursor:pointer">
                                        <?php } else { 
						if(!empty($rsTkh->fields['tkh_upd_perakuan'])){
							print '<td align="center" colspan="1">';
					?>
					<img src="../images/printer.png" width="25px" title="Sila klik untuk cetak maklumat" onclick="do_cetak('<?=$href_cetakB;?>')" style="cursor:pointer">
					<?php 
							print '</td>';
							print '<td align="center" colspan="2">
							<font color="red">Tarikh penerimaan akan dipaparkan setelah permohonan diproses.</font></td>';
						} else {
						//print '<font color="red">Ikon cetakan akan dipaparkan setelah pemohon membuat perakuan pemohon.</font>'; 
							print '<td align="center" colspan="3">
							<font color="red">Ikon cetakan akan dipaparkan setelah pemohon membuat pengesahan.</font></td>'; 
						}
					}?>
                                    
                                    <!--<td align="center"><?php if(!empty($tkh_papar)){ print DisplayDateT($rsTkh->fields['tkh_espp']); } ?></td>
                                        <td align="center"><?php if(!empty($tkh_papar)){ print DisplayDateT($rsTkh->fields['tarikh_luput']); } ?></td>-->
                                </tr>
                                <?php $bil++; } ?>
                               <?php 
                               //if($_SESSION['SESS_UIC']=='990913026148'){ $conn->debug=true; }
		               	    $href_cetakC = "modal_print.php?win=".base64_encode('cetakan/cetak_permohonan_sej.php;'.$_SESSION['SESS_UID']); 
                                    //$conn->debug=true;
                                    $rsSejarah = $conn->query("SELECT * FROM $schema2.`calon_tarikh_sejarah` WHERE `id_pemohon`=".tosql($_SESSION['SESS_UID'])." 
					 ORDER BY tkh_espp DESC LIMIT 1"); //
                                    while(!$rsSejarah->EOF){ $bil++;
					//print $rsSejarah->fields['tkh_upd_biodata'];			
					$condition1 = "KOD='" . $rsSejarah->fields['jawatan1'] . "'";
					$condition2 = "KOD='" . $rsSejarah->fields['jawatan2'] . "'";
                			$condition3 = "KOD='" . $rsSejarah->fields['jawatan3'] . "'";
                                    ?>
                                    <tr>
                                        <td align="center"><?=$bil;?>.</td>
                                        <td align="center"><?php print DisplayDateT($rsSejarah->fields['tkh_upd_biodata']);?></td>
                                        <td align="center"><?php print DisplayDateT($rsSejarah->fields['tkh_upd_awam']);?></td>
                                        <td align="center"><?php print DisplayDateT($rsSejarah->fields['tkh_upd_akademik']);?></td>
                                        <td align="center"><?php print DisplayDateT($rsSejarah->fields['tkh_upd_koko']);?></td>
                                        <td align="left">
                                            <div align="center"><?php print DisplayDateT($rsSejarah->fields['tkh_upd_jawatan']);?></div><br>
					1. <?=strtoupper(dlookup("$schema1.`ref_skim`", "DISKRIPSI", $condition1));?>
                                                                                        <?php 
                                            if(!empty($rsSejarah->fields['jawatan2'])){ print "<br>2. ".strtoupper(dlookup("$schema1.`ref_skim`","DISKRIPSI",$condition2)); } 
                                            if(!empty($rsSejarah->fields['jawatan3'])){ print "<br>3. ".strtoupper(dlookup("$schema1.`ref_skim`","DISKRIPSI",$condition3)); }
                                            ?></td>
                                        <td align="center"><?php print DisplayDateT($rsSejarah->fields['tkh_upd_perakuan']);?></td>
                                    <td align="center">
                                        <?php if(!empty($tkh_daftar)){ ?>
                                        <img src="../images/printer.png" width="25px" title="Sila klik untuk cetak maklumat" style="cursor:pointer" 
						onclick="do_cetak('<?=$href_cetakC;?>&tkh=<?=$tkh_daftar;?>')"><?php }?>
                                    </td>
                                        <td align="center"><?php print DisplayDateT($tkh_daftar);?></td>
                                        <td align="center"><?php print $tkh_tamat;?></td>

                                    </tr>
                                    <?php $rsSejarah->movenext(); } ?>                            </table>
                        </div>
                        
                </div>
</div>
                        
                </div>
            </div>

                <!-- <div class="form-group">
                    <div class="col-md-12" style="padding: 0px;">
                        <button class="btn btn-primary"><i class="fa fa-send"></i> MOHON</button>
                    </div>
                </div> -->
                <!-- <a href="dashboard/info_form.php" id="infos" data-toggle="modal" data-target="#myModal"class="fa" data-backdrop="static">...</a> -->
            </div>
        </div>
     </div>
  </div>    
    <div class="bs-example">
        <div id="myModalInfo" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg static">
                <div class="modal-content">
                    <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading"  style="background-color:rgb(38, 167, 228)">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
                            <h6 class="panel-title"><font color="#000000" size="3"><b>PERINGATAN</b></font></h6>
                        </header>
                        <div class="panel-body">
                            <div class="box-body" align="center">
                                Sekiranya berlaku sebarang pengemaskinian di mana-mana skrin, pemohon perlu membuat perakuan dan klik butang <b>Hantar</b> semula di menu <b>"PERAKUAN PEMOHON"</b>.
                            </div><br>
                            <div align="center"><button type="button" class="btn btn-primary" data-dismiss="modal" aria-hidden="true">Tutup</button></div>
                        </div>
                    </section>
                </div>
                </div>
            </div>
        </div>
    </div>
  <script type="text/javascript">
      // document.getElementById('infos').click();
      // $('#infos').click();

    $(window).on('load', function() {
        $('#myModalInfo').modal('show');
    });
  </script>        

<?php //$connOra->close(); ?>