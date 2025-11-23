<link href="../vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
<link href="../vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
<link href="../vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
<link href="../vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">

<script>
    function do_page(href){
        // alert('sini');
        var carian = $('#carian').val();
        var jenis_hebahan2 = $('#jenis_hebahan2').val();
        var status2 = $('#status2').val();

        window.location.href = href+"&jenis_hebahan2="+jenis_hebahan2+'&status2='+status2+'&carian='+carian;
        
        
        // return sorturl;
    }

	function get_data(type,id) {
        $.ajax({
            url:'../connection/portal_sql.php?pro='+type, //&datas='+datas,
            type: 'POST',
            data: {val:id},
            success:function(data){
                // console.log(data);
                // alert(data[1]);
                document.getElementById('pengumuman').innerHTML = data[0];
                document.getElementById('tajuk').innerHTML = data[1];
                document.getElementById('maklumat').innerHTML = data[2];
            }
        }); 
    }   
    function get_data_pengumuman(type,id) {
        $.ajax({
            url:'../connection/portal_sql.php?pro='+type, //&datas='+datas,
            type: 'POST',
            data: {val:id},
            success:function(data){
                // console.log(data);
                // alert(data[1]);
                document.getElementById('pengumuman').innerHTML = data[0];
                document.getElementById('tajuk').innerHTML = data[1];
                document.getElementById('maklumat').innerHTML = data[2];
            }
        }); 
    }        

function open_pengumuman(type,id){
    $('#modalRegular').modal('show');
    get_data_pengumuman(type,id);
};

function do_close(){
        reload = window.location; 
        window.location = reload;
    }

</script>

<?php
$_SESSION['SESSADM_BACKURL']=$actual_link;
// $conn->debug=true;
$jenis_hebahan2=isset($_REQUEST["jenis_hebahan2"])?$_REQUEST["jenis_hebahan2"]:"";
$status2=isset($_REQUEST["status2"])?$_REQUEST["status2"]:"";
$carian=strtoupper(isset($_REQUEST["carian"])?$_REQUEST["carian"]:"");

$hrefs = 'index.php?data='.base64_encode('pengurusan/hebahan_maklumat;Pentadbiran;Hebahan Atau Makluman;ALL;;;');

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
                <h6 class="panel-title"><font color="#000000"><b>Senarai Maklumat Hebahan Atau Makluman</b></font></h6> 
            </header>
			</div>
            </div>            
            <br /> 
            <div class="col-md-12" style="background-color:#F2F2F2;">
                <div class="row" style="padding-bottom: 10px;">
                    <div class="col-md-2">
                        <label for="">Jenis Hebahan: </label>
                    </div>
                    <div class="col-md-3">
                        <select name="jenis_hebahan2" id="jenis_hebahan2" class="form-control"  onchange="do_page('<?=$hrefs;?>')">
                            <option value="">Sila pilih jenis hebahan</option>
                            <option value="1" <?php if($jenis_hebahan2 == 1){ print 'selected';} ?>>Awam</option>
                            <option value="2" <?php if($jenis_hebahan2 == 2){ print 'selected';} ?>>Dalaman</option>
                        </select>
                    </div> 
                    
                    <label for="nama" class="col-sm-1 control-label">Status:</label>
                    <div class="col-sm-3">
                        <select name="status2" id="status2" class="form-control" onchange="do_page('<?=$hrefs;?>')">
                            <option value="">Sila pilih status</option>
                            <option value="0" <?php if($status2 == 0){ print 'selected'; } ?>>Aktif</option>
                            <option value="1" <?php if($status2 == 1){ print 'selected'; } ?>>Tidak Aktif</option>
                        </select>
                    </div>
                    
                </div>   
            </div>
            <div class="col-md-12" style="background-color:#F2F2F2;">
                <div class="row" style="padding-bottom: 10px;">
                    <div class="col-md-2">
                        <label for="">Carian: </label>
                    </div>
                    <div class="col-md-4" style="background-color:#F2F2F2">
                        <input type="text" id="carian"  name="carian" value="<?=$carian;?>" class="form-control" placeholder="Tajuk Hebahan">
                    </div>
                    <div class="col-md-2" style="background-color:#F2F2F2">
                        <button type="button" class="btn btn-info" onclick="do_page('<?=$hrefs;?>')" title="Sila klik untuk membuat carian bagi maklumat hebahan atau makluman">
                            <i class=" fa fa-search"></i> <font style="font-family:Verdana, Geneva, sans-serif">Cari</font>
                        </button>
                    </div>
                </div>   
            </div>
            <br>
            <div class="col-md-12" align="right">
                <!--<a href="pengurusan/hebahan_maklumat_form.php?id=&jenis=edit" class="btn btn-md btn-primary" data-toggle="modal" data-target="#myModal" title="Tambah Maklumat Hebahan">
                    <i class="fa fa-plus"></i> Tambah Hebahan Atau Makluman
                </a>-->
		<a href="index.php?data=<?php print base64_encode('pengurusan/hebahan_maklumat_form;Pentadbiran;Hebahan Atau Makluman;ALL;;;'); ?>&id=&jenis=tambah"
					 class="btn btn-md btn-primary" title="Sila klik untuk membuat proses penambahan maklumat hebahan / makluman"><i class="fa fa-plus"></i> Tambah Hebahan Atau Makluman
                                </a>

		
            </div>
			<br>
            <?php
                //$conn->debug=true;
                $sql = "SELECT * FROM $schema2.`hebahan_makluman` WHERE is_deleted=0"; 

                if(!empty($jenis_hebahan2)){
                    $sql .= " AND jenis=".$jenis_hebahan2;
                }

                if($status2 == '0' || $status2 == '1'){
                    $sql .= " AND `status`=".$status2;
                }

                if(!empty($carian)){
                    $sql .= " AND tajuk LIKE '%".$carian."%'";
                }

                $sSQL1 = "SELECT COUNT(*) as total FROM $schema2.`hebahan_makluman` WHERE is_deleted=0";

                if(!empty($jenis_hebahan2)){
                    $sSQL1 .= " AND jenis=".$jenis_hebahan2;
                }

                if($status2 == '0' || $status2 == '1'){
                    $sSQL1 .= " AND `status`=".$status2;
                }

                if(!empty($carian)){
                    $sSQL1 .= " AND tajuk LIKE '%".$carian."%'";
                }

                include '../include/list_head.php';
                include '../include/page_list.php';
            ?>
			<div class="box-body" style="background-color:#F2F2F2">
                <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                    <thead  style="background-color:rgb(38, 167, 228)">
                        <th width="5%"><font color="#000000"><div align="center">No.</div></font></th>
                        <th width="10%"><font color="#000000"><div align="center">Jenis</div></font></th>
                        <th width="30%"><font color="#000000"><div align="center">Tajuk</div></font></th>
                        <th width="20%"><font color="#000000"><div align="center">Tarikh</div></font></th>
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
                            <td align="center">
                                <?php 
                                    if($rs->fields['jenis'] == 1){
                                        print 'AWAM';
                                    } else {
                                        print 'DALAMAN';
                                    }
                                ?>
                            </td>
                            <td><?=$rs->fields['tajuk'];?></td>
                            <td align="center"><?=date('d-m-Y',strtotime($rs->fields['tarikh_mula'])).'<br> hingga <br>'.date('d-m-Y',strtotime($rs->fields['tarikh_tamat']));?></td>
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
				
				<a href="index.php?data=<?php print base64_encode('pengurusan/hebahan_maklumat_form;Pentadbiran;Hebahan Atau Makluman;ALL;;;'); ?>&id=<?=$rs->fields['kod'];?>&jenis=edit"
					 class="btn btn-sm btn-success" title="Sila klik untuk membuat proses pengemaskinian maklumat hebahan / makluman"><i class="fa fa-edit"></i>
                                </a>


                                <!--<a href="pengurusan/hebahan_maklumat_form.php?id=<?=$rs->fields['kod'];?>&jenis=edit" class="btn btn-sm btn-success" data-toggle="modal"  data-backdrop="" 
