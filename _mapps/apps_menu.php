<link rel="stylesheet" href="../css/steps_flow.css" />
<?php 
include 'biodata/sql_biodata.php';
// print $module;
if($module=='MAKLUMAT PEMOHON'){
  $btn1 = "completed"; $btn2 = ""; $btn3 = ""; $btn4 = ""; $btn5 = ""; $btn6 = ""; $btn7 = ""; $btn8 = ""; 
  $font1 = "font-weight: bold;"; $font2 = ""; $font3 = ""; $font4 = ""; $font5 = ""; $font6 = ""; $font7 = ""; $font8 = ""; 
} else if($module=='PEGAWAI SEDANG BERKHIDMAT'){
  $btn1 = "completed"; $btn2 = ""; $btn3 = ""; $btn4 = ""; $btn5 = ""; $btn6 = ""; $btn7 = "completed"; $btn8 = ""; 
  $font1 = ""; $font2 = ""; $font3 = ""; $font4 = ""; $font5 = ""; $font6 = ""; $font7 = "font-weight: bold;"; $font8 = ""; 

} else if($module=='MAKLUMAT AKADEMIK'){
  $btn1 = "completed"; $btn2 = "completed"; $btn3 = ""; $btn4 = ""; $btn5 = ""; $btn6 = ""; $btn7 = "completed"; $btn8 = ""; 
  $font1 = ""; $font2 = "font-weight: bold;"; $font3 = ""; $font4 = ""; $font5 = ""; $font6 = ""; $font7 = ""; $font8 = ""; 
} else if($module=='MAKLUMAT BUKAN AKADEMIK'){
  $btn1 = "completed"; $btn2 = "completed"; $btn3 = "completed"; $btn4 = ""; $btn5 = ""; $btn6 = ""; $btn7 = "completed"; $btn8 = ""; 
  $font1 = ""; $font2 = ""; $font3 = "font-weight: bold;"; $font4 = ""; $font5 = ""; $font6 = ""; $font7 = ""; $font8 = ""; 
} else if($module=='MAKLUMAT TAMBAHAN'){
  $btn1 = "completed"; $btn2 = "completed"; $btn3 = "completed"; $btn4 = "completed"; $btn5 = ""; $btn6 = ""; $btn7 = "completed"; $btn8 = ""; 
  $font1 = ""; $font2 = ""; $font3 = ""; $font4 = "font-weight: bold;"; $font5 = ""; $font6 = ""; $font7 = ""; $font8 = ""; 
} else if($module=='JAWATAN DIMOHON'){
  $btn1 = "completed"; $btn2 = "completed"; $btn3 = "completed"; $btn4 = "completed"; $btn5 = "completed"; $btn6 = ""; $btn7 = "completed"; $btn8 = ""; 
  $font1 = ""; $font2 = ""; $font3 = ""; $font4 = ""; $font5 = "font-weight: bold;"; $font6 = ""; $font7 = ""; $font8 = ""; 
} else if($module=='SELEASI'){
  $btn1 = "completed"; $btn2 = "completed"; $btn3 = "completed"; $btn4 = "completed"; $btn5 = "completed"; $btn6 = "completed"; $btn7 = "completed"; $btn8 = "";
  $font1 = ""; $font2 = ""; $font3 = ""; $font4 = ""; $font5 = ""; $font6 = "font-weight: bold;"; $font7 = ""; $font8 = ""; 
} else if($module=='PERAKUAN PEMOHON'){
  $btn1 = "completed"; $btn2 = "completed"; $btn3 = "completed"; $btn4 = "completed"; $btn5 = "completed"; $btn6 = "completed"; $btn7 = "completed"; $btn8 = "completed"; 
  $font1 = ""; $font2 = ""; $font3 = ""; $font4 = ""; $font5 = ""; $font6 = ""; $font7 = ""; $font8 = "font-weight: bold;"; 
}

// $conn->debug=true;
$rsTkh = $conn->query("SELECT * FROM $schema2.`calon_tarikh` WHERE `id_pemohon`=".tosql($_SESSION['SESS_UID']));
// print_r($rsTkh);
// print "AW:".$is_awam;
$getGambar = get_gambar($conn,$_SESSION['SESS_UID']);
if(!empty($getGambar['gambar'])){
    $gambar = "../uploads_doc/".$_SESSION['SESS_UID']."/".$getGambar['gambar'];
} else { $gambar= '../images/person.jpg'; }

$bil=1;
?>

