<link href="../vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
<link href="../vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
<link href="../vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
<link href="../vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">
<script>
    function sortorder(href, val, fieldname){
        // alert('sini');
        var carian = $('#carian').val();
        var tahun_list = $('#tahun_list').val();
        var bulan_list = $('#bulan_list').val();

        window.location.href = href+"&tahun_list="+tahun_list+"&bulan_list="+bulan_list+'&carian='+carian;
        
        
        // return sorturl;
    }
</script>

<?php
$JFORM='LIST';
$tahun_list=isset($_REQUEST["tahun_list"])?$_REQUEST["tahun_list"]:"";
$bulan_list=isset($_REQUEST["bulan_list"])?$_REQUEST["bulan_list"]:"";
$carian=strtoupper(isset($_REQUEST["carian"])?$_REQUEST["carian"]:"");

$hrefs = 'index.php?data='.base64_encode('muatnaikExcel/senarai_panggilan_temuduga;Pengurusan;Senarai Panggilan Temu Duga;;;;');

?>

        <header class="panel-heading"  style="background-color:rgb(38, 167, 228)">
            <h6 class="panel-title"><font color="#000000" size="3"><b><?php print strtoupper($menu);?></b></font></h6>
        </header>
		<div class="box" style="background-color:#F2F2F2">

            <div class="box-body">
        	<input type="hidden" name="id" value="" />
            <div class="x_panel">
			<!-- <header class="panel-heading"  style="background-color:rgb(38, 167, 228)">
                <div class="panel-actions">
                </div>
                <h6 class="panel-title"><font color="#000000"><b>Maklumat Senarai Panggilan Temuduga</b></font></h6> 
            </header> -->
            
            <!-- <header class="panel-heading"  style="background-color:rgb(38, 167, 228)">
                <h6 class="panel-title"><font color="#000000" size="3"><b><?php print strtoupper($menu);?></b></font></h6>
            </header> -->
			</div>
            </div>            
            <br />
	     <div class="col-md-12">
                <div class="row">

            <div class="col-md-12" style="background-color:#F2F2F2;">
                <div class="row">
                    <div class="col-md-1">
                        <label for="">Tahun: </label>
                    </div>
                    <div class="col-md-2">
                        <select name="tahun_list" id="tahun_list" class="form-control" onchange="sortorder('<?=$hrefs;?>',this.value)">
                            <option value="">Sila pilih tahun</option>
                            <?php for($t=date("Y");$t>=2021;$t--){ ?>
                                <option value="<?=$t;?>" <?php if($t==$tahun_list){ print 'selected'; } ?>><?=$t;?></option>
                            <?php } ?>
                        </select>
                    </div>  
                    <div class="col-md-1">
                        <label for="">Bulan: </label>
                    </div>
                    <div class="col-md-2">
                        <select name="bulan_list" id="bulan_list" class="form-control" onchange="sortorder('<?=$hrefs;?>',this.value)">
                            <option value="">Sila pilih bulan</option>
                            <option value="1"<?php if($bulan_list=='1'){ print 'selected'; }?>>Januari</option>
                            <option value="2"<?php if($bulan_list=='2'){ print 'selected'; }?>>Februari</option>
                            <option value="3"<?php if($bulan_list=='3'){ print 'selected'; }?>>Mac</option>
                            <option value="4"<?php if($bulan_list=='4'){ print 'selected'; }?>>April</option>
                            <option value="5"<?php if($bulan_list=='5'){ print 'selected'; }?>>Mei</option>
                            <option value="6"<?php if($bulan_list=='6'){ print 'selected'; }?>>Jun</option>
                            <option value="7"<?php if($bulan_list=='7'){ print 'selected'; }?>>Julai</option>
                            <option value="8"<?php if($bulan_list=='8'){ print 'selected'; }?>>Ogos</option>
                            <option value="9"<?php if($bulan_list=='9'){ print 'selected'; }?>>September</option>
                            <option value="10"<?php if($bulan_list=='10'){ print 'selected'; }?>>Oktober</option>
                            <option value="11"<?php if($bulan_list=='11'){ print 'selected'; }?>>November</option>
                            <option value="12"<?php if($bulan_list=='12'){ print 'selected'; }?>>Disember</option>
                        </select>
                    </div>  
                    <div class="col-md-1">
                        <label for="">Carian: </label>
                    </div>
                    <div class="col-md-3" style="background-color:#F2F2F2">
                        <input type="text" id="carian"name="carian" value="<?=$carian;?>" class="form-control" placeholder="Tajuk Hebahan">
                    </div>
                    <div class="col-md-2" style="background-color:#F2F2F2">
                        <button type="button" class="btn btn-primary" onclick="sortorder('<?=$hrefs;?>',this.value)">
                            <i class=" fa fa-search"></i> <font style="font-family:Verdana, Geneva, sans-serif">Cari</font>
                        </button>
                    </div>
                </div>   
            </div> 
