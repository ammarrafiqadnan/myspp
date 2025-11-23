<?php
$tahun = $data->fields['srp_tahun'];
$rsPMR = get_pmr_result($conn, $id_pemohon, $tahun);
//print $SPR_lengkap;
?>
<br>
<?php //if($SPR_lengkap == ''){
	//print 'Tiada maklumat yang disimpan';
//} ?>

<small style="color: red;">
    <?php
    if(!empty($rsPMR->fields['d_kemaskini'])){
        print 'Tarikh/masa kemas kini : '.DisplayDate($rsPMR->fields['d_kemaskini']);  print '&nbsp;&nbsp;'.DisplayMasa($rsPMR->fields['d_kemaskini']);
    } else if(!empty($rsPMR->fields['d_cipta'])) {
        print 'Tarikh/masa kemas kini : '.DisplayDate($rsPMR->fields['d_cipta']);  print '&nbsp;&nbsp;'.DisplayMasa($rsPMR->fields['d_cipta']);
    } 
     ?> <br>
</small>

<header class="panel-heading"  style="background-color:rgb(38, 167, 228)">
    <h6 class="panel-title"><font color="#000000" size="3"><b>MAKLUMAT Keputusan Peperiksaan SRP/PMR/PT3</b></font></h6>
</header>
<div class="panel-body">
    <div class="box-body">
        <div class="col-md-12">
		<?php if(!empty($tahun)){ ?>
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
			<label for="nama" class="col-sm-2 control-label"><b>Jenis Sijil <div style="float:right">:</div></b></label>
                    <div class="col-sm-4">
                        	<?php if($data->fields['srp_jenis_sijil']== '1'){ print 'PMR'; } else { print 'SRP'; } ?>
			</div>
                </div>
            </div>
            <?php 
            //$rssijil = $conn->query("SELECT * FROM $schema1.`ref_sijil` WHERE `TKT`='3' AND (".$data->fields['srp_tahun']." BETWEEN tahun_mula AND tahun_akhir)");
            //$conn->debug=true;
		$rssijil = $conn->query("SELECT * FROM $schema1.`ref_sijil` WHERE `TKT`='3'");
		$conn->debug=false;
		$rspangkat = $conn->query("SELECT * FROM $schema1.`ref_sijil_pangkat` WHERE `TKT`=3 ORDER BY `DISKRIPSI`");
            ?>
            <!--<div class="form-group">
                <div class="row">
                    <label for="nama" class="col-sm-2 control-label"><b>Jenis Sijil <div style="float:right">:</div></b></label>
                    <div class="col-sm-4">
                        PMR

                         <select class="form-control" id="srp_jenis_sijil" name="srp_jenis_sijil" onchange="get_spr('srp_jenis_sijil',this.value,'')">
                            <option value="">Sila pilih jenis sijil</option>
                            <?php while(!$rssijil->EOF){ ?>
                            <option value="<?=$rssijil->fields['KOD'];?>" 
                            <?php if($rssijil->fields['KOD']==$data->fields['srp_jenis_sijil']){ print 'selected';} ?>	
                            ><?=$rssijil->fields['DISKRIPSI'];?></option>
                            <?php $rssijil->movenext(); } ?>
                        </select>
                    </div>
                    <div class="col-sm-1"></div>
                    <label for="nama" class="col-sm-2 control-label"><b>Pangkat <div style="float:right">:</div></b></label>
                    <div class="col-sm-3">
                        <?php while(!$rspangkat->EOF){ ?>
                            <?php if($rspangkat->fields['KOD']==$data->fields['srp_pangkat']){ print $rspangkat->fields['DISKRIPSI']; } ?>
                        <?php $rspangkat->movenext(); } ?>


                         <select class="form-control" name="srp_pangkat" id="srp_pangkat" onchange="get_spr('srp_pangkat',this.value,'')">
                            <option value="">Sila pilih pangkat</option>
                            <?php while(!$rspangkat->EOF){ ?>
                            <option><?php if($rspangkat->fields['KOD']==$data->fields['srp_pangkat']){ print $rspangkat->fields['DISKRIPSI']; }?></option>
                            <?php $rspangkat->movenext(); } ?>
                        </select>
                    </div>
                </div>
            </div> -->

            

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
                            if(!empty($rsSijil->fields['sijil_nama'])){
				$sijil_pic = "/var/www/upload/".$data->fields['id_pemohon']."/".$rsSijil->fields['sijil_nama']; 
                                print '<h6><b>Sijil PMR</b></h6>';
                                //$sijil = "/upload/".$data->fields['id_pemohon']."/".$rsSijil->fields['sijil_nama']; 
				if (file_exists($sijil_pic)){
     					$b64image = base64_encode(file_get_contents($sijil_pic));
     					$sijil = "data:image/png;base64,$b64image";	
				} else { 
					//print 'tak jumpa: '.$sijil_pic; 
				}
                            }

                            if(!empty($rsSijil->fields['sijil_nama'])){  ?>
                        <img src="<?=$sijil;?>" width="300" height="350">
                        <?php } ?>
                    </div>
                </div>
            </div>
	<?php } else {
                        print '-- Tiada Maklumat --';
                }?>

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
