<?php @session_start(); ?>
<?php
header("Expires: Tue, 01 Jan 2000 00:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
?> 
<?php
include 'connection/common_log.php';
if(empty($pages)){
    $pages=isset($_REQUEST["pages"])?$_REQUEST["pages"]:"";
}
// Declare an associative array
// $arr = array( "bg.webp", "bgfaq.webp", "bghubungi.jpg", "bgakta.png" );
$arr = array( "../upload_doc/bg-spp.jpg");
// Use shuffle function to randomly assign numeric
// key to all elements of array.
shuffle($arr);
// Display the first shuffle element of array
// print "PG:".$pages;
if(empty($pages)){
    $bg_img = $arr[0];
} else {
    $bg_img = "../upload_doc/bg-spp.jpg";
}

$dt_visit=isset($_SESSION['dt_visit'])?$_SESSION['dt_visit']:"";
//print $dt_visit;
$new = time();
$gt = $new - (int)$dt_visit;
//echo $_SESSION['dt_visit'].":".$gt;
if($gt>300){
  $_SESSION['dt_visit']="";
} else {
  $_SESSION['dt_visit']=time();
}
if(empty($_SESSION['dt_visit'])){
  // $conn->debug=true;
  $tarikh = date('Y-m-d H:i:s');
  $ip = $_SERVER['REMOTE_ADDR'];
  $_SESSION['dt_visit']= time();
  $sql = "INSERT INTO $schema1.`tbl_capaian`(`datetimes`, `ip`) VALUES('{$tarikh}', '{$ip}')";
  $conn->execute($sql);
  //echo "2".$sql."<br>";
}

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistem MySPP</title>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
    
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/custom.css">
	<!-- <link rel="stylesheet" href="../eamh/assets/vendor/bootstrap/css/bootstrap.css" /> -->
    <script src="js/fd82e21e86.js" crossorigin="anonymous"></script>
    <link rel="favicon.ico">
    <style>
        
        #intro {
            padding : 40px 0px;
        }
        
        .big-banner {
            background-image: url('images/<?=$bg_img;?>');
            background-position: center;
            background-repeat: no-repeat;
            background-size: 100% 100%;
        }
        
        .scrollClass {
            height:150px;
            overflow-y: scroll;
        }
        
        .marquee {
            white-space: nowrap;
            overflow: hidden;
        }
        
        .marquee div {
            padding-left: 100%;
            display: inline-block;
            animation: animate 10s linear infinite;
        }
        
        @keyframes animate {
            100% {
                transform: translate(-100%, 0);
            }
        }
        
        .input-icons i {
            position: absolute;
            opacity: 0.8;
        }
        
        .input-icons {
            width: 100%;
            color: #081c52;
        }
        
        .input-icons:focus {
            border-color: #2487ce;
        }
        
        .loginIcon {
            padding: 15px;
            min-width: 40px;
        }
        
        .input-field {
            width: 100%;
            padding: 10px;
            text-align: center;
        }
        
        .imgBig {
            background-image: url("assets/infographic.svg");
            background-size: cover;
            background-position: center;
            display: block;
            border: none;
            
        }
        
        .menubutton {
            background-color: white;
            margin: 3px;
            transition: ease-in 0.2s;
            border-radius: 5px;
            width: 24%;
        }
        
        @media only screen and (max-width:768px) {
            .menubutton {
                width: 40%;
            }
        }
        
        .menubutton a {
            color: #081c52;
            text-decoration: none;
            font-weight: bold;
            font-size: 0.7em;
        }
        
        .menubutton:hover {
            background-color: #081c52;
        }
        
        .menubutton:hover a {
            color: white;
        }

	.menubutton:hover h6 {
            color: white;
        }

	@media (min-width: 1200px) and (max-width: 1599px) {
	html.scroll .visible-lg,
	html.fixed .visible-lg {
		display: block !important;
	}

	html.scroll table.visible-lg,
	html.fixed table.visible-lg {
		display: table;
	}

	html.scroll tr.visible-lg,
	html.fixed tr.visible-lg {
		display: table-row !important;
	}

	html.scroll th.visible-lg,
	html.scroll td.visible-lg,
	html.fixed th.visible-lg,
	html.fixed td.visible-lg {
		display: table-cell !important;
	}

	html.scroll .visible-lg-block,
	html.fixed .visible-lg-block {
		display: block !important;
	}

	html.scroll .visible-lg-inline,
	html.fixed .visible-lg-inline {
		display: inline !important;
	}

	html.scroll .visible-lg-inline-block,
	html.fixed .visible-lg-inline-block {
		display: inline-block !important;
	}

	html.scroll .hidden-lg,
	html.fixed .hidden-lg {
		display: none !important;
	}
}

