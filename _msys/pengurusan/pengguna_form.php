<?php include '../../connection/common.php'; ?>

<script>
	function do_save(){
		// var id_pengguna = $('#id_pengguna').val();
		var nama_penuh = $('#nama_penuh').val();
		var noKP = $('#noKP').val();
		var email = $('#email').val();
		var bahagian2 = $('#bahagian2').val();
		var jawatan2 = $('#jawatan2').val();
		var no_tel = $('#no_tel').val();
		var peranan2 = $('#peranan2').val();
		var status2 = $('#status2').val();

		// alert(peranan2);

		// if(id_pengguna.trim() == '' ){
		// 	alert_msg('Sila isi maklumat ID Pengguna.');
		// 	$('#id_pengguna').focus(); return true;
		// } else 
		if(nama_penuh.trim() == '' ){
			alert_msg('Sila isi maklumat nama penuh.');
			$('#nama_penuh').focus(); return true;
		} else if(noKP.trim() == '' ){
			alert_msg('Sila isi maklumat No. KP.');
			$('#noKP').focus(); return true;
		} else if(email.trim() == '' ){
			alert_msg('Sila isi maklumat emel.');
			$('#email').focus(); return true;
		} else if(bahagian2.trim() == '' ){
			alert_msg('Sila pilih maklumat bahagian.');
			$('#bahagian2').focus(); return true;
		} else if(jawatan2.trim() == '' ){
			alert_msg('Sila pilih maklumat jawatan.');
			$('#jawatan2').focus(); return true;
		} else if(no_tel.trim() == '' ){
			alert_msg('Sila isi maklumat nombor telefon.');
			$('#no_tel').focus(); return true;
		} else if(peranan2.trim() == '' ){
		 	alert_msg('Sila pilih maklumat maklumat peranan.');
		 	$('#peranan').focus(); return true;
		} else if(status2.trim() == '' ){
			alert_msg('Sila pilih maklumat maklumat status.');
			$('#status2').focus(); return true;
		} else { 
			$.ajax({
				url:'pengurusan/sql_pengurusan.php?frm=PENGGUNA&pro=SAVE',
				type:'POST',
				//dataType: 'json',
				beforeSend: function () {
					$('.btn-primary').attr("disabled","disabled");
				 	$('.modal-body').css('opacity', '.5');
				},
				data: $("form").serialize(),
				success: function(data){
					//console.log(data);
					if(data=='OK'){
						swal({
							title: 'Berjaya',
							text: 'Maklumat telah berjaya disimpan',
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
						}).then(function () {
							$('.btn-primary').removeAttr("disabled");
				 			$('.modal-body').css('opacity', '0');
						});
					}
				},
			});   
		}
	}

	function do_ic(ic) {
		// alert('sini');
		$.ajax({
			url:'pengurusan/sql_pengurusan.php?frm=PENGGUNA_CHECK_IC&ic='+ic,
			type:'POST',
			//dataType: 'json',
			data: $("form").serialize(),
			success: function(data){
				console.log(data);
				if(data=='ERR'){
					swal({
						title: 'Amaran',
						text: 'No. Kad Pengenalan telah wujud. Sila masukkan no. kad pengenalan lain.',
						type: 'error',
						confirmButtonClass: "btn-warning",
						confirmButtonText: "Ok",
						showConfirmButton: true,
					}).then(function () {
						document.getElementById("save").style.display = "none";
					});
				} else {
					document.getElementById("save").style.display = "inline";
				}

				
			},
		});
	}


	function do_menu(vals) {
		var chks='';
		chks = document.getElementById('pentadbiranKeseluruhan').checked;

		var chks2='';
		chks2 = document.getElementById('laporanKeseluruhan').checked;

		// for(var i = 18; i < 53; i++)
		// {
		// 	alert(i);
			if(chks==true && vals == 'pentadbiranKeseluruhan'){
				document.getElementById('check18').checked  = true;
				document.getElementById('check19').checked  = true;
				document.getElementById('check20').checked  = true;
				document.getElementById('check21').checked  = true;
				document.getElementById('check22').checked  = true;
				document.getElementById('check23').checked  = true;
				document.getElementById('check24').checked  = true;
				document.getElementById('check25').checked  = true;
				document.getElementById('check26').checked  = true;
				document.getElementById('check27').checked  = true;
				document.getElementById('check28').checked  = true;
				document.getElementById('check29').checked  = true;
				document.getElementById('check30').checked  = true;
				document.getElementById('check31').checked  = true;
				document.getElementById('check32').checked  = true;
				document.getElementById('check33').checked  = true;
				document.getElementById('check34').checked  = true;
				document.getElementById('check35').checked  = true;
				document.getElementById('check36').checked  = true;
				document.getElementById('check37').checked  = true;
				document.getElementById('check38').checked  = true;
				document.getElementById('check39').checked  = true;
				document.getElementById('check40').checked  = true;
				document.getElementById('check41').checked  = true;
				document.getElementById('check42').checked  = true;
				document.getElementById('check43').checked  = true;
				document.getElementById('check44').checked  = true;
				document.getElementById('check45').checked  = true;
				document.getElementById('check46').checked  = true;
				document.getElementById('check47').checked  = true;
				document.getElementById('check48').checked  = true;
				document.getElementById('check49').checked  = true;
				document.getElementById('check50').checked  = true;
				document.getElementById('check51').checked  = true;
				document.getElementById('check52').checked  = true;
			} else if(chks==false && vals == 'pentadbiranKeseluruhan') {
				document.getElementById('check18').checked  = false;
				document.getElementById('check19').checked  = false;
				document.getElementById('check20').checked  = false;
				document.getElementById('check21').checked  = false;
				document.getElementById('check22').checked  = false;
				document.getElementById('check23').checked  = false;
				document.getElementById('check24').checked  = false;
				document.getElementById('check25').checked  = false;
				document.getElementById('check26').checked  = false;
				document.getElementById('check27').checked  = false;
				document.getElementById('check28').checked  = false;
				document.getElementById('check29').checked  = false;
				document.getElementById('check30').checked  = false;
				document.getElementById('check31').checked  = false;
				document.getElementById('check32').checked  = false;
				document.getElementById('check33').checked  = false;
				document.getElementById('check34').checked  = false;
				document.getElementById('check35').checked  = false;
				document.getElementById('check36').checked  = false;
				document.getElementById('check37').checked  = false;
				document.getElementById('check38').checked  = false;
				document.getElementById('check39').checked  = false;
				document.getElementById('check40').checked  = false;
				document.getElementById('check41').checked  = false;
				document.getElementById('check42').checked  = false;
				document.getElementById('check43').checked  = false;
				document.getElementById('check44').checked  = false;
				document.getElementById('check45').checked  = false;
				document.getElementById('check46').checked  = false;
				document.getElementById('check47').checked  = false;
				document.getElementById('check48').checked  = false;
				document.getElementById('check49').checked  = false;
				document.getElementById('check50').checked  = false;
				document.getElementById('check51').checked  = false;
				document.getElementById('check52').checked  = false;
			} 

			if(chks2==true && vals == 'laporanKeseluruhan'){
				document.getElementById('check53').checked  = true;
				document.getElementById('check54').checked  = true;
				document.getElementById('check55').checked  = true;
				document.getElementById('check56').checked  = true;
				document.getElementById('check57').checked  = true;
			} else if(chks2==false && vals == 'laporanKeseluruhan') {
				document.getElementById('check53').checked  = false;
				document.getElementById('check54').checked  = false;
				document.getElementById('check55').checked  = false;
				document.getElementById('check56').checked  = false;
				document.getElementById('check57').checked  = false;
			}
			
		// }
		
		
	}


	function do_peranan(peranan) {
		// alert(peranan);
        // var peringkat2 = $("#peringkat2").val();
        // var peringkat2 = $('#peringkat2').val();
        if(peranan == 1){
			// alert('sini');
            $(".chkPembetulan").attr("checked", "true");
        } else {
			// srp_pangkat.removeAttribute('disabled');
			// alert('sana');
            $(".chkPembetulan").removeAttr('checked');
            // $(".chkPembetulan").attr("checked", "false");

        }
    }

	function do_with(vals){
		getSelectedCheckboxValues('menu', vals);
	}

	function getSelectedCheckboxValues(name, vals) {
		const checkboxes = document.querySelectorAll(`input[name="${name}"]:checked`);
		let values = [];
		checkboxes.forEach((checkbox) => {
			values.push(checkbox.value);
			//alert(checkbox.value);
			//document.getElementById("pentadbiran8").checked = false; 
			if(checkbox.value=='param1'){ document.getElementById("pentadbiran8").checked = true; }
			if(checkbox.value=='param2'){ document.getElementById("pentadbiran8").checked = true; }
			if(checkbox.value=='param3'){ document.getElementById("pentadbiran8").checked = true; }
			if(checkbox.value=='param4'){ document.getElementById("pentadbiran8").checked = true; }
			if(checkbox.value=='param5'){ document.getElementById("pentadbiran8").checked = true; }
			//if(checkbox.value=='param6'){ document.getElementById("pentadbiran8").checked = true; }
			//if(checkbox.value=='param7'){ document.getElementById("pentadbiran8").checked = true; }
			//if(checkbox.value=='param8'){ document.getElementById("pentadbiran8").checked = true; }
			if(checkbox.value=='param9'){ document.getElementById("pentadbiran8").checked = true; }
			if(checkbox.value=='param10'){ document.getElementById("pentadbiran8").checked = true; }
			if(checkbox.value=='param11'){ document.getElementById("pentadbiran8").checked = true; }
			if(checkbox.value=='param12'){ document.getElementById("pentadbiran8").checked = true; }
			if(checkbox.value=='param13'){ document.getElementById("pentadbiran8").checked = true; }
			if(checkbox.value=='param14'){ document.getElementById("pentadbiran8").checked = true; }
			if(checkbox.value=='param15'){ document.getElementById("pentadbiran8").checked = true; }
			//if(checkbox.value=='param16'){ document.getElementById("pentadbiran8").checked = true; }
		});

		document.myspp.menu_select.value=values;
	
	}
