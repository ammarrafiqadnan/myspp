<!doctype html>
<html>
	<head>

		<!-- Basic -->
		<meta charset="UTF-8">

		<title>Sistem e-Penyelidikan</title>
		<meta name="keywords" content="e-Penyelidikan JAWI" />
		<meta name="description" content="e-Penyelidikan JAWI">

		<!-- Mobile Metas -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

		<!-- Web Fonts  -->
		<link href="vendors/font.css" rel="stylesheet" type="text/css">

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
        <style type="text/css" media="all">
		html { 
		  /*background: url(images/bg_jawi.jpg) no-repeat top center fixed; */
		  background: url(images/jawi_bg2.jpeg) no-repeat top center fixed; 
		  -webkit-background-size: cover;
		  -moz-background-size: cover;
		  -o-background-size: cover;
		  background-size: cover;
		  /*background-color: transparent;*/
		}
		</style>
		<!-- Head Libs -->
		<script src="salert/sweetalert2.min.js"></script>
        <script src="salert/sweetalert2.common.js"></script>
        <script language="javascript">
		function do_close(){
			$('#myModal').modal('hide');
		}
        function do_login1(){
            var reg = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
			var pengguna = $('#pengguna').val();
	        var katamasuk = $('#katamasuk').val();
	        var keselamatan = $('#keselamatan').val();
	        var NONO = $('#NONO').val();
            //alert("dd");
            if(pengguna.trim() == '' ){
                alert('Sila masukkan ID Pengguna anda.');
                $('#pengguna').focus(); return false;
            } else if(katamasuk.trim() == '' ){
                alert('Sila masukkan katalaluan anda.');
                $('#katamasuk').focus(); return false;
            } else if(keselamatan.trim() == '' ){
                alert('Sila masukkan maklumat kod keselamatan.');
                $('#keselamatan').focus(); return false;
            } else {
				if(keselamatan==NONO){
					$.ajax({
						url:'include/log_masuk_sql.php?pro=SAVE', //&datas='+datas,
						type:'POST',
						//dataType: 'json',
						beforeSend: function () {
						   //$('.btn-primary').attr("disabled","disabled");
							$('.dispmodal').css('opacity', '.5');
						},
						data: $("form").serialize(),
						//data: datas,
						success: function(data){
							console.log(data);
							//alert(data);
							if(data == 'OK'){
								//$("#myModal").modal();
								swal({
								  title: 'Berjaya',
								  text: 'Log Masuk Anda Berjaya',
								  type: 'success',
								  confirmButtonClass: "btn-success",
								  confirmButtonText: "Ok",
								  showConfirmButton: true,
								}).then(function () {
								  window.location.href = "index.php";
								});
							} else if(data=='XADA' || data=='ERR'){
								swal({
								  title: 'Amaran',
								  text: 'ID Pengguna atau Katalaluan anda salah. Sila cuba lagi.',
								  type: 'error',
								  confirmButtonClass: "btn-danger",
								  confirmButtonText: "Ok",
								  showConfirmButton: true,
								});
							} else if(data=='XSTAT'){
								swal({
								  title: 'Amaran',
								  text: 'Maklumat anda tiada dalam pendaftaran sistem.\nAdakah anda pengguna yang sah.',
								  type: 'error',
								  confirmButtonClass: "btn-danger",
								  confirmButtonText: "Ok",
								  showConfirmButton: true,
								});
							}
						}
					});
				} else {
					swal({
					  title: 'Amaran',
					  text: 'Kod keselamatan tidak sama.',
					  type: 'error',
					  confirmButtonClass: "btn-danger",
					  confirmButtonText: "Ok",
					  showConfirmButton: true,
					}).then(function () {
						document.frm.keselamatan.value='';
					  	$('#keselamatan').focus(); return false;
					});
				}
            }
        }
        function do_login(){
            var reg = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
			var pengguna = $('#pengguna').val();
	        //var katamasuk = $('#katamasuk').val();
            //alert("dd");
            if(pengguna.trim() == '' ){
                alert('Sila masukkan ID Pengguna anda.');
                $('#pengguna').focus(); //return false;
            /*} else if(katamasuk.trim() == '' ){
                alert('Sila masukkan katalaluan anda.');
                $('#katamasuk').focus(); return false;*/
            } else {
                $.ajax({
                    url:'include/log_masuk_sql.php?pro=CHK', //&datas='+datas,
                    type:'POST',
                    //dataType: 'json',
                    beforeSend: function () {
                       //$('.btn-primary').attr("disabled","disabled");
                        $('.dispmodal').css('opacity', '.5');
                    },
                    data: $("form").serialize(),
                    //data: datas,
                    success: function(data){
                        //console.log(data);
                        // alert(data);
                        if(data == 'OK'){
							$("#myModal").modal();
                        } else if(data=='XADA' || data=='ERR'){
                            swal({
                              title: 'Amaran',
                              text: 'ID Pengguna atau Katalaluan anda salah. Sila cuba lagi.',
                              type: 'error',
                              confirmButtonClass: "btn-danger",
                              confirmButtonText: "Ok",
                              showConfirmButton: true,
                            });
                        } else if(data=='XSTAT'){
                            swal({
                              title: 'Amaran',
                              text: 'Maklumat anda tiada dalam pendaftaran sistem.\nAdakah anda pengguna yang sah.',
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

        function do_login_lupa(){
            var reg = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
			var IDP = $('#IDP').val();
	        var email = $('#email').val();
            //alert("dd");
            if(IDP.trim() == '' ){
                alert('Sila masukkan ID Pengguna anda.');
                $('#IDP').focus(); return false;
            } else if(email.trim() == '' ){
                alert('Sila masukkan maklumat alamat emel anda.');
                $('#email').focus(); return false;
            } else {
					$.ajax({
                    url:'include/reset_password_sql.php', //&datas='+datas,
                    type:'POST',
                    //dataType: 'json',
					headers: {'x-my-custom-header': 'ptsi' },
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
							  $('#myModal_LP').modal('hide');
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
	<!--<body id="body" style="background-image:url(images/JPMA.jpg);background-repeat:no-repeat;background-size:cover;background-position:center;height:100%">-->
    <body style="background-color: transparent;">
        <form name="frm" action="" method="post">
		<!-- start: page -->
		
		<div class="form-group">
        	
            <div class="row" >
				<div class="col-lg-12">
				<div class="col-lg-2">&nbsp;</div>
                <div class="col-lg-4">
					<div class="form-group">
			        	<br>
			        	<div class="col-lg-12 hidden-md hidden-xs"><br></div>
			            <div class="col-lg-12 hidden-xs hidden-xm" align="center">
			                <img src="images/jata.png" width="150" height="117">
			                <img src="images/logo_jawi.png" width="130" height="130">
			                <br><h3 style="font-size:3em;font-family:'Times New Roman', Times, serif;color: #000;"><b>SISTEM e-PENYELIDIKAN JAWI</b></h3>
			            </div>
			            <div class="col-lg-12 hidden-md hidden-lg" align="center">
			                <img src="images/jata.png" width="70" height="67">
			                <img src="images/logo_jawi.png" width="70" height="70">
			                <br><h3 style="font-size:2em;font-family:'Times New Roman', Times, serif;color: #000;"><b>SISTEM e-PENYELIDIKAN JAWI</b></h3>
			            </div>
			        </div>		
                    <div class="panel-body" style="min-height:500px; background-color:rgba(255, 255, 255, 0.7);">
                            <br>
                            <div class="row" align="center" style="color:#000">
                            	<font style="font-size:26px;padding-left:20px;padding-right:20px">LOG MASUK</font>
							</div>
                            <br><br>
                            <div class="row" align="center">Sistem ini hanya boleh diakses oleh pengguna yang didaftarkan sahaja.
                            <br><br>
                            </div>
                            <div class="row">
                            <div class="col-lg-1"></div>
                            <div class="form-group mb-lg col-lg-10">
                                <label>ID Pengguna</label>
                                <div class="input-group input-group-icon">
                                    <input name="pengguna" id="pengguna" type="text" class="form-control input-lg" placeholder="ID Pengguna" maxlength="12" />
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
                                <div class="col-sm-6 text-left">
                                    <button type="button" id="logmasuk" class="btn btn-primary hidden-xs" onClick="do_login()" >Log Masuk</button>
                                    <button type="button" class="btn btn-primary btn-block btn-lg visible-xs mt-lg" onClick="do_login()">Log-Masuk</button>
                                </div>
                                <div class="col-sm-6 text-right">
                                    <!--<a href="lupa_katalaluan.php" class="pull-right">Lupa Kata Laluan?</a>-->
                                    <a data-toggle="modal" data-target="#myModal_LP" title="Lupa Kata Laluan Pengguna" class="fa" data-backdrop="static" 
                                    style="font-family:Arial, Helvetica, sans-serif;cursor:pointer">
                                    <label style="cursor:pointer">Lupa Kata laluan</label></a>
                                </div>
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
            <p class="text-center mt-md mb-md" style="color:#000"><br><br>
            &copy; Hakcipta 2022 - <?php print date("Y");?> <a href="https://www.jawi.gov.my" target="_blank">Jabatan Agama Islam Wilayah Persekutuan.</a>
            <?php 
			include 'connection/common.php';
			$rs = $conn->query("SELECT * FROM _ref_state WHERE is_deleted=0");
			if(!$rs->EOF){
				// print '<br>'.$_SERVER['HTTP_HOST'].'<br>';
			}
			?>
            </p>
                    </div>
                </div>
				</div>
            </div>        
            
        </div>
        
        <div class="bs-example">
            <div id="myModal" class="modal fade" role="dialog">
                <div class="modal-dialog modal-xs static">
                    <div class="modal-content">
                        <div class="panel-body">
                        	<?php
							function generateRandomString($length = 6) {
								$characters = '123456789abcdefghjkmnpqrstuvwxyzABCDEFGHJKMNPQRSTUVWXYZ';
								$charactersLength = strlen($characters);
								$randomString = '';
								for ($i = 0; $i < $length; $i++) {
									$randomString .= $characters[rand(0, $charactersLength - 1)];
								}
								return $randomString;
							}
							$uniq = substr(generateRandomString(),0,5);
							?>
							<div class="form-group mb-lg">
								<div align="center"><font style="font-size:18px"><b>SILA MASUKKAN KATA LALUAN PENGGUNA SISTEM</b></font></div>
							</div>

							<div class="form-group mb-lg">
								<hr>
							</div>
							<div class="form-group mb-lg">
                            	<div class="col-lg-4">
									<label class="pull-left"><b>Kata Laluan : </b></label>
								</div>
                                <div class="col-lg-8">
                                <div class="input-group input-group-icon">
									<input name="katamasuk" id="katamasuk" type="password" class="form-control input-lg" placeholder="Kata Laluan Pengguna" />
									<span class="input-group-addon">
										<span class="icon icon-lg">
											<i class="fa fa-lock"></i>
										</span>
									</span>
								</div>
                                </div>
							</div>
							<div class="form-group mb-lg">
                            	<div class="col-lg-4">
									<label class="pull-left"><b>Kod Keselamatan : </b></label>
								</div>
                                <div class="col-lg-4">
                                    <div class="input-group input-group-icon">
                                        <input name="keselamatan" id="keselamatan" type="text" class="form-control input-lg" placeholder="Kod Keselamatan Sistem" />
                                    </div>
                                </div>
                                <div class="col-lg-4">
									<label style="text-decoration:line-through;font-size:22px" id="NONO1"><b><?=$uniq;?></b></label>
                                	<input type="hidden" class="form-control input-lg" name="NONO" id="NONO" style="text-decoration:line-through;" value="<?=$uniq;?>" />
                                </div>
							</div>

							<div class="row">
                            	<!--<div class="col-sm-6"><div align="center"><a href="lupa_katalaluan.php" class="pull-right">Lupa Kata Laluan?</a></div></div>-->
								<div class="col-sm-12">
                                	<div class="col-sm-6" align="right">
									<button type="button" class="btn btn-primary hidden-xs" style="width:150px" onClick="do_login1()" >Log Masuk</button>
									<button type="button" class="btn btn-primary btn-block btn-lg visible-xs mt-lg" style="width:150px" onClick="do_login1()">Log-Masuk</button>
                                    </div>
                                	<div class="col-sm-6" align="left">
									<button type="button" class="btn btn-primary hidden-xs" style="width:150px" onClick="do_close()" >Batal</button>
									<button type="button" class="btn btn-primary btn-block btn-lg visible-xs mt-lg" style="width:150px" onClick="do_close()">Batal</button>                                    
                                    </div>
								</div>
							</div>

                        </div> 
                    </div>
                </div>
            </div>


            <div id="myModal_LP" class="modal fade" role="dialog">
                <div class="modal-dialog modal-xs static">
                    <div class="modal-content">
                        <div class="panel-body">
							<div class="form-group mb-lg">
								<div align="center"><font style="font-size:18px"><b>LUPA KATA LALUAN PENGGUNA</b></font></div>
							</div>

							<div class="form-group mb-lg">
								<hr>
							</div>
							<div class="form-group mb-lg">
                            	<div class="col-lg-3">
									<label class="pull-left"><b>ID Pengguna : </b></label>
								</div>
                                <div class="col-lg-9">
                                <div class="input-group input-group-icon">
									<input name="IDP" id="IDP" type="text" class="form-control input-lg" placeholder="ID Pengguna" maxlength="12" />
									<span class="input-group-addon">
										<span class="icon icon-lg">
											<i class="fa fa-user"></i>
										</span>
									</span>
								</div>
                                </div>
							</div>

							<div class="form-group mb-lg">
                            	<div class="col-lg-3">
									<label class="pull-left"><b>Alamat emel : </b></label>
								</div>
                                <div class="col-lg-9">
                                <div class="input-group input-group-icon">
									<input name="email" id="email" type="text" class="form-control input-lg" placeholder="Emel pengguna yang didaftarkan" />
									<span class="input-group-addon">
										<span class="icon icon-lg">
											<i class="fa fa-envelope-o"></i>
										</span>
									</span>
								</div>
                                </div>
							</div>

							<div class="row">
                            	<!--<div class="col-sm-6"><div align="center"><a href="lupa_katalaluan.php" class="pull-right">Lupa Kata Laluan?</a></div></div>-->
								<div class="col-sm-12">
                                	<div class="col-sm-6" align="right">
									<button type="button" class="btn btn-primary hidden-xs" style="width:150px" onClick="do_login_lupa()" >Hantar</button>
									<button type="button" class="btn btn-primary btn-block btn-lg visible-xs mt-lg" style="width:150px" onClick="do_login_lupa()">Hantar</button>
                                    </div>
                                	<div class="col-sm-6" align="left">
									<button type="button" class="btn btn-primary hidden-xs" style="width:150px" data-dismiss="modal">Batal</button>
									<button type="button" class="btn btn-primary btn-block btn-lg visible-xs mt-lg" style="width:150px" data-dismiss="modal">Batal</button>                                    
                                    </div>
								</div>
							</div>

                        </div> 
                    </div>
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
		<!--<script src="assets/javascripts/theme.init.js"></script>-->

		<!-- Bootstrap 3.3.7 -->
		<script>
		$('#pengguna').focus();

		// Get the input field
		var input = document.getElementById("pengguna");
		var katamasuk = document.getElementById("katamasuk");
		var keselamatan = document.getElementById("keselamatan");

		// Execute a function when the user releases a key on the keyboard
		input.addEventListener("keyup", function(event) {
		  // Number 13 is the "Enter" key on the keyboard
		  if (event.keyCode === 13) {
			// Cancel the default action, if needed
			event.preventDefault();
			// Trigger the button element with a click
			//do_login();
			document.getElementById("logmasuk").click();
		  }
		}); 

		// Execute a function when the user releases a key on the keyboard
		katamasuk.addEventListener("keyup", function(event) {
		  // Number 13 is the "Enter" key on the keyboard
		  if (event.keyCode === 13) {
			// Cancel the default action, if needed
			event.preventDefault();
			// Trigger the button element with a click
			do_login1();
			//document.getElementById("logmasuk").click();
		  }
		}); 
		// Execute a function when the user releases a key on the keyboard
		keselamatan.addEventListener("keyup", function(event) {
		  // Number 13 is the "Enter" key on the keyboard
		  if (event.keyCode === 13) {
			// Cancel the default action, if needed
			event.preventDefault();
			// Trigger the button element with a click
			do_login1();
			//document.getElementById("logmasuk").click();
		  }
		}); 
		</script>
	</body>
</html>