<?php

// print $id_pemohon;
// print_r($data);

$rsCalon = get_calon($conn, $id_pemohon);
?>

<small style="color: red;">
    Tarikh dikemskini : <?=DisplayDate($rsCalon->fields['d_kemaskini']);  print '&nbsp;&nbsp;'.DisplayMasa($rsCalon->fields['d_kemaskini']);?> <br>
    Maklumat Calon adalah maklumat peribadi calon<br><br>
</small>

<header class="panel-heading"  style="background-color:rgb(38, 167, 228)">
    <h6 class="panel-title"><font color="#000000" size="3"><b>MAKLUMAT CALON</b></font></h6>
</header>
<div class="panel-body">
    <div class="box-body">
        <div class="col-md-12">
            <div class="form-group">
                <div class="row">
                <div class="col-md-9">
                    <div class="form-group">
                        <div class="row">
                            <label for="nama" class="col-sm-4 control-label"><b>No. Kad Pengenalan<div style="float:right">:</div></b></label>
                            <div class="col-sm-8"><?=$rsCalon->fields['ICNo'];?></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label for="nama" class="col-sm-4 control-label"><b>Nama Penuh<div style="float:right">:</div></b></label>
                            <div class="col-sm-8"><?php print $rsCalon->fields['nama_penuh'];?></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label for="nama" class="col-sm-4 control-label"><b>Tarikh Lahir<div style="float:right">:</div></b></label>
                            <div class="col-sm-8"><?=DisplayDate($rsCalon->fields['dob'])?></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label for="nama" class="col-sm-4 control-label"><b>Alamat Surat Menyurat<div style="float:right">:</div></b></label>
                            <div class="col-sm-8">
                                <?=$rsCalon->fields['addr1']?> <br>
                                <?=$rsCalon->fields['addr2']?> <br>
                                <?=$rsCalon->fields['addr3']?> 
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label for="nama" class="col-sm-4 control-label"></label>
                            <div class="col-sm-8">
                                
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="col-sm-12" align="center">
                        <img src="../images/person.jpg" width="130" height="150">
                    </div>
                </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <label for="nama" class="col-sm-3 control-label"><b>Poskod<div style="float:right">:</div></b></label>
                    <div class="col-sm-3">
                        <?=$rsCalon->fields['poskod']?>
                    </div>
                    <label for="nama" class="col-sm-3 control-label"><b>Bandar <font color="#FF0000">*</font><div style="float:right">:</div></b></label>
                    <div class="col-sm-3">
                        <?=$rsCalon->fields['bandar']?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label for="nama" class="col-sm-3 control-label"><b>Negeri <font color="#FF0000">*</font><div style="float:right">:</div></b></label>
                    <div class="col-sm-3">
                        <?=$rsCalon->fields['diskripsi']?>
                    </div>
                    
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label for="nama" class="col-sm-3 control-label"><b>No. Telefon <font color="#FF0000">*</font><div style="float:right">:</div></b></label>
                    <div class="col-sm-3">
                        <?=$rsCalon->fields['no_tel']?>
                    </div>   
                    <label for="nama" class="col-sm-3 control-label"><b>Alamat Emel <font color="#FF0000">*</font><div style="float:right">:</div></b></label>
                    <div class="col-sm-3">
                        <?=$rsCalon->fields['e_mail']?>
                    </div>
                </div>
            </div>

            <hr>
            <div class="form-group">
                <div class="row">
                    <label for="nama" class="col-sm-3 control-label"><b>Negeri Tempat Lahir<div style="float:right"></div></b></label>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label for="nama" class="col-sm-3 control-label"><b>Pemohon<div style="float:right">:</div></b></label>
                    <div class="col-md-3">
                        <?=$rsCalon->fields['negeriLahirPemohon']?>
                    </div>
                    <label for="nama" class="col-sm-3 control-label"><b>Taraf Perkahwinan <font color="#FF0000">*</font><div style="float:right">:</div></b></label>
                    <div class="col-sm-3">
                        <?=$rsCalon->fields['taraf_kawin']?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label for="nama" class="col-sm-3 control-label"><b>Ibu Pemohon<font color="#FF0000">*</font><div style="float:right">:</div></b></label>
                    <div class="col-sm-3">
                        <?=$rsCalon->fields['negeriLahirIbu']?>
                    </div>
                    <label for="nama" class="col-sm-3 control-label"><b>Ketinggian (meter) <font color="#FF0000">*</font><div style="float:right">:</div></b></label>
                    <div class="col-sm-3">
                        <?=$rsCalon->fields['ketinggian']?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label for="nama" class="col-sm-3 control-label"><b>Bapa Pemohon<font color="#FF0000">*</font><div style="float:right">:</div></b></label>
                    <div class="col-sm-3">
                        <?=$rsCalon->fields['negeriLahirBapa']?>
                    </div>
                    
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label for="nama" class="col-sm-3 control-label"><b>Lesen Kenderaan <div style="float:right">:</div></b></label>
                    <div class="col-sm-3">
                        <?=$rsCalon->fields['lesen_kenderaan']?>
                    </div>
                    
                </div>
            </div>	

            <div class="form-group">
                <div class="row">
                    <label for="nama" class="col-sm-11 control-label"><b>Adakah anda sedang berkhidmat dalam Perkhidmatan Awam / Kerajaan Tempatan / Badan Berkanun / Polis? <font color="#FF0000">*</font><div style="float:right">:</div></b></label>
                    <div class="col-sm-1">
                        Ya
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>