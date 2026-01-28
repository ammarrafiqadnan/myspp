<?php 
include_once 'akademik/sql_akademik.php';

// 1. QUERY LOCAL DB (KEPUTUSAN 3)
$rsUniv = $conn->query("SELECT * FROM $schema2.`calon_ipt` WHERE `bil_keputusan`='3' AND `id_pemohon`=".tosql($uid));

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

// Field Manual (Major, Minor, MUET, Biasiswa)
$val_major      = $rsUniv->fields['major'];
$val_minor      = $rsUniv->fields['minor'];
$val_muet_type  = $rsUniv->fields['muet'];
$val_muet_year  = $rsUniv->fields['muet_tahun'];
$val_muet_res   = $rsUniv->fields['muet_gred'];
$val_biasiswa   = $rsUniv->fields['biasiswa'];

// ATTRIBUTE KHAS: Hanya kunci field API jika Integrasi = Y
$attr_disable_api = ($db_is_integ == 'Y') ? 'disabled style="background-color: #e9ecef;"' : '';
$class_api_field  = ($db_is_integ == 'Y') ? 'api-locked' : ''; 

// Upload section hide jika integrasi
$style_upload = ($db_is_integ == 'Y') ? 'display:none;' : '';
$val_flag_api = ($db_is_integ == 'Y') ? '1' : '0';
?>

<input type="hidden" id="status_data_3" value="<?=$has_local_data;?>">
<input type="hidden" id="is_api_data_3" name="is_api_data_3" value="<?=$val_flag_api;?>">

