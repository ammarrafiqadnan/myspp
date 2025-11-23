<link href="../vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
<link href="../vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
<link href="../vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
<link href="../vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">

<script>
    function sortorder(href, val){
        // alert('sini');
        var carian = $('#carian').val();
        var bahagian = $('#bahagian').val();
        var jawatan = $('#jawatan').val();
        var peranan = $('#peranan').val();
        var status = $('#status').val();

        window.location.href = href+"&bahagian="+bahagian+"&jawatan="+jawatan+'&peranan='+peranan+'&status='+status+'&carian='+carian;
        
        
        // return sorturl;
    }
</script>
  <!-- Select2 -->
<link rel="stylesheet" href="../plugins/select2/css/select2.min.css">
<link rel="stylesheet" href="../plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">

<?php
 //$conn->debug=true;
$bahagian=isset($_REQUEST["bahagian"])?$_REQUEST["bahagian"]:"";
$jawatan=isset($_REQUEST["jawatan"])?$_REQUEST["jawatan"]:"";
$peranan=isset($_REQUEST["peranan"])?$_REQUEST["peranan"]:"";
$status=isset($_REQUEST["status"])?$_REQUEST["status"]:"";
$carian=strtoupper(isset($_REQUEST["carian"])?$_REQUEST["carian"]:"");

