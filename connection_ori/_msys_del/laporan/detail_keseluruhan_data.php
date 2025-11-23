<link href="vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
<link href="vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
<link href="vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
<link href="vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">

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
// $conn->debug=true;
$sql = "SELECT A.nama_penuh, A.ICNo, A.id_pemohon FROM $schema2.`calon` A WHERE A.ICNo IS NOT NULL"; 

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
        <div class="panel-actions">
        <!--<a href="#" class="fa fa-caret-down"></a>
        <a href="#" class="fa fa-times"></a>-->
        </div>
        <h6 class="panel-title"><font color="#000000"><b>Senarai Tapisan</b></font></h6> 
    </header>
    </div>
    </div>            
    <br /> 
    <div class="box-body" style="height: 40px;background-color:#F2F2F2;">
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
            <div class="col-md-2" style="background-color:#F2F2F2">
                <input type="text" id="jumlah" name="jumlah" value="" class="form-control" placeholder="Jumlah">
            </div>
            <!-- <div class="col-md-1" style="background-color:#F2F2F2">
                <a href="" class="btn btn-md btn-primary" data-toggle="tooltip" data-title="Tambah Nama Sijil">
                    <i class="fa fa-plus" aria-hidden="true"></i>
                </a>
            </div>  
                
            <div class="col-md-1">
                <a href="" class="btn btn-md btn-success" data-toggle="tooltip" data-title="Salin Maklumat Kepada excel/csv" onclick="do_print('cetak.php?pages=muatnaikExcel/keputusan_temuduga_cetak&prn=EXCEL&filename=senarai_keputusan_temuduga')" >
                    <i class="fa fa-file-excel-o" aria-hidden="true"></i>
                </a>
            </div>-->
        </div>  
        <br>
        <div class="row">
            <div class="col-md-2">
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
            <div class="col-md-2" style="background-color:#F2F2F2">
                <input type="text" id="jumlah" name="jumlah" value="" class="form-control" placeholder="Jumlah">
            </div>
            <div class="col-md-1" style="background-color:#F2F2F2">
                <a href="" class="btn btn-md btn-primary" data-toggle="tooltip" data-title="Tambah Nama Sijil">
                    <i class="fa fa-plus" aria-hidden="true"></i>
                </a>
            </div> 
            <div class="col-md-2" style="background-color:#F2F2F2">
                <a href="" class="btn btn-md btn-primary" data-toggle="tooltip" data-title="Proses Maklumat">
                    <i class="fa fa-file" aria-hidden="true"></i> Proses
                </a>
            </div>
            
            <div class="col-md-1">
                <a href="" class="btn btn-md btn-success" data-toggle="tooltip" data-title="Salin Maklumat Kepada excel/csv" onclick="do_print('cetak.php?pages=muatnaikExcel/keputusan_temuduga_cetak&prn=EXCEL&filename=senarai_keputusan_temuduga')" >
                    <i class="fa fa-file-excel-o" aria-hidden="true"></i>
                </a>
            </div>
        </div>  
    </div>
    <br><br><br>
    <?php
        $sSQL1 = "SELECT COUNT(*) as total FROM $schema2.`calon` A WHERE A.ICNo IS NOT NULL"; 

        if(!empty($dt_kemaskini)){
            $sSQL1 .= " AND (date(A.d_kemaskini) LIKE '%".$dt_kemaskini."%')";
        }
        
        if(!empty($jantina)){
            $sSQL1 .= " AND A.jantina=".tosql($jantina);
        }

        include '../include/list_head.php';
        include '../include/page_list.php';
    ?>
    <div class="box-body" style="background-color:#F2F2F2">
        <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
            <thead  style="background-color:rgb(38, 167, 228)">
                <th width="5%"><font color="#000000"><div align="center">No.</div></font></th>
                <th width="40%"><font color="#000000"><div align="center">Nama</div></font></th>
                <th width="15%"><font color="#000000"><div align="center">No. Kad Pengenalan</div></font></th>
                <th width="5%"><font color="#000000"><div align="center">Tindakan</div></font></th>
            </thead>
            <tbody>
                <?php 
                    $cnt = 0;
                    $bil = 0; 
                    while(!$rs->EOF){ $bil2=0; 
                        $bil = $cnt + ($PageNo-1)*$PageSize; 
                ?>
                    <tr>
                        <td align="center"><?=++$bil;?></td>
                        <td align="center"><?=$rs->fields['nama_penuh'];?></td>
                        <td align="center"><?=$rs->fields['ICNo'];?></td>
                        <td align="center">
                            <a href="index.php?data=<?php print base64_encode('pemohon/maklumat_pemohon;Senarai Pemohon;Nama: '.$rs->fields['nama_penuh'].' (No.K/P: '.$rs->fields['ICNo'].');;;;'); ?>&id_pemohon=<?=$rs->fields['id_pemohon']?>">
                                <button type="button" class="btn btn-sm btn-success">
                                    <span style="cursor:pointer;color:red" title="Maklumat Terperinci Pemohon">
                                        <i class="fa fa-search" style="color: #FFFFFF;"></i>
                                    </span>
                                </button>
                            </a>
                        </td>
                    </tr>
                <?php 
                    $cnt = $cnt + 1;
                    $rs->movenext(); } 
                ?>
            </tbody>
        </table>
    </div>

    <div class="card-footer">
        <?php 
            $href_f=$actual_link."&table_search=".$table_search;
            include 'include/list_footer.php'; 
        ?>  
    </div>

    <div class="box-body">
        <a class="btn btn-md btn-success" href="index.php?data=<?php print base64_encode('laporan/keseluruhan_data;Laporan;Laporan Keseluruhan Data;ALL;;;'); ?>&dt_kemaskini=<?=$dt_kemaskini?>&jantina=<?=$jantina?>&umur1=<?=$umur1?>&umur2=<?=$umur2?>&bangsa=<?=$bangsa?>&oku=<?=$oku?>&tentera=<?=$tentera?>&zon=<?=$zon?>&negeri=<?=$negeri?>&pusat_temuduga=<?=$pusat_temuduga?>&peringkat_kelulusan=<?=$peringkat_kelulusan?>&univ=<?=$univ?>&pengkhususan=<?=$pengkhususan?>&kluster=<?=$kluster?>&cgpa1=<?=$cgpa1?>&cgpa2=<?=$cgpa2?>&skim=<?=$skim?>&status=<?=$status?>">
            <i class="fa fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>   

           