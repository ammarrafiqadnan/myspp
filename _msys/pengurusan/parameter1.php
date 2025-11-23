<link href="../vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
<link href="../vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
<link href="../vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
<link href="../vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">

<?php
@session_start();
$JFORM='LIST';
$carian=strtoupper(isset($_REQUEST["carian"])?$_REQUEST["carian"]:"");
$reg = $_SESSION['SESSADM_MENU'];
$p = (explode(",",$reg));
$bilp=1;
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
                        <h6 class="panel-title"><font color="#000000"><b>Senarai Maklumat Parameter</b></font></h6> 
                    </header>
                </div>
            </div>            
            <br /> 
			<div class="box-body" style="background-color:#F2F2F2">
                <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                    <thead  style="background-color:rgb(38, 167, 228)">
                        <th width="5%"><font color="#000000"><div align="center">No.</div></font></th>
                        <!-- <th width="15%"><font color="#000000"><div align="center">Kod</div></font></th> -->
                        <th width="30%"><font color="#000000"><div align="center">Keterangan</div></font></th>
                        <th width="5%"><font color="#000000"><div align="center">Tindakan</div></font></th>
                    </thead>
                    <tbody>

                        <?php if(in_array('param1', $p)){ ?>
                        <tr>
                            <td align="center"><?php print $bilp++;?>.</td>
                            <!-- <td align="center">A002</td> -->
                            <td>Negeri</td>
                            <td align="center">
                                <a href="index.php?data=<?php print base64_encode('pengurusan/kod_negeri/senarai_negeri;Pentadbiran;Parameter;ALL;;;'); ?>" class="btn btn-md btn-success" title="Kemaskini Maklumat Kod Negeri">
                                    <i class="fa fa-edit"></i>
                                </a>
                            </td>
                        </tr>
                        <?php } ?>

                        <?php if(in_array('param2', $p)){ ?>
                        <tr>
                            <td align="center"><?php print $bilp++;?>.</td>
                            <!-- <td align="center">A003</td> -->
                            <td>Jenis OKU</td>
                            <td align="center">
                                <a href="index.php?data=<?php print base64_encode('pengurusan/parameter/senarai_oku;Pentadbiran;Parameter;Jenis OKU;;;'); ?>" class="btn btn-md btn-success" title="Kemaskini Maklumat Jenis OKU">
                                    <i class="fa fa-edit"></i>
                                </a>
                            </td>
                        </tr>
                        <?php } ?>

                        <?php if(in_array('param3', $p)){ ?>
                        <tr>
                            <td align="center"><?php print $bilp++;?>.</td>
                            <!-- <td align="center">A003</td> -->
                            <td>Pusat Temu Duga</td>
                            <td align="center">
                                <a href="index.php?data=<?php print base64_encode('pengurusan/parameter/senarai_pusatTemuduga;Pentadbiran;Parameter;Senarai Pusat Temu Duga;;;'); ?>" class="btn btn-md btn-success" title="Kemaskini Maklumat Pusat Temu Duga">
                                    <i class="fa fa-edit"></i>
                                </a>
                            </td>
                        </tr>
                        <?php } ?>

                        <?php if(in_array('param4', $p)){ ?>
                        <tr>
                            <td align="center"><?php print $bilp++;?>.</td>
                            <!-- <td align="center">A002</td> -->
                            <td>Jenis Domain Emel</td>
                            <td align="center">
                                <a href="index.php?data=<?php print base64_encode('pengurusan/parameter/senarai_domainEmail;Pentadbiran;Parameter;Domain Emel;;;'); ?>" class="btn btn-md btn-success" data-toggle="modal" data-taraget="#myModal" title="Kemaskini Maklumat Domain Emel">
                                    <i class="fa fa-edit"></i>
                                </a>
                            </td>
                        </tr>
                        <?php } ?>

                        <?php if(in_array('param5', $p)){ ?>
                        <tr>
                            <td align="center"><?php print $bilp++;?>.</td>
                            <!-- <td align="center">A002</td> -->
                            <td>Matapelajaran Maklumat Akademik</td>
                            <td align="center">
                                <a href="index.php?data=<?php print base64_encode('pengurusan/parameter/senarai_matapelajaran;Pentadbiran;Parameter;Mata Pelajaran Maklumat Akademik;;;'); ?>" class="btn btn-md btn-success" data-toggle="modal" data-taraget="#myModal" title="Kemaskini Mata Pelajaran Maklumat Akademik">
                                    <i class="fa fa-edit"></i>
                                </a>
                            </td>
                        </tr>
                        <?php } ?>
			
			<!--
                        <?php if(in_array('param6', $p)){ ?>
                        <tr>
                            <td align="center"><?php print $bilp++;?>.</td>
                            <td>Kluster</td>
                            <td align="center">
                                <a href="index.php?data=<?php print base64_encode('pengurusan/kod_kluster/senarai_kod_kluster;Pentadbiran;Parameter;ALL;;;'); ?>" class="btn btn-md btn-success" data-toggle="modal" data-taraget="#myModal" title="Kemaskini Maklumat Kluster">
                                    <i class="fa fa-edit"></i>
                                </a>
                            </td>
                        </tr>
                        <?php } ?>
				

                        <?php if(in_array('param7', $p)){ ?>
                        <tr>
                            <td align="center"><?php print $bilp++;?>.</td>
                            <td>Matapelajaran Dan Kluster</td>
                            <td align="center">
                                <a href="index.php?data=<?php print base64_encode('pengurusan/kod_kluster/senarai_kod_mpelajaran;Pentadbiran;Parameter;ALL;;;'); ?>" class="btn btn-md btn-success" data-toggle="modal" data-taraget="#myModal" title="Kemaskini Maklumat Matapelajaran dan Kluster">
                                    <i class="fa fa-edit"></i>
                                </a>
                            </td>
                        </tr>
                        <?php } ?>

                        <?php if(in_array('param8', $p)){ ?>
                        <tr>
                            <td align="center"><?php print $bilp++;?>.</td>
                            <td>Bidang</td>
                            <td align="center">
                                <a href="index.php?data=<?php print base64_encode('pengurusan/kod_bidang/senarai_kod_bidang;Pentadbiran;Parameter;ALL;;;'); ?>" class="btn btn-md btn-success" data-toggle="modal" data-taraget="#myModal" title="Kemaskini Maklumat Bidang">
                                    <i class="fa fa-edit"></i>
                                </a>
                            </td>
                        </tr>
                        <?php } ?>
                    -->

                        <?php if(in_array('param9', $p)){ ?>
                        <tr>
                            <td align="center"><?php print $bilp++;?>.</td>
                            <!-- <td align="center">A003</td> -->
                            <td>Institusi</td>
                            <td align="center">
                                <a href="index.php?data=<?php print base64_encode('pengurusan/parameter/senarai_universiti;Pentadbiran;Parameter;Senarai Universiti;;;'); ?>" class="btn btn-md btn-success" title="Kemaskini Maklumat Universiti / Institusi">
                                    <i class="fa fa-edit"></i>
                                </a>
                            </td>
                        </tr>
                        <?php } ?>

                        <?php if(in_array('param10', $p)){ ?>
                        <tr>
                            <td align="center"><?php print $bilp++;?>.</td>
                            <!-- <td align="center">A003</td> -->
                            <td>Pengkhususan</td>
                            <td align="center">
                                <a href="index.php?data=<?php print base64_encode('pengurusan/parameter/senarai_pengkhususan;Pentadbiran;Parameter;Pengkhususan;;;'); ?>" class="btn btn-md btn-success" title="Kemaskini Maklumat Pengkhususan">
                                    <i class="fa fa-edit"></i>
                                </a>
                            </td>
                        </tr>
                        <?php } ?>

                        <?php if(in_array('param11', $p)){ ?>
                        <tr>
                            <td align="center"><?php print $bilp++;?>.</td>
                            <!-- <td align="center">A003</td> -->
                            <td>Skim</td>
                            <td align="center">
                                <a href="index.php?data=<?php print base64_encode('pengurusan/parameter/senarai_skim;Pentadbiran;Parameter;Skim;;;'); ?>" class="btn btn-md btn-success" title="Kemaskini Maklumat Skim">
                                    <i class="fa fa-edit"></i>
                                </a>
                            </td>
                        </tr>
                        <?php } ?>

                        <?php if(in_array('param12', $p)){ ?>
                        <tr>
                            <td align="center"><?php print $bilp++;?>.</td>
                            <!-- <td align="center">A001</td> -->
                            <td>Peringkat Kelulusan</td>
                            <td align="center">
                                <a href="index.php?data=<?php print base64_encode('pengurusan/parameter/senarai_peringkat_kelulusan;Pentadbiran;Parameter;Peringkat Kelulusan;;;'); ?>" class="btn btn-md btn-success" data-toggle="modal" data-taraget="#myModal" title="Kemaskini Maklumat Peringkat Kelulusan">
                                    <i class="fa fa-edit"></i>
                                </a>
                            </td>
                        </tr>
                        <?php } ?>

                        <?php if(in_array('param13', $p)){ ?>
                        <tr>
                            <td align="center"><?php print $bilp++;?>.</td>
                            <!-- <td align="center">A001</td> -->
                            <td>Padanan Peringkat Kelulusan Dan Institusi</td>
                            <td align="center">
                                <a href="index.php?data=<?php print base64_encode('pengurusan/jawatan_kelulusan/senarai_jawatan_kelulusan;Pentadbiran;Parameter;Peringkat Kelulusan;;;'); ?>" class="btn btn-md btn-success" data-toggle="modal" data-taraget="#myModal" title="Kemaskini Padanan Peringkat Kelulusan Dan Institusi">
                                    <i class="fa fa-edit"></i>
                                </a>
                            </td>
                        </tr>
                        <?php } ?>

                        <?php if(in_array('param14', $p)){ ?>
                        <tr>
                            <td align="center"><?php print $bilp++;?>.</td>
                            <!-- <td align="center">A001</td> -->
                            <td>Padanan Institusi Dan Pengkhususan</td>
                            <td align="center">
                                <a href="index.php?data=<?php print base64_encode('pengurusan/parameter/padanan_institusi_pengkhususan;Pentadbiran;Parameter;Padanan Institusi Dan Pengkhususan;;;'); ?>" class="btn btn-md btn-success" data-toggle="modal" data-taraget="#myModal" title="Kemaskini Maklumat Padanan Institusi Dan Pengkhususan">
                                    <i class="fa fa-edit"></i>
                                </a>
                            </td>
                        </tr>
                        <?php } ?>

                        <?php if(in_array('param15', $p)){ ?>
                        <tr>
                            <td align="center"><?php print $bilp++;?>.</td>
                            <!-- <td align="center">A001</td> -->
                            <td>Padanan Peringkat Akademik Dan Skim</td>
                            <td align="center">
                                <a href="index.php?data=<?php print base64_encode('pengurusan/parameter/padanan_akademik_skim;Pentadbiran;Parameter;Padanan Peringkat Akademik Dan Skim;;;'); ?>" class="btn btn-md btn-success" data-toggle="modal" data-taraget="#myModal" title="Kemaskini Maklumat Padanan Peringkat Akademik Dan Skim">
                                    <i class="fa fa-edit"></i>
                                </a>
                            </td>
                        </tr>
                        <?php } ?>
			
			<!--
                        <?php if(in_array('param16', $p)){ ?>
                        <tr>
                            <td align="center"><?php print $bilp++;?>.</td>
                            <td>Padanan Pengkhususan Kluster Dan Mata Pelajaran</td>
                            <td align="center">
                                <a href="index.php?data=<?php print base64_encode('pengurusan/kod_kluster/padanan_pengkhususan_kluster;Pentadbiran;Parameter;Padanan Pengkhususan Kluster Dan Mata Pelajaran;;;'); ?>" class="btn btn-md btn-success" data-toggle="modal" data-taraget="#myModal" title="Kemaskini Maklumat Padanan Pengkhususan Kluster Dan Mata Pelajaran">
                                    <i class="fa fa-edit"></i>
                                </a>
                            </td>
                        </tr>
                        <?php } ?>
		        -->      

			<!--
                        <tr>
                            <td align="center">16. </td>
                            <td>Padanan Pengkhususan Dan Skim</td>
                            <td align="center">
                                <a href="index.php?data=<?php print base64_encode('pengurusan/parameter/padanan_pengkhususan_skim;Pentadbiran;Parameter;Padanan Pengkhususan Dan Skim;;;'); ?>" class="btn btn-md btn-success" data-toggle="modal" data-taraget="#myModal" title="Kemaskini Maklumat Skim Berdasarkan Pengkhususan">
                                    <i class="fa fa-edit"></i>
                                </a>
                            </td>
                        </tr>
			-->
<!-- 
                        <tr>
                            <td align="center">16. </td>
                            <td>Padanan Bidang Dan Pengkhususan</td>
                            <td align="center">
                                <a href="index.php?data=<?php print base64_encode('pengurusan/parameter/padanan_bidang_pengkhususan;Pentadbiran;Parameter;Padanan Bidang Dan Pengkhususan;;;'); ?>" class="btn btn-md btn-success" data-toggle="modal" data-taraget="#myModal" title="Kemaskini Maklumat Jawatan Berdasarkan Kelulusan">
                                    <i class="fa fa-edit"></i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td align="center">17. </td>
                            <td>Padanan Kluster Dan Bidang</td>
                            <td align="center">
                                <a href="index.php?data=<?php print base64_encode('pengurusan/parameter/padanan_kluster_bidang;Pentadbiran;Parameter;Padanan Kluster Dan Bidang;;;'); ?>" class="btn btn-md btn-success" data-toggle="modal" data-taraget="#myModal" title="Kemaskini Maklumat Jawatan Berdasarkan Kelulusan">
                                    <i class="fa fa-edit"></i>
                                </a>
                            </td>
                        </tr>
-->
                    </tbody>
                </table>
            </div>
		</div>
     </div>
  </div>    

           