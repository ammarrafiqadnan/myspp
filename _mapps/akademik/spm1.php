<script>

function jana_integrasi_spm() {
    var id_pemohon = $('#id_pemohon').val();
    var tahun = $('#spm_tahun_1').val();
    var akg = $('#spm_angka_giliran_1').val().trim();
    var jenis = $('#spm_jenis_sijil_1').val();

    if (tahun == "0" || akg == "" || jenis == "0") {
        swal("Amaran", "Sila lengkapkan Jenis Sijil, Tahun dan Angka Giliran.", "warning");
        return;
    }

    $.ajax({
        url: 'akademik/sql_akademik.php?frm=SPM&pro=SVKSPM_API',
        type: 'POST',
        data: JSON.stringify({ tahun: tahun, angka_giliran: akg }),
        contentType: 'application/json',
        beforeSend: function() {
            swal({ title: '', text: '', showConfirmButton: false, allowOutsideClick: false, html: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i>' });
            $('#spm_integrasi_container').hide().html('');
            $('#div_manual').hide();
        },
        success: function(res) {
            swal.close();
            
            if (res.success && res.data.length > 0) {
                var apiData = res.data[0].data;
                $.ajax({
                    url: 'akademik/spm_integrasi_view.php',
                    type: 'POST',
                    data: { data_api: apiData, akg: akg, tahun: tahun },
                    success: function(view) {
                        $('#spm_integrasi_container').html(view).fadeIn();
                        $('#is_integrasi_input').val('Y');
                        $('#simpan').hide(); // Sembunyi simpan sebab auto-save
                        $('#paparKeputusan').hide();
                        save_spm(1)
                        // Panggil auto save anda di sini jika ada
                        // auto_save_spm(); 
                    }
                });
            } else {
                // KES: API Berjaya panggil tapi data tiada (Salah angka giliran/tahun)
                // $('#is_integrasi_input').val('T');
                // $('#div_manual').fadeIn();
                // $('#simpan').fadeIn();
                swal("Makuman", "Sila Masukkan Tahun dan Angka Giliran yang Tepat.", "info");
            }
        },
        error: function(xhr, status, error) {
            // KES: SERVER DOWN / VPN TUTUP / TIMEOUT
            swal.close();
            $('#is_integrasi_input').val('T'); // Set mode manual
            $('#div_manual').fadeIn(); // Buka form manual
            $('#simpan').fadeIn(); // Tunjuk butang simpan
            
            console.log("API Error: " + error);
            swal("Sila Isi Manual", "Sambungan Tidak Dalam Keadaan Baik", "warning");
        }
    });
}

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

function do_tahun(tahun){
    var sijil = document.getElementById('spm_jenis_sijil_1').value;
    var spm_tahun_val = document.getElementById('spm_tahun_1').value;
    
    if(spm_tahun_val == "" || spm_tahun_val == "0") return;

    // --- LOGIK ASAL ANDA (Lisan, Pangkat, Sejarah) ---
    if(spm_tahun_val.trim() >= '2000'){
        if(document.getElementById('spm_lisan_1')) document.getElementById('spm_lisan_1').disabled = true;
        if(document.getElementById('spm_pangkat_1')) document.getElementById('spm_pangkat_1').disabled = true;
    } else {
        if(document.getElementById('spm_lisan_1')) document.getElementById('spm_lisan_1').disabled = false;
        if(document.getElementById('spm_pangkat_1')) document.getElementById('spm_pangkat_1').disabled = false;
    }

    if(spm_tahun_val.trim() >= '2013'){
        if(document.getElementById("sejarah")) document.getElementById("sejarah").style.display = "block";
    } else {
        if(document.getElementById("sejarah")) document.getElementById("sejarah").style.display = "none";
    }
    
    // --- LOGIK BARU (Syarat 1993) ---
    var tahunInt = parseInt(spm_tahun_val);
    if(tahunInt <= 1993) {
        // Tunjuk Manual, Sembunyi Butang Integrasi
        $('#div_manual').show();
        $('#simpan').show();
        $('#paparKeputusan').hide();
        $('#spm_integrasi_container').hide().html('');
        $('#is_integrasi_input').val('T');
    } else {
        // Wajib Integrasi, Sembunyi Manual
        $('#div_manual').hide();
        $('#simpan').hide();
        $('#paparKeputusan').show();
        $('#is_integrasi_input').val('Y');
    }

    // --- LOGIK ASAL UNTUK SIJIL KOD 5 ---
    if(sijil.trim() == 5 && tahun.trim() != ''){
        var sel = "#spm_tahun_1";
        $(sel).empty();
        for(var i = tahun; i >= 2012; i--){
            $(sel).append("<option value='"+i+"'>"+i+"</option>");
        }
    }
}

</script>

<?php
// include 'akademik/sql_akademik.php';
// $data = get_pmr($conn,$_SESSION['SESS_UID']);
//print_r($data);
$uid = $data['id_pemohon'];
// $tahun = $data['spm_tahun_1'];
//print $s_tahun;
//$conn->debug=true;
if($actions==1){ 
	$rsSijil = $conn->query("SELECT * FROM $schema2.`calon_sijil` WHERE `jenis_sijil`='SPM1' AND `id_pemohon`=".tosql($uid));
	$get_sijil=$rsSijil->fields['sijil_nama'];
} else if($actions==2){
	$rsSijil = $conn->query("SELECT * FROM $schema2.`calon_sijil` WHERE `jenis_sijil`='SPM2' AND `id_pemohon`=".tosql($uid));
	$get_sijil=$rsSijil->fields['sijil_nama'];
} else {
	$get_sijil='';
}
//if(empty($get_sijil)){ $sijil="../upload_doc/sijil_spm.jpg"; }
//else { $sijil = "/upload/".$uid."/".$get_sijil; }

// print "<br><br>SIJIL:".$rsSijil->fields['sijil_nama'];
if(empty($rsSijil->fields['sijil_nama'])){ $sijil_pic1 ="/var/www/html/myspp/upload_doc/sijil_spm.jpg"; }
else { $sijil_pic1 = "/var/www/upload/".$uid."/".$rsSijil->fields['sijil_nama']; }
	//print $sijil;
if (file_exists($sijil_pic1)){
		$b64image = base64_encode(file_get_contents($sijil_pic1));
		$sijil = "data:image/png;base64,$b64image";
}

//print "S:".
?>

	<?php
	// print "DATA:".$data['spm_jenis_sijil_1'];
	// $conn->debug=true;
	if($data['spm_jenis_sijil_1']=='1' || $data['spm_jenis_sijil_1']=='3'){	
		$rssijil = $conn->query("SELECT * FROM $schema1.`ref_sijil` WHERE `TKT`='5' AND KOD IN (1,3,6) AND is_aktif=0");

	// REMOVE ON 11 Nov 2023
	/* } else if($data['spm_jenis_sijil_1']=='6'){	
		// $rssijil = $conn->query("SELECT * FROM $schema1.`ref_sijil` WHERE `TKT`='5' AND KOD=6 AND is_aktif=0");
	// } else if($data['spm_jenis_sijil_2']=='6'){	
		// $rssijil = $conn->query("SELECT * FROM $schema1.`ref_sijil` WHERE `TKT`='5' AND KOD=6 AND is_aktif=0");
	*/
	} else {
		$rssijil = $conn->query("SELECT * FROM $schema1.`ref_sijil` WHERE `TKT`='5' AND is_aktif=0");
	}
	$rspangkat = $conn->query("SELECT * FROM $schema1.`ref_sijil_pangkat` WHERE `TKT`=5 ORDER BY `DISKRIPSI`");
	$conn->debug=false;

	// print $s_tahun.":".$s_sijil;
	$result = get_spm_result($conn, $uid, "103", $s_tahun, "1");

	?>
    <div class="form-group">
		<div class="row">
			<label for="nama" class="col-sm-2 control-label"><b>Jenis Sijil <font color="#FF0000">*</font><div style="float:right">:</div></b></label>
			<div class="col-sm-4">
				<select class="form-control" id="spm_jenis_sijil_1" name="spm_jenis_sijil_1" onchange="set_spm('spm_jenis_sijil_1',this.value,'R')"

					<?php if(!empty($result['gred']) && !empty($s_sijil)){ print 'disabled'; }?>>
					 <!-- onchange="set_spm('spm_jenis_sijil_1',this.value,'R')" -->
					 <!-- onchange="do_tahun('<?=date("Y");?>')"  -->
					<option value="0">Sila pilih jenis sijil</option>
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
			<label for="nama" class="col-sm-2 control-label"><b>Tahun <font color="#FF0000">*</font><div style="float:right">:</div></b></label>
			<div class="col-sm-3">
				<select name="spm_tahun_1" id="spm_tahun_1" class="form-control" 
                    onchange="set_spm('spm_tahun_1',this.value,''); do_tahun('<?=date("Y");?>');" 
                    <?php if(!empty($result['gred']) && !empty($s_sijil)){ print 'disabled'; }?>>
                                    <!--  -->
					<option value="0">Sila pilih tahun</option>
					<?php for($t=$tahun_2;$t>=$tahun_1;$t--){
						print '<option value="'.$t.'"'; 
						if($s_tahun==$t){ print 'selected'; }
						print '>'.$t.'</option>';
					} ?>
				</select>
				<input type="hidden" name="spm_tahun_pilih" value="<?=$s_tahun;?>">
			</div>
			<?php if($actions==1){ ?>
			<div class="col-sm-1"></div>
			<label for="nama" class="col-sm-2 control-label"><b>Pangkat <font color="#FF0000">*</font><div style="float:right">:</div></b></label>
			<div class="col-sm-3">
				<select class="form-control" name="spm_pangkat_1" id="spm_pangkat_1" onchange="set_spm('spm_pangkat_1',this.value,'')" <?php if($s_tahun >= 2000 && $s_tahun <= 2022){ print 'readonly'; } ?>>
					<option value="0">Sila pilih pangkat</option>
					<?php while(!$rspangkat->EOF){ ?>
					<option value="<?=$rspangkat->fields['KOD'];?>" 
					<?php if($rspangkat->fields['DISKRIPSI']==$s_pangkat){ print 'selected';} ?>
					><?=$rspangkat->fields['DISKRIPSI'];?></option>
					<?php $rspangkat->movenext(); } ?>
				</select>
			</div>
			<?php } ?>
		</div>
	</div>
	<?php if($actions==1){ ?>
    <div class="form-group">
        <div class="row">
            <label class="col-sm-2 control-label">
                <b>Angka Giliran <font color="#FF0000">*</font> :</b>
            </label>
            <div class="col-sm-3">
                <input type="text" class="form-control" name="spm_angka_giliran" id="spm_angka_giliran_1" 
                    value="<?=$data['angka_giliran_spm1'];?>" placeholder="Angka Giliran" maxlength="12" <?php if(!empty($result['gred']) && !empty($s_sijil)){ print 'disabled'; }?>>
            </div>
        </div>
    </div>

	<?php } ?>

    <input type="hidden" name="is_integrasi_input" id="is_integrasi_input" value="<?=($data['is_integrasi']=='Y')?'Y':'T';?>">
	<?php if($actions==1){ ?>
	<div class="form-group">
		<div class="row">
			<label for="nama" class="col-sm-4 control-label"><b>Ujian Lisan Bahasa Melayu/Bahasa Malaysia <div style="float:right">:</div></b></label>
			<div class="col-sm-3">
				<select class="form-control" id="spm_lisan_1" name="spm_lisan_1" onchange="set_spm('spm_lisan_1',this.value,'')" <?php if($s_tahun >= 2000 && $s_tahun <= 2022){ print 'readonly'; } ?>>
					<option value="">Sila pilih </option>
					<option value="L" <?php if($s_lisan=='L'){ print 'selected';} ?>>Lulus</option>
					<option value="G" <?php if($s_lisan=='G'){ print 'selected';} ?>>Gagal</option>
				</select>
			</div>
		</div>
	</div>
    <div  style="float:right;">
    <button type="button" class="btn btn-success" id="paparKeputusan" onclick="jana_integrasi_spm()"><i class="fa fa-file"></i> Papar Keputusan</button>
	</div>

	<?php } ?>

    <div id="spm_integrasi_container"></div>

	<?php //if(!empty($s_tahun)){ 
		$rsSRP = $conn->query("SELECT * FROM $schema1.`ref_matapelajaran` WHERE `TKT`='5' AND `SAH_YT`='Y' AND `GAB_YT`='T' AND `kod` NOT IN ('103')
			ORDER BY `DISKRIPSI`");
		if($s_tahun >= 1975 && $s_tahun <= 2008){
			$rsGred = $conn->query("SELECT * FROM $schema1.`ref_gred_matapelajaran` WHERE GRED BETWEEN 1 AND 9 AND `TKT`='5' ORDER BY `SUSUNAN`");
		} else {
			$rsGred = $conn->query("SELECT * FROM $schema1.`ref_gred_matapelajaran` WHERE GRED NOT BETWEEN 1 AND 9 AND `TKT`='5' ORDER BY `SUSUNAN`");
		}
	?>

	<div class="form-group">
        <div id="div_manual" style="display:none;">
	        <hr>
            <div class="row">
                <div class="col-sm-8">
                    <div class="row">
                        <div class="col-sm-7 col-xs-7" style="padding-bottom:5px;text-align: center;"><b>MATAPELAJARAN</b></div>
                        <div class="col-sm-3 col-xs-3" style="padding-bottom:5px;text-align: center;"><b>GRED</b></div>
                        <div class="col-sm-4 col-xs-1" style="padding-bottom:5px;text-align: center;"><b></b></div>
                    </div>
                    <div class="row">
                        <div class="col-sm-7 col-xs-7" style="padding-bottom:5px;margin-left:-10px"><b>BAHASA MELAYU/BAHASA MALAYSIA <font color="#FF0000">*</font></b></div>
                        <div class="col-sm-4 col-xs-4" style="padding-bottom:5px;margin-left:-10px">
                            <input type="hidden" name="mp_old[]" value="103">
                            <input type="hidden" name="mp_1[]" id="mp_10" value="103">
                            <select class="form-control" name="gred_1[]" id="gred_10">
                                <option value="">Sila pilih gred</option>
                                <?php 
                                //$result = get_spm_result($conn, $uid, "103", $s_tahun, "1");
                                $datas='103';
                                $rsGred->movefirst();
                                if(!empty($result['gred'])){ $greds=$result['gred']; } else { $greds=''; }
                                while(!$rsGred->EOF){ ?>
                                <option value="<?=$rsGred->fields['GRED'];?>" <?php if($rsGred->fields['GRED']==$greds){ print 'selected'; } ?>><?=$rsGred->fields['GRED'];?></option>	
                                <?php $rsGred->movenext(); } ?>
                            </select>
                        </div>
                    </div>

                    <?php 
                    $bilr=1;
                    if(!empty($s_tahun) && $s_tahun>=2013){ $bilr++;?>
                    <div class="row" id=sejarah>
                        <div class="col-sm-7 col-xs-7" style="padding-bottom:5px;margin-left:-10px"><b>SEJARAH <font color="#FF0000">*</font></b></div>
                        <div class="col-sm-4 col-xs-4" style="padding-bottom:5px;margin-left:-10px">
                            <input type="hidden" name="mp_old[]" value="249">
                            <input type="hidden" name="mp_1[]" id="mp_1<?=$bilr;?>" value="249">
                            <select class="form-control" name="gred_1[]" id="gred_11">
                                <option value="">Sila pilih gred</option>
                                <?php 
                                $result = get_spm_result($conn, $uid, "249", $s_tahun, "1");
                                $datas='249';
                                $rsGred->movefirst();
                                while(!$rsGred->EOF){ ?>
                                <option value="<?=$rsGred->fields['GRED'];?>" <?php if($result['gred']==$rsGred->fields['GRED']){ print 'selected'; } ?>><?=$rsGred->fields['GRED'];?></option>	
                                <?php $rsGred->movenext(); } ?>
                            </select>
                        </div>
                    </div>
                    <?php } else if(empty($s_tahun)){  $bilr++; ?>
                    <div class="row" id=sejarah>
                        <div class="col-sm-7 col-xs-7" style="padding-bottom:5px;margin-left:-10px"><b>SEJARAH <font color="#FF0000">*</font></b></div>
                        <div class="col-sm-4 col-xs-4" style="padding-bottom:5px;margin-left:-10px">
                            <input type="hidden" name="mp_old[]" value="249">
                            <input type="hidden" name="mp_1[]" id="mp_1<?=$bilr;?>" value="249">
                            <select class="form-control" name="gred_1[]" id="gred_11">
                                <option value="">Sila pilih gred</option>
                                <?php 
                                $result = get_spm_result($conn, $uid, "249", $s_tahun, "1");
                                if(!empty($result['gred'])){ $greds=$result['gred']; } else { $greds=''; }
                                $datas='249';
                                $rsGred->movefirst();
                                while(!$rsGred->EOF){ ?>
                                <option value="<?=$rsGred->fields['GRED'];?>" <?php if($rsGred->fields['GRED']==$greds){ print 'selected'; } ?>><?=$rsGred->fields['GRED'];?></option>	
                                <?php $rsGred->movenext(); } ?>
                            </select>
                        </div>
                    </div>
                <?php } ?>


                    <?php  
                    // $conn->debug=true;
                    // print date("YmdHisN");
                    if($s_tahun>=2013){
                        $rsResult = $conn->query("SELECT * FROM $schema2.`calon_spm` WHERE `jenis_xm`='1' AND `id_pemohon`=".tosql($uid). " AND tahun=".tosql($s_tahun). " AND matapelajaran NOT IN ('103','249') ORDER BY `spm_id`");
                    } else { 
                        $rsResult = $conn->query("SELECT * FROM $schema2.`calon_spm` WHERE `jenis_xm`='1' AND `id_pemohon`=".tosql($uid). " AND tahun=".tosql($s_tahun). " AND matapelajaran NOT IN ('103') ORDER BY `spm_id`");
                    }
                    $conn->debug=false;
                    while(!$rsResult->EOF){ 
                        $datas.=",".$rsResult->fields['matapelajaran']; $bilr++; 
                    ?>								
                    <div class="row">
                        <div class="col-sm-7 col-xs-7" style="padding-bottom:5px;margin-left:-10px">
                            <input type="hidden" name="mp_old[]" value="<?=$rsResult->fields['matapelajaran'];?>">
                            <select name="mp_1[]" id="mp_1<?=$bilr;?>" class="form-control select2 select2-accessible mps<?=$bilr;?>" style="width: 100%;" aria-hidden="true" 
                                onchange="Geeks(this.value,<?=$bilr;?>)">
                                <option value="">Sila pilih matapelajaran</option>
                                <?php $rsSRP->movefirst();
                                while(!$rsSRP->EOF){ ?>
                                <option value="<?=$rsSRP->fields['kod'];?>"<?php if($rsSRP->fields['kod']==$rsResult->fields['matapelajaran']){ print ' selected'; } ?>><?=$rsSRP->fields['DISKRIPSI'];?></option>	
                                <?php $rsSRP->movenext(); } ?>
                            </select>
                        </div>
                        <div class="col-sm-4 col-xs-4" style="padding-bottom:5px;margin-left:-10px">
                            <select class="form-control" name="gred_1[]" id="gred_1<?=$bilr;?>">
                                <option value="">Sila pilih gred</option>
                                <?php $rsGred->movefirst();
                                while(!$rsGred->EOF){ ?>
                                <option value="<?=$rsGred->fields['GRED'];?>"<?php if($rsGred->fields['GRED']==$rsResult->fields['gred']){ print ' selected'; } ?>><?=$rsGred->fields['GRED'];?></option>	
                                <?php $rsGred->movenext(); } ?>
                            </select>
                        </div>
                        <div class="col-sm-1">
                            <img src="../images/trash.png" title="Hapus maklumat matapelajaran & gred" style="cursor: pointer;" 
                            height="30" onclick="do_hapus('akademik/sql_akademik.php?frm=SPM&pro=SPM_DEL_REC&sid=<?=$rsResult->fields['spm_id'];?>')">
                            
                        </div>
                    </div>
                    <?php $rsResult->movenext(); } ?>

                    <?php for($i=$bilr+1;$i<=12;$i++){ ?>
                    <div class="row">
                        <div class="col-sm-7 col-xs-7" style="padding-bottom:5px;margin-left:-10px">
                            <input type="hidden" name="mp_old[]" value="">
                            <select name="mp_1[]" id="mp_1<?=$i;?>" class="form-control select2 select2-accessible mps<?=$i;?>" style="width: 100%;" aria-hidden="true" 
                                onchange="Geeks(this.value,<?=$i;?>)">
                                <option value="">Sila pilih matapelajaran</option>
                                <?php $rsSRP->movefirst();
                                while(!$rsSRP->EOF){ ?>
                                <option value="<?=$rsSRP->fields['kod'];?>"><?=$rsSRP->fields['DISKRIPSI'];?></option>	
                                <?php $rsSRP->movenext(); } ?>
                            </select>
                        </div>
                        <div class="col-sm-4 col-xs-4" style="padding-bottom:5px;margin-left:-10px">
                            <select class="form-control" name="gred_1[]" id="gred_1<?=$i;?>">
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
                <?php
                    $sql = "SELECT COUNT(*) as total FROM $schema2.`kawalan_muatnaik_dokumen` WHERE is_deleted=0 AND `status`=0"; 
                    $sql .=" AND tajuk_dokumen LIKE '%KEPUTUSAN SPM/SPM(V)%'" ;
                    $rsDoc = $conn->query($sql);
                ?>
                <?php if($rsDoc->fields['total'] > 0){ ?>

                <div class="col-sm-4" align="center" style="border: 2px solid black; padding: 10px; border-radius: 25px;">
                    <h6><b>Sijil SPM/SPM(V)/SVM</b></h6>
                    <img src="<?=$sijil;?>" width="100%" height="400">
                    <?php print $rsSijil->fields['sijil_nama'];?><br>
                    <input type="file" name="file_pmr" id="file_pmr" class="form-control" value="" onchange="do_input()">
                    <small style="color: red;">Hanya menerima format png,jpg,jpeg @ gif dan tidak melebihi 300kb</small>

                </div>
                <?php } ?>

            </div>
        </div>
			<div class="modal-footer" style="padding:0px;">
				<button type="button" id="simpan" style="display:none;" class="btn btn-primary mt-sm mb-sm" onclick="save_spm('<?=$actions;?>')"><i class="fa fa-save"></i> Simpan</button>
				<?php if($actions==2){ ?>
				<?php	if(!empty($data['spm_tahun_1']) && !empty($data['spm_tahun_2']) && $data['is_integrasi_input'] == 'T'){ ?>
						<label class="btn btn-danger" onclick="do_hapus_url('akademik/sql_akademik.php?frm=SPM&pro=SPM_DEL&tahun=<?=$s_tahun;?>&actions=<?=$actions;?>&id_pemohon=<?=$_SESSION['SESS_UID'];?>')">Hapus</label>
				<?php 	} ?>
				<?php } else if($actions==1 && !empty($data['spm_tahun_2']) && $data['is_integrasi_input'] == 'T'){ ?>
						<label class="btn btn-danger" title="Sila hapus maklumat peperiksaan kedua terlebih dahulu." onclick="do_dummyhapus()">Hapus</label>
				<?php } else if($actions==1 && empty($data['spm_tahun_2'])){ 

					if(!empty($result['gred']) && $data['is_integrasi_input'] == 'T'){ 
				?>
						<label class="btn btn-danger" onclick="do_hapus_url('akademik/sql_akademik.php?frm=SPM&pro=SPM_DEL&tahun=<?=$s_tahun;?>&actions=<?=$actions;?>&id_pemohon=<?=$_SESSION['SESS_UID'];?>')">Hapus</label>
				<?php } } ?>
				<input type="hidden" name="progid" id="progid" value="<?php print $progid;?>" />
				<input type="hidden" name="proses" value="<?php print $proses;?>" />
				<input type="hidden" name="chk" id="chk" value="<?=$datas;?>">
			</div>
		</div>
	<?php //} ?>


	     

<script language="javascript" type="text/javascript">
var spm_tahun_1 = document.getElementById('spm_tahun_1').value;
var acts =  document.getElementById('actions').value;
// var srp_pangkat = document.getElementById('srp_pangkat');
// alert(spm_tahun_1);
if(acts==1){
    if(spm_tahun_1>='2000'){
        spm_lisan_1.setAttribute('disabled', '');
        spm_pangkat_1.setAttribute('disabled', '');
    } else {
        spm_lisan_1.removeAttribute('disabled');
        spm_pangkat_1.removeAttribute('disabled');
        // sejarah.removeAttribute('disabled');
    }
}
</script>		

<input type="hidden" name="id_pemohon" id="id_pemohon" value="<?php print $uid;?>" />
<input type="hidden" name="is_integrasi_saved" id="is_integrasi_saved" value="<?=$data['is_integrasi'];?>">

<script>
$(document).ready(function() {
    // Gunakan data PHP yang di-pass ke JS (contoh: $data['is_integrasi_spm1'])
    var isInt = '<?=$data['is_integrasi_spm1'];?>'; 
    var akg = '<?=$data['angka_giliran_spm1'];?>';
    var tahun = '<?=$data['spm_tahun_1'];?>';
    
    // Logik paparan onload
    if (tahun !== "" && akg !== "") {
        if (isInt === 'Y') {
            // Panggil API terus untuk render view integrasi
            papar_integrasi_onload(tahun, akg);
        } else {
            // Papar manual
            $('#div_manual').show();
            $('#spm_integrasi_container').hide();
            $('#simpan').show();
        }
    }
});

// Fungsi khas untuk auto-load tanpa Swal Alert
function papar_integrasi_onload(tahun, akg) {
    $.ajax({
        url: 'akademik/sql_akademik.php?frm=SPM&pro=SVKSPM_API',
        type: 'POST',
        data: JSON.stringify({ tahun: tahun, angka_giliran: akg }),
        contentType: 'application/json',
        success: function(res) {
            if (res.success && res.data.length > 0) {
                var apiData = res.data[0].data;
                $.ajax({
                    url: 'akademik/spm_integrasi_view.php',
                    type: 'POST',
                    data: { data_api: apiData, akg: akg, tahun: tahun },
                    success: function(view) {
                        $('#spm_integrasi_container').html(view).show();
                        $('#is_integrasi_input').val('Y');
                        $('#div_manual').hide();
                        $('#div_manual').hide();
                        $('.hapusSemua').show();
                        $('#paparKeputusan').hide();
                    }
                });
            }
        }
    });
}
</script>
