<?php
include 'akademik/sql_akademik.php';
$data = get_exam($conn,$_SESSION['SESS_UID']);
$uid=$_SESSION['SESS_UID'];
// print_r($data);
$tahun_u = $data['spm_tahun_1'];

$rsSijil = $conn->query("SELECT * FROM $schema2.`calon_sijil` WHERE `jenis_sijil`='EXT' AND `id_pemohon`=".tosql($uid));
if(empty($rsSijil->fields['sijil_nama'])){ $sijil="../upload_doc/PMR_Mock_Result_Statement_Certificate.png"; }
else { $sijil = "../uploads_doc/".$uid."/".$rsSijil->fields['sijil_nama']; }
?>
<script type="text/javascript">

function jana_spm_ulangan(slot) {
    var tahun = $('#tahun' + slot).val();
    var akg = $('#akg' + slot).val();
    var id_pemohon = $('#id_pemohon').val();

    if (tahun == "" || akg == "") {
        swal("Amaran", "Sila masukkan Tahun dan Angka Giliran untuk slot ini.", "warning");
        return;
    }

    $.ajax({
        url: 'akademik/sql_akademik.php?frm=ULANGAN&pro=FETCH_ULANGAN',
        type: 'POST',
        data: { tahun: tahun, akg: akg, id_pemohon: id_pemohon },
        dataType: 'json',
        beforeSend: function() {
            swal({ title: "Sila Tunggu", text: "Menarik data SPM Ulangan...", showConfirmButton: false });
        },
        success: function(res) {
            swal.close();
            if (res.status == 'OK') {
                $('#simpan').fadeIn();
                
                // --- FIX 1: HANYA PAPARKAN HEADER TABLE (Global) ---
                $('.hdr-keputusan').show(); 

                $.each(res.data, function(index, item) {
                    var currentSlot = parseInt(slot) + index;
                    
                    if (currentSlot <= 3) {
                        var kodSistem = item.kod;
                        var gredSistem = item.gred;

                        // --- FIX 2: HANYA PAPARKAN DATA UNTUK BARIS INI SAHAJA ---
                        $('#row_utama_' + currentSlot + ' .col-keputusan').show();
                        
                        // Sembunyikan butang papar pada row tersebut
                        $('#row_utama_' + currentSlot + ' .btn-papar').hide();

                        // Assign nilai
                        $('#mp' + currentSlot).val(kodSistem).trigger('change');
                        $('#gred' + currentSlot).val(gredSistem.trim()).trigger('change');
                        $('#tahun' + currentSlot).val(tahun);
                        $('#akg' + currentSlot).val(akg);

                        // Trigger UI tambahan (BM)
                        setTimeout(function() {
                            do_open(kodSistem, currentSlot);
                            if (kodSistem == '101') { 
                                $('#bm' + currentSlot).val('1'); 
                            }
                        }, 200);
                        
                        // Lock fields
                        $('#tahun' + currentSlot).attr('disabled', true);
                        $('#akg' + currentSlot).attr('readonly', true);
                        $('#mp' + currentSlot).attr('disabled', true);
                        $('#gred' + currentSlot).attr('disabled', true);
                        
                        $('#vals' + currentSlot).val(1);
                    }
                });
            } else {
                // MOD MANUAL
                $('.hdr-keputusan').show(); 
                $('#row_utama_' + slot + ' .col-keputusan').show();
                $('#simpan').fadeIn();
                swal("Maklumat Tiada", "Data tidak dijumpai. Sila masukkan secara manual.", "info");
            }
        }
    });
}

function do_open(vals, id) {
    var row = document.getElementById("tambahan_row" + id);
    var panel = document.getElementById("tambahan" + id);
    
    if (vals == '101' || vals == '103') { 
        if(row) row.style.display = "table-row";
        if(panel) panel.style.display = "block";
    } else {
        if(row) row.style.display = "none";
        if(panel) panel.style.display = "none";
    }
    on_chg(id);
}