@media (min-width: 1600px) {
	html.scroll .visible-lg-block,
	html.fixed .visible-lg-block {
		display: none !important;
	}

	html.scroll .visible-lg-inline,
	html.fixed .visible-lg-inline {
		display: none !important;
	}

	html.scroll .visible-lg-inline-block,
	html.fixed .visible-lg-inline-block {
		display: none !important;
	}
}

@media (min-width: 1600px) {
	html.scroll .visible-xl,
	html.fixed .visible-xl {
		display: block !important;
	}

	html.scroll table.visible-xl,
	html.fixed table.visible-xl {
		display: table;
	}

	html.scroll tr.visible-xl,
	html.fixed tr.visible-xl {
		display: table-row !important;
	}

	html.scroll th.visible-xl,
	html.scroll td.visible-xl,
	html.fixed th.visible-xl,
	html.fixed td.visible-xl {
		display: table-cell !important;
	}

	html.scroll .visible-xl-block,
	html.fixed .visible-xl-block {
		display: block !important;
	}

	html.scroll .visible-xl-inline,
	html.fixed .visible-xl-inline {
		display: inline !important;
	}

	html.scroll .visible-xl-inline-block,
	html.fixed .visible-xl-inline-block {
		display: inline-block !important;
	}

	html.scroll .hidden-xl,
	html.fixed .hidden-xl {
		display: none !important;
	}
}
    </style>
    
    <link href="index_files/fontawesome.css" rel="stylesheet">
    <!-- <link href="index_files/style.css" rel="stylesheet"> -->
    <link href="index_files/owl.css" rel="stylesheet">
    <link rel="stylesheet" href="salert/sweetalert2.css">
    <script src="salert/sweetalert2.min.js"></script>
    <script src="salert/sweetalert2.common.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="js/proses.js"></script>

</head>
<body style="background-image: url('uploads_doc/bg-pemenang.jpg')">
<form name="myspp" id="myspp" method="post" action="" enctype="multipart/form-data" autocomplete="off">
    
    <!-- navbar -->
    <?php 
    include 'index_navi.php'; ?>

    <!-- Intro -->
    <div style="min-height: 630px;">
    <?php 
	
    //print "PG:".$page.":".$pages;
    $main_pg = $pages;	
    if(empty($pages)){ 
        include 'index_main.php';
    } else if(!empty($pages)){
        if($pages=='daftar'){
            include 'daftar.php';
        } else if($pages=='faq'){
            include 'faq.php';
        } else if($pages=='hubungi_kami'){
            include 'hubungi_kami.php';
        } else if($pages=='akta'){
            include 'akta.php';
        } else if($pages=='lupapass'){
            include '_usys/fprofile/user_lupa_form.php';
        } else if($pages=='lupapassadm'){
            include '_msys/pentadbiran/user_lupa_form.php';
        } else {
           include $pages.'.php';
        } 
    }
    ?>
    </div>
    <!-- Footer -->    
    <?php include 'index_footer.php'; ?>    


        <div class="bs-example">
            <div id="myModal" class="modal fade" role="dialog" tabindex="-1" >
                <div class="modal-dialog modal-lg static">
                    <div class="modal-content">
            
                    </div>
                </div>
            </div>
        </div>
    <div class="bs-example">
        <div id="myModalInfo" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg static">
                <div class="modal-content">
                    <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading"  style="background-color:rgb(38, 167, 228);padding: 10px 10px 10px 10px;">
                            <!-- <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button> -->
                            <h6 class="panel-title"><font color="#000000" size="3"><b>PERINGATAN</b></font></h6>
                        </header>
                        <div class="panel-body">
                            <div class="box-body" style="padding: 10px 10px 10px 10px;">
				<ul>
				<!-- <li style="text-align: justify;">mySPP telah dinaiktaraf berkuatkuasa pada 15 Jun 2023. Semua pemohon (baharu/sedia ada) perlu mendaftar akaun baharu 
				bagi memohon jawatan di bawah SPP. Untuk maklumat lanjut, sila rujuk Panduan Pengguna dan Soalan Lazim.</li><br>
				<!--<li style="text-align: justify;">Bagi pemohon jawatan <b>Pegawai Perkhidmatan Pendidikan (PPP) Gred DG41</b> yang telah mendaftar jawatan <b>sebelum atau pada 21 April 2023</b>, 
				tidak perlu mendaftar akaun baharu sehingga diberitahu kelak.</li><br>-->
				<li style="text-align: justify;">Di bawah Seksyen 5, Akta Suruhanjaya-suruhanjaya Perkhidmatan 1957 (Semakan 1989), seseorang pemohon yang memberi maklumat 
				palsu atau mengelirukan kepada Suruhanjaya berkaitan sesuatu permohonan untuk mendapatkan pekerjaan atau pelantikan adalah melakukan 
				kesalahan dan jika disabitkan boleh dihukum penjara selama tempoh dua (2) tahun atau denda dua ribu Ringgit Malaysia (RM2,000) atau kedua-duanya sekali.</li>
				</ul>
                            </div><br>
                            <div align="center"><button type="button" class="btn btn-primary" data-dismiss="modal" aria-hidden="true">Tutup</button><br></div>
                            <br>		
			</div>
                    </section>
                </div>
                </div>
            </div>
        </div>
    </div>
