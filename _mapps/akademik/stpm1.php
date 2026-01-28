<?php
// Dapatkan ID
$uid = $data['id_pemohon'];

// --- LOGIC TENTUKAN DATA & STATUS BERDASARKAN TAB ($actions) ---
if($actions==1){ 
    // Tab 1
    $rsSijil = $conn->query("SELECT * FROM $schema2.`calon_sijil` WHERE `jenis_sijil`='STPM1' AND `id_pemohon`=".tosql($uid));
    $s_tahun = $data['stp_tahun_1'];
    $s_sijil = $data['stp_jenis_1'];
    $jxm = 'B';
    
    // Ambil status khusus untuk STPM 1
    $is_integrasi = isset($data['is_integrasi_stpm1']) ? $data['is_integrasi_stpm1'] : 'T';
    $angka_giliran_val = isset($data['angka_giliran_stpm1']) ? $data['angka_giliran_stpm1'] : '';

} else if($actions==2){
    // Tab 2
    $rsSijil = $conn->query("SELECT * FROM $schema2.`calon_sijil` WHERE `jenis_sijil`='STPM2' AND `id_pemohon`=".tosql($uid));
    $s_tahun = $data['stp_tahun_2'];
    $s_sijil = $data['stp_jenis_2'];
    $jxm = 'BT';

    // Ambil status khusus untuk STPM 2
    $is_integrasi = isset($data['is_integrasi_stpm2']) ? $data['is_integrasi_stpm2'] : 'T';
    $angka_giliran_val = isset($data['angka_giliran_stpm2']) ? $data['angka_giliran_stpm2'] : '';
}

// Logic Gambar Sijil
if(empty($rsSijil->fields['sijil_nama'])){ $sijil_pic1 ="/var/www/html/myspp/upload_doc/stpm.png"; }
else { $sijil_pic1 = "/var/www/upload/".$uid."/".$rsSijil->fields['sijil_nama']; }

if (file_exists($sijil_pic1)){
    $b64image = base64_encode(file_get_contents($sijil_pic1));
    $sijil = "data:image/png;base64,$b64image";
}

// Load Reference Tables
$rssijil = $conn->query("SELECT * FROM $schema1.`ref_sijil` WHERE `TKT`='6' AND `kod` IN (1) ");
$rsSRP = $conn->query("SELECT * FROM $schema1.`ref_matapelajaran` WHERE `TKT`='6' AND `SAH_YT`='Y' AND `GAB_YT`='T' AND `kod` NOT IN ('900') ORDER BY `DISKRIPSI`");
$rsGred = $conn->query("SELECT * FROM $schema1.`ref_gred_matapelajaran` WHERE `TKT`='6' AND `JENIS`='D' ORDER BY `SUSUNAN`");
?>

<input type="hidden" name="stp_tahun_pilih" value="<?=$s_tahun;?>">
<input type="hidden" name="stp_sijil_pilih" value="<?=$s_sijil;?>">
<input type="hidden" name="is_integrasi_input" id="is_integrasi_input" value="<?=$is_integrasi;?>">

<div class="form-group">
    <div class="row">
        <label for="nama" class="col-sm-2 control-label"><b>Tahun <font color="#FF0000">*</font><div style="float:right">:</div></b></label>
        <div class="col-sm-3">
            <select name="stp_tahun_1" id="stp_tahun_1" class="form-control" onchange="set_stpm('','','R')" <?php if(!empty($s_tahun) && !empty($s_sijil)){ print 'disabled'; }?>>
                <option value="">Sila pilih tahun</option>
                <?php for($t=$tahun_2;$t>=$tahun_1;$t--){
                    print '<option value="'.$t.'"'; 
                    if($s_tahun==$t){ print 'selected'; }
                    print '>'.$t.'</option>';
                } ?>
            </select>
        </div>
    </div>
    <div class="row" style="margin-top: 20px;">
        <label for="nama" class="col-sm-2 control-label"><b>Jenis Sijil <font color="#FF0000">*</font><div style="float:right">:</div></b></label>
        <div class="col-sm-3">
            <select class="form-control" id="stp_jenis_1" name="stp_jenis_1" onchange="set_stpm('','','')" <?php if(!empty($s_tahun) && !empty($s_sijil)){ print 'disabled'; }?>>
                <?php while(!$rssijil->EOF){ ?>
                <option value="<?=$rssijil->fields['KOD'];?>" <?php if($rssijil->fields['KOD']==$s_sijil){ print 'selected';} ?>><?=$rssijil->fields['DISKRIPSI'];?></option>
                <?php $rssijil->movenext(); } ?>
            </select>
        </div>
    </div>
