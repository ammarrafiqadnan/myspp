<?php //include '../connection/common.php'; ?>
<script language="javascript">
function get_spr(fields, vals,ty){
	$.ajax({
        url:'akademik/sql_akademik.php?frm=SRP&pro=UPDATE&fields='+fields+'&vals='+vals+'&ty='+ty,
		type:'POST',
        //dataType: 'json',
        // beforeSend: function () {
            //$('.btn-primary').attr("disabled","disabled");
            //$('.modal-body').css('opacity', '.5');
        // },
		data: $("form").serialize(),
		//data: datas,
		success: function(data){
			console.log(data);
			if(ty=='R'){
				reload = window.location; 
				window.location = reload;
			}
		}
	});
}

function save_spr(){
	var id_pemohon = $('#id_pemohon').val();
	var srp_tahun = $('#srp_tahun').val();
	var srp_jenis_sijil = $('#srp_jenis_sijil').val();
	var srp_pangkat = $('#srp_pangkat').val();
	// var mp = document.getElementById('mp');; //$('#mp').val();
	// var gred = $('#gred').val();

    if(srp_tahun.trim()<='1992' && srp_jenis_sijil.trim() == ''){
        // alert('Sila pilih maklumat jenis sijil.');
        alert_msg('Sila pilih maklumat jenis sijil.');
        $('#srp_jenis_sijil').focus(); return false;
    } else if(srp_tahun.trim()<='1992' && srp_pangkat.trim() == ''){
        // alert('Sila pilih maklumat pangkat.');
        alert_msg('Sila pilih maklumat pangkat.');
        $('#srp_pangkat').focus(); return false;
    } else if(srp_tahun.trim()>='1993' && srp_jenis_sijil.trim() == ''){
        // alert('Sila pilih maklumat jenis sijil.');
        alert_msg('Sila pilih maklumat jenis sijil.');
        $('#srp_pangkat').focus(); return false;
	} else { 

		var fd = new FormData();
        var files1 = $('#file_pmr')[0].files[0];
        // var files2 = $('#upload_id2')[0].files[0];
        fd.append('file_pmr',files1);
        // fd.append('upload_id2',files2);

        var other_data = $('form').serializeArray();
		$.each(other_data,function(key,input){
		    fd.append(input.name,input.value);
		});
        
        $.ajax({
	        url:'akademik/sql_akademik.php?frm=SRP&pro=SAVE',
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
						reload = window.location; 
						window.location = reload;
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
				
			}
		});
	}
}

