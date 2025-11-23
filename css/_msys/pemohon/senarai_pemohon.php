<?php //include '../connection/common.php'; ?>

<link href="vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
<link href="vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
<link href="vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
<link href="vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">
<!-- <script src="cdn.datatables.net/1.10.4/js/jquery.dataTables.min.js"></script>       
  <link  href="cdn.datatables.net/1.10.4/css/jquery.dataTables.min.css">            
  <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>  
  <script type="text/javascript" src="myJSFile.js"></script> -->

<script>
    $(document).ready(function()
    {
        $('#datatable-responsive').DataTable();
    });
</script>
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
    <div class="box-body d-print-none" style="height: 40px;background-color:#F2F2F2;">
        <div class="row">
            <div class="col-md-2">
                <label for="">Tarikh Mula Kemas kini: </label>
            </div>
            <div class="col-md-3">
                <input type="date" class="form-control">
            </div>  
            <div class="col-md-1">
                <label for=""></label>
            </div>
            <div class="col-md-3" align="right">
                <label for="">Tarikh Akhir Kemas kini: </label>
            </div>
            <div class="col-md-3">
                <input type="date" class="form-control">
            </div> 
        </div>   
    </div> 
    <div class="box-body d-print-none" style="height: 40px;background-color:#F2F2F2;">
        <div class="row">
            <div class="col-md-2">
                <label for="">Jenis Skim: </label>
            </div>
            <div class="col-md-4">
                <?php
                    // $conn->debug=true;
                    $sql2 = "SELECT DISKRIPSI, KOD FROM $schema1.`ref_skim`";
                    $rsSkim = $conn->query($sql2);
                ?>

                <select name="skim" id="skim" class="form-control">
                    <option value="">Sila pilih skim jawatan</option>
                    <?php while(!$rsSkim->EOF){ $skim_code = $rsSkim->fields['KOD']; ?>    
                        <option value="<?=$skim_code;?>"><?php print $rsSkim->fields['DISKRIPSI'];?></option>
                    <?php $rsSkim->movenext(); } ?>
                </select>
            </div>  
            <div class="col-md-3" align="right">
                <label for="">Turutan Skim: </label>
            </div>
            <div class="col-md-3" style="background-color:#F2F2F2">
                <select name="negeri" id="negeri" class="form-control">
                    <option>Sila pilih turutan skim</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                </select>
            </div>
        </div>   
    </div> 
    <div class="box-body d-print-none" style="height: 40px;background-color:#F2F2F2;">
        <div class="row">
            <div class="col-md-2">
                <label for="">Negeri: </label>
            </div>
            <div class="col-md-3">
                <?php
                    $sql3 = "SELECT * FROM $schema2.`ref_negeri` WHERE `status`= 0";
                    $rsState = $conn->query($sql3);
                ?>
                <select name="negeri" id="negeri" class="form-control">
                    <option value="">Sila pilih Negeri</option>
                    <?php while(!$rsState->EOF){ $state_code = $rsState->fields['kod']; ?>    
                        <option value="<?=$state_code;?>"><?php print $rsState->fields['diskripsi2'];?></option>
                    <?php $rsState->movenext(); } ?>
                </select>
            </div> 
            <div class="col-md-1">
                <label for=""></label>
            </div>
            <div class="col-md-3" align="right">
                <label for="">Status: </label>
            </div> 
            <div class="col-md-2">
                <select name="status" id="status" class="form-control">
                    <option value="0">Draf</option>
                    <option value="1">Hantar</option>
                </select>
            </div> 
        </div>   
    </div> 
    <div class="box-body d-print-none" style="height: 40px;background-color:#F2F2F2;">
        <div class="row">
            <div class="col-md-2">
                <label for="">Carian: </label>
            </div>
            <div class="col-md-4" style="background-color:#F2F2F2">
                <input type="text" name="carian" id="carian" value="" class="form-control" placeholder="nama/no. kad pengenalan">
            </div>
            <div class="col-md-2" style="background-color:#F2F2F2">
                <button type="button" class="btn btn-primary">
                    <i class=" fa fa-search"></i> <font style="font-family:Verdana, Geneva, sans-serif">Cari</font>
                </button>
            </div>
            <div class="col-md-2" align="right">
                <a href="" class="btn btn-md btn-success" data-toggle="tooltip" data-title="Salin Maklumat Kepada excel/csv">
                    <i class="fa fa-file-excel-o" aria-hidden="true"></i>
                </a>
                <a href="" class="btn btn-md btn-warning" data-toggle="tooltip" data-title="Salin Maklumat Kepada pdf">
                    <i class="fa fa-file-pdf-o" aria-hidden="true"></i>
                </a>
            </div>
            <div class="col-md-2" style="background-color:#F2F2F2; padding-left: 0px;">
                <a href="pemohon/dokumen_form.php?id=" class="btn btn-md btn-primary" data-toggle="modal" data-target="#myModal" title="Cetak Dokumen-dokumen Pemohon">
                    <i class="fa fa-print"></i> Cetak Dokumen
                </a>
            </div>
        </div>   
    </div> 
    <br>
        <!-- <div align="right">
            <a href="" onclick="window.print()">
                <button type="button" class="btn btn-sm btn-info">
                    <span style="cursor:pointer;" title="Cetak Semua Dokumen Pemohon">
                        <i class="fa fa-print" style="color: #FFFFFF;"></i> Cetak
                    </span>
                </button>
            </a>
        </div> -->
    <?php
        //$conn->debug=true;
        $sql = "SELECT A.id_pemohon,A.nama_penuh, A.ICNo,A.d_cipta,A.d_kemaskini,A.pengakuan, B.diskripsi2 FROM $schema2.calon A, $schema2.ref_negeri B WHERE A.negeri=B.kod";

        // $strSQL=$sql. " LIMIT 10";
        // $rs = $conn->query($sql);
        $sSQL1 = "SELECT COUNT(*) as total FROM $schema2.calon A, $schema2.ref_negeri B WHERE A.negeri=B.kod";
        
        include '../include/list_head.php';
        include '../include/page_list.php';
    ?>
    <br>
    <div class="box-body" style="background-color:#F2F2F2">
        <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
            <thead  style="background-color:rgb(38, 167, 228)">
                <th width="5%"><font color="#000000"><div align="center">Bil</div></font></th>
                <th width="35%"><font color="#000000"><div align="center">Nama Pemohon/Daftar/Kemaskini</div></font></th>
                <th width="10%"><font color="#000000"><div align="center">No. Kad Pengenalan</div></font></th>
                <th width="10%"><font color="#000000"><div align="center">Negeri</div></font></th>
                <th width="10%"><font color="#000000"><div align="center">Skim Jawatan</div></font></th>
                <th width="10%"><font color="#000000"><div align="center">Status</div></font></th>
                <!-- <th width="10%"><font color="#000000"><div align="center">Dokumen <br><small style="color: red;">Nota: Tanda untuk muat turun dokumen pemohon</small></div></font></th> -->
                <th width="10%" class="d-print-none"><font color="#000000"><div align="center">Tindakan</div></font></th>
            </thead>
            <tbody>
        
            <?php 
                // $conn->debug=true;
                // $result = get_pemohon($conn, $uid, "103", $tahun, "1");
                // $pg = 1;
                // $pgSize = 10;
                
                // $rs = get_pemohon($conn, $pg, $pgSize);

                // print $rs;

                // $p = (explode(":",$rs));

                $cnt = 0;
			    $bil = 0; 
                
                
                while(!$rs->EOF){ $bil2=0; 
                    $bil = $cnt + ($PageNo-1)*$PageSize; ?>	
                    <?php 
                        $sql = "SELECT C.DISKRIPSI, C.KOD, A.id_pemohon FROM $schema2.calon_jawatan_dipohon A, $schema1.ref_skim C  WHERE A.kod_jawatan=C.KOD AND A.id_pemohon=".tosql($rs->fields['id_pemohon']);
                        $rsJawatan = $conn->query($sql);
                    ?>
                    <tr>
                        <td align="center"><?=++$bil;?></td>
                        <td align="left">
                            <?=$rs->fields['nama_penuh']?> <br><br>
                            Daftar &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <?=DisplayDate($rs->fields['d_cipta']);  print '&nbsp;&nbsp;('.DisplayMasa($rs->fields['d_cipta']).')';?><br>
                            Kemas Kini : <?=DisplayDate($rs->fields['d_kemaskini']);  print '&nbsp;&nbsp;('.DisplayMasa($rs->fields['d_kemaskini']).')';?>
                        </td>
                        <td align="center"><?=$rs->fields['ICNo']?></td>
                        <td align="center"><?=$rs->fields['diskripsi2']?></td>
                        <td>
                            <?php  while(!$rsJawatan->EOF){ 
                                print ++$bil2.'. '.$rsJawatan->fields['DISKRIPSI'].'<br>';
                            $rsJawatan->movenext(); } ?>
                        </td>
                        <td align="center">
                            <?php if($rs->fields['ICNo'] == '860613915079'){ ?>
                                <button class="btn-warning badge">Draf</button> <br>
                                <!-- Semakan Dokumen : <button class="btn-danger badge"><i class="fa fa-times-circle" aria-hidden="true"></i></button> -->
                            <?php } else if($rs->fields['pengakuan'] == 'Y'){ ?>
                                <button class="btn-success badge">Hantar</button>
                                <!-- Semakan Dokumen : <button class="btn-success badge"><i class="fa fa-check-circle" aria-hidden="true"></i></button> -->
                            <?php } else { ?>
                                <button class="btn-warning badge">Draf</button> <br>
                                <!-- Semakan Dokumen : <button class="btn-success badge"><i class="fa fa-times-circle" aria-hidden="true"></i></button> -->
                            <?php } ?>
                        </td>
                        <!-- <td align="center">
                            <input type="checkbox">
                        </td> -->
                        <td align="center" class="d-print-none">
                            <a href="index.php?data=<?php print base64_encode('pemohon/maklumat_pemohon;Senarai Pemohon;Nama: '.$rs->fields['nama_penuh'].' (No.K/P: '.$rs->fields['ICNo'].');;;;'); ?>&id_pemohon=<?=$rs->fields['id_pemohon']?>">
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

          