<?php //include '../connection/common.php'; ?>
<script language="javascript">
function do_dummyhapus(){
   swal({
        title: 'Amaran',
        text: 'Sila hapus maklumat peperiksaan kedua terlebih dahulu.',
        type: 'warning',
        confirmButtonClass: "btn-warning",
        confirmButtonText: "Ok",
        showConfirmButton: true,
    });
}

var isSvmIntegrasi = '<?=$rsData->fields["is_integrasi"] == "Y" ? "1" : "0"; ?>'; 
// (Nota: Pastikan PHP di atas dah query is_integrasi. Jika belum, set default '0')

function save_svm(val){
    // Enable field sementara supaya value masuk dalam serialize
    $('#svm_sijil_1, #gred_bm_1, #spm_tahun_1, #svm_pngk, #svm_pngkv, #svm_angka_giliran, #spm_jenis_sijil_1').prop('disabled', false).prop('readonly', false);

    var spm_jenis_sijil_1 = $('#spm_jenis_sijil_1').val();
    var svm_sijil_1 = $('#svm_sijil_1').val();
    var spm_tahun_1 = $('#spm_tahun_1').val();
    var gred_bm_1 = $('#gred_bm_1').val();
    var svm_pngk = $('#svm_pngk').val();
    var svm_pngkv = $('#svm_pngkv').val();
    var msg = '';

    // Validation (Skip validation ketat jika integrasi? Atau validate juga utk safety)
    if(spm_jenis_sijil_1 == '' || spm_jenis_sijil_1 == '0'){
        msg += '\n- Sila pilih jenis sijil.';
        $("#spm_jenis_sijil_1").css("border-color","#f00");
    } 
    if(spm_tahun_1 == '' || spm_tahun_1 == '0'){
        msg += '\n- Sila pilih tahun peperiksaan.';
        $("#spm_tahun_1").css("border-color","#f00");
    }
    // ... sambung validation lain ...

    if(msg.trim() !=''){ 
        alert_msg_html(msg);
        // Disable balik jika integrasi
        if(isSvmIntegrasi == '1') lockSvmFields();
    } else { 
        var fd = new FormData();
        
        // Append File (Hanya jika manual / bukan integrasi)
        if(isSvmIntegrasi == '0') {
             if($('#file_pmr')[0].files[0]) fd.append('file_pmr', $('#file_pmr')[0].files[0]);
        }

        // Append Flag Integrasi (PENTING)
        fd.append('is_integrasi_svm', isSvmIntegrasi);

        var other_data = $('form').serializeArray();
        $.each(other_data,function(key,input){
             fd.append(input.name,input.value);
        });

        $.ajax({
            url:'akademik/sql_akademik.php?frm=SVM&pro=SAVE',
            type:'POST',
            data:  fd,
            contentType: false,
            cache: false,
            processData:false,
            beforeSend: function () {
                swal({ title: "Sedang Simpan...", showConfirmButton: false });
            },
            success: function(data){
                // Disable balik jika integrasi (untuk visual)
                if(isSvmIntegrasi == '1') lockSvmFields();

                if(data.trim()=='OK'){
                    swal({
                      title: 'Berjaya',
                      text: 'Maklumat telah berjaya dikemaskini',
                      type: 'success',
                      confirmButtonClass: "btn-success",
                      confirmButtonText: "Ok"
                    }).then(function () {
                        window.location.reload();
                    });
                } else {
                    swal({
                      title: 'Amaran',
                      text: 'Ralat sistem.',
                      type: 'error'
                    });
                }
            }
        });
    }
}

// Fungsi Helper untuk Lock
function lockSvmFields() {
    $('#svm_sijil_1, #gred_bm_1, #spm_tahun_1, #spm_jenis_sijil_1').prop('disabled', true);
    $('#svm_pngk, #svm_pngkv, #svm_angka_giliran').prop('readonly', true);
}

var validate1 = function(e) {
 	var t = e.value;
  	if(t<=4){ 
  		e.value = (t.indexOf(".") >= 0) ? (t.substr(0, t.indexOf(".")) + t.substr(t.indexOf("."), 3)) : t;
	} else {
		document.myspp.svm_pngk.value='';
		//alert(t);
	}
}

var validate2 = function(e) {
 	var t = e.value;
  	if(t<=4){ 
  		e.value = (t.indexOf(".") >= 0) ? (t.substr(0, t.indexOf(".")) + t.substr(t.indexOf("."), 3)) : t;
	} else {
		document.myspp.svm_pngkv.value='';
		//alert(t);
	}
}

