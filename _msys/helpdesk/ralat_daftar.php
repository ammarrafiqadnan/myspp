<link href="../vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
<link href="../vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
<link href="../vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
<link href="../vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">

<?php
$JFORM='LIST';
$carian=strtoupper(isset($_REQUEST["carian"])?$_REQUEST["carian"]:"");
$url="index.php?data=".base64_encode('helpdesk/ralat_daftar;Helpdesk;Senarai Ralat Daftar;ALL;;;');
?>


		<div class="box" style="background-color:#F2F2F2">

            <div class="box-body">
        	<div class="x_panel">
			<header class="panel-heading"  style="background-color:rgb(38, 167, 228)">
                <div class="panel-actions">
                <!--<a href="#" class="fa fa-caret-down"></a>
                <a href="#" class="fa fa-times"></a>-->
                </div>
                <h6 class="panel-title"><font color="#000000"><b>Senarai Maklumat Daftar JPN - ERROR</b></font></h6> 
            </header>
			</div>
            </div>            
            <br /> 
            <div class="box-body" style="height: 40px;background-color:#F2F2F2;">
                <div class="row">
                <!--<label for="nama" class="col-sm-1 control-label">Status:</label>
                    <div class="col-sm-3">
                        <select name="status" id="status" class="form-control">
                            <option value="">Sila pilih status</option>
                            <option value="">Aktif</option>
                            <option value="">Tidak Aktif</option>
                        </select>
                    </div>-->
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
                $sql = "SELECT * FROM $schema2.`myid_jpn_error` WHERE ICno IS NOT NULL";
		if(!empty($carian)){ $sql.= " AND (`ICno` LIKE '%$carian%' OR  `Nama` LIKE '%$carian%') "; }
		$sql .= " ORDER BY trxDate DESC";
                $rs = $conn->query($sql);

                $sSQL1 = "SELECT COUNT(*) as total FROM $schema2.`myid_jpn_error`";

                include '../include/list_head.php';
                include '../include/page_list.php';
            ?>
	    <div class="box-body" style="background-color:#F2F2F2">
                <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                    <thead  style="background-color:rgb(38, 167, 228)">
                        <th width="5%"><font color="#000000"><div align="center">No.</div></font></th>
                        <th width="15%"><font color="#000000"><div align="center">No Kad Pengenalan</div></font></th>
                        <th width="20%"><font color="#000000"><div align="center">Mesej Ralat</div></font></th>
                        <th width="50%"><font color="#000000"><div align="center">Hasil Semakan</div></font></th>  
                        <th width="10%"><font color="#000000"><div align="center">Tarikh</div></font></th>  
                    </thead>
                    <tbody>
                    <?php 
                        //$bil = 0; 
        		$cnt = 1;
        		$bil = $StartRec;
                        while(!$rs->EOF){ 
			    $bil = $cnt + ($PageNo-1)*$PageSize;
			    $ic = explode(":",$rs->fields['ICno']);
			    $nama = explode(":",$rs->fields['Nama']);	
		    ?>
                        <tr>
                            <td align="center"><?=$bil;?></td>
                            <td align="center"><?=trim($ic[0]);?></td>
                            <td align="center"><?=$rs->fields['Message'];?></td>
                            <td align="left">
				<?php 
				//print $rs->fields['Message']."<br>";
				if($rs->fields['Message']=='NAMA TAK SAMA'){
					if(!empty($rs->fields['nama_jpn'])){
						print $rs->fields['nama_jpn'];
					} else {
						print $nama[1];
					}
				} else if($rs->fields['Message']=='NOKP ATAU NAMA TIDAK TEPAT'){
					if(!empty($rs->fields['nama_jpn'])){
						print "Nama INPUT: [".$rs->fields['Nama']."]";
						print "<br>Nama JPN&nbsp;&nbsp;&nbsp;: [".$rs->fields['nama_jpn']."]";
					} else {
						print "Nama INPUT: [".$rs->fields['Nama']."]";
						print "<br>Nama JPN&nbsp;&nbsp;&nbsp;: [".$nama[1]."]";
					}

				}
				//if(!empty($ic[1])){ print $ic[1]; }
				?>
			    </td>
                            <td align="center"><?=DisplayDate($rs->fields['trxDate']);?> <?=DisplayTime($rs->fields['trxDate']);?></td>
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

          