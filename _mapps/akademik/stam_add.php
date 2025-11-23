<script language="javascript">
function do_save(){
	var tahun_add = $('#tahun_add').val();
	// alert(tahun_add);
	if(tahun_add.trim() ==''){
        alert_msg('Sila pilih maklumat tahun.');
        $('#tahun_add').focus(); return false;
	} else {
		$.ajax({
	        url:'akademik/sql_akademik.php?frm=STAM&pro=ADD',
			type:'POST',
	        //dataType: 'json',
	        beforeSend: function () {
	            //$('.btn-primary').attr("disabled","disabled");
	            //$('.modal-body').css('opacity', '.5');
	        },
			data: $("form").serialize(),
			//data: datas,
			success: function(data){
				console.log(data);
				// alert(data);
				var nameArr = data.split(';');
				if(nameArr[0]=='OK'){
					swal({
					  title: 'Berjaya',
					  text: 'Maklumat telah berjaya dikemaskini',
					  type: 'success',
					  confirmButtonClass: "btn-success",
					  confirmButtonText: "Ok",
					  showConfirmButton: true,
					}).then(function () {
						window.location.href=nameArr[1];
						// reload = window.location; 
						// window.location = reload;
					});
				} else if(data=='ERR'){
					swal({
					  title: 'Amaran',
					  text: 'Terdapat ralat sistem.\nMaklumat anda tidak berjaya dikemaskini.',
					  type: 'error',
					  confirmButtonClass: "btn-warning",
					  confirmButtonText: "Ok",
					  showConfirmButton: true,
					});
				}
				//window.location.reload();

			},
			//data: datas
	    });
	}
}

function do_close(){
	reload = window.location; 
	window.location = reload;
}
</script>
<?php
$id_pemohon=isset($_REQUEST["id_pemohon"])?$_REQUEST["id_pemohon"]:"";
$tahun=isset($_REQUEST["tahun"])?$_REQUEST["tahun"]:"";
$tahun_1 = $tahun+1;
$tahun_2 = $tahun+3;
?>
<div class="col-lg-12">
	<section class="panel">
		<header class="panel-heading"  style="background-color:rgb(38, 167, 228)">
			<h6 class="panel-title"><font color="#000000" size="3"><b>TAMBAH MAKLUMAT PEPERIKSAAN STAM KALI KE 2</b></font></h6>
		</header>
		<div class="panel-body">
			<div class="box-body">

			<input type="hidden" name="id_pemohon" id="id_pemohon" value="<?php print $id_pemohon;?>" readonly="readonly"/>
			<input type="hidden" name="tahun" id="tahun" value="<?php print $tahun;?>" readonly="readonly"/>

				<div class="col-md-12">

					<div class="form-group">
						<div class="row">
							<label for="nama" class="col-sm-4 control-label"><b>TAHUN PEPERIKSAAN <font color="#FF0000">*</font> : </b></label>
							<div class="col-sm-3">
								<select name="tahun_add" id="tahun_add" class="form-control">
					                <option value="">-- Sila pilih tahun --</option>
					                <?php for($t=$tahun_1;$t<=$tahun_2;$t++){ ?>
					                <option value="<?php print $t;?>"><?php print $t;?></option>
					                <?php } ?>    
					            </select>	
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
