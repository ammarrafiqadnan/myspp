<?php //include '../connection/common.php'; ?>

<link href="vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
<link href="vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
<link href="vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
<link href="vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">
<script>
    function sortorder(href){
        // alert('sini');
        
        var dt_kemaskini = $('#dt_kemaskini').val();
        var jantina = $('#jantina').val();
        var umur1 = $('#umur1').val();
        var umur2 = $('#umur2').val();
        var bangsa = $('#bangsa').val();
        var oku = $('#oku').val();
        var tentera = $('#tentera').val();
        var zon = $('#zon').val();
        var negeri = $('#negeri').val();
        var pusat_temuduga = $('#pusat_temuduga').val();
        var peringkat_kelulusan = $('#peringkat_kelulusan').val();
        var univ = $('#univ').val();
        var pengkhususan = $('#pengkhususan').val();
        var kluster = $('#kluster').val();
        var cgpa1 = $('#cgpa1').val();
        var cgpa2 = $('#cgpa2').val();
        var skim = $('#skim').val();
        var status = $('#status').val();


        window.location.href = href+"&dt_kemaskini="+dt_kemaskini+"&jantina="+jantina+'&umur1='+umur1+'&umur2='+umur2+'&bangsa='+bangsa+'&oku='+oku+'&tentera='+tentera+'&zon='+zon+'&negeri='+negeri+'&pusat_temuduga='+pusat_temuduga+'&peringkat_kelulusan='+peringkat_kelulusan+'&univ='+univ+'&pengkhususan='+pengkhususan+'&kluster='+kluster+'&cgpa1='+cgpa1+'&cgpa2='+cgpa2+'&skim='+skim+'&status='+status;
        
        
        // return sorturl;
    }
</script>

<?php
$JFORM='LIST';
$dt_kemaskini=isset($_REQUEST["dt_kemaskini"])?$_REQUEST["dt_kemaskini"]:"";
$jantina=isset($_REQUEST["jantina"])?$_REQUEST["jantina"]:"";
$umur1=strtoupper(isset($_REQUEST["umur1"])?$_REQUEST["umur1"]:"");
$umur2=strtoupper(isset($_REQUEST["umur2"])?$_REQUEST["umur2"]:"");
$bangsa=strtoupper(isset($_REQUEST["bangsa"])?$_REQUEST["bangsa"]:"");
$oku=strtoupper(isset($_REQUEST["oku"])?$_REQUEST["oku"]:"");
$tentera=strtoupper(isset($_REQUEST["tentera"])?$_REQUEST["tentera"]:"");
$zon=strtoupper(isset($_REQUEST["zon"])?$_REQUEST["zon"]:"");
$negeri=strtoupper(isset($_REQUEST["negeri"])?$_REQUEST["negeri"]:"");
$pusat_temuduga=strtoupper(isset($_REQUEST["pusat_temuduga"])?$_REQUEST["pusat_temuduga"]:"");
$peringkat_kelulusan=strtoupper(isset($_REQUEST["peringkat_kelulusan"])?$_REQUEST["peringkat_kelulusan"]:"");
$univ=strtoupper(isset($_REQUEST["univ"])?$_REQUEST["univ"]:"");
$pengkhususan=strtoupper(isset($_REQUEST["pengkhususan"])?$_REQUEST["pengkhususan"]:"");
$kluster=strtoupper(isset($_REQUEST["kluster"])?$_REQUEST["kluster"]:"");
$cgpa1=strtoupper(isset($_REQUEST["cgpa1"])?$_REQUEST["cgpa1"]:"");
$cgpa2=strtoupper(isset($_REQUEST["cgpa2"])?$_REQUEST["cgpa2"]:"");
$skim=strtoupper(isset($_REQUEST["skim"])?$_REQUEST["skim"]:"");
$status=strtoupper(isset($_REQUEST["status"])?$_REQUEST["status"]:"");

