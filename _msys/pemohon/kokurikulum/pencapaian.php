

<header class="panel-heading"  style="background-color:rgb(38, 167, 228)">
    <h6 class="panel-title"><font color="#000000" size="3"><b>MAKLUMAT REKACIPTA/PENCAPAIAN</b></font></h6>
</header>
<div class="panel-body">
    <div class="box-body">
        <div class="col-md-12">
            <div class="form-group">
                <div class="row">
                    <div class="col-sm-12">
                        <div>
                            Maklumat Ko-kurikulum bahagian reka cipta dan inovasi bagi calon.<br><br>
                        </div>
                        <?php 
                            $rsRekacipta = $conn->query("SELECT * FROM $schema2.`calon_ko_rekacipta` WHERE `id_pemohon`=".tosql($data->fields['id_pemohon']));

                            $count = $conn->query("SELECT COUNT(*) as total FROM $schema2.`calon_ko_rekacipta` WHERE `id_pemohon`=".tosql($data->fields['id_pemohon']));

                        ?>
                        <small style="color: red;">
                            Tarikh dikemaskini : 
                            <?php
                            if(($count->fields['total'] != 0)){
                                if(!empty($rsRekacipta->fields['d_kemaskini'])){
                                    print DisplayDate($rsRekacipta->fields['d_kemaskini']);  print '&nbsp;&nbsp;'.DisplayMasa($rsRekacipta->fields['d_kemaskini']);
                                } else {
                                    print DisplayDate($rsRekacipta->fields['d_cipta']);  print '&nbsp;&nbsp;'.DisplayMasa($rsRekacipta->fields['d_cipta']);
                                }
                            }
                            ?>
                        </small>
                        <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                            <thead  style="background-color:rgb(38, 167, 228)">
								<th width="50%"><font color="#000000"><div>Reka Cipta</div></font></th>
                                <th width="25%"><font color="#000000"><div>Sumbangan</div></font></th>
                                <th width="25%"><font color="#000000"><div>Peringkat</div></font></th>
                            </thead>
                            <tbody>
                            <?php 
                                $rsRekacipta = $conn->query("SELECT * FROM $schema2.`calon_ko_rekacipta` WHERE `id_pemohon`=".tosql($data->fields['id_pemohon']));

                                $bil=0;
                                if($count->fields['total'] != 0){
                                while(!$rsRekacipta->EOF){ 
					//$conn->debug=true;
                                    $sql = "SELECT * FROM $schema1.`ref_rekacipta` WHERE SAH_YT='Y' AND KOD=".tosql($rsRekacipta->fields['sumbangan'])." ORDER BY KOD";
                                    $rsReka = $conn->query($sql);

                                    $sql = "SELECT * FROM $schema1.`ref_peringkat` WHERE SAH_YT='Y' AND kod=".tosql($rsRekacipta->fields['peringkat'])." ORDER BY KOD";
                                    $rsPeringkat = $conn->query($sql);

                                ?>
                                <tr>
                                    <td align="center"><?=$rsRekacipta->fields['rekacipta']; ?></td>
                                    <td align="center"><?=$rsReka->fields['DISKRIPSI']; ?></td>
                                    <td align="center"><?=$rsPeringkat->fields['DISKRIPSI']; ?></td>

                                </tr>
                                <?php 
                                $rsRekacipta->movenext(); } 
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
            <?php
            $rsPencapaian = $conn->query("SELECT * FROM $schema2.`calon_ko_khas` WHERE `id_pemohon`=".tosql($data->fields['id_pemohon']));

            $count = $conn->query("SELECT COUNT(*) as total FROM $schema2.`calon_ko_khas` WHERE `id_pemohon`=".tosql($data->fields['id_pemohon']));

            ?>
            <small style="color: red;">
                Tarikh dikemaskini : 
                <?php
                if(($count->fields['total'] != 0)){
                    if(!empty($rsPencapaian->fields['d_kemaskini'])){
                        print DisplayDate($rsPencapaian->fields['d_kemaskini']);  print '&nbsp;&nbsp;'.DisplayMasa($rsPencapaian->fields['d_kemaskini']);
                    } else {
                        print DisplayDate($rsPencapaian->fields['d_cipta']);  print '&nbsp;&nbsp;'.DisplayMasa($rsPencapaian->fields['d_cipta']);
                    }
                }
                 ?>
            </small>
            <div class="form-group">
                <div class="row">
                    <div class="col-sm-12">
                        <div>
                            Maklumat Ko-kurikulum bahagian pencapaian khas bagi calon.<br><br>
                        </div>
                        <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                            <thead  style="background-color:rgb(38, 167, 228)">
								<th width="50%"><font color="#000000"><div>Pencapaian Khas</div></font></th>
                            </thead>
                            <tbody>
                                <?php if($count->fields['total'] != 0){
                                while(!$rsPencapaian->EOF){ ?>
                                <tr>
                                    <td><?=$rsPencapaian->fields['pencapaian']?></td>
                                </tr>
                                <?php 
                                $rsPencapaian->movenext(); } 
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

