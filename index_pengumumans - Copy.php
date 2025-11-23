<!-- Pengumuman -->
<section class="bg-light py-3 px-0">
    <div class="container-xxl px-2">
        <div class="row align-items-center justify-content-center text-center">
            <?php 
            // $rsANN = $conn->query("SELECT *, DATEDIFF(CURDATE(), ann_start) AS date_difference FROM portal_pengumuman WHERE ann_status=0 AND ann_deleted=0 ORDER BY ann_start DESC"); 
            $rsANN = $conn->query("SELECT *, DATEDIFF(CURDATE(), tarikh_mula) AS date_difference FROM cms WHERE `status`=1 AND is_deleted=0 ORDER BY tarikh_mula DESC"); 
            ?> 
             <div class="col-lg-5 col-xs-12 col-md-6" style="min-height: 300px;">
                <h1 class="mb-3">Pengumuman</h1>
                <ul class="list-group mx-2 scrollClass border border-primary border-2" style="min-height: 230px">
                    <?php
                    while(!$rsANN->EOF){ $bil++;
                        $idAnn=$rsANN->fields['id'];
                    ?>
                    <li class="list-group-item" style="text-align: left;cursor:pointer;" onclick="open_modal('ANN','<?=$idAnn;?>')"><?=$bil;?>. <?php print $rsANN->fields['title'];?>
                    <?php if($rsANN->fields['date_difference']<=10 && !empty($rsANN->fields['date_difference'])){ print '<img src="images/new-gif.gif" width="50px" height="25px">'; } ?>
                    </li>
                    <?php $rsANN->movenext(); } ?>
                </ul>
            </div>
            
            <div class="col-lg-7 col-md-12 p-0">
                
                <div class="row p-0 m-2 d-flex justify-content-center align-items-stretch ">
                    
                    <div class="menubutton p-2 shadow">
                        <a href="index.php?pages=akta">
                            <div>
                                <i class="fa-solid fa-scale-balanced fa-4x my-2 img-fluid"></i>
                                <div>AKTA MAKANAN HAIWAN 2009 & PERATURAN-PERATURAN DI BAWAH AKTA MAKANAN HAIWAN 2009</div>
                            </div>
                        </a>
                    </div>
                    
                    <div class="menubutton p-2 shadow d-flex justify-content-center align-items-center">
                        <a href="index.php?pages=gras">
                            <div>
                                <i class="fa-solid fa-shield-cat fa-4x my-2 img-fluid"></i>
                                <div>GENERALLY RECOGNIZED AS SAFE (GRAS) LIST</div>
                            </div>
                        </a>
                    </div>
                    
                    <div class="menubutton p-2 shadow d-flex justify-content-center align-items-center">
                        <a href="index.php?pages=borang_panduan">
                            <div>
                                <i class="fa-solid fa-file-lines fa-4x my-2 img-fluid"></i>
                                <div>GARIS PANDUAN PERMOHONAN LESEN / SIJIL PENDAFTARAN</div>
                            </div>
                        </a>
                    </div>
                    
                    <div class="menubutton p-2 shadow d-flex justify-content-center align-items-center">
                        <a href="assets/documents/Carta Alir Permohonan Lesen Mengimport AMH 2009.pdf" target="_blank">
                            <div>
                                <i class="fa-solid fa-truck-fast fa-4x my-2 img-fluid"></i>
                                <div>CARTA ALIR PENGIMPORTAN</div>
                            </div>
                        </a>
                    </div>
                    
                    <div class="menubutton p-2 shadow d-flex justify-content-center align-items-center">
                        <a href="assets/documents/KEPERLUAN MENGISI MAKLUMAT DGN LENGKAP 2022.pdf" target="_blank">
                            <div>
                                <i class="fa-solid fa-circle-exclamation fa-4x my-2 img-fluid"></i>
                                <div>KEPERLUAN MENGISI TAKAT PENGGUNAAN DAN MAKLUMAT LAIN-LAIN BERKAITAN</div>    
                            </div>
                        </a>
                    </div>
                    
                    <div class="menubutton p-2 shadow d-flex justify-content-center align-items-center">
                        <a href="index.php?pages=fsc">
                            <div>
                                <i class="fa-solid fa-certificate fa-4x my-2 img-fluid"></i>
                                <div>TERMA DAN SYARAT PERMOHONAN FSC, TUJUAN KAJIAN DAN TEMUKUT UNTUK MAKANAN HAIWAN</div>
                            </div>
                        </a>
                    </div>
                    
                    <div class="menubutton p-2 shadow d-flex justify-content-center align-items-center">
                        <a href="assets/documents/COA Parameter Makmal yang diperlukan.pdf" target="_blank">
                            <div>
                                <i class="fa-solid fa-folder-tree fa-4x my-2 img-fluid"></i>
                                <div>KEPERLUAN PARAMETER ANALISA MAKMAL</div>
                            </div>
                        </a>
                    </div>
                    
                    <div class="menubutton p-2 shadow d-flex justify-content-center align-items-center">
                        <a href="assets/documents/Manual Pengguna V1.0.pdf" target="_blank">>
                            <div>
                                <i class="fa-solid fa-book-open fa-4x my-2 img-fluid"></i>
                                <div>MANUAL PENGGUNA</div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>