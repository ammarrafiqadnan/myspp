<?php include '../../connection/common.php'; ?>
<script>
	function do_save(){
		var kod = $('#kod').val();

		swal({
			title: 'Adakah anda pasti untuk menutanaik data bagi urusan panggilan temuduga?',
			//text: "You won't be able to revert this!",
			type: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Ya, Teruskan',
			cancelButtonText: 'Tidak, Batal!',
			reverseButtons: true
		}).then(function(e) {
            
            // var formData = new FormData($('#jawi')[0]);

			var fd = new FormData();
	        var files1 = $('#file1')[0].files[0];
	        fd.append('file1',files1);

	        var other_data = $('form').serializeArray();
			$.each(other_data,function(key,input){
			    fd.append(input.name,input.value);
			});

			$.ajax({
				url:'muatnaikExcel/sql_muatnaikExcel.php?frm=PANGGILAN_TEMUDUGA&pro=UPLOAD',
				type:'POST',
				//dataType: 'json',
				beforeSend: function () {
					// $('.btn-primary').attr("disabled","disabled");
					// $('.modal-body').css('opacity', '.5');
				},
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
		});
	}
</script>
<?php
	// $conn->debug=true;
	$kod=isset($_REQUEST["kod"])?$_REQUEST["kod"]:"";
	//print $kod;
	$sql3 = "SELECT * FROM $schema2.`panggilan_temuduga` WHERE kod='{$kod}'";
	$rs = $conn->query($sql3);
?>
<div class="col-lg-12">
	<section class="panel">
		<header class="panel-heading"  style="background-color:rgb(38, 167, 228)">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="do_close()">×</button>
			<h6 class="panel-title"><font color="#000000" size="3"><b>TAMBAH MAKLUMAT <?=strtoupper($rs->fields['tajuk']);?></b></font></h6>
		</header>
		<div class="panel-body">
			<div class="box-body">

			    <input type="hidden" name="kod_panggilan_temuduga" id="kod_panggilan_temuduga" value="<?php print $rs->fields['kod']; ?>">

                <div class="col-md-12">
                    <div class="form-group">
                        <div class="row">
                            <label for="nama" class="col-sm-2 control-label"><b>Tajuk Hebahan<div style="float:right">:</div></b></label>
                            <div class="col-sm-10"><?php if(!empty($kod)){ print $rs->fields['tajuk'];} ?></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label for="nama" class="col-sm-2 control-label"><b> Tarikh Mula Hebah<div style="float:right">:</div></b></label>
                            <div class="col-sm-3"><?php print DisplayDate($rs->fields['tarikh_mula']); ?></div>
                            <label for="nama" class="col-sm-2 control-label"><b> Masa Mula Hebah<div style="float:right">:</div></b></label>
                            <div class="col-sm-3"><?php print $rs->fields['masa_mula']; ?></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label for="nama" class="col-sm-2 control-label"><b> Tarikh Tamat Hebah<div style="float:right">:</div></b></label>
                            <div class="col-sm-3"><?php print DisplayDate($rs->fields['tarikh_tamat']); ?></div>
                            <label for="nama" class="col-sm-2 control-label"><b> Masa Tamat Hebah<div style="float:right">:</div></b></label>
                            <div class="col-sm-3"><?php if(!empty($kod)){ print $rs->fields['masa_tamat'];} ?></div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="row">
                            <label for="nama" class="col-sm-2 control-label"><b> Dokumen<div style="float:right">:</div></b></label>
                            <div class="col-sm-10">
                                <input type="file" name="file1" id="file1" class="form-control" value="">
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