<link href="../vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
<link href="../vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
<link href="../vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
<link href="../vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">

<?php
$JFORM='LIST';
$carian=strtoupper(isset($_REQUEST["carian"])?$_REQUEST["carian"]:"");
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
                <h6 class="panel-title"><font color="#000000"><b>Senarai Maklumat Muatnaik Dokumen</b></font></h6> 
            </header> -->
			</div>
            </div>  
            <!-- <br>
            <div class="col-md-12" align="right">
                <a href="pengurusan/kawalan_muatnaik_dokumen_form.php?id=" class="btn btn-md btn-primary" data-toggle="modal" data-target="#myModal" title="Tambah Maklumat Dokumen">
                    <i class="fa fa-plus"></i> Tambah Dokumen
                </a>
            </div> -->
			<br>
            <?php
                //$conn->debug=true;
                $sql = "SELECT * FROM $schema2.`kawalan_muatnaik_dokumen` WHERE is_deleted=0"; 
                // $rscgpa = $conn->query($sql3);

                $sSQL1 = "SELECT COUNT(*) as total FROM $schema2.`kawalan_muatnaik_dokumen` WHERE is_deleted=0";

                include '../include/list_head.php';
                include '../include/page_list.php';
            ?>
			<div class="box-body" style="background-color:#F2F2F2">
                <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                    <thead  style="background-color:rgb(38, 167, 228)">
                        <th width="5%"><font color="#000000"><div align="center">No.</div></font></th>
                        <th width="30%"><font color="#000000"><div align="center">Tajuk Dokumen</div></font></th>
                        <th width="10%"><font color="#000000"><div align="center">Status 
                            <!-- <br><small style="color: #fff;">Nota: Tanda '/' jika butang muatnaik perlu dipaparkan di bahagian permohonan</small></div></font> -->
                        </th>
			<th width="15%"><font color="#000000"><div align="center">Detail</div></font></th>
                        <th width="15%"><font color="#000000"><div align="center">Tindakan</div></font></th>
                    </thead>
                    <tbody>
                    <?php 
                    $cnt = 0;
                    $bil = 0; 
                    
                    while(!$rs->EOF){ $bil2=0; 
                        $bil = $cnt + ($PageNo-1)*$PageSize; ?>
                    <tr>
                        <td align="center"><?=++$bil;?></td>
                        <td align="center"><?=$rs->fields['tajuk_dokumen'];?></td>
                        <td align="center">
                            <?php 
                                if($rs->fields['status'] == 0){
                                    print '<button class="btn-success badge">Aktif</button>';
                                } else {
                                    print '<button class="btn-danger badge">Tidak Aktif</button>';
                                }
                            ?>
                        </td>
			<td align="center">
                                    <?php 
					if($rs->fields['id_pengubahsuai']){

					$sqlP = "SELECT nama_penuh FROM $schema2.spa8i_admin WHERE id=".tosql($rs->fields['id_pengubahsuai']);
					$sqlKemaskini = $conn->query($sqlP);

					if(!empty($rs->fields['id_pengubahsuai'])){ print "Tarikh Kemaskini : ".displayDate($rs->fields['tarikh_ubahsuai']).'('.DisplayTime($rs->fields['tarikh_ubahsuai']);?> <?=$sqlKemaskini->fields['nama_penuh'].")"; }
					
					}?>
                                </td>

                        <td align="center">
                            <a href="pengurusan/kawalan_muatnaik_dokumen_form.php?dokumen_kod=<?=$rs->fields['kod'];?>" class="btn btn-sm btn-success" data-toggle="modal" data-target="#myModal" title="Kemaskini Maklumat Kawalan Muat Naik Dokumen">
                                <i class="fa fa-edit"></i>
                            </a>
                            <!-- <button type="button" class="btn btn-sm btn-danger" onclick="do_hapus('pengurusan/sql_pengurusan.php?frm=PENGURUSAN&jenis=DOKUMEN&pro=HAPUS&kod=<?=$rs->fields['kod'];?>')">
                                <span style="cursor:pointer;color:red" title="Hapus maklumat dokumen"><i class="fa fa-trash-o" style="color: #FFFFFF;"></i></span>
                            </button> -->
                        </td>
                    </tr>
                    <?php 
                    $cnt = $cnt + 1;
                    $rs->movenext(); } ?>
<!-- 

                        <tr>
                            <td align="center">1.</td>
                            <td class="text-uppercase">Keputusan Peperiksaan PT3/PMR/SRP/LCE</td>
                            <td align="center">
                                <input type="checkbox" checked>
                            </td>
                        </tr>
                        <tr>
                            <td align="center">2.</td>
                            <td class="text-uppercase">Keputusan SPM/MCE/SPVM/SPM(V)</td>
                            <td align="center">
                                <input type="checkbox">
                            </td>
                        </tr>
                        <tr>
                            <td align="center">3.</td>
                            <td class="text-uppercase">Keputusan STPM/STP/HSC</td>
                            <td align="center">
                                <input type="checkbox" checked>
                            </td>
                        </tr>
                        <tr>
                            <td align="center">4.</td>
                            <td class="text-uppercase">Keputusan STAM</td>
                            <td align="center">
                                <input type="checkbox" checked>
                            </td>
                        </tr>
                        <tr>
                            <td align="center">5.</td>
                            <td class="text-uppercase">Keputusan Pengajian Tinggi</td>
                            <td align="center">
                                <input type="checkbox">
                            </td>
                        </tr> -->
                    </tbody>
                </table>
            </div>
		</div>
     </div>
  </div>    

          