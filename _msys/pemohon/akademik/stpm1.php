<?php
    $tahun_stp = $data->fields['stp_tahun_1'];
	//$conn->debug=true;
    $rsSTP = get_stp_result($conn, $id_pemohon, $tahun_stp);
	$rsSTP3 = get_stp_result3($conn, $id_pemohon, $tahun_stp);
//$conn->debug=false;
    $rssijil = $conn->query("SELECT * FROM $schema1.`ref_sijil` WHERE `TKT`='6'");
	$rspangkat = $conn->query("SELECT * FROM $schema1.`ref_sijil_pangkat` WHERE `TKT`=6 ORDER BY `DISKRIPSI`");
?>
 

    <small style="color: red;">
        Tarikh/masa kemas kini : 
        <?php
        if(!empty($rsSTP->fields['d_kemaskini'])){
            print DisplayDate($rsSTP3->fields['d_kemaskini']);  print '&nbsp;&nbsp;'.DisplayMasa($rsSTP3->fields['d_kemaskini']);
        } else {
            print DisplayDate($rsSTP3->fields['d_cipta']);  print '&nbsp;&nbsp;'.DisplayMasa($rsSTP3->fields['d_cipta']);
        }
        ?>  <br>
    </small>
    <div class="form-group">
        <div class="row">
            <label for="nama" class="col-sm-2 control-label"><b>Jenis<div style="float:right">:</div></b></label>
            <div class="col-sm-3">
                <?php while(!$rssijil->EOF){ ?>
                    <?php if($rssijil->fields['KOD']==$data->fields['stp_jenis_1']){ 
                        print $rssijil->fields['DISKRIPSI']; }
                    ?>
                <?php $rssijil->movenext(); } ?>
            </div>
		<label for="nama" class="col-sm-2 control-label"><b>Tahun<div style="float:right">:</div></b></label>
            <div class="col-sm-3">
                <?=$data->fields['stp_tahun_1'];?>
            </div>

            <!-- <label for="nama" class="col-sm-2 control-label"><b>Lisan<div style="float:right">:</div></b></label>
            <div class="col-sm-3">
                <?php 
                if($data->fields['stp_lisan_1']=='L'){
                    print 'Lulus';
                } else if($data->fields['stp_lisan_1']=='G'){
                    print 'Gagal';
                }
                ?>
            </div> -->
        </div>
    </div>
    <!--<div class="form-group">
        <div class="row">
            <label for="nama" class="col-sm-2 control-label"><b>Pangkat<div style="float:right">:</div></b></label>
            <div class="col-sm-3">
                <?php while(!$rspangkat->EOF){ ?>
                    <?php if($rspangkat->fields['DISKRIPSI']==$data->fields['stp_pangkat_1']){ 
                        print $rspangkat->fields['DISKRIPSI']; }
                    ?>
                <?php $rspangkat->movenext(); } ?>
            </div>
            
        </div>
    </div>-->

    <hr>
	<?php //$conn->debug=true;
	if(!empty($data->fields['stp_tahun_1'])){ 
	$rsSTPM2 = $conn->query("SELECT * FROM $schema1.`ref_matapelajaran` WHERE `TKT`='6' AND `SAH_YT`='Y' AND `GAB_YT`='T' AND `kod` NOT IN ('A33') 
		ORDER BY `DISKRIPSI`");
	$rsGred = $conn->query("SELECT * FROM $schema1.`ref_gred_matapelajaran` WHERE `TKT`='6' AND `JENIS`='D' ORDER BY `SUSUNAN`");
	} ?>


    <div class="form-group">
    <div class="row">
        <div class="col-sm-8">
            <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                <thead  style="background-color:rgb(38, 167, 228)">
                    <th width="90%"><font color="#000000"><div>Matapelajaran</div></font></th>
                    <th width="10%"><font color="#000000"><div align="center">Gred</div></font></th>
                </thead>
                <tbody>
			<tr>
				<td>PENGAJIAN AM/KERTAS AM</td>
				<td align="center">
					<?php 
					//$conn->debug=true;
							$s_tahun = $data->fields['stp_tahun_1'];
							$result = get_stp_result2($conn, $data->fields['id_pemohon'], 'A33', $s_tahun, 'B');
							$datas='A33';
							$rsGred->movefirst();
							while(!$rsGred->EOF){ ?>
							<?php if($result['gred']==$rsGred->fields['GRED']){ print $rsGred->fields['GRED']; } ?>	
							<?php $rsGred->movenext(); } $conn->debug=false;?>

				</td>
			</tr>
                    <?php 

                        while(!$rsSTP->EOF){
			//$conn->debug=true;
                        $rsSTPM = $conn->query("SELECT DISKRIPSI FROM $schema1.`ref_matapelajaran` WHERE `TKT`='6' AND `SAH_YT`='Y' AND `GAB_YT`='T' AND kod=".tosql($rsSTP->fields['matapelajaran'])." ORDER BY `DISKRIPSI`");
                    	//$rsSTPM = $conn->query("SELECT * FROM $schema1.`ref_gred_matapelajaran` WHERE `TKT`='6' AND `JENIS`='D' ORDER BY `SUSUNAN`");

			?>
                    <tr>
                        <td><?=$rsSTPM->fields['DISKRIPSI']?></td>
                        <td align="center"><?=$rsSTP->fields['gred']?></td>
                    </tr>
                    <?php $rsSTP->movenext(); } ?>
                </tbody>
            </table>
        </div>
        <div class="col-sm-4" align="center">
            <?php 
                //$conn->debug=true;
                $rsSijil = $conn->query("SELECT * FROM $schema2.`calon_sijil` WHERE `jenis_sijil`='STPM1' AND `id_pemohon`=".tosql($data->fields['id_pemohon']));
                //if(!empty($rsSijil->fields['sijil_nama'])){
                //    print '<h6><b>Sijil STPM</b></h6>';
                //    $sijil = "/upload/".$data->fields['id_pemohon']."/".$rsSijil->fields['sijil_nama']; 
                //}
if(!empty($rsSijil->fields['sijil_nama'])){
	$sijil_pic = "/var/www/upload/".$data->fields['id_pemohon']."/".$rsSijil->fields['sijil_nama']; 
	if (file_exists($sijil_pic)){
		$b64image = base64_encode(file_get_contents($sijil_pic));
		$sijil = "data:image/png;base64,$b64image";
	}
}
		print '<h6><b>Sijil STPM</b></h6>';
            ?>
            <?php if(!empty($rsSijil->fields['sijil_nama'])){  ?>
                <img src="<?=$sijil;?>" width="300" height="350">
            <?php } ?>
        </div>
    </div>
</div>