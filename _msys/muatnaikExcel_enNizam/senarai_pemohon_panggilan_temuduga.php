<link href="../vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
<link href="../vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
<link href="../vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
<link href="../vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">
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
                        </div>
                        <h6 class="panel-title"><font color="#000000"><b>Senarai Panggilan Temuduga</b></font></h6> 
                    </header>
    			</div>
            </div>            
            <br />
            <div class="box-body" style="height: 40px;background-color:#F2F2F2;">
                <div class="row">
                    <div class="col-md-1">
                        <label for="">Carian: </label>
                    </div>
                    <div class="col-md-4" style="background-color:#F2F2F2">
                        <input type="text" name="carian" value="" class="form-control" placeholder="No. Perolehan/Nama/No. KP/Tempat">
                    </div>
                    <div class="col-md-2"  align="right" style="background-color:#F2F2F2">
                        <button type="button" class="btn btn-primary" onclick="do_page()" style="width:100%">
                            <i class=" fa fa-search"></i> <font style="font-family:Verdana, Geneva, sans-serif">Cari</font>
                        </button>
                    </div>
                    <div class="col-md-2" align="left">
                        <button class="btn btn-md btn-info" title="Muat Turun Excel" style="width:100%"><i class="fa fa-download"></i>  Muat Turun</button>
                    </div>
                    <div class="col-md-3">
                        <a href="muatnaikExcel/form_panggilan_temuduga_detail.php?kod=<?=$id;?>" class="btn btn-md btn-primary" data-toggle="modal" data-target="#myModal" title="Tambah Maklumat Panggilan Temuduga" style="width:100%">
                            <i class="fa fa-plus"></i> Muatnaik Panggilan Temuduga
                        </a>
                    </div>
                </div> 
            </div> 


        	<br>

            <?php
                // $conn->debug=true;
                $sql = "SELECT * FROM $schema2.`senarai_panggilan_temuduga` WHERE kod IS NOT NULL"; 
                $sSQL1 = "SELECT COUNT(*) as total FROM $schema2.`senarai_panggilan_temuduga` WHERE kod IS NOT NULL";
                include '../include/list_head.php';
                include '../include/page_list.php';
            ?>

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
                        <th width="10%"><font color="#000000"><div align="center">Dokumen <br><small style="color: #fff;">Nota: Tanda '/' jika dokumen pemohon telah disemak</small></div></font></th>
                        <th width="15%"><font color="#000000"><div align="center">Tindakan</div></font></th>

                    </thead>
                    <tbody>
                
                    <?php 
                        $cnt = 0;
                        $bil = 0; 
                        while(!$rs->EOF){ $bil2=0; 
                            $bil = $cnt + ($PageNo-1)*$PageSize; 
                            $id = $rs->fields['kod'];
                    ?>
                        <tr>
                            <td align="center"><?=++$bil;?></td>
                            <td align="center"></td>
                            <td align="center"><?=$rs->fields['nama_penuh'];?></td>
                            <td align="center"><?=$rs->fields['noKP'];?></td>
                            <td align="center"><?=$rs->fields['skim_jawatan'];?></td>
                            <td align="center"></td>
                            <td align="center"><?=$rs->fields['tempat'];?></td>
                            <td align="center">
                                <input type="checkbox" checked>
                            </td>
                            <td align="center">
                                <!-- <a href="index.php?data=<?php print base64_encode('pemohon/maklumat_pemohon;Senarai Pemohon;Nama: '.$rsPemohon->fields['nama_penuh'].' (No.K/P: '.$rsPemohon->fields['ICNo'].');;;;'); ?>&id_pemohon=<?=$rsPemohon->fields['id_pemohon']?>" class="btn btn-md btn-info" title="Maklumat Pemohon">
                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                </a> -->
                                <a href="index.php?data=<?php print base64_encode('pemohon/maklumat_pemohon;Senarai Pemohon;;;;;'); ?>" class="btn btn-md btn-info" title="Maklumat Pemohon">
                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                </a>
                                <a href="" class="btn btn-md btn-warning"  data-toggle="modal" data-target="#myModalSlip" title="Slip Pemohon">
                                    <i class="fa fa-certificate" aria-hidden="true"></i>
                                </a>
                                <a href="" class="btn btn-md btn-danger" data-toggle="modal" data-taraget="#myModal" title="Hapus Maklumat">
                                    <i class="fa fa-trash-o"></i>
                                </a>
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
                <a href="index.php?data=<?php print base64_encode('muatnaikExcel/senarai_panggilan_temuduga;Senarai Panggilan Temuduga;;;;;'); ?>" class="btn btn-md btn-success" title="Senarai Panggilan Temuduga">
                    <i class="fa fa-arrow-left" aria-hidden="true"></i> Kembali
                </a>
            </div>
		</div>
     </div>
  </div>  
  
  
<!--   <div class="modal fade bd-example-modal-lg" id="myModalSlip" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                            <embed src="../images/slip_panggilan.pdf" type='application/pdf' width='100%' height='800px' />
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
</div> -->

          