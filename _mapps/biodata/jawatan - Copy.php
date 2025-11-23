<?php //include '../connection/common.php'; ?>
<script language="javascript">
function do_save(val1, val2){
    var reg = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
    var pemantauan_type = $('#pemantauan_type').val();
    var tajuk = $('#tajuk').val();
    var tarikh = $('#tarikh').val();
    var tempat = $('#tempat').val();
    var parlimen = $('#parlimen').val();
    var pegawai = $('#pegawai').val();
    var tujuan = $('#tujuan').val();
    var laporan_kajian = $('#laporan_kajian').val();
    var syor = $('#syor').val();
    
    if(pemantauan_type.trim() == '' ){
        alert('Sila pastikan kategori mempunyai maklumat.');
        $('#pemantauan_type').focus(); return false;
	} else if(tajuk.trim() == '' ){
        alert('Sila masukkan maklumat tajuk.');
        $('#tajuk').focus(); return false;
	} else if(tarikh.trim() == '' ){
        alert('Sila masukkan maklumat tarikh.');
        $('#tarikh').focus(); return false;
	} else if(tempat.trim() == '' ){
        alert('Sila masukkan maklumat tempat.');
        $('#tempat').focus(); return false;
    } else if(parlimen.trim() == '' ){
        alert('Sila pilih mkalumat kawasan parlimen.');
        $('#parlimen').focus(); return false;
	// } else if(pegawai.trim() == '' ){
        // alert('Sila masukkan maklumat pegawai pemantauan.');
        // $('#pegawai').focus(); return false;
	} else if(tujuan.trim() == '' ){
        alert('Sila masukkan maklumat tujuan pemantauan.');
        $('#tujuan').focus(); return false;
	} else if(laporan_kajian.trim() == '' ){
        alert('Sila masukkan maklumat hasil kajian.');
        $('#laporan_kajian').focus(); return false;
	} else if(syor.trim() == '' ){
        alert('Sila masukkan maklumat syor / cadangan.');
        $('#syor').focus(); return false;
	} else {
		if(val2=='SEND'){
			swal({
			  	title: 'Adakah anda pasti untuk menghantar laporan ini kepada Ketua Bahagian untuk semakan?',
				//text: "You won't be able to revert this!",
				type: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Ya, Teruskan',
				cancelButtonText: 'Tidak, Batal!',
				reverseButtons: true
			}).then(function () {
				do_prosessql(val1, val2);
			});
		} else {
			do_prosessql(val1, val2);
		}
    }
}

