<?php

    $id_pemohon=isset($_REQUEST["id_pemohon"])?$_REQUEST["id_pemohon"]:"";
    include 'pemohon/maklumat/sql_maklumat.php';
    include 'pemohon/akademik/sql_akademik.php';
    include 'pemohon/sql_pemohon.php';

    $data = get_all($conn,$id_pemohon);
    $rsMYID = get_myid($conn, $id_pemohon);
    //print $rsMYID;
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
                            <li role="presentation">
                                <a href="#Section4" aria-controls="profile" role="tab" data-toggle="tab">
                                    <?php if($rsMYID->fields['ICNo'] == '860613915079'){ ?>
                                        <b style="color: red">Maklumat Perkhidmatan</b>
                                    <?php } else { ?>
                                        <b>Maklumat Perkhidmatan</b>
                                    <?php } ?>
                                </a>
                            </li>
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
                                        <li role="presentation" class="active"><a href="#Section21" aria-controls="home" role="tab" data-toggle="tab">
                                            <b>PT3/PMR/SRP</b></a>
                                        </li>
                                        <li role="presentation" class=""><a href="#Section22" aria-controls="home" role="tab" data-toggle="tab">
                                            <b>SPM/SVM/SPM(V)</b></a>
                                        </li>
                                        <li role="presentation"><a href="#Section23" aria-controls="profile" role="tab" data-toggle="tab">
                                            <b>SPM Ulangan</b></a>
                                        </li>
                                        <li role="presentation"><a href="#Section24" aria-controls="home" role="tab" data-toggle="tab">
                                            <b>STPM</b></a>
                                        </li>
                                        <li role="presentation"><a href="#Section25" aria-controls="profile" role="tab" data-toggle="tab">
                                            <b>STAM</b></a>
                                        </li>
                                        <li role="presentation"><a href="#Section26" aria-controls="home" role="tab" data-toggle="tab">
                                            <b>Pengajian Tinggi</b></a>
                                        </li>
                                        <li role="presentation"><a href="#Section28" aria-controls="profile" role="tab" data-toggle="tab">
                                            <b>Profesional</b></a>
                                        </li>
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
                                            <b>Bakat/ <br>Kebolehan Bahasa</b></a>
                                        </li>
                                        <li role="presentation"><a href="#Section42" aria-controls="profile" role="tab" data-toggle="tab">
                                            <b>Bekas Tentera/ <br>Polis</b></a>
                                        </li>
                                        <li role="presentation"><a href="#Section43" aria-controls="profile" role="tab" data-toggle="tab">
                                            <b>Penerima Bantuan/ <br>Kurang Upaya</b></a>
                                        </li>
                                    </ul>

                                    <div class="tab-content tabs">
                                        <div role="tabpanel" class="tab-pane fade in active" id="Section31">
                                            <?php include 'pemohon/kokurikulum/sukan.php'; ?>
                                        </div>
                                        <div role="tabpanel" class="tab-pane fade in" id="Section32">
                                            <?php include 'pemohon/kokurikulum/pencapaian.php'; ?>

                                        </div>
                                        <div role="tabpanel" class="tab-pane fade in active" id="Section41">
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