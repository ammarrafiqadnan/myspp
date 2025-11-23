<!doctype html>
<?php
/*
$sys = $conn->query("SELECT * FROM tbl_setup WHERE setup_id=1");
$nama_sistem=$sys->fields['setup_title'];
$nama_dashboard=$sys->fields['setup_name'];
if(empty($nama_sistem)){ $nama_sistem='Nama Sistem'; }
$tkh_mula = $sys->fields['setup_startdt'];
$tkh_tamat = $sys->fields['setup_enddt'];
$PTSI_MULA = $sys->fields['setupr_startdt'];
$PTSI_TAMAT = $sys->fields['setup_enddt'];
*/
$CURR_DT = date("Y-m-d");

//$conn->debug=true;
// $rsDT = $conn->query("SELECT * FROM tbl_setup WHERE '{$CURR_DT}' BETWEEN mymonitor_startdt AND mymonitor_enddt");
// if(!$rsDT->EOF){ $_SESSION['SESS_UPDATE']='UPDATE'; }
// else { $_SESSION['SESS_UPDATE']=''; }
// $conn->debug=false;
//print $_SESSION['SESS_UPDATE']; exit;
?>
<html class="fixed">
	<head>
		<!-- Basic -->
		<meta charset="UTF-8">
		<title>Sistem mySPP</title>
		<meta name="keywords" content="mySPP" />
		<meta name="description" content="mySPP">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta http-equiv="Content-Security-Policy" content="connect-src 'self'">
        <meta http-equiv="X-Content-Type" content="nosniff">
        <meta http-equiv="Feature-Policy" content="unsized-media 'none'; geolocation 'self'">

		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

		<!-- Web Fonts  -->
		<!--<link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css">-->
		<link href="../vendors/font.css" rel="stylesheet" type="text/css">

		<!-- Vendor CSS -->
		<link rel="stylesheet" href="../assets/vendor/bootstrap/css/bootstrap.css" />
		<link rel="stylesheet" href="../assets/vendor/font-awesome/css/font-awesome.css" />
		<link rel="stylesheet" href="../assets/vendor/magnific-popup/magnific-popup.css" />
		<link rel="stylesheet" href="../assets/vendor/bootstrap-datepicker/css/datepicker3.css" />

		<!-- Specific Page Vendor CSS -->
		<link rel="stylesheet" href="../assets/vendor/jquery-ui/css/ui-lightness/jquery-ui-1.10.4.custom.css" />
		<link rel="stylesheet" href="../assets/vendor/bootstrap-multiselect/bootstrap-multiselect.css" />
		<!--<link rel="stylesheet" href="assets/vendor/morris/morris.css" />-->

		<!-- Theme CSS -->
		<link rel="stylesheet" href="../assets/stylesheets/theme.css" />
        <!--<link rel="stylesheet" href="assets/stylesheets/theme1.css" />-->

		<!-- Skin CSS -->
		<link rel="stylesheet" href="../assets/stylesheets/skins/default.css" />

		<!-- Theme Custom CSS -->
		<link rel="stylesheet" href="../assets/stylesheets/theme-custom.css">
		<link type="text/css" rel="stylesheet" href="cal/dhtmlgoodies_calendar.css" media="screen">

		<!-- Theme Custom CSS -->
		<link rel="stylesheet" href="../assets/stylesheets/theme-custom.css">
		<link rel="stylesheet" href="../salert/sweetalert2.css">
		<link rel="shortcut icon" type="image/png" href="../images/jata.png"/>

        <!-- Vendor -->
        <script src="../assets/vendor/jquery/jquery.js"></script>
        <script src="../assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js"></script>
        <script src="../assets/vendor/bootstrap/js/bootstrap.js"></script>
		<!-- Head Libs -->
		<script src="../assets/vendor/modernizr/modernizr.js"></script>
		<script src="../salert/sweetalert2.min.js"></script>
		<script src="../salert/sweetalert2.common.js"></script>
		<script src="../assets/proses.js"></script>

		<link href="../assets/vendor/quill/quill.snow.css" rel="stylesheet">

		<link href="../vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
		<link href="../vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
		<link href="../vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
		<link href="../vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">
		<SCRIPT type="text/javascript" src="cal/dhtmlgoodies_calendar.js"></script>


