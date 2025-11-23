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

    function do_print(val){
        do_cetak(val);
    }
</script>
<?php
//$conn->debug=true;
$JFORM='LIST';
$carian=strtoupper(isset($_REQUEST["carian"])?$_REQUEST["carian"]:"");

$hrefs = 'index.php?data='.base64_encode('pemohon/carian_maklumat_pemohon;Pengurusan;Carian Maklumat Pemohon;;;;');
?>


		<div class="box" style="background-color:#F2F2F2">

            <div class="box-body">
        	<input type="hidden" name="id" value="" />
                <div class="x_panel">
        			<header class="panel-heading"  style="background-color:rgb(38, 167, 228)">
                        <div class="panel-actions">
                        </div>
                        <h6 class="panel-title"><font color="#000000"><b>Carian Maklumat Pemohon</b></font></h6> 
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
                        <input type="text" id="carian" name="carian" value="<?=$carian;?>" class="form-control" placeholder="Nama/No. KP">
                    </div>
                    <div class="col-md-2"  align="right" style="background-color:#F2F2F2">
                        <button type="button" class="btn btn-primary" onclick="sortorder('<?=$hrefs;?>',this.value)" style="width:100%">
                            <i class=" fa fa-search"></i> <font style="font-family:Verdana, Geneva, sans-serif">Cari</font>
                        </button>
                    </div>
                </div> 
            </div> 


        	<br>

            <?php
                // $conn->debug=true;
                $sql = "SELECT * FROM $schema2.`senarai_panggilan_temuduga` WHERE kod IS NOT NULL AND is_deleted=0"; 
                $sql .= " AND (nama_penuh LIKE '%".$carian."%' OR noKP LIKE '%".$carian."%')";

                $rs = $conn->query($sql);

                $sql2 = "SELECT * FROM $schema2.`senarai_keputusan_temuduga` WHERE kod IS NOT NULL AND is_deleted=0"; 
                $sql2 .= " AND (nama_penuh LIKE '%".$carian."%' OR noKP LIKE '%".$carian."%')";

                $rs2 = $conn->query($sql2);

                $sql3 = "SELECT * FROM $schema2.`senarai_rayuan_temuduga` WHERE kod IS NOT NULL AND is_deleted=0"; 
                $sql3 .= " AND (nama_penuh LIKE '%".$carian."%' OR noKP LIKE '%".$carian."%')";

                $rs3 = $conn->query($sql3);
            ?>

			<div class="box-body" style="background-color:#F2F2F2">
                <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                    <thead  style="background-color:rgb(38, 167, 228)">
                        <th width="5%"><font color="#000000"><div align="center">No.</div></font></th>
                        <th width="15%"><font color="#000000"><div align="center">Nama</div></font></th>
                        <th width="10%"><font color="#000000"><div align="center">No. K/P</div></font></th>
                        <th width="40%"><font color="#000000"><div align="center">Keterangan</div></font></th>
                        <th width="10%"><font color="#000000"><div align="center">Tindakan</div></font></th>

                    </thead>
                    <tbody>
                    <?php if(!empty($carian)){ ?>
                        <?php 
                            $bil = 0; 
                            while(!$rs->EOF){
                                $id_pemohon = dlookup($schema2.'.calon','id_pemohon','ICNo='.$rs->fields['noKP']);
                        ?>
                            <tr>
                                <td align="center"><?=++$bil;?></td>
                                <td align="center"><?=$rs->fields['nama_penuh'];?></td>
                                <td align="center"><?=$rs->fields['noKP'];?></td>
                                <td align="center">Pengurusan Panggilan Temuduga</td>
                                <td align="center">
                                    <a href="index.php?data=<?php print base64_encode('muatnaikExcel/senarai_pemohon_panggilan_temuduga;PENGURUSAN;Senarai Panggilan Temu Duga;;;'.$rs->fields['kod_panggilan_temuduga'].';'); ?>&carian=<?=$carian;?>">
                                        <button type="button" class="btn btn-sm btn-info">
                                            <span style="cursor:pointer;color:red" title="Maklumat Terperinci Pemohon">
                                                <i class="fa fa-eye" style="color: #FFFFFF;"></i>
                                            </span>
                                        </button>
                                    </a>
                                </td>
                            </tr>
                        <?php 
                            $rs->movenext(); } 
                        ?>
                        <?php 
                            $bil = 0; 
                            while(!$rs2->EOF){
                                $id_pemohon = dlookup($schema2.'.calon','id_pemohon','ICNo='.$rs2->fields['noKP']);
                        ?>
                            <tr>
                                <td align="center"><?=++$bil;?></td>
                                <td align="center"><?=$rs2->fields['nama_penuh'];?></td>
                                <td align="center"><?=$rs2->fields['noKP'];?></td>
                                <td align="center">Pengurusan Keputusan Temuduga</td>
                                <td align="center">
                                    <a href="index.php?data=<?php print base64_encode('muatnaikExcel/senarai_pemohon_keputusan_temuduga;PENGURUSAN;Senarai Keputusan Temu Duga;;;'.$rs2->fields['kod_keputusan_temuduga'].';'); ?>&carian=<?=$carian;?>">
                                        <button type="button" class="btn btn-sm btn-info">
                                            <span style="cursor:pointer;color:red" title="Maklumat Terperinci Pemohon">
                                                <i class="fa fa-eye" style="color: #FFFFFF;"></i>
                                            </span>
                                        </button>
                                    </a>
                                </td>
                            </tr>
                        <?php 
                            $rs2->movenext(); } 
                        ?>
                        <?php 
                            $bil = 0; 
                            while(!$rs3->EOF){
                                $id_pemohon = dlookup($schema2.'.calon','id_pemohon','ICNo='.$rs3->fields['noKP']);
                        ?>
                            <tr>
                                <td align="center"><?=++$bil;?></td>
                                <td align="center"><?=$rs3->fields['nama_penuh'];?></td>
                                <td align="center"><?=$rs3->fields['noKP'];?></td>
                                <td align="center">Pengurusan Rayuan Temuduga</td>
                                <td align="center">
                                    <a href="index.php?data=<?php print base64_encode('muatnaikExcel/senarai_pemohon_rayuan_temuduga;PENGURUSAN;Senarai Rayuan Temu Duga;;;'.$rs3->fields['kod_rayuan_temuduga'].';'); ?>&carian=<?=$carian;?>">
                                        <button type="button" class="btn btn-sm btn-info">
                                            <span style="cursor:pointer;color:red" title="Maklumat Terperinci Pemohon">
                                                <i class="fa fa-eye" style="color: #FFFFFF;"></i>
                                            </span>
                                        </button>
                                    </a>
                                </td>
                            </tr>
                        <?php 
                            $rs3->movenext(); } 
                        ?>
                    <?php } ?>
                    </tbody>
                </table>

                <div class="card-footer">
                    <?php 
                        // $href_f=$actual_link."&table_search=".$table_search;
                        // include 'include/list_footer.php'; 
                    ?>  
                </div>
            </div>
		</div>
     </div>
  </div> 

          