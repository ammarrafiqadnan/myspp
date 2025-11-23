<?php
// include '../biodata/sql_biodata.php';
$user = get_user($conn,$_SESSION['SESS_UID']);
// if($user['id_pemohon']
$data = get_biodata($conn,$_SESSION['SESS_UID']);
// print_r($data);
$rsTkh = $conn->query("SELECT * FROM $schema2.`calon_tarikh` WHERE `id_pemohon`=".tosql($_SESSION['SESS_UID']));
$rsSejarah = $conn->query("SELECT * FROM $schema2.`calon_tarikh_sejarah` WHERE `id_pemohon`=".tosql($_SESSION['SESS_UID']));

$getGambar = get_gambar($conn,$_SESSION['SESS_UID']);
if(!empty($getGambar['gambar'])){
    $gambar = "../uploads_doc/".$_SESSION['SESS_UID']."/".$getGambar['gambar'];
} else { $gambar= '../images/person.jpg'; }

?>


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
                <h4>Maklumat Pemohon</h4>
                <div class="form-group">
                    <div class="col-sm-9">
                        <div class="row">
                            <label for="nama" class="col-sm-4 control-label"><b>MyID (No. Kad Pengenalan)<div style="float:right">:</div></b></label>
                            <div class="col-sm-8"><b><?php print $_SESSION['SESS_UIC'];?></b></div>
                        </div>
                        <div class="row">
                            <label for="nama" class="col-sm-4 control-label"><b>Nama Penuh<div style="float:right">:</div></b></label>
                            <div class="col-sm-8"><b><?php print $_SESSION['SESS_UNAME'];?></b></div>
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
                            <div class="col-sm-8"><?php print $data['poskod'];?>, <?php print $data['bandar']; ?>, 
                            <?php print dlookup("$schema2.ref_negeri", "diskripsi", "kod=".tosql($data['negeri'])); ?></div>
                        </div>
                        
                        <div class="row">
                            <label for="nama" class="col-sm-4 control-label"><b>E-mel<div style="float:right">:</div></b></label>
                            <div class="col-sm-8"><?php print $_SESSION['SESS_EMEL'];?></div>
                        </div>
                        <div class="row">
                            <label for="nama" class="col-sm-4 control-label"><b>No. Telefon<div style="float:right">:</div></b></label>
                            <div class="col-sm-4"><?php print $_SESSION['SESS_NOTEL'];?></div>
                        </div>
                        <div class="row">
                            <label for="nama" class="col-sm-4 control-label"><b>Tarikh Lahir<div style="float:right">:</div></b></label>
                            <div class="col-sm-4"><?php print DisplayDate($data['dob']);?></div>
                        </div>
                        <div class="row">
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
                        </div>
                        <?php if(!empty($data['oku'])){ ?>
                        <div class="row">
                            <label for="nama" class="col-sm-4 control-label"><b>OKU<div style="float:right">:</div></b></label>
                            <div class="col-sm-4">
                                <?php print dlookup("$schema1.`ref_kecacatan_calon`","DISKRIPSI","KOD=".tosql($data['oku']));?>
                                    
                            </div>
                            <div class="col-sm-4">No. OKU : <?=$data['no_rujukan_oku'];?></div>
                        </div>
                        <?php } ?>
                        <?php if($data['masih_khidmat']=='Y'){ ?>
                        <div class="row">
                            <label for="nama" class="col-sm-4 control-label"><b>Status Perkhidmatan Awam<div style="float:right">:</div></b></label>
                            <label for="nama" class="col-sm-8 control-label"><b>Sedang berkhidmat dengan Perkhidmatan Awam / Kerajaan Tempatan / Badan Berkanun / Polis</b></label>
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
                <h4>Perakuan Pemohon</h4>
                <h5>
                    Di bawah Seksyen 5, Akta Suruhanjaya-suruhanjaya Perkhidmatan 1957 (Semakan 1989), seseorang pemohon yang memberi maklumat palsu atau mengelirukan kepada Suruhanjaya berkaitan sesuatu permohonan untuk mendapatkan pekerjaan atau pelantikan adalah melakukan kesalahan dan jika disabitkan boleh dihukum penjara selama tempoh dua (2) tahun atau denda dua ribu Ringgit Malaysia (RM2,000) atau kedua-duanya sekali. 
                </h5>
                <br>
                <?php
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
                <h4>Sejarah Permohonan</h4>
                <div class="form-group">
                    <div class="col-sm-12">
                        <div class="row">
                            <table width="100%" cellpadding="5" cellspacing="0" border="1" class="table">
                                <tr style="font-weight: bold;">
                                    <td width="3%" rowspan="2" align="center">Bil</td>
                                    <td width="97%" colspan="8" align="center">Tarikh Kemaskini Maklumat</td>
                                </tr>
                                <tr style="font-weight: bold;">
                                    <td width="10%" align="center">Permohonan</td>
                                    <td width="10%" align="center">Akademik</td>
                                    <td width="10%" align="center">Ko-Kurikulum</td>
                                    <td width="10%" align="center">Perkhidmatan Awam</td>
                                    <td width="10%" align="center">Tambahan</td>
                                    <td width="10%" align="center">Jawatan Dipohon</td>
                                    <td width="10%" align="center">Perakuan</td>
                                    <td width="10%" align="center">Penghantaran</td>
                                    <td width="2%" align="center"></td>
                                </tr>

                                <tr>
                                    <td align="center">1.</td>
                                    <td align="center"><?php print DisplayDateT($rsTkh->fields['tkh_upd_biodata']);?></td>
                                    <td align="center"><?php print DisplayDateT($rsTkh->fields['tkh_upd_akademik']);?></td>
                                    <td align="center"><?php print DisplayDateT($rsTkh->fields['tkh_upd_koko']);?></td>
                                    <td align="center"><?php print DisplayDateT($rsTkh->fields['tkh_upd_awam']);?></td>
                                    <td align="center"><?php print DisplayDateT($rsTkh->fields['tkh_upd_tambahan']);?></td>
                                    <td align="left">
                                        1. <?=$J1;?>
                                        <?php 
                                        if(!empty($J2)){ print "<br>2. ".$J2; } 
                                        if(!empty($J3)){ print "<br>3. ".$J3; }
                                        ?>
                                    </td>
                                    <td align="center"><?php print DisplayDateT($rsTkh->fields['tkh_upd_perakuan']);?></td>
                                    <td align="center"><?php print DisplayDateT($rsTkh->fields['tarikh_akuan']);?></td>
                                    <td align="center"><img src="../images/printer.png" width="25px" title="Sila klik untuk cetak maklumat" ></td>
                                </tr>

                                <?php while(!$rsSejarah->EOF){ $bil++;?>
                                <tr>
                                    <td align="center"><?=$bil;?>.</td>
                                    <td align="center"><?php print DisplayDateT($rsSejarah->fields['tkh_upd_biodata']);?></td>
                                    <td align="center"><?php print DisplayDateT($rsSejarah->fields['tkh_upd_akademik']);?></td>
                                    <td align="center"><?php print DisplayDateT($rsSejarah->fields['tkh_upd_koko']);?></td>
                                    <td align="center"><?php print DisplayDateT($rsSejarah->fields['tkh_upd_awam']);?></td>
                                    <td align="center"><?php print DisplayDateT($rsSejarah->fields['tkh_upd_tambahan']);?></td>
                                    <td align="center"><?php print DisplayDateT($rsSejarah->fields['tkh_upd_jawatan']);?></td>
                                    <td align="center"><?php print DisplayDateT($rsSejarah->fields['tkh_upd_perakuan']);?></td>
                                    <td align="center"><?php print DisplayDateT($rsSejarah->fields['tarikh_akuan']);?></td>
                                </tr>
                                <?php $rsSejarah->movenext(); } ?>
                            </table>
                        </div>
                        
                </div>
                <!-- <div class="form-group">
                    <div class="col-md-12" style="padding: 0px;">
                        <button class="btn btn-primary"><i class="fa fa-send"></i> MOHON</button>
                    </div>
                </div> -->
            </div>
		</div>
     </div>
  </div>    

          