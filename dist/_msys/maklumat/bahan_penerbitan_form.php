<?php //include '../connection/common.php'; ?>
<script language="javascript">
function do_save(val1, val2){
    var reg = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
    var pemantauan_type = $('#pemantauan_type').val();
    var tajuk = $('#tajuk').val();
    var tajuk_penerbitan  = $('#tajuk_penerbitan').val();
    var tarikh = $('#tarikh').val();
    // var tujuan = $('#tujuan').val();
    var laporan_kajian = $('#laporan_kajian').val();
    var syor = $('#syor').val();

    var sykt_penerbit = $('#sykt_penerbit').val();
    var sykt_pengeluar = $('#sykt_pengeluar').val();
    var sykt_pengedar = $('#sykt_pengedar').val();
    var sykt_pencetak = $('#sykt_pencetak').val();
    
    if(pemantauan_type.trim() == '' ){
        alert('Sila pastikan kategori mempunyai maklumat.');
        $('#pemantauan_type').focus(); return false;
	} else if(tajuk.trim() == '' ){
        alert('Sila masukkan maklumat tajuk.');
        $('#tajuk').focus(); return false;
	} else if(tajuk_penerbitan.trim() == '' ){
        alert('Sila masukkan maklumat tajuk penerbitan.');
        $('#tajuk_penerbitan').focus(); return false;
	} else if(tarikh.trim() == '' ){
        alert('Sila masukkan maklumat tarikh.');
        $('#tarikh').focus(); return false;
	} else if(sykt_penerbit.trim() == '' ){
        alert('Sila masukkan maklumat syarikat penerbit.');
        $('#sykt_penerbit').focus(); return false;
	} else if(sykt_pengeluar.trim() == '' ){
        alert('Sila masukkan maklumat syarikat pengedar.');
        $('#sykt_pengeluar').focus(); return false;
	// } else if(tujuan.trim() == '' ){
 //        alert('Sila masukkan maklumat tujuan pemantauan.');
 //        $('#tujuan').focus(); return false;
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
	    url:'maklumat/sql_maklumat.php?frm=BPENERBITAN&pro='+val1+'&act='+val2,
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
			console.log(data);
			var nameArr = data.split(';');

			// alert(nameArr[0]);
			// alert(nameArr[1]);
			if(nameArr[0]=='OK'){
				swal({
				  title: 'Berjaya',
				  text: 'Maklumat telah berjaya dikemaskini',
				  type: 'success',
				  confirmButtonClass: "btn-success",
				  confirmButtonText: "Ok",
				  showConfirmButton: true,
				}).then(function () {
					// reload = window.location; 
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
$_SESSION['page_name']="BAHAN PENERBITAN";
// $conn->debug=true;
// $ids=isset($_REQUEST["ids"])?$_REQUEST["ids"]:"";
// $kategori=isset($_REQUEST["kategori"])?$_REQUEST["kategori"]:"";
$kategori='11';
$read_only='';

if(empty($id) && !empty($kategori)){
	$jenis = $kategori;
	$id = date("ymd")."_".uniqid();
	$ada='';
} else { 
	$sql = "SELECT * FROM `tbl_pemantauan` WHERE `pemantauan_id`=".tosql($id);
	$rs = $conn->query($sql);
	$ada='OK';
	$jenis = $rs->fields['pemantauan_type'];
	$rsDet = $conn->query("SELECT * FROM `tbl_pemantauan_penerbitan` WHERE `pemantauan_id`=".tosql($id));
}

// PRINT "DD:".$read_only;

?>
<div class="col-lg-12">
	<section class="panel">
		<header class="panel-heading"  style="background-color:rgb(38, 167, 228)">
			<h6 class="panel-title"><font color="#000000" size="3"><b>MAKLUMAT LAPORAN KAJIAN BAHAN PENERBITAN BERUNSUR ISLAM MERAGUKAN</b> - <i style="color:#f00">DRAF LAPORAN</i></font></h6>
		</header>
		<div class="panel-body">
			<div class="box-body">

			<input type="hidden" name="pemantauan_id" id="pemantauan_id" value="<?php print $id;?>" readonly="readonly"/>

				<div class="col-md-12">

					<div class="form-group">
						<div class="row">
							<label for="nama" class="col-sm-2 control-label"><b>KATEGORI LAPORAN <font color="#FF0000">*</font> : </b></label>
							<div class="col-sm-10">
								<input type="hidden" name="pemantauan_type" id="pemantauan_type" class="form-control" value="<?=$jenis;?>" readonly>
								<b><?php print dlookup("`_ref_kategori_sub`","subkat_nama","subkat_id='{$jenis}'"); ?></b>
							</div>
						</div>
					</div>

					<div class="form-group">
						<div class="row">
							<label for="nama" class="col-sm-2 control-label"><b>TAJUK BUKU <font color="#FF0000">*</font> : </b></label>
							<div class="col-sm-10">
								<input type="text" name="tajuk" id="tajuk" class="form-control" value="<?php print $rs->fields['tajuk'];?>" <?=$read_only;?>>
							</div>
						</div>
					</div>

					<div class="form-group">
						<div class="row">
							<label for="nama" class="col-sm-2 control-label"><b>TAJUK PENERBITAN <font color="#FF0000">*</font> : </b></label>
							<div class="col-sm-10">
								<input type="text" name="tajuk_penerbitan" id="tajuk_penerbitan" class="form-control" value="<?php print $rs->fields['tajuk_penerbitan'];?>" <?=$read_only;?>>
							</div>
						</div>
					</div>

					<div class="form-group">
						<div class="row">
							<label for="nama" class="col-sm-2 control-label"><b>NAMA PENGARANG/ PENTERJEMAH <font color="#FF0000">*</font> : </b></label>
							<div class="col-sm-10">
								<textarea name="tempat" id="tempat" class="form-control"><?php print $rs->fields['tempat'];?></textarea>
							</div>
						</div>
					</div>

					<div class="form-group">
						<div class="row">
							<label for="nama" class="col-sm-2 control-label"><b>TARIKH TERBITAN <font color="#FF0000">*</font> : </b></label>
							<div class="col-sm-3">
								<input type="date" name="tarikh" id="tarikh" class="form-control" value="<?php print $rs->fields['tarikh'];?>" <?=$read_only;?>>
							</div>
							<div class="col-sm-2"></div>
							<label for="nama" class="col-sm-2 control-label"><b>BAHASA <font color="#FF0000">*</font> : </b></label>
							<div class="col-sm-3">
								<select name="pemantauan_jenis" id="pemantauan_jenis" class="form-control">
									<option value="M" <?php if($rs->fields['pemantauan_jenis']=='M'){ print 'selected'; }?>>MELAYU</option>
									<option value="A" <?php if($rs->fields['pemantauan_jenis']=='A'){ print 'selected'; }?>>ARAB</option>
									<option value="E" <?php if($rs->fields['pemantauan_jenis']=='E'){ print 'selected'; }?>>ENGLISH</option>
									<option value="C" <?php if($rs->fields['pemantauan_jenis']=='C'){ print 'selected'; }?>>CHINA</option>
									<option value="T" <?php if($rs->fields['pemantauan_jenis']=='T'){ print 'selected'; }?>>TAMIL</option>
									<option value="U" <?php if($rs->fields['pemantauan_jenis']=='U'){ print 'selected'; }?>>URDU</option>
								</select>
							</div>
						</div>
					</div>


					<div class="form-group">
						<div class="row">
							<label for="nama" class="col-sm-2 control-label"><b>SYARIKAT PENERBIT <font color="#FF0000">*</font> : </b></label>
							<div class="col-sm-10">
								<textarea name="sykt_penerbit" id="sykt_penerbit" class="form-control"><?php print $rsDet->fields['sykt_penerbit'];?></textarea>
							</div>
						</div>
					</div>

					<div class="form-group">
						<div class="row">
							<label for="nama" class="col-sm-2 control-label"><b>SYARIKAT PENGELUAR <font color="#FF0000">*</font> : </b></label>
							<div class="col-sm-10">
								<textarea name="sykt_pengeluar" id="sykt_pengeluar" class="form-control"><?php print $rsDet->fields['sykt_pengeluar'];?></textarea>
							</div>
						</div>
					</div>

					<div class="form-group">
						<div class="row">
							<label for="nama" class="col-sm-2 control-label"><b>SYARIKAT PENGEDAR <font color="#FF0000">*</font> : </b></label>
							<div class="col-sm-10">
								<textarea name="sykt_pengedar" id="sykt_pengedar" class="form-control"><?php print $rsDet->fields['sykt_pengedar'];?></textarea>
							</div>
						</div>
					</div>

					<div class="form-group">
						<div class="row">
							<label for="nama" class="col-sm-2 control-label"><b>SYARIKAT PENCETAK <font color="#FF0000">*</font> : </b></label>
							<div class="col-sm-10">
								<textarea name="sykt_pencetak" id="sykt_pencetak" class="form-control"><?php print $rsDet->fields['sykt_pencetak'];?></textarea>
							</div>
						</div>
					</div>

					<div class="form-group">
						<div class="row">
							<label for="nama" class="col-sm-2 control-label"><b>LAPORAN KAJIAN <font color="#FF0000">*</font> : </b>
								<?php if(!empty($ada)){ ?>
								<a href="maklumat/pemantauan_form_upload.php?pemantauan_id=<?=$id;?>&type=PANTAU" data-toggle="modal" data-target="#myModal" 
		                        style="font-family:Arial, Helvetica, sans-serif" title="Tambah Maklumat Gambar" class="fa" data-backdrop="">
		                        <button type="button" class="btn btn-sm btn-primary"><i style="font-family: Arial;color:white;">Muatnaik Gambar</i></button></a>
		                    	<?php } ?>
		                    </label>
							<div class="col-sm-10">
								<textarea name="laporan_kajian" id="laporan_kajian" class="form-control"><?php print $rs->fields['laporan_kajian'];?></textarea>
								<div style="height: 8px;">&nbsp</div>
								<?php 
		                        // $conn->debug=true;
		                        $rsImg = $conn->query("SELECT * FROM `tbl_pemantauan_upload` WHERE `pemantauan_id`='{$id}'");
		                        while(!$rsImg->EOF){
		                        ?>
		                            <a href="maklumat/pemantauan_form_view.php?lawat_id=<?=$rsImg->fields['id'];?>&files=<?=$rsImg->fields['file_name'];?>" 
		                                data-toggle="modal" data-target="#myModal" style="font-family:Arial, Helvetica, sans-serif" title="Tambah Maklumat Gambar" class="fa" data-backdrop="">
		                            <img src="upload_doc/<?=$rsImg->fields['file_name'];?>" width="100px" width="100px"></a>
		                        <?php
		                            $rsImg->movenext();
		                        } ?>
							</div>
						</div>
					</div>

					<div class="form-group">
						<div class="row">
							<label for="nama" class="col-sm-2 control-label"><b>SYOR / CADANGAN <font color="#FF0000">*</font> : </b></label>
							<div class="col-sm-10">
								<textarea name="syor" id="syor" class="form-control"><?php print $rs->fields['syor'];?></textarea>
							</div>
						</div>
					</div>

					<?php if($rs->fields['status_proses']==1){ 
						$rsKB = $conn->query("SELECT * FROM `tbl_pemantauan_ulasan` WHERE `pemantauan_id`='{$id}' AND `jenis_ulasan`=3");
					?>
					<div class="form-group">
						<div class="row">
							<label for="nama" class="col-sm-2 control-label"><b>ULASAN KETUA BAHAGIAN : </b></label>
							<div class="col-sm-10">
								<?php print nl2br($rsKB->fields['ulasan']); ?>
							</div>
						</div>
					</div>
					<?php } ?>
		

					<div class="modal-footer" style="padding:0px;">
						<button type="button" class="btn btn-primary mt-sm mb-sm" onclick="do_save('SAVE','')"><i class="fa fa-save"></i> Simpan</button>
						&nbsp;
						<button type="button" class="btn btn-success mt-sm mb-sm" onclick="do_save('SAVE','SEND')"><i class="fa fa-save"></i> Simpan & Hantar</button>
						&nbsp;
						<button type="button" class="btn btn-default" onclick="do_page('index.php?data=<?php print base64_encode('maklumat/bahan_penerbitan_list;DATA;'.$menu.';;;;'); ?>')">
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
//document.frm.gsasar_nama.focus();
</script>		 