<script language="javascript">
function do_pages(url){
	document.myspp.location = url;
	document.myspp.target = '_self';
	document.myspp.submit();
}	
function alert_msg(msg){
	swal({
		title: 'Makluman',
		text: msg,
		type: 'warning',
		showCancelButton: false,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Ok',
		reverseButtons: true
	});		
}

function alert_msg_html(msg){

	swal({
		title: 'Makluman',
		type: 'info',
		html: '<pre style="color:red;text-align:left;">' + msg + '</pre>',
		showCancelButton: false,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Ok',
		reverseButtons: true
	});		
}

function display_msg(data){
	if(data=='OK'){
        // alert(window.location);
		swal({
		  title: 'Berjaya',
		  text: 'Maklumat telah berjaya disimpan',
		  type: 'success',
		  confirmButtonClass: "btn-success",
		  confirmButtonText: "Ok",
		  showConfirmButton: true,
		}).then(function () {
			reload = window.location; 
			window.location = reload;
		});
	} else if(data=='ERR'){
		swal({
		  title: 'Amaran',
		  text: 'Terdapat ralat sistem.\nMaklumat anda tidak berjaya dikemaskini.',
		  type: 'error',
		  confirmButtonClass: "btn-warning",
		  confirmButtonText: "Ok",
		  showConfirmButton: true,
		});
	}	
}

function display_msg_stay(data){
	if(data=='OK'){
		swal({
		  title: 'Berjaya',
		  text: 'Maklumat telah berjaya disimpan',
		  type: 'success',
		  confirmButtonClass: "btn-success",
		  confirmButtonText: "Ok",
		  showConfirmButton: true,
		});
	} else if(data=='ERR'){
		swal({
		  title: 'Amaran',
		  text: 'Terdapat ralat sistem.\nMaklumat anda tidak berjaya dikemaskini.',
		  type: 'error',
		  confirmButtonClass: "btn-warning",
		  confirmButtonText: "Ok",
		  showConfirmButton: true,
		});
	}	
}

function do_hapus(url){
	swal({
		title: 'Adakah anda pasti untuk menghapuskan data ini?',
		//text: "You won't be able to revert this!",
		type: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Ya, Teruskan',
		cancelButtonText: 'Tidak, Batal!',
		reverseButtons: true
	}).then(function(e) {
		//e.preventDefault();
		$.ajax({
            url:url, //'pentadbiran/pentadbiran_sql.php?frm=pengguna&pro=SAVE',
			type:'POST',
            //dataType: 'json',
            beforeSend: function () {
                //$('.btn-primary').attr("disabled","disabled");
                //$('.modal-body').css('opacity', '.5');
            },
			data: $("form").serialize(),
			//data: datas,
			success: function(data){
				console.log(data);
				// alert(data);
				if(data=='OK'){
					swal({
					  title: 'Berjaya',
					  text: 'Maklumat telah berjaya dihapuskan',
					  type: 'success',
					  confirmButtonClass: "btn-success",
					  confirmButtonText: "Ok",
					  showConfirmButton: true,
					}).then(function () {
						reload = window.location; 
						window.location = reload;
					});
				} else if(data=='ERR'){
					swal({
					  title: 'Amaran',
					  text: 'Terdapat ralat sistem.\nMaklumat anda tidak berjaya dihapuskan.',
					  type: 'error',
					  confirmButtonClass: "btn-warning",
					  confirmButtonText: "Ok",
					  showConfirmButton: true,
					});
				}
				//window.location.reload();
			},
			//data: datas
        });
	});		
}

