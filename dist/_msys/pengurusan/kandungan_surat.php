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
                <h6 class="panel-title"><font color="#000000"><b>Senarai Kandungan Surat</b></font></h6> 
            </header>
			</div>
            </div>            
            <br /> 
            <div class="box-body" style="height: 40px;background-color:#F2F2F2;">
                <div class="row">
                    <div class="col-md-2">
                        <label for="">Jenis Surat: </label>
                    </div>
                    <div class="col-md-3">
                        <select name="jenis_surat" id="jenis_surat" class="form-control" onchange="do_page()">
                            <option value="">-- Sila pilih jenis surat --</option>
                            <option value="">Panggilan Temuduga</option>
                            <option value="">Keputusan Temuduga</option>
                            <option value="">Tawaran Jawatan</option>
                        </select>
                    </div>  
                    <label for="nama" class="col-sm-1 control-label">Status:</label>
                    <div class="col-sm-3">
                        <select name="status" id="status" class="form-control">
                            <option value="">Sila pilih status</option>
                            <option value="">Aktif</option>
                            <option value="">Tidak Aktif</option>
                        </select>
                    </div>
                    
                </div>   
            </div>
            <div class="box-body" style="height: 40px;background-color:#F2F2F2;">
                <div class="row">
                    <div class="col-md-2">
                        <label for="">Carian: </label>
                    </div>
                    <div class="col-md-4" style="background-color:#F2F2F2">
                        <input type="text" name="carian" value="" class="form-control" placeholder="Tajuk Surat">
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
                <a href="pengurusan/kandungan_surat_form.php?id=" class="btn btn-md btn-primary" data-toggle="modal" data-target="#myModal" title="Tambah Maklumat Hebahan">
                    <i class="fa fa-plus"></i> Tambah Surat
                </a>
            </div>
			<br>
			<div class="box-body" style="background-color:#F2F2F2">
                <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                    <thead  style="background-color:rgb(38, 167, 228)">
                        <th width="5%"><font color="#000000"><div align="center">No.</div></font></th>
                        <th width="15%"><font color="#000000"><div align="center">Jenis Surat</div></font></th>
                        <th width="50%"><font color="#000000"><div align="center">Tajuk Surat</div></font></th>
                        <th width="5%"><font color="#000000"><div align="center">Status</div></font></th>
                        <th width="5%"><font color="#000000"><div align="center">Tindakan</div></font></th>
                    </thead>
                    <tbody>
                
                        <tr>
                            <td align="center">1.</td>
                            <td align="center">Temuduga</td>
                            <td>Surat Panggilan Temuduga</td>
                            <td align="center"><button class="btn-success badge">Aktif</button></td>
                            <td align="center">
                                <a href="" class="btn btn-md btn-success" data-toggle="modal" data-taraget="#myModal">
                                    <i class="fa fa-edit"></i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td align="center">2.</td>
                            <td align="center">Temuduga</td>
                            <td>Surat Keputusan Temuduga</td>
                            <td align="center"><button class="btn-danger badge">Tidak Aktif</button></td>
                            <td align="center">
                                <a href="" class="btn btn-md btn-success" data-toggle="modal" data-taraget="#myModal">
                                    <i class="fa fa-edit"></i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td align="center">2.</td>
                            <td align="center">Permohonan</td>
                            <td>Surat Tawaran Jawatan</td>
                            <td align="center"><button class="btn-danger badge">Tidak Aktif</button></td>
                            <td align="center">
                                <a href="" class="btn btn-md btn-success" data-toggle="modal" data-taraget="#myModal">
                                    <i class="fa fa-edit"></i>
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
		</div>
     </div>
  </div>    

          