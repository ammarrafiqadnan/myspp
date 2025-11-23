<link href="vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
<link href="vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
<link href="vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
<link href="vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">

<script>
    function do_page(href){
        // alert('sini');
        var carian = $('#carian').val();
        var status2 = $('#status2').val();
        var kod_svm2 = $('#kod_svm2').val();
        console.log(kod_svm2);

        //window.location.href = href+'&status2='+status2+'&carian='+carian;
        window.location.href = href+'&kod_svm2='+kod_svm2;
        
        // return sorturl;
    }

    $.ajax({
            url: 'pengurusan/parameter/padanan_akademik_skim_svm.php?kod_svm2='+kod_svm2,
            type:'POST',
            //dataType: 'json',
            data: $("form").serialize(),
            //data: datas,
            success: function(data){
            },
        });

        function do_check(kod_svm){
        var peringkat2 = $('#peringkat2').val();
        var kategori = $('#kategori').val();
        //var kod_svm2 = $('#kod_svm2').val();
        //console.log(kod_skim);
        console.log(kod_svm);
        
        const checkboxes = document.querySelectorAll(`input[name="checkPembetulan"]:checked`);
        let values = [];
        checkboxes.forEach((checkbox) => {
            values.push(checkbox.value);
        });

        if(values == ''){
            chks = 'false';
        } else {
            chks = 'true';
        }
        $.ajax({
            url: 'pengurusan/sql_pengurusan.php?frm=PARAMETER&jenis=PADANAN_PERINGKATAKADEMIK_SKIM&pro=SAVE&peringkat2='+peringkat2+'&chk='+chks+'&kod_skim='+kod_skim,
            type:'POST',
            //dataType: 'json',
            data: $("form").serialize(),
            //data: datas,
            success: function(data){
            },
        });
    } 
</script>

<?php
// $conn->debug=true;
$status2=isset($_REQUEST["status2"])?$_REQUEST["status2"]:"";
$carian=strtoupper(isset($_REQUEST["carian"])?$_REQUEST["carian"]:"");
$kod_svm2=isset($_REQUEST["kod_svm2"])?$_REQUEST["kod_svm2"]:"";

$hrefs = 'index.php?data='.base64_encode('pengurusan/parameter/senarai_kursus_svm;Pentadbiran;Parameter;Kursus SVM;;;');

$sql5 = "SELECT kod FROM $schema1.`ref_kursus_svm` WHERE `STATUS`=0 AND is_deleted=0";

    $rsInstitusiUncheck = $conn->query($sql5);
?>

    <?php
        //$conn->debug=true;
        $sql = "SELECT * FROM $schema1.`ref_kursus_svm` WHERE IS_DELETED=0"; 
        if($status2 != ''){
            $sql .= " AND `status`=".$status2;
        }

        if(!empty($carian)){
            $sql .= " AND ((KOD LIKE '%".$carian."%') OR (DISKRIPSI LIKE '%".$carian."%'))";
        }

        $sSQL1 = "SELECT COUNT(*) as total FROM $schema1.`ref_kursus_svm` WHERE IS_DELETED=0";
        if($status2 != ''){
            $sSQL1 .= " AND `status`=".$status2;
        }

        if(!empty($carian)){
            $sSQL1 .= " AND ((KOD LIKE '%".$carian."%') OR (DISKRIPSI LIKE '%".$carian."%'))";
        }

        include '../include/list_head.php';

    ?>

<div class="box" style="background-color:#F2F2F2">

<div class="box-body">
    <input type="hidden" name="id" value="" />
    <div class="x_panel">
    <header class="panel-heading"  style="background-color:rgb(38, 167, 228)">
        <div class="panel-actions">
        </div>
        <h6 class="panel-title"><font color="#000000"><b>Senarai Kursus SVM</b></font></h6> 
    </header>
    </div>
</div>            
<br>
    <div class="box-body" style="background-color:#F2F2F2">
        <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
            <thead  style="background-color:rgb(38, 167, 228)">
                <th width="5%"><font color="#000000"><div align="center">No.</div></font></th>
                <!-- <th width="5%"><font color="#000000"><div align="center">Kod</div></font></th> -->
                <th width="40%"><font color="#000000"><div align="center">Kursus SVM</div></font></th>
                <th width="15%"><font color="#000000"><div align="center">Tindakan</div></font></th>
            </thead>
            <tbody>
            <?php 
                $cnt = 0;
			    $bil = 0; 
                 
                while(!$rs->EOF){ $bil2=0; 
                    $bil = $cnt + ($PageNo-1)*$PageSize; ?>
                <tr>
                    <td align="center"><?=++$bil;?></td>
                    <!-- <td align="center"><?=$rs->fields['KOD'];?></td> -->
                    <td><?php print $rs->fields['DISKRIPSI'];?></td>
                    <td align="center">
                        <?php
                        $hrefs = 'index.php?data='.base64_encode('pengurusan/parameter/padanan_akademik_skim_svm;Pentadbiran;Parameter;Padanan Peringkat Akademik Dan Skim;;;');
                         //echo $hrefs;
                         ?>
                         <a href="index.php?data=cGVuZ3VydXNhbi9wYXJhbWV0ZXIvcGFkYW5hbl9ha2FkZW1pa19za2ltX3N2bTtQZW50YWRiaXJhbjtQYXJhbWV0ZXI7UGFkYW5hbiBQZXJpbmdrYXQgQWthZGVtaWsgRGFuIFNraW07Ozs&kod=<?=$rs->fields['KOD'];?>" class="btn btn-md btn-primary" title="Tambah Maklumat Jawatan" <?=$btn_disable;?> >
                         <i class="fa fa-plus"></i> Tambah Jawatan
                         </a>
                    </td>
                    

                </tr>
                
                
            <?php 
            $cnt = $cnt + 1;
            $rs->movenext(); } ?>
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
        <a class="btn btn-md btn-success" href="index.php?data=<?php print base64_encode('pengurusan/parameter/padanan_akademik_skim;Pentadbiran;Parameter;Padanan Peringkat Akademik Dan Skim;;;'); ?>">
            <i class="fa fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>   