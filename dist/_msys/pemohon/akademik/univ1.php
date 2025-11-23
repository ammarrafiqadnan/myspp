<small style="color: red;">
    Tarikh dikemaskini : 
    <?php
    if(!empty($rsUniv->fields['d_kemaskini'])){
        print DisplayDate($rsUniv->fields['d_kemaskini']);  print '&nbsp;&nbsp;'.DisplayMasa($rsUniv->fields['d_kemaskini']);
    } else {
        print DisplayDate($rsUniv->fields['d_cipta']);  print '&nbsp;&nbsp;'.DisplayMasa($rsUniv->fields['d_cipta']);
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
						<?php print $rsUniv->fields['tahun']; ?>	
					</div>
				</div>
			</div>
			<?php $rfKelulusan = $conn->query("SELECT * FROM `ref_kelayakan` WHERE SAH_YT='Y' ORDER BY `DISKRIPSI`"); ?>
			<div class="form-group">
				<div class="row">
					<label for="nama" class="col-sm-4 control-label"><b>Peringkat Kelulusan <font color="#FF0000">*</font><div style="float:right">:</div></b></label>
					<div class="col-sm-8">
                        <?php while(!$rfKelulusan->EOF){ ?>
                            <?php if($rsUniv->fields['peringkat']==$rfKelulusan->fields['KOD']){ 
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
						<?=$rsUniv->fields['cgpa'];?>
					</div>
				</div>
			</div>

			<?php $rsInstitusi = $conn->query("SELECT * FROM `ref_institusi` WHERE `JENIS_INSTITUSI` IN (1,2) AND `SAH_YT`='Y' AND `STATUS`=0 ORDER BY `DISKRIPSI` ASC "); ?>
			<div class="form-group">
				<div class="row">
					<label for="nama" class="col-sm-4 control-label"><b>Institusi yang mengeluarkan sijil <font color="#FF0000">*</font><div style="float:right">:</div></b></label>
					<div class="col-sm-8">
                        <?php while(!$rsInstitusi->EOF){ ?>
                            <?php if($rsUniv->fields['inst_keluar_sijil']==$rsInstitusi->fields['KOD']){ 
                                print $rsInstitusi->fields['DISKRIPSI']; }
                            ?>
                        <?php $rsInstitusi->movenext(); } ?>
					</div>
				</div>
			</div>

			<?php if(empty($rsUniv->fields['inst_francais'])){ $inst_francais='T'; } else { $inst_francais = $rsUniv->fields['inst_francais']; } ?>
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
			<?php if(empty($rsUniv->fields['bidang'])){ $bidang='S'; } else { $bidang = $rsUniv->fields['bidang']; } ?>
			<div class="form-group">
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
			</div>

			<?php $rsKhusus = $conn->query("SELECT * FROM `ref_pengkhususan` WHERE `JENIS` IN (1,2,3) ORDER BY `DISKRIPSI` ASC "); ?>
			<div class="form-group">
				<div class="row">
					<label for="nama" class="col-sm-4 control-label"><b>Pengkhususan  <font color="#FF0000">*</font><div style="float:right">:</div></b></label>
					<div class="col-sm-8">
							<?php while(!$rsKhusus->EOF){ ?>
							    <?php if($rsUniv->fields['pengkhususan']==$rsKhusus->fields['kod']) { 
                                    print $rsKhusus->fields['DISKRIPSI']; 
                                }
                                ?>
							<?php $rsKhusus->movenext(); } ?>
					</div>
				</div>
			</div>
            <div class="form-group">
				<div class="row">
					<label for="nama" class="col-sm-4 control-label"><b>Keputusan MUET  <div style="float:right">:</div></b></label>
					<div class="col-sm-8">
                        <?php if($rsUniv->fields['muet']=='Band 1'){ print 'Band 1'; }?>
                        <?php if($rsUniv->fields['muet']=='Band 2'){ print 'Band 2'; }?>
                        <?php if($rsUniv->fields['muet']=='Band 3'){ print 'Band 3'; }?>
                        <?php if($rsUniv->fields['muet']=='Band 4'){ print 'Band 4'; }?>
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
                            <?php if($rsUniv->fields['biasiswa']==$rsBiasiswa->fields['kod_biasiswa']){ 
                                print $rsBiasiswa->fields['biasiswa']; }?>
                        <?php $rsBiasiswa->movenext(); } ?>
					</div>
				</div>
			</div>
		</div>

		<div class="col-sm-4" align="center">
			<img src="../upload_doc/PMR_Mock_Result_Statement_Certificate.png" width="300" height="400">
		</div>

	</div>
</div>