</script>
<?php
	// $conn->debug=true;
	$id=isset($_REQUEST["id"])?$_REQUEST["id"]:"";
	$jenis=isset($_REQUEST["jenis"])?$_REQUEST["jenis"]:"";
	$sql3 = "SELECT * FROM $schema2.`spa8i_admin` WHERE id='{$id}'";
	$rs = $conn->query($sql3);
?>
<div class="col-lg-12">
	<section class="panel">
		<header class="panel-heading"  style="background-color:rgb(38, 167, 228)">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="do_close()">X</button>
			<h6 class="panel-title"><font color="#000000" size="3"><b>TAMBAH MAKLUMAT PENGGUNA</b></font></h6>
		</header>
		<div class="panel-body">
			<div class="box-body">

			<input type="hidden" name="id" id="id" value="<?php if(!empty($id)){ print $id; }?>" />
			<input type="hidden" name="jenis" id="jenis" value="<?php print $jenis;?>" />


				<div class="col-md-12">

					<!-- <div class="form-group">
						<div class="row">
							<label for="nama" class="col-sm-2 control-label"><b>ID Pengguna <font color="#FF0000">*</font> : </b></label>
							<div class="col-sm-3">
								<input type="text" name="id_pengguna" id="id_pengguna" class="form-control" value="<?php if(!empty($id)){ print $rs->fields['username']; }?>">
							</div>
						</div>
					</div> -->

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
								<input type="text" name="noKP" id="noKP" maxlength="12" class="form-control" value="<?php if(!empty($id)){ print $rs->fields['noKP']; }?>" onchange="do_ic(this.value)" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
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
                                <select name="bahagian2" id="bahagian2" class="form-control">
									<option value="">Sila pilih bahagian</option>
									<option value="1" <?php if(!empty($id)){ if($rs->fields['bahagian'] == 1){ print 'selected';}} ?>>BAHAGIAN PENGURUSAN MAKLUMAT</option>
									<option value="2" <?php if(!empty($id)){ if($rs->fields['bahagian'] == 2){ print 'selected';}} ?>>BAHAGIAN PENGAMBILAN</option>
								</select>
							</div>
							<label for="nama" class="col-sm-2 control-label"><b>Jawatan <font color="#FF0000">*</font> : </b></label>
							<div class="col-sm-4">
                                <select name="jawatan2" id="jawatan2" class="form-control">
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
								<input type="text" name="no_tel" id="no_tel" class="form-control" value="<?php if(!empty($id)){ print $rs->fields['no_tel']; }?>" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"	>
							</div>
							<div class="col-sm-1"></div>
							<label for="nama" class="col-sm-2 control-label"><b>Peranan <font color="#FF0000">*</font> : </b></label>
							<div class="col-sm-3">
								<?php if($jenis == 'admin'){ ?>
									<select name="peranan2" id="peranan2" class="form-control" >
										<option value="">Sila pilih peranan</option>
										<option value="1" <?php if(!empty($id)){ if($rs->fields['peranan'] == 1){ print 'selected';}} ?>>Pentadbir/Admin</option>
										<option value="2" <?php if(!empty($id)){ if($rs->fields['peranan'] == 2){ print 'selected';}} ?>>Pengurusan</option>
										<option value="3" <?php if(!empty($id)){ if($rs->fields['peranan'] == 3){ print 'selected';}} ?>>Meja Bantu (Helpdesk)</option>
									</select>
								<?php } else { ?>
									<input class="form-control" name="peranan2" id="peranan2" type="text" value="<?php if(!empty($id)){ if($rs->fields['peranan'] == 1){ print 'Pentadbir/Admin';} else  if($rs->fields['peranan'] == 2){ print 'Pengurusan';} else  if($rs->fields['peranan'] == 3){ print 'Meja Bantu (Helpdesk';}} ?>" readonly>
								<?php } ?>


								<!--<select name="peranan2" id="peranan2" class="form-control" <?php if($jenis == 'pengguna'){ print 'disabled'; }?> onchange="do_peranan(this.value)">
									<option value="">Sila pilih peranan</option>
									<option value="1" <?php if(!empty($id)){ if($rs->fields['peranan'] == 1){ print 'selected';}} ?>>Pentadbir/Admin</option>
									<option value="2" <?php if(!empty($id)){ if($rs->fields['peranan'] == 2){ print 'selected';}} ?>>Pengurusan</option>
									<option value="3" <?php if(!empty($id)){ if($rs->fields['peranan'] == 3){ print 'selected';}} ?>>Meja Bantu (Helpdesk)</option>
								</select>-->
							</div>

						</div>
					</div>
