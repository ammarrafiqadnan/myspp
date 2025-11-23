<link href="vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
<link href="vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
<link href="vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
<link href="vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">

<?php
$JFORM='LIST';
$carian=strtoupper(isset($_REQUEST["carian"])?$_REQUEST["carian"]:"");
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
        <h6 class="panel-title"><font color="#000000"><b>Senarai Maklumat OKU</b></font></h6> 
    </header>
    </div>
    </div>            
    <br /> 
    <div class="box-body" style="height: 40px;background-color:#F2F2F2;">
        <div class="row">
        <label for="nama" class="col-sm-1 control-label">Status:</label>
            <div class="col-sm-3">
                <select name="status" id="status" class="form-control">
                    <option value="">Sila pilih status</option>
                    <option value="">Aktif</option>
                    <option value="">Tidak Aktif</option>
                </select>
            </div>
            <div class="col-md-1">
                <label for="">Carian: </label>
            </div>
            <div class="col-md-5" style="background-color:#F2F2F2">
                <input type="text" name="carian" value="" class="form-control" placeholder="Kod/Tajuk">
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
        <a href="pengurusan/parameter/form_oku.php?oku_kod=" class="btn btn-md btn-primary" data-toggle="modal" data-target="#myModal" title="Tambah Maklumat Notifikasi">
            <i class="fa fa-plus"></i> Tambah OKU
        </a>
    </div>
    <br>
    <?php
        //$conn->debug=true;
        $sql = "SELECT * FROM $schema1.`ref_kecacatan_calon` WHERE is_deleted=0"; 
        // $rs = $conn->query($sql);
        //$conn->debug=false;

        // $rsoku = $conn->query($sql3);

        $sSQL1 = "SELECT COUNT(*) as total FROM $schema1.`ref_kecacatan_calon` WHERE is_deleted=0";

        include '../include/list_head.php';
        include '../include/page_list.php';
    ?>
    <div class="box-body" style="background-color:#F2F2F2">
        <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
            <thead  style="background-color:rgb(38, 167, 228)">
                <th width="5%"><font color="#000000"><div align="center">No.</div></font></th>
                <th width="5%"><font color="#000000"><div align="center">Kod</div></font></th>
                <th width="40%"><font color="#000000"><div align="center">oku</div></font></th>
                <th width="10%"><font color="#000000"><div align="center">Status</div></font></th>
                <th width="5%"><font color="#000000"><div align="center">Tindakan</div></font></th>
            </thead>
            <tbody>
            <?php 
                $cnt = 0;
			    $bil = 0; 
                 
                while(!$rs->EOF){ $bil2=0; 
                    $bil = $cnt + ($PageNo-1)*$PageSize; ?>
                <tr>
                    <td align="center"><?=++$bil;?></td>
                    <td align="center"><?=$rs->fields['KOD'];?></td>
                    <td><?php print $rs->fields['DISKRIPSI'];?></td>
                    <td align="center">
                        <?php 
                            if($rs->fields['status'] == 0){
                                print '<button class="btn-success badge">Aktif</button>';
                            } else {
                                print '<button class="btn-danger badge">Tidak Aktif</button>';
                            }
                        ?>
                    </td>
                    <td align="center">
                        <a href="pengurusan/parameter/form_oku.php?oku_kod=<?=$rs->fields['KOD'];?>" class="btn btn-sm btn-success" data-toggle="modal" data-target="#myModal" title="Kemaskini Maklumat Bangsa">
                            <i class="fa fa-edit"></i>
                        </a>
                        <button type="button" class="btn btn-sm btn-danger" onclick="do_hapus('pengurusan/sql_pengurusan.php?frm=PARAMETER&jenis=OKU&pro=HAPUS&kod=<?=$rs->fields['KOD'];?>')">
							<span style="cursor:pointer;color:red" title="Hapus maklumat oku"><i class="fa fa-trash-o" style="color: #FFFFFF;"></i></span>
						</button>
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
        <a class="btn btn-md btn-success" href="index.php?data=<?php print base64_encode('pengurusan/parameter;Pengurusan;Parameter;ALL;;;'); ?>">
            <i class="fa fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>   

           