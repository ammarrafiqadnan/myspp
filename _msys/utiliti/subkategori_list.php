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
			url:'utiliti/kategori_form_sql.php?pro=DEL&id='+ID, //&datas='+datas,
			type:'POST',
			//dataType: 'json',
			/*beforeSend: function () {
				$('#simpan').attr("disabled","disabled");
				$('.dispmodal').css('opacity', '.5');
			},*/
			data: $("form").serialize(),
			//data: datas,
			success: function(data){
				console.log(data);
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

</script>
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
                <h6 class="panel-title"><font color="#000000"><b>Maklumat Rujukan Sub Kategori</b></font></h6> 
            </header>
			</div>
            </div>            
            <br />
            <div class="box-body">
                <div class="form-group">
                    <label class="col-md-1 control-label" for="inputDefault">Carian</label>
                    <div class="col-md-7">
                    	<input type="text" class="form-control" id="carian" name="carian" value="<?=$carian;?>">
                    </div>
        			<div class="col-md-4" align="right">
                        <button type="button" class="btn btn-success" 
                        	onclick="do_page('index.php?data=<?php print base64_encode($pages.";".$module.";".$menu);?>')">
                        	<i class="fa fa-search"></i> Carian</button>
                        	
                            <a href="utiliti/subkategori_form.php" 
                            data-toggle="modal" data-target="#myModal"  
                            title="Tambah Maklumat Rujukan Sub Kategori" class="fa" data-backdrop="static">
                            <button type="button" class="btn btn-primary">
                        	<i class=" fa fa-plus-square"></i> <font style="font-family:Verdana, Geneva, sans-serif">Maklumat</font></button>
				        </a> 
			        </div>
        		</div>                    
			</div>
			<br>
			<?php
			// $conn->debug=true;
            $sql = "SELECT * FROM `_ref_kategori_sub` A, `_ref_kategori` B WHERE A.kategori_id=B.kategori_id AND A.is_deleted=0 ";
            if(!empty($carian)){ $sql .= " AND subkat_nama LIKE '%{$carian}%'"; }
            $sql .= " ORDER BY A.kategori_id, A.subkat_nama";
			?>    
			<?php include_once 'include/list_head.php'; ?>
            <?php include_once 'include/page_list.php'; ?>
            <div class="box-body">
              <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                <thead>
                <tr style="background-color:rgb(38, 167, 228)">
                  <th width="5%"><font color="#000000"><div align="center">#</div></font></th>
                  <th width="50%"><font color="#000000"><div align="center">Maklumat Sub Kategori</div></font></th>
                  <th width="20%"><font color="#000000"><div align="center">Maklumat Kategori</div></font></th>
                  <th width="15%"><font color="#000000"><div align="center">Status</div></font></th>
                  <th width="10%"><font color="#000000"><div align="center">Tindakan</div></font></th>
                </tr>
                </thead>
                <tbody>
                <?php
			if(!$rs->EOF) {
				$cnt = 1;
				$bil = $StartRec;
				while(!$rs->EOF){ 
					//$bil++;
					$bil = $cnt + ($PageNo-1)*$PageSize;
					$ids=$rs->fields['subkat_id'];
					$subkat_nama = str_replace($carian,'<font color="#FF0000">'.$carian.'</font>', $rs->fields['subkat_nama']);
				?>
				  <tr>
					  <td align="center"><?=$bil;?></td>
					  <td align="left"><?php print $subkat_nama;?></td>
					  <td align="center"><?php print $rs->fields['kategori_nama'];?></td>
					  <td align="center" class="actions">
						<?php if(empty($rs->fields['subkat_status'])){ ?>
							<span class="label label-primary">AKTIF</span>
						<?php } else { ?>
							<span class="label label-danger">TIDAK AKTIF</span>
						<?php } ?>
					  </td>
					  <td class="actions" align="center">
						  <a href="utiliti/subkategori_form.php?ids=<?=$ids;?>" 
							data-toggle="modal" data-target="#myModal"  
							title="Kemaskini maklumat sub kategori" class="fa" data-backdrop="static" style="margin:0px;">
								<button class="btn btn-sm btn-success">
									<i class="fa fa-edit" style="color:white;"></i>
								</button>
							</a>
							<?php if(empty($get_data)){ ?>
							<button type="button" class="btn btn-sm btn-danger" onclick="do_hapus('<?=$ids;?>')">
								<span style="cursor:pointer;color:red" title="Hapus maklumat rujukan sub kategori">
									<i class="fa fa-trash-o" style="color: #FFFFFF;"></i>
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

          