<link href="vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
<link href="vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
<link href="vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
<link href="vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">
<!-- <style>
    input#file {
  display: inline-block;
  width: 30%;
  padding: 120px 0 0 0;
  height: 100px;
  overflow: hidden;
  -webkit-box-sizing: border-box;
  -moz-box-sizing: border-box;
  box-sizing: border-box;
  background: url('https://cdn1.iconfinder.com/data/icons/hawcons/32/698394-icon-130-cloud-upload-512.png') center center no-repeat #e4e4e4;
  border-radius: 20px;
  background-size: 60px 60px;
}
</style> -->
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
                <h6 class="panel-title"><font color="#000000"><b>Senarai Panggilan Temuduga</b></font></h6> 
            </header>
			</div>
            </div>            
            <br />
            <div class="box-body" style="height: 40px;background-color:#F2F2F2;">
                <div class="row">
                    <!-- <div class="col-md-1">
                        <label for="">Tahun: </label>
                    </div>
                    <div class="col-md-2">
                        <select name="tahun_list" id="tahun_list" class="form-control" onchange="do_page()">
                            <option value="">Sila pilih tahun</option>
                            <?php for($t=date("Y");$t>=2021;$t--){ ?>
                                <option value="<?=$t;?>" <?php if($t==$tahun_list){ print 'selected'; } ?>><?=$t;?></option>
                            <?php } ?>
                        </select>
                    </div>   -->
                    <!-- <div class="col-md-1">
                        <label for="">Bulan: </label>
                    </div>
                    <div class="col-md-2">
                        <select name="tahun_list" id="tahun_list" class="form-control" onchange="do_page()">
                            <option value="">Januari</option>
                        </select>
                    </div>   -->
                    <div class="col-md-1">
                        <label for="">Carian: </label>
                    </div>
                    <div class="col-md-7" style="background-color:#F2F2F2">
                        <input type="text" name="carian" value="" class="form-control" placeholder="No. Perolehan/Nama/No. KP/Tempat">
                    </div>
                    <div class="col-md-2"  align="right" style="background-color:#F2F2F2">
                        <button type="button" class="btn btn-primary" onclick="do_page()">
                            <i class=" fa fa-search"></i> <font style="font-family:Verdana, Geneva, sans-serif">Cari</font>
                        </button>
                    </div>
                    <!-- <div class="col-md-2" style="padding-right: 0px;"  align="right">
                        <button class="btn btn-md btn-success" style="display:block;"><i class="fa fa-check"></i>  Publish</button>
                        <input type='file' id="getFile" style="display:none">
                    </div> -->
                    <div class="col-md-2" align="left">
                        <button class="btn btn-md btn-info" title="Muat Turun Excel"><i class="fa fa-download"></i>  Muat Turun</button>
                        <input type='file' id="getFile" style="display:none">
                        <!-- <button class="btn btn-md btn-info" style="display:block;" onclick="document.getElementById('getFile').click()"><i class="fa fa-download"></i>  Muat Turun</button>
                        <input type='file' id="getFile" style="display:none"> -->
                    </div>
                </div> 
            </div> 
			<br>
			<div class="box-body" style="background-color:#F2F2F2">
                <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                    <thead  style="background-color:rgb(38, 167, 228)">
                        <th width="5%"><font color="#000000"><div align="center">No.</div></font></th>
                        <th width="10%"><font color="#000000"><div align="center">No. Pemerolehan</div></font></th>
                        <th width="20%"><font color="#000000"><div align="center">Nama</div></font></th>
                        <th width="10%"><font color="#000000"><div align="center">No. K/P</div></font></th>
                        <th width="10%"><font color="#000000"><div align="center">Skim Jawatan</div></font></th>
                        <th width="10%"><font color="#000000"><div align="center">Tarikh/ Masa</div></font></th>
                        <th width="10%"><font color="#000000"><div align="center">Tempat</div></font></th>
                        <th width="10%"><font color="#000000"><div align="center">Dokumen <br><small style="color: #fff;">Nota: Tanda '/' jika dokumen pemohon telah disemak</small></div></font></th>
                        <th width="15%"><font color="#000000"><div align="center">Tindakan</div></font></th>

                    </thead>
                    <tbody>
                
                        <tr>
                            <td align="center">1.</td>
                            <td align="center">20222139</td>
                            <td>AHMAD LUQMAN BIN AHMAD KAMIL</td>
                            <td>950205665057</td>
                            <td>PEGAWAI PERKHIDMATAN PENDIDIKAN GRED DH41</td>
                            <td>Tarikh : 10/11/2022 <br> Masa : 9.00 AM</td>
                            <td>SPP</td>
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
                        <tr>
                            <td align="center">2.</td>
                            <td align="center">20221232</td>
                            <td>MOHD KHAIRUL AMRIK BIN MD YUSUP</td>
                            <td>860613915079	</td>
                            <td>PEGAWAI PERKHIDMATAN PENDIDIKAN GRED DH41</td>
                            <td>Tarikh : 10/11/2022 <br> Masa : 9.10 AM</td>
                            <td>SPP</td>
                            <td align="center">
                                <input type="checkbox">
                            </td>
                            <td align="center">
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
                    </tbody>
                </table>

                <a href="index.php?data=<?php print base64_encode('senarai_panggilan_temuduga;Senarai Panggilan Temuduga;;;;;'); ?>" class="btn btn-md btn-success" title="Senarai Panggilan Temuduga">
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
                            <!-- <img src="../images/slip_panggilan.pdf" width="130" height="150"> -->
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
</div>

          