function do_save() {
    // PADAM baris ini dari sini: $('select[disabled]').prop('disabled', false);
    
    var msg = '';
    var hasData = false;

    for (var i = 1; i <= 4; i++) {
        var tahunObj = $('#tahun' + i);
        var mpObj = $('#mp' + i);
        var gredObj = $('#gred' + i);

        if (tahunObj.length === 0) continue;

        var tahun = (tahunObj.val() || "").toString().trim();
        var mp = (mpObj.val() || "").toString().trim();
        var gred = (gredObj.val() || "").toString().trim();

        if (tahun !== '' || mp !== '' || gred !== '') {
            hasData = true; 

            if (tahun === '' || mp === '' || gred === '') {
                msg += "\n- Sila lengkapkan maklumat (Tahun, Matapelajaran, Gred) pada Slot " + i;
                if(tahun === '') tahunObj.css("border-color", "#f00");
                if(mp === '') mpObj.css("border-color", "#f00");
                if(gred === '') gredObj.css("border-color", "#f00");
            } else {
                if (mp == '101') {
                    var lisan = ($('#lisan' + i).val() || "").toString().trim();
                    var bm = ($('#bm' + i).val() || "").toString().trim();
                    if (lisan == '' || bm == '') {
                        msg += "\n- Sila lengkapkan maklumat Ujian Lisan untuk Bahasa Melayu pada Slot " + i;
                        $('#bm' + i).css("border-color", "#f00");
                        $('#lisan' + i).css("border-color", "#f00");
                    }
                }
            }
        }
    }

    if (!hasData) {
        msg = "\n- Sila masukkan sekurang-kurangnya satu maklumat peperiksaan tambahan.";
        $('#tahun1, #mp1, #gred1').css("border-color", "#f00");
    }

    if (msg !== '') {
        alert_msg_html(msg);
        // Field kekal disabled di sini kerana kita tidak panggil prop('disabled', false) lagi
    } else {
        // HANYA ENABLEKAN DI SINI (Validasi sudah lulus)
        $('select[disabled]').prop('disabled', false);

        var fd = new FormData();
        var fileElem = $('#file1')[0];
        if (fileElem && fileElem.files.length > 0) {
            fd.append('file1', fileElem.files[0]);
        }

        var other_data = $('form').serializeArray();
        $.each(other_data, function(key, input) {
            fd.append(input.name, input.value);
        });

        $.ajax({
            url: 'akademik/sql_akademik.php?frm=ULANGAN&pro=SAVE',
            type: 'POST',
            data: fd,
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                if (data.trim() == 'OK') {
                    swal({ title: 'Berjaya', text: 'Maklumat telah dikemaskini', type: 'success' })
                    .then(function() { window.location.reload(); });
                } else {
                    swal('Amaran', 'Gagal mengemaskini maklumat: ' + data, 'error');
                    // Jika gagal simpan ddb, anda mungkin mahu disable balik
                    // lock_inputs_api(); 
                }
            }
        });
    }
}
// function do_open(vals,id){
// 	var x = '';	
// 	// alert(id+" : "+vals);
//   	if(id==1){
//   		x = document.getElementById("tambahan1");
//   	} else if(id==2){
//   		x = document.getElementById("tambahan2");
//   	} else if(id==3){
//   		x = document.getElementById("tambahan3");
//   	} else if(id==4){
//   		x = document.getElementById("tambahan4");
// 	}

// 	if(vals=='101'){ 
// 		x.style.display = "block";
// 	} else {
// 		x.style.display = "none";
// 	}	

//  	on_chg(id);

// }

function on_chg(vals){
	if(vals==1){
		if($('#tahun1').val()=='' && $('#mp1').val()=='' &&$('#gred1').val()==''){ 
			$('#vals1').val(0);
		} else {
			$('#vals1').val(1);
		}
	} else if(vals==2){
		if($('#tahun2').val()=='' && $('#mp2').val()=='' &&$('#gred2').val()==''){ 
			$('#vals2').val(0);
		} else {
			$('#vals2').val(1);
		}
	} else if(vals==3){
		if($('#tahun3').val()=='' && $('#mp3').val()=='' &&$('#gred3').val()==''){ 
			$('#vals3').val(0);
		} else {
			$('#vals3').val(1);
		}
	} else if(vals==4){
		if($('#tahun4').val()=='' && $('#mp4').val()=='' &&$('#gred4').val()==''){ 
			$('#vals4').val(0);
		} else {
			$('#vals4').val(1);
		}
	}
}