function do_prosessql(val1, val2){
	$.ajax({
	    url:'maklumat/sql_maklumat.php?frm=PANTAU&pro='+val1+'&act='+val2,
		type:'POST',
	    //dataType: 'json',
	    beforeSend: function () {
	        $('.btn-primary').attr("disabled","disabled");
	        $('.btn-success').attr("disabled","disabled");
	        $('.modal-body').css('opacity', '.5');
	    },
		data: $("form").serialize(),
		//data: datas,
		success: function(data){
			var nameArr = data.split(';');
			// alert(data);
			if(nameArr[0]=='OK'){
				swal({
				  title: 'Berjaya',
				  text: 'Maklumat telah berjaya dikemaskini',
				  type: 'success',
				  confirmButtonClass: "btn-success",
				  confirmButtonText: "Ok",
				  showConfirmButton: true,
				}).then(function () {
					//reload = window.location; 
					window.location.href=nameArr[1];
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
// $conn->debug=true;
$_SESSION['page_name']="MAKLUMAT PEMANTAUAN";
$ids=isset($_REQUEST["ids"])?$_REQUEST["ids"]:"";
$kategori=isset($_REQUEST["kategori"])?$_REQUEST["kategori"]:"";
$read_only='';
$ada='';
if(empty($id) && !empty($kategori)){
	$jenis = $kategori;
	$id = date("ymd")."_".uniqid();
} else { 
	$sql = "SELECT * FROM `tbl_pemantauan` WHERE `pemantauan_id`=".tosql($id);
	$rs = $conn->query($sql);
	$jenis = $rs->fields['pemantauan_type'];
	$ada='OK';
}

// PRINT "DD:".$read_only;
// SELECT * FROM `_ref_status` 
$stat = dlookup("`_ref_status`","status_nama","`status_id`=".tosql($rs->fields['status_proses']));
// print "ST:".$stat;
if(empty($stat)){ $stat='DRAF LAPORAN'; }
?>
		<header class="panel-heading"  style="background-color:rgb(38, 167, 228)">
			<h6 class="panel-title"><font color="#000000" size="3"><b><?php print strtoupper($menu);?></b></font></h6>
		</header>
		<div class="panel-body">
			<div class="box-body">

			<input type="hidden" name="pemantauan_id" id="pemantauan_id" value="<?php print $id;?>" readonly="readonly"/>

				<div class="col-md-12">

					<?php include 'biodata/biodata_view.php'; ?>

					<div class="form-group">
						<div class="row">
							<label for="nama" class="col-sm-12 control-label"><b>ARAHAN : </b>
								<ul>
									<li>Jumlah keseluruhan JAWATAN SPP yang dipilih mestilah tidak melebihi 3 jawatan. <br>
									** CONTOH : Jika kelayakan akademik adalah SPM, jawatan PMR + SPM + DIPLOMA = 3 jawatan sahaja.</li>
									<li>Jawatan yang dipilih adalah mengikut turutan nombor pilihan dari atas ke bawah. (Pilihan PERTAMA hingga KETIGA)</li>
								</ul>
							</label>
						</div>
					</div>
					<hr>

					
					<div class="form-group">
						<div class="row">
							<div class="col-sm-12">
								<b>JAWATAN MAKSIMUM BERDASARKAN KELAYAKAN DIPLOMA</b>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="row">
							<div class="col-sm-5">
								<label for="nama" class="col-sm-12 control-label">Jawatan yang layak dimohon</label>
								<textarea rows="6" class="form-control">
									
								</textarea>
							</div>
							<div class="col-sm-2 text-center"><br><br>
								<lable class="btn btn-primary">Tambah</lable><br><br>
								<lable class="btn btn-primary">Hapus</lable><br>
							</div>
							<div class="col-sm-5">
								<label for="nama" class="col-sm-12 control-label">Jawatan yang dimohon</label>
								<textarea rows="6" class="form-control">
									
								</textarea>
							</div>
						</div>
					</div>

					<hr>

					<div class="form-group">
						<div class="row">
							<label for="nama" class="col-sm-6 control-label"><b>Pusat Temu Duga / Ujian Khas yang Dipilih Bagi Jawatan SPP Sahaja<font color="#FF0000">*</font><div style="float:right">:</div></b>
								<br><font style="color: red;">Sila pastikan pilihan Pusat Temu Duga adalah terhampir dengan tempat tinggal semasa.
								<br>Sebarang perubahan/pertukaran Pusat Temu Duga tidak akan dilayan.</font>
								</label>
							<div class="col-sm-4">
								<select class="form-control">
									<option>Sila pilih</option>
									<option>JOHOR</option>
									<option>KEDAH</option>
								</select>
							</div>
						</div>
					</div>

					
					
					<div class="modal-footer" style="padding:0px;">
						<button type="button" id="simpan" class="btn btn-primary mt-sm mb-sm" onclick="do_save('SAVE','')"><i class="fa fa-save"></i> Simpan</button>
						&nbsp;
						<!-- <button type="button" id="simpan_next" class="btn btn-success mt-sm mb-sm" onclick="do_save('SAVE','SEND')"><i class="fa fa-save"></i> Simpan & Hantar</button>
						&nbsp; -->
						<button type="button" class="btn btn-default" onclick="do_page('index.php?data=<?php print base64_encode('maklumat/pemantauan_list;DATA;Maklumat Pemantauan;;;;'); ?>')">
							<i class="fa fa-spinner" style="margin:0px;"></i> Kembali</button>
						<input type="hidden" name="progid" id="progid" value="<?php print $progid;?>" />
						<input type="hidden" name="proses" value="<?php print $proses;?>" />
					</div>
				</div>

			
			</div>
		</div>
	     

<script language="javascript" type="text/javascript">
//document.frm.gsasar_nama.focus();
</script>		 
