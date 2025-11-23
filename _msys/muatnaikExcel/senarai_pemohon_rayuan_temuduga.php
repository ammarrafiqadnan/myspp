<link href="../vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
<link href="../vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
<link href="../vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
<link href="../vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">
<script>
    function sortorder(href, val, fieldname){
        // alert('sini');
        var carian = $('#carian').val();

        window.location.href = href+"&carian="+carian;
        
        
        // return sorturl;
    }
</script>
<?php
// $conn->debug=true;
$JFORM='LIST';
$carian=strtoupper(isset($_REQUEST["carian"])?$_REQUEST["carian"]:"");

$hrefs = 'index.php?data='.base64_encode('muatnaikExcel/senarai_pemohon_rayuan_temuduga;PENGURUSAN;Senarai Rayuan Temu Duga;;;1;');
?>


		<div class="box" style="background-color:#F2F2F2">

            <div class="box-body">
        	<input type="hidden" name="id" value="" />
                <div class="x_panel">
        			<header class="panel-heading"  style="background-color:rgb(38, 167, 228)">
                        <div class="panel-actions">
                        </div>
                        <h6 class="panel-title"><font color="#000000"><b>Senarai Rayuan Temuduga</b></font></h6> 
                    </header>
    			</div>
            </div>            
            <br />
            <div class="box-body" style="height: 40px;background-color:#F2F2F2;">
                <div class="row">
                    <div class="col-md-1">
                        <label for="">Carian: </label>
                    </div>
                    <div class="col-md-3" style="background-color:#F2F2F2">
                        <input type="text" id="carian" name="carian" value="<?=$carian;?>" class="form-control" placeholder="No. Perolehan/Nama/No. KP/Tempat">
                    </div>
                    <div class="col-md-2"  align="right" style="background-color:#F2F2F2">
                        <button type="button" class="btn btn-primary" onclick="sortorder('<?=$hrefs;?>',this.value)" style="width:100%">
                            <i class=" fa fa-search"></i> <font style="font-family:Verdana, Geneva, sans-serif">Cari</font>
                        </button>
                    </div>
                    <div class="col-md-1">
                        <a href="" class="btn btn-md btn-success" data-toggle="tooltip" data-title="Salin Maklumat Kepada excel/csv" onclick="do_print('cetak.php?pages=muatnaikExcel/rayuan_temuduga_cetak&prn=EXCEL&filename=senarai_rayuan_temuduga')" >
                            <i class="fa fa-file-excel-o" aria-hidden="true"></i>
                        </a>
                    </div>
                    <div class="col-md-2" align="left">
                        <button class="btn btn-md btn-info" title="Muat Turun Excel" style="width:100%"><i class="fa fa-download"></i>  Muat Turun Dokumen</button>
                    </div>
                    <div class="col-md-3">
                        <a href="muatnaikExcel/form_rayuan_temuduga_detail.php?kod=<?=$id;?>" class="btn btn-md btn-primary" data-toggle="modal" data-target="#myModal" title="Tambah Maklumat Rayuan Temuduga" style="width:100%">
                            <i class="fa fa-plus"></i> Muatnaik Rayuan Temuduga
                        </a>
                    </div>
                </div> 
            </div> 


        	<br>

            <?php
                 //$conn->debug=true;

                $sql3 = "SELECT * FROM $schema2.`rayuan_temuduga` WHERE kod='{$id}'";
                $rsPT = $conn->query($sql3);

                $sql = "SELECT * FROM $schema2.`senarai_rayuan_temuduga` WHERE kod IS NOT NULL AND is_deleted=0 AND kod_rayuan_temuduga='{$id}'"; 
                if(!empty($carian)){
                    $sql .= " AND (nama_penuh LIKE '%".$carian."%' OR noKP LIKE '%".$carian."%' OR skim_jawatan LIKE '%".$carian."%' OR no_pemerolehan LIKE '%".$carian."%')";
                }
                $sSQL1 = "SELECT COUNT(*) as total FROM $schema2.`senarai_rayuan_temuduga` WHERE kod IS NOT NULL AND is_deleted=0 AND kod_rayuan_temuduga='{$id}'";
                include '../include/list_head.php';
                include '../include/page_list.php';
            ?>
            <h4><b> Tajuk Hebahan : <?php print $rsPT->fields['tajuk']; ?></b></h4>
			<div class="box-body" style="background-color:#F2F2F2">
                <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                    <thead  style="background-color:rgb(38, 167, 228)">
                        <th width="5%"><font color="#000000"><div align="center">No.</div></font></th>
                        <th width="10%"><font color="#000000"><div align="center">No. Pemerolehan</div></font></th>
                        <th width="15%"><font color="#000000"><div align="center">Nama</div></font></th>
                        <th width="10%"><font color="#000000"><div align="center">No. K/P</div></font></th>
                        <th width="15%"><font color="#000000"><div align="center">Skim Jawatan</div></font></th>
                        <th width="10%"><font color="#000000"><div align="center">Tarikh/ Masa</div></font></th>
                        <th width="15%"><font color="#000000"><div align="center">Tempat</div></font></th>
                        <!-- <th width="10%"><font color="#000000"><div align="center">Dokumen <br><small style="color: #fff;">Nota: Tanda '/' jika dokumen pemohon telah disemak</small></div></font></th> -->
                        <th width="15%"><font color="#000000"><div align="center">Tindakan</div></font></th>

                    </thead>
                    <tbody>
                
                    <?php 
                        $cnt = 0;
                        $bil = 0; 
                        while(!$rs->EOF){ $bil2=0; 
                            $bil = $cnt + ($PageNo-1)*$PageSize; 
                            $id = $rs->fields['kod'];

                            $id_pemohon = dlookup($schema2.'.calon','id_pemohon','ICNo='.$rs->fields['noKP']);
                            
                    ?>
                        <tr>
                            <td align="center"><?=++$bil;?></td>
                            <td align="center"></td>
                            <td align="center"><?=$rs->fields['nama_penuh'];?></td>
                            <td align="center"><?=$rs->fields['noKP'];?></td>
                            <td align="center"><?=$rs->fields['skim_jawatan'];?></td>
                            <td align="center"><?=date('d-m-Y',strtotime($rs->fields['tarikh'])).'<br>'.date('h:i A',strtotime($rs->fields['masa']));?></td>
                            <td align="center"><?=$rs->fields['tempat'];?></td>
                            <!-- <td align="center">
                                <input type="checkbox" checked>
                            </td> -->
                            <td align="center">
                                <!-- <a href="index.php?data=<?php print base64_encode('pemohon/maklumat_pemohon;Senarai Pemohon;Nama: '.$rs->fields['nama_penuh'].' (No.K/P: '.$rs->fields['noKP'].');;;;'); ?>&id_pemohon=<?=$id_pemohon;?>" class="btn btn-md btn-info" title="Maklumat Pemohon">
                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                </a> -->
                                <a href="index.php?data=<?php print base64_encode('pemohon/maklumat_pemohon;Senarai Pemohon;Nama: '.$rs->fields['nama_penuh'].' (No.K/P: '.$rs->fields['noKP'].');;;;'); ?>&id_pemohon=<?=$id_pemohon;?>">
                                    <button type="button" class="btn btn-sm btn-info">
                                        <span style="cursor:pointer;color:red" title="Maklumat Terperinci Pemohon">
                                            <i class="fa fa-search" style="color: #FFFFFF;"></i>
                                        </span>
                                    </button>
                                </a>

                                <!-- <a href="index.php?data=<?php print base64_encode('pemohon/maklumat_pemohon;Senarai Pemohon;;;;;'); ?>" class="btn btn-md btn-info" title="Maklumat Pemohon">
                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                </a> -->
                                <a href="" class="btn btn-md btn-warning"  data-toggle="modal" data-target="#myModalSlip" title="Slip Pemohon">
                                    <i class="fa fa-certificate" aria-hidden="true"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-danger" onclick="do_hapus('muatnaikExcel/sql_muatnaikExcel.php?frm=PEMOHON_RAYUAN_TEMUDUGA&pro=HAPUS&kod=<?=$rs->fields['kod'];?>')">
                                    <span style="cursor:pointer;color:red" title="Hapus maklumat rayuan temuduga"><i class="fa fa-trash-o" style="color: #FFFFFF;"></i></span>
                                </button>
                            </td>
                        </tr>
                    <?php 
                        $cnt = $cnt + 1;
                        $rs->movenext(); } 
                    ?>
                    </tbody>
                </table>

                <div class="card-footer">
                    <?php 
                        $href_f=$actual_link."&table_search=".$table_search;
                        include 'include/list_footer.php'; 
                    ?>  
                </div>
                <a href="index.php?data=<?php print base64_encode('muatnaikExcel/senarai_rayuan_temuduga;Senarai Rayuan Temuduga;;;;;'); ?>" class="btn btn-md btn-success" title="Senarai Rayuan Temuduga">
                    <i class="fa fa-arrow-left" aria-hidden="true"></i> Kembali
                </a>
            </div>
		</div>
     </div>
  </div>  
  
  
  <div class="modal fade bd-example-modal-lg" id="myModalSlip" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #0088cc">
        <h5 class="modal-title" id="exampleModalLabel" style="color: #fff">Slip Pemohon</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="col-md-12">
                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-12">
                            <embed src="../images/slip_rayuan.pdf" type='application/pdf' width='100%' height='800px' />
                        </div>
                    </div>
                </div>
            </div>
      </div>
      
      <div class="modal-footer" style="padding-top: 180px;">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
        <button type="button" class="btn btn-primary">Simpan</button>
      </div>
    </div>
  </div>
</div>

          