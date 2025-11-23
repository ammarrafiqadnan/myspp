<?php
if(empty($pages)){ $pages='dashboard/dashboard_utama'; }   

$reg = $_SESSION['SESSADM_MENU'];
$p = (explode(",",$reg));

?>
<div class="inner-wrapper">
	<!-- start: sidebar -->
	<aside id="sidebar-left" class="sidebar-left d-print-none"  
	style="background-image: linear-gradient(90deg, rgb(38, 167, 228) 0%, rgba(236, 241, 244, 0.353) 87%);">
	
		<div class="sidebar-header">
			<div class="sidebar-title">
				<font color="black"><b>Menu Sistem</b></font>
			</div>
			<div class="sidebar-toggle hidden-xs" data-toggle-class="sidebar-left-collapsed" data-target="html" data-fire-event="sidebar-left-toggle">
				<i class="fa fa-bars" aria-label="Toggle sidebar"></i>
			</div>
		</div>
							<?php //print_r($p); ?>
		<div class="nano">
			<div class="nano-content">
				<nav id="menu" class="nav-main" role="navigation" style="color:black">
					<ul class="nav nav-main">
						<?php if(in_array('dashboard', $p)){ ?>
							<li <?php if(empty($module) || $pages=='dashboard/dashboard_utama'){ print 'class="nav-expanded nav-active"';}?>>
								<a href="index.php">
									<i class="fa fa-home" aria-hidden="true"></i>
									<span>Dashboard</span>
								</a>
							</li>
						<?php } ?>
						<!-- <li class="nav-parent<?php if($module=='Senarai Pemohon'){ print ' nav-expanded nav-active'; }?>">
							<a>
								<i class="fa fa-keyboard-o" aria-hidden="true"></i>
								<span>Senarai Pemohon</span>
							</a>
							<ul class="nav nav-children">
								<li <?php if($pages=='pemohon/senarai_pemohon_draf'){ print 'class="nav-active"'; }?>>
									<a href="index.php?data=<?php print base64_encode('pemohon/senarai_pemohon_draf;Senarai Pemohon;Senarai Pemohon Draf;ALL;;;'); ?>&kategori=draf">
										<i class="fa fa-list" aria-hidden="true"></i>
										<span>Draf</span>
									</a>
								</li>
								<li <?php if($pages=='pemohon/senarai_pemohon_hantar'){ print 'class="nav-active"'; }?>>
									<a href="index.php?data=<?php print base64_encode('pemohon/senarai_pemohon_hantar;Senarai Pemohon;Senarai Pemohon Hantar;ALL;;;'); ?>&kategori=hantar">
										<i class="fa fa-list" aria-hidden="true"></i>
										<span>Hantar</span>
									</a>
								</li>
							</ul>
						</li> -->
						<?php if(in_array('senarai_pemohon', $p)){ ?>
						<li <?php if($pages=='pemohon/senarai_pemohon'){ print 'class="nav-expanded nav-active"';}?>>
							<a href="index.php?data=<?php print base64_encode('pemohon/senarai_pemohon;Pengurusan;Senarai Pemohon;;;;'); ?>&m=1">
								<i class="fa fa-list" aria-hidden="true"></i>
								<span>Senarai Pemohon</span>
							</a>
						</li> 
						<?php }
						if(in_array('pptd', $p)){ ?> 
						<li class="<?php if($menu=='Senarai Panggilan Temu Duga'){ print ' nav-expanded nav-active'; }?>">
							<a href="index.php?data=<?php print base64_encode('muatnaikExcel/senarai_panggilan_temuduga;Pengurusan;Senarai Panggilan Temu Duga;;;;'); ?>">
								<i class="fa fa-list-alt" aria-hidden="true"></i>
								<span>Pengurusan Panggilan <br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Temu Duga</span>
							</a>
						</li> 
						<?php }
						if(in_array('pktd', $p)){ ?>
						<li class="<?php if($menu=='Senarai Keputusan Temu Duga'){ print ' nav-expanded nav-active'; }?>">
							<a href="index.php?data=<?php print base64_encode('muatnaikExcel/senarai_keputusan_temuduga;Pengurusan;Senarai Keputusan Temu Duga;;;;'); ?>">
								<i class="fa fa-check-square-o" aria-hidden="true"></i>
								<span>Pengurusan Keputusan <br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Temu Duga</span>
							</a>
						</li> 
						<?php } ?>

						<!--<li class="<?php if($menu=='Senarai Rayuan Temu Duga'){ print ' nav-expanded nav-active'; }?>">
							<a href="index.php?data=<?php print base64_encode('muatnaikExcel/senarai_rayuan_temuduga;Pengurusan;Senarai Rayuan Temu Duga;;;;'); ?>">
								<i class="fa fa-check-square-o" aria-hidden="true"></i>
								<span>Pengurusan Rayuan <br> Temu Duga</span>
							</a>
						</li> -->


						<li class="nav-parent<?php if($module=='Padanan Kluster'){ print ' nav-expanded nav-active'; }?>">
							<a>
								<i class="fa fa-keyboard-o" aria-hidden="true"></i>
								<span>Padanan Kluster</span>
							</a>
							<ul class="nav nav-children">
								<?php if(in_array('param6', $p)) { ?>
								<li <?php if($pages=='pengurusan/kod_kluster/senarai_kod_kluster'){ print 'class="nav-active"'; }?>>
									<a href="index.php?data=<?php print base64_encode('pengurusan/kod_kluster/senarai_kod_kluster;Padanan Kluster;Maklumat Kluster;ALL;;;'); ?>">
                               						<span class="fa fa-archive"></span> Maklumat Kluster
                                					</a>
								</li>
								<?php } ?>
								
								<?php if(in_array('param7', $p)) { ?>
								<li <?php if($pages=='pengurusan/kod_kluster/senarai_kod_mpelajaran'){ print 'class="nav-active"'; }?>>
									<a href="index.php?data=<?php print base64_encode('pengurusan/kod_kluster/senarai_kod_mpelajaran;Padanan Kluster;Matapelajaran Dan Kluster;ALL;;;'); ?>">
                               						<span class="fa fa-archive"></span> Maklumat Matapelajaran Dan Kluster
                                					</a>
								</li>
								<?php } ?>
								
								<?php if(in_array('param8', $p)) { ?>


								<li <?php if($pages=='pengurusan/kod_bidang/senarai_kod_bidang'){ print 'class="nav-active"'; }?>>
									<a href="index.php?data=<?php print base64_encode('pengurusan/kod_bidang/senarai_kod_bidang;Padanan Kluster;Maklumat Bidang;ALL;;;'); ?>">
                               						<span class="fa fa-archive"></span> Maklumat Bidang
                                					</a>
								</li>
								<?php } ?>
								
								<?php if(in_array('param16', $p)) { ?>
								<li <?php if($pages=='pengurusan/kod_kluster/padanan_pengkhususan_kluster'){ print 'class="nav-active"'; }?>>
									<a href="index.php?data=<?php print base64_encode('pengurusan/kod_kluster/padanan_pengkhususan_kluster;Padanan Kluster;Padanan Pengkhususan Kluster Dan Mata Pelajaran;;;'); ?>" 
										title="Padanan Pengkhususan Kluster Dan Mata Pelajaran">
                               						<span class="fa fa-archive"></span> Padanan Kluster dan Mata Pelajaran
                                					</a>
								</li>
								<?php } ?>
								
								<?php if(in_array('param20', $p)) { ?>
								<li <?php if($pages=='helpdesk/ralat_daftar'){ print 'class="nav-active"'; }?>>
									<a href="index.php?data=<?php print base64_encode('padanan/carian_kluster;Padanan Kluster;Senarai Padanan Kluster;ALL;;;'); ?>">
										<span class="fa fa-archive"></span> Maklumat Padanan
									</a>
								</li>
								<?php } ?>


							</ul>
						</li>
						<?php //} ?>

						<?php if(in_array('helpdesk', $p)){ ?>
						<li class="nav-parent<?php if($module=='Helpdesk'){ print ' nav-expanded nav-active'; }?>">
							<a>
								<i class="fa fa-keyboard-o" aria-hidden="true"></i>
								<span>Helpdesk</span>
							</a>
							<ul class="nav nav-children">
								<li <?php if($pages=='helpdesk/ralat_daftar'){ print 'class="nav-active"'; }?>>
									<a href="index.php?data=<?php print base64_encode('helpdesk/ralat_daftar;Helpdesk;Senarai Ralat Daftar;ALL;;;'); ?>">
											<span class="fa fa-archive"></span> Senarai Ralat Daftar
									</a>
								</li>
								<li <?php if($pages=='helpdesk/myid_daftar'){ print 'class="nav-active"'; }?>>
									<a href="index.php?data=<?php print base64_encode('helpdesk/myid_daftar;Helpdesk;Senarai Daftar Pemohon;ALL;;;'); ?>">
											<span class="fa fa-archive"></span> Senarai Daftar Pemohon
									</a>
								</li>

								<li <?php if($pages=='zip/upload_pemohon'){ print 'class="nav-active"'; }?>>
									<a href="index.php?data=<?php print base64_encode('zip/upload_pemohon;Helpdesk;Muat Turun Dokumen;ALL;;;'); ?>">
											<span class="fa fa-archive"></span> Muat Turun Dokumen Pemohon
									</a>
								</li>
							</ul>
						</li>
						<?php } ?>

						<?php if(in_array('housekeeping', $p)){ ?>
						<li class="nav-parent<?php if($module=='Housekeeping'){ print ' nav-expanded nav-active'; }?>">
							<a>
								<i class="fa fa-keyboard-o" aria-hidden="true"></i>
								<span>Housekeeping</span>
							</a>
							<ul class="nav nav-children">
								<li <?php if($pages=='hkeeping/ralat_daftar'){ print 'class="nav-active"'; }?>>
									<a href="index.php?data=<?php print base64_encode('hkeeping/senarai_pemohon;Housekeeping;Senarai Pemohon Daftar;ALL;;;'); ?>">
											<span class="fa fa-archive"></span> Senarai Pemohon
									</a>
								</li>
								<!--
								<li <?php if($pages=='hkeeping/myid_daftar'){ print 'class="nav-active"'; }?>>
									<a href="index.php?data=<?php print base64_encode('helpdesk/myid_daftar;Helpdesk;Senarai Daftar Pemohon;ALL;;;'); ?>">
											<span class="fa fa-archive"></span> Senarai Daftar Pemohon
									</a>
								</li>-->
							</ul>
						</li>
						<?php } ?>


						<?php if(in_array('pentadbiran', $p) || in_array('pentadbiran2', $p) || in_array('pentadbiran3', $p)
							|| in_array('pentadbiran4', $p) || in_array('pentadbiran5', $p) || in_array('pentadbiran6', $p)
							|| in_array('pentadbiran7', $p) || in_array('pentadbiran8', $p) || in_array('pentadbiran9', $p)
						){ ?>
						<li class="nav-parent<?php if($module=='Pentadbiran'){ print ' nav-expanded nav-active'; }?>">
							<a>
								<i class="fa fa-keyboard-o" aria-hidden="true"></i>
								<span>Pentadbiran</span>
							</a>
							<ul class="nav nav-children">
								<?php if(in_array('pentadbiran', $p)) { ?> 
								<li <?php if($pages=='pengurusan/senarai_pengguna'){ print 'class="nav-active"'; }?>>
									<a href="index.php?data=<?php print base64_encode('pengurusan/senarai_pengguna;Pentadbiran;Senarai Pengguna;ALL;;;'); ?>">
											<span class="fa fa-archive"></span> Pengurusan Pengguna
									</a>
								</li>
								<?php } ?>
								<?php if(in_array('pentadbiran2', $p)) { ?>
								<li <?php if($pages=='pengurusan/menu_pemohon'){ print 'class="nav-active"'; }?>>
									<a href="index.php?data=<?php print base64_encode('pengurusan/menu_pemohon;Pentadbiran;Kawalan Menu Pemohon;ALL;;;'); ?>">
											<span class="fa fa-archive"></span> Kawalan Menu Permohonan
									</a>
								</li>
								<?php } ?>
								<?php if(in_array('pentadbiran3', $p)) { ?>
								<li <?php if($pages=='pengurusan/kawalan_muatnaik_dokumen'){ print 'class="nav-active"'; }?>>
									<a href="index.php?data=<?php print base64_encode('pengurusan/kawalan_muatnaik_dokumen;Pentadbiran;Kawalan Muatnaik Dokumen;ALL;;;'); ?>">
											<span class="fa fa-archive"></span> Kawalan Muatnaik Dokumen
									</a>
								</li>
								<?php } ?>
								<?php if(in_array('pentadbiran4', $p)) { ?>
								<li <?php if($pages=='pengurusan/kawalan_tempoh_akaun'){ print 'class="nav-active"'; }?>>
									<a href="index.php?data=<?php print base64_encode('pengurusan/kawalan_tempoh_akaun;Pentadbiran;Kawalan Tempoh Akaun;ALL;;;'); ?>">
											<span class="fa fa-archive"></span> Kawalan Tempoh Akaun <br> &nbsp;&nbsp;&nbsp; Pemohon Aktif
									</a>
								</li>
								<?php } ?>
								<?php if(in_array('pentadbiran5', $p)) { ?>
								<li <?php if($pages=='pengurusan/kandungan_surat'){ print 'class="nav-active"'; }?>>
									<a href="index.php?data=<?php print base64_encode('pengurusan/kandungan_surat;Pentadbiran;Kandungan Surat;ALL;;;'); ?>">
											<span class="fa fa-archive"></span> Pengurusan Kandungan <br> &nbsp;&nbsp;&nbsp; Surat
									</a>
								</li>
								<?php } ?>
								<?php if(in_array('pentadbiran6', $p)) { ?>
								<li <?php if($pages=='pengurusan/hebahan_maklumat'){ print 'class="nav-active"'; }?>>
									<a href="index.php?data=<?php print base64_encode('pengurusan/hebahan_maklumat;Pentadbiran;Hebahan Atau Makluman;ALL;;;'); ?>">
											<span class="fa fa-archive"></span> Pengurusan Hebahan Atau <br> &nbsp;&nbsp;&nbsp; Makluman
									</a>
								</li>
								<?php } ?>
								<?php if(in_array('pentadbiran7', $p)) { ?>
								<li <?php if($pages=='pengurusan/FAQ'){ print 'class="nav-active"'; }?>>
									<a href="index.php?data=<?php print base64_encode('pengurusan/FAQ;Pentadbiran;FAQ;ALL;;;'); ?>">
											<span class="fa fa-archive"></span> Pengurusan FAQ
									</a>
								</li>

								<!--<li <?php if($pages=='pengurusan/notifikasi'){ print 'class="nav-active"'; }?>>
									<a href="index.php?data=<?php print base64_encode('pengurusan/notifikasi;Pentadbiran;Notifikasi;ALL;;;'); ?>">
											<span class="fa fa-archive"></span> Pengurusan Kandungan <br> &nbsp;&nbsp;&nbsp; Notifikasi (emel)
									</a>
								</li>-->
								
								<?php } ?>
								<?php if(in_array('pentadbiran8', $p)) { ?>
								<li <?php if($pages=='pengurusan/parameter'){ print 'class="nav-active"'; }?>>
									<a href="index.php?data=<?php print base64_encode('pengurusan/parameter;Pentadbiran;Parameter;ALL;;;'); ?>">
											<span class="fa fa-archive"></span> Parameter
									</a>
								</li>
								<?php } ?>
								<?php if(in_array('pentadbiran9', $p)) { ?>
								<li <?php if($pages=='pengurusan/auditrail'){ print 'class="nav-active"'; }?>>
									<a href="index.php?data=<?php print base64_encode('pengurusan/auditrail;Pentadbiran;Audit Trail;ALL;;;'); ?>">
											<span class="fa fa-archive"></span> Audit Trail
									</a>
								</li>
								<?php } ?>
								<!--<li <?php if($pages=='pengurusan/housekeeping'){ print 'class="nav-active"'; }?>>
									<a href="index.php?data=<?php print base64_encode('pengurusan/housekeeping;Pentadbiran;Housekeeping;ALL;;;'); ?>">
											<span class="fa fa-archive"></span> Housekeeping
									</a>
								</li>-->
								
							</ul>
						</li>
						<?php } ?>
						<?php if(in_array('laporan', $p)){ ?>

						<!-- <li <?php if($pages=='pemohon/carian_maklumat_pemohon'){ print 'class="nav-expanded nav-active"';}?>>
							<a href="index.php?data=<?php print base64_encode('pemohon/carian_maklumat_pemohon;Pengurusan;Carian Maklumat Pemohon;;;;'); ?>">
								<i class="fa fa-list" aria-hidden="true"></i>
								<span>Carian Maklumat Pemohon</span>
							</a>
						</li>  -->

						<li class="nav-parent<?php if($module=='Laporan'){ print ' nav-expanded nav-active'; }?>">
							<a>
								<i class="fa fa-bar-chart-o" aria-hidden="true"></i>
								<span>Laporan</span>
							</a>
							<ul class="nav nav-children">
								 <!-- <li <?php if($pages=='laporan/carian'){ print 'class="nav-active"'; }?>>
									<a href="index.php?data=<?php print base64_encode('laporan/carian;Laporan;Laporan;ALL;;;'); ?>">
											<span class="fa fa-archive"></span> Carian Maklumat
									</a>
								</li>  -->

								<!--<li <?php if($pages=='laporan/keseluruhan_data'){ print 'class="nav-active"'; }?>>
									<a href="index.php?data=<?php print base64_encode('laporan/keseluruhan_data;Laporan;Laporan Keseluruhan Data;ALL;;;'); ?>">
											<span class="fa fa-archive"></span> Keseluruhan Data
									</a>
								</li>-->

								<li <?php if($pages=='laporan/tapisan'){ print 'class="nav-active"'; }?>>
									<a href="index.php?data=<?php print base64_encode('laporan/tapisan;Laporan;Laporan Tapisan;ALL;;;'); ?>">
											<span class="fa fa-archive"></span> Tapisan
									</a>
								</li>
							</ul>
						</li>
						<?php } ?>
						<!-- <li class="<?php if($pages=='Laporan'){ print ' nav-expanded nav-active'; }?>">
							<a href="index.php?data=<?php print base64_encode('laporan/laporan;Laporan;;;;;'); ?>">
								<i class="fa fa-list" aria-hidden="true"></i>
								<span>Laporan</span>
							</a>
						</li>  -->

						<li title="Sila klik disini untuk log keluar daripada sistem">
							<a href="logout.php">
								<i class="fa fa-power-off" aria-hidden="true"></i>
								<span>Log Keluar</span>
							</a>
						</li>


						<!--<li title="Manual pengguns sistem PTIS"><br />
							<a href="manual/Panduan_pengguna_Modul_Pikap_Agensi.pdf" target="_blank">
								<i class="fa fa-file-pdf-o" aria-hidden="true"></i>
								<span><b>PANDUAN PENGGUNA</b></span>
							</a>
						</li>-->

						<li><br />
							<div style="padding-left:30px;color:#fff">
								<br />
								<a href="../upload_doc/user_manual_pentadbiran.pdf" target="_blank" title="Sila klik untuk paparan manual pengguna sistem">
									<img src="../images/icon_pdf.png" width="30px" height="30px" /> Panduan Pengguna</a>


							</div>

					</ul>

				</nav>

			</div>
	
		</div>
	
	</aside>
	<!-- end: sidebar -->