<link href="vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
<link href="vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
<link href="vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
<link href="vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">

<script>
    function sortorder(href){
        // alert('sini');   
        var cari = $('#carian').val();
        var bidang = $('#bidang').val();
        
        window.location.href = href+"&bidang="+bidang+"&carian="+cari;
        // return sorturl;
    }
</script>
<?php
    // $conn->debug=true;
    $order_by=isset($_REQUEST["order_by"])?$_REQUEST["order_by"]:"";
    $sort=isset($_REQUEST["sort"])?$_REQUEST["sort"]:"";
    $bidang=isset($_REQUEST["bidang"])?$_REQUEST["bidang"]:"";
    $carian=isset($_REQUEST["carian"])?$_REQUEST["carian"]:"";

    $hrefs = 'index.php?data='.base64_encode('pengurusan/parameter/padanan_bidang_pengkhususan;Pentadbiran;Parameter;Padanan Bidang Dan Pengkhususan;;;');
    
    $sql3 = "SELECT A.*, B.DISKRIPSI FROM $schema1.padanan_bidang_pengkhususan A, $schema1.`ref_pengkhususan` B WHERE A.kod_pengkhususan=B.kod AND A.status=0 AND A.kod_bidang=".tosql($bidang);

    // if(!empty($bidang)){
    //     $sql3 .= " AND A.kod_bidang=".tosql($bidang);
    // }

    if(!empty($carian)){
        $sql3 .= " AND B.DISKRIPSI  LIKE '%$carian%'";
    }



    $rs = $conn->query($sql3);

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
            <h6 class="panel-title"><font color="#000000"><b>Padanan Bidang Dan Pengkhususan</b></font></h6> 
        </header>
        </div>
    </div>            
    <br /> 
    <div class="col-md-12" style="background-color:#F2F2F2;">
        <div class="row">
            <div class="col-md-2">
                <label for="">Bidang: </label>
            </div>
            <div class="col-md-4">
                <?php 
                    $sql = "SELECT * FROM $schema1.`ref_bidang` WHERE is_deleted=0 AND `status`=0";
                    $rsbidang = $conn->query($sql);
                ?>
                <select name="bidang" id="bidang" class="form-control" onchange="sortorder('<?=$hrefs;?>')">
                    <option value="">Sila pilih bidang</option>
                    <?php while(!$rsbidang->EOF){ $code = $rsbidang->fields['kod']; ?>    
                        <option value="<?=$code;?>" <?php if($bidang == $code){ print 'selected';}?>><?php print $rsbidang->fields['diskripsi'];?></option>
                    <?php $rsbidang->movenext(); } ?>
                </select>
            </div> 
            <div class="col-md-1">
                <label for="">Carian: </label>
            </div>
            <div class="col-md-3" style="background-color:#F2F2F2">
                <input type="text" id="carian" name="carian" value="<?=$carian;?>" class="form-control" placeholder="">
            </div>
            <div class="col-md-2" style="background-color:#F2F2F2">
                <button type="button" class="btn btn-info" onclick="sortorder('<?=$hrefs;?>')">
                    <i class=" fa fa-search"></i> <font style="font-family:Verdana, Geneva, sans-serif">Cari</font>
                </button>
            </div>
        </div>   
    </div>
    <br>
    <div class="col-md-12" align="right">
        <a href="pengurusan/parameter/form_padananBidangPengkhususan.php?bidang_kod=<?=$bidang;?>" class="btn btn-md btn-primary" data-toggle="modal" data-target="#myModal" title="Tambah Maklumat Bidang">
            <i class="fa fa-plus"></i> Tambah Bidang
        </a>
    </div>
    <br>
    <div class="box-body" style="background-color:#F2F2F2">
        <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
            <thead  style="background-color:rgb(38, 167, 228)">
                <th width="5%"><font color="#000000"><div align="center">No.</div></font></th>
                <th width="15%"><font color="#000000"><div align="center">Pengkhususan</div></font></th>
                <!-- <th width="15%"><font color="#000000"><div align="center">Kategori</div></font></th> -->
                <th width="5%"><font color="#000000"><div align="center">Tindakan</div></font></th>
            </thead>
            <tbody>
                <?php 
                    $bil = 0; 
                    while(!$rs->EOF){ ?>
                    <tr>
                        <td align="center"><?=++$bil;?></td>
                        <td><?=$rs->fields['DISKRIPSI'];?></td>
                        <!-- <td align="center">
                            Awam
                        </td> -->
                        <td align="center">
                            <button type="button" class="btn btn-sm btn-danger" onclick="do_hapus('pengurusan/sql_pengurusan.php?frm=PARAMETER&jenis=PADANAN_BIDANG_PENGKHUSUSAN&pro=HAPUS&bidang_kod=<?=$bidang;?>&kod_pengkhususan=<?=$rs->fields['kod_pengkhususan'];?>')">
                                <span style="cursor:pointer;color:red" title="Keluarkan maklumat universiti"><i class="fa fa-trash-o" style="color: #FFFFFF;"></i></span>
                            </button>
                        </td>
                    </tr>
                <?php $rs->movenext(); } ?>
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
           