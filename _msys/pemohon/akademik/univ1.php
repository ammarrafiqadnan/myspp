<?php if(!empty($rsUniv->fields['d_cipta'])) { ?>
<small style="color: red;">
    Tarikh/masa kemas kini : 
    <?php
    if(!empty($rsUniv->fields['d_kemaskini'])){
        print DisplayDate($rsUniv->fields['d_kemaskini']);  print '&nbsp;&nbsp;'.DisplayMasa($rsUniv->fields['d_kemaskini']);
    } else {
        print DisplayDate($rsUniv->fields['d_cipta']);  print '&nbsp;&nbsp;'.DisplayMasa($rsUniv->fields['d_cipta']);
    }
     ?>
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
			<div class="form-group">
				<div class="row">
					<label for="nama" class="col-sm-4 control-label"><b>Tarikh Kelulusan <font color="#FF0000">*</font>
						<div style="float:right"> :</div></b></label>
					<div class="col-sm-3"><?php print date('d-m-Y',strtotime($rsUniv->fields['tkh_senate']));?>
					</div>
				</div>
			</div>
			<?php $rfKelulusan = $conn->query("SELECT * FROM $schema1.`ref_peringkat_kelulusan` WHERE is_deleted=0 ORDER BY `diskripsi`"); ?>
			<div class="form-group">
				<div class="row">
					<label for="nama" class="col-sm-4 control-label"><b>Peringkat Kelulusan <font color="#FF0000">*</font><div style="float:right">:</div></b></label>
					<div class="col-sm-8">
                        <?php while(!$rfKelulusan->EOF){ ?>
                            <?php if($rsUniv->fields['peringkat']==$rfKelulusan->fields['kod']){ 
                                print $rfKelulusan->fields['diskripsi']; }
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

			<?php $rsInstitusi = $conn->query("SELECT * FROM $schema1.`ref_institusi` WHERE `JENIS_INSTITUSI` IN (1,2) AND `SAH_YT`='Y' AND `STATUS`=0 ORDER BY `DISKRIPSI` ASC "); ?>
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

			<?php //$rsKhusus = $conn->query("SELECT * FROM $schema1.`ref_pengkhususan` WHERE `STATUS`=0 AND is_deleted=0");
				
				$peringkats = $rsUniv->fields['peringkat'];
				$query ="SELECT A.`kod`, B.`DISKRIPSI` FROM $schema1.`padanan_institusi_pengkhususan` A, $schema1.`ref_pengkhususan` B 
				WHERE A.`kod_pengkhususan`=B.`kod` AND A.`kod_institusi`=".tosql($rsUniv->fields['inst_keluar_sijil'])." 
				AND A.status=0 AND B.STATUS=0 AND B.is_deleted=0 ";  
				if($peringkats == '1' || $peringkats == '3' || $peringkats == '5'){
					$query .= " AND A.kategori=1";
					if($peringkats == '1'){
						$query .= " AND A.peringkat_kelulusan=1";
					} else if($peringkats == '3'){
						$query .= " AND A.peringkat_kelulusan=2";
					}  else if($peringkats == '5'){
						$query .= " AND A.peringkat_kelulusan=3";
					}
				} else if($peringkats == '2' || $peringkats == '4' || $peringkats == '6' || $peringkats == '7'){
					$query .= " AND A.kategori=2";

					if($peringkats == '2'){
						$query .= " AND A.peringkat_kelulusan=1";
					} else if($peringkats == '4'){
						$query .= " AND A.peringkat_kelulusan=2";
					}  else if($peringkats == '6'){
						$query .= " AND A.peringkat_kelulusan=3";
					}  else if($peringkats == '7'){
						$query .= " AND A.peringkat_kelulusan=4";
					}
				}
				$query .= " ORDER BY B.`DISKRIPSI`";
				//print $query;
				$rsKhusus = $conn->query($query);


			 ?>
			<div class="form-group">
				<div class="row">
					<label for="nama" class="col-sm-4 control-label"><b>Nama Sijil  <font color="#FF0000">*</font><div style="float:right">:</div></b></label>
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
			<?php 
				$rfMajor = $conn->query("SELECT * FROM $schema1.`ref_major` ");
			 ?>
			<div class="form-group">
				<div class="row">
					<label for="nama" class="col-sm-4 control-label"><b>Major <div style="float:right">:</div></b></label>
					<div class="col-sm-8">
							<?php while(!$rfMajor->EOF){ ?>
                            <?php if( $rfMajor->fields['KOD'] == $rsUniv->fields['MAJOR'] ){ 
                                print $rfMajor->fields['DISKRIPSI']; 
							}
                            ?>
                        <?php $rfMajor->movenext(); } ?>
					</div>
				</div>
			</div>
			<?php 
				$rfMinor = $conn->query("SELECT * FROM $schema1.`ref_minor` ");
			 ?>
			<div class="form-group">
				<div class="row">
					<label for="nama" class="col-sm-4 control-label"><b>Minor <div style="float:right">:</div></b></label>
					<div class="col-sm-8">
							<?php while(!$rfMinor->EOF){ ?>
                            <?php if( $rfMinor->fields['KOD'] == $rsUniv->fields['MINOR'] ){ 
                                print $rfMinor->fields['DISKRIPSI']; 
							}
                            ?>
                        <?php $rfMinor->movenext(); } ?>
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="row">
					<label for="nama" class="col-sm-12 control-label"><b>Keputusan Penguasaan Bahasa Inggeris</b> 
						<a href="../view_doc3.php"  data-toggle="modal" data-target="#myModal">
                    		<i class="fa fa-info-circle" aria-hidden="true"></i>
                		</a>

					</label>
				</div>
			</div>
            		<div class="form-group">
				<div class="row">
					<label for="nama" class="col-sm-4 control-label"><b>Jenis Peperiksaan</b><div style="float:right">:</div></label>

					<?php
					//$conn->debug=true;
    				$sql3 = "SELECT * FROM $schema1.`ref_jenis_peperiksaanBI` WHERE `status`=0 AND `is_deleted`=0";
    				$rsJP = $conn->query($sql3);
        			?>
					<div class="col-sm-8">
        					<?php while(!$rsJP->EOF){ $code = $rsJP->fields['kod']; ?>    
            					<?php if($rsUniv->fields['muet']==$code){ print $rsJP->fields['diskripsi']; }?>
        					<?php $rsJP->movenext(); } ?>

					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="row">
					<label for="nama" class="col-sm-4 control-label"><b>Tahun</b><div style="float:right">:</div></label>
					<div class="col-sm-4">
						<?php $d = date("Y");?>
						<?php for($i=$d; $i>='1999'; $i--){ ?>
                   					<?php if($rsUniv->fields['muet_tahun']==$i){ print $i; }?>                    				<?php } ?>					
					</div>
				</div>
			</div>

			<div class="form-group">
				<div class="row">

					<label for="nama" class="col-sm-4 control-label"><b>Keputusan BAND/TAHAP CEFR</b><div style="float:right">:</div></label>
					<?php
					$sql3 = "SELECT * FROM $schema1.padanan_jenisPeperiksaan_keputusan WHERE kod_jenis_peperiksaan=".tosql($rsUniv->fields['muet']);
    				$rsJK = $conn->query($sql3);
        			?>

					<div class="col-sm-7">
							<?php while(!$rsJK->EOF){ 
								$code = $rsJK->fields['kod']; 
								$kep = '';
								if(!empty($rsJK->fields['band'])){ $kep = $rsJK->fields['band']; }
								if(!empty($rsJK->fields['gred'])){ 
									if(!empty($kep)){ $kep .= " / "; }
									$kep .= $rsJK->fields['gred']; 
								}
								if(!empty($rsJK->fields['cefr'])){ 
									if(!empty($kep)){ $kep .= " / "; } 
									$kep .= $rsJK->fields['cefr']; 
								}
							?>    
            						<?php if($rsUniv->fields['muet_gred']==$code){ print $kep; }?>
        					<?php $rsJK->movenext(); } ?>
					</div>

					
				</div>
			</div>
			<div class="form-group">
				<div class="row">
					<label for="nama" class="col-sm-12 control-label"><b>Salah satu biasiswa yang diperolehi bagi salah satu pengajian di atas:</b></label>
				</div>
			</div>

			<?php $rsBiasiswa = $conn->query("SELECT * FROM $schema1.`ref_biasiswa` WHERE 1 ORDER BY `kod_biasiswa` ASC "); ?>
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

		<?php
		$rsSijil = $conn->query("SELECT * FROM $schema2.`calon_sijil` WHERE `jenis_sijil`='UNIV1A' AND `id_pemohon`=".tosql($uid));
		//if(empty($rsSijil->fields['sijil_nama'])){ $sijil1="../upload_doc/sijil_diploma.jpg"; }
		//else { $sijil1 = "/upload/".$uid."/".$rsSijil->fields['sijil_nama']; }
		if(empty($rsSijil->fields['sijil_nama'])){ $sijil_pic1 ="/var/www/myspp/upload_doc/sijil_diploma.jpg"; }
		else { $sijil_pic1 = "/var/www/upload/".$uid."/".$rsSijil->fields['sijil_nama']; }
 		//print $sijil;
		if (file_exists($sijil_pic1)){
    			$b64image = base64_encode(file_get_contents($sijil_pic1));
     			$sijil1 = "data:image/png;base64,$b64image";
		}


		$rsSijil2 = $conn->query("SELECT * FROM $schema2.`calon_sijil` WHERE `jenis_sijil`='UNIV1B' AND `id_pemohon`=".tosql($uid));
		//if(empty($rsSijil2->fields['sijil_nama'])){ $sijil2 ="../upload_doc/sijil_muet.jpgg"; }
		//else { $sijil2 = "/upload/".$uid."/".$rsSijil->fields['sijil_nama']; }
		if(empty($rsSijil2->fields['sijil_nama'])){ $sijil_pic2 ="/var/www/myspp/upload_doc/sijil_muet.jpg"; }
		else { $sijil_pic2 = "/var/www/upload/".$uid."/".$rsSijil2->fields['sijil_nama']; }
 		//print $sijil;
		if (file_exists($sijil_pic2)){
		     $b64image = base64_encode(file_get_contents($sijil_pic2));
		     $sijil2 = "data:image/png;base64,$b64image";
		}


		$rsSijil31 = $conn->query("SELECT * FROM $schema2.`calon_sijil` WHERE `jenis_sijil`='UNIV1C' AND `id_pemohon`=".tosql($uid));
		$sijil_pic3 = "/var/www/upload/".$uid."/".$rsSijil31->fields['sijil_nama'];
		?>
		<div class="col-sm-4" align="center">
			<h6><b>Sijil Pengajian Tinggi</b></h6>
			<img src="<?=$sijil1;?>" width="300" height="400">
			
			<?php if (file_exists($sijil_pic1)){ print "<br><div>".$rsSijil->fields['sijil_nama']."</div>"; } ?>
		</div>

		<div class="col-sm-4" align="center"><br></div>

		<div class="col-sm-4" align="center">
			<h6><b>Transkrip Pengajian Tinggi</b></h6>
			<?php if(empty($rsSijil31->fields['sijil_nama'])){ 
				print "Tiada Sijil Dimuat Naik"; 
			} else { 
				if (file_exists($sijil_pic3)){
				?>
				<!--<a href="../view_doc_pemohon.php?id_pemohon=<?=$uid;?>&doc=<?=$rsSijil31->fields['sijil_nama'];?>" data-toggle="modal" data-target="#myModal">.</a>-->
				<a href="../view_doc_pemohon.php?id_pemohon=<?=$uid;?>&doc=<?=$rsSijil31->fields['sijil_nama'];?>" target="_blank" 
				onclick="return popitup('../view_doc_pemohon.php?id_pemohon=<?=$uid;?>&doc=<?=$rsSijil31->fields['sijil_nama'];?>')"><?=$rsSijil31->fields['sijil_nama'];?></a> 
			<?php } else { print "Tiada Sijil Dimuat Naik"; } ?>
			<?php } ?>
		</div>

		<div class="col-sm-4" align="center"><br></div>

		<div class="col-sm-4" align="center">
			<h6><b>Sijil Penguasaan Bahasa Inggeris</b></h6>
			<img src="<?=$sijil2;?>" width="300" height="400">
			
			<?php if (file_exists($sijil_pic2)){ print "<br><div>".$rsSijil->fields['sijil_nama']."</div>"; } ?>
		</div>


	</div>
</div>

<?php } else { 
	print '-- Tiada Maklumat --';
	
} ?>

	     
<!--<div class="form-group">
	    	<div class="row">
                	<div class="col-md-12">
                    		<a type="button" class="btn btn-success" href="index.php?data=<?php print base64_encode('pemohon/senarai_pemohon;Senarai Pemohon;;;;;'); ?>"><i class="fa fa-arrow-left" style="margin:0px;"></i> Kembali</a>
                	</div>
		</div>
            </div>-->
