<?php

// print $id_pemohon;
// print_r($data);

$rsMyid = get_myid($conn, $id_pemohon);
?>

<small style="color: red;">
    Tarikh dikemaskini : <?=DisplayDate($rsMyid->fields['d_upd']);  print '&nbsp;&nbsp;'.DisplayMasa($rsMyid->fields['d_upd']);?> <br>
    Maklumat MYID digunakan untuk tujuan Log Masuk ke Sistem MySPP<br><br>
</small>

<header class="panel-heading"  style="background-color:rgb(38, 167, 228)">
    <h6 class="panel-title"><font color="#000000" size="3"><b>MAKLUMAT MYID</b></font></h6>
</header>
<div class="panel-body">
    <div class="box-body">
        <div class="col-md-12">

            <div class="form-group">
                <div class="row">
                    <label for="nama" class="col-sm-3 control-label"><b>No. Kad Pengenalan<div style="float:right">:</div></b></label>
                    <div class="col-sm-9"><?=$rsMyid->fields['ICNo']?></div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label for="nama" class="col-sm-3 control-label"><b>Nama Penuh<div style="float:right">:</div></b></label>
                    <div class="col-sm-9"><?=$rsMyid->fields['nama']?></div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label for="nama" class="col-sm-3 control-label"><b>Alamat<div style="float:right">:</div></b></label>
                    <div class="col-sm-9">
                        <?=$rsMyid->fields['addr1']?> <br>
                        <?=$rsMyid->fields['addr2']?> <br>
                        <?=$rsMyid->fields['addr3']?> 
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label for="nama" class="col-sm-3 control-label"></label>
                    <div class="col-sm-9">
                        
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label for="nama" class="col-sm-3 control-label"><b>Poskod<div style="float:right">:</div></b></label>
                    <div class="col-sm-9">
                        <?=$rsMyid->fields['poskod']?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label for="nama" class="col-sm-3 control-label"><b>Bandar<div style="float:right">:</div></b></label>
                    <div class="col-sm-9">
                        <?=$rsMyid->fields['bandar']?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label for="nama" class="col-sm-3 control-label"><b>Negeri<div style="float:right">:</div></b></label>
                    <div class="col-sm-9">
                        <?=$rsMyid->fields['diskripsi']?>
                    </div>
                    
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label for="nama" class="col-sm-3 control-label"><b>No. Telefon<div style="float:right">:</div></b></label>
                    <div class="col-sm-9">
                        <?=$rsMyid->fields['notel']?>
                    </div>   
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <label for="nama" class="col-sm-3 control-label"><b>Emel<div style="float:right">:</div></b></label>
                    <div class="col-sm-9">
                        <?=$rsMyid->fields['emel']?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label for="nama" class="col-sm-3 control-label"><b>Nama Ibu<div style="float:right">:</div></b></label>
                    <div class="col-sm-9">
                        Aminah
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label for="nama" class="col-sm-3 control-label"><b>Negeri Kelahiran <div style="float:right">:</div></b></label>
                    <div class="col-md-3">
                        <?=$rsMyid->fields['negeriLahirPemohon']?>
                    </div>
                </div>
            </div>	

            <div class="form-group">
                <div class="row">
                    <label for="nama" class="col-sm-3 control-label"><b>Tarikh Daftar<div style="float:right">:</div></b></label>
                    <div class="col-sm-9"><?=DisplayDate($rsMyid->fields['d_create']);  print '&nbsp;&nbsp;'.DisplayMasa($rsMyid->fields['d_create']);?></div>
                </div>
            </div>
        </div>
    </div>
</div>