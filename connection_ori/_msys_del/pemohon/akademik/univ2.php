<small style="color: red;">
    Tarikh dikemaskini : 
    <?php
    if(!empty($rsUniv2->fields['d_kemaskini'])){
        print DisplayDate($rsUniv2->fields['d_kemaskini']);  print '&nbsp;&nbsp;'.DisplayMasa($rsUniv2->fields['d_kemaskini']);
    } else {
        print DisplayDate($rsUniv2->fields['d_cipta']);  print '&nbsp;&nbsp;'.DisplayMasa($rsUniv2->fields['d_cipta']);
    }
     ?>  <br>
    Maklumat Pengajian Tinggi adalah maklumat akademik peperiksaan peringkat Pengajian Tinggi calon.<br><br>
</small>

<div class="form-group">
	<div class="row">
		<div class="col-sm-8">
			<div class="form-group">
				<div class="row">
					<label for="nama" class="col-sm-4 control-label"><b>Tahun Graduasi<font color="#FF0000">*</font><div style="float:right">:</div></b></label>
					<div class="col-sm-3">
						<?php print $rsUniv2->fields['tahun']; ?>	
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="row">
					<label for="nama" class="col-sm-4 control-label"><b>Tarikh Kelulusan <font color="#FF0000">*</font>
						<div style="float:right"> :</div></b></label>
					<div class="col-sm-3"><?php print $rsUniv->fields['tkh_senate'];?>
					</div>
				</div>
			</div>
			<?php $rfKelulusan = $conn->query("SELECT * FROM `ref_kelayakan` WHERE SAH_YT='Y' ORDER BY `DISKRIPSI`"); ?>
			<div class="form-group">
				<div class="row">
					<label for="nama" class="col-sm-4 control-label"><b>Peringkat Kelulusan <font color="#FF0000">*</font><div style="float:right">:</div></b></label>
					<div class="col-sm-8">
                        <?php while(!$rfKelulusan->EOF){ ?>
                            <?php if($rsUniv2->fields['peringkat']==$rfKelulusan->fields['KOD']){ 
                                print $rfKelulusan->fields['DISKRIPSI']; }
                            ?>
                        <?php $rfKelulusan->movenext(); } ?>
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="row">
					<label for="nama" class="col-sm-4 control-label"><b>CGPA (PNGK) <div style="float:right">:</div></b></label>
					<div class="col-sm-2">
						<?=$rsUniv2->fields['cgpa'];?>
					</div>
				</div>
			</div>

			<?php $rsInstitusi = $conn->query("SELECT * FROM `ref_institusi` WHERE `JENIS_INSTITUSI` IN (1,2) AND `SAH_YT`='Y' AND `STATUS`=0 ORDER BY `DISKRIPSI` ASC "); ?>
			<div class="form-group">
				<div class="row">
					<label for="nama" class="col-sm-4 control-label"><b>Institusi yang mengeluarkan sijil <font color="#FF0000">*</font><div style="float:right">:</div></b></label>
					<div class="col-sm-8">
                        <?php while(!$rsInstitusi->EOF){ ?>
                            <?php if($rsUniv2->fields['inst_keluar_sijil']==$rsInstitusi->fields['KOD']){ 
                                print $rsInstitusi->fields['DISKRIPSI']; }
                            ?>
                        <?php $rsInstitusi->movenext(); } ?>
					</div>
				</div>
			</div>

			<?php if(empty($rsUniv2->fields['inst_francais'])){ $inst_francais='T'; } else { $inst_francais = $rsUniv2->fields['inst_francais']; } ?>
			<div class="form-group">
				<div class="row">
					<label for="nama" class="col-sm-4 control-label"><b>Institusi Francais Luar Negara <font color="#FF0000">*</font><div style="float:right">:</div></b></label>
					<div class="col-sm-8">
						<?php 
                            if($inst_francais=='Y'){ 
                                print 'YA'; 
                            } else if($inst_francais=='T'){ 
                                print 'TIDAK'; 
                            }   
                        ?>  
					</div>
				</div>
			</div>
			<?php if(empty($rsUniv2->fields['bidang'])){ $bidang='S'; } else { $bidang = $rsUniv2->fields['bidang']; } ?>
			<!-- <div class="form-group">
				<div class="row">
					<label for="nama" class="col-sm-4 control-label"><b>Bidang pengkhususan <font color="#FF0000">*</font><div style="float:right">:</div></b></label>
					<div class="col-sm-8">
						<?php 
                            if($bidang=='P'){ print 'Pendidikan'; 
                            } else if($bidang=='B'){ print 'Bukan Pendidikan'; 
                            } else if($bidang=='S'){ print 'Semua'; }
                        ?>
					</div>
				</div>
			</div> -->

			<?php $rsKhusus = $conn->query("SELECT * FROM `ref_pengkhususan` WHERE `JENIS` IN (1,2,3) ORDER BY `DISKRIPSI` ASC "); ?>
			<div class="form-group">
				<div class="row">
					<label for="nama" class="col-sm-4 control-label"><b>Nama Sijil  <font color="#FF0000">*</font><div style="float:right">:</div></b></label>
					<div class="col-sm-8">
							<?php while(!$rsKhusus->EOF){ ?>
							    <?php if($rsUniv2->fields['pengkhususan']==$rsKhusus->fields['kod']) { 
                                    print $rsKhusus->fields['DISKRIPSI']; 
                                }
                                ?>
							<?php $rsKhusus->movenext(); } ?>
					</div>
				</div>
			</div>
            <div class="form-group">
				<div class="row">
					<label for="nama" class="col-sm-4 control-label"><b>Keputusan MUET/CFER/Setaraf  <div style="float:right">:</div></b></label>
					<div class="col-sm-8">
                        <?php if($rsUniv2->fields['muet']=='Band 1'){ print 'Band 1'; }?>
                        <?php if($rsUniv2->fields['muet']=='Band 2'){ print 'Band 2'; }?>
                        <?php if($rsUniv2->fields['muet']=='Band 3'){ print 'Band 3'; }?>
                        <?php if($rsUniv2->fields['muet']=='Band 4'){ print 'Band 4'; }?>
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="row">
					<label for="nama" class="col-sm-12 control-label"><b>Salah satu biasiswa yang diperolehi bagi salah satu pengajian di atas:</b></label>
				</div>
			</div>

			<?php $rsBiasiswa = $conn->query("SELECT * FROM `ref_biasiswa` WHERE 1 ORDER BY `kod_biasiswa` ASC "); ?>
			<div class="form-group">
				<div class="row">
					<label for="nama" class="col-sm-4 control-label"><b>Biasiswa Pengajian  <div style="float:right">:</div></b></label>
					<div class="col-sm-8">
                        <?php while(!$rsBiasiswa->EOF){ ?>
                            <?php if($rsUniv2->fields['biasiswa']==$rsBiasiswa->fields['kod_biasiswa']){ 
                                print $rsBiasiswa->fields['biasiswa']; }?>
                        <?php $rsBiasiswa->movenext(); } ?>
					</div>
				</div>
			</div>
		</div>

		<?php
		$rsSijil = $conn->query("SELECT * FROM $schema2.`calon_sijil` WHERE `jenis_sijil`='UNIV2A' AND `id_pemohon`=".tosql($data->fields['id_pemohon']));
		if(empty($rsSijil->fields['sijil_nama'])){ $sijil="../upload_doc/PMR_Mock_Result_Statement_Certificate.png"; }
		else { $sijil1 = "../uploads_doc/".$data->fields['id_pemohon']."/".$rsSijil->fields['sijil_nama']; }
		$rsSijil = $conn->query("SELECT * FROM $schema2.`calon_sijil` WHERE `jenis_sijil`='UNIV2B' AND `id_pemohon`=".tosql($data->fields['id_pemohon']));
		if(empty($rsSijil->fields['sijil_nama'])){ $sijil="../upload_doc/PMR_Mock_Result_Statement_Certificate.png"; }
		else { $sijil2 = "../uploads_doc/".$data->fields['id_pemohon']."/".$rsSijil->fields['sijil_nama']; }
		?>
		<div class="col-sm-4" align="center">
			<img src="<?=$sijil1;?>" width="300" height="400">
		</div>

		<div class="col-sm-4" align="center"><br></div>

		<div class="col-sm-4" align="center">
			<img src="<?=$sijil2;?>" width="300" height="400">
		</div>

	</div>
</div>