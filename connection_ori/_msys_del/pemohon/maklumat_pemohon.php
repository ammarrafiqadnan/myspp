<?php
    //$conn->debug=true;
    $id_pemohon=isset($_REQUEST["id_pemohon"])?$_REQUEST["id_pemohon"]:"";
    include 'pemohon/maklumat/sql_maklumat.php';
    include 'pemohon/akademik/sql_akademik.php';
    include 'pemohon/sql_pemohon.php';

    $data = get_all($conn,$id_pemohon);
    $rsMYID = get_myid($conn, $id_pemohon);
    $rsCalon = get_calon($conn, $id_pemohon);

    //print $rsMYID;
?>

<?php 
    $lengkap="";
    //print_r($data_biodata);
    $icon_tick = '../images/icon_green.png';
    $icon_no = '../images/icon_red.png';
    $icon_info = '../images/Button-Info-icon.png';
    
    $sql = "SELECT id_pemohon, srp_tahun, srp_jenis_sijil, srp_pangkat FROM $schema2.calon WHERE `id_pemohon`=".tosql($data->fields['id_pemohon']);
    $data_pmr = $conn->query($sql);
    //print_r($data_pmr);
    $SPR_lengkap=''; $SPR_lengkap_ikon='';
    if(empty($data_pmr->fields['srp_tahun'])){ 
        $SPR_status = 'TidakLengkap';
        $SPR_lengkap='Tiada Maklumat, Lengkapkan sekiranya perlu'; 
        $SPR_lengkap_ikon=$icon_tick;
    } else {
        if(empty($data_pmr->fields['srp_jenis_sijil']) || empty($data_pmr->fields['srp_pangkat'])){ 
            $SPR_status = 'TidakLengkap';
            $SPR_lengkap='<font style="color:red">Tiada Maklumat, Lengkapkan sekiranya perlu.</font>'; 
            $SPR_lengkap_ikon=$icon_info;
        } else {
            $SPR_lengkap='Lengkap';
            $SPR_lengkap_ikon=$icon_tick;
        }
    }

    $sql = "SELECT id_pemohon, spm_tahun_1, spm_jenis_sijil_1, spm_pangkat_1, spm_tahun_2, spm_jenis_sijil_2, spm_pangkat_2, spm_lisan_1, stp_tahun_1, stp_jenis_1, stp_pangkat_1, stp_tahun_2, stp_jenis_2, stp_pangkat_2,   
    stam_tahun_1, stam_jenis_1, stam_pangkat_1, stam_tahun_2, stam_jenis_2, stam_pangkat_2    
    FROM $schema2.calon WHERE `id_pemohon`=".tosql($data->fields['id_pemohon']);
    $data_spm = $conn->query($sql);
    
    // $data_spm = get_exam($conn,$data->fields['id_pemohon']);
    //print_r($data_spm);
    $SPR_lengkap=''; $SPR_lengkap_ikon='';
    if(empty($data_spm->fields['spm_tahun_1'])){ 
        $SPM_status = 'TidakLengkap';
        $SPM_lengkap='Tiada Maklumat, Lengkapkan sekiranya perlu'; 
        $SPM_lengkap_ikon=$icon_info;
    } else {
        if(empty($data_spm->fields['spm_jenis_sijil_1']) || empty($data_spm->fields['spm_pangkat_1']) || empty($data_spm->fields['spm_lisan_1'])){ 
            $SPM_status = 'TidakLengkap';
            $SPM_lengkap='<font style="color:red">Tidak Lengkap. Sila semak semula maklumat diisi.</font>'; 
            $SPM_lengkap_ikon=$icon_no;
        } else {
            $SPM_lengkap='Lengkap';
            $SPM_lengkap_ikon=$icon_tick;
        }
    }

    $SPM_tambahan_status = 'TidakLengkap';
    $SPM_tambahan='Tiada Maklumat, Lengkapkan sekiranya perlu'; 
    $SPM_tambahan_ikon=$icon_info;
    $rsData = $conn->query("SELECT * FROM $schema2.`calon_spm` WHERE `jenis_xm`='T' AND `id_pemohon`=".tosql($data->fields['id_pemohon']));
    if(!$rsData->EOF){
        $SPM_tambahan='Lengkap';
        $SPM_tambahan_ikon=$icon_tick;
    }

    $rsUniv = $conn->query("SELECT * FROM $schema2.`calon_ipt` WHERE `id_pemohon`=".tosql($data->fields['id_pemohon']));
    $bilUniv1 = $rsUniv->recordcount();

    $SPR_lengkap=''; $SPR_lengkap_ikon='';
    if($rsUniv->EOF){ 
        $UNIV_status = 'TidakLengkap';
        $UNIV_lengkap='Tiada Maklumat, Lengkapkan sekiranya perlu'; 
        $UNIV_lengkap_ikon=$icon_info;
    } else {
        // if(empty($data_spm->fields['spm_jenis_sijil_1']) || empty($data_spm->fields['spm_pangkat_1']) || empty($data_spm->fields['spm_lisan_1'])){ 
        // 	$UNIV_lengkap='<font style="color:red">Tidak Lengkap. Sila semak semula maklumat diisi.</font>'; 
        // 	$UNIV_lengkap_ikon=$icon_no;
        // } else {
            $UNIV_lengkap='Lengkap';
            $UNIV_lengkap_ikon=$icon_tick;
        // }
    }

    $sql = "SELECT * FROM $schema2.`calon` WHERE `id_pemohon`=".tosql($data->fields['id_pemohon']);
    $prof = $conn->query($sql);
    // $prof->fields = get_profesional($conn,$prof->fields->fields['id_pemohon']);

    $SPR_lengkap=''; $SPR_lengkap_ikon='';
    if(empty($prof->fields['professional_1']) && empty($prof->fields['professional_d_1'])){ 
        $PRO_status = 'TidakLengkap';
        $PRO_lengkap='Tiada Maklumat, Lengkapkan sekiranya perlu'; 
        $PRO_lengkap_ikon=$icon_info;
    } else {
        // if(empty($data_PRO->fields['PRO_jenis_sijil_1']) || empty($data_PRO->fields['PRO_pangkat_1']) || empty($data_PRO->fields['PRO_lisan_1'])){ 
        // 	$PRO_lengkap='<font style="color:red">Maklumat perlu dilengkapkan.</font>'; 
        // 	$PRO_lengkap_ikon='../images/icon_red.jpg';
        // } else {
            $PRO_lengkap='Lengkap';
            $PRO_lengkap_ikon=$icon_tick;
        }
