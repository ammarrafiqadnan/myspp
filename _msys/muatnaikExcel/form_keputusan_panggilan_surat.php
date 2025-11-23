<?php include '../../connection/common.php'; ?>
<script>
	function do_proses(){
		var kod = $('#kod').val();

		swal({
			title: 'Adakah anda pasti untuk memproses surat keputusan temuduga?',
			type: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Ya, Teruskan',
			cancelButtonText: 'Tidak, Batal!',
			reverseButtons: true
		}).then(function(e) {
            

		$.ajax({
		url:'muatnaikExcel/sql_proses_surat.php?frm=SURAT&pro=PROSES_PANGGILAN',
		type:'POST',
		//dataType: 'json',
		beforeSend: function () {
			// $('.btn-primary').attr("disabled","disabled");
			// $('.modal-body').css('opacity', '.5');
		},
		data: $("form").serialize(),
		//data:  fd,
	            //contentType: false,
	            //cache: false,
	            //processData:false,
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
<input type="hidden" name="kod" id="kod" value="<?=$kod;?>">
<div class="col-lg-12">
	<section class="panel">
		<header class="panel-heading"  style="background-color:rgb(38, 167, 228)">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="do_close()">×</button>
			<h6 class="panel-title"><font color="#000000" size="3"><b>PROSES SURAT <?=strtoupper($rs->fields['tajuk']);?></b></font></h6>
		</header>
		<div class="panel-body">
			<div class="box-body">

			    <input type="hidden" name="kod_keputusan_temuduga" id="kod_keputusan_temuduga" value="<?php print $rs->fields['kod']; ?>">

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
                    
                     
			<?php $rsSurat = $conn->query("SELECT * FROM $schema2.`kandungan_surat` WHERE `is_deleted`=0 AND `status`=0 AND kod=".tosql($rs->fields['kod_surat'])); ?>
                    <div class="form-group">
                        <div class="row">
                            <label for="nama" class="col-sm-2 control-label"><b> Kandungan Surat<div style="float:right">:</div></b></label>
                            <div class="col-sm-10">
                                <select name="kod_surat" id="kod_surat" class="form-control">
				<?php while(!$rsSurat->EOF){ ?>
					<option value="<?=$rsSurat->fields['kod'];?>" <?php if($rsSurat->fields['kod']==$rs->fields['kod_surat']){ print'selected'; }?>><?=$rsSurat->fields['tajuk'];?></option>
				<?php $rsSurat->movenext(); } ?>	
				</select>
                            </div>
                        </div>
                    </div>


                    <div class="modal-footer" style="padding:0px;">
						<button type="button" class="btn btn-primary mt-sm mb-sm" onclick="do_proses()"><i class="fa fa-save"></i> Proses</button>
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