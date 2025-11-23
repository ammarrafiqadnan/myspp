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
                <h6 class="panel-title"><font color="#000000"><b>Senarai Maklumat Audit Trail</b></font></h6> 
            </header>
			</div>
            </div>            
            <br /> 
            <div class="box-body" style="height: 40px;background-color:#F2F2F2;">
                <div class="row">
                <label for="nama" class="col-sm-1 control-label">Status:</label>
                    <div class="col-sm-3">
                        <select name="status" id="status" class="form-control">
                            <option value="">Sila pilih status</option>
                            <option value="">Aktif</option>
                            <option value="">Tidak Aktif</option>
                        </select>
                    </div>
                    <div class="col-md-1">
                        <label for="">Carian: </label>
                    </div>
                    <div class="col-md-5" style="background-color:#F2F2F2">
                        <input type="text" name="carian" value="" class="form-control" placeholder="Tajuk/Keterangan">
                    </div>
                    <div class="col-md-2" style="background-color:#F2F2F2">
                        <button type="button" class="btn btn-info" onclick="do_page()">
                            <i class=" fa fa-search"></i> <font style="font-family:Verdana, Geneva, sans-serif">Cari</font>
                        </button>
                    </div>
                </div>   
            </div>
            <br>
            <?php
                $sql = "SELECT * FROM $schema2.`auditrail`";
                $rs = $conn->query($sql);

                $sSQL1 = "SELECT COUNT(*) as total FROM $schema2.`auditrail`";

                include '../include/list_head.php';
                include '../include/page_list.php';
            ?>
			<div class="box-body" style="background-color:#F2F2F2">
                <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                    <thead  style="background-color:rgb(38, 167, 228)">
                        <th width="5%"><font color="#000000"><div align="center">No.</div></font></th>
                        <th width="15%"><font color="#000000"><div align="center">Tajuk Auditrail</div></font></th>
                        <th width="45%"><font color="#000000"><div align="center">Keterangan Auditrail</div></font></th>
                        <th width="10%"><font color="#000000"><div align="center">Pengguna</div></font></th>  
                    </thead>
                    <tbody>
                    <?php 
                        $bil = 0; 
                        while(!$rs->EOF){ ?>
                        <tr>
                            <td align="center"><?=++$bil;?></td>
                            <td align="center"><?=$rs->fields['actions'];?></td>
                            <td><?=$rs->fields['remarks'];?></td>
                            <td align="center"><?=$rs->fields['log_user'];?></td>
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

          