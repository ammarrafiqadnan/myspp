<?php
$tahun1 = $data->fields['spm_tahun_1'];
$tahun2 = $data->fields['spm_tahun_2'];
print $SPM_lengkap;

?>

<header class="panel-heading"  style="background-color:rgb(38, 167, 228)">
    <h6 class="panel-title"><font color="#000000" size="3"><b>Maklumat Keputusan Peperiksaan SPM/MCE/SPVM/SPM(V) calon</b></font></h6>
</header>
<div class="panel-body">
    <div class="box-body">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12">
                    <?php if(!empty($tahun1)) { ?>
                    <div class="tab" role="tabpanel">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active"><a href="#SectionExam1" aria-controls="home" role="tab" data-toggle="tab">
                                <b>Maklumat Peperiksaan Kali Pertama</b></a></li>
                            <?php if(!empty($tahun2)){ ?>
                            <li role="presentation"><a href="#SectionExam2" aria-controls="profile" role="tab" data-toggle="tab">
                                <b>Maklumat Peperiksaan Kali Kedua</b></a></li>
                            <?php } ?>
                        </ul>
                        <!-- Tab panes -->
                        <div class="tab-content tabs">
                            <div role="tabpanel" class="tab-pane fade in active" id="SectionExam1">
                                <?php include 'pemohon/akademik/spm1.php';?>
                            </div>
                            <?php if(!empty($tahun2)){ ?>
                            <div role="tabpanel" class="tab-pane fade" id="SectionExam2">
                                <?php include 'pemohon/akademik/spm2.php';?>
                            </div>
                            <?php } ?>

                        </div>
                    </div>
                    <?php } else {
                        print '-- Tiada Maklumat --';
                    }?>
                </div>
            </div>
        </div>
    </div>
</div>		 