$hrefs = 'index.php?data='.base64_encode('laporan/keseluruhan_data;Laporan;Laporan Keseluruhan Data;ALL;;;');
//$conn->debug=true;
$sql = "SELECT COUNT(*) as total FROM $schema2.`calon` A WHERE A.ICNo IS NOT NULL"; 

if(!empty($dt_kemaskini)){
    $sql .= " AND (date(A.d_kemaskini) LIKE '%".$dt_kemaskini."%')";
}

if(!empty($jantina)){
    $sql .= " AND A.jantina=".tosql($jantina);
}

// if(!empty($carian)){
//     $sql .= " AND (A.tajuk  LIKE '%".$carian."%')";
// }
$rs = $conn->query($sql);
$conn->debug=false;

?>
<div class="box" style="background-color:#F2F2F2">

    <div class="box-body">
        <input type="hidden" name="id" value="" />
        <div class="x_panel">
            <header class="panel-heading"  style="background-color:rgb(38, 167, 228)">
                <h6 class="panel-title"><font color="#000000" size="3"><b><?php print strtoupper($menu);?></b></font></h6>
            </header>
        </div>
    </div>            
    <br />
    <div class="box-body d-print-none" style="height: 40px;background-color:#F2F2F2;">
        <div class="row">
            <label for="tajuk" class="col-sm-2 control-label">Tajuk Hebahan <font color="#FF0000">*</font> :</label>
            <div class="col-sm-10">
            <?php
                    $sql3 = "SELECT * FROM $schema2.`hebahan_makluman` WHERE `status`=0 AND `is_deleted`=0";
                    $rsHebahan = $conn->query($sql3);
                ?>
                <select name="kluster" id="kluster" class="form-control">
                    <option value="">Sila pilih</option>
                    <?php while(!$rsHebahan->EOF){ $hebahan_code = $rsHebahan->fields['kod']; ?>    
                        <option value="<?=$hebahan_code;?>" ><?php print $rsHebahan->fields['tajuk'];?></option>
                    <?php $rsHebahan->movenext(); } ?>
                </select>
            </div>
        </div>
    </div>  
    <div class="box-body d-print-none" style="height: 40px;background-color:#F2F2F2;">
        <div class="row">
            <div class="col-md-2">
                <label for="">Tarikh Kemas kini : </label>
            </div>
            <div class="col-md-2">
                <input type="date" class="form-control" id="dt_kemaskini"  name="dt_kemaskini" value="<?=$dt_kemaskini;?>">
            </div> 
            <div class="col-md-1">
                <label for="">Jantina : </label>
            </div>
            <div class="col-md-2">
                <select name="jantina" id="jantina" class="form-control">
                    <option value="">Sila pilih</option>
                    <option value="1" <?php if($jantina == 1){ print 'selected'; }?>>Lelaki</option>
                    <option value="2" <?php if($jantina == 2){ print 'selected'; }?>>Perempuan</option>
                </select>
            </div> 
            <div class="col-md-1">
            </div>
            <div class="col-md-1">
                <label for="">Umur : </label>
            </div>
            <div class="col-md-1">
                <input type="text" class="form-control" value="" name="umur1" id="umur1" value="<?=$umur1;?>"> 
            </div> 
            <div class="col-md-1">
                <small>hingga</small>
                
            </div> 
            <div class="col-md-1">
                <input type="text" class="form-control" value="" name="umur2" id="umur2" value="<?=$umur2;?>">
            </div> 
        </div>   
    </div> 
    <div class="box-body d-print-none" style="height: 40px;background-color:#F2F2F2;">
        <div class="row">
            <div class="col-md-2">
                <label for="">Bangsa : </label>
            </div>
            <div class="col-md-2">
                <?php
                    $sql3 = "SELECT * FROM $schema1.`ref_bangsa` WHERE `status`=0";
                    $rsBangsa = $conn->query($sql3);
                ?>
                <select name="bangsa" id="bangsa" class="form-control">
                    <option value="">Sila pilih</option>
                    <?php while(!$rsBangsa->EOF){ $bangsa_code = $rsBangsa->fields['kod']; ?>    
                        <option value="<?=$bangsa_code;?>" <?php if($bangsa_code == $bangsa){ print 'selected'; }?>><?php print $rsBangsa->fields['diskripsi'];?></option>
                    <?php $rsBangsa->movenext(); } ?>
                </select>
            </div> 
            <div class="col-md-1">
                <label for="">OKU : </label>
            </div>
            <div class="col-md-2">
                <select name="oku" id="oku" class="form-control">
                    <option value="">Sila pilih</option>
                    <option value="1" <?php if($oku == 1){ print 'selected'; }?>>Ya</option>
                    <option value="2" <?php if($oku == 2){ print 'selected'; }?>>Tidak</option>
                </select>
            </div> 
            <div class="col-md-2">
                <label for="tentera">Bekas Polis/ Tentera : </label>
            </div>
            <div class="col-md-3">
                <select name="tentera" id="tentera" class="form-control">
                    <option value="">Sila pilih</option>
                    <option value="1" <?php if($tentera == 1){ print 'selected'; }?>>Ya</option>
                    <option value="2" <?php if($tentera == 2){ print 'selected'; }?>>Tidak</option>
                </select>
            </div>
        </div>   
    </div> 

    <div class="box-body d-print-none" style="height: 40px;background-color:#F2F2F2;">
        <div class="row">
            <div class="col-md-2">
                <label for="">Zon : </label>
            </div>
            <div class="col-md-2">
                <select name="zon" id="zon" class="form-control">
                    <option value="">Sila pilih</option>
                    <option value="1" <?php if($zon == 1){ print 'selected'; }?>>Utara</option>
                    <option value="2" <?php if($zon == 2){ print 'selected'; }?>>Selatan</option>
                    <option value="3" <?php if($zon == 3){ print 'selected'; }?>>Tengah</option>
                    <option value="4" <?php if($zon == 4){ print 'selected'; }?>>Timur</option>
                    <option value="5" <?php if($zon == 5){ print 'selected'; }?>>SQL</option>
                </select>
            </div> 
            <div class="col-md-1">
                <label for="">Negeri : </label>
            </div>
            <div class="col-md-4">
                <?php
                    $sql3 = "SELECT * FROM $schema2.`ref_negeri` WHERE `status`=0";
                    $rsState = $conn->query($sql3);
                ?>
                <select name="negeri" id="negeri" class="form-control">
                    <option value="">Sila pilih</option>
                    <?php while(!$rsState->EOF){ $state_code = $rsState->fields['kod']; ?>    
                        <option value="<?=$state_code;?>"  <?php if($state_code == $negeri){ print 'selected'; }?>><?php print $rsState->fields['diskripsi2'];?></option>
                    <?php $rsState->movenext(); } ?>
                </select>
            </div> 
        </div>   
    </div> 

    <div class="box-body d-print-none" style="height: 40px;background-color:#F2F2F2;">
        <div class="row">
            <div class="col-md-2">
                <label for="">Pusat Temu Duga : </label>
            </div>
            <div class="col-md-4">
                <?php
                    $sql3 = "SELECT * FROM $schema1.`ref_pusat_temuduga` WHERE `status`=0";
                    $rspusatTemuduga = $conn->query($sql3);
                ?>
                <select name="pusat_temuduga" id="pusat_temuduga" class="form-control">
                    <option value="">Sila pilih</option>
                    <?php while(!$rspusatTemuduga->EOF){ $pusatTemuduga_code = $rspusatTemuduga->fields['kod']; ?>    
                        <option value="<?=$pusatTemuduga_code;?>" <?php if($pusatTemuduga_code == $pusat_temuduga){ print 'selected'; }?>><?php print $rspusatTemuduga->fields['diskripsi'];?></option>
                    <?php $rspusatTemuduga->movenext(); } ?>
                </select>
            </div> 
            <div class="col-md-2">
                <label for="">Peringkat Kelulusan : </label>
            </div>
            <div class="col-md-4">
                <?php
                    $sql3 = "SELECT * FROM $schema1.`ref_peringkat_kelulusan` WHERE `status`=0";
                    $rsperingkatKelulusan = $conn->query($sql3);
                ?>
                <select name="peringkat_kelulusan" id="peringkat_kelulusan" class="form-control">
                    <option value="">Sila pilih</option>
                    <?php while(!$rsperingkatKelulusan->EOF){ $peringkatKelulusan_code = $rsperingkatKelulusan->fields['kod']; ?>    
                        <option value="<?=$peringkatKelulusan_code;?>" <?php if($peringkatKelulusab_code == $peringkat_kelulusan){ print 'selected'; }?>><?php print $rsperingkatKelulusan->fields['diskripsi'];?></option>
                    <?php $rsperingkatKelulusan->movenext(); } ?>
                </select>
            </div> 
        </div>   
    </div> 

    <div class="box-body d-print-none" style="height: 40px;background-color:#F2F2F2;">
        <div class="row">
            <div class="col-md-2">
                <label for="">Universiti : </label>
            </div>
            <div class="col-md-4">
                <?php
                    $sql3 = "SELECT * FROM $schema1.`ref_institusi` WHERE `status`=0";
                    $rsinstitusi = $conn->query($sql3);
                ?>
                <select name="univ" id="univ" class="form-control">
                    <option value="">Sila pilih</option>
                    <?php while(!$rsinstitusi->EOF){ $institusi_code = $rsinstitusi->fields['KOD']; ?>    
                        <option value="<?=$institusi_code;?>" <?php if($institusi_code == $univ){ print 'selected'; }?>><?php print $rsinstitusi->fields['DISKRIPSI'];?></option>
                    <?php $rsinstitusi->movenext(); } ?>
                </select>
            </div> 
            
            <div class="col-md-2">
                <label for="">Kluster : </label>
            </div>
            <div class="col-md-4">
                <?php
                    $sql3 = "SELECT * FROM $schema1.`ref_kluster` WHERE `status`=0";
                    $rskluster = $conn->query($sql3);
                ?>
                <select name="kluster" id="kluster" class="form-control">
                    <option value="">Sila pilih</option>
                    <?php while(!$rskluster->EOF){ $kluster_code = $rskluster->fields['kod']; ?>    
                        <option value="<?=$kluster_code;?>" <?php if($kluster_code == $kluster){ print 'selected'; }?>><?php print $rskluster->fields['diskripsi'];?></option>
                    <?php $rskluster->movenext(); } ?>
                </select>
            </div>
            
        </div>  
            
    </div> 

    <div class="box-body d-print-none" style="height: 40px;background-color:#F2F2F2;">
        <div class="row">
            <div class="col-md-2">
                <label for="">Nama Sijil : </label>
            </div>
            <div class="col-md-4">
                <?php
                    $sql3 = "SELECT * FROM $schema1.`ref_pengkhususan` WHERE `status`=0";
                    $rsPengkhususan = $conn->query($sql3);
                ?>
                <select name="pengkhususan" id="pengkhususan" class="form-control">
                    <option value="">Sila pilih</option>
                    <?php while(!$rsPengkhususan->EOF){ $pengkhususan_code = $rsPengkhususan->fields['kod']; ?>    
                        <option value="<?=$pengkhususan_code;?>" <?php if($pengkhususan_code == $pengkhususan){ print 'selected'; }?>><?php print $rsPengkhususan->fields['DISKRIPSI'];?></option>
                    <?php $rsPengkhususan->movenext(); } ?>
                </select>
            </div>  
            <div class="col-md-2">
                <label for="">CGPA : </label>
            </div>
            <div class="col-md-1">
                <input type="text" class="form-control" value="" name="cgpa1" id="cgpa1" <?=$cgpa1;?>> 
            </div> 
            <div class="col-md-1">
                <small>hingga</small>
                
            </div> 
            <div class="col-md-1">
                <input type="text" class="form-control" value="" name="cgpa2" id="cgpa2" <?=$cgpa2;?>>
            </div> 
        </div>   
    </div> 
    
    <div class="box-body d-print-none" style="height: 40px;background-color:#F2F2F2;">
        <div class="row">
            <div class="col-md-2">
                <label for="">Jenis Skim: </label>
            </div>
            <div class="col-md-4">
                <?php
                    // $conn->debug=true;
                    $sql2 = "SELECT DISKRIPSI, KOD FROM $schema1.`ref_skim`";
                    $rsSkim = $conn->query($sql2);
                ?>

                <select name="skim" id="skim" class="form-control">
                    <option value="">Sila pilih</option>
                    <?php while(!$rsSkim->EOF){ $skim_code = $rsSkim->fields['KOD']; ?>    
                        <option value="<?=$skim_code;?>" <?php if($skim_code == $skim){ print 'selected'; }?>><?php print $rsSkim->fields['DISKRIPSI'];?></option>
                    <?php $rsSkim->movenext(); } ?>
                </select>
            </div> 
            <div class="col-md-2">
                <label for="">Status Permohonan: </label>
            </div>
            <div class="col-md-2" style="background-color:#F2F2F2">
                <select name="status" id="status" class="form-control">
                    <option value="">Sila pilih</option>
                    <option value="1" <?php if($status == 1){ print 'selected'; }?>>Hantar</option>
                    <option value="2" <?php if($status == 2){ print 'selected'; }?>>Draf</option>
                </select>
            </div>
            <div class="col-md-2" style="background-color:#F2F2F2">
                <button type="button" class="btn btn-primary" onclick="sortorder('<?=$hrefs;?>')">
                    <i class=" fa fa-search"></i> <font style="font-family:Verdana, Geneva, sans-serif">Cari</font>
                </button>
            </div>
        </div>   
    </div> 
    <br>
        <!-- <div align="right">
            <a href="" onclick="window.print()">
                <button type="button" class="btn btn-sm btn-info">
                    <span style="cursor:pointer;" title="Cetak Semua Dokumen Pemohon">
                        <i class="fa fa-print" style="color: #FFFFFF;"></i> Cetak
                    </span>
                </button>
            </a>
        </div> -->
    <?php
    ?>
    <br>
    <div class="box-body" style="background-color:#F2F2F2">
        <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
            <thead  style="background-color:rgb(38, 167, 228)">
                <th width="35%"><font color="#000000"><div align="center">Jumlah</div></font></th>
                <th width="10%" class="d-print-none"><font color="#000000"><div align="center">Tindakan</div></font></th>
            </thead>
            <tbody>
                <tr>
                    <td align="center"><?=$rs->fields['total'];?></td>
                    <td align="center" class="d-print-none">
                        <a href="index.php?data=<?php print base64_encode('laporan/detail_keseluruhan_data;Laporan;Laporan Detail Keseluruhan Data;ALL;;;'); ?>&dt_kemaskini=<?=$dt_kemaskini?>&jantina=<?=$jantina?>&umur1=<?=$umur1?>&umur2=<?=$umur2?>&bangsa=<?=$bangsa?>&oku=<?=$oku?>&tentera=<?=$tentera?>&zon=<?=$zon?>&negeri=<?=$negeri?>&pusat_temuduga=<?=$pusat_temuduga?>&peringkat_kelulusan=<?=$peringkat_kelulusan?>&univ=<?=$univ?>&pengkhususan=<?=$pengkhususan?>&kluster=<?=$kluster?>&cgpa1=<?=$cgpa1?>&cgpa2=<?=$cgpa2?>&skim=<?=$skim?>&status=<?=$status?>">
                            <button type="button" class="btn btn-sm btn-success">
                                <span style="cursor:pointer;color:red" title="Maklumat Terperinci Pemohon">
                                    <i class="fa fa-search" style="color: #FFFFFF;"></i>
                                </span>
                            </button>
                        </a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>   

          