function do_hapus_url(url){
	swal({
		title: 'Adakah anda pasti untuk menghapuskan data ini?',
		//text: "You won't be able to revert this!",
		type: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Ya, Teruskan',
		cancelButtonText: 'Tidak, Batal!',
		reverseButtons: true
	}).then(function(e) {
		//e.preventDefault();
		$.ajax({
            url:url, //'pentadbiran/pentadbiran_sql.php?frm=pengguna&pro=SAVE',
			type:'POST',
            //dataType: 'json',
            beforeSend: function () {
                //$('.btn-primary').attr("disabled","disabled");
                //$('.modal-body').css('opacity', '.5');
            },
			data: $("form").serialize(),
			//data: datas,
			success: function(data){
				console.log(data);
				// alert(data);
				var nameArr = data.split(';');
				if(nameArr[0]=='OK'){
					swal({
					  title: 'Berjaya',
					  text: 'Maklumat telah berjaya dihapuskan',
					  type: 'success',
					  confirmButtonClass: "btn-success",
					  confirmButtonText: "Ok",
					  showConfirmButton: true,
					}).then(function () {
						window.location.href=nameArr[1];
					});
				} else if(data=='ERR'){
					swal({
					  title: 'Amaran',
					  text: 'Terdapat ralat sistem.\nMaklumat anda tidak berjaya dihapuskan.',
					  type: 'error',
					  confirmButtonClass: "btn-warning",
					  confirmButtonText: "Ok",
					  showConfirmButton: true,
					});
				}
				//window.location.reload();
			},
			//data: datas
        });
	});		
}

</script>

</head>

<?php
/*	
$rsGambar = $conn->query("SELECT * FROM $schema2.`calon_gambar` WHERE `id_pemohon`=".tosql($_SESSION['SESS_UID']));
    if(!$rsGambar->EOF){
	$gambar = "/upload/".$_SESSION['SESS_UID']."/".$rsGambar->fields['gambar'];
   } else {
    	$gambar = '../images/person.jpg';
    }
*/


$rsGambar = $conn->query("SELECT * FROM $schema2.`calon_gambar` WHERE `id_pemohon`=".tosql($_SESSION['SESS_UID']));
if(!$rsGambar->EOF){
       	$sijil_pic1 = "/var/www/upload/".$_SESSION['SESS_UID']."/".$rsGambar->fields['gambar'];
} else {
       	$sijil_pic1 = '../images/person.jpg';
}

if (file_exists($sijil_pic1)){
	$b64image = base64_encode(file_get_contents($sijil_pic1));
	$gambar = "data:image/png;base64,$b64image";
}

