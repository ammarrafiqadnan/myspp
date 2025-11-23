<?php include '../connection/common.php'; ?>
<script language="javascript">
function do_save(val1, val2){
    var reg = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
    var ulasan = $('#ulasan').val();
    var status_proses = $('#status_proses').val();
    
    if(ulasan.trim() == '' ){
        alert('Sila masukkan maklumat ulasan.');
        $('#ulasan').focus(); return false;
	} else if(status_proses.trim() == '' && val2.trim()=='SEND'){
        alert('Sila pilih status ulasan.');
        $('#status_proses').focus(); return false;
	} else {
		if(val2=='SEND'){
			swal({
			 	title: 'Perhatian',
				// title: 'Adakah anda pasti untuk menghapuskan data ini?',
		        text: "Adakah anda pasti untuk mengesahkan data ini?",
		        type: 'warning',
		        showCancelButton: true,
		        confirmButtonColor: '#3085d6',
		        cancelButtonColor: '#d33',
		        confirmButtonText: 'Ya, Teruskan',
		        cancelButtonText: 'Tidak, Batal!',
		        reverseButtons: true
			}).then(function () {
				do_send(val1, val2);
			});
		} else {
			do_send(val1, val2);
		}
    }
}

function do_send(val1, val2){
	$.ajax({
        url:'maklumat/sql_maklumat.php?frm=ULASAN_PENGARAH&pro='+val1+'&act='+val2,
		type:'POST',
        //dataType: 'json',
        beforeSend: function () {
            $('.btn-primary').attr("disabled",true);
            $('.btn-success').attr("disabled",true);
            $('.modal-body').css('opacity', '.5');
        },
		data: $("form").serialize(),
		//data: datas,
		success: function(data){
			console.log(data);
			// alert(data);
			if(data=='OK'){
				swal({
				  title: 'Berjaya',
				  text: 'Maklumat telah berjaya dikemaskini',
				  type: 'success',
				  confirmButtonClass: "btn-success",
				  confirmButtonText: "Ok",
				  showConfirmButton: true,
				}).then(function () {
					if(val2=='SEND'){ 
						reload = window.location; 
						window.location = reload;
					} else {
						$('.btn-primary').attr("disabled",false);
				        $('.btn-success').attr("disabled",false);
				        $('.modal-body').css('opacity', '0');
					}
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
</script>
<?php
$_SESSION['page_name']="ULASAN PENGARAH";
// $conn->debug=true;
$id=isset($_REQUEST["id"])?$_REQUEST["id"]:"";
$kategori=isset($_REQUEST["kategori"])?$_REQUEST["kategori"]:"";
$read_only='';

$sql = "SELECT * FROM `tbl_pemantauan` WHERE `pemantauan_id`=".tosql($id);
$rs = $conn->query($sql);
$jenis = $rs->fields['pemantauan_type'];
$status = dlookup("_ref_status","status_nama","status_id=".tosql($rs->fields['status_proses']));
// PRINT "DD:".$read_only;

?>
<div class="col-lg-12">
	<section class="panel">
		<header class="panel-heading"  style="background-color:rgb(38, 167, 228)">
			<h6 class="panel-title"><font color="#000000" size="3"><b>MAKLUMAT PEMANTAUAN - <i style="color:#f00"><?=$status;?></i></b></font></h6>
		</header>
		<div class="panel-body">
			<div class="box-body">

			<input type="hidden" name="pemantauan_id" id="pemantauan_id" value="<?php print $id;?>" readonly="readonly"/>

				<div class="col-md-12">

					<div class="form-group">
						<div class="row">
							<label for="nama" class="col-sm-2 control-label"><b>KATEGORI PEMANTAUAN <font color="#FF0000">*</font> : </b></label>
							<div class="col-sm-10">
								<b><?php print dlookup("`_ref_kategori_sub`","subkat_nama","subkat_id='{$jenis}'"); ?></b>
							</div>
						</div>
					</div>

					<div class="form-group">
						<div class="row">
							<label for="nama" class="col-sm-2 control-label"><b>TAJUK <font color="#FF0000">*</font> : </b></label>
							<div class="col-sm-10"><?php print $rs->fields['tajuk'];?></div>
						</div>
					</div>

					<div class="form-group">
						<div class="row">
							<label for="nama" class="col-sm-2 control-label"><b>TARIKH <font color="#FF0000">*</font> : </b></label>
							<div class="col-sm-3"><?php print DisplayDate($rs->fields['tarikh']);?></div>
						</div>
					</div>

					<div class="form-group">
						<div class="row">
							<label for="nama" class="col-sm-2 control-label"><b>TEMPAT <font color="#FF0000">*</font> : </b></label>
							<div class="col-sm-10"><?php print nl2br($rs->fields['tempat']);?></div>
						</div>
					</div>

					<div class="form-group">
						<div class="row">
							<label for="nama" class="col-sm-2 control-label"><b>PEGAWAI PEMANTAU <font color="#FF0000">*</font> : </b><br>SENARAI NAMA</label>
							<div class="col-sm-10"><?php print nl2br($rs->fields['pegawai']);?></div>
					</div>

					<div class="form-group">
						<div class="row">
							<label for="nama" class="col-sm-2 control-label"><b>TUJUAN <font color="#FF0000">*</font> : </b></label>
							<div class="col-sm-10"><?php print nl2br($rs->fields['tujuan']);?></div>
						</div>
					</div>

					<div class="form-group">
						<div class="row">
							<label for="nama" class="col-sm-2 control-label"><b>HASIL PEMANTAUAN <font color="#FF0000">*</font> : </b></label>
							<div class="col-sm-10"><?php print nl2br($rs->fields['laporan_kajian']);?></div>
						</div>
					</div>

					<div class="form-group">
						<div class="row">
							<label for="nama" class="col-sm-2 control-label"><b>SYOR / CADANGAN <font color="#FF0000">*</font> : </b></label>
							<div class="col-sm-10"><?php print nl2br($rs->fields['syor']);?></div>
						</div>
					</div>
					
					<?php $rsKB = $conn->query("SELECT * FROM `tbl_pemantauan_ulasan` WHERE `pemantauan_id`='{$id}' AND `jenis_ulasan`=3"); ?>
					<div class="form-group">
						<div class="row">
							<label for="nama" class="col-sm-2 control-label"><b>ULASAN KETUA BAHAGIAN <font color="#FF0000">*</font> : </b></label>
							<div class="col-sm-10"><?php print nl2br($rsKB->fields['ulasan']);?></div>
						</div>
					</div>

					<?php $rsTP = $conn->query("SELECT * FROM `tbl_pemantauan_ulasan` WHERE `pemantauan_id`='{$id}' AND `jenis_ulasan`=5"); ?>
					<div class="form-group">
						<div class="row">
							<label for="nama" class="col-sm-2 control-label"><b>ULASAN TIMBALAN KETUA PENGARAH (O) <font color="#FF0000">*</font> : </b></label>
							<div class="col-sm-10"><?php print nl2br($rsTP->fields['ulasan']);?></textarea>
							</div>
						</div>
					</div>

					<?php $rsP = $conn->query("SELECT * FROM `tbl_pemantauan_ulasan` WHERE `pemantauan_id`='{$id}' AND `jenis_ulasan`=7"); ?>
					<div class="form-group">
						<div class="row">
							<label for="nama" class="col-sm-2 control-label"><b>ULASAN PENGARAH JAWI <font color="#FF0000">*</font> : </b></label>
							<div class="col-sm-10">
								<textarea name="ulasan" id="ulasan" class="form-control" rows="6"><?php print $rsP->fields['ulasan'];?></textarea>
							</div>
						</div>
					</div>

					<div class="form-group">
						<div class="row">
							<label for="nama" class="col-sm-2 control-label"><b>STATUS : </b></label>
							<div class="col-sm-5">
								<select name="status_proses" id="status_proses" class="form-control">
									<option value="">Sila pilih keputusan</option>
									<option value="5">Dikembalikan kepada Timbalan Pengarah (O)</option>
									<option value="9">Selesai</option>
								</select>
							</div>
						</div>
					</div>
		

					<div class="modal-footer" style="padding:0px;">
						<button type="button" class="btn btn-primary mt-sm mb-sm" onclick="do_save('SAVE','')"><i class="fa fa-save"></i> Simpan</button>
						&nbsp;
						<button type="button" class="btn btn-success mt-sm mb-sm" onclick="do_save('SAVE','SEND')"><i class="fa fa-save"></i> Simpan & Hantar</button>
						&nbsp;
						<button type="button" class="btn btn-default" 
							onclick="do_page('index.php?data=<?php print base64_encode('maklumat/ulasan_pengarah_list;Ulasan Pengarah JAWI;Ulasan Pengarah JAWI;;;;'); ?>')">
							<i class="fa fa-spinner" style="margin:0px;"></i> Kembali</button>
						<input type="hidden" name="progid" id="progid" value="<?php print $progid;?>" />
						<input type="hidden" name="proses" value="<?php print $proses;?>" />
					</div>
				</div>

			
			</div>
		</div>
	     
	</section>

</div> 
<script language="javascript" type="text/javascript">
document.jawi.ulasan.focus();
</script>		 
