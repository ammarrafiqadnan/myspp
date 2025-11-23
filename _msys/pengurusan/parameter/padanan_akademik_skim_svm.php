<link href="vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
<link href="vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
<link href="vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
<link href="vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">

<?php
$kod = $_GET['kod'];

/*$sql = "SELECT * FROM $schema1.`ref_skim` 
        WHERE `STATUS`=0 
        AND is_deleted=0
        and kod in (
        select kod_skim from $schema1.padanan_peringkatakademik_skim where kod_peringkat_akademik='3' and kod_svm='$kod' AND `STATUS`=0
        )";*/

$sql = "SELECT * from $schema1.padanan_peringkatakademik_skim a, $schema1.ref_skim b
        where a.kod_skim=b.kod
        and a.kod_peringkat_akademik='3' 
        and a.kod_svm='$kod' 
        AND a.`STATUS`=0";

$svmsql = $conn->query($sql);

$sql2 = "SELECT DISKRIPSI FROM $schema1.ref_kursus_svm WHERE KOD=$kod";
$svmsql2 = $conn->query($sql2);

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
            <h6 class="panel-title"><font color="#000000"><b>Senarai Maklumat Jawatan Berdasarkan Kelulusan SVM <br><?=$svmsql2->fields['DISKRIPSI'];?></b></font></h6> 
        </header>
        </div>
    </div>            
    <br /> 
    <div class="col-md-12" style="background-color:#F2F2F2;">
        <div class="row" style="padding-bottom: 10px; text-align: right;">
            <a href="pengurusan/parameter/form_padananAkademikSkim_svm.php?peringkat2=3&kod=<?=$kod;?>" class="btn btn-md btn-primary" data-toggle="modal" 
		                data-target="#myModal" title="Tambah Maklumat Jawatan" <?=$btn_disable;?> >
            	        <i class="fa fa-plus" align="right"></i> Tambah Jawatan
        	</a>
            </div>

        </div>
   
    </div>
    <br>
    <br>
    <div class="box-body" style="background-color:#F2F2F2">
        <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
            <thead  style="background-color:rgb(38, 167, 228)">
                <th width="5%"><font color="#000000"><div align="center">No.</div></font></th>
                <th width="15%"><font color="#000000"><div align="center">Jawatan</div></font></th>
                <th width="5%"><font color="#000000"><div align="center">Tindakan</div></font></th>
            </thead>
            <tbody>
                <?php 
                    $bil = 0; 
                    while(!$svmsql->EOF){ ?>
                    <tr>
                        <td align="center"><?=++$bil;?></td>
                        <td><?=$svmsql->fields['DISKRIPSI'];?></td>
                        <td align="center">
                            <button type="button" class="btn btn-sm btn-danger" onclick="do_hapus('pengurusan/sql_pengurusan.php?frm=PARAMETER&jenis=PADANAN_PERINGKATAKADEMIK_SKIM&pro=HAPUS&peringkat2=3&kod_skim=<?=$svmsql->fields['kod_skim'];?>&kod=<?=$svmsql->fields['kod'];?>')">
                                <span style="cursor:pointer;color:red" title="Keluarkan maklumat universiti"><i class="fa fa-trash-o" style="color: #FFFFFF;"></i></span>
                            </button>
                        </td>
                    </tr>
                <?php $svmsql->movenext(); } ?>
            </tbody>
        </table>
    </div>
    <div class="box-body">
        <a class="btn btn-md btn-success" href="index.php?data=<?php print base64_encode('pengurusan/parameter/senarai_akademik_svm;Pentadbiran;Parameter;Padanan Peringkat Akademik Dan Skim;;;'); ?>">
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