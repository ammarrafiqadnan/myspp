<?php
    $tahun_stp = $data->fields['stp_tahun_1'];
    $rsSTP = get_stp_result($conn, $id_pemohon, $tahun_stp);

    $rssijil = $conn->query("SELECT * FROM $schema1.`ref_sijil` WHERE `TKT`='6'");
	$rspangkat = $conn->query("SELECT * FROM $schema1.`ref_sijil_pangkat` WHERE `TKT`=6 ORDER BY `DISKRIPSI`");
?>
 

    <small style="color: red;">
        Tarikh dikemaskini : 
        <?php
        if(!empty($rsSTP->fields['d_kemaskini'])){
            print DisplayDate($rsSTP->fields['d_kemaskini']);  print '&nbsp;&nbsp;'.DisplayMasa($rsSTP->fields['d_kemaskini']);
        } else {
            print DisplayDate($rsSTP->fields['d_cipta']);  print '&nbsp;&nbsp;'.DisplayMasa($rsSTP->fields['d_cipta']);
        }
        ?>  <br>
        Maklumat STPM adalah maklumat akademik peperiksaan peringkat STPM calon.<br><br>
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
    <div class="form-group">
        <div class="row">
            <label for="nama" class="col-sm-2 control-label"><b>Pangkat<div style="float:right">:</div></b></label>
            <div class="col-sm-3">
                <?php while(!$rspangkat->EOF){ ?>
                    <?php if($rspangkat->fields['DISKRIPSI']==$data->fields['stp_pangkat_1']){ 
                        print $rspangkat->fields['DISKRIPSI']; }
                    ?>
                <?php $rspangkat->movenext(); } ?>
            </div>
            <label for="nama" class="col-sm-2 control-label"><b>Tahun<div style="float:right">:</div></b></label>
            <div class="col-sm-3">
                <?=$data->fields['stp_tahun_1'];?>
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

                        $rsSRP = $conn->query("SELECT DISKRIPSI FROM $schema1.`ref_matapelajaran` WHERE `TKT`='6' AND `SAH_YT`='Y' AND `GAB_YT`='T' AND kod=".tosql($rsSPM->fields['matapelajaran'])." ORDER BY `DISKRIPSI`");
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
            <img src="../upload_doc/PMR_Mock_Result_Statement_Certificate.png" width="300" height="350">
        </div>
    </div>
</div>