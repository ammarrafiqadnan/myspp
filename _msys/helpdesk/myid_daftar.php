<link href="../vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
<link href="../vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
<link href="../vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
<link href="../vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">


		<div class="box" style="background-color:#F2F2F2">

            <div class="box-body">
        	<div class="x_panel">
			<header class="panel-heading"  style="background-color:rgb(38, 167, 228)">
                <div class="panel-actions">
                <!--<a href="#" class="fa fa-caret-down"></a>
                <a href="#" class="fa fa-times"></a>-->
                </div>
                <h6 class="panel-title"><font color="#000000"><b>Senarai Maklumat Daftar Pemohon mySPP</b></font></h6> 
            </header>
			</div>
            </div>            
            <br /> 
            <div class="box-body" style="height: 40px;background-color:#F2F2F2;">
                <div class="row">
                <label for="nama" class="col-sm-1 control-label">Status:</label>
                    <div class="col-sm-3">
                        <select name="status" id="status" class="form-control" >
                            <option value="">Sila pilih status</option>
                            <option value="A" <?php if($status=='A'){ print 'selected'; }?>>Sah Berdaftar</option>
                            <option value="Z" <?php if($status=='Z'){ print 'selected'; }?>>Tiada Pengesahan</option>
                        </select>
                    </div>
                    <div class="col-md-1">
                        <label for="">Carian: </label>
                    </div>
                    <div class="col-md-5" style="background-color:#F2F2F2">
                        <input type="text" name="carian"  value="<?=$carian;?>" class="form-control" placeholder="Tajuk/Keterangan">
                    </div>
                    <div class="col-md-2" style="background-color:#F2F2F2">
                        <button type="button" class="btn btn-info" onclick="do_pages('<?=$url;?>')">
                            <i class=" fa fa-search"></i> <font style="font-family:Verdana, Geneva, sans-serif">Cari</font>
                        </button>
                    </div>
                </div>   
            </div>
            <br>
            <?php
		//$conn->debug=true;
                $sql = "SELECT * FROM $schema2.`myid` WHERE ICNo IS NOT NULL";
		if(!empty($status)){
			$sql.= " AND `ic_ind`=".tosql($status); 
		}
		if(!empty($carian)){ 
			$sql.= " AND (`ICNo` LIKE '%$carian%' OR  `Nama` LIKE '%$carian%') "; 
		}
		$sql .= " ORDER BY tkh_daftar DESC";
                //$rs = $conn->query($sql);


                            ?>
	    <div class="box-body" style="background-color:#F2F2F2">
                <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                    <thead  style="background-color:rgb(38, 167, 228)">
                        <th width="5%"><font color="#000000"><div align="center">No.</div></font></th>
                        <th width="15%"><font color="#000000"><div align="center">No Kad Pengenalan</div></font></th>
                        <th width="30%"><font color="#000000"><div align="center">Nama Pemohon</div></font></th>
                        <th width="15%"><font color="#000000"><div align="center">Tarikh Daftar</div></font></th>
                        <th width="15%"><font color="#000000"><div align="center">Tarikh Pengesahan</div></font></th>
                        <th width="10%"><font color="#000000"><div align="center">Status</div></font></th>  
                    </thead>
                    <tbody>
                    <?php 
                        //$bil = 0; 
        		$cnt = 1;
        		$bil = $StartRec;
                        while(!$rs->EOF){ 
			    $bil = $cnt + ($PageNo-1)*$PageSize;	
		    ?>
                        <tr>
                            <td align="center"><?=$bil;?></td>
                            <td align="center"><?=$rs->fields['ICNo'];?></td>
                            <td align="center"><?=$rs->fields['nama'];?></td>
                            <td align="center"><?=DisplayDate($rs->fields['d_create']);?> <?=DisplayTime($rs->fields['d_create']);?></td>
                            <td align="center"><?=DisplayDate($rs->fields['tkh_daftar']);?> <?=DisplayTime($rs->fields['tkh_daftar']);?></td>

                            <td align="center">
				<?php
				if($rs->fields['ic_ind'] == 'A'){
                                        print '<button class="btn-success badge">(A) Berdaftar</button>';
                                } else if($rs->fields['ic_ind'] == 'Z') {
                                        print '<button class="btn-warning badge">(Z) Belum Buat Pengesahan</button>';
				}
				?>
			    </td>
                        </tr>
                        <?php $cnt = $cnt + 1;
			$bil = $bil + 1;
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

          