data-target="#myModal-xl" title="Kemaskini Maklumat Hebahan">
                                    <i class="fa fa-edit"></i>
                                </a>-->
				<button type="button" class="btn btn-primary mt-sm mb-sm" onclick="open_pengumuman('ANN','<?=$rs->fields['kod'];?>')" 
 				title="Sila klik untuk melihat maklumat hebahan / makluman"><i class="fa fa-eye"></i></button>
						
                                <button type="button" class="btn btn-sm btn-danger" onclick="do_hapus('pengurusan/sql_pengurusan.php?frm=PENGURUSAN&pro=HAPUS&jenis=HEBAHAN_MAKLUMAN&id_hapus=<?=$rs->fields['kod'];?>')">
                                    <span style="cursor:pointer;color:red" title="Sila klik untuk menghapuskan maklumat hebahan / makluman"><i class="fa fa-trash-o" style="color: #FFFFFF;"></i></span>
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
     </div>
  </div>    


<div class="modal fade static" id="modalRegular" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg static" role="document">
        <!--Content-->
        <div class="modal-content static" >
        <div class="modal-header static" style="background-color:rgb(38, 167, 228)">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="do_close()">X</button>
            <h4 class="modal-title" id="pengumuman">Maklumat Pengumuman</h4>
            
          </div>

	<!--<div class="modal-header static"  style="background-color:rgb(38, 167, 228)">
            <button type="button" id="pengumuman" class="close" data-dismiss="modal" aria-hidden="true" onclick="do_close()">X</button>
			<h6 class="panel-title"><font color="#000000" size="3"><b> MAKLUMAT PENGUMUMAN</b></font></h6>
		</div>-->


          <!--Body-->
            <div class="modal-body">
                <div class="col-md-12">    
                    <div class="form-group">
                        <div id="tajuk" class="modal-title" style="font-size:16px;font-weight: bold;"></div><br>
                        <div id="maklumat"></div>
                    </div>
                </div>
            </div>
          <!--Footer-->
          <div class="modal-footer justify-content-center">
            <button type="button" class="btn btn-default" onclick="do_close()"><i class="fa fa-spinner" style="margin:0px;"></i> Kembali</button>
          </div>

        </div>
        <!--/.Content-->

      </div>
    </div>
          