</form>
</body>

<footer class="footercolor text-white">
    <div class="container-xxl py-1 text-center">
        <span style="font-size: 0.8em;">Â©<?=date("Y");?> oleh Suruhanjaya Perkhidmatan Pendidikan. Semua hakcipta terpelihara.</span><br>
        <span style="font-size: 0.8em;">
            <!--Penafian :  SPP tidak bertanggungjawab atas kehilangan atau kerosakan disebabkan penggunaan informasi yang diperolehi daripada portal ini dan penggunaan Google Translate untuk Bahasa Inggeris dan bahasa asing adalah tidak tepat.-->
        </span>
    </div>
</footer>

        <!-- Bootstrap core JavaScript -->
        <script src="index_files/jquery.js"></script>
        <script src="index_files/bootstrap.js"></script>
        <!-- <script src="assets/vendor/bootstrap/js/bootstrap.js"></script> -->
        <!-- <script src="vendors/bootstrap/js/bootstrap.js"></script> -->

        <script src="assets/vendor/jquery-ui/js/jquery-ui-1.10.4.custom.js"></script>
        <script src="assets/vendor/jquery-ui-touch-punch/jquery.ui.touch-punch.js"></script>
        <script src="assets/vendor/jquery-appear/jquery.appear.js"></script>
        <script src="assets/vendor/bootstrap-multiselect/bootstrap-multiselect.js"></script>

        <!-- Theme Base, Components and Settings -->
        <!-- <script src="assets/javascripts/theme.js"></script> -->
        
        <!-- Theme Custom -->
        <!-- <script src="assets/javascripts/theme.custom.js"></script> -->
        
        <!-- Theme Initialization Files -->
        <!-- <script src="assets/javascripts/theme.init.js"></script> -->

        
        <!-- <script src="vendor/jquery/jquery.min.js"></script>
        <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script> -->

        <!-- Additional Scripts -->
        <!-- <script src="index_files/custom.js"></script>
        <script src="index_files/owl.js"></script>
        <script src="index_files/slick.js"></script>
        <script src="index_files/accordions.js"></script>
        <script src="index_files/aos.js"></script> -->

    <script>
        //Edit SL: more universal
        $(document).on('hidden.bs.modal', function (e) {
            $(e.target).removeData('bs.modal');
        });  
    </script>


<?php 
//print "ss".$pages;
if(empty($main_pg)){ ?>
  <script type="text/javascript">
    $(window).on('load', function() {
        $('#myModalInfo').modal('show');
    });
  </script>        
<?php } ?>  

</html>
