<?php include '../../connection/common.php'; ?>

<script>
	function do_save(){
		var id_pengguna = $('#id_pengguna').val();
		var nama_penuh = $('#nama_penuh').val();
		var noKP = $('#noKP').val();
		var emel = $('#emel').val();
		var bahagian = $('#bahagian').val();
		var jawatan = $('#jawatan').val();
		var no_tel = $('#no_tel').val();
		var peranan = $('#peranan').val();
		var status = $('#status').val();

		if(id_pengguna.trim() == '' ){
			alert_msg('Sila isi maklumat ID Pengguna.');
			$('#id_pengguna').focus(); return true;
		} else if(nama_penuh.trim() == '' ){
			alert_msg('Sila isi maklumat nama penuh.');
			$('#nama_penuh').focus(); return true;
		} else if(noKP.trim() == '' ){
			alert_msg('Sila isi maklumat No. KP.');
			$('#noKP').focus(); return true;
		} else if(emel.trim() == '' ){
			alert_msg('Sila isi maklumat emel.');
			$('#emel').focus(); return true;
		} else if(bahagian.trim() == '' ){
			alert_msg('Sila pilih maklumat maklumat bahagian.');
			$('#bahagian').focus(); return true;
		} else if(jawatan.trim() == '' ){
			alert_msg('Sila pilih maklumat jawatan.');
			$('#jawatan').focus(); return true;
		} else if(no_tel.trim() == '' ){
			alert_msg('Sila isi maklumat nama penuh.');
			$('#no_tel').focus(); return true;
		} else if(peranan.trim() == '' ){
			alert_msg('Sila pilih maklumat maklumat peranan.');
			$('#peranan').focus(); return true;
		} else if(status.trim() == '' ){
			alert_msg('Sila pilih maklumat maklumat status.');
			$('#status').focus(); return true;
		} else { 
			$.ajax({
				url:'pengurusan/sql_pengurusan.php?frm=PENGGUNA&pro=SAVE',
				type:'POST',
				//dataType: 'json',
				// beforeSend: function () {
				// 	$('.btn-primary').attr("disabled","disabled");
				// 	$('.modal-body').css('opacity', '.5');
				// },
				data: $("form").serialize(),
				success: function(data){
					console.log(data);
					if(data=='OK'){
						swal({
							title: 'Berjaya',
							text: 'Maklumat telah berjaya dikemaskini',
							type: 'success',
							confirmButtonClass: "btn-success",
							confirmButtonText: "Ok",
							showConfirmButton: true,
						}).then(function () {
							// window.location.href = url;
							reload = window.location; 
							window.location = reload;
						});
					} else if(data=='ERR'){
						swal({
							title: 'Amaran',
							text: 'Terdapat ralat sistem.\nMaklumat anda tidak berjaya diproses.',
							type: 'error',
							confirmButtonClass: "btn-warning",
							confirmButtonText: "Ok",
							showConfirmButton: true,
						});
					}
				},
			});   
		}
	}
</script>
<?php
	// $conn->debug=true;
	$id=isset($_REQUEST["id"])?$_REQUEST["id"]:"";
	$sql3 = "SELECT * FROM $schema2.`spa8i_admin` WHERE id='{$id}'";
	$rs = $conn->query($sql3);