$hrefs = 'index.php?data='.base64_encode('pengurusan/senarai_pengguna;Pentadbiran;Senarai Pengguna;ALL;;;');

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
                <h6 class="panel-title"><font color="#000000"><b>Maklumat Senarai Pemohon</b></font></h6> 
            </header>
			</div>
            </div>            
            <br />
            <div class="col-md-12" style="background-color:#F2F2F2;">
                <div class="col-md-12">
                    <div class="row" style="padding-bottom: 10px;">
                        <div class="col-md-1">
                            <label for="">Bahagian: </label>
                        </div>
                        <div class="col-md-4">
                            <select name="bahagian" id="bahagian" class="form-control select2"  onchange="sortorder('<?=$hrefs;?>',this.value)">
                                <option value="">Sila pilih bahagian</option>
                                <option value="1" <?php if($bahagian == 1){ print 'selected'; } ?>>BAHAGIAN PENGURUSAN MAKLUMAT</option>
                                <option value="2" <?php if($bahagian == 2){ print 'selected'; } ?>>BAHAGIAN PENGAMBILAN</option>
                            </select>
                        </div>  
                        <div class="col-md-1">
                            <label for="">Jawatan: </label>
                        </div>
                        <div class="col-md-5">
                            <select select name="jawatan" id="jawatan" class="form-control select2"  onchange="sortorder('<?=$hrefs;?>',this.value)">
                                <option value="">Sila pilih jawatan</option>
                                <option value="1" <?php if($jawatan == 1){ print 'selected'; } ?>>PEMBANTU PEGAWAI SISTEM MAKLUMAT</option>
                                <option value="2" <?php if($jawatan == 2){ print 'selected'; } ?>>PEMBANTU PEGAWAI SPP</option>
                            </select>
                        </div>  
                    </div>   
                </div>
            </div> 
            <div class="col-md-12" style="background-color:#F2F2F2;">
                <div class="col-md-12">
                    <div class="row" style="padding-bottom: 10px;">
                        <div class="col-md-1">
                            <label for="">Peranan: </label>
                        </div>
                        <div class="col-md-4">
                            <select name="peranan" id="peranan" class="form-control select2"  onchange="sortorder('<?=$hrefs;?>',this.value)">
                                <option value="">-- Sila pilih peranan --</option>
                                <option value="1" <?php if($peranan == 1){ print 'selected'; } ?>>Pentadbir/Admin</option>
                                <option value="2" <?php if($peranan == 2){ print 'selected'; } ?>>Pengurusan</option>
				<option value="3" <?php if($peranan == 3){ print 'selected'; } ?>>Meja Bantu (Helpdesk)</option>


                            </select>
                        </div>  

                        <label for="nama" class="col-sm-1 control-label">Status:</label>
                        <div class="col-sm-3">
                            <select name="status" id="status" class="form-control select2"  onchange="sortorder('<?=$hrefs;?>',this.value)">
                                <option value="">Sila pilih status</option>
                                <option value="0" <?php if($status == 0){ print 'selected'; } ?>>Aktif</option>
                                <option value="1" <?php if($status == 1){ print 'selected'; } ?>>Tidak Aktif</option>
                            </select>
                        </div>
                    </div>   
                </div>
            </div>

            <div class="col-md-12" style="background-color:#F2F2F2;">
                <div class="col-md-12">
                    <div class="row" style="padding-bottom: 10px;">
                        <div class="col-md-1">
                            <label for="">Carian: </label>
                        </div>
                        <div class="col-md-4" style="background-color:#F2F2F2">
                            <input type="text" name="carian" id="carian" value="<?php if(!empty($carian)){ print $carian; } ?>" class="form-control" placeholder="ID Pengguna/Nama/No KP">
                        </div>
                        <div class="col-md-2" style="background-color:#F2F2F2">
                            <button type="button" class="btn btn-info"  onclick="sortorder('<?=$hrefs;?>',this.value)">
                                <i class=" fa fa-search"></i> <font style="font-family:Verdana, Geneva, sans-serif">Cari</font>
                            </button>
                        </div>
                    </div>   
                </div>
            </div>
            <br>
            <div class="col-md-12" align="right">
                <a href="pengurusan/pengguna_form.php?id=&jenis=admin" class="btn btn-md btn-primary" data-toggle="modal" data-target="#myModal" data-backdrop="" title="Tambah Maklumat Pengguna">
                    <i class="fa fa-plus"></i> Tambah Pengguna
                </a>
            </div>
			<br>
            <?php
                //$conn->debug=true;
                $sql = "SELECT * FROM $schema2.`spa8i_admin` WHERE is_deleted=0"; 

                if(!empty($bahagian)){
                    $sql .= " AND bahagian=".$bahagian;
                }

                if(!empty($peranan)){
                    $sql .= " AND peranan=".$peranan;
                }

                if(!empty($jawatan)){
                    $sql .= " AND jawatan=".$jawatan;
                }

                if(!empty($status)){
                    $sql .= " AND `status`=".$status;
                }

                if(!empty($carian)){
                    // $sql .= " AND username  LIKE '%".$carian."%'";

                    $sql .= " AND ((noKP  LIKE '%".$carian."%') OR (nama_penuh  LIKE '%".$carian."%') OR (username  LIKE '%".$carian."%'))";

                }

                // $rsoku = $conn->query($sql3);

                $sSQL1 = "SELECT COUNT(*) as total FROM $schema2.`spa8i_admin` WHERE is_deleted=0";

                if(!empty($bahagian)){
                    $sSQL1 .= " AND bahagian=".$bahagian;
                }

                if(!empty($peranan)){
                    $sSQL1 .= " AND peranan=".$peranan;
                }

                if(!empty($jawatan)){
                    $sSQL1 .= " AND jawatan=".$jawatan;
                }

                if(!empty($status)){
                    $sSQL1 .= " AND `status`=".$status;
                }

                if(!empty($carian)){
                    // $sSQL1 .= " AND username  LIKE '%".$carian."%'";

                    $sSQL1 .= " AND ((noKP  LIKE '%".$carian."%') OR (nama_penuh  LIKE '%".$carian."%') OR (username  LIKE '%".$carian."%'))";

                }

                include '../include/list_head.php';
                include '../include/page_list.php';
            ?>
			<div class="box-body" style="background-color:#F2F2F2">
                <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                    <thead  style="background-color:rgb(38, 167, 228)">
                        <th width="5%"><font color="#000000"><div align="center">No.</div></font></th>
                        <!-- <th width="15%"><font color="#000000"><div align="center">ID Pengguna</div></font></th> -->
                        <th width="20%"><font color="#000000"><div align="center">Nama Penuh/ No.KP</div></font></th>
                        <th width="15%"><font color="#000000"><div align="center">Bahagian</div></font></th>
                        <th width="10%"><font color="#000000"><div align="center">Jawatan</div></font></th>
                        <th width="5%"><font color="#000000"><div align="center">No. Tel</div></font></th>
                        <th width="5%"><font color="#000000"><div align="center">Peranan</div></font></th>
                        <th width="5%"><font color="#000000"><div align="center">Status</div></font></th>
			<th width="15%"><font color="#000000"><div align="center">Detail</div></font></th>
                        <th width="10%"><font color="#000000"><div align="center">Tindakan</div></font></th>

                    </thead>
                    <tbody>

                
                    <?php 
                        $cnt = 0;
                        $bil = 0; 
                    //if($rs1->fields['total'] != 0){
                        while(!$rs->EOF){ $bil2=0; 
                            $bil = $cnt + ($PageNo-1)*$PageSize; ?>
                        <tr>
                            <td align="center"><?=++$bil;?></td>
                            <!-- <td align="left"><?=$rs->fields['username'];?></td> -->
                            <td><?=$rs->fields['nama_penuh'];?> <br> <?=$rs->fields['noKP'];?></td>
                            <td align="center">
                                <?php 
                                    if($rs->fields['bahagian'] == 1){
                                        print 'BAHAGIAN PENGURUSAN MAKLUMAT';
                                    } else if($rs->fields['bahagian'] == 2){
                                        print 'BAHAGIAN PENGAMBILAN';
                                    }
                                ?>
                            </td>
                            <td align="left">
                                <?php 
                                    if($rs->fields['jawatan'] == 1){
                                        print 'PEMBANTU PEGAWAI SISTEM MAKLUMAT';
                                    } else if($rs->fields['jawatan'] == 2){
                                        print 'PEMBANTU PEGAWAI SPP';
                                    }
                                ?>
                            </td>
                            <td align="center"><?=$rs->fields['no_tel'];?></td>
                            <td align="center">
                                <?php 
                                    if($rs->fields['peranan'] == 1){
                                        print 'Pentadbir/Admin';
                                    } else if($rs->fields['peranan'] == 2){
                                        print 'Pengurusan';
                                    } else if($rs->fields['peranan'] == 3){
                                        print 'Meja Bantu (Helpdesk)';
                                    }
                                ?>
                            </td>
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
                                <!-- <a href="" class="btn btn-md btn-success" data-toggle="modal" data-taraget="#myModal" title="Kemaskini Maklumat Pengguna">
                                    <i class="fa fa-edit"></i>
                                </a> -->
                                <a href="pengurusan/pengguna_form.php?id=<?=$rs->fields['id'];?>&jenis=admin" class="btn btn-sm btn-success" data-toggle="modal" data-target="#myModal" data-backdrop="" title="Kemaskini Maklumat Pengguna">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <!-- <a href="" class="btn btn-sm btn-danger" data-toggle="modal" data-taraget="#myModal" title="Hapus Maklumat Pengguna">
                                    <i class="fa fa-trash-o"></i>
                                </a> -->
                                <button type="button" class="btn btn-sm btn-danger" onclick="do_hapus('pengurusan/sql_pengurusan.php?frm=PENGGUNA&pro=HAPUS&id_hapus=<?=$rs->fields['id'];?>')">
                                    <span style="cursor:pointer;color:red" title="Hapus maklumat pengguna"><i class="fa fa-trash-o" style="color: #FFFFFF;"></i></span>
                                </button>
                                <!-- <a href="" class="btn btn-sm btn-info" data-toggle="modal" data-taraget="#myModal" title="Reset Katalaluan">
                                    <i class="fa fa-key"></i>
                                </a> -->
                            </td>
			    

                        </tr>
                        <?php 
                            $cnt = $cnt + 1;
                            $rs->movenext(); } ?>

                <?php //} else { ?>
                        <!--<tr>
                            <td colspan="8" align="center">-- Tiada Maklumat --</td>
                        </tr>-->
                <?php //}?>
                        
                    </tbody>
                </table>
            </div>
		</div>
     </div>


	<div class="card-footer">
        <?php 
            $href_f=$actual_link."&table_search=".$table_search;
            include 'include/list_footer.php'; 
        ?>  
    </div>

  </div>    

<script>
    $(function () {
        //Initialize Select2 Elements
        $('.select2').select2();
        //Initialize Select2 Elements
        $('.select2bs4').select2({
            theme: 'bootstrap4',
            maximumSelectionLength: 25,

            language: {
                // You can find all of the options in the language files provided in the
                // build. They all must be functions that return the string that should be
                // displayed.
                maximumSelected: function (e) {
                    var t = "PERHATIAN ! Telah Mencapai Had Maksimum Negeri";
                    // + e.maximum + " item";
                    e.maximum != 1;
                    return t;
                    // return t + ' - Upgrade Now and Select More';
                }
            }
            
        });
    });
</script>
<script src="../plugins/jquery/jquery.min.js"></script>
<script src="../plugins/select2/js/select2.full.min.js"></script>


          