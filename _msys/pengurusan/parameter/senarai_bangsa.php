<link href="vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
<link href="vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
<link href="vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
<link href="vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">

<script>
    function do_page(href){
        // alert('sini');
        var carian = $('#carian').val();
        var status2 = $('#status2').val();

        window.location.href = href+'&status2='+status2+'&carian='+carian;
        
        
        // return sorturl;
    }
</script>

<?php
// $conn->debug=true;
$status2=isset($_REQUEST["status2"])?$_REQUEST["status2"]:"";
$carian=strtoupper(isset($_REQUEST["carian"])?$_REQUEST["carian"]:"");

$hrefs = 'index.php?data='.base64_encode('pengurusan/parameter/senarai_bangsa;Pentadbiran;Parameter;Senarai Bangsa;;;');

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
        <h6 class="panel-title"><font color="#000000"><b>Senarai Maklumat Bangsa</b></font></h6> 
    </header>
    </div>
    </div>            
    <br /> 
    <div class="col-md-12" style="background-color:#F2F2F2;">
        <div class="row">
        <label for="nama" class="col-sm-1 control-label">Status:</label>
            <div class="col-sm-3">
                <select name="status2" id="status2" class="form-control" onchange="do_page('<?=$hrefs;?>')">
                    <option value="">Sila pilih status</option>
                    <option value="0" <?php if($status2 == 0){ print 'selected'; } ?>>Aktif</option>
                    <option value="1" <?php if($status2 == 1){ print 'selected'; } ?>>Tidak Aktif</option>
                </select>
            </div>
            <div class="col-md-1">
                <label for="">Carian: </label>
            </div>
            <div class="col-md-5" style="background-color:#F2F2F2">
                <input type="text" id="carian"  name="carian" value="<?=$carian;?>" class="form-control" placeholder="Kod/Tajuk">
            </div>
            <div class="col-md-2" style="background-color:#F2F2F2">
                <button type="button" class="btn btn-info" onclick="do_page('<?=$hrefs;?>')">
                    <i class=" fa fa-search"></i> <font style="font-family:Verdana, Geneva, sans-serif">Cari</font>
                </button>
            </div>
        </div>   
    </div>
    <!-- <br>
    <div class="col-md-12" align="right">
        <a href="pengurusan/notifikasi_form.php?id=" class="btn btn-md btn-primary" data-toggle="modal" data-target="#myModal" title="Tambah Maklumat Notifikasi">
            <i class="fa fa-plus"></i> Tambah Notifikasi
        </a>
    </div> -->
    <br>
    <?php
    // $conn->debug=true;
        $sql3 = "SELECT * FROM $schema1.`ref_bangsa` WHERE kod IS NOT NULL";
        if($status2 != ''){
            $sql3 .= " AND `status`=".$status2;
        }

        if(!empty($carian)){
            $sql3 .= " AND ((kod LIKE '%".$carian."%') OR (diskripsi LIKE '%".$carian."%'))";
        }

        $rsState = $conn->query($sql3);
    ?>
    <div class="box-body" style="background-color:#F2F2F2">
        <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
            <thead  style="background-color:rgb(38, 167, 228)">
                <th width="5%"><font color="#000000"><div align="center">No.</div></font></th>
                <th width="15%"><font color="#000000"><div align="center">Kod</div></font></th>
                <th width="30%"><font color="#000000"><div align="center">Bangsa</div></font></th>
                <th width="10%"><font color="#000000"><div align="center">Status</div></font></th>
                <th width="5%"><font color="#000000"><div align="center">Tindakan</div></font></th>
            </thead>
            <tbody>
            <?php 
                $bil = 0; 
                while(!$rsState->EOF){ ?>
                <tr>
                    <td align="center"><?=++$bil;?></td>
                    <td align="center"><?=$rsState->fields['kod'];?></td>
                    <td><?php print $rsState->fields['diskripsi'];?></td>
                    <td align="center">
                        <?php 
                            if($rsState->fields['status'] == 0){
                                print '<button class="btn-success badge">Aktif</button>';
                            } else {
                                print '<button class="btn-danger badge">Tidak Aktif</button>';
                            }
                        ?>
                    </td>
                    <td align="center">
                        <a href="pengurusan/parameter/form_bangsa.php?bangsa_kod=<?=$rsState->fields['kod'];?>" class="btn btn-md btn-success" data-toggle="modal" data-target="#myModal" title="Kemaskini Maklumat Bangsa">
                            <i class="fa fa-edit"></i>
                        </a>
                    </td>
                </tr>
            <?php $rsState->movenext(); } ?>
            </tbody>
        </table>
    </div>

    <div class="box-body">
        <a class="btn btn-md btn-success" href="index.php?data=<?php print base64_encode('pengurusan/parameter;Pengurusan;Parameter;ALL;;;'); ?>">
            <i class="fa fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>   

           