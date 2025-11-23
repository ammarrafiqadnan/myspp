<?php
    // $conn->debug=true;
    $rsSPMtambahan = $conn->query("SELECT * FROM $schema2.`calon_spm` WHERE `jenis_xm`='T' AND `id_pemohon`=".tosql($data->fields['id_pemohon']));

    $count = $conn->query("SELECT COUNT(*) as total FROM $schema2.`calon_spm` WHERE `jenis_xm`='T' AND `id_pemohon`=".tosql($data->fields['id_pemohon']));

    print $SPM_tambahan;

    if(($count->fields['total'] != 0)){ ?>

<small style="color: red;">
    Tarikh dikemaskini : 
    <?php
    if(($count->fields['total'] != 0)){
        if(!empty($rsSPMtambahan->fields['d_kemaskini'])){
            print DisplayDate($rsSPMtambahan->fields['d_kemaskini']);  print '&nbsp;&nbsp;'.DisplayMasa($rsSPMtambahan->fields['d_kemaskini']);
        } else {
            print DisplayDate($rsSPMtambahan->fields['d_cipta']);  print '&nbsp;&nbsp;'.DisplayMasa($rsSPMtambahan->fields['d_cipta']);
        }
    }

     ?> <br>
    Maklumat Peperiksaan Tambahan adalah maklumat akademik Peperiksaan Bahasa Melayu, Matematik, Sejarah bagi Peperiksaan Julai sahaja bagi calon.<br><br>
</small>
<?php } ?>

<header class="panel-heading"  style="background-color:rgb(38, 167, 228)">
    <h6 class="panel-title"><font color="#000000" size="3"><b>MAKLUMAT Keputusan Peperiksaan Tambahan calon</b></font></h6>
</header>
<div class="panel-body">
    <div class="box-body">
        <div class="col-md-12">

            <div class="form-group">
                <div class="row">
                    <div class="col-sm-12">
                        
                        <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                            <thead  style="background-color:rgb(38, 167, 228)">
                                <th width="90%"><font color="#000000"><div>Matapelajaran</div></font></th>
                                <th width="10%"><font color="#000000"><div align="center">Gred</div></font></th>
                            </thead>
                            <tbody>
                                <?php 
                                    if(($count->fields['total'] != 0)){
                                    while(!$rsSPMtambahan->EOF){

                                    $rsSRP = $conn->query("SELECT DISKRIPSI FROM $schema1.`ref_matapelajaran` WHERE `TKT`='5' AND `SAH_YT`='Y' AND `GAB_YT`='T' AND kod=".tosql($rsSPMtambahan->fields['matapelajaran'])." ORDER BY `DISKRIPSI`");
                                ?>
                                <tr>
                                    <td><?=$rsSRP->fields['DISKRIPSI']?></td>
                                    <td align="center"><?=$rsSPMtambahan->fields['gred']?></td>
                                </tr>

                                <?php $rsSPMtambahan->movenext(); } 
                                 } else { ?>
                                    <tr>
                                        <td colspan="2">-- Tiada Maklumat --</td>
                                    </tr>
                                <?php }?>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-sm-4" align="center">
                        <?php  if(($count->fields['total'] != 0)){
                            //$conn->debug=true;
                            $rsSijil = $conn->query("SELECT * FROM $schema2.`calon_sijil` WHERE `jenis_sijil`='EXT' AND `id_pemohon`=".tosql($data->fields['id_pemohon']));
                            if(empty($rsSijil->fields['sijil_nama'])){ 
                                $sijil="../upload_doc/PMR_Mock_Result_Statement_Certificate.png"; }
                            else { 
                                $sijil = "../uploads_doc/".$data->fields['id_pemohon']."/".$rsSijil->fields['sijil_nama']; 
                            }
                        ?>
                        <img src="<?=$sijil;?>" width="300" height="350">
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>	 
