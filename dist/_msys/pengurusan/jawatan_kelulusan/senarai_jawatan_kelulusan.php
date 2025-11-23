<link href="vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
<link href="vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
<link href="vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
<link href="vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">

<?php
// $a_link = str_replace("&C=C", "&C=D", $a_link);
// $_SESSION['pages']=$a_link;
// $JFORM='LIST';
// $C=isset($_REQUEST["C"])?$_REQUEST["C"]:"";
// $peringkat=isset($_REQUEST["peringkat"])?$_REQUEST["peringkat"]:"";

// if($C=='D'){
// 	$peringkat = $_SESSION["SS_peringkat"];
// } else if($C=='C'){
// 	$_SESSION["SS_peringkat"]='';
// 		if(!empty($peringkat)){ $_SESSION["SS_peringkat"] = $peringkat; }
// 		else { $peringkat = $_SESSION["SS_peringkat"]; }
// } else {
// 	if($peringkat=='-'){ $peringkat=''; $_SESSION["SS_peringkat"]=''; } 
// 	else { 
// 		if(!empty($peringkat)){ $_SESSION["SS_peringkat"] = $peringkat; }
// 		else { $peringkat = $_SESSION["SS_peringkat"]; }
// 	}
// }
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
            <h6 class="panel-title"><font color="#000000"><b>Senarai Maklumat Jawatan Berdasarkan Kelulusan</b></font></h6> 
        </header>
        </div>
    </div>            
    <br /> 
    <div class="box-body" style="height: 40px;background-color:#F2F2F2;">
        <div class="row">
            <div class="col-md-2">
                <label for="">Peringkat Kelulusan: </label>
            </div>
            <div class="col-md-4">
                <select name="peringkat" id="peringkat" class="form-control" onchange="do_pages('<?=$actual_link;?>&C=C')"
                    <option value="">Sila pilih</option>
                    <option value="">Diploma Pendidikan</option>
                    <option value="">Diploma Bukan Pendidikan</option>
                    <option value="">Ijazah Pendidikan</option>
                    <option value="">Ijazah Bukan Pendidikan</option>
                    <option value="">Master Pendidikan (UTHM sahaja)</option>
                    <option value="">Master Bukan Pendidikan</option>
                    <option value="">PHD Bukan Pendidikan</option>
                </select>
            </div> 
            <div class="col-md-1">
                <label for="">Carian: </label>
            </div>
            <div class="col-md-3" style="background-color:#F2F2F2">
                <input type="text" name="carian" value="" class="form-control" placeholder="">
            </div>
            <div class="col-md-2" style="background-color:#F2F2F2">
                <button type="button" class="btn btn-info" onclick="do_page()">
                    <i class=" fa fa-search"></i> <font style="font-family:Verdana, Geneva, sans-serif">Cari</font>
                </button>
            </div>
        </div>   
    </div>
    <br>
    <div class="col-md-12" align="right">
        <a href="pengurusan/jawatan_kelulusan/form_institusiAwam.php" class="btn btn-md btn-primary" data-toggle="modal" data-target="#myModal" title="Tambah Maklumat Notifikasi">
            <i class="fa fa-plus"></i> Tambah Institusi Awam
        </a>
        
        <a href="pengurusan/jawatan_kelulusan/form_institusiSwasta.php" class="btn btn-md btn-info" data-toggle="modal" data-target="#myModal" title="Tambah Maklumat Notifikasi">
            <i class="fa fa-plus"></i> Tambah Institusi Swasta
        </a>
    </div>
    <br>
    <?php
        $sql3 = "SELECT * FROM $schema1.`ref_institusi` WHERE `NEGARA`='130' AND SAH_YT='Y' AND KATEGORI='A'";
        $rsInstitusi = $conn->query($sql3);

        $sql = "SELECT * FROM $schema1.`ref_institusi` WHERE `NEGARA`='130' AND SAH_YT='Y' AND KATEGORI IS NULL";
        $rsInstitusiS = $conn->query($sql);
    ?>
    <div class="box-body" style="background-color:#F2F2F2">
        <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
            <thead  style="background-color:rgb(38, 167, 228)">
                <th width="5%"><font color="#000000"><div align="center">No.</div></font></th>
                <th width="15%"><font color="#000000"><div align="center">Institusi</div></font></th>
                <th width="15%"><font color="#000000"><div align="center">Kategori</div></font></th>
                <th width="5%"><font color="#000000"><div align="center">Tindakan</div></font></th>
            </thead>
            <tbody>
                <?php 
                    $bil = 0; 
                    while(!$rsInstitusi->EOF){ ?>
                    <tr>
                        <td align="center"><?=++$bil;?></td>
                        <td><?=$rsInstitusi->fields['DISKRIPSI'];?></td>
                        <td align="center">
                            Awam
                        </td>
                        <td align="center">
                            <button type="button" class="btn btn-sm btn-danger" onclick="do_hapus()">
                                <span style="cursor:pointer;color:red" title="Keluarkan maklumat universiti"><i class="fa fa-trash-o" style="color: #FFFFFF;"></i></span>
                            </button>
                        </td>
                    </tr>
                <?php $rsInstitusi->movenext(); } ?>
                <?php 
                    //$bil = 0; 
                    while(!$rsInstitusiS->EOF){ ?>
                    <tr>
                        <td align="center"><?=++$bil;?></td>
                        <td><?=$rsInstitusiS->fields['DISKRIPSI'];?></td>
                        <td align="center">
                            Swasta
                        </td>
                        <td align="center">
                            <button type="button" class="btn btn-sm btn-danger" onclick="do_hapus()">
                                <span style="cursor:pointer;color:red" title="Keluarkan maklumat universiti"><i class="fa fa-trash-o" style="color: #FFFFFF;"></i></span>
                            </button>
                        </td>
                    </tr>
                <?php $rsInstitusiS->movenext(); } ?>
            </tbody>
        </table>
    </div>
    <div class="box-body">
        <a class="btn btn-md btn-success" href="index.php?data=<?php print base64_encode('pengurusan/parameter;Pengurusan;Parameter;ALL;;;'); ?>">
            <i class="fa fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<div class="card-footer">
    <?php 
    // $href_f=$actual_link."&table_search=".$table_search;
    // include 'include/list_footer.php'; 
    ?>  
</div>
           