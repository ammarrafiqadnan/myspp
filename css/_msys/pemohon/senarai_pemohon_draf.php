<?php //include '../connection/common.php'; ?>

<link href="vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
<link href="vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
<link href="vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
<link href="vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">

<?php
include 'pemohon/sql_pemohon.php';
// print_r($data);
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
                <h6 class="panel-title"><font color="#000000"><b>Maklumat Senarai Pemohon Draf</b></font></h6> 
            </header>
			</div>
            </div>            
            <br />
            <div class="box-body d-print-none" style="height: 40px;background-color:#F2F2F2;">
                <div class="row">
                    <div class="col-md-2">
                        <label for="">Tarikh Mula: </label>
                    </div>
                    <div class="col-md-3">
                        <input type="date" class="form-control">
                    </div>  
                    <div class="col-md-2">
                        <label for="">Tarikh Akhir: </label>
                    </div>
                    <div class="col-md-3">
                        <input type="date" class="form-control">
                    </div> 
                </div>   
            </div> 
            <div class="box-body d-print-none" style="height: 40px;background-color:#F2F2F2;">
                <div class="row">
                    <div class="col-md-2">
                        <label for="">Negeri: </label>
                    </div>
                    <div class="col-md-3">
                        <select name="tahun_list" id="tahun_list" class="form-control" onchange="do_page()">
                            <!-- <?php for($t=date("Y");$t>=2021;$t--){ ?>
                                <option value="<?=$t;?>" <?php if($t==$tahun_list){ print 'selected'; } ?>><?=$t;?></option>
                            <?php } ?> -->
                            <option value="">-- Sila pilih negeri --</option>
                            <option value="">Johor</option>
                            <option value="">Selangor</option>
                            <option value="">Negeri Sembilan</option>
                        </select>
                    </div>  
                    <div class="col-md-1">
                        <label for="">Carian: </label>
                    </div>
                    <div class="col-md-4" style="background-color:#F2F2F2">
                        <input type="text" name="carian" value="" class="form-control" placeholder="nama/no. kad pengenalan">
                    </div>
                    <div class="col-md-2" style="background-color:#F2F2F2">
                        <button type="button" class="btn btn-primary" onclick="do_page()">
                            <i class=" fa fa-search"></i> <font style="font-family:Verdana, Geneva, sans-serif">Cari</font>
                        </button>
                    </div>
                </div>   
            </div> 
			<br>
			<div class="box-body" style="background-color:#F2F2F2">
                <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                    <thead  style="background-color:rgb(38, 167, 228)">
                        <th width="5%"><font color="#000000"><div align="center">Bil</div></font></th>
                        <th width="35%"><font color="#000000"><div align="center">Nama Pemohon</div></font></th>
                        <th width="15%"><font color="#000000"><div align="center">No. Kad Pengenalan</div></font></th>
                        <th width="15%"><font color="#000000"><div align="center">Negeri</div></font></th>
                        <th width="10%"><font color="#000000"><div align="center">Daftar</div></font></th>
                        <th width="10%"><font color="#000000"><div align="center">Kemaskini</div></font></th>
                        <th width="10%" class="d-print-none"><font color="#000000"><div align="center">Tindakan</div></font></th>
                    </thead>
                    <tbody>
                
                    <?php 
                        // $conn->debug=true;
                        // $result = get_pemohon($conn, $uid, "103", $tahun, "1");
                        $pg = 1;
                        $pgSize = 10;
                        
                        // $rsPemohon = get_pemohon($conn, $pg, $pgSize);
                        $rsPemohon = get_pemohon($conn);

                        // print $rsPemohon;

                        // $p = (explode(":",$rsPemohon));

                        $bil=0;
                        
                        while(!$rsPemohon->EOF){ ?>	
                            <tr>
                                <td align="center"><?=++$bil;?></td>
                                <td align="left"><?=$rsPemohon->fields['nama_penuh']?></td>
                                <td align="center"><?=$rsPemohon->fields['ICNo']?></td>
                                <td align="center"><?=$rsPemohon->fields['diskripsi']?></td>
                                <td align="center"><?=DisplayDate($rsPemohon->fields['d_cipta']);  print '<br>'.DisplayMasa($rsPemohon->fields['d_cipta']);?></td>
                                <td align="center"><?=DisplayDate($rsPemohon->fields['d_kemaskini']);  print '<br>'.DisplayMasa($rsPemohon->fields['d_kemaskini']);?></td>
                                <td align="center" class="d-print-none">
                                    <a href="index.php?data=<?php print base64_encode('pemohon/maklumat_pemohon;Senarai Pemohon;Nama: '.$rsPemohon->fields['nama_penuh'].' (No.K/P: '.$rsPemohon->fields['ICNo'].');;;;'); ?>&id_pemohon=<?=$rsPemohon->fields['id_pemohon']?>">
                                        <button type="button" class="btn btn-sm btn-success">
                                            <span style="cursor:pointer;color:red" title="Maklumat Terperinci Pemohon">
                                                <i class="fa fa-search" style="color: #FFFFFF;"></i>
                                            </span>
                                        </button>
                                    </a>
                                    <a href="" onclick="window.print()">
                                        <button type="button" class="btn btn-sm btn-info">
                                            <span style="cursor:pointer;color:red" title="Cetak Semua Dokumen Pemohon">
                                                <i class="fa fa-print" style="color: #FFFFFF;"></i>
                                            </span>
                                        </button>
                                    </a>
                                </td>
                            </tr>
                        <?php $rsPemohon->movenext(); } ?>
                    </tbody>
                </table>
            </div>
		</div>
     </div>
  </div>    

          