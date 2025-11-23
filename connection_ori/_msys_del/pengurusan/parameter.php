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
                        <tr>
                            <td align="center">1.</td>
                            <!-- <td align="center">A002</td> -->
                            <td>Negeri</td>
                            <td align="center">
                                <a href="index.php?data=<?php print base64_encode('pengurusan/kod_negeri/senarai_negeri;Pentadbiran;Parameter;ALL;;;'); ?>" class="btn btn-md btn-success" title="Kemaskini Maklumat Kod Negeri">
                                    <i class="fa fa-edit"></i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td align="center">2.</td>
                            <!-- <td align="center">A003</td> -->
                            <td>Bangsa</td>
                            <td align="center">
                                <a href="index.php?data=<?php print base64_encode('pengurusan/parameter/senarai_bangsa;Pentadbiran;Parameter;Senarai Bangsa;;;'); ?>" class="btn btn-md btn-success" title="Kemaskini Maklumat Bangsa">
                                    <i class="fa fa-edit"></i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td align="center">3.</td>
                            <!-- <td align="center">A003</td> -->
                            <td>Jenis OKU</td>
                            <td align="center">
                                <a href="index.php?data=<?php print base64_encode('pengurusan/parameter/senarai_OKU;Pentadbiran;Parameter;Jenis OKU;;;'); ?>" class="btn btn-md btn-success" title="Kemaskini Maklumat Jenis OKU">
                                    <i class="fa fa-edit"></i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td align="center">4.</td>
                            <!-- <td align="center">A003</td> -->
                            <td>Pusat Temu Duga</td>
                            <td align="center">
                                <a href="index.php?data=<?php print base64_encode('pengurusan/parameter/senarai_pusatTemuduga;Pentadbiran;Parameter;Senarai Pusat Temu Duga;;;'); ?>" class="btn btn-md btn-success" title="Kemaskini Maklumat Pusat Temu Duga">
                                    <i class="fa fa-edit"></i>
                                </a>
                            </td>
                        </tr>
                        <!-- <tr>
                            <td align="center">5.</td>
                            <td>Senarai Ijazah Untuk Setiap Universiti</td>
                            <td align="center">
                                <a href="index.php?data=<?php print base64_encode('pengurusan/parameter/senarai_ijazah;Pentadbiran;Parameter;Senarai Ijazah;;;'); ?>" class="btn btn-md btn-success" title="Kemaskini Maklumat Ijazah">
                                    <i class="fa fa-edit"></i>
                                </a>
                            </td>
                        </tr> -->
                        <tr>
                            <td align="center">5.</td>
                            <!-- <td align="center">A003</td> -->
                            <td>CGPA</td>
                            <td align="center">
                                <a href="index.php?data=<?php print base64_encode('pengurusan/parameter/senarai_cgpa;Pentadbiran;Parameter;Senarai CGPA;;;'); ?>" class="btn btn-md btn-success" title="Kemaskini Maklumat CGPA">
                                    <i class="fa fa-edit"></i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td align="center">6.</td>
                            <!-- <td align="center">A002</td> -->
                            <td>Jenis Domain Emel</td>
                            <td align="center">
                                <a href="index.php?data=<?php print base64_encode('pengurusan/parameter/senarai_domainEmail;Pentadbiran;Parameter;Domain Emel;;;'); ?>" class="btn btn-md btn-success" data-toggle="modal" data-taraget="#myModal" title="Kemaskini Maklumat Jawatan Berdasarkan Kelulusan">
                                    <i class="fa fa-edit"></i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td align="center">7.</td>
                            <!-- <td align="center">A002</td> -->
                            <td>Mata Pelajaran Maklumat Akademik</td>
                            <td align="center">
                                <a href="index.php?data=<?php print base64_encode('pengurusan/parameter/senarai_matapelajaran;Pentadbiran;Parameter;Mata Pelajaran Maklumat Akademik;;;'); ?>" class="btn btn-md btn-success" data-toggle="modal" data-taraget="#myModal" title="Kemaskini Mata Pelajaran Maklumat Akademik">
                                    <i class="fa fa-edit"></i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td align="center">8.</td>
                            <!-- <td align="center">A001</td> -->
                            <td>Kluster</td>
                            <td align="center">
                                <a href="index.php?data=<?php print base64_encode('pengurusan/kod_kluster/senarai_kod_kluster;Pentadbiran;Parameter;ALL;;;'); ?>" class="btn btn-md btn-success" data-toggle="modal" data-taraget="#myModal" title="Kemaskini Maklumat Jawatan Berdasarkan Kelulusan">
                                    <i class="fa fa-edit"></i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td align="center">8.</td>
                            <!-- <td align="center">A001</td> -->
                            <td>Bidang</td>
                            <td align="center">
                                <a href="index.php?data=<?php print base64_encode('pengurusan/kod_bidang/senarai_kod_bidang;Pentadbiran;Parameter;ALL;;;'); ?>" class="btn btn-md btn-success" data-toggle="modal" data-taraget="#myModal" title="Kemaskini Maklumat Jawatan Berdasarkan Kelulusan">
                                    <i class="fa fa-edit"></i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td align="center">9.</td>
                            <!-- <td align="center">A003</td> -->
                            <td>Institusi</td>
                            <td align="center">
                                <a href="index.php?data=<?php print base64_encode('pengurusan/parameter/senarai_universiti;Pentadbiran;Parameter;Senarai Universiti;;;'); ?>" class="btn btn-md btn-success" title="Kemaskini Maklumat Universiti">
                                    <i class="fa fa-edit"></i>
                                </a>
                            </td>
                        </tr>
                        
                        <tr>
                            <td align="center">10.</td>
                            <!-- <td align="center">A003</td> -->
                            <td>Pengkhususan</td>
                            <td align="center">
                                <a href="index.php?data=<?php print base64_encode('pengurusan/parameter/senarai_pengkhususan;Pentadbiran;Parameter;Pengkhususan;;;'); ?>" class="btn btn-md btn-success" title="Kemaskini Maklumat Pengkhususan">
                                    <i class="fa fa-edit"></i>
                                </a>
                            </td>
                        </tr>

                        <tr>
                            <td align="center">11.</td>
                            <!-- <td align="center">A003</td> -->
                            <td>Skim</td>
                            <td align="center">
                                <a href="index.php?data=<?php print base64_encode('pengurusan/parameter/senarai_skim;Pentadbiran;Parameter;Skim;;;'); ?>" class="btn btn-md btn-success" title="Kemaskini Maklumat Skim">
                                    <i class="fa fa-edit"></i>
                                </a>
                            </td>
                        </tr>

                        <tr>
                            <td align="center">12. </td>
                            <!-- <td align="center">A001</td> -->
                            <td>Peringkat Kelulusan</td>
                            <td align="center">
                                <a href="index.php?data=<?php print base64_encode('pengurusan/parameter/senarai_peringkat_kelulusan;Pentadbiran;Parameter;Peringkat Kelulusan;;;'); ?>" class="btn btn-md btn-success" data-toggle="modal" data-taraget="#myModal" title="Kemaskini Maklumat Peringkat Kelulusan">
                                    <i class="fa fa-edit"></i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td align="center">12. </td>
                            <!-- <td align="center">A001</td> -->
                            <td>Padanan Peringkat Kelulusan Dan Institusi</td>
                            <td align="center">
                                <a href="index.php?data=<?php print base64_encode('pengurusan/jawatan_kelulusan/senarai_jawatan_kelulusan;Pentadbiran;Parameter;Peringkat Kelulusan;;;'); ?>" class="btn btn-md btn-success" data-toggle="modal" data-taraget="#myModal" title="Kemaskini Maklumat Jawatan Berdasarkan Kelulusan">
                                    <i class="fa fa-edit"></i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td align="center">13. </td>
                            <!-- <td align="center">A001</td> -->
                            <td>Padanan Institusi Dan Pengkhususan</td>
                            <td align="center">
                                <a href="index.php?data=<?php print base64_encode('pengurusan/parameter/padanan_institusi_pengkhususan;Pentadbiran;Parameter;Padanan Institusi Dan Pengkhususan;;;'); ?>" class="btn btn-md btn-success" data-toggle="modal" data-taraget="#myModal" title="Kemaskini Maklumat Jawatan Berdasarkan Kelulusan">
                                    <i class="fa fa-edit"></i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td align="center">14. </td>
                            <!-- <td align="center">A001</td> -->
                            <td>Padanan Peringkat Akademik Dan Skim</td>
                            <td align="center">
                                <a href="index.php?data=<?php print base64_encode('pengurusan/parameter/padanan_akademik_skim;Pentadbiran;Parameter;Padanan Peringkat Akademik Dan Skim;;;'); ?>" class="btn btn-md btn-success" data-toggle="modal" data-taraget="#myModal" title="Kemaskini Maklumat Jawatan Berdasarkan Kelulusan">
                                    <i class="fa fa-edit"></i>
                                </a>
                            </td>
                        </tr>
                        <!-- <tr>
                            <td align="center">14. </td>
                            <td>Padanan Pengkhususan Dan Skim</td>
                            <td align="center">
                                <a href="index.php?data=<?php print base64_encode('pengurusan/parameter/padanan_pengkhususan_skim;Pentadbiran;Parameter;Padanan Pengkhususan Dan Skim;;;'); ?>" class="btn btn-md btn-success" data-toggle="modal" data-taraget="#myModal" title="Kemaskini Maklumat Skim Berdasarkan Pengkhususan">
                                    <i class="fa fa-edit"></i>
                                </a>
                            </td>
                        </tr> -->
                        <tr>
                            <td align="center">15. </td>
                            <!-- <td align="center">A001</td> -->
                            <td>Padanan Bidang Dan Pengkhususan</td>
                            <td align="center">
                                <a href="index.php?data=<?php print base64_encode('pengurusan/parameter/padanan_bidang_pengkhususan;Pentadbiran;Parameter;Padanan Bidang Dan Pengkhususan;;;'); ?>" class="btn btn-md btn-success" data-toggle="modal" data-taraget="#myModal" title="Kemaskini Maklumat Jawatan Berdasarkan Kelulusan">
                                    <i class="fa fa-edit"></i>
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
		</div>
     </div>
  </div>    

           