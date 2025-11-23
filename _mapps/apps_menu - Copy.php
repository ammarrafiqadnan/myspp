<link rel="s tylesheet" href="../css/steps_flow.css" />
<?php 
if($module== 'MAKLUMAT PEMOHON'){
  $btn1 = "completed"; $btn2 = ""; $btn3 = ""; $btn4 = ""; $btn5 = ""; $btn6 = ""; $btn7 = ""; $btn8 = ""; 
  $font1 = "font-weight: bold;"; $font2 = ""; $font3 = ""; $font4 = ""; $font5 = ""; $font6 = ""; $font7 = ""; $font8 = ""; 
} else if($module=='MAKLUMAT AKADEMIK'){
  $btn1 = "completed"; $btn2 = "completed"; $btn3 = ""; $btn4 = ""; $btn5 = ""; $btn6 = ""; $btn7 = ""; $btn8 = ""; 
  $font1 = ""; $font2 = "font-weight: bold;"; $font3 = ""; $font4 = ""; $font5 = ""; $font6 = ""; $font7 = ""; $font8 = ""; 
} else if($module=='MAKLUMAT KOKU'){
  $btn1 = "completed"; $btn2 = "completed"; $btn3 = "completed"; $btn4 = ""; $btn5 = ""; $btn6 = ""; $btn7 = ""; $btn8 = ""; 
  $font1 = ""; $font2 = ""; $font3 = "font-weight: bold;"; $font4 = ""; $font5 = ""; $font6 = ""; $font7 = ""; $font8 = ""; 
} else if($module=='MAKLUMAT TAMBAHAN'){
  $btn1 = "completed"; $btn2 = "completed"; $btn3 = "completed"; $btn4 = "completed"; $btn5 = ""; $btn6 = ""; $btn7 = "completed"; $btn8 = ""; 
  $font1 = ""; $font2 = ""; $font3 = ""; $font4 = "font-weight: bold;"; $font5 = ""; $font6 = ""; $font7 = ""; $font8 = ""; 
} else if($module=='JAWATAN DIPOHON'){
  $btn1 = "completed"; $btn2 = "completed"; $btn3 = "completed"; $btn4 = "completed"; $btn5 = "completed"; $btn6 = ""; $btn7 = "completed"; $btn8 = ""; 
  $font1 = ""; $font2 = ""; $font3 = ""; $font4 = ""; $font5 = "font-weight: bold;"; $font6 = ""; $font7 = ""; $font8 = ""; 
} else if($module=='SELEASI'){
  $btn1 = "completed"; $btn2 = "completed"; $btn3 = "completed"; $btn4 = "completed"; $btn5 = "completed"; $btn6 = "completed"; $btn7 = "completed"; $btn8 = ""; 
  $font1 = ""; $font2 = ""; $font3 = ""; $font4 = ""; $font5 = ""; $font6 = "font-weight: bold;"; $font7 = ""; $font8 = ""; 
} else if($module=='PEGAWAI SEDANG BERKHIDMAT'){
  $btn1 = "completed"; $btn2 = "completed"; $btn3 = "completed"; $btn4 = ""; $btn5 = ""; $btn6 = ""; $btn7 = "completed"; $btn8 = ""; 
  $font1 = ""; $font2 = ""; $font3 = ""; $font4 = ""; $font5 = ""; $font6 = ""; $font7 = "font-weight: bold;"; $font8 = ""; 
} else if($module=='PERAKUAN PEMOHON'){
  $btn1 = "completed"; $btn2 = "completed"; $btn3 = "completed"; $btn4 = "completed"; $btn5 = "completed"; 
  $btn6 = "completed"; $btn7 = "completed"; $btn8 = "completed"; 
  $font1 = ""; $font2 = ""; $font3 = ""; $font4 = ""; $font5 = ""; $font6 = ""; $font7 = ""; $font8 = "font-weight: bold;"; 
}

$bil=1;
?>

<div class="stepper-wrapper">
  <div class="stepper-item <?=$btn1;?>">
    <a href="index.php?p=<?php print base64_encode('Perlesenan;Perlesenan Permohonan Baru;fpelesenan/lesen_baru_form1;;'); ?>">
    <div class="step-counter" style="color: #000;"><b><?=$bil++;?></b></div></a>
    <div class="step-name" style="text-align: center;<?=$font1;?>">Maklumat<br>Pemohon</div>
  </div>
  <div class="stepper-item <?=$btn2;?>">
    <div class="step-counter"><?=$bil++;?></div>
    <div class="step-name" style="text-align: center;<?=$font2;?>">Maklumat<br>Akademik</div>
  </div>
  <div class="stepper-item <?=$btn3;?>">
    <div class="step-counter"><b><?=$bil++;?></b></div>
    <div class="step-name" style="text-align: center;<?=$font3;?>">Maklumat<br>Ko-Kurikulum</div>
  </div>
  <div class="stepper-item <?=$btn7;?>">
    <div class="step-counter"><?=$bil++;?></div>
    <div class="step-name" style="text-align: center;<?=$font7;?>">Maklumat<br>Perkhidmatan Awam</div>
  </div>
  <div class="stepper-item <?=$btn4;?>">
    <div class="step-counter"><?=$bil++;?></div>
    <div class="step-name" style="text-align: center;<?=$font4;?>">Maklumat<br>Tambahan</div>
  </div>
  <div class="stepper-item <?=$btn5;?>">
    <div class="step-counter"><?=$bil++;?></div>
    <div class="step-name" style="text-align: center;<?=$font5;?>">Jawatan<br>Dipohon</div>
  </div>
  <div class="stepper-item <?=$btn8;?>">
    <div class="step-counter"><?=$bil++;?></div>
    <div class="step-name" style="text-align: center;<?=$font8;?>">Perakuan<br>Pemohon</div>
  </div>
</div>