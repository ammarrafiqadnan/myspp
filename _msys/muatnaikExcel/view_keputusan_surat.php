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
		url:'muatnaikExcel/sql_proses_surat.php?frm=SURAT&pro=PROSES',
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
	$sql3 = "SELECT * FROM $schema2.`senarai_keputusan_temuduga` WHERE kod='{$kod}'";
	$rs = $conn->query($sql3);
?>
<input type="hidden" name="kod" id="kod" value="<?=$kod;?>">
<div class="col-lg-12">
	<section class="panel">
		<header class="panel-heading"  style="background-color:rgb(38, 167, 228)">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"  data-dismiss="modal">×</button>
			<h6 class="panel-title"><font color="#000000" size="3"><b>MAKLUMAT SURAT TAWARAN</b></font></h6>
		</header>
		<div class="panel-body">
			<div class="box-body">

			    <input type="hidden" name="kod_keputusan_temuduga" id="kod_keputusan_temuduga" value="<?php print $rs->fields['kod']; ?>">

                <div class="col-md-12">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12"><?php if(!empty($kod)){ print $rs->fields['keputusan_surat'];} ?></div>
                        </div>
                    </div>

                    <div class="modal-footer" style="padding:0px;">
			<button type="button" class="btn btn-default"  data-dismiss="modal"><i class="fa fa-spinner" style="margin:0px;"></i> Kembali</button>
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