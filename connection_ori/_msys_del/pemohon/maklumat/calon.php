<?php
// $conn->debug=true;
// print $id_pemohon;
// print_r($data);

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
                        
                        <?php
                            global $schema2;
                            //$conn->debug=true;
                            $sql3 = "SELECT * FROM $schema2.`calon_gambar` WHERE id_pemohon=".tosql($rsCalon->fields['id_pemohon']);
                            $rs3 = $conn->query($sql3);

                            if(!empty($rs3->fields['gambar'])){
                                $gambar = "../uploads_doc/".$rsCalon->fields['id_pemohon']."/".$rs3->fields['gambar'];
                            } else { $gambar= '../images/person.jpg'; }
                        ?>
                        <img src="<?=$gambar?>" width="130" height="150">
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
                    <label for="nama" class="col-sm-3 control-label"><b>Bapa Pemohon<font color="#FF0000">*</font><div style="float:right">:</div></b></label>
                    <div class="col-sm-3">
                        <?=$rsCalon->fields['negeriLahirBapa']?>
                    </div>
                    
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    
                    <label for="nama" class="col-sm-3 control-label"><b>Ketinggian (meter) <font color="#FF0000">*</font><div style="float:right">:</div></b></label>
                    <div class="col-sm-2">
                        <?=$rsCalon->fields['ketinggian'];?>
                    </div>

                    <div class="col-sm-2"></div>
                    <label for="nama" class="col-sm-2 control-label"><b>Berat (KG) <font color="#FF0000">*</font><div style="float:right">:</div></b></label>
                    <div class="col-sm-2">
                        <?=$rsCalon->fields['berat'];?>
                    </div>
                    
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label for="nama" class="col-sm-3 control-label"><b>BMI <font color="#FF0000">*</font><div style="float:right">:</div></b></label>
                    <?php
                        $HInches = ($rsCalon->fields['ketinggian'])*39.3700787;
                        /*Convert kg to pound*/
                        $WPound = ($rsCalon->fields['berat'])*2.2;
                        $BMIIndex = round($WPound/($HInches*$HInches)* 703,2);
        
                        /*Set Message*/
                        if ($BMIIndex < 18.5) {
                                $Message="Kurang berat badan";
                        } else if ($BMIIndex <= 24.9) {
                                $Message="Mempunyai berat badan unggul";
                        } else if ($BMIIndex <= 29.9) {
                                $Message="Berlebihan berat badan";
                        } else {
                                $Message="Obesiti";
                        }

                        
                    ?>
                    <div class="col-sm-3">
                        <?php  print $BMIIndex.' ('.$Message.')';?>
                    </div>
                    <label for="nama" class="col-sm-3 control-label"><b>Lesen Kenderaan <font color="#FF0000">*</font><div style="float:right">:</div></b></label>
                    <div class="col-sm-3">
                        <?=$rsCalon->fields['lesen_kenderaan']?>
                    </div>
                </div>
            </div>	

            <div class="form-group">
                <div class="row">
                        <ul>
                            <li>Untuk diisi oleh Orang Kurang Upaya (OKU) sahaja.</li>
                        </ul>
                    </label>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label for="nama" class="col-sm-3 control-label"><b>Jenis Kurang Upaya  <div style="float:right">:</div></b></label>
                    <div class="col-sm-3">
                        <?php
                            if(!empty($rsCalon->fields['oku'])){
                                global $schema1;
                                //$conn->debug=true;
                                $sql2 = "SELECT * FROM $schema1.`ref_kecacatan_calon` WHERE KOD=".tosql($rsCalon->fields['oku']);
                                $rs2 = $conn->query($sql2);
                                
                        
                                print $rs2->fields['DISKRIPSI']; 
                            } else {
                                print '-';
                            }
                        ?>
                    </div>
                    <div class="col-sm-1"></div>
                    <label for="nama" class="col-sm-2 control-label"><b>No.Pendaftaran OKU <div style="float:right">:</div></b></label>
                    <div class="col-sm-2">
                        <?php
                            if(!empty($rsCalon->fields['no_rujukan_oku'])){
                                print $rsCalon->fields['no_rujukan_oku']; 
                            } else {
                                print '-';
                            }
                        ?>
                        
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                        <ul>
                            <li>Isikan sekiranya ibu/bapa/pemohon menerima bantuan Program Kesejahteraan Rakyat / Bantuan Kebajikan Masyarakat / Program Perumahan Rakyat.</li>
                        </ul>
                    </label>
                </div>
            </div>
        
            <div class="form-group">
                <div class="row">
                    <label for="nama" class="col-sm-3 control-label"><b>Jenis Bantuan <div style="float:right">:</div></b></label>
                    <div class="col-sm-3">
                        <?php
                            if(!empty($rsCalon->fields['bantuan'])){
                                global $schema1;
                                //$conn->debug=true;
                                $sql2 = "SELECT * FROM $schema1.`ref_bantuan` WHERE kod_bantuan=".tosql($rsCalon->fields['bantuan']);
                                $rs2 = $conn->query($sql2);
                                
                        
                                print $rs2->fields['bantuan']; 
                            } else {
                                print '-';
                            }
                        ?>
                    </div>
                    <div class="col-sm-1"></div>
                    <label for="nama" class="col-sm-2 control-label"><b>No.Pendaftaran Bantuan <div style="float:right">:</div></b></label>
                    <div class="col-sm-3">
                        <?php
                            if(!empty($rsCalon->fields['no_rujukan_bantuan'])){
                                print $rsCalon->fields['no_rujukan_bantuan']; 
                            } else {
                                print '-';
                            }
                        ?>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <label for="nama" class="col-sm-11 control-label"><b>Adakah anda sedang berkhidmat dalam Perkhidmatan Awam / Kerajaan Tempatan / Badan Berkanun / Polis? <font color="#FF0000">*</font><div style="float:right">:</div></b></label>
                    <div class="col-sm-1">
                        <?php if($rsCalon->fields['masih_khidmat']=='Y'){ print 'Ya'; } else { print 'Tidak'; }?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>