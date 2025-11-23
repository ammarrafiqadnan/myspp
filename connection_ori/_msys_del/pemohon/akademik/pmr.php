<?php
$tahun = $data->fields['srp_tahun'];
$rsPMR = get_pmr_result($conn, $id_pemohon, $tahun);
print $SPR_lengkap;
?>
<br>
<small style="color: red;">
    Tarikh dikemaskini : 
    <?php
    if(!empty($rsPMR->fields['d_kemaskini'])){
        print DisplayDate($rsPMR->fields['d_kemaskini']);  print '&nbsp;&nbsp;'.DisplayMasa($rsPMR->fields['d_kemaskini']);
    } else {
        print DisplayDate($rsPMR->fields['d_cipta']);  print '&nbsp;&nbsp;'.DisplayMasa($rsPMR->fields['d_cipta']);
    }
     ?> <br>
    Maklumat PT3/PMR/SRP/LCE adalah maklumat akademik peperiksaan peringkat PT3/PMR/SRP/LCE calon.<br><br>
</small>

<header class="panel-heading"  style="background-color:rgb(38, 167, 228)">
    <h6 class="panel-title"><font color="#000000" size="3"><b>MAKLUMAT Keputusan Peperiksaan PT3/PMR calon</b></font></h6>
</header>
<div class="panel-body">
    <div class="box-body">
        <div class="col-md-12">

            <div class="form-group">
                <div class="row">
                    <label for="nama" class="col-sm-2 control-label"><b>Tahun <div style="float:right">:</div></b></label>
                    <div class="col-sm-3">
                        <?=$data->fields['srp_tahun'];?>
                        <!-- <select name="srp_tahun" id="srp_tahun" class="form-control" onchange="get_spr('srp_tahun',this.value,'R')">
                            <option value="">Sila pilih tahun</option>
                            <?php for($t=date("Y");$t>=1985;$t--){
                                print '<option value="'.$t.'"'; 
                                if($data->fields['srp_tahun']==$t){ print 'selected'; }
                                print '>'.$t.'</option>';
                            } ?>
                        </select> -->
                    </div>
                </div>
            </div>
            <?php 
            $rssijil = $conn->query("SELECT * FROM $schema1.`ref_sijil` WHERE `TKT`='3' AND (".$data->fields['srp_tahun']." BETWEEN tahun_mula AND tahun_akhir)");
            $rspangkat = $conn->query("SELECT * FROM $schema1.`ref_sijil_pangkat` WHERE `TKT`=3 ORDER BY `DISKRIPSI`");
            ?>
            <div class="form-group">
                <div class="row">
                    <label for="nama" class="col-sm-2 control-label"><b>Jenis Sijil <div style="float:right">:</div></b></label>
                    <div class="col-sm-4">
                        <?php while(!$rssijil->EOF){ ?>
                            <?php if($rssijil->fields['KOD']==$data->fields['srp_jenis_sijil']){ print $rssijil->fields['DISKRIPSI']; };?>
                        <?php $rssijil->movenext(); } ?>


                        <!-- <select class="form-control" id="srp_jenis_sijil" name="srp_jenis_sijil" onchange="get_spr('srp_jenis_sijil',this.value,'')">
                            <option value="">Sila pilih jenis sijil</option>
                            <?php while(!$rssijil->EOF){ ?>
                            <option value="<?=$rssijil->fields['KOD'];?>" 
                            <?php if($rssijil->fields['KOD']==$data->fields['srp_jenis_sijil']){ print 'selected';} ?>	
                            ><?=$rssijil->fields['DISKRIPSI'];?></option>
                            <?php $rssijil->movenext(); } ?>
                        </select> -->
                    </div>
                    <div class="col-sm-1"></div>
                    <label for="nama" class="col-sm-2 control-label"><b>Pangkat <div style="float:right">:</div></b></label>
                    <div class="col-sm-3">
                        <?php while(!$rspangkat->EOF){ ?>
                            <?php if($rspangkat->fields['KOD']==$data->fields['srp_pangkat']){ print $rspangkat->fields['DISKRIPSI']; } ?>
                        <?php $rspangkat->movenext(); } ?>


                        <!-- <select class="form-control" name="srp_pangkat" id="srp_pangkat" onchange="get_spr('srp_pangkat',this.value,'')">
                            <option value="">Sila pilih pangkat</option>
                            <?php while(!$rspangkat->EOF){ ?>
                            <option><?php if($rspangkat->fields['KOD']==$data->fields['srp_pangkat']){ print $rspangkat->fields['DISKRIPSI']; }?></option>
                            <?php $rspangkat->movenext(); } ?>
                        </select> -->
                    </div>
                </div>
            </div>

            

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

                                    while(!$rsPMR->EOF){

                                    $rsSRP = $conn->query("SELECT DISKRIPSI FROM $schema1.`ref_matapelajaran` WHERE `TKT`='3' AND `SAH_YT`='Y' AND `GAB_YT`='T' AND kod=".tosql($rsPMR->fields['matapelajaran'])." ORDER BY `DISKRIPSI`");
                                ?>
                                <tr>
                                    <td><?=$rsSRP->fields['DISKRIPSI']?></td>
                                    <td align="center"><?=$rsPMR->fields['gred']?></td>
                                </tr>

                                <?php $rsPMR->movenext(); } ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-sm-4" align="center">
                        
                        <?php 
                            //$conn->debug=true;
                            $rsSijil = $conn->query("SELECT * FROM $schema2.`calon_sijil` WHERE `jenis_sijil`='PMR' AND `id_pemohon`=".tosql($data->fields['id_pemohon']));
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
        </div>
    </div>
</div>	 
