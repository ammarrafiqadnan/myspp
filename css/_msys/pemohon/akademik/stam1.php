
<small style="color: red;">
    Tarikh dikemaskini : 
    <?php
    if(!empty($rsUniv->fields['d_kemaskini'])){
        print DisplayDate($rsUniv->fields['d_kemaskini']);  print '&nbsp;&nbsp;'.DisplayMasa($rsUniv->fields['d_kemaskini']);
    } else {
        print DisplayDate($rsUniv->fields['d_cipta']);  print '&nbsp;&nbsp;'.DisplayMasa($rsUniv->fields['d_cipta']);
    }
     ?>  <br>
    Maklumat STAM adalah maklumat akademik peperiksaan peringkat STAM calon.<br><br>
</small>

<div class="form-group">
    <div class="row">
        <label for="nama" class="col-sm-2 control-label"><b>Jenis<div style="float:right">:</div></b></label>
        <div class="col-sm-3">
            <?php while(!$rssijil->EOF){ ?>
                <?php if($rssijil->fields['KOD']==$data->fields['stam_jenis_1']){ 
                    print $rssijil->fields['DISKRIPSI']; }
                ?>
            <?php $rssijil->movenext(); } ?>
        </div>

        <!-- <label for="nama" class="col-sm-2 control-label"><b>Lisan<div style="float:right">:</div></b></label>
        <div class="col-sm-3">
            <?php 
            if($data->fields['stam_lisan_1']=='L'){
                print 'Lulus';
            } else if($data->fields['stam_lisan_1']=='G'){
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
                <?php if($rspangkat->fields['DISKRIPSI']==$data->fields['stam_pangkat_1']){ 
                    print $rspangkat->fields['DISKRIPSI']; }
                ?>
            <?php $rspangkat->movenext(); } ?>
        </div>
        <label for="nama" class="col-sm-2 control-label"><b>Tahun<div style="float:right">:</div></b></label>
        <div class="col-sm-3">
            <?=$data->fields['stam_tahun_1'];?>
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

                        while(!$rsSTAM->EOF){

                        $rsSRP = $conn->query("SELECT DISKRIPSI FROM $schema1.`ref_matapelajaran` WHERE `TKT`='5' AND `SAH_YT`='Y' AND `GAB_YT`='T' AND kod=".tosql($rsSTAM->fields['matapelajaran'])." ORDER BY `DISKRIPSI`");
                    ?>
                    <tr>
                        <td><?=$rsSRP->fields['DISKRIPSI']?></td>
                        <td align="center"><?=$rsSTAM->fields['gred']?></td>
                    </tr>

                    <?php $rsSTAM->movenext(); } ?>
                </tbody>
            </table>
        </div>
        <div class="col-sm-4" align="center">
            <img src="../upload_doc/PMR_Mock_Result_Statement_Certificate.png" width="300" height="350">
        </div>
    </div>
</div>