</script>
<?php
include 'akademik/sql_akademik.php';
$data = get_pmr($conn,$_SESSION['SESS_UID']);
// print_r($data);
$uid = $data['id_pemohon'];
$tahun = $data['srp_tahun'];
// $conn->debug=true;
$rsSijil = $conn->query("SELECT * FROM $schema2.`calon_sijil` WHERE `jenis_sijil`='PMR' AND `id_pemohon`=".tosql($uid));
if(empty($rsSijil->fields['sijil_nama'])){ $sijil="../upload_doc/PMR_Mock_Result_Statement_Certificate.png"; }
else { $sijil = "../uploads_doc/".$uid."/".$rsSijil->fields['sijil_nama']; }
// print $sijil;
?>
		<header class="panel-heading"  style="background-color:rgb(209 29 29)">
			<h6 class="panel-title"><font color="#000000" size="3"><b><?php print strtoupper($menu);?></b></font></h6>
		</header>
		<div class="panel-body">
			<div class="box-body">

			<input type="hidden" name="id_pemohon" id="id_pemohon" value="<?php print $data['id_pemohon'];?>" readonly="readonly"/>

				<div class="col-md-12">

					<?php include 'biodata/biodata_view.php'; ?>

					<div class="form-group">
						<div class="row">
							<p>
							  <button class="btn btn-primary form-control" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample" title="Sila klik untuk membaca arahan berkaitan kemasukan data akademik SPM">
							    ARAHAN:
							  </button>
							</p>
							<div class="collapse" id="collapseExample">
							  <div class="card card-body">
									<label for="nama" class="col-sm-12 control-label"><b>ARAHAN : Sila Masukkan 10 Matapelajaran Dengan Keputusan Terbaik</b>
										<ul>
											<li>Bagi sijil PT3, sila pilih gred A hingga F.</li>
											<li>Bagi sijil PMR, sila pilih gred A hingga E.</li>
											<li>Bagi sijil SRP/LCE, sila pilih gred 1 hingga 9.</li>
										</ul>
									</label>

							  </div>
							</div>
						</div>
					</div>

					<hr>

					
					<div class="form-group">
						<div class="row">
							<label for="nama" class="col-sm-2 control-label"><b>Tahun <font color="#FF0000">*</font><div style="float:right">:</div></b></label>
							<div class="col-sm-3">
								<select name="srp_tahun" id="srp_tahun" class="form-control" onchange="get_spr('srp_tahun',this.value,'R')">
									<option value="">Sila pilih tahun</option>
									<?php for($t=date("Y");$t>=1985;$t--){
										print '<option value="'.$t.'"'; 
										if($data['srp_tahun']==$t){ print 'selected'; }
										print '>'.$t.'</option>';
									} ?>
								</select>
							</div>
						</div>
					</div>
					<?php 
					$rssijil = $conn->query("SELECT * FROM $schema1.`ref_sijil` WHERE `TKT`='3' AND (".$data['srp_tahun']." BETWEEN tahun_mula AND tahun_akhir)");
					$rspangkat = $conn->query("SELECT * FROM $schema1.`ref_sijil_pangkat` WHERE `TKT`=3 ORDER BY `DISKRIPSI`");
					?>
					<div class="form-group">
						<div class="row">
							<label for="nama" class="col-sm-2 control-label"><b>Jenis Sijil <font color="#FF0000">*</font><div style="float:right">:</div></b></label>
							<div class="col-sm-4">
								<select class="form-control" id="srp_jenis_sijil" name="srp_jenis_sijil" onchange="get_spr('srp_jenis_sijil',this.value,'')">
									<option value="">Sila pilih jenis sijil</option>
									<?php while(!$rssijil->EOF){ ?>
									<option value="<?=$rssijil->fields['KOD'];?>" 
									<?php if($rssijil->fields['KOD']==$data['srp_jenis_sijil']){ print 'selected';} ?>	
									><?=$rssijil->fields['DISKRIPSI'];?></option>
									<?php $rssijil->movenext(); } ?>
								</select>
							</div>
							<div class="col-sm-1"></div>
							<label for="nama" class="col-sm-2 control-label"><b>Pangkat <font color="#FF0000">*</font><div style="float:right">:</div></b></label>
							<div class="col-sm-3">
								<select class="form-control" name="srp_pangkat" id="srp_pangkat" onchange="get_spr('srp_pangkat',this.value,'')">
									<option value="">Sila pilih pangkat</option>
									<?php while(!$rspangkat->EOF){ ?>
									<option value="<?=$rspangkat->fields['KOD'];?>" 
									<?php if($rspangkat->fields['KOD']==$data['srp_pangkat']){ print 'selected';} ?>	
									><?=$rspangkat->fields['DISKRIPSI'];?></option>
									<?php $rspangkat->movenext(); } ?>
								</select>
							</div>
						</div>
					</div>

					<?php if(!empty($data['srp_tahun'])){ 
						$rsSRP = $conn->query("SELECT * FROM $schema1.`ref_matapelajaran` WHERE `TKT`='3' AND `SAH_YT`='Y' AND `GAB_YT`='T' 
							ORDER BY `DISKRIPSI`");
						$rsGred = $conn->query("SELECT * FROM $schema1.`ref_gred_matapelajaran` WHERE `TKT`='3' 
							ORDER BY `SUSUNAN`");
					?>
					<hr>

					<div class="form-group">
						<div class="row">
							<div class="col-sm-8">
								<div class="row">
									<div class="col-sm-8 col-xm-8" style="padding-bottom:5px"><b>BAHASA MELAYU/BAHASA MALAYSIA</b></div>
									<div class="col-sm-4 col-xm-4" style="padding-bottom:5px">
										<input type="hidden" name="mp[]" id="mp[]" value="002">
										<select class="form-control" name="gred[]">
											<option value="">Sila pilih gred</option>
											<?php 
											$result = get_pmr_result($conn, $uid, "002", $tahun);
											$rsGred->movefirst();
											while(!$rsGred->EOF){ ?>
											<option value="<?=$rsGred->fields['GRED'];?>" <?php if($result['gred']==$rsGred->fields['GRED']){ print 'selected'; } ?>><?=$rsGred->fields['GRED'];?></option>	
											<?php $rsGred->movenext(); } ?>
										</select>
									</div>
								</div>

								<?php $bilr=0;
								$rsResult = $conn->query("SELECT * FROM $schema2.`calon_srp` WHERE `id_pemohon`=".tosql($uid). " AND tahun=".tosql($tahun). " AND matapelajaran NOT IN ('002')");
								while(!$rsResult->EOF){ $bilr++; ?>								
								<div class="row">
									<div class="col-sm-8" style="padding-bottom:5px">
										<select class="form-control" name="mp[]" id="mp[]">
											<option value="">Sila pilih matapelajaran</option>
											<?php $rsSRP->movefirst();
											while(!$rsSRP->EOF){ ?>
											<option value="<?=$rsSRP->fields['kod'];?>"<?php if($rsSRP->fields['kod']==$rsResult->fields['matapelajaran']){ print ' selected'; } ?>><?=$rsSRP->fields['DISKRIPSI'];?></option>	
											<?php $rsSRP->movenext(); } ?>
										</select>
									</div>
									<div class="col-sm-4" style="padding-bottom:5px">
										<select class="form-control" name="gred[]" id="gred[]">
											<option value="">Sila pilih gred</option>
											<?php $rsGred->movefirst();
											while(!$rsGred->EOF){ ?>
											<option value="<?=$rsGred->fields['GRED'];?>"<?php if($rsGred->fields['GRED']==$rsResult->fields['gred']){ print ' selected'; } ?>><?=$rsGred->fields['GRED'];?></option>	
											<?php $rsGred->movenext(); } ?>
										</select>
									</div>
								</div>
								<?php $rsResult->movenext(); } ?>

								<?php for($i=$bilr;$i<=9;$i++){ ?>
								<div class="row">
									<div class="col-sm-8" style="padding-bottom:5px">
										<select class="form-control" name="mp[]" id="mp[]">
											<option value="">Sila pilih matapelajaran</option>
											<?php $rsSRP->movefirst();
											while(!$rsSRP->EOF){ ?>
											<option value="<?=$rsSRP->fields['kod'];?>"><?=$rsSRP->fields['DISKRIPSI'];?></option>	
											<?php $rsSRP->movenext(); } ?>
										</select>
									</div>
									<div class="col-sm-4" style="padding-bottom:5px">
										<select class="form-control" name="gred[]" id="gred[]">
											<option value="">Sila pilih gred</option>
											<?php $rsGred->movefirst();
											while(!$rsGred->EOF){ ?>
											<option value="<?=$rsGred->fields['GRED'];?>"><?=$rsGred->fields['GRED'];?></option>	
											<?php $rsGred->movenext(); } ?>
										</select>
									</div>
								</div>
							<?php } ?>
							</div>

							<div class="col-sm-4" align="center">
								<img src="<?=$sijil;?>" width="300" height="400">
								<input type="file" name="file_pmr" id="file_pmr" class="form-control">
							</div>

						</div>
					</div>
					<?php } ?>

					<div class="modal-footer" style="padding:0px;">
						<button type="button" id="simpan" class="btn btn-primary mt-sm mb-sm" onclick="save_spr()"><i class="fa fa-save"></i> Simpan</button>
						<input type="hidden" name="progid" id="progid" value="<?php print $progid;?>" />
						<input type="hidden" name="proses" value="<?php print $proses;?>" />
					</div>
				</div>

			
			</div>
		</div>
	     

<script language="javascript" type="text/javascript">
var srp_tahun = document.getElementById('srp_tahun').value;
var srp_pangkat = document.getElementById('srp_pangkat');
// alert(srp_tahun);
if(srp_tahun>='1993'){
	srp_pangkat.setAttribute('disabled', '');
} else {
	srp_pangkat.removeAttribute('disabled');
}
</script>		 
