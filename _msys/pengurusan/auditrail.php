<link href="../vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
<link href="../vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
<link href="../vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
<link href="../vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">
<script>
    function do_page(href){
        // alert('sini');
        var carian = $('#carian').val();

        window.location.href = href+'&carian='+carian;
        
        
        // return sorturl;
    }
</script>

<?php
$JFORM='LIST';
$carian=strtoupper(isset($_REQUEST["carian"])?$_REQUEST["carian"]:"");
$hrefs = 'index.php?data='.base64_encode('pengurusan/auditrail;Pentadbiran;Audit Trail;ALL;;;');

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
                <h6 class="panel-title"><font color="#000000"><b>Senarai Maklumat Audit Trail</b></font></h6> 
            </header>
			</div>
            </div>            
            <br /> 
            <div class="col-md-12" style="background-color:#F2F2F2;">
                <div class="row">
                    <div class="col-md-1">
                        <label for="">Carian: </label>
                    </div>
                    <div class="col-md-5" style="background-color:#F2F2F2">
                        <input type="text" id="carian" name="carian" value="<?=$carian;?>" class="form-control" placeholder="Tajuk/Keterangan">
                    </div>
                    <div class="col-md-2" style="background-color:#F2F2F2">
                        <button type="button" class="btn btn-info" onclick="do_page('<?=$hrefs;?>')">
                            <i class=" fa fa-search"></i> <font style="font-family:Verdana, Geneva, sans-serif">Cari</font>
                        </button>
                    </div>
                </div>   
            </div>
            <br>
            <?php
		//$conn->debug=true;
                $sql = "SELECT * FROM $schema2.`auditrail` WHERE aid IS NOT NULL AND remarks IS NOT NULL AND actions IS NOT NULL";
		if(!empty($carian)){
            		$sql .= " AND ((`remarks` LIKE '%".$carian."%') OR (`actions` LIKE '%".$carian."%'))";
        	}

                //$rs = $conn->query($sql);

                $sSQL1 = "SELECT COUNT(*) as total FROM $schema2.`auditrail` WHERE aid IS NOT NULL AND remarks IS NOT NULL AND actions IS NOT NULL ";

		if(!empty($carian)){
            		$sSQL1 .= " AND ((`remarks` LIKE '%".$carian."%') OR (`actions` LIKE '%".$carian."%'))";
        	}


                include '../include/list_head.php';
                include '../include/page_list.php';
            ?>
			<div class="box-body" style="background-color:#F2F2F2">
                <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                    <thead  style="background-color:rgb(38, 167, 228)">
                        <th width="5%"><font color="#000000"><div align="center">No.</div></font></th>
                        <th width="30%"><font color="#000000"><div align="center">Tajuk Auditrail</div></font></th>
                        <th width="10%"><font color="#000000"><div align="center">Pengguna</div></font></th>
			<th width="10%"><font color="#000000"><div align="center">Tarikh</div></font></th>
                        <th width="55%"><font color="#000000"><div align="center">Detail Auditrail</div></font></th>
                    </thead>
                    <tbody>
                    <?php 
                        $bil = 0; 
                        while(!$rs->EOF){ 
			if(!empty($rs->fields['id_user'])){
			$sqls = "SELECT * FROM $schema2.`spa8i_admin` WHERE id=".tosql($rs->fields['id_user']);
			$rs2 = $conn->query($sqls);
			}
			?>
                        <tr>
                            <td align="center"><?=++$bil;?></td>
                            <td><?php print $rs->fields['remarks'];?></td>
			    
                            	<td align="center"><?php if(!empty($rs->fields['id_user'])){ print $rs2->fields['nama_penuh']; } ?></td>
				<td align="center"><?=DisplayDate($rs->fields['trans_date']);?> <?=DisplayTime($rs->fields['trans_date']);?></td>
                            <td align="center"><?=$rs->fields['actions'];?></td>

			    
                        </tr>
                        <?php $rs->movenext(); } ?>
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

          