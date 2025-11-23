<?php
    //$conn->debug=true;
    $id_pemohon=isset($_REQUEST["id_pemohon"])?$_REQUEST["id_pemohon"]:"";
    include 'pemohon/maklumat/sql_maklumat.php'; 
    include 'pemohon/akademik/sql_akademik.php';
    include 'pemohon/sql_pemohon.php';

    $data = get_all($conn,$id_pemohon);
    $rsMYID = get_myid($conn, $id_pemohon);
    $rsCalon = get_calon($conn, $id_pemohon);
    $rsTarikh = get_tarikh($conn, $id_pemohon);
    //print_r($rsCalon);
    //print $rsMYID;

	$rsUnivLengkap = $conn->query("SELECT COUNT(*) as total FROM $schema2.`calon_ipt` WHERE `bil_keputusan`='1' AND `id_pemohon`=".tosql($id_pemohon));


?>

<?php 
    $lengkap="";
    //print_r($data_biodata);
    $icon_tick = '../images/icon_green.png';
    $icon_no = '../images/icon_red.png';
    $icon_info = '../images/Button-Info-icon.png';

	$sql = "SELECT id_pemohon, spm_tahun_1, spm_jenis_sijil_1, spm_pangkat_1, spm_tahun_2, spm_jenis_sijil_2, spm_pangkat_2, spm_lisan_1, 
	stp_tahun_1, stp_jenis_1, stp_pangkat_1, stp_tahun_2, stp_jenis_2, stp_pangkat_2,   
	stam_tahun_1, stam_jenis_1, stam_pangkat_1, stam_tahun_2, stam_jenis_2, stam_pangkat_2, masih_khidmat    
	FROM $schema2.calon WHERE `id_pemohon`=".tosql($data->fields['id_pemohon']);
	$data_spm = $conn->query($sql);
$SPR_lengkap=''; $SPR_lengkap_ikon='';
if(empty($data_spm->fields['spm_tahun_1'])){ 
	$SPM_lengkap='Tiada Maklumat, Lengkapkan sekiranya perlu'; 
	$SPM_lengkap_ikon=$icon_info;
} else {
	// KENA CHECK BY TAHUN
	if(empty($data_spm->fields['spm_jenis_sijil_1']) || empty($data_spm->fields['spm_tahun_1'])){ 
		$SPM_lengkap='style="background-color:red"'; 
		$SPM_lengkap_ikon=$icon_no; 
		$btn_ok='';
	} else {
		$SPM_lengkap='style="background-color:#fff"';
		$SPM_lengkap_ikon=$icon_tick;
	}
}
if($SPM_lengkap=='Lengkap'){ 
	if(!empty($data_spm->fields['spm_jenis_sijil_1']) && $data_spm->fields['spm_jenis_sijil_1']==5){
	$rsSijil = $conn->query("SELECT * FROM $schema2.`calon_sijil` WHERE `jenis_sijil`='SVM1' AND `id_pemohon`=".tosql($data->fields['id_pemohon']));
	if(empty($rsSijil->fields['sijil_nama'])){
		$SPM_lengkap='style="background-color:red"'; 
		$SPM_lengkap_ikon=$icon_no; 
		$btn_ok='';
	}

	} else if(!empty($data_spm->fields['spm_jenis_sijil_1']) && $data_spm->fields['spm_jenis_sijil_1']<>5){
	$rsSijil = $conn->query("SELECT * FROM $schema2.`calon_sijil` WHERE `jenis_sijil`='SPM1' AND `id_pemohon`=".tosql($data->fields['id_pemohon']));
	if(empty($rsSijil->fields['sijil_nama'])){
		$SPM_lengkap='style="background-color:red"'; 
		$SPM_lengkap_ikon=$icon_no; 
		$btn_ok='';
	}
	}

	if(!empty($data_spm->fields['spm_jenis_sijil_2']) && $data_spm->fields['spm_jenis_sijil_2']==5){
	$rsSijil = $conn->query("SELECT * FROM $schema2.`calon_sijil` WHERE `jenis_sijil`='SVM2' AND `id_pemohon`=".tosql($data->fields['id_pemohon']));
	if(empty($rsSijil->fields['sijil_nama'])){
		$SPM_lengkap='style="background-color:red"'; 
		$SPM_lengkap_ikon=$icon_no; 
		$btn_ok='';
	}

	} else if(!empty($data_spm->fields['spm_jenis_sijil_2']) && $data_spm->fields['spm_jenis_sijil_2']<>5){
	$rsSijil = $conn->query("SELECT * FROM $schema2.`calon_sijil` WHERE `jenis_sijil`='SPM2' AND `id_pemohon`=".tosql($data->fields['id_pemohon']));
	if(empty($rsSijil->fields['sijil_nama'])){
		$SPM_lengkap='style="background-color:red"'; 
		$SPM_lengkap_ikon=$icon_no; 
		$btn_ok='';
	}
	}
} 

