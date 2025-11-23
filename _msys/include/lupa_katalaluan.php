<!doctype html>
<html class="fixed">
	<head>

		<!-- Basic -->
		<meta charset="UTF-8">

		<title>Dashboard PTSI</title>
		<meta name="keywords" content="MyMonitoring PIKAP DASHBOARD JAKIM" />
		<meta name="description" content="MyMonitoring PIKAP DASHBOARD JAKIM">

		<!-- Mobile Metas -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

		<!-- Web Fonts  -->
		<link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css">

		<!-- Vendor CSS -->
		<link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.css" />
		<link rel="stylesheet" href="assets/vendor/font-awesome/css/font-awesome.css" />

		<!-- Theme CSS -->
		<link rel="stylesheet" href="assets/stylesheets/theme.css" />

		<!-- Skin CSS -->
		<link rel="stylesheet" href="assets/stylesheets/skins/default.css" />

		<!-- Theme Custom CSS -->
        <link rel="shortcut icon" type="image/png" href="images/jata.png"/>
		<link href="salert/sweetalert2.css" rel="stylesheet">
		<!-- Head Libs -->
		<script src="salert/sweetalert2.min.js"></script>
        <script src="salert/sweetalert2.common.js"></script>
        <script language="javascript">
		function ValidateEmail(inputText){
			var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
			if(inputText.value.match(mailformat)){
				document.frm.emel.focus();
				return true;
			} else {
				alert("You have entered an invalid email address!");
				document.frm.emel.focus();
				return false;
			}
		}
        function do_login(){
            var reg = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
            var pengguna = $('#pengguna').val();
            var emel = $('#emel').val();
            //alert("dd");
            if(pengguna.trim() == '' ){
                alert('Sila masukkan ID Pengguna anda.');
                $('#pengguna').focus(); return false;
            } else if(emel.trim() == '' ){
                alert('Sila masukkan emel yang telah didaftarkan anda.');
                $('#emel').focus(); return false;
            } else {
                $.ajax({
                    url:'include/reset_password_sql.php', //&datas='+datas,
                    type:'POST',
                    //dataType: 'json',
					headers: {'x-my-custom-header': 'pikap' },
                    beforeSend: function () {
                        //$('.btn-primary').attr("disabled","disabled");
                        $('.dispmodal').css('opacity', '.5');
                    },
                    data: $("form").serialize(),
                    //data: datas,
                    success: function(data){
                        //console.log(data);
                        //alert(data);
                        if(data=='SEND'){
								swal({
								  title: 'Berjaya',
								  text: 'Sila semak emel anda. Kata laluan baru telah dihantar.',
								  type: 'success',
								  confirmButtonClass: "btn-success",
								  confirmButtonText: "Ok",
								  showConfirmButton: true,
								}).then(function () {
								  window.location.href = "index.php";
								});
                        } else if(data=='ERR_SEND'){
                            swal({
                              title: 'Amaran',
                              text: 'ID Pengguna atau Emel anda salah. Sila cuba lagi.',
                              type: 'error',
                              confirmButtonClass: "btn-danger",
                              confirmButtonText: "Ok",
                              showConfirmButton: true,
                            });
                        }
                    }
                });
            }
        }
        </script>
        <!-- jQuery 3 -->
        
	</head>
	<body style="background-image:url(images/JPMA.jpg);background-repeat:no-repeat;background-size:cover;background-position:center">
        <form name="frm" action="" method="post">
		<!-- start: page -->
		<div class="form-group">
        <br><br>
        <div class="col-lg-12 hidden-md hidden-xs"><br><br></div>
            <div class="col-lg-12" align="center">
                <img src="images/jata.png" style="width:100;height:100px">
            </div>
        </div>		
		
		<div class="form-group">
        	<br><br><br>
            <div class="row" >
                <div class="col-lg-1">&nbsp;</div>
                <div class="col-lg-5 hidden-xs hidden-sm">
                    <div class="panel-body" style="background-color:rgba(0, 0, 0, 0.68);min-height:500px">
                            <br><br>
                            <div class="row" align="center" style="color:#FFF">
                            	<font style="font-size:26px;padding-left:20px;padding-right:20px">SISTEM DASHBOARD PELAN TINDAKAN SOSIAL ISLAM (PTSI)</font>
							</div>
                            <br><br>
                            <div class="row" style="color:#FFF">
                            <p style="font-size:16px;padding-left:20px;padding-right:20px;text-align:justify">
                            	Mesyuarat Majlis Kebangsaan Bagi Hal Ehwal Ugama Islam Malaysia (MKI) Kali Ke-66 pada 13 Jun 2019 yang dipengerusikan oleh YAB Perdana Menteri telah bersetuju menerima cadangan mengenai inisiatif menangani gejala sosial dalam kalangan masyarakat Islam iaitu Pelan Tindakan Sosial Islam (PTSI). Mesyuarat turut bersetuju menubuhkan dua jawatankuasa iaitu Jawatankuasa Pemandu Pelan Tindakan Sosial Islam dan Jawatankuasa Pelaksana Pelan Tindakan Sosial Islam yang berfungsi dalam merancang, menyelaras, melaksana dan memantau pelaksanaan pelan tindakan ini. Salah satu fungsi atau bidang kuasa yang digariskan adalah mewujudkan mekanisme pelaksanaan,  penyelarasan dan pemantauan ke atas pelaksanaan pelan tindakan ini.
                            </p>
                            </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="panel-body" style="min-height:500px; background-color:rgba(255, 255, 255, 0.7);">
                            <br><br>
                            <div class="row" align="center" style="color:#000">
                            	<font style="font-size:26px;padding-left:20px;padding-right:20px">LUPA KATA LALUAN</font>
							</div>
                            <br><br>
                            <div class="row" align="center"></div>
                            <div class="row">
                            <div class="col-lg-1"></div>
                            <div class="form-group mb-lg col-lg-10">
                                <label><b>ID Pengguna</b></label>
                                <div class="input-group input-group-icon">
                                    <input name="pengguna" id="pengguna" type="text" class="form-control input-lg" placeholder="ID Pengguna" />
                                    <span class="input-group-addon">
                                        <span class="icon icon-lg">
                                            <i class="fa fa-user"></i>
                                        </span>
                                    </span>
                                </div>
                            </div>
                            </div>
							
							<div class="row">
                            <div class="col-lg-1"></div>
							<div class="form-group mb-lg col-lg-10">
                                <label><b>Emel Pengguna</b></label>
                                <div class="input-group input-group-icon">
                                    <input name="emel" id="emel" type="text" class="form-control input-lg" placeholder="Emel yang didaftarkan" autocomplete="off" 
                                    onChange="ValidateEmail(document.frm.emel)" required/>
                                    <span class="input-group-addon">
                                        <span class="icon icon-lg">
                                            <i class="fa fa-envelope-o"></i>
                                        </span>
                                    </span>
                                </div>
                            </div>
                            </div>

                            <div class="row">
                            <div class="col-lg-1"></div>
                            <div class="form-group mb-lg col-lg-10">
                                <div class="col-sm-6 text-left">
                                	<input type="hidden" name="token" id="token" value="<?=$token;?>" />
									<button type="button" class="btn btn-primary hidden-xs" onClick="do_login()">Reset Kata Laluan</button>
									<button type="button" class="btn btn-primary btn-block btn-lg visible-xs mt-lg" onClick="do_login()">Reset Kata Laluan</button>
								</div>
								<div class="col-sm-6 text-right"><a href="index.php" class="pull-right">Log Masuk</a></div>
                            </div>
							</div>

                            <div class="row">
                            <div class="col-lg-1"></div>
                            <div class="form-group mb-lg col-lg-10" align="center">
                            <span class="mt-lg mb-lg line-thru text-center text-uppercase">
                            </span>
							<br><br>
                            <p class="text-center">ID pengguna dan kata laluan anda adalah rahsia.<br>Jangan kongsikan maklumat anda.</p>
							</div>
                            </div>
                    </div>
                </div>
            </div>        
            <p class="text-center text-muted mt-md mb-md"><br><br>
            &copy; Hakcipta 2019 - <a href="http://www.islam.gov.my" target="_blank">Jabatan Kemajuan Islam Malaysia.</a><br><br></p>
        </div>
        
        
            </div>
        </div>
        </form>
		<!-- end: page -->

		<!-- Vendor -->
		<script src="assets/vendor/jquery/jquery.js"></script>
		<script src="assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js"></script>
		<script src="assets/vendor/bootstrap/js/bootstrap.js"></script>
		<script src="assets/vendor/nanoscroller/nanoscroller.js"></script>
		<script src="assets/vendor/jquery-placeholder/jquery.placeholder.js"></script>
		
		<!-- Theme Base, Components and Settings -->
		<script src="assets/javascripts/theme.js"></script>
		
		<!-- Theme Custom -->
		<script src="assets/javascripts/theme.custom.js"></script>
		
		<!-- Theme Initialization Files -->
		<script src="assets/javascripts/theme.init.js"></script>

		<!-- Bootstrap 3.3.7 -->
	</body>
</html>