<div class="form-group">
						<div class="row">
							<label for="nama" class="col-sm-2 control-label"><b>Status <font color="#FF0000">*</font> : </b></label>
							<div class="col-sm-3">
                                <select name="status2" id="status2" class="form-control" <?php if($jenis == 'pengguna'){ print 'disabled'; }?>>
									<option value="">Sila pilih status</option>
									<option value="0" <?php if(!empty($id)){ if($rs->fields['status'] == 0){ print 'selected';}} ?>>Aktif</option>
									<option value="1" <?php if(!empty($id)){ if($rs->fields['status'] == 1){ print 'selected';}} ?>>Tidak Aktif</option>
								</select>
							</div>

						</div>
					</div>

					<?php 
						$reg = $rs->fields['menu'];
						//print $reg;
						$p = (explode(",",$reg));
					?>
					<?php if($jenis == 'admin'){ ?>
					<div class="form-group">
						<div class="row">
							<label for="nama" class="col-sm-2 control-label"><b>Menu <font color="#FF0000">*</font> : </b></label>
							<div class="col-sm-10">
								<input type="checkbox" name="menu" id="menu" onclick="do_with(this.value)" value="dashboard" <?php if(in_array('dashboard', $p)){ print 'checked="checked"'; } ?>> <b>Dashboard</b>
							</div>
						</div>

						<div class="row">
							<label for="nama" class="col-sm-2 control-label"></label>
							<div class="col-sm-10">
								<input type="checkbox" name="menu" id="menu" onclick="do_with(this.value)" value="senarai_pemohon" <?php if(in_array('senarai_pemohon', $p)){ print 'checked="checked"'; } ?>> <b>Senarai Pemohon</b>
							</div>
						</div>

						<div class="row">
							<label for="nama" class="col-sm-2 control-label"></label>
							<div class="col-sm-10">
								<input type="checkbox" name="menu" id="menu" onclick="do_with(this.value)" value="pptd" <?php if(in_array('pptd', $p)){ print 'checked="checked"'; } ?>> <b>Pengurusan Panggilan Temu Duga</b>
							</div>
						</div>

						<div class="row">
							<label for="nama" class="col-sm-2 control-label"></label>
							<div class="col-sm-10">
								<input type="checkbox" name="menu" id="menu" onclick="do_with(this.value)" value="pktd" <?php if(in_array('pktd', $p)){ print 'checked="checked"'; } ?>>  <b>Pengurusan Keputusan Temu Duga</b>
							</div>
						</div>

						<div class="row">
							<label for="nama" class="col-sm-2 control-label"></label>
							<div class="col-sm-10"><b>Padanan Kluster</b> <br>
								<div class="col-sm-6">
									&nbsp;&nbsp;<input type="checkbox" name="menu" id="menu" onclick="do_with(this.value)" value="param6" <?php if(in_array('param6', $p)){ print 'checked="checked"'; } ?>> Maklumat Kluster
								</div>
								<div class="col-sm-6">
									&nbsp;&nbsp;<input type="checkbox" name="menu" id="menu" onclick="do_with(this.value)" value="param8" <?php if(in_array('param8', $p)){ print 'checked="checked"'; } ?>> Maklumat Bidang
								</div>
								<div class="col-sm-6">
									&nbsp;&nbsp;<input type="checkbox" name="menu" id="menu" onclick="do_with(this.value)" value="param7" <?php if(in_array('param7', $p)){ print 'checked="checked"'; } ?>> Maklumat Matapelajaran Dan Kluster
								</div>
								<div class="col-sm-6">
									&nbsp;&nbsp;<input type="checkbox" name="menu" id="menu" onclick="do_with(this.value)" value="param16" <?php if(in_array('param16', $p)){ print 'checked="checked"'; } ?>> Padanan Kluster Dan Matapelajaran
								</div>
								<div class="col-sm-6">
									&nbsp;&nbsp;<input type="checkbox" name="menu" id="menu" onclick="do_with(this.value)" value="param20" <?php if(in_array('param20', $p)){ print 'checked="checked"'; } ?>> Maklumat Padanan
								</div>



	
						</div>
						</div>


						<div class="row">
							<label for="nama" class="col-sm-2 control-label"></label>
							<div class="col-sm-10">
								<input type="checkbox" name="menu" id="menu" onclick="do_with(this.value)" value="helpdesk" <?php if(in_array('helpdesk', $p)){ print 'checked="checked"'; } ?>> <b>Helpdesk</b>
							</div>
						</div>
						<div class="row">
							<label for="nama" class="col-sm-2 control-label"></label>
							<div class="col-sm-10">
								<input type="checkbox" name="menu" id="menu" onclick="do_with(this.value)" value="housekeeping" <?php if(in_array('housekeeping', $p)){ print 'checked="checked"'; } ?>> <b>Housekeeping</b>
							</div>
						</div>


						<div class="row">
							<label for="nama" class="col-sm-2 control-label"></label>
							<div class="col-sm-10">
								<!--<input type="checkbox" name="menu" id="menu" onclick="do_with(this.value)" value="pentadbiran" <?php if(in_array('pentadbiran', $p)){ print 'checked="checked"'; } ?>>--> <b>Pentadbiran</b> <br>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="menu" id="menu" onclick="do_with(this.value)" value="pentadbiran" <?php if(in_array('pentadbiran', $p)){ print 'checked="checked"'; } ?>> Pengurusan Pengguna <br>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="menu" id="menu" onclick="do_with(this.value)" value="pentadbiran2" <?php if(in_array('pentadbiran2', $p)){ print 'checked="checked"'; } ?>> Kawalan Menu Permohonan <br>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="menu" id="menu" onclick="do_with(this.value)" value="pentadbiran3" <?php if(in_array('pentadbiran3', $p)){ print 'checked="checked"'; } ?>> Kawalan Muatnaik Dokumen <br>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="menu" id="menu" onclick="do_with(this.value)" value="pentadbiran4" <?php if(in_array('pentadbiran4', $p)){ print 'checked="checked"'; } ?>> Kawalan Tempoh Akaun Pemohon Aktif <br>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="menu" id="menu" onclick="do_with(this.value)" value="pentadbiran5" <?php if(in_array('pentadbiran5', $p)){ print 'checked="checked"'; } ?>> Pengurusan Kandungan Surat <br>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="menu" id="menu" onclick="do_with(this.value)" value="pentadbiran6" <?php if(in_array('pentadbiran6', $p)){ print 'checked="checked"'; } ?>> Pengurusan Hebahan Atau Makluman <br>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="menu" id="menu" onclick="do_with(this.value)" value="pentadbiran7" <?php if(in_array('pentadbiran7', $p)){ print 'checked="checked"'; } ?>> Pengurusan FAQ <br>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="menu" id="menu" onclick="do_with(this.value)" value="pentadbiran9" <?php if(in_array('pentadbiran9', $p)){ print 'checked="checked"'; } ?>> Auditrail <br>

								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="menu" id="pentadbiran8" onclick="do_with(this.value)" value="pentadbiran8" <?php if(in_array('pentadbiran8', $p)){ print 'checked="checked"'; } ?>> Parameter <br>
								<div class="col-sm-10">
									<div class="col-sm-6">
										&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="menu" id="menu" onclick="do_with(this.value)" value="param1" <?php if(in_array('param1', $p)){ print 'checked="checked"'; } ?>> Negeri
									</div>
									<div class="col-sm-6">
										&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="menu" id="menu" onclick="do_with(this.value)" value="param2" <?php if(in_array('param2', $p)){ print 'checked="checked"'; } ?>> Jenis OKU
									</div>
									<div class="col-sm-6">
										&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="menu" id="menu" onclick="do_with(this.value)" value="param3" <?php if(in_array('param3', $p)){ print 'checked="checked"'; } ?>> Pusat Temu Duga
									</div>
									<div class="col-sm-6">
										&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="menu" id="menu" onclick="do_with(this.value)" value="param4" <?php if(in_array('param4', $p)){ print 'checked="checked"'; } ?>> Jenis Domain Emel
									</div>
									<div class="col-sm-6">
										&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="menu" id="menu" onclick="do_with(this.value)" value="param5" <?php if(in_array('param5', $p)){ print 'checked="checked"'; } ?>> Matapelajaran Maklumat Akademik
									</div>
									<div class="col-sm-6">
										&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="menu" id="menu" onclick="do_with(this.value)" value="param9" <?php if(in_array('param9', $p)){ print 'checked="checked"'; } ?>> Institusi
									</div>
									<div class="col-sm-6">
										&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="menu" id="menu" onclick="do_with(this.value)" value="param10" <?php if(in_array('param10', $p)){ print 'checked="checked"'; } ?>> Pengkhususan
									</div>
									<div class="col-sm-6">
										&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="menu" id="menu" onclick="do_with(this.value)" value="param11" <?php if(in_array('param11', $p)){ print 'checked="checked"'; } ?>> Skim
									</div>
									<div class="col-sm-6">
										&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="menu" id="menu" onclick="do_with(this.value)" value="param12" <?php if(in_array('param12', $p)){ print 'checked="checked"'; } ?>> Peringkat Kelulusan
									</div>
									<div class="col-sm-6">
										&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="menu" id="menu" onclick="do_with(this.value)" value="param13" <?php if(in_array('param13', $p)){ print 'checked="checked"'; } ?>> Padanan Kelulusan Dan Institusi
									</div>
									<div class="col-sm-6">
										&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="menu" id="menu" onclick="do_with(this.value)" value="param14" <?php if(in_array('param14', $p)){ print 'checked="checked"'; } ?>> Padanan Institusi Dan Pengkhususan
									</div>
									<div class="col-sm-6">
										&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="menu" id="menu" onclick="do_with(this.value)" value="param15" <?php if(in_array('param15', $p)){ print 'checked="checked"'; } ?>> Padanan Peringkat Akademik Dan Skim
									</div>
								</div>
							</div>
						</div>

						<div class="row">
							<label for="nama" class="col-sm-2 control-label"></label>
							<div class="col-sm-10">
								<input type="checkbox" name="menu" id="menu" onclick="do_with(this.value)" value="laporan" <?php if(in_array('laporan', $p)){ print 'checked="checked"'; } ?>> <b>Laporan</b>
							</div>
						</div>
					</div>
					<input type="hidden" name="menu_select" id="menu_select" value="<?php print $rs->fields['menu'];?>">
					<input type="hidden" name="menu_param" id="menu_param" value="">
					<?php } ?>
					<?php if($jenis == 'admin'){ ?>
					<?php } ?>

					<div class="modal-footer" style="padding:0px;">
						<button type="button" class="btn btn-primary mt-sm mb-sm" id="save" onclick="do_save()"><i class="fa fa-save"></i> Simpan</button>
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