<div id="univ_form_wrapper_3"> 
    <div class="form-group">
        <div class="row">
            <div class="col-sm-12"><br>
                
                <div class="form-group">
                    <div class="row">
                        <label class="col-sm-4 control-label"><b>Tahun Graduasi <font color="#FF0000">*</font><div style="float:right">:</div></b></label>
                        <div class="col-sm-4">
                            <select class="form-control <?=$class_api_field;?>" name="tahun1" id="tahun3" <?=$attr_disable_api;?>>
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
                            <input type="text" id="tkh_senate3" name="tkh_senate" size="15" maxlength="10" value="<?=$val_senat;?>"
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
                            <select name="peringkat1" id="peringkat3" class="form-control <?=$class_api_field;?>" onchange="get_univ_3(this.value)" <?=$attr_disable_api;?>>
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
                            <input type="text" name="cgpa1" id="cgpa3" class="form-control <?=$class_api_field;?>" value="<?=$val_cgpa;?>" oninput="validate(this)" <?=$attr_disable_api;?>>
                        </div>
                    </div>
                </div>

                <?php $rsInstitusi = $conn->query("SELECT * FROM $schema1.`ref_institusi` WHERE `JENIS_INSTITUSI` IN (1,2) AND `SAH_YT`='Y' ORDER BY `JENIS_INSTITUSI`, `DISKRIPSI` ASC "); ?>
                <div class="form-group">
                    <div class="row">
                        <label class="col-sm-4 control-label"><b>Institusi <font color="#FF0000">*</font><div style="float:right">:</div></b></label>
                        <div class="col-sm-8">
                            <select name="inst_keluar_sijil1" id="inst_keluar_sijil3" class="form-control select2 inst_keluar_sijil1 <?=$class_api_field;?>" style="width: 100%;" onchange="get_pengkhususan_3(this.value)" <?=$attr_disable_api;?>>
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
                            <select name="pengkhususan1" id="pengkhususan3" class="form-control select2 pengkhususan1 <?=$class_api_field;?>" style="width: 100%;" <?=$attr_disable_api;?>>
                                <option value="">Sila pilih</option>
                                <?php if($rsKhusus && !$rsKhusus->EOF) { ?>
                                    <option value="<?=$rsKhusus->fields['kod'];?>" selected><?=$rsKhusus->fields['DISKRIPSI'];?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>

                <?php $query ="SELECT KOD, DISKRIPSI FROM $schema1.ref_major WHERE STATUS=0 ORDER BY DISKRIPSI ASC"; $qrymajor = $conn->query($query); ?>
                <div class="form-group" id="selmajor1" name="selmajor1">
                    <div class="row">
                        <label for="major1" class="col-sm-4 control-label"><b>Major <div style="float:right">:</div></b></label>
                        <div class="col-sm-8">
                            <select name="major1" id="major1" class="form-control select2" style="width: 100%;">
                                <option value="" selected>Sila Pilih</option>
                                <?php while(!$qrymajor->EOF){ ?>
                                <option value="<?=$qrymajor->fields['KOD'];?>" <?php if($val_major==$qrymajor->fields['KOD']){ print 'selected'; }?>>
                                <?php print $qrymajor->fields['DISKRIPSI']; ?>
                                </option>
                                <?php $qrymajor->movenext(); } ?>
                            </select>
                        </div>
                    </div>
                </div>

                <?php $query ="SELECT KOD, DISKRIPSI FROM $schema1.ref_minor WHERE STATUS=0 ORDER BY DISKRIPSI ASC"; $qryminor = $conn->query($query); ?>
                <div class="form-group" id="selminor1" name="selminor1">
                    <div class="row">
                        <label for="minor1" class="col-sm-4 control-label"><b>Minor <div style="float:right">:</div></b></label>
                        <div class="col-sm-8">
                            <select name="minor1" id="minor1" class="form-control select2" style="width: 100%;">
                                <option value="">Sila pilih </option>
                                <?php while(!$qryminor->EOF){ ?>
                                <option value="<?=$qryminor->fields['KOD'];?>" <?php if($val_minor==$qryminor->fields['KOD']){ print 'selected'; }?>>
                                <?php print $qryminor->fields['DISKRIPSI'];?></option>  
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
                        <label class="col-sm-4 control-label"><b>Jenis Peperiksaan</b><div style="float:right">:</div></label>
                        <?php $rsJP = $conn->query("SELECT * FROM $schema1.`ref_jenis_peperiksaanBI` WHERE `status`=0 AND `is_deleted`=0"); ?>
                        <div class="col-sm-8">
                            <select name="jenisMuetCefr1" id="jenisMuetCefr1" class="form-control">
                                <option value="">Sila pilih </option>
                                <?php while(!$rsJP->EOF){ $code = $rsJP->fields['kod']; ?>    
                                <option value="<?=$code;?>" <?php if($val_muet_type==$code){ print 'selected'; }?>><?php print $rsJP->fields['diskripsi'];?></option>
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
                        <label class="col-sm-4 control-label"><b>Keputusan BAND/TAHAP CEFR</b><div style="float:right">:</div></label>
                        <?php
                        $rsJK = null;
                        if(!empty($val_muet_type)){
                             $sql3 = "SELECT * FROM $schema1.padanan_jenisPeperiksaan_keputusan WHERE kod_jenis_peperiksaan=".tosql($val_muet_type);
                             $rsJK = $conn->query($sql3);
                        }
                        ?>
                        <div class="col-sm-7">
                            <select name="keputusanMuetCefr1" id="keputusanMuetCefr1" class="form-control">
                                <option value="">Sila pilih Keputusan MUET/CEFR</option>
                                <?php if($rsJK) { while(!$rsJK->EOF){ 
                                    $code = $rsJK->fields['kod']; 
                                    $kep = $rsJK->fields['band'] . ' / ' . $rsJK->fields['gred'];
                                ?>    
                                <option value="<?=$code;?>" <?php if($val_muet_res==$code){ print 'selected'; }?>><?php print $kep;?></option>
                                <?php $rsJK->movenext(); } } ?>
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

            </div> <div id="upload_section_3" style="<?=$style_upload;?>">
                <?php
                // CHECK FILE UNIV3A
                $rsSijil = $conn->query("SELECT * FROM $schema2.`calon_sijil` WHERE `jenis_sijil`='UNIV3A' AND `id_pemohon`=".tosql($uid));
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
                    <input type="file" name="file1"  id="file3_1" class="form-control" onchange="do_input('sijil1')" value="">
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

    // 2. Logic Hidemm (Major/Minor)
    if(typeof hidemm == 'function') { hidemm(); }

    // 3. Semak Integrasi Tab 3
    check_univ_integration_3();
});

function get_pengkhususan(kod){ 
    // Logic copy paste get_pengkhususan tapi target ID suffix 2
    var peringkat1 = $('#peringkat2').val();
    var sel="#pengkhususan2";
    $.ajax({
        url: '../include/get_pengkhususan.php?kod='+kod+'&peringkat1='+peringkat1,
        type: 'post',
        data: {kod:kod},
        dataType: 'json',
        success:function(response){
            var len = response.length;
            $(sel).empty();
            for( var i = 0; i<len; i++){
                var id = response[i]['id'];
                var name = response[i]['name'];
                $(sel).append("<option value='"+id+"'>"+name+"</option>");
            }
        }
    });
} 

// Fungsi Panggil API Tab 3
function check_univ_integration_3() {
    var status = $('#status_data_3').val();
    
    // Hanya tarik jika data tiada
    if (status == 'false') {
        if (typeof fetchAndMapUniversityData !== 'function') {
            console.warn('kpt-api-client.js not loaded.');
            return;
        }
        
        var no_ic = ($('#sess_uic').val && $('#sess_uic').val()) || '<?= $_SESSION['SESS_UIC']; ?>';
        if (!no_ic) {
            console.warn('No IC found for API lookup.');
            return;
        }
        
        swal({ 
            title: '', 
            text: '', 
            showConfirmButton: false, 
            allowOutsideClick: false, 
            html: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><p>Mencari data universiti (Keputusan 3)...</p>' 
        });

        // Call client-side API function
        fetchAndMapUniversityData(no_ic).then(function(result) {
            swal.close();
            if (result.status === 'OK' && result.data && result.data.length > 2) {
                var d = result.data[2]; 
                fillAndLockFields_3(d);
            } else {
                console.warn('API fetch failed (Keputusan 3):', result.msg);
            }
        }).catch(function(error) {
            swal.close();
            console.error('Error fetching university data (Keputusan 3):', error);
        });
    }
}

function fillAndLockFields_3(d) {
    // 1. Set Flag API
    $('#is_api_data_3').val('1');

    // 2. Hide Upload Section
    $('#upload_section_3').hide();

    // 3. FILL DATA & DISABLE (ID SUFFIX 3)

    // --- TAHUN ---
    $('#tahun3').val(d.tahun).prop('disabled', true).addClass('api-locked').css('background-color', '#e9ecef');
    
    // --- TARIKH SENAT ---
    $('#tkh_senate3').val(d.tkh_senate).prop('disabled', true).addClass('api-locked').css('background-color', '#e9ecef');
    
    // --- PERINGKAT ---
    $('#peringkat3').val(d.peringkat).prop('disabled', true).addClass('api-locked').css('background-color', '#e9ecef');
    
    // --- CGPA ---
    $('#cgpa3').val(d.cgpa).prop('disabled', true).addClass('api-locked').css('background-color', '#e9ecef');
    
    // --- INSTITUSI ---
    $('#inst_keluar_sijil3').removeAttr('onchange'); 
    $('#inst_keluar_sijil3').val(d.inst_kod).trigger('change').prop('disabled', true).addClass('api-locked').css('background-color', '#e9ecef');
    
    // --- NAMA SIJIL ---
    var kodSijil = d.khusus_kod;
    var namaSijil = d.khusus_nama; 

    if (kodSijil) {
        if ($('#pengkhususan3').find("option[value='" + kodSijil + "']").length) {
            $('#pengkhususan3').val(kodSijil).trigger('change');
        } else {
            var newOption = new Option(namaSijil, kodSijil, true, true);
            $('#pengkhususan3').append(newOption).trigger('change');
        }
    }
    $('#pengkhususan3').prop('disabled', true).addClass('api-locked').css('background-color', '#e9ecef');

    // --- FRANCAIS ---
    $('input[name="inst_francais1"][value="T"]').prop('checked', true);
    $('input[name="inst_francais1"]').prop('disabled', true).addClass('api-locked');

    // --- TRIGGER HIDEMM (Untuk tunjuk Major/Minor jika perlu) ---
    if(typeof hidemm == 'function') { hidemm(); }
}

function save_univ(){
    var isApi = $('#is_api_data_3').val();
    
    // Enable field sekejap
    var disabledFields = $('#univ_form_wrapper_3 :input:disabled');
    disabledFields.prop('disabled', false);

    // --- VALIDATION MANUAL ---
    var msg = '';
    // if(isApi == '0' && $('#tahun3').val() == '') msg += '\n- Sila pilih tahun graduasi.';

    if(msg != ''){
        alert_msg_html(msg);
        if(isApi == '1') disabledFields.prop('disabled', true); 
    } else {
        var fd = new FormData();
        
        // Manual files
        if(isApi == '0') {
            if($('#file3_1')[0].files[0]) fd.append('file1', $('#file3_1')[0].files[0]);
            // ...
        } else {
             fd.append('inst_francais1', 'T');
        }

        var other_data = $('form').serializeArray();
        $.each(other_data,function(key,input){ fd.append(input.name,input.value); });

        $.ajax({
            url:'akademik/sql_akademik.php?frm=UNIV&pro=SAVE3', // SAVE 3
            type:'POST',
            data: fd,
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function() { swal({ title: "Sedang Simpan...", showConfirmButton: false }); },
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

// Function Helper untuk Tab 3
function get_univ_3(kod){
	var kods=$('#inst_keluar_sijil1').val();
	var sel="#inst_keluar_sijil1";
	$.ajax({
		url: '../include/get_universiti.php?kod='+kod,
		type: 'post',
		data: {kod:kod},
		dataType: 'json',
		success:function(data){
			var len = data.length;
			console.log(len);
			$(sel).empty();
			$('#pengkhususan1').empty();
			for( var i = 0; i<len; i++){
				var id = data[i]['id'];
				var name = data[i]['name'];
				$(sel).append("<option value='"+id+"'>"+name+"</option>");
			}
			$('#pengkhususan1').append("<option value=''>Sila pilih</option>");
		}
	});

	get_pengkhususan(kods);
	hidemm();

}
function get_pengkhususan_3(kod){ 
    var peringkat1 = $('#peringkat3').val();
    var sel="#pengkhususan3";
    $.ajax({
        url: '../include/get_pengkhususan.php?kod='+kod+'&peringkat1='+peringkat1,
        type: 'post',
        data: {kod:kod},
        dataType: 'json',
        success:function(response){
            var len = response.length;
            $(sel).empty();
            for( var i = 0; i<len; i++){
                var id = response[i]['id'];
                var name = response[i]['name'];
                $(sel).append("<option value='"+id+"'>"+name+"</option>");
            }
        }
    });
} 
function hidemm(){
    var peringkat1 = $('#peringkat1').val();

    // Kod '3' = Ijazah Sarjana Muda, '4' = Sarjana (Contoh)
    // Pastikan kod ini tally dengan ref_peringkat_kelulusan anda
    if(peringkat1 == '3' || peringkat1 == '4'){
        $('#selmajor1').show();
        $('#selminor1').show();
    } else {
        // HANYA sembunyi, JANGAN reset value di sini (sebab function ni jalan masa page load juga)
        $('#selmajor1').hide();
        $('#selminor1').hide();
        
        // Jika anda mahu reset nilai apabila user MANUAL tukar peringkat, buat di function get_univ
    }
}
</script>