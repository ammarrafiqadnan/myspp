<?php include '../../connection/common.php'; ?>
<script>
	function do_save(){
		var tarikh_mula = $('#tarikh_mula').val();
		var masa_mula = $('#masa_mula').val();
		var tarikh_tamat = $('#tarikh_tamat').val();
		var masa_tamat = $('#masa_tamat').val();


		if (tarikh_mula.trim() == '' ){
			alert_msg('Sila pilih maklumat tarikh mula.');
			$('#tarikh_mula').focus(); return true;
		} else if(masa_mula.trim() == '' ){
			alert_msg('Sila pilih maklumat masa mula.');
			$('#masa_mula').focus(); return true;
		} else if(tarikh_tamat.trim() == '' ){
			alert_msg('Sila pilih maklumat tarikh tamat.');
			$('#tarikh_tamat').focus(); return true;
		} else if(masa_tamat.trim() == '' ){
			alert_msg('Sila pilih maklumat masa tamat.');
			$('#masa_tamat').focus(); return true;
		} else { 

			$.ajax({
				url:'muatnaikExcel/sql_muatnaikExcel.php?frm=PENETAPAN_TARIKH&pro=SAVE',
				type:'POST',
				//dataType: 'json',
				// beforeSend: function () {
				// 	$('.btn-primary').attr("disabled","disabled");
				// 	$('.modal-body').css('opacity', '.5');
				// },
				data: $("form").serialize(),
				//data:  fd,
	            //contentType: false,
	            //cache: false,
	            //processData:false,
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
						});
					}
				},
			});   
		}
	}
</script>
<?php
	//$conn->debug=true;
	$kategori=isset($_REQUEST["kategori"])?$_REQUEST["kategori"]:""; //panggilan atau keputusan
	$kod_pk=isset($_REQUEST["kod_pk"])?$_REQUEST["kod_pk"]:""; //kod_panggilan_temuduga atau kod_keputusan_temuduga
	$kod=isset($_REQUEST["kod"])?$_REQUEST["kod"]:"";
	//print $kod.'/'.$kod_pk.'/'.$kategori;

	if($kategori == 'panggilan'){
		$sql3 = "SELECT * FROM $schema2.`senarai_panggilan_temuduga` WHERE kod=".tosql($kod)." AND kod_panggilan_temuduga=".tosql($kod_pk);
		$rs = $conn->query($sql3);
	} else if($kategori == 'keputusan'){
		$sql3 = "SELECT * FROM $schema2.`senarai_keputusan_temuduga` WHERE kod=".tosql($kod)." AND kod_keputusan_temuduga=".tosql($kod_pk);
		$rs = $conn->query($sql3);
	}
?>
<div class="col-lg-12">
	<section class="panel">
		<header class="panel-heading"  style="background-color:rgb(38, 167, 228)">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="do_close()">X</button>
			<h6 class="panel-title"><font color="#000000" size="3"><b>MAKLUMAT TARIKH <?php if($kategori == 'panggilan'){ print 'PANGGILAN'; } else if($kategori == 'keputusan'){ print 'KEPUTUSAN'; } ?> TEMU DUGA BAGI <?=$rs->fields['nama_penuh'];?></b></font></h6>
		</header>
		<div class="panel-body">
			<div class="box-body">

			    <input type="hidden" name="kod" id="kod" value="<?=$kod;?>">
				<input type="hidden" name="kod_pk" id="kod_pk" value="<?=$kod_pk;?>">
			<input type="hidden" name="kategori" id="kategori" value="<?=$kategori;?>">


                <div class="col-md-12">
                     <div class="form-group">
                        <div class="row">
                            <label for="nama" class="col-sm-2 control-label"><b> Tarikh Mula<div style="float:right">:</div></b></label>
                            <div class="col-sm-3">
                                <input type="date" name="tarikh_mula" id="tarikh_mula" class="form-control" value="<?=$rs->fields['tarikh_mula'];?>">
                            </div>
                            <div class="col-sm-2">&nbsp;</div>
                            <label for="nama" class="col-sm-2 control-label"><b> Masa Mula<div style="float:right">:</div></b></label>
                            <div class="col-sm-3">
                                <input type="time" name="masa_mula" id="masa_mula" class="form-control" value="<?=$rs->fields['masa_mula'];?>">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label for="nama" class="col-sm-2 control-label"><b> Tarikh Tamat<div style="float:right">:</div></b></label>
                            <div class="col-sm-3">
                                <input type="date" name="tarikh_tamat" id="tarikh_tamat" class="form-control" value="<?=$rs->fields['tarikh_tamat'];?>">
                            </div>
                            <div class="col-sm-2">&nbsp;</div>
                            <label for="nama" class="col-sm-2 control-label"><b> Masa Tamat<div style="float:right">:</div></b></label>
                            <div class="col-sm-3">
                                <input type="time" name="masa_tamat" id="masa_tamat" class="form-control" value="<?=$rs->fields['masa_tamat'];?>">
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