</div>

<div class="form-group">
    <?php $showManual = (!empty($s_tahun)) ? '' : 'display:none'; ?>

    <div class="row divManual" style="border: 1px solid #ddd; padding: 10px; margin-top: 10px; margin-below: 10px;<?=$showManual;?>">
        
        <label for="nama" class="col-sm-2 control-label"><b>Angka Giliran <div style="float:right">:</div></b></label>
        <div class="col-sm-3" id="container_akg">
            <?php if($is_integrasi == 'Y') { ?>
                <p class="form-control-static" style="font-weight:bold; margin-top:7px; margin-bottom:0;"><?=$angka_giliran_val;?></p>
                <input type="hidden" name="stpm_angka_giliran_1" id="stpm_angka_giliran_1" value="<?=$angka_giliran_val;?>">
            <?php } else { ?>
                <input type="text" class="form-control" name="stpm_angka_giliran_1" id="stpm_angka_giliran_1" value="<?=$angka_giliran_val;?>" placeholder="Angka Giliran" maxlength="20">
            <?php } ?>
        </div>

        <div class="col-sm-12"><br></div>
        
        <div class="col-sm-9" id="container_subjek"> 
			<div class="row">
                <div class="col-sm-7" style="padding-bottom:5px;"><b>MATAPELAJARAN</b></div>
                <div class="col-sm-3" style="padding-bottom:5px;"><b>GRED</b></div>
                <div class="col-sm-1" style="padding-bottom:5px;"><b></b></div>
            </div>

            <?php 
            $result = get_stp_result($conn, $uid, "900", $s_tahun, $jxm);
            $gred_pa = $result['gred'];
            
            // SKIP row ini jika Integrasi DAN data kosong
            if( !($is_integrasi == 'Y' && empty($gred_pa)) ) { 
            ?>
            <div class="row" style="margin-top: 10px; border-bottom: 1px dashed #eee; padding-bottom: 5px;">
                <div class="col-sm-7">
                    <?php if($is_integrasi == 'Y') { ?>
                        <p class="form-control-static" style="margin-bottom:0;">PENGAJIAN AM/KERTAS AM</p>
                        <input type="hidden" name="mp_old[]" value="900">
                        <input type="hidden" name="mp_1[]" value="900">
                    <?php } else { ?>
                        <b>PENGAJIAN AM/KERTAS AM</b>
                        <input type="hidden" name="mp_old[]" value="900">
                        <input type="hidden" name="mp_1[]" id="mp_10" value="900">
                    <?php } ?>
                </div>
                <div class="col-sm-3">
                    <?php if($is_integrasi == 'Y') { ?>
                        <p class="form-control-static" style="font-weight:bold; margin-bottom:0;"><?=$gred_pa;?></p>
                        <input type="hidden" name="gred_1[]" value="<?=$gred_pa;?>">
                    <?php } else { ?>
                        <select class="form-control" name="gred_1[]" id="gred_10">
                            <option value="">Sila pilih gred</option>
                            <?php $rsGred->movefirst(); while(!$rsGred->EOF){ ?>
                            <option value="<?=$rsGred->fields['GRED'];?>" <?php if($gred_pa==$rsGred->fields['GRED']){ print 'selected'; } ?>><?=$rsGred->fields['GRED'];?></option> 
                            <?php $rsGred->movenext(); } ?>
                        </select>
                    <?php } ?>
                </div>
            </div>
            <?php } ?>

            <?php 
            $bilr=0; 
            // Query ikut jenis exam yang betul
            $q_jenis = ($actions==1) ? 'B' : 'BT';
            $rsResult = $conn->query("SELECT * FROM $schema2.`calon_stp_stam` WHERE `jenis_xm`='$q_jenis' AND `id_pemohon`=".tosql($uid). " AND tahun=".tosql($s_tahun). " AND matapelajaran NOT IN ('900') ORDER BY `stp_id`");
            
            while(!$rsResult->EOF){ 
                $curr_mp = $rsResult->fields['matapelajaran'];
                $curr_gred = $rsResult->fields['gred'];
                $curr_id = $rsResult->fields['stp_id'];
                $bilr++; 
                
                // Cari Nama Subjek
                $rsNama = $conn->query("SELECT DISKRIPSI FROM $schema1.ref_matapelajaran WHERE kod='$curr_mp' AND TKT='6'");
                $nama_display = $rsNama->EOF ? $curr_mp : $rsNama->fields['DISKRIPSI'];

                // SKIP jika Integrasi DAN data kosong
                if($is_integrasi == 'Y' && empty($curr_mp)) { $rsResult->movenext(); continue; }
            ?>                                  
            <div class="row" style="margin-top: 10px; border-bottom: 1px dashed #eee; padding-bottom: 5px;">
                <div class="col-sm-7">
                    <input type="hidden" name="mp_old[]" value="<?=$curr_mp;?>">
                    
                    <?php if($is_integrasi == 'Y') { ?>
                        <p class="form-control-static" style="margin-bottom:0;"><?=$nama_display;?></p>
                        <input type="hidden" name="mp_1[]" value="<?=$curr_mp;?>">
                    <?php } else { ?>
                        <select name="mp_1[]" id="mp_1<?=$bilr;?>" class="form-control select2 mps<?=$bilr;?>" style="width: 100%;" onchange="Geeks(this.value,<?=$i;?>)">
                            <option value="">Sila pilih matapelajaran</option>
                            <?php $rsSRP->movefirst(); while(!$rsSRP->EOF){ ?>
                            <option value="<?=$rsSRP->fields['kod'];?>"<?php if($rsSRP->fields['kod']==$curr_mp){ print ' selected'; } ?>><?=$rsSRP->fields['DISKRIPSI'];?></option>  
                            <?php $rsSRP->movenext(); } ?>
                        </select>
                    <?php } ?>
                </div>
                <div class="col-sm-3">
                    <?php if($is_integrasi == 'Y') { ?>
                        <p class="form-control-static" style="font-weight:bold; margin-bottom:0;"><?=$curr_gred;?></p>
                        <input type="hidden" name="gred_1[]" value="<?=$curr_gred;?>">
                    <?php } else { ?>
                        <select class="form-control" name="gred_1[]" id="gred_1<?=$bilr;?>">
                            <option value="">Sila pilih gred</option>
                            <?php $rsGred->movefirst(); while(!$rsGred->EOF){ ?>
                            <option value="<?=$rsGred->fields['GRED'];?>"<?php if($rsGred->fields['GRED']==$curr_gred){ print ' selected'; } ?>><?=$rsGred->fields['GRED'];?></option>    
                            <?php $rsGred->movenext(); } ?>
                        </select>
                    <?php } ?>
                </div>
                <div class="col-sm-1">
                    <?php if($is_integrasi != 'Y') { ?>
                    <img src="../images/trash.png" title="Hapus maklumat" style="cursor: pointer;"  
                    height="30" onclick="do_hapus('akademik/sql_akademik.php?frm=STPM&pro=STPM_DEL_REC&sid=<?=$rsResult->fields['stp_id'];?>&id_pemohon=<?=$_SESSION['SESS_UID'];?>')">
                    <?php } ?>
                </div>
            </div>
            <?php $rsResult->movenext(); } ?>

            <?php if($is_integrasi != 'Y') { ?>
                <?php for($i=$bilr+1;$i<=4;$i++){ ?>
                <div class="row" style="margin-top: 10px;">
                    <div class="col-sm-7">
                        <input type="hidden" name="mp_old[]" value="">
                        <select name="mp_1[]" id="mp_1<?=$i;?>" class="form-control select2 mps<?=$i;?>" style="width: 100%;" onchange="Geeks(this.value,<?=$i;?>)">
                            <option value="">Sila pilih matapelajaran</option>
                            <?php $rsSRP->movefirst(); while(!$rsSRP->EOF){ ?>
                            <option value="<?=$rsSRP->fields['kod'];?>"><?=$rsSRP->fields['DISKRIPSI'];?></option>  
                            <?php $rsSRP->movenext(); } ?>
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <select class="form-control" name="gred_1[]" id="gred_1<?=$i;?>">
                            <option value="">Sila pilih gred</option>
                            <?php $rsGred->movefirst(); while(!$rsGred->EOF){ ?>
                            <option value="<?=$rsGred->fields['GRED'];?>"><?=$rsGred->fields['GRED'];?></option>    
                            <?php $rsGred->movenext(); } ?>
                        </select>
                    </div>
                    <div class="col-sm-1"></div>
                </div>
                <?php } ?>
            <?php } ?>
        </div>

        <?php
            $sql = "SELECT COUNT(*) as total FROM $schema2.`kawalan_muatnaik_dokumen` WHERE is_deleted=0 AND `status`=0"; 
            $sql .=" AND tajuk_dokumen LIKE '%KEPUTUSAN STPM%'" ;
            $rsDoc = $conn->query($sql);
        ?>
        <?php if($rsDoc->fields['total'] > 0 && $is_integrasi != 'Y'){ ?>
        <div class="col-sm-3 divUpload" align="center" style="border: 2px solid black; padding: 10px; border-radius: 25px;">
			
            <h6><b>Sijil STPM</b></h6>
            <img src="<?=$sijil;?>" width="100%" height="400">
            <h6><?=$rsSijil->fields['sijil_nama'];?></h6>
            <input type="file" name="file_pmr" id="file_pmr" class="form-control" onchange="do_input()" value="">
            <small style="color: red;">Hanya menerima format png,jpg,jpeg @ gif dan tidak melebihi 300kb</small>
        </div>
        <?php } ?>
    </div>

    <div class="modal-footer" style="padding:0px;">
        <button type="button" class="btn btn-success mt-sm mb-sm divPapar" onclick="jana_keputusan_stpm()">
            <i class="fa fa-file"></i> Papar Keputusan
        </button>
        <button type="button" id="simpan" style="display:<?=(!empty($s_tahun)?'inline-block':'none');?>" class="btn btn-primary mt-sm mb-sm divPapar" onclick="save_stpm(1)"><i class="fa fa-save"></i> Simpan</button>
        
        <?php if(!empty($s_tahun) && $is_integrasi != 'Y'){ ?>
            <label class="btn btn-danger" onclick="do_hapus_url('akademik/sql_akademik.php?frm=STPM&pro=STPM_DEL&tahun=<?=$s_tahun;?>&actions=<?=$actions;?>&id_pemohon=<?=$_SESSION['SESS_UID'];?>')">Hapus</label>
        <?php } ?>
        
        <input type="hidden" name="progid" id="progid" value="<?php print $progid;?>" />
        <input type="hidden" name="proses" value="<?php print $proses;?>" />
        <input type="hidden" name="chk" id="chk" value="<?=$datas;?>">
    </div>