<?php if($module =='MAKLUMAT PEMOHON' || $module=='MAKLUMAT AKADEMIK' || $module=='MAKLUMAT BUKAN AKADEMIK' || $module=='MAKLUMAT TAMBAHAN' || $module=='JAWATAN DIMOHON' || $module=='SELEASI' || $module=='PEGAWAI SEDANG BERKHIDMAT' || $module=='PERAKUAN PEMOHON'){ ?>
    <div class="stepper-wrapper" style="margin-bottom: -10px;">
    <div class="stepper-item <?=$btn1;?>">
        <a href="index.php?data=<?php print base64_encode('biodata/biodata;MAKLUMAT PEMOHON;;;;;'); ?>">
        <div class="step-counter" style="color: #000;" title="Maklumat Pemohon"><b><?=$bil++;?></b></div></a>
        <div class="step-name visible-lg visible-md" style="text-align: center;<?=$font1;?>">Maklumat Pemohon</div>
        <div class="visible-lg visible-md"><?php if(!empty($rsTkh->fields['tkh_upd_biodata'])){ print DisplayDate($rsTkh->fields['tkh_upd_biodata']); } ?></div>
    </div>
    <?php if($is_awam=='Y'){ ?>
    <div class="stepper-item <?=$btn7;?>">
        <a href="index.php?data=<?php print base64_encode('biodata/khidmat;PEGAWAI SEDANG BERKHIDMAT;Maklumat Pengalaman Bekerja di Sektor Awam;;;;'); ?>">
        <div class="step-counter" style="color: #000;" title="Maklumat Perkhidmatan Awam"><b><?=$bil++;?></b></div></a>
        <div class="step-name visible-lg visible-md" style="text-align: center;<?=$font7;?>">Maklumat Perkhidmatan Awam</div>
        <div class="visible-lg visible-md"><?php if(!empty($rsTkh->fields['tkh_upd_awam'])){ print DisplayDate($rsTkh->fields['tkh_upd_awam']); } ?></div>
    </div>
    <?php } ?>
    <div class="stepper-item <?=$btn2;?>">
        <a href="index.php?data=<?php print base64_encode('akademik/pmr;MAKLUMAT AKADEMIK;Maklumat PT3/PMR/SRP;;;;'); ?>">
        <div class="step-counter" style="color: #000;" title="Maklumat Akademik"><b><?=$bil++;?></b></div></a>
        <div class="step-name visible-lg visible-md" style="text-align: center;<?=$font2;?>">Maklumat Akademik</div>
        <div class="visible-lg visible-md"><?php if(!empty($rsTkh->fields['tkh_upd_akademik'])){ print DisplayDate($rsTkh->fields['tkh_upd_akademik']); } ?></div>
    </div>
    <div class="stepper-item <?=$btn3;?>">
        <a href="index.php?data=<?php print base64_encode('koku/sukan;MAKLUMAT BUKAN AKADEMIK;Maklumat Sukan/Persatuan;ALL;;;'); ?>">
        <div class="step-counter" style="color: #000;" title="Maklumat Bukan Akademik"><b><?=$bil++;?></b></div></a>
        <div class="step-name visible-lg visible-md" style="text-align: center;<?=$font3;?>">Maklumat Bukan Akademik</div>
        <div class="visible-lg visible-md"><?php if(!empty($rsTkh->fields['tkh_upd_koko'])){ print DisplayDate($rsTkh->fields['tkh_upd_koko']); } ?></div>
    </div>
    <!-- AKAN DIPAPARKAN JIKA PEMOHON ADALAH KAKITANGAN AWAM -->
    <!-- <div class="stepper-item <?=$btn4;?>">
        <a href="index.php?data=<?php print base64_encode('tambahan/bakat;MAKLUMAT TAMBAHAN;Maklumat Bakat / Kebolehan / Bahasa;ALL;;;'); ?>">
        <div class="step-counter" style="color: #000;" title="Maklumat Tambahan"><b><?//=$bil++;?></b></div></a>
        <div class="step-name visible-lg visible-md" style="text-align: center;<?=$font4;?>">Maklumat Tambahan</div>
        <div class="visible-lg visible-md"><?php if(!empty($rsTkh->fields['tkh_upd_tambahan'])){ print DisplayDate($rsTkh->fields['tkh_upd_tambahan']); } ?></div>
    </div> -->
    <div class="stepper-item <?=$btn5;?>">
        <a href="index.php?data=<?php print base64_encode('biodata/jawatan;JAWATAN DIMOHON;Maklumat Jawatan Dimohon;;;;'); ?>">
        <div class="step-counter" style="color: #000;" title="Jawatan Dimohon"><b><?=$bil++;?></b></div></a>
        <div class="step-name visible-lg visible-md" style="text-align: center;<?=$font5;?>">Jawatan Dimohon</div>
        <div class="visible-lg visible-md"><?php if(!empty($rsTkh->fields['tkh_upd_jawatan'])){ print DisplayDate($rsTkh->fields['tkh_upd_jawatan']); } ?></div>
    </div>
    <div class="stepper-item <?=$btn8;?>">
        <a href="index.php?data=<?php print base64_encode('biodata/perakuan;PERAKUAN PEMOHON;Semakan Maklumat Peribadi Pemohon;;;;'); ?>">
        <div class="step-counter" style="color: #000;" title="Maklumat Pemohon"><b><?=$bil++;?></b></div></a>
        <div class="step-name visible-lg visible-md" style="text-align: center;<?=$font8;?>">Perakuan Pemohon</div>
        <div class="visible-lg visible-md"><?php if(!empty($rsTkh->fields['tkh_upd_perakuan'])){ print DisplayDate($rsTkh->fields['tkh_upd_perakuan']); } ?></div>
    </div>
    </div>
<?php } ?>

<?php
 if($pages!='akademik/spm'){

    $_SESSION['SESS_SPMSIJIL']="";
    $_SESSION['SESS_SPMTAHUN']="";

    $_SESSION['SESS_SPMSIJIL2']="";
    $_SESSION['SESS_SPMTAHUN2']="";
    // $_SESSION['SESS_SPMSIJIL']="";
    // $_SESSION['SESS_SPMTAHUN']="";
 }
?>