<!-- <small style="color: red;">
    Tarikh dikemskini : 04-03-2022 10:30:23 <br>
    Maklumat Pengajian Tinggi adalah maklumat akademik peperiksaan peringkat Pengajian Tinggi calon.<br><br>
</small> -->
<?php 
print $UNIV_lengkap;

?>
<header class="panel-heading"  style="background-color:rgb(38, 167, 228)">
    <h6 class="panel-title"><font color="#000000" size="3"><b>Maklumat Keputusan Pengajian Tinggi calon</b></font></h6>
</header>
<div class="panel-body">
    <div class="box-body">

    <input type="hidden" name="pemantauan_id" id="pemantauan_id" value="<?php print $id;?>" readonly="readonly"/>

        <div class="col-md-12">

            <div class="row">
                <div class="col-md-12">
                    <?php 
						// $conn->debug=true;
						$rsUniv = $conn->query("SELECT * FROM $schema2.`calon_ipt` WHERE `bil_keputusan`='1' AND `id_pemohon`=".tosql($id_pemohon));
						$bilUniv1 = $rsUniv->recordcount();
						$rsUniv2 = $conn->query("SELECT * FROM $schema2.`calon_ipt` WHERE `bil_keputusan`='2' AND `id_pemohon`=".tosql($id_pemohon));
						$bilUniv2 = $rsUniv2->recordcount();
						$rsUniv3 = $conn->query("SELECT * FROM $schema2.`calon_ipt` WHERE `bil_keputusan`='3' AND `id_pemohon`=".tosql($id_pemohon));
						$bilUniv3 = $rsUniv3->recordcount();
						// $conn->debug=false;
					?>					
					<div class="row">
						<input type="hidden" name="bil_keputusan1" id="bil_keputusan1" value="<?=$rsUniv->fields['bil_keputusan'];?>">
						<input type="hidden" name="bil_keputusan2" id="bil_keputusan2" value="<?=$rsUniv2->fields['bil_keputusan'];?>">
						<input type="hidden" name="bil_keputusan3" id="bil_keputusan3" value="<?=$rsUniv3->fields['bil_keputusan'];?>">

                        <div class="tab" role="tabpanel">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs" role="tablist">
                                <li role="presentation" class="active">
                                    <a href="#SectionUNIV1" aria-controls="home" role="tab" data-toggle="tab">
                                    <b>Maklumat Keputusan - 1</b></a>
                                </li>
                                <?php if(!empty($bilUniv2)){ ?>
                                    <li role="presentation">
                                        <a href="#SectionUNIV2" aria-controls="profile" role="tab" data-toggle="tab">
                                        <b>Maklumat Keputusan - 2</b></a>
                                    </li>
                                <?php } ?>
                                <?php if(!empty($bilUniv3)){ ?>
                                    <li role="presentation">
                                        <a href="#SectionUNIV3" aria-controls="profile" role="tab" data-toggle="tab">
                                        <b>Maklumat Keputusan - 3</b></a>
                                    </li>
                                <?php } ?>
                            </ul>
                            <!-- Tab panes -->
                            <div class="tab-content tabs">
                                <div role="tabpanel" class="tab-pane fade in active" id="SectionUNIV1">
                                    <?php include 'pemohon/akademik/univ1.php';?>
                                </div>
                                <div role="tabpanel" class="tab-pane fade" id="SectionUNIV2">
                                    <?php include 'pemohon/akademik/univ2.php';?>
                                </div>
                                <div role="tabpanel" class="tab-pane fade" id="SectionUNIV3">
                                    <?php include 'pemohon/akademik/univ3.php';?>
                                </div>
                            </div>
                        </div>
			    	</div>
                </div>
            </div>
            
        </div>

    
    </div>
</div>	 
