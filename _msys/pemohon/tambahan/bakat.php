<header class="panel-heading"  style="background-color:rgb(38, 167, 228)">
    <h6 class="panel-title"><font color="#000000" size="3"><b>MAKLUMAT BAKAT/KEBOLEHAN BAHASA</b></font></h6>
</header>
<div class="panel-body">
    <div class="box-body">
        <div class="col-md-12">
            <div class="form-group">
                <div class="row">
                    <div class="col-sm-12">
                        <div>
                            Maklumat Bakat bagi calon.<br><br>
                        </div>
                        <?php 
                            $rsData = $rsData = $conn->query("SELECT * FROM $schema2.`calon_bakat_bahasa` WHERE `id_pemohon`='{$data->fields['id_pemohon']}' AND `bakat_bahasa_ind`='B'");

                            $count = $conn->query("SELECT COUNT(*) as total FROM $schema2.`calon_bakat_bahasa` WHERE `id_pemohon`='{$data->fields['id_pemohon']}' AND `bakat_bahasa_ind`='B'");

                        ?>
                        <small style="color: red;">
                            Tarikh dikemaskini : 
                            <?php
                            if(($count->fields['total'] != 0)){
                                if(!empty($rsData->fields['d_kemaskini'])){
                                    print DisplayDate($rsData->fields['d_kemaskini']);  print '&nbsp;&nbsp;'.DisplayMasa($rsData->fields['d_kemaskini']);
                                } else {
                                    print DisplayDate($rsData->fields['d_cipta']);  print '&nbsp;&nbsp;'.DisplayMasa($rsData->fields['d_cipta']);
                                }
                            }
                            ?>
                        </small>
                        <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                            <thead  style="background-color:rgb(38, 167, 228)">
								<th width="80%"><font color="#000000"><div>Bakat</div></font></th>
                            </thead>
                            <tbody>
                                <?php
                                if($count->fields['total'] != 0){
                                    while(!$rsData->EOF){ 

                                    $sql = "SELECT * FROM $schema1.`ref_bakat` WHERE kod=".tosql($rsData->fields['bakat_bahasa'])." GROUP BY kod";
                                    $rsBakat = $conn->query($sql);
                
                                ?>
                                <tr>
                                    <td><?=$rsBakat->fields['descripsi']?></td>
                                </tr>
                                <?php 
                                $rsData->movenext(); } 
                                } else { ?>
                                    <tr>
                                        <td colspan="7" align="center">Tiada rekod dijumpai</td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-sm-12">
                        <div>
                            Maklumat Bahasa bagi calon.<br><br>
                        </div>
                        <?php 
                            $rsData = $rsData = $conn->query("SELECT * FROM $schema2.`calon_bakat_bahasa` WHERE `id_pemohon`='{$data->fields['id_pemohon']}' AND `bakat_bahasa_ind`='L'");

                            $count = $conn->query("SELECT COUNT(*) as total FROM $schema2.`calon_bakat_bahasa` WHERE `id_pemohon`='{$data->fields['id_pemohon']}' AND `bakat_bahasa_ind`='L'");

                        ?>
                        <small style="color: red;">
                            Tarikh dikemaskini : 
                            <?php
                            if(($count->fields['total'] != 0)){
                                if(!empty($rsData->fields['d_kemaskini'])){
                                    print DisplayDate($rsData->fields['d_kemaskini']);  print '&nbsp;&nbsp;'.DisplayMasa($rsData->fields['d_kemaskini']);
                                } else {
                                    print DisplayDate($rsData->fields['d_cipta']);  print '&nbsp;&nbsp;'.DisplayMasa($rsData->fields['d_cipta']);
                                }
                            }
                            ?>
                        </small>
                        <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                            <thead  style="background-color:rgb(38, 167, 228)">
								<th width="50%"><font color="#000000"><div>Bahasa/ Dialek</div></font></th>
                                <th width="25%"><font color="#000000"><div>Penguasaan</div></font></th>
                            </thead>
                            <tbody>
                                <?php
                                    if($count->fields['total'] != 0){
                                    while(!$rsData->EOF){ 

                                    $sql = "SELECT * FROM $schema1.`ref_bahasa` WHERE  kod=".tosql($rsData->fields['bakat_bahasa'])." GROUP BY kod";
                                    $rsBahasa = $conn->query($sql);
                                    $sql = "SELECT * FROM $schema1.`ref_penguasaan_bahasa` WHERE  KOD=".tosql($rsData->fields['penguasaan'])." GROUP BY KOD";
                                    $rsPenguasaan = $conn->query($sql);

                
                                ?>
                                <tr>
                                    <td><?=$rsBahasa->fields['diskripsi']?></td>
                                    <td><?=$rsPenguasaan->fields['DISKRIPSI']?></td>
                                </tr>
                                <?php 
                                $rsData->movenext(); } 
                                } else { ?>
                                    <tr>
                                        <td colspan="7" align="center">Tiada rekod dijumpai</td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>	 

	     
<!--<div class="form-group">
	    	<div class="row">
                	<div class="col-md-12">
                    		<a type="button" class="btn btn-success" href="index.php?data=<?php print base64_encode('pemohon/senarai_pemohon;Senarai Pemohon;;;;;'); ?>"><i class="fa fa-arrow-left" style="margin:0px;"></i> Kembali</a>
                	</div>
		</div>
            </div>-->

