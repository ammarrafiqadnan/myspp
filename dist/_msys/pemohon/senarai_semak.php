
<?php
// $conn->debug=true;
// $_SESSION['page_name']="MAKLUMAT PEMANTAUAN";
// $ids=isset($_REQUEST["ids"])?$_REQUEST["ids"]:"";
// $kategori=isset($_REQUEST["kategori"])?$_REQUEST["kategori"]:"";
// $read_only='';
// $ada='';
// if(empty($id) && !empty($kategori)){
// 	$jenis = $kategori;
// 	$id = date("ymd")."_".uniqid();
// } else { 
// 	$sql = "SELECT * FROM `tbl_pemantauan` WHERE `pemantauan_id`=".tosql($id);
// 	$rs = $conn->query($sql);
// 	$jenis = $rs->fields['pemantauan_type'];
// 	$ada='OK';
// }

// // PRINT "DD:".$read_only;
// // SELECT * FROM `_ref_status` 
// $stat = dlookup("`_ref_status`","status_nama","`status_id`=".tosql($rs->fields['status_proses']));
// // print "ST:".$stat;
// if(empty($stat)){ $stat='DRAF LAPORAN'; }
?>
		<header class="panel-heading"  style="background-color:rgb(38, 167, 228)">
			<h6 class="panel-title"><font color="#000000" size="3"><b><?php print strtoupper($menu);?></b></font></h6>
		</header>
		<div class="panel-body">
			<div class="box-body">

				<div class="col-md-12">
					
					<div class="form-group">
						<div class="row">
							<div class="col-sm-12">
								<b>SEMAKAN MAKLUMAT PERMOHONAN</b>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="row">
							<div class="col-sm-12">
								<table width="100%" cellspacing="1" cellpadding="10" border="1" align="center" class="table">
                                <tbody>
                                <tr>
                                    <td width="35%" bgcolor="#999999"><strong>Kategori</strong></td>
                                    <td width="65%" bgcolor="#999999"><strong>Status</strong></td>
                                </tr>
                                <tr>
                                    <td bgcolor="#ffffff">Maklumat Pemohon</td>
                                    <td bgcolor="#ffffff"><span class="style1">Lengkap</span></td>
                                </tr>
                                <tr>
                                    <td bgcolor="#CCCCCC">Maklumat Akademik</td>
                                    <td bgcolor="#CCCCCC"></td>
                                </tr>
                                <tr>
                                    <td bgcolor="#ffffff">PT3/PMR/SRP/LCE</td>
                                    <td bgcolor="#ffffff">Lengkap</td>
                                </tr>
                                <tr>
                                    <td bgcolor="#ffffff">SPM/MCE/SPVM/SPM(V)</td>
                                    <td bgcolor="#ffffff"><span class="style1">Lengkap</span></td>
                                </tr>
                                <tr>
                                    <td bgcolor="#ffffff">Peperiksaan Tambahan</td>
                                    <td bgcolor="#ffffff"><span class="style1">Lengkap</span></td>
                                </tr>
                                <tr>
                                    <td bgcolor="#ffffff">STPM/STP/HSC</td>
                                    <td bgcolor="#ffffff"><span class="style1">Lengkap</span></td>
                                </tr>
                                <tr>
                                    <td bgcolor="#ffffff">STAM</td>
                                    <td bgcolor="#ffffff"><span class="style1">Lengkap</span></td>
                                </tr>
                                <tr>
                                    <td bgcolor="#ffffff">Pengajian Tinggi</td>
                                    <td bgcolor="#ffffff"><span class="style1">Lengkap</span></td>
                                </tr>
                                <tr>
                                    <td bgcolor="#ffffff">Profesional</td>
                                    <td bgcolor="#ffffff"><span class="style1">Lengkap</span></td>
                                </tr>
                                <tr>
                                    <td bgcolor="#CCCCCC">Maklumat Ko-kurikulum</td>
                                    <td bgcolor="#CCCCCC"></td>
                                </tr>
                                <tr>
                                    <td bgcolor="#ffffff">Sukan</td>
                                    <td bgcolor="#ffffff"><span class="style1">Lengkap</span></td>
                                </tr>
                                <tr>
                                    <td bgcolor="#ffffff">Persatuan</td>
                                    <td bgcolor="#ffffff"><span class="style1">Lengkap</span></td>
                                </tr>
                                <tr>
                                    <td bgcolor="#ffffff">Rekacipta</td>
                                    <td bgcolor="#ffffff"><span class="style1">Lengkap</span></td>
                                </tr>
                                <tr>
                                    <td bgcolor="#ffffff">Pencapaian Khas / Istimewa</td>
                                    <td bgcolor="#ffffff"><span class="style1">Lengkap</span></td>
                                </tr>
                                <tr>
                                    <td bgcolor="#ffffff">Pegawai Sedang Berkhidmat</td>
                                    <td bgcolor="#ffffff"><span class="style2" style="color:red">Tidak Lengkap. Sila semak semula maklumat diisi</span></td>
                                </tr>
                                <tr>
                                    <td bgcolor="#CCCCCC">Maklumat Tambahan</td>
                                    <td bgcolor="#CCCCCC"></td>
                                </tr>
                                <tr>
                                    <td bgcolor="#ffffff">Bakat / Kebolehan bahasa</td>
                                    <td bgcolor="#ffffff"><span class="style1">Lengkap</span></td>
                                </tr>
                                <tr>
                                    <td bgcolor="#ffffff">Bekas tentera / Polis</td>
                                    <td bgcolor="#ffffff"><span class="style1">Lengkap</span></td>
                                </tr>
                                
                                <tr>
                                    <td bgcolor="#ffffff">Penerima bantuan / Kurang upaya</td>
                                    <td bgcolor="#ffffff"><span class="style1">Lengkap</span></td>
                                </tr>
                                
                                <tr>
                                    <td bgcolor="#ffffff">Jawatan dimohon</td>
                                    <td bgcolor="#ffffff"><span class="style1">Lengkap</span></td>
                                </tr>
                                <tr>
                                    <td bgcolor="#ffffff">Kelayakan Jawatan dimohon</td>
                                    <td bgcolor="#ffffff"><span class="style1">Lengkap</span></td>
                                </tr>
                            </tbody></table>
							</div>
						</div>
					</div>

					<div class="form-group">
						<div class="row">
							<div class="col-sm-12">
								<b>Jawatan Yang Dimohon: </b>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="row">
							<label for="nama" class="col-sm-2 control-label"><b>Pilihan Pertama<div style="float:right">:</div></b></label>
							<div class="col-sm-10"><b>PEGAWAI PERKHIDMATAN PENDIDIKAN GRED DH41</b></div>
						</div>
						<div class="row">
							<label for="nama" class="col-sm-2 control-label"><b>Pilihan Kedua<div style="float:right">:</div></b></label>
							<div class="col-sm-10"><b>PEGAWAI PERKHIDMATAN PENDIDIKAN GRED DG41</b></div>
						</div>
						<!-- <div class="row">
							<label for="nama" class="col-sm-2 control-label"><b>Pilihan Ketiga<div style="float:right">:</div></b></label>
							<div class="col-sm-10"><b>Pembantu Operasi N29</b></div>
						</div> -->
						</div>
					</div>

					
				</div>

			
			</div>

			<div class="box" style="background-color:#F2F2F2">
      			<div class="box-body">
				<div class="x_panel" style="background-color:#F2F2F2">
					<header class="panel-heading"  style="background-color:rgb(38, 167, 228)">
						<div class="panel-actions"></div>
						<h6 class="panel-title"><font color="#000000"><b>MAKLUMAT PERAKUAN PEMOHON</b></font></h6> 
					</header>
				</div>
				<div class="form-group">
						<div class="row">
							<div class="col-sm-12">
								<label for="nama" class="col-sm-12 control-label">Di bawah Seksyen 5, Akta Suruhanjaya-suruhanjaya Perkhidmatan 1957 (Semakan 1989), seseorang pemohon yang memberi maklumat palsu atau mengelirukan kepada Suruhanjaya berkaitan sesuatu permohonan untuk mendapatkan pekerjaan atau pelantikan adalah melakukan kesalahan dan jika disabitkan boleh dihukum penjara selama tempoh dua (2) tahun atau denda dua ribu Ringgit Malaysia (RM2,000) atau kedua-duanya sekali.
								<br><br>	
                                <input type="checkbox" checked disabled> Saya akui bahawa semua maklumat yang diberikan adalah benar. Sekiranya maklumat itu didapati palsu, saya boleh didakwa dan permohonan saya akan dibatalkan. Sekiranya saya diberi tawaran jawatan atau telah pun berkhidmat, maka maklumat palsu itu akan menjadi bukti dan alasan membatalkan tawaran jawatan atau menamatkan perkhidmatan saya dengan serta-merta. 
							</label>
							</div>
						</div>
					</div>
    			</div>   

			</div>		
		</div>

	     

<script language="javascript" type="text/javascript">
//document.frm.gsasar_nama.focus();
</script>		 