function do_input() { 

	var fileUpload = $("#file1")[0];
	//alert(fileUpload);
	var regex = new RegExp("\.(jpe?g|png|jpg|gif)$");

    if (regex.test(fileUpload.value.toLowerCase())) {
        //Initiate the FileReader object.

	    if (!fileUpload.files) { // This is VERY unlikely, browser support is near-universal
	        console.error("This browser doesn't seem to support the `files` property of file inputs.");
	    } else if (!fileUpload.files[0]) {
	        console.log("Please select a file before clicking 'Load'");
	    } else {
		    var file = fileUpload.files[0];
			if(file.size > 307200){
				swal({
		    		title: 'Amaran',
		    		text: 'Saiz fail yang dimuatnaik melebihi daripada yang dibenarkan (300kb)',
		    		type: 'warning',
		    		confirmButtonClass: "btn-warning",
		    		confirmButtonText: "Ok",
		    		showConfirmButton: true,
		    	});
				return fileUpload.value = '';
			}
	        //console.log("File " + file.name + " is " + file.size + " bytes in size");
	    }
        
    } else {
        swal({
            title: 'Amaran',
            text: 'Kami hanya menerima format JPG, JPEG, GIF @ PNG sahaja.',
            type: 'warning',
            confirmButtonClass: "btn-warning",
            confirmButtonText: "Ok",
            showConfirmButton: true,
        });
        return fileUpload.value = '';
    }
}