//$conn->debug=true;

$rsSPMtambahan = $conn->query("SELECT COUNT(*) as total FROM $schema2.`calon_spm` WHERE `jenis_xm`='T' AND `id_pemohon`=".tosql($data->fields['id_pemohon']). " LIMIT 1");
						
//$conn->debug=false;

//print $rsSPMtambahan->fields['total'];
    
    ?>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script language="javascript" type="text/javascript">
function popitup(url) {
newwindow=window.open(url,'name','height=700,width=900,toolbar=no,menubar=no,location=no,resizable=no,scrollbars=no');
//if (window.focus) {newwindow.focus()}
if (window.focus) {newwindow.focus();}
return false;
}
</script>
<header class="panel-heading"  style="background-color:rgb(38, 167, 228)">
    <h6 class="panel-title"><font color="#000000" size="3"><b><?php print strtoupper($menu);?></b></font></h6>
</header>
<div class="panel-body">
    <div class="box-body">

    <input type="hidden" name="pemantauan_id" id="pemantauan_id" value="<?php print $id;?>" readonly="readonly"/>

        <div class="col-md-12">

            <div class="row">
                <div class="col-md-12">
                    <div class="tab" role="tabpanel">
			<div style="color:blue">Tarikh Hantar : <?=DisplayDate($rsCalon->fields['tarikh_akuan']);  print '&nbsp;&nbsp;('.DisplayMasa($rsCalon->fields['tarikh_akuan']).')';?></div>

                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active"><a href="#Section1" aria-controls="home" role="tab" data-toggle="tab">
                                <b>Pemohon</b></a>
                            </li>
			    <?php if($data_spm->fields['masih_khidmat']=='Y'){ ?>
                            <li role="presentation"><a href="#Section4" aria-controls="profile" role="tab" data-toggle="tab">
                                <b>Maklumat Perkhidmatan</b></a>
                            </li>
			    <?php } ?>
                            <li role="presentation"><a href="#Section20" aria-controls="profile" role="tab" data-toggle="tab">
                                <b>Maklumat Akademik</b></a>
                            </li>
                            <li role="presentation"><a href="#Section3" aria-controls="home" role="tab" data-toggle="tab">
                                <b>Maklumat Bukan Akademik</b></a>
                            </li>
                            <li role="presentation"><a href="#Section6" aria-controls="profile" role="tab" data-toggle="tab">
                                <b>Jawatan Dimohon</b></a>
                            </li>
                            <li role="presentation"><a href="#Section7" aria-controls="profile" role="tab" data-toggle="tab">
                                <b>Dokumen</b></a>
                            </li>
                            <li role="presentation"><a href="#Section9" aria-controls="profile" role="tab" data-toggle="tab">
                                <b>Senarai Semak</b></a>
                            </li>
                            <!--<li role="presentation"><a href="#Section8" aria-controls="profile" role="tab" data-toggle="tab">
                                <b>Auditrail</b></a>
                            </li>-->
                        </ul>
                        <!-- Tab panes -->
                        <div class="tab-content tabs">
                            <div role="tabpanel" class="tab-pane fade in active" id="Section1">
                                <div class="tab" role="tabpanel">
                                    <!-- Sub Nav tabs Pemohon -->
                                    <ul class="nav nav-tabs" role="tablist">
                                        <!-- <li role="presentation"><a href="#Section11" aria-controls="home" role="tab" data-toggle="tab">
                                            <b>MyID</b></a>
                                        </li> -->
                                        <li role="presentation" class="active"><a href="#Section12" aria-controls="profile" role="tab" data-toggle="tab">
                                            <b>Calon</b></a>
                                        </li>
                                        <li role="presentation"><a href="#Section13" aria-controls="profile" role="tab" data-toggle="tab">
                                            <b>MyIdentity</b></a>
                                        </li>
                                    </ul>

                                    <div class="tab-content tabs">
                                        <!-- <div role="tabpanel" class="tab-pane fade in " id="Section11">
                                            <?php include 'pemohon/maklumat/myID.php'; ?>
                                        </div> -->
                                        <div role="tabpanel" class="tab-pane fade in active" id="Section12">
                                            <?php include 'pemohon/maklumat/calon.php'; ?>
                                        </div>
                                        <div role="tabpanel" class="tab-pane fade in" id="Section13">
                                            <?php include 'pemohon/maklumat/myIdentity.php'; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

			<?php if($data_spm->fields['masih_khidmat']=='Y'){ ?>
                            <div role="tabpanel" class="tab-pane fade" id="Section4">
                                <?php include 'pemohon/perkhidmatan/perkhidmatan.php'; ?>
                            </div>
			<?php } ?>

			    <div role="tabpanel" class="tab-pane fade in" id="Section3">
                                <div class="tab" role="tabpanel">
                                    <!-- Sub Nav tabs Pemohon -->
                                    <ul class="nav nav-tabs" role="tablist">
                                        <?php
                                            $rsDataSukan = $conn->query("SELECT * FROM $schema2.`calon_ko_sukan` WHERE `id_pemohon`=".tosql($data->fields['id_pemohon']));
                                        ?>
                                        <li role="presentation" class="active"><a href="#Section31" aria-controls="home" role="tab" data-toggle="tab" <?php if(empty($rsDataSukan->fields['sukan'])){ print 'style="background-color: #ffff0047;"';} ?>>
                                            <b>Sukan/ <br> Persatuan</b></a>
                                        </li>
                                        <?php
                                            $rsDataReka = $conn->query("SELECT * FROM $schema2.`calon_ko_rekacipta` WHERE `id_pemohon`=".tosql($data->fields['id_pemohon']));
                                        ?>
                                        <li role="presentation"><a href="#Section32" aria-controls="profile" role="tab" data-toggle="tab" <?php if(empty($rsDataReka->fields['rekacipta'])){ print 'style="background-color: #ffff0047;"';} ?>>
                                            <b>Rekacipta/ <br>Pencapaian</b></a>
                                        </li>
                                        <?php
                                            $rsDatabkt = $conn->query("SELECT * FROM $schema2.`calon_bakat_bahasa` WHERE `id_pemohon`=".tosql($data->fields['id_pemohon']));
                                        ?>
                                        <li role="presentation"><a href="#Section41" aria-controls="home" role="tab" data-toggle="tab" <?php if(empty($rsDatabkt->fields['bakat_bahasa'])){ print 'style="background-color: #ffff0047;"';} ?>>
                                            <b>Bakat/ <br>Kebolehan/ Bahasa</b></a>
                                        </li>
                                        <?php
                                            $rsDataBT = $conn->query("SELECT * FROM $schema2.`calon_polis_ban_oku` WHERE `id_pemohon`=".tosql($data->fields['id_pemohon']));
                                        ?>
                                        <li role="presentation"><a href="#Section42" aria-controls="profile" role="tab" data-toggle="tab" <?php if(empty($rsDataBT->fields['kategori'])){ print 'style="background-color: #ffff0047;"';} ?>>
                                            <b>Bekas Tentera/ <br>Polis</b></a>
                                        </li>
                                        <!-- <li role="presentation"><a href="#Section43" aria-controls="profile" role="tab" data-toggle="tab">
                                            <b>Penerima Bantuan/ <br>Kurang Upaya</b></a>
                                        </li> -->
                                    </ul>

                                    <div class="tab-content tabs">
                                        <div role="tabpanel" class="tab-pane fade in active" id="Section31">
                                            <?php include 'pemohon/kokurikulum/sukan.php'; ?>
                                        </div>
                                        <div role="tabpanel" class="tab-pane fade in" id="Section32">
                                            <?php include 'pemohon/kokurikulum/pencapaian.php'; ?>

                                        </div>
                                        <div role="tabpanel" class="tab-pane fade in" id="Section41">
                                            <?php include 'pemohon/tambahan/bakat.php'; ?>
                                        </div>
                                        <div role="tabpanel" class="tab-pane fade in" id="Section42">
                                            <?php include 'pemohon/tambahan/bekasTenteraPolis.php'; ?>
                                        </div>
                                        <div role="tabpanel" class="tab-pane fade in" id="Section43">
                                            <?php include 'pemohon/tambahan/penerimaBantuanOKU.php'; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane fade" id="Section6">
                                <?php include 'pemohon/jawatan/jawatan.php'; ?>
                            </div>
                            <div role="tabpanel" class="tab-pane fade" id="Section7">
                                <?php include 'pemohon/dokumen.php'; ?>
                            </div>
                            <div role="tabpanel" class="tab-pane fade" id="Section8">
                                <?php include 'pemohon/auditrail.php'; ?>
                            </div>
                            <div role="tabpanel" class="tab-pane fade" id="Section9">
                                <?php include 'pemohon/senarai_semak.php'; ?>
                            </div>
                            <div role="tabpanel" class="tab-pane fade" id="Section20">
                                <div class="tab" role="tabpanel">
                                    <!-- Sub Nav tabs Pemohon -->
                                    <ul class="nav nav-tabs" role="tablist">
					
                                        
                                        <li role="presentation" class="active">
                                            <a href="#Section21" aria-controls="home" role="tab" data-toggle="tab" <?php if($data->fields['srp_tahun'] == ''){ print 'style="background-color: #ffff0047;"';} ?>>
                                            
                                            <b <?php if($SPR_lengkap != 'Lengkap') {print 'style="color: #000;"';} ?>>SRP/PMR/PT3</b></a>
                                        </li>
                                        <?php //}
                                        //if($SPM_lengkap == 'Lengkap'){ ?>
                                        <li role="presentation" class=""><a href="#Section22" aria-controls="home" role="tab" data-toggle="tab" <?php print $SPM_lengkap;?> <?php if($data->fields['spm_tahun_1'] == ''){ print 'style="background-color: #ffff0047;"';} ?>>
                                            <b>SPM/SPM(V)/SVM</b></a>
                                        </li>
                                        <?php //}
                                        //if($SPM_tambahan == 'Lengkap'){ 
						
					?>
                                        <li role="presentation"><a href="#Section23" aria-controls="profile" role="tab" data-toggle="tab" <?php
    						if($rsSPMtambahan->fields['total'] == 0){ print 'style="background-color: #ffff0047;"';} ?>>
                                            <b <?php //if($SPM_tambahan != 'Lengkap'){ print 'style="color: red;"';} ?>>Peperiksaan SPM Ulangan<?=$rsSPMtambahan->fields['tahun'];?></b></a>
                                        </li>
                                        <li role="presentation"><a href="#Section24" aria-controls="home" role="tab" data-toggle="tab" <?php if($data->fields['stp_tahun_1'] == ''){ print 'style="background-color: #ffff0047;"';} ?>>
                                            <b>STPM</b></a>
                                        </li>
                                        <li role="presentation"><a href="#Section25" aria-controls="profile" role="tab" data-toggle="tab" <?php if($data->fields['stam_tahun_1'] == ''){ print 'style="background-color: #ffff0047;"';} ?>>
                                            <b>STAM</b></a>
                                        </li> 
                                        <?php //} 
                                        //if($UNIV_lengkap == 'Lengkap'){ ?>
                                        <li role="presentation"><a href="#Section26" aria-controls="home" role="tab" data-toggle="tab" <?php if($rsUnivLengkap->fields['total']  == '0'){ print 'style="background-color: #ffff0047;"';} ?>>
                                            <b <?php //if($UNIV_lengkap != 'Lengkap'){print 'style="color: red;"';} ?>>Pengajian Tinggi</b></a>
                                        </li>
                                        <?php //}
                                         //if($PRO_lengkap == 'Lengkap'){ ?>
                                        <li role="presentation"><a href="#Section30" aria-controls="profile" role="tab" data-toggle="tab" <?php if($data->fields['professional_1'] == ''){ print 'style="background-color: #ffff0047;"';} ?>>
                                            <b <?php //if($PRO_lengkap != 'Lengkap'){print 'style="color: red;"';} ?>>Profesional</b></a>
                                        </li>
                                        <?php //} ?>
                                    </ul>

                                    <div class="tab-content tabs">
					<div role="tabpanel" class="tab-pane fade in" id="Section30">
                                            <?php include 'pemohon/akademik/profesional.php'; ?>
                                        </div>
                                        <div role="tabpanel" class="tab-pane fade in active" id="Section21">
                                            <?php include 'pemohon/akademik/pmr.php'; ?>
                                        </div>
                                        <div role="tabpanel" class="tab-pane fade in" id="Section22">
                                            <?php include 'pemohon/akademik/spm.php'; ?>
                                        </div>
                                        <div role="tabpanel" class="tab-pane fade in" id="Section23">
                                            <?php include 'pemohon/akademik/tambahan.php'; ?>
                                        </div>
                                        <div role="tabpanel" class="tab-pane fade in" id="Section24">
                                            <?php include 'pemohon/akademik/stpm.php'; ?>
                                        </div>
                                        <div role="tabpanel" class="tab-pane fade in" id="Section25">
                                            <?php include 'pemohon/akademik/stam.php'; ?>
                                        </div>
                                        <div role="tabpanel" class="tab-pane fade in" id="Section26">
                                            <?php include 'pemohon/akademik/univ.php'; ?>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>            
        </div>

    
    </div>
<div class="form-group">
	<div class="row">
               	<div class="col-md-12">
               		<!--<a type="button" class="btn btn-success" href="<?=$_SESSION['SESSADM_BACKLINK'];?>"><i class="fa fa-arrow-left" style="margin:0px;"></i> Kembali</a>-->
               		<a type="button" class="btn btn-success" href="<?=$_SESSION['SESS_LINKBACK'];?>"><i class="fa fa-arrow-left" style="margin:0px;"></i> Kembali</a>
               	</div>
	</div>
</div>

</div>