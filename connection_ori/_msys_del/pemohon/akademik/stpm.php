<?php
    $tahun_stp1 = $data->fields['stp_tahun_1'];
    $tahun_stp2 = $data->fields['stp_tahun_2'];
?>

<header class="panel-heading"  style="background-color:rgb(38, 167, 228)">
    <h6 class="panel-title"><font color="#000000" size="3"><b>Maklumat Keputusan Peperiksaan STPM calon</b></font></h6>
</header>
<div class="panel-body">
    <div class="box-body">

    <input type="hidden" name="pemantauan_id" id="pemantauan_id" value="<?php print $id;?>" readonly="readonly"/>

        <div class="col-md-12">

            <div class="row">
                <div class="col-md-12">
                    <?php if(!empty($tahun_stp1)) { ?>
                        <div class="tab" role="tabpanel">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs" role="tablist">
                                <li role="presentation" class="active"><a href="#SectionSTPM1" aria-controls="home" role="tab" data-toggle="tab">
                                    <b>Maklumat Peperiksaan Kali Pertama</b></a></li>
                                <?php if(!empty($tahun_stp2)){ ?>
                                    <li role="presentation"><a href="#SectionSTPM2" aria-controls="profile" role="tab" data-toggle="tab">
                                    <b>Maklumat Peperiksaan Kali Kedua</b></a></li>
                                <?php } ?>
                            </ul>
                            <!-- Tab panes -->
                            <div class="tab-content tabs">
                                <div role="tabpanel" class="tab-pane fade in active" id="SectionSTPM1">
                                    <?php include 'pemohon/akademik/stpm1.php';?>
                                </div>
                                <?php if(!empty($tahun_stp2)){ ?>
                                    <div role="tabpanel" class="tab-pane fade" id="SectionSTPM2">
                                        <?php include 'pemohon/akademik/stpm2.php';?>
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