?>

	<body style="background-image:url(../images/bgspp.png)">
		<form name="myspp" method="post" action="" enctype="multipart/form-data" autocomplete="off">
		<section class="body">
			<!-- start: header -->
			<header class="header" style="background-color: red;">
				<div class="logo-container">
					<a href="index.php" class="logo">
						<img class="visible-lg" src="../upload_doc/logo_spp.png" alt="MySPP" height="40px" width="400px" /> 
						<img class="visible-xs" src="../upload_doc/logo_spp.png" alt="MySPP" height="60px" width="280px" />

						<!-- <img src="../images/jata.png" height="35" alt="mySPP" />  -->
						<!--<img src="../upload_doc/logo_spp.png" alt="MySPP" height="40px" width="400px" class="visible-lg visible-md"/>
						<img src="../upload_doc/logo_spp_small.png" alt="MySPP" height="40px" class="visible-xs"/> -->
						<div class="visible-xs" style="font-size:20px;margin-top:-50px;padding-left:100px;color:#000"></div>
					</a> 
					<div class="visible-xs toggle-sidebar-left" data-toggle-class="sidebar-left-opened" data-target="html" data-fire-event="sidebar-left-opened">
						<i class="fa fa-bars" aria-label="Toggle sidebar" style="cursor:pointer"></i>
					</div>
                    <div id="userbox" class="userbox1 visible-xs">
                    	<figure class="profile-picture">
				<img src="<?=$gambar;?>" alt="<?=$_SESSION['SESS_UNAME'];?>" class="img-circle" data-lock-picture="../images/person.jpg" />
			</figure>
                        <a href="#" data-toggle="dropdown"></a>
						<div class="dropdown-menu" style="margin-left:-50px;width:250px">
							<div style="padding-left:10px"><br>
							<span class="name"><b><?=$_SESSION['SESS_UNAME'];?></b></span>
							<span class="role"><?=$_SESSION['SESS_UIC'];?></span>
							</div>
							<ul class="list-unstyled">
								<li class="divider"></li>
								<!--<li>
									<a role="menuitem" tabindex="-1" href="utiliti/profile_form.php?id=<?=$_SESSION['SESS_UID'];?>" 
										data-toggle="modal" data-target="#myModal"><i class="fa fa-user"></i> Profile Saya</a>
								</li>
								<li>
									<a role="menuitem" tabindex="-1" href="utiliti/userpwd_form.php?id=<?=$_SESSION['SESS_UID'];?>" 
										data-toggle="modal" data-target="#myModal"><i class="fa fa-key"></i> Tukar Kata Laluan</a>
								</li>-->
								<li>
									<a role="menuitem" tabindex="-1" href="userpwd_form.php?id=<?=$_SESSION['SESS_UIC'];?>" 
										data-toggle="modal" data-target="#myModal"><i class="fa fa-key"></i> Tukar Kata Laluan</a>
								</li>
								<!--<li>
									<a role="menuitem" tabindex="-1" href="#" data-lock-screen="true"><i class="fa fa-lock"></i> Kunci Paparan Skrin</a>
								</li>-->
								<li title="Sila klik disini untuk log keluar daripada sistem">
									<a role="menuitem" tabindex="-1" href="logout.php"><i class="fa fa-power-off"></i> Log Keluar</a>
								</li>
							</ul>
						</div>
					</div>
				</div>

				<!-- start: search & user box -->
				<div class="header-right visible-lg">
					<div id="userbox" class="userbox  visible-lg">

						<a href="#" data-toggle="dropdown">
							<figure class="profile-picture">
								<img src="<?=$gambar;?>" alt="<?=$_SESSION['SESS_UNAME'];?>" width="45px" height="45px" class="img-circle" data-lock-picture="images/person.jpg" />
							</figure>
							<div class="profile-info" data-lock-name="wwwww" data-lock-email="<?=$_SESSION['SESS_EMEL'];?>">
								<span class="name"><b><?=$_SESSION['SESS_UNAME'];?></b></span>
								<span class="name"><b><?=$_SESSION['SESS_UIC'];?></b></span>
							</div>
							<i class="fa custom-caret"></i>
						</a>

						<div class="dropdown-menu">
							<ul class="list-unstyled">
								<li class="divider"></li>
								<!--<li>
									<a role="menuitem" tabindex="-1" href="utiliti/profile_form.php?id=<?=$_SESSION['SESS_UID'];?>" 
										data-toggle="modal" data-target="#myModal"><i class="fa fa-user"></i> Profile Saya</a>
								</li>
								<li>
									<a role="menuitem" tabindex="-1" href="utiliti/userpwd_form.php?id=<?=$_SESSION['SESS_UID'];?>" 
										data-toggle="modal" data-target="#myModal"><i class="fa fa-key"></i> Tukar Kata Laluan</a>
								</li>-->
								<li>
									<a role="menuitem" tabindex="-1" href="userpwd_form.php?id=<?=$_SESSION['SESS_UIC'];?>" 
										data-toggle="modal" data-target="#myModal"><i class="fa fa-key"></i> Tukar Kata Laluan</a>
								</li>

								<!--<li>
									<a role="menuitem" tabindex="-1" href="#" data-lock-screen="true"><i class="fa fa-lock"></i> Kunci Paparan Skrin</a>
								</li>-->
								<li title="Sila klik disini untuk log keluar daripada sistem">
									<a role="menuitem" tabindex="-1" href="logout.php"><i class="fa fa-power-off"></i> Log Keluar</a>
								</li>
							</ul>
						</div>
					</div>
				</div>
                <div class="header-right1 visible-xs">
                </div>
				<!-- end: search & user box -->
			</header>
			<!-- end: header -->
					
					