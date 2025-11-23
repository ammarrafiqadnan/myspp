<?php include '../../../connection/common.php'; ?>
<script>
	function do_save(){
		// var kod = $('#kod').val();
		var pengkhususan = $('#pengkhususan').val();
		var peringkatKelulusan = $('#peringkatKelulusan1').val();		
		var status_pengkhususan = $('#status_pengkhususan').val();


		// alert(status_pengkhususan);

		 if(pengkhususan.trim() == '' ){
			alert_msg('Sila isi maklumat pengkhususan.');
			$('#pengkhususan').focus(); return true;
		} else if(peringkatKelulusan.trim() == '' ){
			alert_msg('Sila pilih maklumat peringkat kelulusan.');
			$('#peringkatKelulusan').focus(); return true;
		} else if(status_pengkhususan.trim() == '' ){
			alert_msg('Sila pilih maklumat status pengkhususan.');
			$('#status_pengkhususan').focus(); return true;
		} else { 
			$.ajax({
				url:'pengurusan/sql_pengurusan.php?frm=PARAMETER&jenis=PENGKHUSUSAN&pro=SAVE&p='+peringkatKelulusan,
				type:'POST',
				//dataType: 'json',
				beforeSend: function () {
					//$('.btn-primary').attr("disabled","disabled");
					//$('.modal-body').css('opacity', '.5');
				},
				data: $("form").serialize(),
				success: function(data){
					console.log(data);
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
						});
					}
				},
			});   
		}
	}

	// function do_kod(kod) {
	// 	// alert('sini');
	// 	$.ajax({
	// 		url:'pengurusan/sql_pengurusan.php?frm=PARAMETER&jenis=PENGKHUSUSAN&pro=CHECK_KOD&kod='+kod,
	// 		type:'POST',
	// 		//dataType: 'json',
	// 		data: $("form").serialize(),
	// 		success: function(data){
	// 			console.log(data);
	// 			if(data=='ERR'){
	// 				swal({
	// 					title: 'Amaran',
	// 					text: 'Kod telah wujud. Sila masukkan kod lain.',
	// 					type: 'error',
	// 					confirmButtonClass: "btn-warning",
	// 					confirmButtonText: "Ok",
	// 					showConfirmButton: true,
	// 				})
	// 				// .then(function () {
	// 				// 	document.getElementById("kod").value = "";
	// 				// });
	// 			}

				
	// 		},
	// 	});
	// }

	function do_pengkhususan(pengkhususan) {
		
		//alert(pengkhususan);
		var peringkatKelulusan = $('#peringkatKelulusan1').val();
		$.ajax({
			url:'pengurusan/sql_pengurusan.php?frm=PARAMETER&jenis=PENGKHUSUSAN&pro=CHECK_PENGKHUSUSAN&pengkhususan='+pengkhususan+'&p='+peringkatKelulusan,
			type:'POST',
			//dataType: 'json',
			data: $("form").serialize(),
			success: function(data){
				console.log(data);
				if(data=='ERR'){
					swal({
						title: 'Amaran',
						text: 'Pengkhususan telah wujud. Sila masukkan pengkhususan lain.',
						type: 'error',
						confirmButtonClass: "btn-warning",
						confirmButtonText: "Ok",
						showConfirmButton: true,
					}).then(function () {
						document.getElementById("save").style.display = "none";
					});
				} else {
					document.getElementById("save").style.display = "inline";
					//document.getElementById("save").style.display = "block";
				}

				
			},
		});
	}
</script>
<?php
	// $conn->debug=true;
	$institusi_kod=isset($_REQUEST["institusi_kod"])?$_REQUEST["institusi_kod"]:"";
	$peringkat=isset($_REQUEST["peringkat"])?$_REQUEST["peringkat"]:"";
	$kod_ip=isset($_REQUEST["kod_ip"])?$_REQUEST["kod_ip"]:"";
	//print $pengkhususan_kod;
	// $sql3 = "SELECT * FROM $schema1.`ref_pengkhususan` WHERE kod='{$kod}'";
    $sql3 = "SELECT * FROM $schema1.padanan_institusi_pengkhususan A, $schema1.`ref_pengkhususan` B 
	WHERE A.kod_pengkhususan=B.kod AND B.is_deleted=0 AND A.kod=".tosql($kod_ip);//." AND A.peringkat_kelulusan=".tosql($peringkatKelulusan);
	$rs = $conn->query($sql3);

	if(!$rs->EOF){
		$kod_pengkhususan = $rs->fields['kod_pengkhususan'];
		$peringkat = $rs->fields['id_peringkat_kelulusan'];
		$DISKRIPSI = $rs->fields['DISKRIPSI'];
		$NO_PEMEROLEHAN = $rs->fields['NO_PEMEROLEHAN'];
	} else {

	}

    $rfKelulusan = $conn->query("SELECT * FROM $schema1.`ref_peringkat_kelulusan` WHERE `is_deleted`='0' AND `status`=0"); 

