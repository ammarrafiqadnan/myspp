<?php 
include_once 'akademik/sql_akademik.php';

// 1. QUERY LOCAL DB
$rsUniv = $conn->query("SELECT * FROM $schema2.`calon_ipt` WHERE `bil_keputusan`='1' AND `id_pemohon`=".tosql($uid));

// Check status data: Jika kosong, kita akan cuba tarik API.
$has_local_data = ($rsUniv->EOF || empty($rsUniv->fields['tahun'])) ? 'false' : 'true';

// Check flag integrasi dari DB ('Y' atau 'T' atau null)
$db_is_integ = isset($rsUniv->fields['is_integrasi']) ? $rsUniv->fields['is_integrasi'] : 'T';

// Helper variables
$val_tahun      = $rsUniv->fields['tahun'];
$val_senat      = DisplayDate($rsUniv->fields['tkh_senate']);
$val_peringkat  = $rsUniv->fields['peringkat'];
$val_cgpa       = $rsUniv->fields['cgpa'];
$val_inst       = $rsUniv->fields['inst_keluar_sijil'];
$val_francais   = empty($rsUniv->fields['inst_francais']) ? 'T' : $rsUniv->fields['inst_francais'];
$val_sijil      = $rsUniv->fields['pengkhususan'];

// Field Manual (Major, Minor, MUET, Biasiswa) - Sentiasa boleh edit jika belum submit, atau pull dari DB
$val_major      = $rsUniv->fields['major'];
$val_minor      = $rsUniv->fields['minor'];
$val_muet_type  = $rsUniv->fields['muet'];
$val_muet_year  = $rsUniv->fields['muet_tahun'];
$val_muet_res   = $rsUniv->fields['muet_gred'];
$val_biasiswa   = $rsUniv->fields['biasiswa'];

// ATTRIBUTE KHAS: Hanya kunci field API jika Integrasi = Y
// Field lain (Major/Minor/MUET) TIDAK AKAN dapat attribute ini.
$attr_disable_api = ($db_is_integ == 'Y') ? 'disabled style="background-color: #e9ecef;"' : '';
$class_api_field  = ($db_is_integ == 'Y') ? 'api-locked' : ''; // Class marker untuk JS

// Upload section hide jika integrasi
$style_upload = ($db_is_integ == 'Y') ? 'display:none;' : '';
$val_flag_api = ($db_is_integ == 'Y') ? '1' : '0';
?>

<input type="hidden" id="status_data_1" value="<?=$has_local_data;?>">
<input type="hidden" id="is_api_data_1" name="is_api_data_1" value="<?=$val_flag_api;?>">
<input type="hidden" id="sess_uic" value="<?=$_SESSION['SESS_UIC'];?>">

<script src="akademik/kpt-api-client.js"></script>

