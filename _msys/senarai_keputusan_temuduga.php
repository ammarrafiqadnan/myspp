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
                <h6 class="panel-title"><font color="#000000"><b>Maklumat Senarai Keputusan Temuduga</b></font></h6> 
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
                        <button class="btn btn-md btn-primary" title="Muatnaik excel senarai keputusan temuduga">
                           <i class="fa fa-upload"></i> Muatnaik excel senarai keputusan temuduga
                        </button>
                    </div>
                </div>   
            </div>
			<br>
			<div class="box-body" style="background-color:#F2F2F2">
                <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                    <thead  style="background-color:rgb(38, 167, 228)">
                        <th width="5%"><font color="#000000"><div align="center">No.</div></font></th>
                        <th width="45%"><font color="#000000"><div align="center">Nama Penuh</div></font></th>
                        <th width="15%"><font color="#000000"><div align="center">No. K/P</div></font></th>
                        <th width="15%"><font color="#000000"><div align="center">Tarikh</div></font></th>
                        <th width="15%"><font color="#000000"><div align="center">No. Tel</div></font></th>
                        <th width="15%"><font color="#000000"><div align="center">Kelayakan <br><small style="color: #fff;">Nota: Tanda '/' jika pemohon layak ditemuduga</small></div></font></th>
                        <th width="5%"><font color="#000000"><div align="center">Tindakan</div></font></th>

                    </thead>
                    <tbody>
                
                        <tr>
                            <td align="center">1.</td>
                            <td>Ahmad</td>
                            <td>xxxxxx-xx-xxxx</td>
                            <td>10/11/2022</td>
                            <td>xxx-xxxxxxxx</td>
                            <td align="center">
                                <input type="checkbox" checked>
                            </td>
                            <td align="center">
                                <a href="" class="btn btn-md btn-danger" data-toggle="modal" data-taraget="#myModal" title="Hapus Maklumat">
                                    <i class="fa fa-trash-o"></i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td align="center">2.</td>
                            <td>Aminah</td>
                            <td>xxxxxx-xx-xxxx</td>
                            <td>10/11/2022</td>
                            <td>xxx-xxxxxxxx</td>
                            <td align="center">
                                <input type="checkbox">
                            </td>
                            <td align="center">
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

          