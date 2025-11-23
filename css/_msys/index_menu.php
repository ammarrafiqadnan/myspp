<?php
if(empty($pages)){ $pages='dashboard/dashboard_utama'; }   

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
				
					<div class="nano">
						<div class="nano-content">
							<nav id="menu" class="nav-main" role="navigation" style="color:black">
								<ul class="nav nav-main">

									<li <?php if(empty($module) || $pages=='dashboard/dashboard_utama'){ print 'class="nav-expanded nav-active"';}?>>
										<a href="index.php">
											<i class="fa fa-home" aria-hidden="true"></i>
											<span>Dashboard</span>
										</a>
									</li>
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
                                    <li <?php if($pages=='pemohon/senarai_pemohon'){ print 'class="nav-expanded nav-active"';}?>>
										<a href="index.php?data=<?php print base64_encode('pemohon/senarai_pemohon;Pentadbiran;Senarai Pemohon;;;;'); ?>">
											<i class="fa fa-list" aria-hidden="true"></i>
											<span>Senarai Pemohon</span>
										</a>
									</li> 
									
									<li class="<?php if($menu=='Senarai Panggilan Temu Duga'){ print ' nav-expanded nav-active'; }?>">
										<a href="index.php?data=<?php print base64_encode('senarai_panggilan_temuduga;Pentadbiran;Senarai Panggilan Temu Duga;;;;'); ?>">
											<i class="fa fa-list-alt" aria-hidden="true"></i>
											<span>Pengurusan Panggilan Temu Duga</span>
										</a>
									</li> 
									
									<li class="<?php if($menu=='Senarai Keputusan Temu Duga'){ print ' nav-expanded nav-active'; }?>">
										<a href="index.php?data=<?php print base64_encode('senarai_keputusan_temuduga;;Senarai Keputusan Temu Duga;;;;'); ?>">
											<i class="fa fa-check-square-o" aria-hidden="true"></i>
											<span>Pengurusan Keputusan Temu Duga</span>
										</a>
									</li> 

									<li class="<?php if($menu=='Senarai Rayuan'){ print ' nav-expanded nav-active'; }?>">
										<a href="index.php?data=<?php print base64_encode('senarai_rayuan;Pentadbiran;Senarai Rayuan;;;;'); ?>">
											<i class="fa fa-sun-o" aria-hidden="true"></i>
											<span>Pengurusan Rayuan Temu Duga</span>
										</a>
									</li>
									
									
                                    <li class="nav-parent<?php if($module=='Pengurusan'){ print ' nav-expanded nav-active'; }?>">
										<a>
											<i class="fa fa-keyboard-o" aria-hidden="true"></i>
											<span>Pentadbiran</span>
										</a>
										<ul class="nav nav-children">
											<li <?php if($pages=='pengurusan/senarai_pengguna'){ print 'class="nav-active"'; }?>>
								            	<a href="index.php?data=<?php print base64_encode('pengurusan/senarai_pengguna;Pentadbiran;Senarai Pengguna;ALL;;;'); ?>">
													 <span class="fa fa-archive"></span> Pengurusan Pengguna
												</a>
											</li>

											<li <?php if($pages=='pengurusan/menu_pemohon'){ print 'class="nav-active"'; }?>>
								            	<a href="index.php?data=<?php print base64_encode('pengurusan/menu_pemohon;Pentadbiran;Menu Pemohon;ALL;;;'); ?>">
													 <span class="fa fa-archive"></span> Pengurusan Menu Pemohon
												</a>
											</li>

											<li <?php if($pages=='pengurusan/kawalan_muatnaik_dokumen'){ print 'class="nav-active"'; }?>>
								            	<a href="index.php?data=<?php print base64_encode('pengurusan/kawalan_muatnaik_dokumen;Pentadbiran;Kawalan Muatnaik Dokumen;ALL;;;'); ?>">
													 <span class="fa fa-archive"></span> Kawalan Muatnaik Dokumen
												</a>
											</li>

											<li <?php if($pages=='pengurusan/kawalan_muatnaik_dokumen'){ print 'class="nav-active"'; }?>>
								            	<a href="index.php?data=<?php print base64_encode('pengurusan/kawalan_muatnaik_dokumen;Pentadbiran;Kawalan Muatnaik Dokumen;ALL;;;'); ?>">
													 <span class="fa fa-archive"></span> Kawalan Tempoh Akaun <br> &nbsp;&nbsp;&nbsp; Pemohon Aktif
												</a>
											</li>

											<li <?php if($pages=='pengurusan/kandungan_surat'){ print 'class="nav-active"'; }?>>
								            	<a href="index.php?data=<?php print base64_encode('pengurusan/kandungan_surat;Pentadbiran;Kandungan Surat;ALL;;;'); ?>">
													 <span class="fa fa-archive"></span> Pengurusan Kandungan Surat
												</a>
											</li>

											<li <?php if($pages=='pengurusan/hebahan_maklumat'){ print 'class="nav-active"'; }?>>
								            	<a href="index.php?data=<?php print base64_encode('pengurusan/hebahan_maklumat;Pentadbiran;Hebahan Dan Makluman;ALL;;;'); ?>">
													 <span class="fa fa-archive"></span> Pengurusan Hebahan Atau <br> &nbsp;&nbsp;&nbsp; Makluman
												</a>
											</li>

											<li <?php if($pages=='pengurusan/FAQ'){ print 'class="nav-active"'; }?>>
								            	<a href="index.php?data=<?php print base64_encode('pengurusan/FAQ;Pentadbiran;FAQ;ALL;;;'); ?>">
													 <span class="fa fa-archive"></span> Pengurusan FAQ
												</a>
											</li>

											<li <?php if($pages=='pengurusan/notifikasi'){ print 'class="nav-active"'; }?>>
								            	<a href="index.php?data=<?php print base64_encode('pengurusan/notifikasi;Pentadbiran;Notifikasi;ALL;;;'); ?>">
													 <span class="fa fa-archive"></span> Pengurusan Kandungan <br> &nbsp;&nbsp;&nbsp; Notifikasi (emel)
												</a>
											</li>

											<li <?php if($pages=='pengurusan/parameter'){ print 'class="nav-active"'; }?>>
								            	<a href="index.php?data=<?php print base64_encode('pengurusan/parameter;Pentadbiran;Parameter;ALL;;;'); ?>">
													 <span class="fa fa-archive"></span> Parameter
												</a>
											</li>

											<li <?php if($pages=='pengurusan/auditrail'){ print 'class="nav-active"'; }?>>
								            	<a href="index.php?data=<?php print base64_encode('pengurusan/auditrail;Pentadbiran;Audit Trail;ALL;;;'); ?>">
													 <span class="fa fa-archive"></span> Audit Trail
												</a>
											</li>

											<li <?php if($pages=='pengurusan/housekeeping'){ print 'class="nav-active"'; }?>>
								            	<a href="index.php?data=<?php print base64_encode('pengurusan/housekeeping;Pentadbiran;Housekeeping;ALL;;;'); ?>">
													 <span class="fa fa-archive"></span> Housekeeping
												</a>
											</li>
                                            
										</ul>
									</li>

									<li class="nav-parent<?php if($module=='Laporan'){ print ' nav-expanded nav-active'; }?>">
										<a>
											<i class="fa fa-bar-chart-o" aria-hidden="true"></i>
											<span>Laporan</span>
										</a>
										<ul class="nav nav-children">
											<li <?php if($pages=='laporan/carian'){ print 'class="nav-active"'; }?>>
								            	<a href="index.php?data=<?php print base64_encode('laporan/carian;Laporan;Laporan;ALL;;;'); ?>">
													 <span class="fa fa-archive"></span> Carian Maklumat
												</a>
											</li>

											<li <?php if($pages=='laporan/keseluruhan_data'){ print 'class="nav-active"'; }?>>
								            	<a href="index.php?data=<?php print base64_encode('laporan/keseluruhan_data;Laporan;Laporan Keseluruhan Data;ALL;;;'); ?>">
													 <span class="fa fa-archive"></span> Keseluruhan Data
												</a>
											</li>

											<li <?php if($pages=='laporan/tapisan'){ print 'class="nav-active"'; }?>>
								            	<a href="index.php?data=<?php print base64_encode('laporan/tapisan;Laporan;Laporan Tapisan;ALL;;;'); ?>">
													 <span class="fa fa-archive"></span> Tapisan
												</a>
											</li>
										</ul>
									</li>

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
											<span><b>Manual Pengguna Sistem</b></span>
										</a>
									</li>-->

									<li><br />
                                        <div style="padding-left:30px;color:#fff">
                                        	<b>Petunjuk : </b><br />
                                    		<img src="../images/icon_edit.png" width="30" height="30" /> Kemaskini maklumat<br />
                                            <!--<img src="../images/btn_tambah.gif" width="20" height="20" /> Tambah maklumat aktiviti<br />-->
                                            <img src="../images/icon_delete.png" width="30" height="30" /> Hapus maklumat<br /><br />

                                            <br />
                                            <a href="manual/manual.pdf" target="_blank" title="Sila klik untuk paparan manual pengguna sistem">
                                            	<img src="../images/icon_pdf.png" width="30px" height="30px" /> Manual Pengguna Sistem</a>


                                    	</div>

								</ul>

							</nav>

						</div>
				
					</div>
				
				</aside>
				<!-- end: sidebar -->