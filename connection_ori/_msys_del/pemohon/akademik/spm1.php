<?php
    // $conn->debug=true;
    $tahun_spm = $data->fields['spm_tahun_1'];
    $rsSPM = get_spm_result($conn, $id_pemohon, $tahun_spm);

    // $rssijil = $conn->query("SELECT * FROM $schema1.`ref_sijil` WHERE `TKT`='5'");
	$rspangkat = $conn->query("SELECT * FROM $schema1.`ref_sijil_pangkat` WHERE `TKT`=5 ORDER BY `DISKRIPSI`");

    //print $data->fields['spm_jenis_sijil_1'];

    if($data->fields['spm_jenis_sijil_1']=='5'){	
		$rssijil = $conn->query("SELECT * FROM $schema1.`ref_sijil` WHERE `TKT`='5' AND KOD<>5 AND is_aktif=0");
	} else if($data->fields['spm_jenis_sijil_2']=='5'){	
		$rssijil = $conn->query("SELECT * FROM $schema1.`ref_sijil` WHERE `TKT`='5' AND KOD<>5 AND is_aktif=0");
	} else {
		$rssijil = $conn->query("SELECT * FROM $schema1.`ref_sijil` WHERE `TKT`='5' AND is_aktif=0");
	}
?>

<small style="color: red;">
    Tarikh dikemaskini : 
    <?php
    if(!empty($rsSPM->fields['d_kemaskini'])){
        print DisplayDate($rsSPM->fields['d_kemaskini']);  print '&nbsp;&nbsp;'.DisplayMasa($rsSPM->fields['d_kemaskini']);
    } else {
        print DisplayDate($rsSPM->fields['d_cipta']);  print '&nbsp;&nbsp;'.DisplayMasa($rsSPM->fields['d_cipta']);
    }
     ?>  <br>
    Maklumat SPM/SPM(V)/SPVM adalah maklumat akademik peperiksaan peringkat SPM/SPM(V)/SPVM calon.<br><br>
</small>

<div class="form-group">
    <div class="row">
        <label for="nama" class="col-sm-2 control-label"><b>Jenis<div style="float:right">:</div></b></label>
        <div class="col-sm-3">
            <?php while(!$rssijil->EOF){ ?>
                <?php if($rssijil->fields['KOD']==$data->fields['spm_jenis_sijil_1']){ 
                    print $rssijil->fields['DISKRIPSI']; }
                ?>
            <?php $rssijil->movenext(); } ?>
        </div>

        <label for="nama" class="col-sm-2 control-label"><b>Lisan<div style="float:right">:</div></b></label>
        <div class="col-sm-3">
            <?php 
            if($data->fields['spm_lisan_1']=='L'){
                print 'Lulus';
            } else if($data->fields['spm_lisan_1']=='G'){
                print 'Gagal';
            }
            ?>
        </div>
    </div>
</div>
<div class="form-group">
    <div class="row">
        <label for="nama" class="col-sm-2 control-label"><b>Pangkat<div style="float:right">:</div></b></label>
        <div class="col-sm-3">
            <?php while(!$rspangkat->EOF){ ?>
                <?php if($rspangkat->fields['DISKRIPSI']==$data->fields['spm_pangkat_1']){ 
                    print $rspangkat->fields['DISKRIPSI']; }
                ?>
            <?php $rspangkat->movenext(); } ?>
        </div>
        <label for="nama" class="col-sm-2 control-label"><b>Tahun<div style="float:right">:</div></b></label>
        <div class="col-sm-3">
            <?=$data->fields['spm_tahun_1'];?>
        </div>
    </div>
</div>

<hr>

<div class="form-group">
    <div class="row">
        <div class="col-sm-8">
            <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                <thead  style="background-color:rgb(38, 167, 228)">
                    <th width="90%"><font color="#000000"><div>Matapelajaran</div></font></th>
                    <th width="10%"><font color="#000000"><div align="center">Gred</div></font></th>
                </thead>
                <tbody>
                    <?php 

                        while(!$rsSPM->EOF){

                        $rsSRP = $conn->query("SELECT DISKRIPSI FROM $schema1.`ref_matapelajaran` WHERE `TKT`='5' AND `SAH_YT`='Y' AND `GAB_YT`='T' AND kod=".tosql($rsSPM->fields['matapelajaran'])." ORDER BY `DISKRIPSI`");
                    ?>
                    <tr>
                        <td><?=$rsSRP->fields['DISKRIPSI']?></td>
                        <td align="center"><?=$rsSPM->fields['gred']?></td>
                    </tr>

                    <?php $rsSPM->movenext(); } ?>
                </tbody>
            </table>
        </div>
        <div class="col-sm-4" align="center">
            <?php 
                //$conn->debug=true;
                $rsSijil = $conn->query("SELECT * FROM $schema2.`calon_sijil` WHERE `jenis_sijil`='SPM1' AND `id_pemohon`=".tosql($data->fields['id_pemohon']));
                if(empty($rsSijil->fields['sijil_nama'])){ 
                    $sijil="../upload_doc/PMR_Mock_Result_Statement_Certificate.png"; }
                else { 
                    $sijil = "../uploads_doc/".$data->fields['id_pemohon']."/".$rsSijil->fields['sijil_nama']; 
                }
            ?>
            <img src="<?=$sijil;?>" width="300" height="350">
        </div>
    </div>
</div>