</div>   
            </div> 

            <br>
		<?php if($_SESSION['SESSADM_UROLE'] != 3){ ?>
            <div class="col-md-12" style="background-color:#F2F2F2;">
                <div class="row">
                    <div class="col-md-12" align="right">
                        <a href="muatnaikExcel/form_panggilan_temuduga.php?kod=" class="btn btn-md btn-primary" data-toggle="modal" data-target="#myModal" title="Tambah Maklumat Panggilan Temuduga">
                            <i class="fa fa-plus"></i> Tambah Panggilan Temuduga
                        </a>
                    </div>
                </div>   
            </div>
		<?php } ?>
			<br>
            <?php
                //  $conn->debug=true;
                $sql = "SELECT A.* FROM $schema2.`panggilan_temuduga` A WHERE A.is_deleted=0"; 

                if(!empty($tahun_list)){
                    $sql .= " AND (year(A.tarikh_mula) LIKE '%".$tahun_list."%' OR year(A.tarikh_tamat) LIKE '%".$tahun_list."%')";
                }
            
                if(!empty($bulan_list)){
                    $sql .= " AND (month(A.tarikh_mula)  LIKE '%".$bulan_list."%' OR month(A.tarikh_tamat)  LIKE '%".$bulan_list."%')";
                }
            
                if(!empty($carian)){
                    $sql .= " AND (A.tajuk  LIKE '%".$carian."%')";
                }

                $sSQL1 = "SELECT COUNT(*) as total FROM $schema2.`panggilan_temuduga` WHERE is_deleted=0";
                include '../include/list_head.php';
                include '../include/page_list.php';
            ?>
			<div class="box-body" style="background-color:#F2F2F2">
                <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                    <thead  style="background-color:rgb(38, 167, 228)">
                        <th width="5%"><font color="#000000"><div align="center">No.</div></font></th>
                        <th width="35%"><font color="#000000"><div align="center">Tajuk Hebahan</div></font></th>
                        <th width="15%"><font color="#000000"><div align="center">Tarikh/ Masa Publish</div></font></th>
                        <th width="10%"><font color="#000000"><div align="center">Jumlah Pemohon</div></font></th>
                        <th width="10%"><font color="#000000"><div align="center">Tindakan</div></font></th>
			<th width="15%"><font color="#000000"><div align="center">Detail</div></font></th>

                    </thead>
                    <tbody>
                
                        <?php 
                            $cnt = 0;
                            $bil = 0; 
                            while(!$rs->EOF){ $bil2=0; 
                                $bil = $cnt + ($PageNo-1)*$PageSize; 
                                $id = $rs->fields['kod'];
                                $rsJ = $conn->query("SELECT COUNT(*) as total FROM $schema2.`senarai_panggilan_temuduga` WHERE kod_panggilan_temuduga=".tosql($id). "  AND is_deleted=0");
                                $jumlah = $rsJ->fields['total'];
                        ?>
                            <tr>
                                <td align="center"><?=++$bil;?></td>
                                <td align="center"><?=$rs->fields['tajuk'];?></td>
                                <td align="center">
                                    <?=displayDate($rs->fields['tarikh_mula']);?> (<?=date('h:i a', strtotime($rs->fields['masa_mula']));?>) <br>hingga <br> <?=displayDate($rs->fields['tarikh_tamat']);?> (<?=date('h:i a', strtotime($rs->fields['masa_tamat']));?>)
                                </td>
                                <td align="center"><?=$jumlah;?></td>
                                <td align="center">
					<?php if($_SESSION['SESSADM_UROLE'] != 3){ ?>
                                    <a href="muatnaikExcel/form_panggilan_temuduga.php?kod=<?=$rs->fields['kod'];?>" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#myModal" title="Kemaskini Maklumat Panggilan Temuduga">
                                        <i class="fa fa-edit"></i>
                                    </a>
				<?php } ?>
                                    <a href="index.php?data=<?php print base64_encode('muatnaikExcel/senarai_pemohon_panggilan_temuduga;PENGURUSAN;Senarai Panggilan Temu Duga;;;'.$id.';'); ?>" class="btn btn-sm btn-success" title="Senarai Panggilan Temuduga">
                                    <!-- <a href="index.php?data=<?php print base64_encode('senarai_panggilan_temuduga;PENGURUSAN;Senarai Panggilan Temu Duga;;;;'); ?>"> -->
                                        <i class="fa fa-list"></i>
                                    </a>
				<?php if($_SESSION['SESSADM_UROLE'] != 3){ ?>
                                    <button type="button" class="btn btn-sm btn-danger" onclick="do_hapus('muatnaikExcel/sql_muatnaikExcel.php?frm=PANGGILAN_TEMUDUGA&pro=HAPUS&kod=<?=$rs->fields['kod'];?>')">
                                        <span style="cursor:pointer;color:red" title="Hapus maklumat panggilan temuduga"><i class="fa fa-trash-o" style="color: #FFFFFF;"></i></span>
                                    </button>
				<?php } ?>
                                </td>
				<td align="center">
                                    <?php 
					$sqlP = "SELECT nama_penuh FROM $schema2.spa8i_admin WHERE id=".tosql($rs->fields['id_pencipta']);
					$sqlCipta = $conn->query($sqlP);

					$sqlP = "SELECT nama_penuh FROM $schema2.spa8i_admin WHERE id=".tosql($rs->fields['id_pengemaskini']);
					$sqlKemaskini = $conn->query($sqlP);


					print "Tarikh Cipta : ".displayDate($rs->fields['tarikh_cipta']).'('.DisplayTime($rs->fields['tarikh_cipta']);?>) (<?=$sqlCipta->fields['nama_penuh'];?>) <br> <?php if(!empty($rs->fields['tarikh_ubahsuai'])){ print "Tarikh Kemaskini : ".displayDate($rs->fields['tarikh_ubahsuai']).'('.DisplayTime($rs->fields['tarikh_ubahsuai']);?>) (<?=$sqlKemaskini->fields['nama_penuh'].")"; }?>
                                </td>
                            </tr>
                        <?php 
                            $cnt = $cnt + 1;
                            $rs->movenext(); } 
                        ?>
                    </tbody>
                </table>

                <div class="card-footer">
                    <?php 
                        $href_f=$actual_link."&table_search=".$table_search;
                        include 'include/list_footer.php'; 
                    ?>  
                </div>

            </div>
		</div>
     </div>
  </div>  

          