</div>
	<?php //} ?>


	     

<script language="javascript" type="text/javascript">
// var srp_tahun = document.getElementById('srp_tahun').value;
// var srp_pangkat = document.getElementById('srp_pangkat');
// // alert(srp_tahun);
// if(srp_tahun>='1993'){
// 	srp_pangkat.setAttribute('disabled', '');
// } else {
// 	srp_pangkat.removeAttribute('disabled');
// }

function jana_keputusan_stpm() {
    var id_pemohon = $('#id_pemohon').val();
    var stp_tahun = $('#stp_tahun_1').val();

    if(stp_tahun == "") {
        swal("Amaran", "Sila pilih Tahun peperiksaan terlebih dahulu.", "warning");
        return;
    }

    $.ajax({
        url: 'akademik/sql_akademik.php?frm=STPM&pro=FETCH_STPM',
        type: 'POST',
        data: { id_pemohon: id_pemohon, stp_tahun: stp_tahun },
        dataType: 'json',
        beforeSend: function() {
            swal({ title: '', text: '', showConfirmButton: false, allowOutsideClick: false, html: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i>' });
        },
        success: function(res) {
            swal.close();
            // $('.divManual').show(); 
            // $('#simpan').fadeIn();

            if(res.status == 'OK') {
                // --- KES 1: DATA INTEGRASI JUMPA (MODE TEKS) ---
                var d = res.data;
                
                $('#is_integrasi_input').val('Y'); 
                $('.divUpload').hide();
                $('.divPapar').hide();
                $('img[src*="trash.png"]').hide();

                // 1. UPDATE ANGKA GILIRAN
                var akg_val = d.akg ? d.akg : '-';
                var html_akg = '<p class="form-control-static" style="font-weight:bold; margin-top:7px; margin-bottom:0;">' + akg_val + '</p>';
                html_akg += '<input type="hidden" name="stpm_angka_giliran_1" id="stpm_angka_giliran_1" value="' + (d.akg ? d.akg : '') + '">';
                $('#container_akg').html(html_akg);

                // 2. BINA LIST SUBJEK
                var html_list = '';
                html_list += '<div class="row"><div class="col-sm-7" style="padding-bottom:5px;"><b>MATAPELAJARAN</b></div><div class="col-sm-3" style="padding-bottom:5px;"><b>GRED</b></div><div class="col-sm-1"></div></div>';

                // -- Check Pengajian Am (900) --
                var kodPA = String(d.kodmpl1 || "");
                var gredPA = String(d.gredmpl1 || "");

                if(kodPA == "900" && gredPA != "") {
                    html_list += '<div class="row" style="margin-top: 10px; border-bottom: 1px dashed #eee; padding-bottom: 5px;">';
                    html_list += '<div class="col-sm-7"><p class="form-control-static" style="margin-bottom:0;">PENGAJIAN AM/KERTAS AM</p>';
                    // PENTING: ID input hidden mesti sama dengan ID dropdown manual untuk elak error save_stpm
                    html_list += '<input type="hidden" name="mp_old[]" value="900"><input type="hidden" id="mp_10" name="mp_1[]" value="900"></div>';
                    html_list += '<div class="col-sm-3"><p class="form-control-static" style="font-weight:bold; margin-bottom:0;">'+gredPA+'</p>';
                    html_list += '<input type="hidden" id="gred_10" name="gred_1[]" value="'+gredPA+'"></div>';
                    html_list += '</div>';
                }

                // -- Loop Subjek Lain (2-5) --
                var slot_index = 1; // Untuk ID unik (mp_11, mp_12...)
                for (var i = 2; i <= 5; i++) {
                    var rawKod = d['kodmpl' + i];
                    var rawGred = d['gredmpl' + i];
                    
                    // -- PEMBETULAN: GUNA NAMA SISTEM DARI PHP --
                    // Backend anda return 'nama_sistem' dalam array.
                    // Oleh kerana struktur JSON integrated mungkin berbeza, 
                    // kita cari dalam array data matapelajaran jika structure backend anda hantar array object.
                    // ATAU jika backend hantar flat JSON (kodmpl2, namampl2), guna direct.
                    
                    // Kalau structure backend hantar: data: { kodmpl2: '910', namampl2: 'BM', ... }
                    var rawNama = d['namampl' + i] ? d['namampl' + i] : rawKod; 
                    
                    // JIKA backend anda return structure array "data": [{kod:'910', nama_sistem:'BM'}]
                    // Anda perlu ubah cara baca di sini. Tapi berdasarkan kod PHP FETCH_STPM anda, 
                    // anda flatten array tu. 
                    // Kalau PHP tak hantar 'namampl2', JS tak boleh tahu nama. 
                    // **PENTING:** PHP FETCH_STPM anda setakat ini cuma return kod. 
                    // Di bawah saya tambah logic fallback.
                    
                    if (rawKod != null && rawGred != null) {
                        var kodStr = String(rawKod).trim();
                        var gredStr = String(rawGred).trim();
                        
                        // Nama fallback = kod. Kalau integrasi API hantar nama, guna nama.
                        // Di PHP FETCH_STPM anda, pastikan anda hantar 'namamplX' atau modify array output.
                        // Jika dalam PHP anda buat loop mapping $mappedData[], JSON output adalah array [0..4].
                        // Ini bermakna d bukan flat object kodmpl1..5, tapi d ialah array objects.
                        
                        // **FIX LOGIC BACA JSON:**
                        // Jika FETCH_STPM return array of objects:
                        if(Array.isArray(d)){
                             // Cari object dalam array d yang kod == rawKod
                             var foundObj = d.find(o => o.kod == rawKod);
                             if(foundObj && foundObj.nama_sistem) {
                                 rawNama = foundObj.nama_sistem;
                             }
                        } else if(d['nama_sistem_mpl'+i]) {
                             // Jika flat object dan ada key nama
                             rawNama = d['nama_sistem_mpl'+i];
                        }

                        var namaStr = String(rawNama).trim();

                        if (kodStr !== "" && gredStr !== "") {
                            html_list += '<div class="row" style="margin-top: 10px; border-bottom: 1px dashed #eee; padding-bottom: 5px;">';
                            
                            html_list += '<div class="col-sm-7">';
                            html_list += '<p class="form-control-static" style="margin-bottom:0;">'+namaStr+'</p>';
                            html_list += '<input type="hidden" name="mp_old[]" value="'+kodStr+'">';
                            // PENTING: Tambah ID supaya save_stpm boleh baca (mp_11, mp_12)
                            html_list += '<input type="hidden" id="mp_1'+slot_index+'" name="mp_1[]" value="'+kodStr+'">';
                            html_list += '</div>';

                            html_list += '<div class="col-sm-3">';
                            html_list += '<p class="form-control-static" style="font-weight:bold; margin-bottom:0;">'+gredStr+'</p>';
                            // PENTING: Tambah ID supaya save_stpm boleh baca (gred_11, gred_12)
                            html_list += '<input type="hidden" id="gred_1'+slot_index+'" name="gred_1[]" value="'+gredStr+'">';
                            html_list += '</div>';
                            
                            html_list += '</div>';
                            slot_index++;
                        }
                    }
                }

                $('#container_subjek').html(html_list);
				save_stpm(1)
                // swal("Berjaya", "Data integrasi berjaya diperolehi.", "success");

            } else {
                // ... (Logic manual kekal sama) ...
                $('#is_integrasi_input').val('T');
                $('.divUpload').show();
                if(!$('#stpm_angka_giliran_1').is('input')){
                    location.reload();
                } else {
                    $('#stpm_angka_giliran_1').val('');
                    $('#gred_10').val('');
                    for(var k=1; k<=4; k++){ $('#mp_1'+k).val('').trigger('change'); $('#gred_1'+k).val(''); }
                    swal("Makluman", "Sila Isi Maklumat Yang Tepat.", "info");
                }
            }
        },
        error: function() {
            swal("Ralat", "Gagal menghubungi pelayan.", "error");
        }
    });
}
// Fungsi tambahan untuk reset/enable semula field
function reset_fields_stpm() {
    // Enable semula input
    $('#stpm_angka_giliran_1').attr('readonly', false).val('');
    
    // Enable semula dropdown-dropdown
    $('#gred_10').attr('disabled', false).val('').trigger('change');
    
    for (var i = 1; i <= 4; i++) {
        $('#mp_1' + i).attr('disabled', false).val('').trigger('change');
        $('#gred_1' + i).attr('disabled', false).val('').trigger('change');
    }
}

$(document).ready(function() {
    // Periksa jika input Angka Giliran atau Gred PA sudah mempunyai nilai semasa halaman dibuka
    var akg = $('#stpm_angka_giliran_1').val();
    var gredPA = $('#gred_10').val();

    if (akg !== "" || gredPA !== "") {
        // Tunjukkan divManual jika ada data
        $('.divManual').show();
        
        // Kunci field yang sudah ada data supaya user tak ubah sesuka hati
        // (Sama seperti logik selepas panggil API)
        if(akg !== "") $('#stpm_angka_giliran_1').attr('readonly', true);
        if(gredPA !== "") $('#gred_10').attr('disabled', true);

        // Kunci juga 4 matapelajaran lain jika sudah ada nilai
        for (var i = 1; i <= 4; i++) {
            if ($('#mp_1' + i).val() !== "") {
                $('#mp_1' + i).attr('disabled', true);
                $('#gred_1' + i).attr('disabled', true);
            }
        }
    }
});
</script>		 
