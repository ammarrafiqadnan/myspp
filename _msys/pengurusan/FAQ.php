<link href="../vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
<link href="../vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
<link href="../vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
<link href="../vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">

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

$hrefs = 'index.php?data='.base64_encode('pengurusan/FAQ;Pentadbiran;FAQ;ALL;;;');

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
        <h6 class="panel-title"><font color="#000000"><b>Senarai Maklumat FAQ</b></font></h6> 
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
                <input type="text" id="carian"  name="carian" value="<?=$carian;?>" class="form-control" placeholder="Soalan/Jawapan">
            </div>
            <div class="col-md-2" style="background-color:#F2F2F2">
                <button type="button" class="btn btn-info" onclick="do_page('<?=$hrefs;?>')">
                    <i class=" fa fa-search"></i> <font style="font-family:Verdana, Geneva, sans-serif">Cari</font>
                </button>
            </div>
        </div>   
    </div>
    <br>
    <div class="col-md-12" align="right">
        <a href="pengurusan/FAQ_form.php?id=" class="btn btn-md btn-primary" data-toggle="modal" data-target="#myModal-xl" title="Tambah Maklumat FAQ">
            <i class="fa fa-plus"></i> Tambah FAQ
        </a>
    </div>
    <br>
    <?php
        //$conn->debug=true;
        $sql = "SELECT * FROM $schema2.`faq` WHERE is_deleted=0"; 
        if($status2 == '0' || $status2 == '1'){
            $sql .= " AND `status`=".$status2;
        }

        if(!empty($carian)){
            $sql .= " AND ((tajuk LIKE '%".$carian."%') OR (keterangan LIKE '%".$carian."%'))";
        }

        $sSQL1 = "SELECT COUNT(*) as total FROM $schema2.`faq` WHERE is_deleted=0";
        if($status2 == '0' || $status2 == '1'){
            $sSQL1 .= " AND `status`=".$status2;
        }

        if(!empty($carian)){
            $sSQL1 .= " AND ((tajuk LIKE '%".$carian."%') OR (keterangan LIKE '%".$carian."%'))";
        }

        include '../include/list_head.php';
        include '../include/page_list.php';
    ?>
    <div class="box-body" style="background-color:#F2F2F2">
        <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
            <thead  style="background-color:rgb(38, 167, 228)">
                <th width="5%"><font color="#000000"><div align="center">No.</div></font></th>
                <th width="30%"><font color="#000000"><div align="center">Soalan</div></font></th>
                <th width="30%"><font color="#000000"><div align="center">Jawapan</div></font></th>
                <th width="10%"><font color="#000000"><div align="center">Status</div></font></th>
		<th width="15%"><font color="#000000"><div align="center">Detail</div></font></th>
                <th width="10%"><font color="#000000"><div align="center">Tindakan</div></font></th>
            </thead>
            <tbody>
        
            <?php 
                $cnt = 0;
                $bil = 0; 
                
                while(!$rs->EOF){ $bil2=0; 
                    $bil = $cnt + ($PageNo-1)*$PageSize; ?>
                <tr>
                    <td align="center"><?=++$bil;?></td>
                    <td><?=$rs->fields['tajuk'];?></td>
                    <td><?=$rs->fields['keterangan'];?></td>
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
                                    <?php 
					if($rs->fields['id_pencipta']){
					$sqlP = "SELECT nama_penuh FROM $schema2.spa8i_admin WHERE id=".tosql($rs->fields['id_pencipta']);
					$sqlCipta = $conn->query($sqlP);

					$sqlP = "SELECT nama_penuh FROM $schema2.spa8i_admin WHERE id=".tosql($rs->fields['id_pengubahsuai']);
					$sqlKemaskini = $conn->query($sqlP);


					print "Tarikh Cipta : ".displayDate($rs->fields['tarikh_cipta']).'('.DisplayTime($rs->fields['tarikh_cipta']);?>) (<?=$sqlCipta->fields['nama_penuh'];?>) <br> <?php if(!empty($rs->fields['id_pengubahsuai'])){ print "Tarikh Kemaskini : ".displayDate($rs->fields['tarikh_ubahsuai']).'('.DisplayTime($rs->fields['tarikh_ubahsuai']);?>) (<?=$sqlKemaskini->fields['nama_penuh'].")"; }
					}?>
                                </td>

                    <td align="center">
                        <a href="pengurusan/FAQ_form.php?id=<?=$rs->fields['kod'];?>" class="btn btn-sm btn-success" data-toggle="modal" data-target="#myModal-xl" title="Kemaskini Maklumat FAQ">
                            <i class="fa fa-edit"></i>
                        </a>
                        <button type="button" class="btn btn-sm btn-danger" onclick="do_hapus('pengurusan/sql_pengurusan.php?frm=PENGURUSAN&pro=HAPUS&jenis=FAQ&id_hapus=<?=$rs->fields['kod'];?>')">
                            <span style="cursor:pointer;color:red" title="Hapus maklumat FAQ"><i class="fa fa-trash-o" style="color: #FFFFFF;"></i></span>
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

</div>

          