function do_input() { 

	var fileUpload = $("#file_pmr")[0];
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
<?php
//print_r($data);
//$conn->debug=true;
$uid = $data['id_pemohon'];
// $tahun = $data['svm_tahun_1'];
//$s_sijil = $data['spm_jenis_sijil_1'];

if($actions==1){ 
	$rsSijil = $conn->query("SELECT * FROM $schema2.`calon_sijil` WHERE `jenis_sijil`='SVM1' AND `id_pemohon`=".tosql($uid));
} else if($actions==2){
	//print "..".$s_sijil;
	//$s_sijil=isset($_REQUEST["spm_jenis_sijil_1"])?$_REQUEST["spm_jenis_sijil_1"]:"";
	$rsSijil = $conn->query("SELECT * FROM $schema2.`calon_sijil` WHERE `jenis_sijil`='SVM2' AND `id_pemohon`=".tosql($uid));
}
//if(empty($rsSijil->fields['sijil_nama'])){ $sijil="../upload_doc/svm.jpg"; }
//else { $sijil = "/upload/".$uid."/".$rsSijil->fields['sijil_nama']; }

if(empty($rsSijil->fields['sijil_nama'])){ $sijil_pic ="/var/www/myspp/upload_doc/svm.jpg"; }
else { $sijil_pic = "/var/www/upload/".$uid."/".$rsSijil->fields['sijil_nama']; }
//print $sijil;

if (file_exists($sijil_pic)){
     $b64image = base64_encode(file_get_contents($sijil_pic));
     $sijil = "data:image/png;base64,$b64image";
     //echo "<img src = 'data:image/png;base64,$b64image'>";
}


// $rssijil = $conn->query("SELECT * FROM $schema1.`ref_sijil` WHERE `TKT`='5' AND kod=5 AND is_aktif=0");
// if()
if($data['spm_jenis_sijil_1']==60 && !empty($data['spm_tahun_1'])){ $s = "SELECT * FROM $schema1.`ref_sijil` WHERE `TKT`='5' AND is_aktif=0 AND KOD=6"; }
else { $s = "SELECT * FROM $schema1.`ref_sijil` WHERE `TKT`='5' AND is_aktif=0"; }

$rssijil = $conn->query($s); // AND `DISKRIPSI`='SVM'
$rspangkat = $conn->query("SELECT * FROM $schema1.`ref_sijil_pangkat` WHERE `TKT`=5 ORDER BY `DISKRIPSI`");

// $rsSRP = $conn->query("SELECT * FROM $schema1.`ref_matapelajaran` WHERE `TKT`='5' AND `SAH_YT`='Y' AND `GAB_YT`='T' AND `kod` NOT IN ('103')
// 	ORDER BY `DISKRIPSI`");
$rsGred = $conn->query("SELECT * FROM $schema1.`ref_gred_matapelajaran` WHERE `TKT`='5' AND `GRED`>='A'
ORDER BY `SUSUNAN`");
$conn->debug=false;



//if(empty($s_sijil) && !empty($_SESSION['SESS_SPMSIJIL'])){ $s_sijil=$_SESSION['SESS_SPMSIJIL']; }
//if(empty($s_tahun) && !empty($_SESSION['SESS_SPMTAHUN'])){ $s_tahun=$_SESSION['SESS_SPMTAHUN']; }


?>

	<?php
	$rsData = $conn->query("SELECT * FROM $schema2.`calon_svm` WHERE `id_pemohon`=".tosql($uid) ." AND `tahun`=".tosql($s_tahun));
	?>
<hr>

<?php
$rsData = $conn->query("SELECT * FROM $schema2.`calon_svm` WHERE `id_pemohon`=".tosql($uid) ." AND `tahun`=".tosql($s_tahun));
// Tentukan keadaan awal data
$hasData = (!empty($rsData->fields['gred_bm'])) ? true : false;
$showStyle = ($hasData) ? 'display:block' : 'display:none';
?>

<div class="form-group">
    <div class="row">
        <div class="col-sm-8">
            <div class="form-group">
                <div class="row">
                    <label for="nama" class="col-sm-4 control-label"><b>Jenis Sijil <font color="#FF0000">*</font><div style="float:right">:</div></b></label>
                    <div class="col-sm-8">
                        <select class="form-control" id="spm_jenis_sijil_1" name="spm_jenis_sijil_1" onchange="set_spm('spm_jenis_sijil_1',this.value,'R')"
                        <?php if($hasData){ print 'disabled'; }?>>
                            <?php while(!$rssijil->EOF){ ?>
                            <option value="<?=$rssijil->fields['KOD'];?>" 
                            <?php if($rssijil->fields['KOD']==$s_sijil){ print 'selected';} ?>  
                            ><?=$rssijil->fields['DISKRIPSI'];?></option>
                            <?php $rssijil->movenext(); } ?>
                        </select>
                        <input type="hidden" name="spm_sijil_pilih" value="<?=$s_sijil;?>">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <label class="col-sm-4 control-label"><b>Angka Giliran <font color="#FF0000">*</font><div style="float:right">:</div></b></label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="svm_angka_giliran" name="svm_angka_giliran" placeholder="Angka Giliran" value="<?=$rsData->fields['angka_giliran'];?>" <?php if($hasData){ print 'readonly'; }?>>
                    </div>
                </div>
            </div>

            <div id="bahagian_keputusan_svm" style="<?=$showStyle;?>">
                <div class="form-group">
                    <div class="row">
                        <label class="col-sm-4 control-label"><b>Tahun Peperiksaan<div style="float:right">:</div></b></label>
                        <div class="col-sm-8">
                            <select name="spm_tahun_1" id="spm_tahun_1" class="form-control" <?php if($hasData){ print 'disabled'; }?>>
                                <option value="">Sila pilih tahun</option>
                                <?php for($t=date("Y");$t>=2012;$t--){
                                    print '<option value="'.$t.'"'; 
                                    if($s_tahun==$t){ print 'selected'; }
                                    print '>'.$t.'</option>';
                                } ?>
                            </select>
                        </div>
                    </div>
                </div>

                <?php $rsSVM = $conn->query("SELECT * FROM $schema1.`ref_kursus_svm` WHERE IS_DELETED=0"); ?>
                <div class="form-group">
                    <div class="row">
                        <label class="col-sm-4 control-label"><b>Nama Kursus <font color="#FF0000">*</font><div style="float:right">:</div></b></label>
                        <div class="col-sm-8">
                            <select class="form-control" name="svm_sijil_1" id="svm_sijil_1" <?php if($hasData){ print 'disabled'; }?>> 
                                <option value="">Sila pilih nama kursus</option>
                                <?php while(!$rsSVM->EOF){ ?>
                                <option value="<?=$rsSVM->fields['KOD'];?>" <?php if($rsData->fields['nama_sijil']==$rsSVM->fields['KOD']){ print 'selected';} ?>
                                ><?=$rsSVM->fields['DISKRIPSI'];?></option>
                                <?php $rsSVM->movenext(); } ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <label class="col-sm-4 control-label"><b>Bahasa Melayu SVM <font color="#FF0000">*</font><div style="float:right">:</div></b></label>
                        <div class="col-sm-8">
                            <select class="form-control" name="gred_bm_1" id="gred_bm_1" <?php if($hasData){ print 'disabled'; }?>>
                                <option value="">Sila pilih gred</option>
                                <?php $rsGred->movefirst();
                                while(!$rsGred->EOF){ ?>
                                <option value="<?=$rsGred->fields['GRED'];?>" <?php if($rsData->fields['gred_bm']==$rsGred->fields['GRED']){ print 'selected'; } ?>><?=$rsGred->fields['GRED'];?></option>  
                                <?php $rsGred->movenext(); } ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <table width="100%" class="table table-bordered">
                            <tr style="background-color:#eee">
                                <td width="75%"><b>Kompeten Semua Modul</b></td>
                                <td width="25%"><b>Mata Gred</b></td>
                            </tr>
                            <tr>
                                <td>PURATA NILAI GRED KUMULATIF AKADEMIK (PNGK) <font color="#FF0000">*</font></td>
                                <td><input type="text" name="svm_pngk" id="svm_pngk" class="form-control" oninput="validate1(this)" value="<?=number_format($rsData->fields['svm_pngk'],2);?>" <?php if($hasData){ print 'readonly'; }?>></td>
                            </tr>
                            <tr>
                                <td>PURATA NILAI GRED KUMULATIF VOKASIONAL (PNGKV) <font color="#FF0000">*</font></td>
                                <td><input type="text" name="svm_pngkv" id="svm_pngkv" class="form-control" oninput="validate2(this)" value="<?=number_format($rsData->fields['svm_pngkv'],2);?>" <?php if($hasData){ print 'readonly'; }?>></td>
                            </tr>
                        </table>
                        <i class="small text-danger">Pointer PNGK @ PNGKV hanya 4.00 dan kebawah sahaja.</i>
                    </div>
                </div>
            </div>
        </div>
<?php
// ... (Kod backend/query sedia ada) ...

$rsData = $conn->query("SELECT * FROM $schema2.`calon_svm` WHERE `id_pemohon`=".tosql($uid) ." AND `tahun`=".tosql($s_tahun));

// Check Data Wujud
$hasData = (!empty($rsData->fields['gred_bm'])) ? true : false;
$showStyle = ($hasData) ? 'display:block' : 'display:none';

// --- LOGIC INTEGRASI ---
// Check flag dari DB
$is_integ_y = ($rsData->fields['is_integrasi'] == 'Y');

// Style CSS untuk hide elemen jika integrasi = Y
$style_hide_integ = ($is_integ_y) ? 'display:none !important;' : ''; 
?>
<div class="col-sm-4" id="bahagian_upload" style="border: 2px solid black; padding: 10px; border-radius: 25px; <?=$showStyle;?>; <?=$style_hide_integ;?>" align="center">
    <h6><b>Sijil SPM/SPM(V)/SVM</b></h6>
    <img src="<?=$sijil;?>" width="100%" height="400">
    <input type="file" name="file_pmr" id="file_pmr" class="form-control" onchange="do_input()">
    <small style="color: red;">Maksimum 300kb (PNG, JPG, JPEG, GIF)</small>
</div>
    </div>
</div>

<div class="modal-footer" style="padding:0px;">
    <button type="button" id="btn_papar_svm" class="btn btn-success mt-sm mb-sm" onclick="jana_svm()" style="<?=$style_hide_integ;?>">
        <i class="fa fa-file"></i> Papar Keputusan
    </button>
    
    <button type="button" id="simpan" class="btn btn-primary mt-sm mb-sm" onclick="save_svm(1)" style="<?=($hasData)?'':'display:none;';?>">
        <i class="fa fa-save"></i> Simpan
    </button>

    <?php if($hasData){ ?>
        <label id="btn_hapus_svm" class="btn btn-danger" onclick="do_hapus('akademik/sql_akademik.php?frm=SVM&pro=DEL&tahun=<?=$s_tahun;?>&actions=<?=$actions;?>&id_pemohon=<?=$_SESSION['SESS_UID'];?>')" style="<?=$style_hide_integ;?>">Hapus</label>
    <?php } ?>
</div>

<script>
// Pengekalan logik set_spm untuk penukaran borang
function set_spm(fields, vals, ty){
    var actions = $('#actions').val();
    $.ajax({
        url:'akademik/sql_akademik.php?frm=SPM&pro=AWAL&actions='+actions+'&fields='+fields+'&vals='+vals+'&ty='+ty,
        type:'POST',
        data: $("form").serialize(),
        success: function(data){
            window.location.reload();
        }
    });
}

function jana_svm() {
    var id_pemohon = $('#id_pemohon').val();
    var akg = $('#svm_angka_giliran').val().trim();

    if(akg == "") {
        swal("Amaran", "Sila masukkan Angka Giliran SVM.", "warning");
        return;
    }

    var mappingKursus = { "MTK": "99" }; // Contoh mapping

    $.ajax({
        url: 'akademik/sql_akademik.php?frm=SVM&pro=FETCH_SVM',
        type: 'POST',
        data: { id_pemohon: id_pemohon, angkaGiliran: akg },
        dataType: 'json',
        beforeSend: function() {
            swal({ title: "Sila Tunggu", text: "Menarik data daripada APKV (KPM)...", showConfirmButton: false });
        },
        success: function(res) {
            swal.close();
            
            $('#bahagian_keputusan_svm').fadeIn();
            $('#simpan').show(); 

            if(res.status == 'OK') {
                var d = res.data;
                isSvmIntegrasi = '1'; // Set Flag

                // --- LOGIK HIDE ELEMEN BILA JUMPA DATA API ---
                $('#bahagian_upload').hide(); // Hide Upload
                $('#btn_papar_svm').hide();   // Hide Button Papar
                $('#btn_hapus_svm').hide();   // Hide Button Hapus
                
                // Isi Data
                var kodDbKursus = mappingKursus[d.kodProgram] ? mappingKursus[d.kodProgram] : "";
                if(kodDbKursus != "") $('#svm_sijil_1').val(kodDbKursus).trigger('change');
                
                $('#gred_bm_1').val(d.gredBM).trigger('change');
                $('#svm_pngk').val(d.pngka);
                $('#svm_pngkv').val(d.pngkv);
                $('#spm_tahun_1').val(d.tahunPeperiksaan).trigger('change');

                // Kunci Field
                lockSvmFields();
                
                // Auto Save (Optional)
                save_svm(1); 

            } else {
                // MOD MANUAL (Jika data tak jumpa)
                isSvmIntegrasi = '0';
                $('#bahagian_upload').fadeIn();
                $('#btn_papar_svm').show(); // Tunjuk balik jika user nak try semula
                // $('#btn_hapus_svm').show(); // Hapus hanya muncul kalau dah save
                
                // Unlock
                $('#svm_sijil_1, #gred_bm_1, #spm_tahun_1').attr('disabled', false);
                $('#svm_pngk, #svm_pngkv, #svm_angka_giliran').attr('readonly', false);
                $('#svm_pngk, #svm_pngkv').val('');
                
                swal("Maklumat Tiada", "Data tidak dijumpai. Sila isi secara manual.", "info");
            }
        },
        error: function() {
            swal.close();
            swal("Ralat", "Gagal berhubung dengan server APKV.", "error");
        }
    });
}
</script>