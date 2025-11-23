    <nav class="navbar navbar-expand-lg navbar-primary bg-light fixed-top fs-6 shadow">
        <div class="container-xxl">
            <!-- navbar brand / title -->
            <div class="navbar-brand py-0 col-2">
                <a class="navbar-brand" href="index.php">
			<img class="visible-lg" src="upload_doc/logo_spp.png" alt="MySPP" height="40px" width="400px" /> 
			<!--<img class="visible-xs" src="upload_doc/logo_spp.png" alt="MySPP" height="60px" width="280px" />-->
			

                    <!--<img src="upload_doc/logo_spp.png" class="brandmd" alt="mySPP" height="50px">-->
                </a>
            </div>
            <!-- toggle button for mobile nav -->
            <button class="navbar-toggler custom-toggler" type="button" data-toggle="collapse" data-target="#main-nav" aria-controls="main-nav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <!-- navbar links -->
            <div class="collapse navbar-collapse justify-content-end align-center" id="main-nav">
                <ul class="navbar-nav" style="color: black">
                    <li class="nav-item">
                        <a class="nav-link <?php if(empty($pages)){ print 'active';}?>" href="index.php">Utama</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php if($pages=='faq'){ print 'active';}?>" href="index.php?pages=faq">Soalan Lazim</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php if($pages=='hubungi_kami'){ print 'active';}?>" href="index.php?pages=hubungi_kami">Hubungi Kami</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="upload_doc/manual_pengguna_permohonanJan2025.pdf" target="_blank">Panduan Pengguna</a>
                    </li>
		    <li class="nav-item">
                        <a class="nav-link" href="upload_doc/pendaftaran.pdf" target="_blank">Infografik</a>
                    </li>
                    <?php if(empty($_SESSION['SESS_UID']) || $_SESSION['SESS_USER']!='COMP-USER'){ ?>
                    <!-- <li class="nav-item ms-2d-none d-md-inline text-center" id="admin_log">
                        <a class="login pr-5 p-2" href="log_masuk_admin.php" >Log Masuk Admin</a>
                    </li> -->
                    <?php } ?>
                    
                </ul>
            </div>
        </div>
    </nav>        