</script>
		<header class="panel-heading" style="background-color:#0088cc;">
			<h6 class="panel-title"><font color="#fff" size="3"><b><?php print strtoupper($menu);?></b></font></h6>
		</header>
		<div class="panel-body">
			<div class="box-body">

			<input type="hidden" name="id_pemohon" id="id_pemohon" value="<?php print $_SESSION['SESS_UID'];?>" readonly="readonly"/>

				<div class="col-md-12">

					<?php //include 'biodata/biodata_view.php'; ?>

					<div class="form-group">
						<div class="row">
							<!--<p>
							  <button class="btn btn-primary form-control" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample" title="Sila klik untuk membaca arahan berkaitan kemasukan data akademik SPM">
							    ARAHAN:
							  </button>
							</p>-->
						<!-- <div class="collapse" id="collapseExample"> -->
						  <div class="card">
								<label for="nama" class="col-sm-12 control-label" style="border: 1px solid rgb(38, 167, 228);"><b>ARAHAN : Sila Masukkan maklumat peperiksaan tambahan</b>
									<ul>
									<li>Peperiksaan Bahasa Melayu, Matematik, Sejarah bagi Peperiksaan Julai sahaja</li>
									</ul>
								</label>

						  </div>
						<!-- </div> -->

					</div>
					<hr>
					<?php 
					//$conn->debug=true;

					$spm_id1 = ''; $mid1 = ''; $tahun1 = ''; $mp1 = ''; $gred1 = ''; $bm1 = ''; $lisan1 = '';
					$spm_id2 = ''; $mid2 = ''; $tahun2 = ''; $mp2 = ''; $gred2 = ''; $bm2 = ''; $lisan2 = '';
					$spm_id3 = ''; $mid3 = ''; $tahun3 = ''; $mp3 = ''; $gred3 = ''; $bm3 = ''; $lisan3 = '';
					$spm_id4 = ''; $mid4 = ''; $tahun4 = ''; $mp4 = ''; $gred4 = ''; $bm4 = ''; $lisan4 = '';



					$rssijil = $conn->query("SELECT * FROM $schema1.`ref_paper_julai` WHERE `sah_yt`='Y'");
					$rsGred = $conn->query("SELECT * FROM $schema1.`ref_gred_matapelajaran` WHERE `TKT`='5' ORDER BY `SUSUNAN`");

					$rsData = $conn->query("SELECT * FROM $schema2.`calon_spm` WHERE `jenis_xm`='T' AND `id_pemohon`=".tosql($_SESSION['SESS_UID'])." ORDER BY `spm_id`");
					$cntt = 0; $vals1=0; $vals2=0; $vals3=0; $vals4=0;
					while(!$rsData->EOF){
						if($cntt==0){
							$vals1=1;
							$spm_id1 = $rsData->fields['spm_id'];
							$mid1 = $rsData->fields['id_pemohon'];
							$tahun1 = $rsData->fields['tahun'];
							$mp1 = $rsData->fields['matapelajaran'];
							$gred1 = $rsData->fields['gred'];
							$bm1 = $rsData->fields['jenis_sijil'];
							$lisan1 = $rsData->fields['ujian_lisan'];
							$akg1 = $rsData->fields['angka_giliran'];
						} else if($cntt==1){
							$vals2=1;
							$spm_id2 = $rsData->fields['spm_id'];
							$mid2 = $rsData->fields['id_pemohon'];
							$tahun2 = $rsData->fields['tahun'];
							$mp2 = $rsData->fields['matapelajaran'];
							$gred2 = $rsData->fields['gred'];
							$bm2 = $rsData->fields['jenis_sijil'];
							$lisan2 = $rsData->fields['ujian_lisan'];
							$akg2 = $rsData->fields['angka_giliran'];
						} else if($cntt==2){
							$vals3=1;
							$spm_id3 = $rsData->fields['spm_id'];
							$mid3 = $rsData->fields['id_pemohon'];
							$tahun3 = $rsData->fields['tahun'];
							$mp3 = $rsData->fields['matapelajaran'];
							$gred3 = $rsData->fields['gred'];
							$bm3 = $rsData->fields['jenis_sijil'];
							$lisan3 = $rsData->fields['ujian_lisan'];
							$akg3 = $rsData->fields['angka_giliran'];
						} else if($cntt==3){
							$vals4=1;
							$spm_id4 = $rsData->fields['spm_id'];
							$mid4 = $rsData->fields['id_pemohon'];
							$tahun4 = $rsData->fields['tahun'];
							$mp4 = $rsData->fields['matapelajaran'];
							$gred4 = $rsData->fields['gred'];
							$bm4 = $rsData->fields['jenis_sijil'];
							$lisan4 = $rsData->fields['ujian_lisan'];
							$akg4 = $rsData->fields['angka_giliran'];
						}
						$cntt++;
						$rsData->movenext();
					}

					?>
					<div class="form-group">
						<div class="row">
							<div class="col-sm-12">
								<table class="table table-bordered" style="width: 100%; table-layout: fixed;">
									<thead>
										<tr style="background-color: #f4f4f4;">
											<th width="20%">TAHUN</th>
											<th width="25%">ANGKA GILIRAN</th>
											<?php 
												$showColHeader = (!empty($spm_id1) || !empty($spm_id2) || !empty($spm_id3)) ? '' : 'display:none;';
											?>
											<th class="col-keputusan hdr-keputusan" style="<?=$showColHeader;?>" width="30%">MATAPELAJARAN</th>
											<th class="col-keputusan hdr-keputusan" style="<?=$showColHeader;?>" width="12%">GRED</th>
											<th width="13%">TINDAKAN</th>
										</tr>
									</thead>
									<tbody>
										<?php for($i=1; $i<=3; $i++) { 
											$spm_id = ${"spm_id$i"};
											$tahun_val = ${"tahun$i"};
											$mp_val = ${"mp$i"};
											$gred_val = ${"gred$i"};
											
											// Pastikan backend anda (sql_akademik.php) telah assign nilai ini dari DB
											$akg_val = ${"akg$i"}; 
											
											$hasDataRow = (!empty($spm_id)) ? true : false;
										?>
										<tr id="row_utama_<?=$i;?>">
											<td>
												<select class="form-control" name="tahun<?=$i;?>" id="tahun<?=$i;?>" onchange="on_chg(<?=$i;?>)" <?=$hasDataRow?'disabled':'';?>>
													<option value="">Pilih</option>
													<?php for($t=date("Y"); $t>$tahun_u; $t--){ ?>
													<option value="<?=$t;?>" <?php if($tahun_val==$t){ print 'selected'; }?>><?=$t;?></option>
													<?php } ?>
												</select>
											</td>
											<td>
												<input type="text" class="form-control" name="akg<?=$i;?>" id="akg<?=$i;?>" placeholder="Angka Giliran" value="<?=$akg_val;?>" onchange="on_chg(<?=$i;?>)" <?=$hasDataRow?'readonly':'';?>>
											</td>
											<td class="col-keputusan" style="<?=($hasDataRow)?'':'display:none;';?>">
												<select class="form-control" name="mp<?=$i;?>" id="mp<?=$i;?>" onchange="do_open(this.value,<?=$i;?>)" <?=$hasDataRow?'disabled':'';?>>
													<option value="">Sila pilih matapelajaran</option>
													<?php $rssijil->movefirst();
													while(!$rssijil->EOF){ ?>
													<option value="<?=$rssijil->fields['mpel_kod'];?>" <?php if($mp_val==$rssijil->fields['mpel_kod']){ print 'selected'; }?>><?=$rssijil->fields['descripsi'];?></option>
													<?php $rssijil->movenext(); } ?>
												</select>
											</td>
											<td class="col-keputusan" style="<?=($hasDataRow)?'':'display:none;';?>">
												<select class="form-control" name="gred<?=$i;?>" id="gred<?=$i;?>" onchange="on_chg(<?=$i;?>)" <?=$hasDataRow?'disabled':'';?>>
													<option value="">Gred</option>
													<?php $rsGred->movefirst();
													while(!$rsGred->EOF){ ?>
													<option value="<?=$rsGred->fields['GRED'];?>" <?php if($gred_val==$rsGred->fields['GRED']){ print 'selected'; } ?>><?=$rsGred->fields['GRED'];?></option>  
													<?php $rsGred->movenext(); } ?>
												</select>
											</td>
											<td align="center">
												<?php if(!$hasDataRow){ ?>
													<button type="button" class="btn btn-success btn-sm btn-block btn-papar" onclick="jana_spm_ulangan(<?=$i;?>)">
														<i class="fa fa-file"></i> Papar Keputusan
													</button>
												<?php } ?>
												<?php if($hasDataRow){ ?>
													<img src="../images/trash.png" title="Hapus" style="cursor: pointer;" height="25" onclick="do_hapus('akademik/sql_akademik.php?frm=ULANGAN&pro=ULANGAN_DEL&sid=<?=$spm_id;?>&id_pemohon=<?=$_SESSION['SESS_UID'];?>')">
												<?php } ?>
											</td>
										</tr>
										<tr id="tambahan_row<?=$i;?>" style="<?=($mp_val=='101' || $mp_val=='103') ? 'display:table-row;' : 'display:none;'; ?> background-color:#fff9e6;">
											<td colspan="6">
												<div id="tambahan<?=$i;?>" style="padding:10px;">
													<div class="row">
														<div class="col-sm-6">
															<label class="small">Jenis:</label>
															<select name="bm<?=$i;?>" id="bm<?=$i;?>" class="form-control" <?=$hasDataRow?'disabled':'';?>>
																<option value="">Sila Pilih</option>
																<option value="1" <?=(${"bm$i"}=='1')?'selected':'';?>>Bahasa Melayu Kertas Julai / SPM Ulangan</option>
															</select>
														</div>
														<div class="col-sm-6">
															<label class="small">Ujian Lisan:</label>
															<select name="lisan<?=$i;?>" id="lisan<?=$i;?>" class="form-control" <?=$hasDataRow?'disabled':'';?>>
																<option value="">Sila Pilih</option>
																<option value="L" <?=(${"lisan$i"}=='L')?'selected':'';?>>Lulus</option>
																<option value="G" <?=(${"lisan$i"}=='G')?'selected':'';?>>Gagal</option>
															</select>
														</div>
													</div>
												</div>
											</td>
										</tr>
										<?php } ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>

					<div class="modal-footer" style="padding:0px;">
						<button type="button" id="simpan" class="btn btn-primary mt-sm mb-sm" onclick="do_save('SAVE','')" style="<?=($vals1==1 || $vals2==1)?'':'display:none;';?>">
							<i class="fa fa-save"></i> Simpan
						</button>
						&nbsp;
						<?php if(!empty($tahun1)){ ?>
						<label id="btn_hapus_semua" class="btn btn-danger" onclick="do_hapus('akademik/sql_akademik.php?frm=ULANGAN&pro=CLEAR&kep=<?=$actions;?>&id_pemohon=<?=$_SESSION['SESS_UID'];?>')">Hapus</label>
						<?php } ?>
					</div>
				</div>

			
			</div>
		</div>
	     

<?php if($mp1=="101"){ ?>
<script language="javascript" type="text/javascript">
	document.getElementById("tambahan1").style.display = "block";
</script>
<?php } else { ?>
<script language="javascript" type="text/javascript">
	document.getElementById("tambahan1").style.display = "none";
</script>
<?php } ?>

<?php if($mp2=="101"){ ?>
<script language="javascript" type="text/javascript">
	document.getElementById("tambahan2").style.display = "block";
</script>
<?php } else { ?>
<script language="javascript" type="text/javascript">
	document.getElementById("tambahan2").style.display = "none";
</script>
<?php } ?>

<?php if($mp3=="101"){ ?>
<script language="javascript" type="text/javascript">
	document.getElementById("tambahan3").style.display = "block";
</script>
<?php } else { ?>
<script language="javascript" type="text/javascript">
	document.getElementById("tambahan3").style.display = "none";
</script>
<?php } ?>

