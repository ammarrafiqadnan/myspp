<link href="vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
<link href="vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
<link href="vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
<link href="vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">
<script language="javascript">
function do_hapus(ID){
	swal({
		title: 'Adakah anda pasti untuk menghapuskan data ini?',
		//text: "You won't be able to revert this!",
		type: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Ya, Teruskan',
		cancelButtonText: 'Tidak, Batal!',
		reverseButtons: true
	}).then(function () {
		$.ajax({
			url:'utiliti/users_form_sql.php?pro=DEL&ID='+ID, //&datas='+datas,
			type:'POST',
			//dataType: 'json',
			/*beforeSend: function () {
				$('#simpan').attr("disabled","disabled");
				$('.dispmodal').css('opacity', '.5');
			},*/
			data: $("form").serialize(),
			//data: datas,
			success: function(data){
				//console.log(data);
				//alert(data);
				if(data=='OK'){
					swal({
					  title: 'Berjaya',
					  text: 'Maklumat telah berjaya dihapuskan',
					  type: 'success',
					  confirmButtonClass: "btn-success",
					  confirmButtonText: "Ok",
					  showConfirmButton: true,
					}).then(function () {
						reload = window.location; 
						window.location = reload;
					});
				} else if(data=='ERR'){
					swal({
					  title: 'Amaran',
					  text: 'Terdapat ralat sistem.\nMaklumat anda tidak berjaya dikemaskini.',
					  type: 'error',
					  confirmButtonClass: "btn-warning",
					  confirmButtonText: "Ok",
					  showConfirmButton: true,
					});
				}
			}
		});
	});		
}
function do_reset(ID){
	swal({
		title: 'Adakah anda pasti untuk reset katalaluan ini?',
		//text: "You won't be able to revert this!",
		type: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Ya, Teruskan',
		cancelButtonText: 'Tidak, Batal!',
		reverseButtons: true
	}).then(function () {
		$.ajax({
			url:'utiliti/users_form_sql.php?pro=RESET&ID='+ID, //&datas='+datas,
			type:'POST',
			//dataType: 'json',
			/*beforeSend: function () {
				$('#simpan').attr("disabled","disabled");
				$('.dispmodal').css('opacity', '.5');
			},*/
			data: $("form").serialize(),
			//data: datas,
			success: function(data){
				//console.log(data);
				//alert(data);
				if(data=='OK'){
					swal({
					  title: 'Berjaya',
					  text: 'Katalaluan pengguna telah diset semula?',
					  type: 'success',
					  confirmButtonClass: "btn-success",
					  confirmButtonText: "Ok",
					  showConfirmButton: true,
					}).then(function () {
						reload = window.location; 
						window.location = reload;
					});
				} else if(data=='ERR'){
					swal({
					  title: 'Amaran',
					  text: 'Terdapat ralat sistem.\nMaklumat anda tidak berjaya dikemaskini.',
					  type: 'error',
					  confirmButtonClass: "btn-warning",
					  confirmButtonText: "Ok",
					  showConfirmButton: true,
					});
				}
			}
		});
	});		
}

