<?php
if(empty($pages)){ $pages='dashboard/dashboard_utama'; } 
// $jumnotis = dlookup("tbl_notis","count(*)","is_read=0 AND id_user=".tosql($_SESSION['SESS_UID']));
$is_awam = dlookup("$schema2.`calon`","masih_khidmat","`id_pemohon`=".tosql($_SESSION['SESS_UID']));
?>

			<div class="inner-wrapper">
				<!-- start: sidebar -->
				<aside id="sidebar-left" class="sidebar-left" style="background-image: linear-gradient(to right, rgb(38, 167, 228), rgb(96 92 92)); background-color: #131416;" background-color: #131416;">

					<div class="sidebar-header">
						<div class="sidebar-title">
							<font color="white"><b>MENU SISTEM</b></font>
						</div>
						<div class="sidebar-toggle hidden-xs" data-toggle-class="sidebar-left-collapsed" data-target="html" data-fire-event="sidebar-left-toggle">
							<i class="fa fa-bars" aria-label="Toggle sidebar"></i>
						</div>
					</div>
					<?php //print $module; ?>
					<div class="nano">
						<div class="nano-content">
							<nav id="menu" class="nav-main" role="navigation" style="color:white">
								<ul class="nav nav-main">

									<?php
										$sql = "SELECT COUNT(*) as total FROM $schema2.`menu_pemohon` WHERE is_deleted=0 AND `status`=0"; 
										$sql .=" AND keterangan LIKE '%DASHBOARD%'" ;
										$rsMenu = $conn->query($sql);
									?>
									<?php if($rsMenu->fields['total'] > 0){ ?>
									<li class="<?php if($module=='DASHBOARD'){ print ' nav-expanded nav-active'; }?>">
										<a href="index.php">
											<i class="fa fa-home" aria-hidden="true"></i>
											<span >DASHBOARD </span>
										</a>
									</li>
									<?php } ?>
									<!-- <li <?php if($pages=='notis/notis_list'){ print 'class="nav-expanded nav-active"';}?>>
										<a href="index.php?data=<?php print base64_encode('notis/notis_list;NOTIS;Maklumat Notis;;;;'); ?>">
											<?php if(!empty($jumnotis)){ ?>
												<span class="pull-right label label-primary"><?=$jumnotis;?> Notis Baru</span>
											<?php } ?>
											<i class="fa fa-envelope" aria-hidden="true"></i>
											<span>Notis</span>
										</a>
									</li> -->
									<?php
										$sql = "SELECT COUNT(*) as total FROM $schema2.`menu_pemohon` WHERE is_deleted=0 AND `status`=0"; 
										$sql .=" AND keterangan LIKE '%MAKLUMAT PEMOHON%'" ;
										$rsMenu = $conn->query($sql);
									?>
									<?php if($rsMenu->fields['total'] > 0){ ?>
									<li class="<?php if($module=='MAKLUMAT PEMOHON'){ print ' nav-expanded nav-active'; }?>">
										<a href="index.php?data=<?php print base64_encode('biodata/biodata;MAKLUMAT PEMOHON;;;;;'); ?>">
											<i class="fa fa-envelope" aria-hidden="true"></i>
											<span>MAKLUMAT PEMOHON</span>
										</a>
									</li>
									<?php } ?>
									<?php
										$sql = "SELECT COUNT(*) as total FROM $schema2.`menu_pemohon` WHERE is_deleted=0 AND `status`=0"; 
										$sql .=" AND keterangan LIKE '%PEGAWAI SEDANG BERKHIDMAT%'" ;
										$rsMenu = $conn->query($sql);
									?>
									<?php if($rsMenu->fields['total'] > 0){ ?>
									<?php if($is_awam=='Y'){ ?>
									<li class="<?php if($module=='PEGAWAI SEDANG BERKHIDMAT'){ print ' nav-expanded nav-active'; }?>">
										<a href="index.php?data=<?php print base64_encode('biodata/khidmat;PEGAWAI SEDANG BERKHIDMAT;Maklumat Pengalaman Bekerja di Sektor Awam;;;;'); ?>">
											<i class="fa fa-envelope" aria-hidden="true"></i>
											<span>PEGAWAI SEDANG BERKHIDMAT</span>
										</a>
									</li>
									<?php } ?>
									<?php } ?>

									<?php
										$sql = "SELECT COUNT(*) as total FROM $schema2.`menu_pemohon` WHERE is_deleted=0 AND `status`=0"; 
										$sql .=" AND keterangan LIKE '%MAKLUMAT AKADEMIK%'" ;
										$rsMenu = $conn->query($sql);
									?>
									<?php if($rsMenu->fields['total'] > 0){ ?>
									<li class="nav-parent <?php if($module=='MAKLUMAT AKADEMIK'){ print ' nav-expanded nav-active'; }?>">
										<a>
											<i class="fa fa-dashboard" aria-hidden="true"></i>
											<span>MAKLUMAT AKADEMIK</span>
										</a>
										<ul class="nav nav-children">
											<?php
												$sql = "SELECT COUNT(*) as total FROM $schema2.`menu_pemohon` WHERE is_deleted=0 AND `status`=0"; 
												$sql .=" AND keterangan LIKE '%PT3/PMR%'" ;
												$rsMenu = $conn->query($sql);
											?>
											<?php if($rsMenu->fields['total'] > 0){ ?>
											<!-- <li <?php if($pages=='akademik/pmr'){ print 'class="nav-active"'; }?>>
								            	<a href="index.php?data=<?php print base64_encode('akademik/pmr;MAKLUMAT AKADEMIK;Maklumat SRP/PMR/PT3;;;;'); ?>">
													 <span class="fa fa-archive"></span> SRP/PMR/PT3
												</a>
											</li> -->
											<?php } ?>
											<?php
												$sql = "SELECT COUNT(*) as total FROM $schema2.`menu_pemohon` WHERE is_deleted=0 AND `status`=0"; 
												$sql .=" AND keterangan LIKE '%SPM/SPM(V)/SVM%'" ;
												$rsMenu = $conn->query($sql);
											?>
											<?php if($rsMenu->fields['total'] > 0){ ?>
											<li <?php if($pages=='akademik/spm'){ print 'class="nav-active"'; }?>>
								            	<a href="index.php?data=<?php print base64_encode('akademik/spm;MAKLUMAT AKADEMIK;Maklumat SPM/SPM(V)/SVM;;1;;'); ?>">
													 <span class="fa fa-archive"></span> SPM/SPM(V)/SVM
												</a>
											</li>
											<?php } ?>
											<!--<li <?php if($pages=='akademik/svm'){ print 'class="nav-active"'; }?>>
								            	<a href="index.php?data=<?php print base64_encode('akademik/svm;MAKLUMAT AKADEMIK;Maklumat SVM;;1;;'); ?>">
													 <span class="fa fa-archive"></span> SVM
												</a>
											</li>-->
											
											<?php
												$sql = "SELECT COUNT(*) as total FROM $schema2.`menu_pemohon` WHERE is_deleted=0 AND `status`=0"; 
												$sql .=" AND keterangan LIKE '%PEPERIKSAAN SPM ULANGAN%'" ;
												$rsMenu = $conn->query($sql);
											?>
											<?php if($rsMenu->fields['total'] > 0){ ?>
											<li <?php if($pages=='akademik/tambahan'){ print 'class="nav-active"'; }?>>
								            	<a href="index.php?data=<?php print base64_encode('akademik/tambahan;MAKLUMAT AKADEMIK;Maklumat Peperiksaan SPM Ulangan;;;;'); ?>">
													 <span class="fa fa-archive"></span> Peperiksaan SPM Ulangan
												</a>
											</li>
											<?php } ?>
											<?php
												$sql = "SELECT COUNT(*) as total FROM $schema2.`menu_pemohon` WHERE is_deleted=0 AND `status`=0"; 
												$sql .=" AND keterangan LIKE '%STPM%'" ;
												$rsMenu = $conn->query($sql);
											?>
											<?php if($rsMenu->fields['total'] > 0){ ?>
											<li <?php if($pages=='akademik/stpm'){ print 'class="nav-active"'; }?>>
								            	<a href="index.php?data=<?php print base64_encode('akademik/stpm;MAKLUMAT AKADEMIK;Maklumat STPM;;1;;'); ?>">
													 <span class="fa fa-archive"></span> STPM
												</a>
											</li>
											<?php } ?>


											<?php
												$sql = "SELECT COUNT(*) as total FROM $schema2.`menu_pemohon` WHERE is_deleted=0 AND `status`=0"; 
												$sql .=" AND keterangan LIKE '%STAM%'" ;
												$rsMenu = $conn->query($sql);
											?>
											<?php if($rsMenu->fields['total'] > 0){ ?>
											<li <?php if($pages=='akademik/stam'){ print 'class="nav-active"'; }?>>
								            	<a href="index.php?data=<?php print base64_encode('akademik/stam;MAKLUMAT AKADEMIK;Maklumat STAM;;1;;'); ?>">
													 <span class="fa fa-archive"></span> STAM
												</a>
											</li>
											<?php } ?>

											<?php
												$sql = "SELECT COUNT(*) as total FROM $schema2.`menu_pemohon` WHERE is_deleted=0 AND `status`=0"; 
												$sql .=" AND keterangan LIKE '%PENGAJIAN TINGGI%'" ;
												$rsMenu = $conn->query($sql);
											?>
											<?php if($rsMenu->fields['total'] > 0){ ?>
											<li <?php if($pages=='akademik/univ'){ print 'class="nav-active"'; }?>>
								            	<a href="index.php?data=<?php print base64_encode('akademik/univ;MAKLUMAT AKADEMIK;Maklumat Pengajian Tinggi;;1;;'); ?>">
													 <span class="fa fa-archive"></span> Pengajian Tinggi
												</a>
											</li>
											<?php } ?>

											<?php
												$sql = "SELECT COUNT(*) as total FROM $schema2.`menu_pemohon` WHERE is_deleted=0 AND `status`=0"; 
												$sql .=" AND keterangan LIKE '%PROFESIONAL%'" ;
												$rsMenu = $conn->query($sql);
											?>
											<?php if($rsMenu->fields['total'] > 0){ ?>
											<li <?php if($pages=='akademik/profesional'){ print 'class="nav-active"'; }?>>
								            	<a href="index.php?data=<?php print base64_encode('akademik/profesional;MAKLUMAT AKADEMIK;Maklumat Sijil Profesional;;;;'); ?>">
													 <span class="fa fa-archive"></span> Profesional
												</a>
											</li>
											<?php } ?>
										</ul>

									</li>
									<?php } ?>


									<?php
										$sql = "SELECT COUNT(*) as total FROM $schema2.`menu_pemohon` WHERE is_deleted=0 AND `status`=0"; 
										$sql .=" AND keterangan LIKE '%MAKLUMAT BUKAN AKADEMIK%'" ;
										$rsMenu = $conn->query($sql);
									?>
									<?php if($rsMenu->fields['total'] > 0){ ?>

									<li class="nav-parent<?php if($module=='MAKLUMAT BUKAN AKADEMIK'){ print ' nav-expanded nav-active'; }?>">
										<a>
											<i class="fa fa-keyboard-o" aria-hidden="true"></i>
											<span>MAKLUMAT BUKAN AKADEMIK</span>
										</a>

										<ul class="nav nav-children">
											<?php //if($_SESSION['SESS_ULEVEL']==1 || $_SESSION['SESS_ULEVEL']==2){ ?>
											
											<?php
												$sql = "SELECT COUNT(*) as total FROM $schema2.`menu_pemohon` WHERE is_deleted=0 AND `status`=0"; 
												$sql .=" AND keterangan LIKE '%SUKAN/PERSATUAN%'" ;
												$rsMenu = $conn->query($sql);
											?>
											<?php if($rsMenu->fields['total'] > 0){ ?>
											<li <?php if($pages=='koku/sukan'){ print 'class="nav-active"'; }?>>
								            	<a href="index.php?data=<?php print base64_encode('koku/sukan;MAKLUMAT BUKAN AKADEMIK;Maklumat Sukan/Persatuan;ALL;;;'); ?>">
													 <span class="fa fa-archive"></span> Sukan/Persatuan
												</a>
											</li>
											<?php } ?>

											<?php
												$sql = "SELECT COUNT(*) as total FROM $schema2.`menu_pemohon` WHERE is_deleted=0 AND `status`=0"; 
												$sql .=" AND keterangan LIKE '%REKACIPTA/PENCAPAIAN%'" ;
												$rsMenu = $conn->query($sql);
											?>
											<?php if($rsMenu->fields['total'] > 0){ ?>
											<li <?php if($pages=='koku/pencapaian'){ print 'class="nav-active"'; }?>>
								            	<a href="index.php?data=<?php print base64_encode('koku/pencapaian;MAKLUMAT BUKAN AKADEMIK;Maklumat Rekacipta/Pencapaian;ALL;;;'); ?>">
													 <span class="fa fa-archive"></span> Rekacipta/Pencapaian
												</a>
											</li>
											<?php } ?>
											<!-- <li <?php if($pages=='koku/tiada'){ print 'class="nav-active"'; }?>>
								            	<a href="index.php?data=<?php print base64_encode('koku/tiada;MAKLUMAT BUKAN AKADEMIK;Tiada Maklumat Tambahan;ALL;;;'); ?>">
													 <span class="fa fa-archive"></span> Tiada Maklumat Ko-Kurikulum
												</a>
											</li> -->
										<!-- 
											</ul>
										</li>




										<li class="nav-parent<?php if($module=='MAKLUMAT TAMBAHAN'){ print ' nav-expanded nav-active'; }?>">
										<a>
											<i class="fa fa-keyboard-o" aria-hidden="true"></i>
											<span>MAKLUMAT TAMBAHAN</span>
										</a>

										<ul class="nav nav-children">-->	


										<?php
											$sql = "SELECT COUNT(*) as total FROM $schema2.`menu_pemohon` WHERE is_deleted=0 AND `status`=0"; 
											$sql .=" AND keterangan LIKE '%BAKAT/KEBOLEHAN/BAHASA%'" ;
											$rsMenu = $conn->query($sql);
										?>
										<?php if($rsMenu->fields['total'] > 0){ ?> 

 											<li <?php if($pages=='tambahan/bakat'){ print 'class="nav-active"'; }?>>
								            	<a href="index.php?data=<?php print base64_encode('tambahan/bakat;MAKLUMAT BUKAN AKADEMIK;Maklumat Bakat / Kebolehan Bahasa;ALL;;;'); ?>">
													 <span class="fa fa-archive"></span> Bakat / Kebolehan Bahasa
												</a>
											</li>
										<?php } ?>
										<?php
											$sql = "SELECT COUNT(*) as total FROM $schema2.`menu_pemohon` WHERE is_deleted=0 AND `status`=0"; 
											$sql .=" AND keterangan LIKE '%BEKAS TENTERA/POLIS%'" ;
											$rsMenu = $conn->query($sql);
										?>
										<?php if($rsMenu->fields['total'] > 0){ ?>
											<li <?php if($pages=='tambahan/bekas'){ print 'class="nav-active"'; }?>>
								            	<a href="index.php?data=<?php print base64_encode('tambahan/bekas;MAKLUMAT BUKAN AKADEMIK;Maklumat Bekas Tentera / Polis;ALL;;;'); ?>">
													 <span class="fa fa-archive"></span> Bekas Tentera / Polis
												</a>
											</li>
										<?php } ?>
											<!-- <li <?php if($pages=='tambahan/oku'){ print 'class="nav-active"'; }?>>
								            	<a href="index.php?data=<?php print base64_encode('tambahan/oku;MAKLUMAT TAMBAHAN;Maklumat Penerima Bantuan / Kurang Upaya;ALL;;;'); ?>">
													 <span class="fa fa-archive"></span> Penerima Bantuan /<br>&nbsp;&nbsp;&nbsp;&nbsp;Kurang Upaya
												</a>

											</li> -->

											<!-- <li <?php if($pages=='tambahan/tiada'){ print 'class="nav-active"'; }?>>
								            	<a href="index.php?data=<?php print base64_encode('tambahan/tiada;MAKLUMAT TAMBAHAN;Tiada Maklumat Tambahana;ALL;;;'); ?>">
													 <span class="fa fa-archive"></span> Tiada Maklumat Tambahan
												</a>
											</li> -->

										</ul>

									</li>
									<?php } ?>

									<?php
										$sql = "SELECT COUNT(*) as total FROM $schema2.`menu_pemohon` WHERE is_deleted=0 AND `status`=0"; 
										$sql .=" AND keterangan LIKE '%JAWATAN DIMOHON%'" ;
										$rsMenu = $conn->query($sql);
									?>
									<?php if($rsMenu->fields['total'] > 0){ ?>
										<li class="<?php if($module=='JAWATAN DIMOHON'){ print ' nav-expanded nav-active'; }?>">
											<a href="index.php?data=<?php print base64_encode('biodata/jawatan;JAWATAN DIMOHON;Maklumat Jawatan Dimohon;;;;'); ?>">
												<i class="fa fa-envelope" aria-hidden="true"></i>
												<span>JAWATAN DIMOHON</span>
											</a>
										</li>
									<?php } ?>

									<?php
										$sql = "SELECT COUNT(*) as total FROM $schema2.`menu_pemohon` WHERE is_deleted=0 AND `status`=0"; 
										$sql .=" AND keterangan LIKE '%PERAKUAN PEMOHON%'" ;
										$rsMenu = $conn->query($sql);
									?>
									<?php if($rsMenu->fields['total'] > 0){ ?>

									<li class="<?php if($module=='PERAKUAN PEMOHON'){ print ' nav-expanded nav-active'; }?>">
										<a href="index.php?data=<?php print base64_encode('biodata/perakuan;PERAKUAN PEMOHON;Semakan Maklumat Peribadi Pemohon;;;;'); ?>">
											<i class="fa fa-envelope" aria-hidden="true"></i>
											<span>PERAKUAN PEMOHON</span>
										</a>
									</li>

										<?php if($_SESSION['SESS_UIC']=='840414145982'){ ?>

									<li class="<?php if($module=='SEMAKAN PERMOHONAN'){ print ' nav-expanded nav-active'; }?>">
										<a href="index.php?data=<?php print base64_encode('dashboard/semakan_permohonan;SEMAKAN PERMOHONAN;Semakan Maklumat Permohonan;;;;'); ?>">
											<i class="fa fa-envelope" aria-hidden="true"></i>
											<span>SEMAKAN PERMOHONAN</span>
										</a>
									</li>



										<?php } ?>


									<?php } ?>

									<li title="Sila klik disini untuk log keluar daripada sistem">
										<a href="logout.php">
											<i class="fa fa-power-off" aria-hidden="true"></i>
											<span>LOG KELUAR</span>
										</a>
									</li>

									<li title="Manual pengguna sistem mySPP"><br />
										<a href="../upload_doc/manual_pengguna_permohonanJan2025.pdf" target="_blank">
											<!--<i class="fa fa-file-pdf-o" aria-hidden="true"></i>-->
											<img src="../images/icon_pdf.png" width="30px" height="30px" />&nbsp;
											<span><b> PANDUAN PENGGUNA</b></span>
										</a>
									</li>
									<li title="FAQ">
										<a href="../index.php?pages=faq" target="_blank">
											<!--<i class="fa fa-file-pdf-o" aria-hidden="true"></i>-->
											<img src="../images/icon_pdf.png" width="30px" height="30px" />&nbsp;
											<span><b> SOALAN LAZIM</b></span>
										</a>
									</li><br><br>
									<!--<li title="Hubungi Sispa">
										<a href="#" target="_blank">-->
											<!--<i class="fa fa-file-pdf-o" aria-hidden="true"></i>

											<span><b> HUBUNGI SISPAA</b></span><br>-->
											<p style="padding-left: 10px;">
											<b> Nota: </b><br>
											Sebarang pertanyaan boleh hubungi <br> Hotline mySPP<br>
											i) Urusan Pengambilan : <br>&nbsp;&nbsp;&nbsp; 03-8893 4019/4020<br>
											ii) Urusan Teknikal : <br>&nbsp;&nbsp;&nbsp; 03-8893 4021<br>
											Sila salurkan pertanyaan atau aduan <br> kepada 
											<a href="https://spp.spab.gov.my/eApps/system/index.do" target="_blank" style="padding: 0px; color: #000;"><b>SISPAA-SPP</b></a> untuk bantuan selanjutnya.
											</p>
										<!--</a>
									</li>-->



									<div style="padding-left:30px;color:#fff">
								<br />

							</div>


									<li>								</ul>

							</nav>

						</div>

					</div>

				</aside>

				<!-- end: sidebar -->