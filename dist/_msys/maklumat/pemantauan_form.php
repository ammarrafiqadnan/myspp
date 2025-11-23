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
<div class="col-lg-12">
	<section class="panel">
		<header class="panel-heading"  style="background-color:rgb(38, 167, 228)">
			<h6 class="panel-title"><font color="#000000" size="3"><b>MAKLUMAT PEMANTAUAN</b> - <i style="color:#f00"><?php print strtoupper($stat);?></i></font></h6>
		</header>
		<div class="panel-body">
			<div class="box-body">

			<input type="hidden" name="pemantauan_id" id="pemantauan_id" value="<?php print $id;?>" readonly="readonly"/>

				<div class="col-md-12">

					<div class="form-group">
						<div class="row">
							<label for="nama" class="col-sm-2 control-label"><b>KATEGORI PEMANTAUAN <font color="#FF0000">*</font> : </b></label>
							<div class="col-sm-10">
								<input type="hidden" name="pemantauan_type" id="pemantauan_type" class="form-control" value="<?=$jenis;?>" readonly>
								<b><?php print dlookup("`_ref_kategori_sub`","subkat_nama","subkat_id='{$jenis}'"); ?></b>
							</div>
						</div>
					</div>

					<div class="form-group">
						<div class="row">
							<label for="nama" class="col-sm-2 control-label"><b>TAJUK <font color="#FF0000">*</font> : </b></label>
							<div class="col-sm-10">
								<input type="text" name="tajuk" id="tajuk" class="form-control" value="<?php print $rs->fields['tajuk'];?>" <?=$read_only;?>>
							</div>
						</div>
					</div>

					<div class="form-group">
						<div class="row">
							<label for="nama" class="col-sm-2 control-label"><b>TARIKH <font color="#FF0000">*</font> : </b></label>
							<div class="col-sm-3">
								<input type="date" name="tarikh" id="tarikh" class="form-control" value="<?php print $rs->fields['tarikh'];?>" <?=$read_only;?>>
							</div>
							<div class="col-sm-2"></div>
							<label for="nama" class="col-sm-2 control-label"><b>JENIS PEMANTAUAN <font color="#FF0000">*</font> : </b></label>
							<div class="col-sm-3">
								<select name="pemantauan_jenis" id="pemantauan_jenis" class="form-control">
									<option value="A" <?php if($rs->fields['pemantauan_jenis']=='A'){ print 'selected'; }?>>ADUAN</option>
									<option value="B" <?php if($rs->fields['pemantauan_jenis']=='B'){ print 'selected'; }?>>BERKALA</option>
								</select>
							</div>
						</div>
					</div>

					<div class="form-group">
						<div class="row">
							<label for="nama" class="col-sm-2 control-label"><b>TEMPAT <font color="#FF0000">*</font> : </b></label>
							<div class="col-sm-10">
								<textarea name="tempat" id="tempat" class="form-control"><?php print $rs->fields['tempat'];?></textarea>
							</div>
						</div>
					</div>

					<?php //$conn->debug=true;
					$sql = "SELECT * FROM _ref_parlimen WHERE is_deleted=0 AND parlimen_status=0 ORDER BY parlimen_nama";
					$rsP = $conn->query($sql);
					// print $rsP->recordcount();
					?>
					<div class="form-group">
						<div class="row">
							<label for="nama" class="col-sm-2 control-label"><b>KAWASAN PARLIMEN <font color="#FF0000">*</font> : </b></label>
							<div class="col-sm-6">
								<select name="parlimen" id="parlimen" class="form-control">
									<option value="">Sila pilih</option>
									<?php while(!$rsP->EOF){ ?>
									<option value="<?php print $rsP->fields['parlimen_id'];?>" <?php if($rsP->fields['parlimen_id']==$rs->fields['parlimen_id']){ print 'selected'; } ?>><?php print $rsP->fields['parlimen_nama'];?></option>										
									<?php $rsP->movenext(); } ?>	
								</select>
							</div>
						</div>
					</div>

					<?php 
					if(!empty($rs->fields['pegawai_list'])){
						$sql = "SELECT * FROM _tbl_users WHERE `id` IN(".$rs->fields['pegawai_list'].")";
						$senarai = $conn->query($sql);
					}
					?>
					<div class="form-group">
						<div class="row">
							<label for="nama" class="col-sm-2 control-label"><b>PEGAWAI PEMANTAU <font color="#FF0000">*</font> : </b><br>
								<?php if(!empty($ada)){ ?>
								<a href="maklumat/senarai_pegawai.php?ids=<?=$ids;?>&vals=<?=$rs->fields['pegawai_list'];?>" data-toggle="modal" data-target="#myModal" 
								title="Nama pegawai pemantau" class="fa" data-backdrop="">
								<label class="btn btn-success"><i class="fa fa-plus-o" style="color:white;font-family: Arial;">Tambah Pegawai</i></label>
								</a>
								<?php } ?>
							</label>
							<div class="col-sm-10">
								<input type="hidden" name="pegawai_list" id="pegawai_list" value="<?php print $rs->fields['pegawai_list'];?>" class="form-control">
								<?php if(!empty($rs->fields['pegawai_list'])){ ?>
								<table width="100%" class="table" cellpadding="5" cellspacing="0" border="1">
									<tr>
										<td width="10%"><b>Bil</b></td>
										<td width="90%"><b>Nama</b></td>
									</tr>
									<?php while(!$senarai->EOF){ $bil++; ?>
									<tr>
										<td><?=$bil;?>.</td>
										<td><?php print $senarai->fields['nama'];?></td>
									</tr>
									<?php $senarai->movenext(); } ?>
								</table>
								<?php } ?>
								<textarea name="pegawai" id="pegawai" class="form-control"><?php print $rs->fields['pegawai'];?></textarea>

							</div>
						</div>
					</div>

					<div class="form-group">
						<div class="row">
							<label for="nama" class="col-sm-2 control-label"><b>TUJUAN <font color="#FF0000">*</font> : </b></label>
							<div class="col-sm-10">
								<textarea name="tujuan" id="tujuan" class="form-control"><?php print $rs->fields['tujuan'];?></textarea>
							</div>
						</div>
					</div>

					<div class="form-group">
						<div class="row">
							<label for="nama" class="col-sm-2 control-label"><b>HASIL PEMANTAUAN <font color="#FF0000">*</font> : </b>
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
						<button type="button" id="simpan" class="btn btn-primary mt-sm mb-sm" onclick="do_save('SAVE','')"><i class="fa fa-save"></i> Simpan</button>
						&nbsp;
						<button type="button" id="simpan_next" class="btn btn-success mt-sm mb-sm" onclick="do_save('SAVE','SEND')"><i class="fa fa-save"></i> Simpan & Hantar</button>
						&nbsp;
						<button type="button" class="btn btn-default" onclick="do_page('index.php?data=<?php print base64_encode('maklumat/pemantauan_list;DATA;Maklumat Pemantauan;;;;'); ?>')">
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
