    <section class="bg-dark p-2">
        <div class="container text-center text-md-left">
            <div class="row text-center text-md-left text-white" style="font-size: 0.8em;">
                
                <div class="col-md-3 col-lg-3 col-xl-3 mx-auto mt-3 text-start">
                    <h5 class="mb-4 fw-bold text-light">Pautan</h5>
                    <a href="https://www.spp.gov.my/ms/" target="_blank" class="link-light" style="text-decoration: none;">Suruhanjaya Perkhidmatan Pendidikan</a><br>
                    <a href="https://www.mqa.gov.my/pv4/" target="_blank" class="link-light" style="text-decoration: none;">Agensi Kelayakan Malaysia (MQA)</a><br>
                    <a href="https://www.moe.gov.my/" target="_blank" class="link-light" style="text-decoration: none;">Kementerian Pendidikan Malaysia</a><br>
                    <a href="https://www.mohe.gov.my/" target="_blank" class="link-light" style="text-decoration: none;">Kementerian Pendidikan Tinggi</a><br>
                    <a href="https://www.malaysia.gov.my" target="_blank" class="link-light" style="text-decoration: none;">MyGovernment</a><br>
                </div>
                
                <div class="col-md-3 col-lg-3 col-xl-3 mx-auto mt-3 text-start">
                    <h5 class="mb-4 fw-bold text-white">Keserasian</h5>
                    <p>
                        <!-- 22/6/2022<br>-->
                        Paparan Terbaik : Mozilla Firefox 7+/Internet Explorer 9+/Safari 4+/Chrome dengan resolusi minimum 1280 x 1024.
                    </p>
                </div>
                
                <div class="col-md-3 col-lg-3 col-xl-3 mx-auto mt-3 text-start">
                    <h5 class="mb-4 fw-bold text-white">Alamat Pejabat</h5>
                    <p>
                        Suruhanjaya Perkhidmatan Pendidikan Malaysia<br>
                        Aras 1-4, Blok F9, Kompleks F,<br>
                        Lebuh Perdana Timur, Presint 1,<br>
                        62000 Putrajaya, Malaysia.<br>
                        Tel : 03-8000 8000<br>
                        Faks : 03-8871 7499<br>
                        Emel : webmaster@spp.gov.my<br>
                        <a href="https://www.facebook.com/SPPHQ/" target="_blank" rel="noopener"><img src="images/fb-footer.png" alt="" width="40" height="40"></a> 
                        <a href="https://twitter.com/SPPmy" target="_blank" rel="noopener"><img src="images/twitter-footer.png" alt="" width="40" height="40"></a> 
                        <a href="https://www.instagram.com/sppmy" target="_blank" rel="noopener"><img src="images/instagram-footer.png" alt="" width="40" height="40"></a>
                    </p>
                </div>
                <?php 
		$tahun_lepas=3490478;
		$dt=date("Y-m-d"); $m = date("m"); $y = date("Y");
		//$rsP = $conn->query("SELECT count(*) AS cnt FROM  $schema1.tbl_capaian"); 
		$rsPT = $conn->query("SELECT count(*) AS cnt1 FROM  $schema1.tbl_capaian WHERE `datetimes` LIKE '$dt%'");
		$rsPM = $conn->query("SELECT count(*) AS cnt1 FROM  $schema1.tbl_capaian WHERE month(`datetimes`)=".tosql($m));
		$rsPY = $conn->query("SELECT count(*) AS cnt1 FROM  $schema1.tbl_capaian WHERE year(`datetimes`)=".tosql($y)); 
		//$jum=189;
		//print $rsP->fields['cnt'];
		$semua = $tahun_lepas+$rsPY->fields['cnt1'];
		?>
                <div class="col-md-3 col-lg-3 col-xl-3 mx-auto mt-3 text-start">
                    <h5 class="mb-4 fw-bold text-white">Jumlah Pelawat</h5>
                    <h1 class="text-white" style="font-size: 4em;">
                        <?php print number_format($semua,0); ?>
                    </h1>
                    <h3 class="text-white" style="font-size: 1em;">
                        Hari Ini : <?php print number_format($rsPT->fields['cnt1'],0); ?>
                    </h3>

                    <h3 class="text-white" style="font-size: 1em;">
                        Bulan Ini : <?php print number_format($rsPM->fields['cnt1'],0); ?>
                    </h3>

                    <h3 class="text-white" style="font-size: 1em;">
                        Tahun Ini : <?php print number_format($rsPY->fields['cnt1'],0); ?>
                    </h3>
	
		    <br>Tarikh Kemaskini : 15 Jun 2023<br>
                </div>
            </div>
        </div>


    </section>
    <!-- <div class="bs-example"  >
        <div id="myModal" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg static"  style="width: 95%;">
                <div class="modal-content">
        
                </div>
            </div>
        </div>
    </div> -->

    <!-- <script src="js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script> -->

<?php $conn->close(); ?>