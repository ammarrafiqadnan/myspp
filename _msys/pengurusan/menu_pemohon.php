<link href="../vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
<link href="../vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
<link href="../vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
<link href="../vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">
<script>
    function do_status(status, id){
        // alert(status);
		var fd = new FormData();
		fd.append('status',status);
		fd.append('id_menu',id);


		var other_data = $('form').serializeArray();
		$.each(other_data,function(key,input){
			fd.append(input.name,input.value);
		});
        
        if(status == '1'){ //tak aktif
            var msg = 'Adakah anda pasti untuk tutup menu ini?';
        } else {
            var msg = 'Adakah anda pasti untuk membuka kembali menu ini?';
        }
        swal({
            title: msg,
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
                url:'pengurusan/sql_pengurusan.php?frm=PENGURUSAN&jenis=MENU_PEMOHON&pro=SAVE&status_menu='+status,
                type:'POST',
                //dataType: 'json',
                beforeSend: function () {
                    // $('.btn-primary').attr("disabled","disabled");
                    // $('.modal-body').css('opacity', '.5');
                },
                // data: $("form").serialize(),
                data:  fd,
                contentType: false,
                cache: false,
                processData:false,
                success: function(data){
                    console.log(data);
                    if(data=='OK'){
                        swal({
                            title: 'Berjaya',
                            text: 'Maklumat telah berjaya disimpan',
                            type: 'success',
                            confirmButtonClass: "btn-success",
                            confirmButtonText: "Ok",
                            showConfirmButton: true,
                        }).then(function () {
                            // window.location.href = url;
                            reload = window.location; 
                            window.location = reload;
                        });
                    } else if(data=='ERR'){
                        swal({
                            title: 'Amaran',
                            text: 'Terdapat ralat sistem.\nMaklumat anda tidak berjaya diproses.',
                            type: 'error',
                            confirmButtonClass: "btn-warning",
                            confirmButtonText: "Ok",
                            showConfirmButton: true,
                        });
                    }
                },
            }); 
        }, function(dismiss){
            if(dismiss == 'cancel'){
                reload = window.location; 
                window.location = reload;
            }
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
                <h6 class="panel-title"><font color="#000000"><b>Senarai Maklumat Menu Pemohon</b></font></h6> 
            </header>
			</div>
            </div>     
            <br>
            <!-- <div class="col-md-12" align="right">
                <a href="pengurusan/FAQ_form.php?id=" class="btn btn-md btn-primary" data-toggle="modal" data-target="#myModal" title="Tambah Maklumat FAQ">
                    <i class="fa fa-plus"></i> Tambah FAQ
                </a>
            </div> -->
			<br>
            <?php
                //$conn->debug=true;
                $sql = "SELECT * FROM $schema2.`menu_pemohon` WHERE is_deleted=0"; 
                $rs = $conn->query($sql);

                // $sSQL1 = "SELECT COUNT(*) as total FROM $schema2.`menu_pemohon` WHERE is_deleted=0";

                // include '../include/list_head.php';
                // include '../include/page_list.php';
            ?>
			<div class="box-body" style="background-color:#F2F2F2">
                <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                    <thead  style="background-color:rgb(38, 167, 228)">
                        <th width="5%"><font color="#000000"><div align="center">No.</div></font></th>
                        <th width="15%"><font color="#000000"><div align="center">Menu</div></font></th>
                        <th width="10%"><font color="#000000"><div align="center">Kategori</div></font></th>
			<th width="15%"><font color="#000000"><div align="center">Detail</div></font></th>
                        <th width="10%"><font color="#000000"><div align="center">Status<div></font></th>
                    </thead>
                    <tbody>
                        <?php 
                            //$cnt = 0;
                            $bil = 0; 
                            
                            while(!$rs->EOF){ $bil2=0; 
                                //$bil = $cnt + ($PageNo-1)*$PageSize; ?>
                            <tr>
                                <td align="center"><?=++$bil;?></td>
                                <td>
                                    <?php 
                                        if($rs->fields['jenis'] == '1'){
                                            print $rs->fields['keterangan'];
                                        } else if($rs->fields['jenis'] == '2'){
                                            print '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$rs->fields['keterangan'];
                                        }
                                    ?>
                                </td>
                                <td align="center">
                                    <?php 
                                        if($rs->fields['jenis'] == '1'){
                                            print 'MENU';
                                        } else if($rs->fields['jenis'] == '2'){
                                            print 'SUBMENU';
                                        }
                                    ?>
                                </td>
                                <td align="center">
                                    <select name="status" id="status" class="form-control" onchange="do_status(this.value, '<?=$rs->fields['kod']?>')" <?php if($rs->fields['status'] == 0){ print 'style="background-color: green; color: #fff;"'; } else if($rs->fields['status'] == 1){ print 'style="background-color: red; color: #fff;"';} ?>>
                                        <option value="">Sila pilih status</option>
                                        <option value="0" <?php if($rs->fields['status'] == 0){ print 'selected';} ?>>Aktif</option>
                                        <option value="1" <?php if($rs->fields['status'] == 1){ print 'selected';} ?>>Tidak Aktif</option>
                                    </select>                           
                                </td>
				<td align="center">
                                    <?php 
					if($rs->fields['id_pengubahsuai']){

					$sqlP = "SELECT nama_penuh FROM $schema2.spa8i_admin WHERE id=".tosql($rs->fields['id_pengubahsuai']);
					$sqlKemaskini = $conn->query($sqlP);

					if(!empty($rs->fields['id_pengubahsuai'])){ print "Tarikh Kemaskini : ".displayDate($rs->fields['tarikh_ubahsuai']).'('.DisplayTime($rs->fields['tarikh_ubahsuai']);?> <?=$sqlKemaskini->fields['nama_penuh'].")"; }
					
					}?>
                                </td>

                            </tr>
                        <?php 
                            // $cnt = $cnt + 1;
                             $rs->movenext(); } ?>
                    </tbody>
                </table>
            </div>
		</div>
     </div>
  </div>    

          