<div id="univ_form_wrapper_1"> 
    <div class="form-group">
        <div class="row">
            <div class="col-sm-12"><br>
                
                <div class="form-group">
                    <div class="row">
                        <label class="col-sm-4 control-label"><b>Tahun Graduasi <font color="#FF0000">*</font><div style="float:right">:</div></b></label>
                        <div class="col-sm-4">
                            <select class="form-control <?=$class_api_field;?>" name="tahun1" id="tahun1" <?=$attr_disable_api;?>>
                                <option value="">Sila pilih tahun</option>
                                <?php for($t1=date("Y");$t1>=1978;$t1--){ ?>
                                <option value="<?=$t1;?>" <?php if($val_tahun==$t1){ print 'selected'; }?>><?=$t1;?></option> 
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <label class="col-sm-4 control-label"><b>Tarikh Kelulusan Senat <font color="#FF0000">*</font></b></label>
                        <div class="col-sm-4">
                            <input type="text" id="tkh_senate" name="tkh_senate" size="15" maxlength="10" value="<?=$val_senat;?>"
                            data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask 
                            class="form-control enableFuturedate icon <?=$class_api_field;?>" <?=$attr_disable_api;?>>    
                        </div>
                    </div>
                </div>

                <?php $rfKelulusan = $conn->query("SELECT * FROM $schema1.`ref_peringkat_kelulusan` WHERE `is_deleted`='0' AND `status`=0"); ?>
                <div class="form-group">
                    <div class="row">
                        <label class="col-sm-4 control-label"><b>Peringkat Kelulusan <font color="#FF0000">*</font><div style="float:right">:</div></b></label>
                        <div class="col-sm-8">
                            <select name="peringkat1" id="peringkat1" class="form-control <?=$class_api_field;?>" onchange="get_univ(this.value)" <?=$attr_disable_api;?>>
                                <option value="">Sila pilih peringkat kelulusan</option>
                                <?php while(!$rfKelulusan->EOF){ ?>
                                <option value="<?=$rfKelulusan->fields['kod'];?>" <?php if($val_peringkat==$rfKelulusan->fields['kod']){ print 'selected'; }?>><?php print $rfKelulusan->fields['diskripsi'];?></option>  
                                <?php $rfKelulusan->movenext(); } ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <label class="col-sm-4 control-label"><b>CGPA (PNGK) :</b></label>
                        <div class="col-sm-2">
                            <input type="text" name="cgpa1" id="cgpa1" class="form-control <?=$class_api_field;?>" value="<?=$val_cgpa;?>" oninput="validate(this)" <?=$attr_disable_api;?> maxlength="4">
                        </div>
                    </div>
                </div>

                <?php $rsInstitusi = $conn->query("SELECT * FROM $schema1.`ref_institusi` WHERE `JENIS_INSTITUSI` IN (1,2) AND `SAH_YT`='Y' ORDER BY `JENIS_INSTITUSI`, `DISKRIPSI` ASC "); ?>
                <div class="form-group">
                    <div class="row">
                        <label class="col-sm-4 control-label"><b>Institusi <font color="#FF0000">*</font><div style="float:right">:</div></b></label>
                        <div class="col-sm-8">
                            <select name="inst_keluar_sijil1" id="inst_keluar_sijil1" class="form-control select2 inst_keluar_sijil1 <?=$class_api_field;?>" style="width: 100%;" onchange="get_pengkhususan(this.value)" <?=$attr_disable_api;?>>
                                <option value="">Sila pilih institusi</option>
                                <?php while(!$rsInstitusi->EOF){ ?>
                                <option value="<?=$rsInstitusi->fields['KOD'];?>" <?php if($val_inst==$rsInstitusi->fields['KOD']){ print 'selected'; }?>><?php print $rsInstitusi->fields['DISKRIPSI'];?></option>  
                                <?php $rsInstitusi->movenext(); } ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <label class="col-sm-4 control-label"><b>Institusi Francais Luar Negara <font color="#FF0000">*</font><div style="float:right">:</div></b></label>
                        <div class="col-sm-8">
                            <?php $rad_disable = ($attr_disable_api != '') ? 'disabled' : ''; ?>
                            <input type="radio" name="inst_francais1" class="<?=$class_api_field;?>" value="Y" <?php if($val_francais=='Y'){ print 'checked'; }?> <?=$rad_disable;?>> YA &nbsp; 
                            <input type="radio" name="inst_francais1" class="<?=$class_api_field;?>" value="T" <?php if($val_francais=='T'){ print 'checked'; }?> <?=$rad_disable;?>> TIDAK 
                        </div>
                    </div>
                </div>

                <?php 
                    $rsKhusus = null;
                    if(!empty($val_inst)){
                         $rsKhusus = $conn->query("SELECT * FROM $schema1.ref_pengkhususan WHERE kod=".tosql($val_sijil));
                    }
                ?>
                <div class="form-group">
                    <div class="row">
                        <label class="col-sm-4 control-label"><b>Nama Sijil <font color="#FF0000">*</font><div style="float:right">:</div></b></label>
                        <div class="col-sm-8">
                            <select name="pengkhususan1" id="pengkhususan1" class="form-control select2 pengkhususan1 <?=$class_api_field;?>" style="width: 100%;" <?=$attr_disable_api;?>>
                                <option value="">Sila pilih</option>
                                <?php if($rsKhusus && !$rsKhusus->EOF) { ?>
                                    <option value="<?=$rsKhusus->fields['kod'];?>" selected><?=$rsKhusus->fields['DISKRIPSI'];?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>

                <?php $query ="SELECT KOD, DISKRIPSI FROM $schema1.ref_major WHERE STATUS=0 ORDER BY DISKRIPSI ASC"; $qrymajor = $conn->query($query); ?>
                <div class="form-group" id="major1" name="major1">
                    <div class="row">
                        <label for="major1" class="col-sm-4 control-label"><b>Major <div style="float:right">:</div></b></label>
                        <div class="col-sm-8">
                            <select name="major1" id="major1" class="form-control select2" style="width: 100%;">
								<option value="">Sila pilih </option>
								<?php while(!$qrymajor->EOF){ $code = $qrymajor->fields['kod']; ?>    
								<option value="<?=$code;?>" <?php if($rsUniv->fields['major']==$code){ print 'selected'; }?>><?php print $qrymajor->fields['DISKRIPSI'];?></option>
								<?php $qrymajor->movenext(); } ?>
                            </select>
                        </div>
                    </div>
                </div>

                <?php $query ="SELECT KOD, DISKRIPSI FROM $schema1.ref_minor WHERE STATUS=0 ORDER BY DISKRIPSI ASC"; 
				$qryminor = $conn->query($query); ?>
                <div class="form-group" id="minor1" name="minor1">
                    <div class="row">
                        <label for="minor1" class="col-sm-4 control-label"><b>Minor <div style="float:right">:</div></b></label>
                        <div class="col-sm-8">
                            <select name="minor1" id="minor1" class="form-control select2" style="width: 100%;">
							<option value="">Sila pilih </option>
        					<?php while(!$qryminor->EOF){ $code = $qryminor->fields['kod']; ?>    
            				<option value="<?=$code;?>" <?php if($rsUniv->fields['minor']==$code){ print 'selected'; }?>><?php print $qryminor->fields['DISKRIPSI'];?></option>
        					<?php $qryminor->movenext(); } ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <label class="col-sm-12 control-label"><b>Keputusan Penguasaan Bahasa Inggeris</b></label>
                    </div>
                </div>

			<div class="form-group">
				<div class="row">
					<label for="nama" class="col-sm-4 control-label"><b>Jenis Peperiksaan</b><div style="float:right">:</div></label>

					<?php
					//$conn->debug=true;
    				$sql3 = "SELECT * FROM $schema1.`ref_jenis_peperiksaanBI` WHERE `status`=0 AND `is_deleted`=0";
    				$rsJP = $conn->query($sql3);
        			?>
					<div class="col-sm-8">
						<select name="jenisMuetCefr1" id="jenisMuetCefr1" class="form-control" onchange="get_keputusan(this.value)">
							<option value="">Sila pilih </option>
        					<?php while(!$rsJP->EOF){ $code = $rsJP->fields['kod']; ?>    
            				<option value="<?=$code;?>" <?php if($rsUniv->fields['muet']==$code){ print 'selected'; }?>><?php print $rsJP->fields['diskripsi'];?></option>
        					<?php $rsJP->movenext(); } ?>
						</select>
					</div>
				</div>
			</div>

                <div class="form-group">
                    <div class="row">
                        <label class="col-sm-4 control-label"><b>Tahun</b><div style="float:right">:</div></label>
                        <div class="col-sm-4">
                            <?php $d = date("Y");?>
                            <select name="tahunMuetCefr1" id="tahunMuetCefr1" class="form-control" onchange="get_keputusan(this.value)">
                                <option value="">Sila pilih tahun</option>
                                <?php for($i=$d; $i>='1999'; $i--){ ?>
                                <option value="<?=$i;?>" <?php if($val_muet_year==$i){ print 'selected'; }?>><?=$i;?></option>
                                <?php } ?>                              
                            </select>
                        </div>
                    </div>
                </div>

			<div class="form-group">
				<div class="row">

					<label for="nama" class="col-sm-4 control-label"><b>Keputusan BAND/TAHAP CEFR</b><div style="float:right">:</div></label>
					<?php
					$sql3 = "SELECT * FROM $schema1.padanan_jenisPeperiksaan_keputusan WHERE kod_jenis_peperiksaan=".tosql($rsUniv->fields['muet']);
    				$rsJK = $conn->query($sql3);
        			?>

					<div class="col-sm-7">
						<select name="keputusanMuetCefr1" id="keputusanMuetCefr1" class="form-control">
							<option value="">Sila pilih Keputusan MUET/CEFR</option>
							<?php while(!$rsJK->EOF){ 
								$code = $rsJK->fields['kod']; 
								$kep = '';
								if(!empty($rsJK->fields['band'])){ $kep = $rsJK->fields['band']; }
								if(!empty($rsJK->fields['gred'])){ 
									if(!empty($kep)){ $kep .= " / "; }
									$kep .= $rsJK->fields['gred']; 
								}
								if(!empty($rsJK->fields['cefr'])){ 
									if(!empty($kep)){ $kep .= " / "; } 
									$kep .= $rsJK->fields['cefr']; 
								}
							?>    
            				<option value="<?=$code;?>" <?php if($rsUniv->fields['muet_gred']==$code){ print 'selected'; }?>><?php print $kep;?></option>
        					<?php $rsJK->movenext(); } ?>
						</select>
					</div>

					
				</div>
			</div>

                <?php $rsBiasiswa = $conn->query("SELECT * FROM $schema1.`ref_biasiswa` WHERE 1 ORDER BY `kod_biasiswa` ASC "); ?>
                <div class="form-group">
                    <div class="row">
                        <label class="col-sm-4 control-label"><b>Biasiswa Pengajian  <div style="float:right">:</div></b></label>
                        <div class="col-sm-8">
                            <select name="biasiswa1" id="biasiswa" class="form-control">
                                <option value="">Sila pilih biasiswa</option>
                                <?php while(!$rsBiasiswa->EOF){ ?>
                                <option value="<?=$rsBiasiswa->fields['kod_biasiswa'];?>" <?php if($val_biasiswa==$rsBiasiswa->fields['kod_biasiswa']){ print 'selected'; }?>><?php print $rsBiasiswa->fields['biasiswa'];?></option> 
                                <?php $rsBiasiswa->movenext(); } ?>
                            </select>
                        </div>
                    </div>
                </div>

            </div> <div id="upload_section_1" style="<?=$style_upload;?>">
                <?php
                $rsSijil = $conn->query("SELECT * FROM $schema2.`calon_sijil` WHERE `jenis_sijil`='UNIV1A' AND `id_pemohon`=".tosql($uid));
                if(empty($rsSijil->fields['sijil_nama'])){ $sijil_pic1 ="/var/www/html/myspp/upload_doc/sijil_diploma.jpg"; }
                else { $sijil_pic1 = "/var/www/upload/".$uid."/".$rsSijil->fields['sijil_nama']; }
                if (file_exists($sijil_pic1)){
                        $b64image = base64_encode(file_get_contents($sijil_pic1));
                        $sijil1 = "data:image/png;base64,$b64image";
                }
                ?>
                <div class="col-sm-4" align="center" style="border: 2px solid black; padding: 10px; border-radius: 25px; margin-top:20px;">
                    <h6><b>Sijil Pengajian Tinggi</b></h6>
                    <img src="<?=$sijil1;?>" width="100%" height="350">
                    <?php print $rsSijil->fields['sijil_nama'];?>
                    <input type="file" name="file1"  id="file1" class="form-control" onchange="do_input('sijil1')" value="">
                    <small style="color: red;">Hanya menerima format png,jpg,jpeg @ gif dan tidak melebihi 300kb</small>
                </div>
                
			</div>

        </div> 
    </div> 
</div> 
        
<script type="text/javascript">
$(document).ready(function () {
    // 1. Setup Datepicker
    $('.enableFuturedate').datepicker({ format: 'dd/mm/yyyy' });

    // 2. Jalankan logic paparan Major/Minor berdasarkan data sedia ada
    hidemm(); 

    // 3. Semak Integrasi
    check_univ_integration_1();
});

// Fungsi Kawalan Paparan Major/Minor
function hidemm(){
    var peringkat1 = $('#peringkat1').val();

    // Kod '3' = Ijazah Sarjana Muda, '4' = Sarjana (Contoh)
    // Pastikan kod ini tally dengan ref_peringkat_kelulusan anda
    if(peringkat1 == '3' || peringkat1 == '4'){
        $('#major1').show();
        $('#minor1').show();
    } else {
        // HANYA sembunyi, JANGAN reset value di sini (sebab function ni jalan masa page load juga)
        $('#major1').hide();
        $('#minor1').hide();
        
        // Jika anda mahu reset nilai apabila user MANUAL tukar peringkat, buat di function get_univ
    }
}

// Fungsi Panggil API (Client-side)
function check_univ_integration_1() {
    var status = $('#status_data_1').val();
    
    // Hanya tarik jika data tiada
    if (status == 'false') {
        var no_ic = $('#sess_uic').val(); // Get IC from session
        
        swal({ 
            title: '', 
            text: '', 
            showConfirmButton: false, 
            allowOutsideClick: false, 
            html: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><p>Mencari data universiti...</p>' 
        });

        // Call client-side API function
        fetchAndMapUniversityData(no_ic).then(function(result) {
            swal.close();
            
            if (result.status === 'OK' && result.data && result.data.length > 0) {
                var d = result.data[0]; 
                fillAndLockFields(d);
            } else {
                // Silently fail - user can manually enter data
                console.warn('API fetch failed:', result.msg);
            }
        }).catch(function(error) {
            swal.close();
            console.error('Error fetching university data:', error);
        });
    }
}

function fillAndLockFields(d) {
    $('#is_api_data_1').val('1'); // Set flag API
    $('#upload_section_1').hide(); // Hide upload

    // --- FILL & DISABLE FIELDS ---
    $('#tahun1').val(d.tahun).prop('disabled', true).addClass('api-locked').css('background-color', '#e9ecef');
    $('#tkh_senate').val(d.tkh_senate).prop('disabled', true).addClass('api-locked').css('background-color', '#e9ecef');
    $('#peringkat1').val(d.peringkat).prop('disabled', true).addClass('api-locked').css('background-color', '#e9ecef');
    $('#cgpa1').val(d.cgpa).prop('disabled', true).addClass('api-locked').css('background-color', '#e9ecef');
    
    // Institusi
    $('#inst_keluar_sijil1').removeAttr('onchange'); 
    $('#inst_keluar_sijil1').val(d.inst_kod).trigger('change').prop('disabled', true).addClass('api-locked').css('background-color', '#e9ecef');
    
    // Nama Sijil
    var kodSijil = d.khusus_kod;
    var namaSijil = d.khusus_nama; 
    if (kodSijil) {
        if ($('#pengkhususan1').find("option[value='" + kodSijil + "']").length) {
            $('#pengkhususan1').val(kodSijil).trigger('change');
        } else {
            var newOption = new Option(namaSijil, kodSijil, true, true);
            $('#pengkhususan1').append(newOption).trigger('change');
        }
    }
    $('#pengkhususan1').prop('disabled', true).addClass('api-locked').css('background-color', '#e9ecef');

    // Francais
    $('input[name="inst_francais1"][value="T"]').prop('checked', true);
    $('input[name="inst_francais1"]').prop('disabled', true).addClass('api-locked');

    // --- PEMBETULAN UTAMA: TRIGGER HIDEMM ---
    // Panggil hidemm() supaya jika Peringkat = 3, field Major/Minor akan MUNCUL
    hidemm();
}

function save_univ(){
    var isApi = $('#is_api_data_1').val();
    var disabledFields = $('#univ_form_wrapper_1 :input:disabled');
    disabledFields.prop('disabled', false); // Enable sekejap untuk submit

    var msg = '';
    // (Validasi Manual di sini...)
    // Contoh ringkas:
    if(isApi == '0' && $('#tahun1').val() == '') msg += '\n- Sila pilih tahun.';

    if(msg != ''){
        alert_msg_html(msg);
        if(isApi == '1') disabledFields.prop('disabled', true); 
    } else {
        var fd = new FormData();
        
        if(isApi == '0') {
            // Append Files (Manual Only)
            if($('#file1')[0].files[0]) fd.append('file1', $('#file1')[0].files[0]);
            // ... file2, file3 ...
        } else {
             fd.append('inst_francais1', 'T');
        }

        var other_data = $('form').serializeArray();
        $.each(other_data,function(key,input){ fd.append(input.name,input.value); });

        $.ajax({
            url:'akademik/sql_akademik.php?frm=UNIV&pro=SAVE1',
            type:'POST',
            data: fd,
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function() { 
				},
            success: function(data){
                if(isApi == '1') disabledFields.prop('disabled', true);
                if(data.trim()=='OK'){
                    swal({ title: 'Berjaya', text: 'Maklumat berjaya disimpan', type: 'success'}).then(function(){ window.location.reload(); });
                } else {
                    swal('Ralat', 'Gagal menyimpan data.', 'error');
                }
            }
        });
    }
}


function get_keputusan(tahun){
	var jenisMuetCefr1 = $('#jenisMuetCefr1').val();
	var sel="#keputusanMuetCefr1";
	$.ajax({
		url: '../include/get_keputusan.php?tahun='+tahun+'&jenisMuetCefr1='+jenisMuetCefr1 ,
		type: 'post',
		data: {jenisMuetCefr1:jenisMuetCefr1},
		dataType: 'json',
		success:function(response){
			var len = response.length;
			$(sel).empty();
			$('#keputusanMuetCefr1').empty();
			if(len > 0){
			for( var i = 0; i<len; i++){
				var kod = response[i]['kod'];
				var keputusan = response[i]['keputusan'];
				$(sel).append("<option value='"+kod+"'>"+keputusan+"</option>");
			}	
			} else {
				$(sel).append("<option value=''>Sila pilih Keputusan MUET/CEFR</option>");

			}
		}
	});
}
</script>