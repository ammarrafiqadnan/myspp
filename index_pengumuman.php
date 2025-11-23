<!-- Pengumuman -->
    <section class="bg-light">
        <div class="container-xxl px-2">
            <div class="row align-items-center justify-content-center text-center">
            
            <?php 
            // $rsANN = $conn->query("SELECT *, DATEDIFF(CURDATE(), ann_start) AS date_difference FROM portal_pengumuman WHERE ann_status=0 AND ann_deleted=0 ORDER BY ann_start DESC"); 
            $rsANN = $conn->query("SELECT *, DATEDIFF(CURDATE(), tarikh_mula) AS date_difference FROM cms WHERE `status`=1 AND is_deleted=0 ORDER BY tarikh_mula DESC"); 
            ?>    
            <div class="col-lg-6 col-xs-12 col-md-6">
                <h1 class="mb-3">Pengumuman</h1>
                <ul class="list-group mx-3 scrollClass border border-primary border-2">
                    <?php while(!$rsANN->EOF){ $bil++;
                        $idAnn=$rsANN->fields['id'];
                    ?>
                    <li class="list-group-item" style="text-align: left;cursor:pointer;" onclick="open_modal('ANN','<?=$idAnn;?>')"><?=$bil;?>. <?php print $rsANN->fields['title'];?>
                    <?php if($rsANN->fields['date_difference']<=10 && !empty($rsANN->fields['date_difference'])){ print '<img src="images/new-gif.gif" width="50px" height="25px">'; } ?>
                    </li>
                    <?php $rsANN->movenext(); } ?>
                    <!-- <li class="list-group-item">Lorem ipsum dolor sit amet consectetur adipisicing elit.</li>
                    <li class="list-group-item">Lorem ipsum dolor sit amet consectetur adipisicing elit.</li>
                    <li class="list-group-item">Lorem ipsum dolor sit amet consectetur adipisicing elit.</li>
                    <li class="list-group-item">Lorem ipsum dolor sit amet consectetur adipisicing elit.</li> -->
                </ul>
            </div>
            
            <div class="col-6 col-xs-12 p-0">
                
                <div class="row p-0 m-2 justify-content-center align-items-center">
                    
                    <div class="col-md-4 col-lg-3 col-xs-4 p-0 m-0 iconContainer">
                        <a href="index.php?pages=akta" class="text-center text-secondary my-0" style="text-decoration: none;">
                            <div class="card p-2 m-1">                               
                                <i class="fa-solid fa-scale-balanced fa-4x my-2"></i>                                
                                <div class="fw-bold text-primary link p-0 pt-1" style="font-size: 0.8em;">AKTA MAKANAN DAN PERATURAN MAKANAN HAIWAN</div>                             
                            </div>   
                        </a>        
                    </div>

                    <div class="col-md-4 col-lg-3 col-xs-4 p-0 m-0 iconContainer">
                        <a href="akta.html" class="text-center text-secondary my-0" style="text-decoration: none;">
                            <div class="card p-2 m-1">                               
                                <i class="fa-solid fa-gavel fa-4x my-2"></i>                                
                                <div class="fw-bold text-primary link p-0 pt-1" style="font-size: 0.8em;">AKTA MAKANAN DAN PERATURAN MAKANAN HAIWAN</div>                             
                            </div>   
                        </a>        
                    </div>

                    <div class="col-md-4 col-lg-3 col-xs-4 p-0 m-0 iconContainer">
                        <a href="akta.html" class="text-center text-secondary my-0" style="text-decoration: none;">
                            <div class="card p-2 m-1">                               
                                <i class="fa-solid fa-book fa-4x my-2"></i>
                                <div class="fw-bold text-primary link p-0 pt-1" style="font-size: 0.8em;">AKTA MAKANAN DAN PERATURAN MAKANAN HAIWAN</div>                             
                            </div>   
                        </a>        
                    </div>
                    
                 </div>
            </div>
        </div>
    </section>