<?php @session_start(); ?>
<?php
include 'connection/common_log.php';
// Declare an associative array
$arr = array( "bg.webp", "bgfaq.webp", "bghubungi.jpg", "bgakta.png" );
// Use shuffle function to randomly assign numeric
// key to all elements of array.
shuffle($arr);
// Display the first shuffle element of array
$bg_img = $arr[0];

$new = time();
$gt = $new - $_SESSION['dt_visit'];
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
  $sql = "INSERT INTO `tbl_capaian`(`datetimes`, `ip`) VALUES('{$tarikh}', '{$ip}')";
  $conn->execute($sql);
  //echo "2".$sql."<br>";
}

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistem eAMH</title>
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
            background-image: url('assets/<?=$bg_img;?>');
            background-position: center;
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
    </style>
    
    <link href="index_files/fontawesome.css" rel="stylesheet">
    <!-- <link href="index_files/style.css" rel="stylesheet"> -->
    <link href="index_files/owl.css" rel="stylesheet">
    <link rel="stylesheet" href="salert/sweetalert2.css">
    <script src="salert/sweetalert2.min.js"></script>
    <script src="salert/sweetalert2.common.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

</head>
<body>
<form name="veterina" id="veterina" method="post" action="" enctype="multipart/form-data" autocomplete="off">
    
    <!-- navbar -->
    <?php 
    $pages=isset($_REQUEST["pages"])?$_REQUEST["pages"]:"";
    include 'index_navi.php'; ?>

    <!-- Intro -->
    <div style="min-height: 630px;">
    <?php 

    if(empty($pages)){ 
        include 'index_main1.php';
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

</form>
</body>

<footer class="footercolor text-white">
    <div class="container-xxl py-1 text-center">
        <span style="font-size: 0.8em;">©2022 oleh Jabatan Perkhidmatan Veterinar.Semua hakcipta terpelihara.</span><br>
        <span style="font-size: 0.8em;">
            Penafian :  DVS tidak bertanggungjawab atas kehilangan atau kerosakan disebabkan penggunaan informasi yang diperolehi daripada portal ini dan penggunaan Google Translate untuk Bahasa Inggeris dan bahasa asing adalah tidak tepat.
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

</html>