?>

<header class="panel-heading"  style="background-color:rgb(38, 167, 228)">
    <h6 class="panel-title"><font color="#000000" size="3"><b><?php print strtoupper($menu);?></b></font></h6>
</header>
<div class="panel-body">
    <div class="box-body">

    <input type="hidden" name="pemantauan_id" id="pemantauan_id" value="<?php print $id;?>" readonly="readonly"/>

        <div class="col-md-12">

            <?php //include 'biodata/biodata_view.php'; ?>

            <div class="row">
                <div class="col-md-12">
                    <div class="tab" role="tabpanel">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active"><a href="#Section1" aria-controls="home" role="tab" data-toggle="tab">
                                <b>Pemohon</b></a>
                            </li>
                            <!-- <li role="presentation">
                                <a href="#Section4" aria-controls="profile" role="tab" data-toggle="tab">
                                    <b>Maklumat Perkhidmatan</b>
                                </a>
                            </li> -->
                            <li role="presentation"><a href="#Section2" aria-controls="profile" role="tab" data-toggle="tab">
                                <b>Maklumat Akademik</b></a>
                            </li>
                            <li role="presentation"><a href="#Section3" aria-controls="home" role="tab" data-toggle="tab">
                                <b>Maklumat Bukan Akademik</b></a>
                            </li>
                            <li role="presentation"><a href="#Section6" aria-controls="profile" role="tab" data-toggle="tab">
                                <b>Jawatan Yang Dimohon</b></a>
                            </li>
                            <li role="presentation"><a href="#Section7" aria-controls="profile" role="tab" data-toggle="tab">
                                <b>Dokumen</b></a>
                            </li>
                            <li role="presentation"><a href="#Section9" aria-controls="profile" role="tab" data-toggle="tab">
                                <b>Senarai Semak</b></a>
                            </li>
                            <li role="presentation"><a href="#Section8" aria-controls="profile" role="tab" data-toggle="tab">
                                <b>Auditrail</b></a>
                            </li>
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
                            <div role="tabpanel" class="tab-pane fade" id="Section4">
                                <?php include 'pemohon/perkhidmatan/perkhidmatan.php'; ?>
                            </div>
                            <div role="tabpanel" class="tab-pane fade" id="Section2">
                                <div class="tab" role="tabpanel">
                                    <!-- Sub Nav tabs Pemohon -->
                                    <ul class="nav nav-tabs" role="tablist">
                                        <?php //if($SPR_lengkap == 'Lengkap'){ ?>
                                        <li role="presentation" class="active">
                                            <a href="#Section21" aria-controls="home" role="tab" data-toggle="tab">
                                            
                                            <b <?php if($SPR_lengkap != 'Lengkap') {print 'style="color: red;"';} ?>>PT3/PMR</b></a>
                                        </li>
                                        <?php //}
                                        //if($SPM_lengkap == 'Lengkap'){ ?>
                                        <li role="presentation" class=""><a href="#Section22" aria-controls="home" role="tab" data-toggle="tab">
                                            <b <?php if($SPM_lengkap != 'Lengkap'){ print 'style="color: red;"';} ?>>SPM/SPM(V)/SVM</b></a>
                                        </li>
                                        <?php //}
                                        //if($SPM_tambahan == 'Lengkap'){ ?>
                                        <li role="presentation"><a href="#Section23" aria-controls="profile" role="tab" data-toggle="tab">
                                            <b <?php //if($SPM_tambahan != 'Lengkap'){ print 'style="color: red;"';} ?>>Peperiksaan SPM Ulangan</b></a>
                                        </li>
                                        <!-- <li role="presentation"><a href="#Section24" aria-controls="home" role="tab" data-toggle="tab">
                                            <b>STPM</b></a>
                                        </li>
                                        <li role="presentation"><a href="#Section25" aria-controls="profile" role="tab" data-toggle="tab">
                                            <b>STAM</b></a>
                                        </li> -->
                                        <?php //} 
                                        //if($UNIV_lengkap == 'Lengkap'){ ?>
                                        <li role="presentation"><a href="#Section26" aria-controls="home" role="tab" data-toggle="tab">
                                            <b <?php //if($UNIV_lengkap != 'Lengkap'){print 'style="color: red;"';} ?>>Pengajian Tinggi</b></a>
                                        </li>
                                        <?php //}
                                         //if($PRO_lengkap == 'Lengkap'){ ?>
                                        <li role="presentation"><a href="#Section28" aria-controls="profile" role="tab" data-toggle="tab">
                                            <b <?php //if($PRO_lengkap != 'Lengkap'){print 'style="color: red;"';} ?>>Profesional</b></a>
                                        </li>
                                        <?php //} ?>
                                    </ul>

                                    <div class="tab-content tabs">
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
                                        <div role="tabpanel" class="tab-pane fade in" id="Section28">
                                            <?php include 'pemohon/akademik/profesional.php'; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane fade in" id="Section3">
                                <div class="tab" role="tabpanel">
                                    <!-- Sub Nav tabs Pemohon -->
                                    <ul class="nav nav-tabs" role="tablist">
                                        <li role="presentation" class="active"><a href="#Section31" aria-controls="home" role="tab" data-toggle="tab">
                                            <b>Sukan/ <br> Persatuan</b></a>
                                        </li>
                                        <li role="presentation"><a href="#Section32" aria-controls="profile" role="tab" data-toggle="tab">
                                            <b>Rekacipta/ <br>Pencapaian</b></a>
                                        </li>
                                        <li role="presentation"><a href="#Section41" aria-controls="home" role="tab" data-toggle="tab">
                                            <b>Bakat/ <br>Kebolehan/ Bahasa</b></a>
                                        </li>
                                        <li role="presentation"><a href="#Section42" aria-controls="profile" role="tab" data-toggle="tab">
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
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <a type="button" class="btn btn-success" href="index.php?data=<?php print base64_encode('pemohon/senarai_pemohon;Senarai Pemohon;;;;;'); ?>"><i class="fa fa-arrow-left" style="margin:0px;"></i> Kembali</a>
                </div>
            </div>
            
        </div>

    
    </div>
</div>