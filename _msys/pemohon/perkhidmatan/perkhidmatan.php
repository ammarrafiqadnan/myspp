<small style="color: red;">
    Tarikh dikemskini : 04-03-2022 10:30:23 <br>
    Maklumat pengalaman calon berkhidmat di sektor awam.<br><br>
</small>
<?php
//$conn->debug=true;
$sql = "SELECT * FROM $schema2.`calon_masih_khidmat` WHERE `id_pemohon`=".tosql($id_pemohon);
$rsKhidmat = $conn->query($sql);
?>
<header class="panel-heading"  style="background-color:rgb(38, 167, 228)">
    <h6 class="panel-title"><font color="#000000" size="3"><b>MAKLUMAT PERKHIDMATAN</b></font></h6>
</header>
<div class="panel-body">
    <div class="box-body">
        <div class="col-md-12">
        <div class="panel-body">
			<div class="box-body">

			<input type="hidden" name="id_pemohon" id="id_pemohon" value="<?php print $_SESSION['SESS_UID'];?>" readonly="readonly"/>

				<div class="col-md-12">

					

					<div class="form-group">
						<div class="row">
							<label for="nama" class="col-sm-7 control-label"><b>Jenis Perkhidmatan <font color="#FF0000">*</font>
								<div style="float:right"><!--<img src="../images/info.gif" title="Sila klik pada medan carian dan calon boleh menaip perkataan yang dikehendaki. Carian dibuat berdasarkan perkataan yang ditaip.">--> :</div></b>
							</label>
							<div class="col-sm-5"><?php print dlookup("$schema1.`ref_jenis_perkhidmatan`","DISKRIPSI","KOD=".tosql($rsKhidmat->fields['jenis_perkhidmatan'])); ?></div>
						</div>
					</div>

					<div class="form-group">
						<div class="row">
							<label for="nama" class="col-sm-7 control-label"><b>Jenis Lantikan <font color="#FF0000">*</font>
								<div style="float:right"><!--<img src="../images/info.gif" title="Sila klik pada medan carian dan calon boleh menaip perkataan yang dikehendaki. Carian dibuat berdasarkan perkataan yang ditaip.">--> :</div>
							</b><br>
							- PSH - Pekerja Sambilan Harian<br>
						    - Contract Of Service (COS) - mengguna pakai skim perkhidmatan, gred dan kadar gaji sebagaimana yang ditetapkan di dalam Perkhidmatan Awam.<br>
						    - Contract For Service (CFS) - tidak mengguna pakai sebarang skim perkhidmatan, gred jawatan, kadar gaji serta sebarang peraturan sebagaimana yang ditetapkan dalam Perkhidmatan Awam.
							</label>
							<div class="col-sm-5"><?php print dlookup("$schema1.`ref_taraf_jawatan`","DISKRIPSI","KOD=".tosql($rsKhidmat->fields['taraf_jawatan'])); ?></div>
						</div>
					</div>

					<div class="form-group">
						<div class="row">
							<label for="nama" class="col-sm-7 control-label"><b>Tarikh Lantikan Pertama ke Perkhidmatan Awam <font color="#FF0000">*</font>
								<div style="float:right"><!--<img src="../images/info.gif" title="Sila klik pada medan carian dan calon boleh menaip perkataan yang dikehendaki. Carian dibuat berdasarkan perkataan yang ditaip.">--> :</div></b><br>
								 (Bagi pemohon yang bertaraf jawatan kontrak, tarikh lantikan adalah bermula daripada tempoh perkhidmatan kontrak yang tidak terputus melebihi tempoh enam(6) bulan daripada kontrak terdahulu. Sekiranya tempoh perkhidmatan terputus melebihi enam (6), maka tidak kira sebagai sebahagian tempoh keseluruhan kontrak.)
							</label>
							<div class="col-sm-5"><?php print DisplayDate($rsKhidmat->fields['d_lantikan_jpa']);?></div>
						</div>
					</div>

					<div class="form-group">
						<div class="row">
							<label for="nama" class="col-sm-7 control-label"><b>Tarikh Tamat Kontrak (Jika Berkenaan) <div style="float:right"><!--<img src="../images/info.gif" title="Sila pilih daripada senarai/maklumat">--> :</div></b><br>
								 (Tarikh Tamat Kontrak Perkhidmatan.)
							</label>
							<div class="col-sm-5"><?php print DisplayDate($rsKhidmat->fields['d_lantikan_kontrak']);?></div>
						</div>
					</div>

					<hr>

					<div class="form-group">
						<div class="row">
							<label for="nama" class="col-sm-7 control-label"><b>Skim Perkhidmatan Sekarang <font color="#FF0000">*</font>
								<div style="float:right"><!--<img src="../images/info.gif" title="Sila klik pada medan carian dan calon boleh menaip perkataan yang dikehendaki. Carian dibuat berdasarkan perkataan yang ditaip.">--> :</div></b><br>
								Nota: Jika Skim Perkhidmatan tiada dalam senarai, sila hubungi pihak SPP
							</label>
							<div class="col-sm-5"><?php print dlookup("$schema1.`ref_skim`","DISKRIPSI","KOD=".tosql($rsKhidmat->fields['skim_sekarang'])); ?></div>
						</div>
					</div>

					<div class="form-group">
						<div class="row">
							<label for="nama" class="col-sm-7 control-label"><b>Gred Jawatan Sekarang <font color="#FF0000">*</font>
								<div style="float:right"><!--<img src="../images/info.gif" title="Sila klik pada medan carian dan calon boleh menaip perkataan yang dikehendaki. Carian dibuat berdasarkan perkataan yang ditaip.">--> :</div></b></label>
							<div class="col-sm-5"><?php print dlookup("$schema1.`ref_gred_gaji`","KOD","KOD=".tosql($rsKhidmat->fields['gred_jawatan_sekarang'])); ?></div>
						</div>
					</div> 


					<div class="form-group">
						<div class="row">
							<label for="nama" class="col-sm-7 control-label"><b>Tarikh Lantikan Pertama ke Skim Perkhidmatan Sekarang (Hakiki)  <font color="#FF0000">*</font><div style="float:right"><img src="../images/info.gif" title="Contoh : Sekiranya gred jawatan anda adalah N22, sila isikan tarikh lantikan Gred N17"> :</div></b></label>
							<div class="col-sm-5"><?php print DisplayDate($rsKhidmat->fields['d_lantikan_khidmat_sekarang']);?></div>
						</div>
					</div>

					<div class="form-group">
						<div class="row">
							<label for="nama" class="col-sm-7 control-label"><b>Tarikh Pengesahan ke Skim Perkhidmatan Sekarang (Jika Berkenaan)<div style="float:right">
								<img src="../images/info.gif" title="Contoh : Sekiranya gred jawatan anda adalah N22, sila isikan tarikh lantikan Gred N17"> :</div></b><br>
								 (Bagi pemohon yang berkhidmat secara kontrak dan sangkut tidak perlu mengisi ruangan ini)
							</label>
							<div class="col-sm-5"><?php print DisplayDate($rsKhidmat->fields['d_sah_khidmat_sekarang']);?></div>
						</div>
					</div>

					<hr>

					<div class="form-group">
						<div class="row">
							<label for="nama" class="col-sm-7 control-label"><b>Kementerian/Jabatan Tempat Bertugas <font color="#FF0000">*</font>
								<div style="float:right"><!--<img src="../images/info.gif" title="Sila klik pada medan carian dan calon boleh menaip perkataan yang dikehendaki. Carian dibuat berdasarkan perkataan yang ditaip.">--> :</div></b><br>
								(Sekiranya skim perkhidmatan sekarang (hakiki) adalah jawatan kader, sila nyatakan kementerian/jabatan pegawai sedang bertugas.)
								<br>Nota: Jika Kementerian / Jabatan tiada dalam senarai, sila hubungi pihak SPP
							</label>
							<div class="col-sm-5"><?php print dlookup("$schema1.`ref_kem_jabatan`","DISKRIPSI","KOD=".tosql($rsKhidmat->fields['tpt_bertugas'])); ?></div>
						</div>
					</div>

					<div class="form-group">
						<div class="row">
							<label for="nama" class="col-sm-7 control-label"><b>Negeri Tempat Bertugas  <font color="#FF0000">*</font>
								<div style="float:right"><!--<img src="../images/info.gif" title="Sila klik pada medan carian dan calon boleh menaip perkataan yang dikehendaki. Carian dibuat berdasarkan perkataan yang ditaip.">--> :</div></b></label>
							<div class="col-sm-5"><?php print dlookup("$schema2.`ref_negeri`","diskripsi","KOD=".tosql($rsKhidmat->fields['negeri_tpt_bertugas'])); ?></div>
						</div>
					</div>

					<hr>
					<?php 
					$rsPSB = $conn->query("SELECT * FROM $schema1.`ref_kelulusan` WHERE `JENIS`=2 AND `KATEGORI`='B' ORDER BY `DISKRIPSI`"); 
					?>
					<div class="form-group">
						<div class="row">
							<label for="nama" class="col-sm-7 control-label"><b>Jenis Peperiksaan <!--<font color="#FF0000">*</font>-->
								<div style="float:right"><!--<img src="../images/info.gif" title="Sila klik pada medan carian dan calon boleh menaip perkataan yang dikehendaki. Carian dibuat berdasarkan perkataan yang ditaip.">--> :</div></b></label>
							<div class="col-sm-5"><?php print dlookup("$schema1.`ref_kelulusan`","DISKRIPSI","KOD=".tosql($rsKhidmat->fields['jenis_xm'])); ?></div>
						</div>
					</div>

					<div class="form-group">
						<div class="row">
							<label for="nama" class="col-sm-7 control-label"><b>Tarikh Lulus Peperiksaan PSL<!--<font color="#FF0000">*</font>-->
								<div style="float:right"><!--<img src="../images/info.gif" title="Sila pilih daripada senarai/maklumat">--> :</div>
							</b>
							<br>
							- PSL - Peningkatan Secara Lantikan<br>
							</label>
							<div class="col-sm-5"><?php print DisplayDate($rsKhidmat->fields['d_lulus_kpsl']);?></div>
						</div>
					</div>


					
					
				</div>

			
			</div>
		</div>
	</div>
    </div>
</div>