?>
<div class="col-lg-12">
	<section class="panel">
		<header class="panel-heading"  style="background-color:rgb(38, 167, 228)">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="do_close()">×</button>
			<h6 class="panel-title"><font color="#000000" size="3"><b>TAMBAH MAKLUMAT PENGGUNA</b></font></h6>
		</header>
		<div class="panel-body">
			<div class="box-body">

			<input type="hidden" name="id" id="id" value="<?php if(!empty($id)){ print $rs->fields['id']; }?>" />

				<div class="col-md-12">

					<div class="form-group">
						<div class="row">
							<label for="nama" class="col-sm-2 control-label"><b>ID Pengguna <font color="#FF0000">*</font> : </b></label>
							<div class="col-sm-3">
								<input type="text" name="id_pengguna" id="id_pengguna" class="form-control" value="<?php if(!empty($id)){ print $rs->fields['username']; }?>">
							</div>
						</div>
					</div>

                    <div class="form-group">
						<div class="row">
							<label for="nama" class="col-sm-2 control-label"><b>Nama Penuh<font color="#FF0000">*</font> : </b></label>
							<div class="col-sm-10">
								<input type="text" name="nama_penuh" id="nama_penuh" class="form-control" value="<?php if(!empty($id)){ print $rs->fields['nama_penuh']; }?>">
							</div>
						</div>
					</div>

					<div class="form-group">
						<div class="row">
							<label for="nama" class="col-sm-2 control-label"><b>No. K/P <font color="#FF0000">*</font> : </b></label>
							<div class="col-sm-4">
								<input type="text" name="noKP" id="noKP" maxlength="12" class="form-control" value="<?php if(!empty($id)){ print $rs->fields['noKP']; }?>">
								<small>(cth : 000000110000)</small>
							</div>
							<label for="nama" class="col-sm-2 control-label"><b>Emel <font color="#FF0000">*</font> : </b></label>
							<div class="col-sm-4">
								<input type="email" name="email" id="email" class="form-control" value="<?php if(!empty($id)){ print $rs->fields['emel']; }?>">
							</div>
						</div>
					</div>

                    <div class="form-group">
						<div class="row">
							<label for="nama" class="col-sm-2 control-label"><b>Bahagian <font color="#FF0000">*</font> : </b></label>
							<div class="col-sm-4">
                                <select name="bahagian" id="bahagian" class="form-control">
									<option value="">Sila pilih bahagian</option>
									<option value="1" <?php if(!empty($id)){ if($rs->fields['bahagian'] == 1){ print 'selected';}} ?>>BAHAGIAN PENGURUSAN MAKLUMAT</option>
									<option value="2" <?php if(!empty($id)){ if($rs->fields['bahagian'] == 2){ print 'selected';}} ?>>BAHAGIAN PENGAMBILAN</option>
								</select>
							</div>
							<label for="nama" class="col-sm-2 control-label"><b>Jawatan <font color="#FF0000">*</font> : </b></label>
							<div class="col-sm-4">
                                <select name="jawatan" id="jawatan" class="form-control">
									<option value="">Sila pilih jawatan</option>
									<option value="1" <?php if(!empty($id)){ if($rs->fields['jawatan'] == 1){ print 'selected';}} ?>>PEMBANTU PEGAWAI SISTEM MAKLUMAT</option>
									<option value="2" <?php if(!empty($id)){ if($rs->fields['jawatan'] == 2){ print 'selected';}} ?>>PEMBANTU PEGAWAI SPP</option>
								</select>
							</div>
						</div>
					</div>

                    <div class="form-group">
						<div class="row">
							<label for="nama" class="col-sm-2 control-label"><b>No. Tel <font color="#FF0000">*</font> : </b></label>
							<div class="col-sm-3">
								<input type="text" name="no_tel" id="no_tel" class="form-control" value="<?php if(!empty($id)){ print $rs->fields['no_tel']; }?>">
							</div>
							<div class="col-sm-1"></div>
							<label for="nama" class="col-sm-2 control-label"><b>Peranan <font color="#FF0000">*</font> : </b></label>
							<div class="col-sm-3">
                                <select name="peranan" id="peranan" class="form-control">
									<option value="">Sila pilih peranan</option>
									<option value="1" <?php if(!empty($id)){ if($rs->fields['peranan'] == 1){ print 'selected';}} ?>>Pentadbir/Admin</option>
									<option value="2" <?php if(!empty($id)){ if($rs->fields['peranan'] == 2){ print 'selected';}} ?>>Pengurusan</option>
									<option value="3" <?php if(!empty($id)){ if($rs->fields['peranan'] == 3){ print 'selected';}} ?>>Meja Bantu (Helpdesk)</option>

								</select>
							</div>

						</div>
					</div>

                    <div class="form-group">
						<div class="row">
							<label for="nama" class="col-sm-2 control-label"><b>Status <font color="#FF0000">*</font> : </b></label>
							<div class="col-sm-3">
                                <select name="status" id="status" class="form-control">
									<option value="">Sila pilih status</option>
									<option value="0" <?php if(!empty($id)){ if($rs->fields['status'] == 0){ print 'selected';}} ?>>Aktif</option>
									<option value="1" <?php if(!empty($id)){ if($rs->fields['status'] == 1){ print 'selected';}} ?>>Tidak Aktif</option>
								</select>
							</div>
						</div>
					</div>

					<div class="box-body" style="background-color:#F2F2F2">
						<table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
							<thead  style="background-color:rgb(38, 167, 228)">
								<th width="5%"><font color="#000000"><div align="center">No.</div></font></th>
								<th width="15%"><font color="#000000"><div align="center">Menu</div></font></th>
								<th width="10%"><font color="#000000"><div align="center">Tambah</div></font></th>
								<th width="10%"><font color="#000000"><div align="center">Kemaskini<div></font></th>
								<th width="10%"><font color="#000000"><div align="center">Hapus<div></font></th>
								<th width="10%"><font color="#000000"><div align="center">Lihat<div></font></th>
							</thead>
							<tbody>
								<tr>
									<td>1.</td>
									<td>Dashboard</td>
									<td align="center"><input type="checkbox"></td>
									<td align="center"><input type="checkbox"></td>
									<td align="center"><input type="checkbox"></td>
									<td align="center"><input type="checkbox"></td>
								</tr>
								<tr>
									<td>2.</td>
									<td>Senarai Pemohon</td>
									<td align="center"><input type="checkbox"></td>
									<td align="center"><input type="checkbox"></td>
									<td align="center"><input type="checkbox"></td>
									<td align="center"><input type="checkbox"></td>
								</tr>
								<tr>
									<td>3.</td>
									<td>Pengurusan Panggilan Temuduga</td>
									<td align="center"><input type="checkbox"></td>
									<td align="center"><input type="checkbox"></td>
									<td align="center"><input type="checkbox"></td>
									<td align="center"><input type="checkbox"></td>
								</tr>
								<tr>
									<td>4.</td>
									<td>Pengurusan Keputusan Temuduga</td>
									<td align="center"><input type="checkbox"></td>
									<td align="center"><input type="checkbox"></td>
									<td align="center"><input type="checkbox"></td>
									<td align="center"><input type="checkbox"></td>
								</tr>
								<tr>
									<td>5.</td>
									<td>Pengurusan Rayuan Temuduga</td>
									<td align="center"><input type="checkbox"></td>
									<td align="center"><input type="checkbox"></td>
									<td align="center"><input type="checkbox"></td>
									<td align="center"><input type="checkbox"></td>
								</tr>
								<tr>
									<td rowspan="11">6.</td>
									<td>Pentadbiran</td>
									<td align="center" colspan="4"><input type="checkbox"></td>
								</tr>
								<tr>
									<td>Pengurusan Pengguna</td>
									<td align="center"><input type="checkbox"></td>
									<td align="center"><input type="checkbox"></td>
									<td align="center"><input type="checkbox"></td>
									<td align="center"><input type="checkbox"></td>
								</tr>
								<tr>
									<td>Kawalan Muatnaik Dokumen</td>
									<td align="center"><input type="checkbox"></td>
									<td align="center"><input type="checkbox"></td>
									<td align="center"><input type="checkbox"></td>
									<td align="center"><input type="checkbox"></td>
								</tr>
								<tr>
									<td>Kawalan Tempoh Akaun Pemohon Aktif</td>
									<td align="center"><input type="checkbox"></td>
									<td align="center"><input type="checkbox"></td>
									<td align="center"><input type="checkbox"></td>
									<td align="center"><input type="checkbox"></td>
								</tr>
								<tr>
									<td>Pengurusan Kandungan Surat</td>
									<td align="center"><input type="checkbox"></td>
									<td align="center"><input type="checkbox"></td>
									<td align="center"><input type="checkbox"></td>
									<td align="center"><input type="checkbox"></td>
								</tr>
								<tr>
									<td>Pengurusan Hebahan Atau Makluman</td>
									<td align="center"><input type="checkbox"></td>
									<td align="center"><input type="checkbox"></td>
									<td align="center"><input type="checkbox"></td>
									<td align="center"><input type="checkbox"></td>
								</tr>
								<tr>
									<td>Pengurusan FAQ</td>
									<td align="center"><input type="checkbox"></td>
									<td align="center"><input type="checkbox"></td>
									<td align="center"><input type="checkbox"></td>
									<td align="center"><input type="checkbox"></td>
								</tr>
								<tr>
									<td>Pengurusan Kandungan Notifikasi (emel)</td>
									<td align="center"><input type="checkbox"></td>
									<td align="center"><input type="checkbox"></td>
									<td align="center"><input type="checkbox"></td>
									<td align="center"><input type="checkbox"></td>
								</tr>
								<tr>
									<td>Parameter</td>
									<td align="center"><input type="checkbox"></td>
									<td align="center"><input type="checkbox"></td>
									<td align="center"><input type="checkbox"></td>
									<td align="center"><input type="checkbox"></td>
								</tr>
								<tr>
									<td>Audit Trail</td>
									<td align="center"><input type="checkbox"></td>
									<td align="center"><input type="checkbox"></td>
									<td align="center"><input type="checkbox"></td>
									<td align="center"><input type="checkbox"></td>
								</tr>
								<tr>
									<td>Housekeeping</td>
									<td align="center"><input type="checkbox"></td>
									<td align="center"><input type="checkbox"></td>
									<td align="center"><input type="checkbox"></td>
									<td align="center"><input type="checkbox"></td>
								</tr>
								<tr>
									<td rowspan="3">7</td>
									<td>Laporan</td>
									<td align="center" colspan="4"><input type="checkbox"></td>
								</tr>
								<tr>
									<td>Keseluruhan Data</td>
									<td align="center"><input type="checkbox"></td>
									<td align="center"><input type="checkbox"></td>
									<td align="center"><input type="checkbox"></td>
									<td align="center"><input type="checkbox"></td>
								</tr>
								<tr>
									<td>Tapisan</td>
									<td align="center"><input type="checkbox"></td>
									<td align="center"><input type="checkbox"></td>
									<td align="center"><input type="checkbox"></td>
									<td align="center"><input type="checkbox"></td>
								</tr>
							</tbody>
						</table>
					</div>

					<div class="modal-footer" style="padding:0px;">
						<button type="button" class="btn btn-primary mt-sm mb-sm" onclick="do_save()"><i class="fa fa-save"></i> Simpan</button>
						&nbsp;
						<button type="button" class="btn btn-default" onclick="do_close()"><i class="fa fa-spinner" style="margin:0px;"></i> Kembali</button>
					</div>
				</div>

			
			</div>
		</div>
	     
	</section>

</div> 

<script>
    function do_close(){
        reload = window.location; 
        window.location = reload;
    }
</script>