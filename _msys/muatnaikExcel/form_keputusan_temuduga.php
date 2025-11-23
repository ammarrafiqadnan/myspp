<?php include '../../connection/common.php'; ?>
<script>
	function do_save(){
		// var kod = $('#kod').val();
		var tajuk = $('#tajuk').val();
		var kod_surat = $('#kod_surat').val();
		var tarikh_mula = $('#tarikh_mula').val();
		var masa_mula = $('#masa_mula').val();
		var tarikh_tamat = $('#tarikh_tamat').val();
		var masa_tamat = $('#masa_tamat').val();

		var fd = new FormData();
		var dokumen = $('#dokumen')[0].files[0];
		fd.append('dokumen',dokumen);

        // fd.append('tajuk', tajuk);
        // fd.append('tarikh_mula', tarikh_mula);
        // fd.append('masa_mula', masa_mula);
        // fd.append('tarikh_tamat', tarikh_tamat);
        // fd.append('masa_tamat', masa_tamat);
		// alert(tarikh_mula);

		if (tajuk.trim() == '' ){
			alert_msg('Sila pilih maklumat tajuk.');
			$('#tajuk').focus(); return true;
		} else if(kod_surat.trim() == '' ){
			alert_msg('Sila pilih maklumat surat bagi proses janaan surat.');
			$('#kod_surat').focus(); return true;
		} else if(tarikh_mula.trim() == '' ){
			alert_msg('Sila pilih maklumat tarikh_mula.');
			$('#tarikh_mula').focus(); return true;
		} else if(masa_mula.trim() == '' ){
			alert_msg('Sila pilih maklumat masa_mula.');
			$('#masa_mula').focus(); return true;
		} else if(tarikh_tamat.trim() == '' ){
			alert_msg('Sila pilih maklumat tarikh_tamat.');
			$('#tarikh_tamat').focus(); return true;
		} else if(masa_tamat.trim() == '' ){
			alert_msg('Sila pilih maklumat masa_tamat.');
			$('#masa_tamat').focus(); return true;
		} else { 
            
            // var formData = new FormData($('#jawi')[0]);

//			var fd = new FormData();
	        // var files1 = $('#file1')[0].files[0];
	        // fd.append('file1',files1);

	        var other_data = $('form').serializeArray();
		$.each(other_data,function(key,input){
		    fd.append(input.name,input.value);
		});

		$.ajax({
			url:'muatnaikExcel/sql_muatnaikExcel.php?frm=KEPUTUSAN_TEMUDUGA&pro=SAVE',
			type:'POST',
			//dataType: 'json',
			// beforeSend: function () {
			// 	$('.btn-primary').attr("disabled","disabled");
			// 	$('.modal-body').css('opacity', '.5');
			// },
			// data: $("form").serialize(),
			data:  fd,
	            contentType: false,
	            cache: false,
	            processData:false,
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
</script>
<?php
	//$conn->debug=true;
	$kod=isset($_REQUEST["kod"])?$_REQUEST["kod"]:"";
	//print $kod;
	$sql3 = "SELECT * FROM $schema2.`keputusan_temuduga` WHERE kod='{$kod}'";
	$rs = $conn->query($sql3);
?>
<div class="col-lg-12">
	<section class="panel">
		<header class="panel-heading"  style="background-color:rgb(38, 167, 228)">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="do_close()">×</button>
			<h6 class="panel-title"><font color="#000000" size="3"><b>TAMBAH MAKLUMAT KEPUTUSAN TEMU DUGA</b></font></h6>
		</header>
		<div class="panel-body">
			<div class="box-body">

			    <input type="hidden" name="kod" id="kod" value="<?php if(!empty($kod)){ print $rs->fields['kod'];} ?>">

                <div class="col-md-12">
                    <div class="form-group">
                        <div class="row">
                            <label for="nama" class="col-sm-2 control-label"><b>Tajuk Hebahan<div style="float:right">:</div></b></label>
                            <div class="col-sm-10">
                                <input type="text" name="tajuk" id="tajuk" class="form-control" value="<?php if(!empty($kod)){ print $rs->fields['tajuk'];} ?>">
                            </div>
                        </div>
                    </div> 
			<?php $rsSurat = $conn->query("SELECT * FROM $schema2.`kandungan_surat` WHERE `is_deleted`=0 AND `status`=0"); ?>
                    <div class="form-group">
                        <div class="row">
                            <label for="nama" class="col-sm-2 control-label"><b> Kandungan Surat<div style="float:right">:</div></b></label>
                            <div class="col-sm-10">
                                <select name="kod_surat" id="kod_surat" class="form-control">
					<option value=""></option>
				<?php while(!$rsSurat->EOF){ ?>
					<option value="<?=$rsSurat->fields['kod'];?>" <?php if($rsSurat->fields['kod']==$rs->fields['kod_surat']){ print'selected'; }?>><?=$rsSurat->fields['tajuk'];?></option>
				<?php $rsSurat->movenext(); } ?>	
				</select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <label for="nama" class="col-sm-2 control-label"><b> Lampiran<div style="float:right">:</div></b></label>
                            <div class="col-sm-10">
				<input type="file" name="dokumen" id="dokumen" class="form-control" value="" accept="application/pdf">
				<?php if(!empty($rs->fields['file_lampiran'])){ 
					print '<a href="../upload_doc/'.$rs->fields['file_lampiran'].'" target="_blank">'.$rs->fields['file_lampiran'].'</a>'; 
				} ?>
                            </div>
                        </div>
                    </div>
			
                    <div class="form-group">
                        <div class="row">
                            <label for="nama" class="col-sm-2 control-label"><b> Tarikh Mula Hebah<div style="float:right">:</div></b></label>
                            <div class="col-sm-3">
                                <input type="date" name="tarikh_mula" id="tarikh_mula" class="form-control" value="<?php if(!empty($kod)){ print $rs->fields['tarikh_mula'];} ?>">
                            </div>
                            <label for="nama" class="col-sm-2 control-label"><b> Masa Mula Hebah<div style="float:right">:</div></b></label>
                            <div class="col-sm-3">
                                <input type="time" name="masa_mula" id="masa_mula" class="form-control" value="<?php if(!empty($kod)){ print $rs->fields['masa_mula'];} ?>">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label for="nama" class="col-sm-2 control-label"><b> Tarikh Tamat Hebah<div style="float:right">:</div></b></label>
                            <div class="col-sm-3">
                                <input type="date" name="tarikh_tamat" id="tarikh_tamat" class="form-control" value="<?php if(!empty($kod)){ print $rs->fields['tarikh_tamat'];} ?>">
                            </div>
                            <label for="nama" class="col-sm-2 control-label"><b> Masa Tamat Hebah<div style="float:right">:</div></b></label>
                            <div class="col-sm-3">
                                <input type="time" name="masa_tamat" id="masa_tamat" class="form-control" value="<?php if(!empty($kod)){ print $rs->fields['masa_tamat'];} ?>">
                            </div>
                        </div>
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