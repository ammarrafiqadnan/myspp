<!-- <small style="color: red;">
    Tarikh dikemskini : 04-03-2022 10:30:23 <br>
    Maklumat Jawatan Dipohon adalah maklumat Jawatan yang dipohon oleh calon.<br><br>
</small> -->


<script>
    function do_print(val){
        do_cetak(val);
    }
</script>
<header class="panel-heading"  style="background-color:rgb(38, 167, 228)">
    <h6 class="panel-title"><font color="#000000" size="3"><b>MAKLUMAT DOKUMEN</b></font></h6>
</header>
<div class="panel-body">
    <div class="box-body">
        <div class="col-md-12">
            <div class="form-group">
                <div align="right">
		    <button type="button" class="btn btn-sm btn-info" onclick="do_print('cetak.php?pages=pemohon/dokumen_print_all&prn=&id_pemohon=<?=$data->fields['id_pemohon'];?>&filename=semua_dokumen_pemohon')">
                        <span style="cursor:pointer;" title="Cetak Semua Dokumen Pemohon">
                            <i class="fa fa-print" style="color: #FFFFFF;"></i> Cetak Dokumen
                        </span>
                    </button>

                    <button type="button" class="btn btn-sm btn-info" onclick="do_print('cetak.php?pages=pemohon/dokumen_print_all&prn=&id_pemohon=<?=$data->fields['id_pemohon'];?>&filename=semua_dokumen_pemohon_pdf')">
                        <span style="cursor:pointer;" title="Cetak Dokumen Transkrip">
                            <i class="fa fa-print" style="color: #FFFFFF;"></i> Cetak Dokumen PDF
                        </span>
                    </button>
                </div>
                <br>
                <div class="row">
                    <div class="col-sm-12">
                        <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                            <thead  style="background-color:rgb(38, 167, 228)">
                                <th width="5%"><font color="#000000"><div align="center">No.</div></font></th>
                                <th width="25%"><font color="#000000"><div>Nama Dokumen</div></font></th>
                                <th width="60%"><font color="#000000"><div>Dokumen</div></font></th>
                                <th width="10%"><font color="#000000"><div>Cetak</div></font></th>
                            </thead>
                            <tbody>
                                <?php
                                //$conn->debug=true;  
                                $bil = 0;
                                    $sql = "SELECT * FROM $schema2.`calon_sijil` WHERE id_pemohon=".tosql($data->fields['id_pemohon']);
                                    $rsData = $conn->query($sql);

                                    $sql2 = "SELECT * FROM $schema2.`calon_sijil` WHERE id_pemohon=".tosql($data->fields['id_pemohon']);
                                    //$countrsData = $conn->query($sql2);
                                    //if($countJawatan->fields['total'] != 0){
				    if(!$rsData->EOF){	
                                    while(!$rsData->EOF){ 
                
                                ?>
                                <tr>
                                    <td><?=++$bil;?></td>
                                    <td>
                                        <?php 
						//print $rsData->fields['jenis_sijil'];
                                            if($rsData->fields['jenis_sijil'] == 'PMR'){
                                                print 'Sijil PMR';
                                            } else if($rsData->fields['jenis_sijil'] == 'SPM1'){
                                                print 'Sijil SPM (Maklumat Peperiksaan Pertama)';
                                            } else if($rsData->fields['jenis_sijil'] == 'SPM12'){
                                                print 'Sijil SPM (Maklumat Peperiksaan Kedua)';
                                            } else if($rsData->fields['jenis_sijil'] == 'SVM1'){
                                                print 'Sijil SVM (Maklumat Peperiksaan Pertama)';
                                            } else if($rsData->fields['jenis_sijil'] == 'SVM2'){
                                                print 'Sijil SVM (Maklumat Peperiksaan Kedua)';
                                            } else if($rsData->fields['jenis_sijil'] == 'STAM1'){
                                                print 'Sijil STAM (Maklumat Peperiksaan Pertama)';
                                            } else if($rsData->fields['jenis_sijil'] == 'STAM2'){
                                                print 'Sijil STAM (Maklumat Peperiksaan Kedua)';
                                            } else if($rsData->fields['jenis_sijil'] == 'STPM1'){
                                                print 'Sijil STPM (Maklumat Peperiksaan Pertama)';
                                            } else if($rsData->fields['jenis_sijil'] == 'STPM2'){
                                                print 'Sijil STPM (Maklumat Peperiksaan Kedua)';
                                            } else if($rsData->fields['jenis_sijil'] == 'UNIV1A'){
                                                print 'Sijil Pengajian Tinggi (Maklumat Keputusan Pertama)';
                                            } else if($rsData->fields['jenis_sijil'] == 'UNIV1B'){
                                                print 'Sijil Penguasaan Bahasa Inggeris (Maklumat Keputusan Pertama)';
                                            } else if($rsData->fields['jenis_sijil'] == 'UNIV1C'){
                                                print 'Transkrip Pengajian Tinggi (Maklumat Keputusan Pertama)';
                                            } else if($rsData->fields['jenis_sijil'] == 'UNIV2A'){
                                                print 'Sijil Pengajian Tinggi (Maklumat Keputusan Kedua)';
                                            } else if($rsData->fields['jenis_sijil'] == 'UNIV2B'){
                                                print 'Sijil Penguasaan Bahasa Inggeris (Maklumat Keputusan Kedua)';
                                            } else if($rsData->fields['jenis_sijil'] == 'UNIV2C'){
                                                print 'Transkrip Pengajian Tinggi (Maklumat Keputusan Kedua)';
                                            } else if($rsData->fields['jenis_sijil'] == 'UNIV3A'){
                                                print 'Sijil Pengajian Tinggi (Maklumat Keputusan Ketiga)';
                                            } else if($rsData->fields['jenis_sijil'] == 'UNIV3B'){
                                                print 'Sijil Penguasaan Bahasa Inggeris (Maklumat Keputusan Ketiga)';
                                            } else if($rsData->fields['jenis_sijil'] == 'UNIV3C'){
                                                print 'Transkrip Pengajian Tinggi (Maklumat Keputusan Ketiga)';
                                            } else if($rsData->fields['jenis_sijil'] == 'PRO'){
                                                print 'Sijil Profesional';
                                            } else if($rsData->fields['jenis_sijil'] == 'ULANG'){
					    	print 'Sijil SPM Ulangan';
					    }                                       
				        ?>
                                    </td>
                                    <td>
                                        <!--<a href="../view_doc_pemohon.php?id_pemohon=<?=$data->fields['id_pemohon'];?>&doc=<?=$rsData->fields['sijil_nama'];?>" data-toggle="modal" data-target="#myModal"><?=$rsData->fields['sijil_nama'];?></a>-->
					<a href="../view_doc_pemohon.php?id_pemohon=<?=$data->fields['id_pemohon'];?>&doc=<?=$rsData->fields['sijil_nama'];?>" 
				onclick="return popitup('../view_doc_pemohon.php?id_pemohon=<?=$data->fields['id_pemohon'];?>&doc=<?=$rsData->fields['sijil_nama'];?>')"><?=$rsData->fields['sijil_nama'];?></a>
                                    </td>
                                    <td>
                                        <!-- <a href="cetak_borang.php?pages=pemohon/view_doc_pemohon&id_pemohon=<?=$data->fields['id_pemohon'];?>&doc=<?=$rsData->fields['sijil_nama'];?>" data-rel="tooltip" title="Cetak permohonan" target="_window"><span class='fa fa-print bigger-300' ></a> -->

                                        <button class="btn btn-info" onclick="do_print('cetak.php?pages=pemohon/dokumen_print&prn=&id_pemohon=<?=$data->fields['id_pemohon'];?>&doc=<?=$rsData->fields['sijil_nama'];?>&filename=dokumen_pemohon')" ><span class='fa fa-print bigger-300' ></button>
                                    </td>
                                </tr>
                                <?php 
                                $rsData->movenext(); }
                                } else { ?>
                                    <tr>
                                        <td colspan="7" align="center">Tiada rekod dijumpai</td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>	 

	     
<!--<div class="form-group">
	    	<div class="row">
                	<div class="col-md-12">
                    		<a type="button" class="btn btn-success" href="index.php?data=<?php print base64_encode('pemohon/senarai_pemohon;Senarai Pemohon;;;;;'); ?>"><i class="fa fa-arrow-left" style="margin:0px;"></i> Kembali</a>
                	</div>
		</div>
            </div>-->