?>
<div class="col-lg-12">
	<section class="panel">
		<header class="panel-heading"  style="background-color:rgb(38, 167, 228)">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="do_close()">×</button>
			<h6 class="panel-title"><font color="#000000" size="3"><b><?php if(!empty($kod_ip)){ print 'KEMASKINI'; } else { print 'TAMBAH'; } ?> MAKLUMAT PENGKHUSUSAN BERDASARKAN MAKLUMAT INSTITUSI</b></font></h6>
		</header>
		<div class="panel-body">
			<div class="box-body">

			<input type="hidden" name="kod_ip" id="kod_ip" value="<?php if(!empty($kod_ip)){ print $kod_ip; } ?>">
			<input type="hidden" name="kod" id="kod" value="<?php if(!empty($kod_pengkhususan)){ print $kod_pengkhususan; } ?>">

				<div class="col-md-12">
                    <div class="form-group">
						<div class="row">
							<label for="kod" class="col-sm-2 control-label"><b>Nama Institusi : </b></label>
							<div class="col-sm-10">
								<b><?php print dlookup("$schema1.ref_institusi","DISKRIPSI","KOD=".tosql($institusi_kod)); ?></b>
								<input type="hidden" name="institusi_kod" id="institusi_kod" value="<?=$institusi_kod;?>">
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="row">
							<label for="kod" class="col-sm-2 control-label"><b>Peringkat Kelulusan <font color="#FF0000">*</font> : </b></label>
							<div class="col-sm-10">
								<select name="peringkatKelulusan" id="peringkatKelulusan1" class="form-control" onchange="do_pengkhususan(this.value)">
				                    <option value="">Sila pilih peringkat kelulusan</option>
				                    <?php while(!$rfKelulusan->EOF){ ?>
				                    <option value="<?=$rfKelulusan->fields['kod'];?>" <?php if($peringkat==$rfKelulusan->fields['kod']){ print 'selected'; }?>><?php print strtoupper($rfKelulusan->fields['diskripsi']);?></option>  
				                    <?php $rfKelulusan->movenext(); } ?>
				                </select>
								<!-- <input type="hidden" name="institusi_kod" id="institusi_kod" value="<?=$institusi_kod;?>"> -->
							</div>
						</div>
					</div>
                    <div class="form-group">
						<div class="row">
							<label for="pengkhususan" class="col-sm-2 control-label"><b>Pengkhususan <font color="#FF0000">*</font> : </b></label>
							<div class="col-sm-10">
								<textarea name="pengkhususan" id="pengkhususan" rows="2" class="form-control" onchange="do_pengkhususan(this.value)"><?php if(!empty($kod_ip)){ print $DISKRIPSI; } ?></textarea>
							</div>
						</div>
					</div>

					<div class="form-group">
						<div class="row">
                            <label for="tajuk" class="col-sm-2 control-label"><b>No. Pemerolehan : </b></label>
							<div class="col-sm-3">
								<input type="text" name="no_pemerolehan" id="no_pemerolehan" class="form-control" value="<?php if(!empty($kod_ip)){ print $NO_PEMEROLEHAN; }?>" maxlength="10">
							</div>
						</div>
					</div>

					<div class="form-group">
						<div class="row">
                            <label for="tajuk" class="col-sm-2 control-label"><b>Status <font color="#FF0000">*</font> : </b></label>
							<div class="col-sm-3">
                                <select name="status_pengkhususan" id="status_pengkhususan" class="form-control">
                                    <option value="">Sila pilih status</option>
                                    <option value="0" <?php if(!empty($kod_ip)){ if($rs->fields['STATUS'] == 0){ print 'selected';}} ?>>Aktif</option>
                                    <option value="1" <?php if(!empty($kod_ip)){  if($rs->fields['STATUS'] == 1){ print 'selected';} } ?>>Tidak Aktif</option>
                                </select>
                            </div>
						</div>
					</div>

					<div class="modal-footer" style="padding:0px;">
						<button type="button" id="save" class="btn btn-primary mt-sm mb-sm" onclick="do_save()"><i class="fa fa-save"></i> Simpan</button>
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