</script>
<?php
$JFORM='LIST';
$carian=strtoupper(isset($_REQUEST["carian"])?$_REQUEST["carian"]:"");
$lvl=isset($_REQUEST["lvl"])?$_REQUEST["lvl"]:"";
$bhg=isset($_REQUEST["bhg"])?$_REQUEST["bhg"]:"";
//if(!empty($parlimen) && $parlimen<>"-"){ $_SESSION['parlimen']=$parlimen; }
//else if(!empty($parlimen) && $parlimen="-"){ $parlimen=''; $_SESSION['parlimen']=$parlimen; }
//else { $parlimen = $_SESSION['parlimen']; }
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
                <h6 class="panel-title"><font color="#000000"><b>Senarai Pengguna Sistem</b></font></h6> 
          </header>
				</div>
      </div>            
            <br />
            <div class="box-body">
                <div class="form-group">
                <?php //$conn->debug=true; 
										$rsB = $conn->query("SELECT * FROM _ref_bahagian WHERE is_deleted=0 AND bhg_status=0"); ?>
                    <!-- <label class="col-md-1 control-label" for="inputDefault">Peranan Pengguna</label> -->
                    <div class="col-md-3">
                    	<select name="bhg" id="bhg" class="form-control" onChange="do_page('<?=$actual_link;?>')">
                        	<option value="">Semua Bahagian</option>
                        <?php while(!$rsB->EOF){ ?>
                        	<option value="<?=$rsB->fields['bhg_id'];?>" <?php if($rsB->fields['bhg_id']==$bhg){ print 'selected'; }?>><?=$rsB->fields['bhg_nama'];?></option>
                        <?php $rsB->movenext(); } ?>
                        </select>
                    </div>
                    <!-- <label class="col-md-1 control-label" for="inputDefault"></label> -->
                		<?php //$conn->debug=true; 
										$rsA = $conn->query("SELECT * FROM _ref_level WHERE LvlStatus=0"); ?>
                    <!-- <label class="col-md-1 control-label" for="inputDefault">Peranan Pengguna</label> -->
                    <div class="col-md-3">
                    	<select name="lvl" id="lvl" class="form-control" onChange="do_page('<?=$actual_link;?>')">
                        	<option value="">Semua peranan</option>
                        <?php while(!$rsA->EOF){ ?>
                        	<option value="<?=$rsA->fields['LvlID'];?>" <?php if($rsA->fields['LvlID']==$lvl){ print 'selected'; }?>><?=$rsA->fields['LvlNama'];?></option>
                        <?php $rsA->movenext(); } ?>
                        </select>
                    </div>
                    <!-- <label class="col-md-1 control-label" for="inputDefault"></label>     -->
                    <label class="col-md-1 control-label" for="inputDefault">Carian</label>
                    <div class="col-md-2">
                    	<input type="text" class="form-control" id="carian" name="carian" value="<?=$carian;?>">
                    </div>
        			<div class="col-md-3" align="right">
                        <button type="button" class="btn btn-success" 
                        	onclick="do_page('index.php?data=<?php print base64_encode($pages.";".$module.";".$menu);?>')">
							<i class="fa fa-search"></i> Carian
						</button>
						<a href="utiliti/users_form.php" data-toggle="modal" data-target="#myModal"  
							title="Kemaskini profil pengguna" class="fa" data-backdrop="">
							<button type="button" class="btn btn-primary">
								<i class=" fa fa-plus-square"></i> 
								<font style="font-family:Verdana, Geneva, sans-serif"> Tambah Penggguna</font>
							</button>
				        </a> 
			        </div>
        		</div>                    
			</div>
			<br>
			<?php //$conn->debug=true;
            $sql = "SELECT * FROM _tbl_users WHERE isdeleted=0";
            if(!empty($bhg)){ $sql .= " AND bahagian_id='{$bhg}'"; }
            if(!empty($lvl)){ $sql .= " AND level='{$lvl}'"; }
            if(!empty($carian)){ $sql .= " AND (username LIKE '%{$carian}%' OR nama LIKE '%{$carian}%')"; }
            ?>    
			<?php include_once 'include/list_head.php'; ?>
            <?php include_once 'include/page_list.php'; ?>
            <div class="box-body">
              <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                <thead>
                <tr style="background-color:rgb(38, 167, 228)">
                  <th width="3%"><font color="#000000"><div align="center">#</div></font></th>
                  <th width="10%"><font color="#000000"><div align="center">ID Pengguna</div></font></th>
                  <th width="20%"><font color="#000000"><div align="center">Nama Pengguna</div></font></th>
                  <th width="20%"><font color="#000000"><div align="center">E-mel</div></font></th>
                  <th width="15%"><font color="#000000"><div align="center">Bahagian</div></font></th>
                  <th width="15%"><font color="#000000"><div align="center">Peranan</div></font></th>
                  <th width="5%"><font color="#000000"><div align="center">Status</div></font></th>
                  <th width="10%"><font color="#000000"><div align="center">Tindakan</div></font></th>
                </tr>
                </thead>
                <tbody>
                <?php
			if(!$rs->EOF) {
				$cnt = 1;
				$bil = $StartRec;
				while(!$rs->EOF){ //$conn->debug=true;
					//$bil++;
					$bil = $cnt + ($PageNo-1)*$PageSize;
					$id=$rs->fields['id'];
					$gambar = ""; //dlookup("","","");
					$Nama = str_replace($carian,'<font color="#FF0000">'.$carian.'</font>',$rs->fields['nama']);
					$bahagian = dlookup("_ref_bahagian","bhg_nama","bhg_id=".tosql($rs->fields['bahagian_id']));
					$peranan = dlookup("_ref_level","LvlNama","LvlID=".tosql($rs->fields['level']));
				?>
				  <tr>
					  <td align="center"><?=$bil;?></td>
					  <td align="center"><?php print $rs->fields['username'];?></td>
					  <td align="left"><?php print $Nama;?></td>
					  <td align="center"><?php print $rs->fields['emel'];?></td>
					  <td align="center"><?php print "<b>".$bahagian."</b>";?></td>
					  <td align="center"><?php print $peranan;?></td>
					  <td align="center" class="actions">
						<?php if(empty($rs->fields['access'])){ ?>
							<span class="label label-primary">AKTIF</span>
						<?php } else { ?>
							<span class="label label-danger">TIDAK AKTIF</span>
						<?php } ?>
					  </td>
					  <td class="actions" align="center">
						<a href="utiliti/users_form.php?id=<?=$id;?>" data-toggle="modal" data-target="#myModal"  
							title="Kemaskini profil pengguna" class="fa" data-backdrop="" style="margin:0px;">
							<button class="btn btn-sm btn-success">
								<i class="fa fa-edit" style="color:white;"></i>
							</button>
						</a>

						<button type="button" class="btn btn-sm btn-danger" onclick="do_hapus('<?=$id;?>')">
							<span style="cursor:pointer;color:red" title="Hapus maklumat pengguna sistem">
								<i class="fa fa-trash-o" style="color: #FFFFFF;"></i>
							</span>
						</button> 

						
						<?php if($rs->fields['passwords']<>md5($rs->fields['ic'])){ ?>  
							<!-- <button class="btn btn-sm btn-info">
							<i class="fa fa-key" onclick="do_reset('<?//=$id;?>')" style="cursor:pointer" 
								title="Reset katalaluan pengguna"></i>
							</button> -->
							<button type="button" class="btn btn-sm btn-info" onclick="do_reset('<?=$id;?>')">
								<span style="cursor:pointer;" title="Reset katalaluan pengguna">
									<i class="fa fa-key" style="color: #FFFFFF;"></i>
								</span>
							</button> 
						<?php } ?>
						
					  </td>
				  </tr>
			<?php 
					$cnt = $cnt + 1;
					$bil = $bil + 1;
					$rs->movenext(); 
				} 
			}
			?>
                </tbody>
              </table>
            </div>
		</div>
		<?php 
        $url = explode("&",$actual_link);
        $href_f=$url[0]."&table_search=".$table_search; ?>
        <?php include 'include/list_footer.php'; ?>  
     </div>
  </div>    
<!-- DataTables -->
          