<?php include '../connection/common.php'; //$conn->debug=true; ?>
<script type="text/javascript">
    window.onload = function() { window.print(); }
</script>
<style>
	@media print {
    		.pagebreak { page-break-before: always; } /* page-break-after works, as well */
	}
</style>
<?php 
$id_pemohon=isset($_REQUEST["id_pemohon"])?$_REQUEST["id_pemohon"]:"";
$filename=isset($_REQUEST["filename"])?$_REQUEST["filename"]:"";
// $doc=isset($_REQUEST["doc"])?$_REQUEST["doc"]:"";


//print $ext;
?>
    <!-- <div class="modal-title"><i class="icon-pen"></i> Paparan Dokumen</div> -->

                
    <?php
	if($filename == 'semua_dokumen_pemohon'){
        	$sql = "SELECT * FROM $schema2.`calon_sijil` WHERE id_pemohon=".tosql($id_pemohon). " AND jenis_sijil NOT IN('UNIV1C','UNIV2C','UNIV3C')";
	} else {
		$sql = "SELECT * FROM $schema2.`calon_sijil` WHERE id_pemohon=".tosql($id_pemohon). " AND jenis_sijil IN('UNIV1C','UNIV2C','UNIV3C')";
	}
        $rsData = $conn->query($sql);

        while(!$rsData->EOF){ 
            $tmp = explode('.', $rsData->fields['sijil_nama']);
            $ext = end($tmp);

    ?>
<div class="pagebreak"> 
        <?php if($ext=='jpg' || $ext=='gif' || $ext=='png' || $ext=='jpeg' || $ext=='PNG' || $ext == 'JPG' || $ext == 'JPEG' || $ext == 'GIF') { ?>
            Nama Dokumen : <?php //print $rsData->fields['sijil_nama']; ?>
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
			    if(!empty($rsData->fields['sijil_nama'])){
				$sijil_pic = "/var/www/upload/".$id_pemohon."/".$rsData->fields['sijil_nama']; 
                                if (file_exists($sijil_pic)){
     					$b64image = base64_encode(file_get_contents($sijil_pic));
     					$sijil = "data:image/png;base64,$b64image";	
				} else { 
					//print 'tak jumpa: '.$sijil_pic; 
				}
                            }

	?>	<img src="<?=$sijil;?>" width="80%" height="80%">

            <!--<img src="/upload/<?=$id_pemohon?>/<?=$rsData->fields['sijil_nama'];?>" width="100%" height="100%">--> 

        <?php } else if($ext=='pdf'){ ?>
            Nama Dokumen : <?php //print $rsData->fields['sijil_nama']; ?>
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
					    } ?> 
	            <embed src="/upload/<?=$id_pemohon?>/<?=$rsData->fields['sijil_nama'];?>" type='application/pdf' width='100%' height='800px' />
		
        <?php } ?>  
    <?php 
    $rsData->movenext(); } ?>
</div>
                        
                      


