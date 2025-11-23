<!-- <small style="color: red;">
    Tarikh dikemskini : 04-03-2022 10:30:23 <br>
    Maklumat STAM adalah maklumat akademik peperiksaan peringkat STAM calon.<br><br>
</small> -->
<?php
    $tahun_stam1 = $data->fields['stam_tahun_1'];
    $tahun_stam2 = $data->fields['stam_tahun_2'];
?>
<header class="panel-heading"  style="background-color:rgb(38, 167, 228)">
    <h6 class="panel-title"><font color="#000000" size="3"><b>Maklumat Keputusan Peperiksaan STAM calon</b></font></h6>
</header>
<div class="panel-body">
    <div class="box-body">

    <input type="hidden" name="pemantauan_id" id="pemantauan_id" value="<?php print $id;?>" readonly="readonly"/>

        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12">
                    <?php if(!empty($tahun_stam1)) { ?>
                        <div class="tab" role="tabpanel">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs" role="tablist">
                                <li role="presentation" class="active"><a href="#SectionSTAM1" aria-controls="home" role="tab" data-toggle="tab">
                                    <b>Maklumat Peperiksaan Kali Pertama</b></a></li>
                                <?php if(!empty($tahun2)){ ?>
                                    <li role="presentation"><a href="#SectionSTAM2" aria-controls="profile" role="tab" data-toggle="tab">
                                    <b>Maklumat Peperiksaan Kali Kedua</b></a></li>
                                <?php } ?>
                            </ul>
                            <!-- Tab panes -->
                            <div class="tab-content tabs">
                                <div role="tabpanel" class="tab-pane fade in active" id="SectionSTAM1">
                                    <?php include 'pemohon/akademik/stam1.php';?>
                                </div>
                                <?php if(!empty($tahun2)){ ?>
                                    <div role="tabpanel" class="tab-pane fade" id="SectionSTAM2">
                                        <?php include 'pemohon/akademik/stam2.php';?>
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
