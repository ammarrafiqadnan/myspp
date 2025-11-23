<link href="vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
<link href="vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
<link href="vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
<link href="vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">

<?php
$JFORM='LIST';
$carian=strtoupper(isset($_REQUEST["carian"])?$_REQUEST["carian"]:"");
?>

        <header class="panel-heading"  style="background-color:rgb(38, 167, 228)">
            <h6 class="panel-title"><font color="#000000" size="3"><b><?php print strtoupper($menu);?></b></font></h6>
        </header>
		<div class="box" style="background-color:#F2F2F2">

            <div class="box-body">
        	<input type="hidden" name="id" value="" />
            <div class="x_panel">
			<!-- <header class="panel-heading"  style="background-color:rgb(38, 167, 228)">
                <div class="panel-actions">
                </div>
                <h6 class="panel-title"><font color="#000000"><b>Maklumat Senarai Panggilan Temuduga</b></font></h6> 
            </header> -->
            
            <!-- <header class="panel-heading"  style="background-color:rgb(38, 167, 228)">
                <h6 class="panel-title"><font color="#000000" size="3"><b><?php print strtoupper($menu);?></b></font></h6>
            </header> -->
			</div>
            </div>            
            <br />
            <div class="box-body" style="height: 40px;background-color:#F2F2F2;">
                <div class="row">
                    <div class="col-md-1">
                        <label for="">Tahun: </label>
                    </div>
                    <div class="col-md-2">
                        <select name="tahun_list" id="tahun_list" class="form-control" onchange="do_page()">
                            <option value="">Sila pilih tahun</option>
                            <!-- <?php for($t=date("Y");$t>=2021;$t--){ ?>
                                <option value="<?=$t;?>" <?php if($t==$tahun_list){ print 'selected'; } ?>><?=$t;?></option>
                            <?php } ?> -->
                        </select>
                    </div>  
                    <div class="col-md-1">
                        <label for="">Bulan: </label>
                    </div>
                    <div class="col-md-2">
                        <select name="tahun_list" id="tahun_list" class="form-control" onchange="do_page()">
                            <option value="">Januari</option>
                        </select>
                    </div>  
                    <div class="col-md-1">
                        <label for="">Carian: </label>
                    </div>
                    <div class="col-md-3" style="background-color:#F2F2F2">
                        <input type="text" name="carian" value="" class="form-control" placeholder="ID Pengguna/Nama/No.telefon">
                    </div>
                    <div class="col-md-2" style="background-color:#F2F2F2">
                        <button type="button" class="btn btn-primary" onclick="do_page()">
                            <i class=" fa fa-search"></i> <font style="font-family:Verdana, Geneva, sans-serif">Cari</font>
                        </button>
                    </div>
                </div>   
            </div> 
            <br>
            <div class="box-body" style="height: 40px;background-color:#F2F2F2;">
                <div class="row">
                     <!--<div class="col-md-1">
                        <label for="">Peranan: </label>
                    </div>
                    <div class="col-md-4">
                        <select name="tahun_list" id="tahun_list" class="form-control" onchange="do_page()">
                            <option value="">-- Sila pilih peranan --</option>
                            <option value="">Pentadbir</option>
                            <option value="">Meja Bantu</option>

                        </select>
                    </div>   -->
                    
                    <div class="col-md-12" align="right">
                        <!-- <button class="btn btn-md btn-primary" title="Muatnaik excel senarai panggilan temuduga">
                           <i class="fa fa-upload"></i> Muatnaik excel senarai panggilan temuduga
                        </button> -->
                        <!-- <button class="btn btn-md btn-primary" data-toggle="modal" data-taraget="#myModalPanggilan" title="Tambah Panggilan Temuduga">
                           <i class="fa fa-plus"></i> Tambah Panggilan Temuduga
                        </button> -->

                        <button type="button" class="btn btn-md btn-primary" data-toggle="modal" data-target="#myModalPanggilan">
                        <i class="fa fa-plus"></i> Tambah Panggilan Temuduga
                        </button>
                    </div>
                </div>   
            </div>
			<br>
			<div class="box-body" style="background-color:#F2F2F2">
                <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                    <thead  style="background-color:rgb(38, 167, 228)">
                        <th width="5%"><font color="#000000"><div align="center">No.</div></font></th>
                        <th width="40%"><font color="#000000"><div align="center">Tajuk/ Jawatan Panggilan</div></font></th>
                        <th width="15%"><font color="#000000"><div align="center">Tarikh/ Masa Publish</div></font></th>
                        <th width="10%"><font color="#000000"><div align="center">Tindakan</div></font></th>

                    </thead>
                    <tbody>
                
                        <tr>
                            <td align="center">1.</td>
                            <td>PENGAMBILAN TEMUDUGA UNTUK PEGAWAI PERKHIDMATAN PENDIDIKAN GRED DH41</td>
                            <td>Tarikh : 10/11/2022 <br> Masa : 9.00 pagi </td>
                            <td align="center">
                                <a href="" class="btn btn-md btn-warning"  data-toggle="modal" data-target="#myModalPanggilan" title="Kemaskini Maklumat">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <a href="index.php?data=<?php print base64_encode('senarai_pemohon_panggilan_temuduga;PENGURUSAN;Senarai Panggilan Temu Duga;;;;'); ?>" class="btn btn-md btn-success" title="Senarai Panggilan Temuduga">
                                <!-- <a href="index.php?data=<?php print base64_encode('senarai_panggilan_temuduga;PENGURUSAN;Senarai Panggilan Temu Duga;;;;'); ?>"> -->
                                    <i class="fa fa-list"></i>
                                </a>
                                <a href="" class="btn btn-md btn-danger" data-toggle="modal" data-taraget="#myModal" title="Hapus Maklumat">
                                    <i class="fa fa-trash-o"></i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td align="center">2.</td>
                            <td>PENGAMBILAN TEMUDUGA UNTUK PEGAWAI PERKHIDMATAN PENDIDIKAN GRED DG29</td>
                            <td>Tarikh : 10/02/2022 <br> Masa : 9.00 pagi </td>
                            <td align="center">
                                <a href="" class="btn btn-md btn-warning"  data-toggle="modal" data-target="#myModalPanggilan" title="Kemaskini Maklumat">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <a href="index.php?data=<?php print base64_encode('senarai_pemohon_panggilan_temuduga;Senarai Panggilan Temuduga;;;;;'); ?>" class="btn btn-md btn-success" title="Senarai Panggilan Temuduga">
                                    <i class="fa fa-list"></i>
                                </a>
                                <a href="" class="btn btn-md btn-danger" data-toggle="modal" data-taraget="#myModal" title="Hapus Maklumat">
                                    <i class="fa fa-trash-o"></i>
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
		</div>
     </div>
  </div>  
  
  

  <div class="modal fade" id="myModalPanggilan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #0088cc">
        <h5 class="modal-title" id="exampleModalLabel" style="color: #fff">Maklumat Panggilan Temuduga</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="col-md-12">
                <div class="form-group">
                    <div class="row">
                        <label for="nama" class="col-sm-2 control-label"><b>Tajuk/ Jawatan<div style="float:right">:</div></b></label>
                        <div class="col-sm-8">
                            <input type="text" name="" id="" class="form-control" value="">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <label for="nama" class="col-sm-2 control-label"><b> Dokumen<div style="float:right">:</div></b></label>
                        <div class="col-sm-8">
                            <input type="file" name="" id="" class="form-control" value="">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <label for="nama" class="col-sm-2 control-label"><b> Tarikh Mula Hebah<div style="float:right">:</div></b></label>
                        <div class="col-sm-2">
                            <input type="date" name="" id="" class="form-control" value="">
                        </div>
                        <label for="nama" class="col-sm-2 control-label"><b> Masa Mula Hebah<div style="float:right">:</div></b></label>
                        <div class="col-sm-2">
                            <input type="time" name="" id="" class="form-control" value="">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <label for="nama" class="col-sm-2 control-label"><b> Tarikh Tamat Hebah<div style="float:right">:</div></b></label>
                        <div class="col-sm-2">
                            <input type="date" name="" id="" class="form-control" value="">
                        </div>
                        <label for="nama" class="col-sm-2 control-label"><b> Masa Tamat Hebah<div style="float:right">:</div></b></label>
                        <div class="col-sm-2">
                            <input type="time" name="" id="" class="form-control" value="">
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

          