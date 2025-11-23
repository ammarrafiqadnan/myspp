<!-- <link rel="stylesheet" href="../css/bootstrap-select.min.css">
<script src="../js/bootstrap-select.min.js"></script> -->
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script> -->

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<style type="text/css">
.icon {
  padding-right: 15px;
  margin-right: 10px;
  background: url("cal/img/screenshot.gif") no-repeat right;
  background-size: 20px;
}
</style>

<script language="javascript">
function do_save_khidmat(val1, val2){
	var id_pemohon = $('#id_pemohon').val();
	var jenis_perkhidmatan = $('#jenis_perkhidmatan').val();
	var taraf_jawatan = $('#taraf_jawatan').val();
	var d_lantikan_jpa = $('#d_lantikan_jpa').val();
	var d_lantikan_kontrak = $('#d_lantikan_kontrak').val();
	var skim_sekarang = $('#skim_sekarang').val();
	var gred_jawatan_sekarang = $('#gred_jawatan_sekarang').val();
	var d_lantikan_khidmat_sekarang = $('#d_lantikan_khidmat_sekarang').val();
	var d_sah_khidmat_sekarang = $('#d_sah_khidmat_sekarang').val();
	var tpt_bertugas = $('#tpt_bertugas').val();
	var negeri_tpt_bertugas = $('#negeri_tpt_bertugas').val();
	var jenis_xm = $('#jenis_xm').val();
	var d_lulus_kpsl = $('#d_lulus_kpsl').val();
	var msg = '';

	if(jenis_perkhidmatan.trim() ==''){
        msg = msg+'- Sila pilih jenis perkhidmatan.';
        $("#jenis_perkhidmatan").css("border-color","#f00");
    } 
    if(taraf_jawatan.trim() ==''){
        msg = msg+"\n- Sila pilih taraf jawatan.";
        $("#taraf_jawatan").css("border-color","#f00");
    } 
	if(d_lantikan_khidmat_sekarang.trim() ==''){
        msg = msg+"\n- Sila pilih/masukkan tarikh lantikan pertama ke skim perkhidmatan sekarang (hakiki).";
        $("#d_lantikan_khidmat_sekarang").css("border-color","#f00");
    } 

    if(d_lantikan_jpa.trim() ==''){
        msg = msg+"\n- Sila pilih tarikh lantikan pertama ke Perkhidmatan Awam.";
        $('#d_lantikan_jpa').css("border-color","#f00");
	}
    if(skim_sekarang.trim() ==''){
        msg = msg+'- Sila pilih skim perkhidmatan sekarang.';
        $("#skim_sekarang").css("border-color","#f00");
    } 
    if(gred_jawatan_sekarang.trim() ==''){
        msg = msg+"\n- Sila pilih maklumat gred jawatan sekarang.";
        $('#gred_jawatan_sekarang').css("border-color","#f00");
	}

    if(taraf_jawatan == 1){
    if(d_sah_khidmat_sekarang.trim() ==''){
        msg = msg+"\n- Sila pilih/masukkan tarikh sah ke skim sekarang.";
        $('#d_sah_khidmat_sekarang').css("border-color","#f00");
	}
    }
	
    if(tpt_bertugas.trim() ==''){
        msg = msg+"\n- Sila pilih maklumat kementerian/agensi bertugas sekarang.";
        $('#tpt_bertugas').css("border-color","#f00");
        // $('.select2-selection3').css('border-color','blue');
        // $('.select2').addClass("alert");
	}


    if(negeri_tpt_bertugas.trim() ==''){
        msg = msg+"\n- Sila pilih maklumat negeri tempat bertugas.";
        $('#negeri_tpt_bertugas').css("border-color","#f00");
	}
    if(jenis_xm.trim() !='' && d_lulus_kpsl.trim() ==''){
        msg = msg+"\n- Sila pilih/masukkan tarikh lulus peperiksaan PSL.";
        $('#d_lulus_kpsl').css("border-color","#f00");
	}
    if(jenis_xm.trim() =='' && d_lulus_kpsl.trim() !=''){
        msg = msg+"\n- Sila pilih jenis peperiksaan.";
        $('#jenis_xm').css("border-color","#f00");
	}

    // if(jenis_xm.trim() ==''){
    //     msg = msg+"\n- Sila pilih maklumat jenis peperiksaan.";
    //     $('#jenis_xm').css("border-color","#f00");
	// }
    // if(d_lulus_kpsl.trim() ==''){
    //     msg = msg+"\n- Sila pilih/masukkan tarikh lulus peperiksaan PSL.";
    //     $('#d_lulus_kpsl').css("border-color","#f00");
	// }

	// alert(msg);
	if(msg.trim() !=''){ 
		alert_msg_html(msg);
	} else { 
		var fd = new FormData();
        var other_data = $('form').serializeArray();
		$.each(other_data,function(key,input){
		    fd.append(input.name,input.value);
		});

        $.ajax({
	        url:'biodata/sql_biodata.php?frm=KHIDMAT&pro=SAVE',
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


function get_gred(kod){
	var sel="#gred_jawatan_sekarang";
	$.ajax({
		url: '../include/sel_gred_jawatan.php?kod='+kod,
		type: 'post',
		data: {kod:kod},
		dataType: 'json',
		success:function(data){
			var len = data.length;
			console.log(len);
			$(sel).empty();
			$('#gred_jawatan_sekarang').empty();
			for( var i = 0; i<len; i++){
				var id = data[i]['id'];
				var name = data[i]['name'];
				var sama = data[i]['sel'];
				$(sel).append("<option value='"+id+"' "+sama+">"+name+"</option>");
			}
			//$('#gred_jawatan_sekarang').append("<option value=''>Sila pilih</option>");
		}
	});
}

function do_clear(){
	var jenis_xm = $('#jenis_xm').val();
	if(jenis_xm.trim()==''){ 
	$('#d_lulus_kpsl').val('');
	}
}
</script>
<?php
$data = get_khidmat_awam($conn,$_SESSION['SESS_UID']);
//print_r($data); 
?>
		<header class="panel-heading"  style="background-color:rgb(38, 167, 228)">
			<h6 class="panel-title"><font color="#000000" size="3"><b><?php print strtoupper($menu);?></b></font></h6>
		</header>
		<div class="panel-body">
			<div class="box-body">

			<input type="hidden" name="id_pemohon" id="id_pemohon" value="<?php print $_SESSION['SESS_UID'];?>" readonly="readonly"/>

				<div class="col-md-12">

					<?php //include 'biodata/biodata_view.php'; ?>

					<div class="form-group">
						<div class="row">
							

							<!-- <p>
							  <button class="btn btn-primary form-control" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample" title="Sila klik untuk membaca arahan berkaitan kemasukan data akademik SPM">
							    ARAHAN:
							  </button>
							</p> -->
							<!-- <div class="collapse" id="collapseExample"> -->
							  <div class="card">
									<label for="nama" class="col-sm-12 control-label" style="border: 1px solid rgb(38, 167, 228);"><b>ARAHAN : </b>
										<ul>
											<li>Bahagian ini perlu diisi oleh mereka yang sedang berkhidmat dalam Perkhidmatan Awam/Kerajaan Tempatan/Badan Berkanun/Polis</li>
											<li>Pengesahan Ketua Jabatan (Lampiran A) dan Ringkasan Kenyataan Perkhidmatan (Lampiran D) hendaklah dibawa semasa temuduga. Sila muat turun <a href="../upload_doc/LAMPIRANA_PENGESAHAN_PERKHIDMATAN.pdf" target="_blank">Lampiran A</a> dan <a href="../upload_doc/LAMPIRAND_RINGKASAN_PENYATAAN_PERKHIDMATAN.pdf" target="_blank">Lampiran D</a> di sini.</li>
										</ul>
									</label>
							  </div>
							<!-- </div> -->
						</div>

					</div>

					<div class="form-group">
						<div class="row">
							<label for="nama" class="col-sm-7 control-label"><b>Jenis Perkhidmatan <font color="#FF0000">*</font>
								<div style="float:right"><!--<img src="../images/info.gif" title="Sila klik pada medan carian dan calon boleh menaip perkataan yang dikehendaki. Carian dibuat berdasarkan perkataan yang ditaip.">--> :</div></b>
							</label>
							<div class="col-sm-5">
								<!-- <select name="jenis_perkhidmatan" id="jenis_perkhidmatan" class="form-control"> -->
								<!-- <select name="jenis_perkhidmatan" id="jenis_perkhidmatan" class="form-control select" data-live-search="true" style="height: 20px;">
									<option value="">Sila pilih</option>
									<?php //print get_perkhidmatan($conn, $data['negeri_lahir_ibu']); ?>
								</select> -->
								<select name="jenis_perkhidmatan" id="jenis_perkhidmatan" class="form-control" style="width: 100%;" aria-hidden="true">
					                <option value="">Sila pilih jenis perkhidmatan</option>
									<?php print get_perkhidmatan($conn, $data['jenis_perkhidmatan']); ?>
					            </select> 
							</div>
						</div>
					</div>

					<div class="form-group">
						<div class="row">
							<label for="nama" class="col-sm-7 control-label"><b>Jenis Lantikan <font color="#FF0000">*</font>
								<div style="float:right"><!--<img src="../images/info.gif" title="Sila klik pada medan carian dan calon boleh menaip perkataan yang dikehendaki. Carian dibuat berdasarkan perkataan yang ditaip.">--> :</div>
							</b><br>
							- PSH - Pekerja Sambilan Harian<br>
						    - Contract Of Service (COS) - mengguna pakai skim perkhidmatan, gred dan kadar gaji sebagaimana yang ditetapkan di dalam Perkhidmatan Awam.<br>
						    - Contract For Service (CFS) - tidak mengguna pakai sebarang skim perkhidmatan, gred jawatan, kadar gaji serta sebarang peraturan sebagaimana yang ditetapkan dalam Perkhidmatan Awam.
							</label>
							<div class="col-sm-5">
								<select name="taraf_jawatan" id="taraf_jawatan" class="form-control" style="width: 100%;" aria-hidden="true">
									<option value="">Sila pilih jenis lantikan</option>
									<<?php print get_taraf_jawatan($conn, $data['taraf_jawatan']); ?>
								</select>
							</div>
						</div>
					</div>

					<div class="form-group">
						<div class="row">
							<label for="nama" class="col-sm-7 control-label"><b>Tarikh Lantikan Pertama ke Perkhidmatan Awam <font color="#FF0000">*</font>
								<div style="float:right"><!--<img src="../images/info.gif" title="Sila klik pada medan carian dan calon boleh menaip perkataan yang dikehendaki. Carian dibuat berdasarkan perkataan yang ditaip.">--> :</div></b><br>
								 (Bagi pemohon yang bertaraf jawatan kontrak, tarikh lantikan adalah bermula daripada tempoh perkhidmatan kontrak yang tidak terputus melebihi tempoh enam(6) bulan daripada kontrak terdahulu. Sekiranya tempoh perkhidmatan terputus melebihi enam (6), maka tidak kira sebagai sebahagian tempoh keseluruhan kontrak.)
							</label>
							<div class="col-sm-3">
								<!-- <input type="date" name="d_lantikan_jpa" id="d_lantikan_jpa" class="form-control dates" value="<?php print $data['d_lantikan_jpa'];?>"> -->
								<input type="text" name="d_lantikan_jpa" id="d_lantikan_jpa"  size="15" maxlength="10" value="<?php print DisplayDate($data['d_lantikan_jpa']);?>" 
								data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask 
								class="form-control disableFuturedate icon" style="background-color: #fff; cursor: pointer;">
							</div>
						</div>
					</div>

					<div class="form-group">
						<div class="row">
							<label for="nama" class="col-sm-7 control-label"><b>Tarikh Tamat Kontrak (Jika Berkenaan) <div style="float:right"><!--<img src="../images/info.gif" title="Sila pilih daripada senarai/maklumat">--> :</div></b><br>
								 (Tarikh Tamat Kontrak Perkhidmatan.)
							</label>
							<div class="col-sm-3">
								<input type="date" name="d_lantikan_kontrak" id="d_lantikan_kontrak" class="form-control" value="<?php print $data['d_lantikan_kontrak'];?>">
								<!--<input type="text" name="d_lantikan_kontrak" id="d_lantikan_kontrak"  size="15" maxlength="10" value="<?php print DisplayDate($data['d_lantikan_kontrak']);?>" 
								data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask 
								class="form-control disableFuturedate icon" style="background-color: #fff; cursor: pointer;">-->
							</div>
						</div>
					</div>

					<hr>

					<div class="form-group">
						<div class="row">
							<label for="nama" class="col-sm-7 control-label"><b>Skim Perkhidmatan Sekarang <font color="#FF0000">*</font>
								<div style="float:right"><!--<img src="../images/info.gif" title="Sila klik pada medan carian dan calon boleh menaip perkataan yang dikehendaki. Carian dibuat berdasarkan perkataan yang ditaip.">--> :</div></b><br>
								Nota: Jika Skim Perkhidmatan tiada dalam senarai, sila hubungi pihak SPP
							</label>
							<div class="col-sm-5">
								<select name="skim_sekarang" id="skim_sekarang" class="form-control select2-accessible" onchange="get_gred(this.value)" 
									style="width: 100%;" aria-hidden="true">
								<!--<select name="skim_sekarang" id="skim_sekarang" class="form-control select2 select2-accessible" style="width: 100%;" aria-hidden="true">-->

									<option value="">Sila pilih skim perkhidmatan sekarang</option>
									<<?php print get_skim($conn, $data['skim_sekarang']); ?>
								</select>
							</div>
						</div>
					</div>

					<div class="form-group">
						<div class="row">
							<label for="nama" class="col-sm-7 control-label"><b>Gred Jawatan Sekarang <font color="#FF0000">*</font>
								<div style="float:right"><!--<img src="../images/info.gif" title="Sila klik pada medan carian dan calon boleh menaip perkataan yang dikehendaki. Carian dibuat berdasarkan perkataan yang ditaip.">--> :</div></b></label>
							<div class="col-sm-5">
								<!--<select name="gred_jawatan_sekarang" id="gred_jawatan_sekarang" class="form-control select2 select2-accessible" style="width: 100%;" aria-hidden="true">-->
								<select name="gred_jawatan_sekarang" id="gred_jawatan_sekarang" class="form-control" style="width: 100%;" aria-hidden="true">

									<option value="">Sila pilih gred jawatan sekarang</option>
									<?php print get_gred_jawatan($conn, $data['gred_jawatan_sekarang'], $data['skim_sekarang']); ?>
								</select>
							</div>
						</div>
					</div><!-- 

					<div class="form-group">
						<div class="row">
							<label for="nama" class="col-sm-7 control-label"><b>Tarikh Lantikan Pertama ke Perkhidmatan Awam <font color="#FF0000">*</font>
								<div style="float:right"><img src="../images/info.gif" title="Sila pilih daripada senarai/maklumat"> :</div></b><br>
								 (Bagi pemohon yang bertaraf jawatan kontrak, tarikh lantikan adalah bermula daripada tempoh perkhidmatan kontrak yang tidak terputus melebihi tempoh enam(6) bulan daripada kontrak terdahulu. Sekiranya tempoh perkhidmatan terputus melebihi enam (6), maka tidak kira sebagai sebahagian tempoh keseluruhan kontrak.)
							</label>
							<div class="col-sm-2">
								<input type="date" name="d_lantikan_khidmat_sekarang" id="d_lantikan_khidmat_sekarang" class="form-control">
							</div>
						</div>
					</div> -->

					<div class="form-group">
						<div class="row">
							<label for="nama" class="col-sm-7 control-label"><b>Tarikh Lantikan Pertama ke Skim Perkhidmatan Sekarang (Hakiki)  <font color="#FF0000">*</font>
								<div style="float:right"><!--<img src="../images/info.gif" title="Contoh : Sekiranya gred jawatan anda adalah N22, sila isikan tarikh lantikan Gred N17">--> :
								</div></b>
							</label>

							<div class="col-sm-3">
								<!-- <input type="date" name="d_sah_khidmat_sekarang" id="d_sah_khidmat_sekarang" class="form-control" value="<?php print $data['d_sah_khidmat_sekarang'];?>"> -->
								<input type="text" name="d_lantikan_khidmat_sekarang" id="d_lantikan_khidmat_sekarang"  size="15" maxlength="10" value="<?php print DisplayDate($data['d_lantikan_khidmat_sekarang']);?>" 
								data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask 
								class="form-control disableFuturedate icon" style="background-color: #fff; cursor: pointer;">
							</div>
						</div>
					</div>

					<div class="form-group">
						<div class="row">
							<label for="nama" class="col-sm-7 control-label"><b>Tarikh Pengesahan ke Skim Perkhidmatan Sekarang (Jika Berkenaan)
								<div style="float:right">
									<!--<img src="../images/info.gif" title="Contoh : Sekiranya gred jawatan anda adalah N22, sila isikan tarikh lantikan Gred N17">--> :
								</div></b><br>
								 (Bagi pemohon yang berkhidmat secara kontrak dan sangkut tidak perlu mengisi ruangan ini)
							</label>
							<div class="col-sm-3">
								<!-- <input type="date" name="" class="form-control" value="<?php print $data['d_lulus_kpsl'];?>"> -->
								<input type="text" name="d_sah_khidmat_sekarang" id="d_sah_khidmat_sekarang"  size="15" maxlength="10" value="<?php print DisplayDate($data['d_sah_khidmat_sekarang']);?>" 
								data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask 
								class="form-control disableFuturedate icon" style="background-color: #fff; cursor: pointer;">
							</div>
						</div>
					</div>

					<hr>

					<div class="form-group">
						<div class="row">
							<label for="nama" class="col-sm-7 control-label"><b>Kementerian/Jabatan Tempat Bertugas <font color="#FF0000">*</font>
								<div style="float:right">
									<!--<img src="../images/info.gif" title="Sila klik pada medan carian dan calon boleh menaip perkataan yang dikehendaki. Carian dibuat berdasarkan perkataan yang ditaip.">--> :
								</div></b><br>
								(Sekiranya skim perkhidmatan sekarang (hakiki) adalah jawatan kader, sila nyatakan kementerian/jabatan pegawai sedang bertugas.)
								<br>Nota: Jika Kementerian / Jabatan tiada dalam senarai, sila hubungi pihak SPP
							</label>
							<div class="col-sm-5">
								<!-- <select name="tpt_bertugas" id="tpt_bertugas" class="form-control select2 select2-selection3"> -->
								<select name="tpt_bertugas" id="tpt_bertugas" class="form-control" style="width: 100%;" aria-hidden="true">
									<option value="">Sila pilih kementerian/agensi tempat bertugas</option>
									<<?php print get_kementerian($conn, $data['tpt_bertugas']); ?>
									<!-- <option value="">Lain-Lain</option> -->
								</select>
							</div>
						</div>
					</div>

					<div class="form-group">
						<div class="row">
							<label for="nama" class="col-sm-7 control-label"><b>Negeri Tempat Bertugas  <font color="#FF0000">*</font>
								<div style="float:right">
									<!--<img src="../images/info.gif" title="Sila klik pada medan carian dan calon boleh menaip perkataan yang dikehendaki. Carian dibuat berdasarkan perkataan yang ditaip.">--> :
								</div></b></label>
							<div class="col-sm-5">
								<select name="negeri_tpt_bertugas" id="negeri_tpt_bertugas" class="form-control">
									<option value="">Sila pilih negeri tempat bertugas</option>
									<?php print get_negeri($conn, $data['negeri_tpt_bertugas']); ?>
								</select>
							</div>
						</div>
					</div>

					<hr>
					<?php 
					$rsPSB = $conn->query("SELECT * FROM $schema1.`ref_kelulusan` WHERE `JENIS`=2 AND `KATEGORI`='B' ORDER BY `DISKRIPSI`"); 
					?>
					<div class="form-group">
						<div class="row">
							<label for="nama" class="col-sm-7 control-label"><b>Jenis Peperiksaan <!--<font color="#FF0000">*</font>-->
								<div style="float:right">
									<!--<img src="../images/info.gif" title="Sila klik pada medan carian dan calon boleh menaip perkataan yang dikehendaki. Carian dibuat berdasarkan perkataan yang ditaip.">--> :
								</div></b>
							</label>
							<div class="col-sm-5">
								<select name="jenis_xm" id="jenis_xm" class="form-control select2 select2-accessible" onchange="do_clear()">
									<option value="">Sila pilih jenis peperiksaan</option>
									<?php while(!$rsPSB->EOF){ ?>}
									<option value="<?=$rsPSB->fields['KOD'];?>" <?php if($rsPSB->fields['KOD']==$data['jenis_xm']){ print 'selected'; }?>><?=$rsPSB->fields['DISKRIPSI'];?></option>
									<?php $rsPSB->movenext(); } ?>
								</select>
							</div>
						</div>
					</div>

					<div class="form-group">
						<div class="row">
							<label for="nama" class="col-sm-7 control-label"><b>Tarikh Lulus Peperiksaan PSL<!--<font color="#FF0000">*</font>-->
								<!--<div style="float:right"><img src="../images/info.gif" title="Sila pilih daripada senarai/maklumat"> :</div>-->
							</b>
							<br>
							- PSL - Peningkatan Secara Lantikan<br>
							</label>
							<div class="col-sm-3">
								<!-- <input type="date" name="d_lulus_kpsl" id="d_lulus_kpsl" class="form-control" value="<?php print $data['d_lulus_kpsl'];?>" max='2000-13-13'> -->
								<input type="text" name="d_lulus_kpsl" id="d_lulus_kpsl"  size="15" maxlength="10" value="<?php print DisplayDate($data['d_lulus_kpsl']);?>" 
								data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask 
								class="form-control disableFuturedate icon" style="background-color: #fff; cursor: pointer;">
				                <!-- <img src="cal/img/screenshot.gif" alt="" width="21" height="22" align="absmiddle" 
				                onclick="displayCalendar(document.forms[0].d_lulus_kpsl,'dd/mm/yyyy',this)"/> [dd/mm/yyyy]  -->
							</div>
						</div>
					</div>


					
					
					<div class="modal-footer" style="padding:0px;">
						<button type="button" id="simpan" class="btn btn-primary mt-sm mb-sm" onclick="do_save_khidmat('SAVE','')"><i class="fa fa-save"></i> Simpan</button>
						&nbsp;
						<?php if(!empty($data['jenis_perkhidmatan'])){ ?>
							<label class="btn btn-danger" onclick="do_hapus('biodata/sql_biodata.php?frm=KHIDMAT&pro=HAPUS&id_pemohon=<?=$_SESSION['SESS_UID'];?>')">Hapus</label>
						<?php } ?>
						<input type="hidden" name="progid" id="progid" value="<?php print $progid;?>" />
						<input type="hidden" name="proses" value="<?php print $proses;?>" />
					</div>
				</div>

			
			</div>
		</div>
	     
<script type="text/javascript">

// Use datepicker on the date inputs
$("input[type=date]").datepicker({
  dateFormat: 'yy-mm-dd',
  onSelect: function(dateText, inst) {
    $(inst).val(dateText); // Write the value in the input
  }
});

// Code below to avoid the classic date-picker
$("input[type=date]").on('click', function() {
  return false;
});

$(document).ready(function () {
      var currentDate = new Date();
      $('.disableFuturedate').datepicker({
      format: 'dd/mm/yyyy',
      autoclose:true,
      endDate: "currentDate",
      maxDate: currentDate
      // }).on('changeDate', function (ev) {
      //    $(this).datepicker('hide');
      });
      // $('.disableFuturedate').keyup(function () {
      //    if (this.value.match(/[^0-9]/g)) {
      //       this.value = this.value.replace(/[^0-9^-]/g, '');
      //    }
      // });
   });

// $(function() {
//   $( "#d_lulus_kpsl" ).datepicker({  maxDate: new Date() });
//  });
// $(function(){
//     var dtToday = new Date();
    
//     var month = dtToday.getMonth() + 1;
//     var day = dtToday.getDate();
//     var year = dtToday.getFullYear();
//     if(month < 10)
//         month = '0' + month.toString();
//     if(day < 10)
//         day = '0' + day.toString();
    
//     var maxDate = year + '-' + month + '-' + day;
//     // alert(maxDate);
//     $('#d_lulus_kpsl').attr('max', maxDate);
// });
</script>
<script src="../plugins/inputmask/jquery.inputmask.min.js"></script>
<script src="../plugins/daterangepicker/daterangepicker.js"></script>

<script>
  $(function () {
    //Datemask dd/mm/yyyy
    $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
    //Datemask2 mm/dd/yyyy
    $('#datemask2').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
    //Money Euro
    $('[data-mask]').inputmask()

});
</script>