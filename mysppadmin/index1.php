<?php @session_start(); ?>
<?php

include '../connection/common_log.php';
date_default_timezone_set('UTC');
date_default_timezone_set('Asia/Kuala_Lumpur'); 
error_reporting (E_ALL ^ E_NOTICE);
ini_set("display_errors", 1);

// $pro=isset($_GET["pro"])?$_GET["pro"]:"";
// $pengguna=isset($_REQUEST["userid"])?$_REQUEST["userid"]:"";
// $katamasuk=isset($_REQUEST["katalaluan"])?$_REQUEST["katalaluan"]:"";
// $token=isset($_REQUEST["token"])?$_REQUEST["token"]:"";
// $pass = md5($katamasuk);
// $tarikh = date("Y-m-d H:i:s");

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Log Masuk Admin</title>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
    
    <script src="js/fd82e21e86.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/custom.css">
	<!--<link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.css" />-->

    <style>
        section {
            padding : 40px 0px; 
        }
        
        /*body {
            background-image: url('assets/bgadmin.webp');
            background-position: center;
            background-size: 100%;
        }*/
        .big-banner {
            background-image: url('assets/bgadmin.webp');
            background-position: center;
            background-size: cover;
        }
        
        .input-icons i {
            position: absolute;
            opacity: 0.8;
        }
        
        .input-icons {
            width: 100%;
            margin-bottom: 10px;
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

        /* .bg-login {
            text-align: center;
            background-image: url("images/bg-login.jpg");
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
        } */

        .bg-login {
            color: #fff;
            background-attachment: scroll;
            background: #1c1e21 url("../upload_doc/bg-spp.jpg");
            background-position: center center;
            background-repeat: none;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            background-size: cover;
            -o-background-size: cover;
            min-height:100%;

        }
    </style>
<script type="text/javascript">
  function do_log(){
    var reg = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
    var userid = $('#userid').val();
    var katalaluan = $('#katalaluan').val();
    if(userid.trim() == '' ){
        alert('Sila masukkan ID Pengguna anda.');
        $('#userid').focus(); //return false;
    } else if(katalaluan.trim() == '' ){
        alert('Sila masukkan kata laluan anda.');
        $('#katalaluan').focus(); return false;
    } else {
        $.ajax({
            url:'../_msys/include/log_masuk_sql.php?pro=CHK', //&datas='+datas,
            type:'POST',
            //dataType: 'json',
            beforeSend: function () {
               //$('.btn-primary').attr("disabled","disabled");
                $('.dispmodal').css('opacity', '.5');
            },
            data: $("form").serialize(),
            //data: datas,
            success: function(data){
                // alert(data);
                // alert(data);
                if(data == 'OK'){
                  // $("#myModal").modal();
                    swal({
                      title: 'Berjaya',
                      text: 'Berjaya log masuk.',
                      type: 'success',
                      //confirmButtonClass: "btn-success",
                      //confirmButtonText: "Ok",
                      //showConfirmButton: true,
                    }).then(function () {
                      window.location.replace("../_msys/index.php");  
                      // reload = window.location; 
                      // window.location = reload;
                    });
                    // swal({
                    //   title: 'Berjaya',
                    //   text: 'Berjaya log masuk.',
                    //   type: 'success',
                    //   confirmButtonClass: "btn-success",
                    //   confirmButtonText: "Ok",
                    //   showConfirmButton: true,
                    // }).then(function () {
                    //     window.location.replace(url);  
                    // });
                } else if(data=='XADA'){
                    swal({
                      title: 'Amaran',
                      text: 'ID Pengguna atau Katalaluan anda salah. Sila cuba lagi.',
                      type: 'error',
                      confirmButtonClass: "btn-danger",
                      confirmButtonText: "Ok",
                      showConfirmButton: true,
                    });
		} else if(data=='ERR'){
                    swal({
			title: 'Amaran',
			text: 'Terdapat ralat sistem.\nMaklumat anda tidak berjaya diproses.',
			type: 'error',
			confirmButtonClass: "btn-warning",
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

function do_lupa(URL){
    var reg = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
    var emel = $('#emel').val();
    var ICNo = $('#ICNo').val();

    var msg = '';
    //alert("dd");
    if(emel.trim() == '' ){
        msg = msg+'- Sila masukkan alamat e-mel anda.';
        $("#emel").css("border-color","#f00");
    } 
    if(ICNo.trim() == '' ){
        msg = msg+'\n- Sila masukkan maklumat No. Kad Pengenalan anda.';
        $("#ICNo").css("border-color","#f00");
    }

    if(msg.trim() !=''){ 
        alert_msg_html(msg);
    } else { 
        $.ajax({
            url:URL,
            type:'POST',
            //dataType: 'json',
            beforeSend: function () {
                $('.btn-primary').attr("disabled","disabled");
                $('.modal-body').css('opacity', '.5');
            },
            data: $("form").serialize(),
            //data: datas,
            success: function(data){
                console.log(data);
                // alert(data);
                if(data=='OK'){
                    swal({
                      title: 'Berjaya',
                      text: 'Permohonan lupa kata laluan berjaya. Sila semak e-mel anda untuk mendapatkan katalaluan baru',
                      type: 'success',
                      confirmButtonClass: "btn-success",
                      confirmButtonText: "Ok",
                      showConfirmButton: true,
                    }).then(function () {
                        reload = window.location; 
                        window.location = reload;
                        // window.href = "index.php";
                    });
                } else if(data=='ERR'){
                    swal({
                      title: 'Amaran',
                      text: 'Terdapat ralat sistem.\nMaklumat lupa kata laluan tidak berjaya diproses.',
                      type: 'error',
                      confirmButtonClass: "btn-warning",
                      confirmButtonText: "Ok",
                      showConfirmButton: true,
                    });
                }
            }
            //data: datas
        });
    }
}



</script>
<link rel="stylesheet" href="../salert/sweetalert2.css">
<script src="../salert/sweetalert2.min.js"></script>
<script src="../salert/sweetalert2.common.js"></script>

</head>
<body>
<form name="myspp" id="myspp" class="bg-login" method="post" action="" enctype="multipart/form-data" autocomplete="off">
    
    <!-- navbar -->
    <?php include '../index_navi.php'; ?>
    
    
    <section id="intro">
	<div style="background-color: #fff; padding-top: 10px;">
            <?php
                //$conn->debug=true;
                $now = date('Y-m-d', strtotime(now()));
                $sql = "SELECT * FROM $schema2.`hebahan_makluman` WHERE is_deleted=0 AND jenis=2 AND tarikh_mula <=" .tosql($now)." AND tarikh_tamat >=".tosql($now); 
                $hebahan = $conn->query($sql);
            ?>
            <marquee class="marq" behavior="" direction="left" onmouseover="this.stop();" onmouseout="this.start();">
                <?php while(!$hebahan->EOF){
                    print "<a href='../_msys/pengurusan/hebahan_maklumat_form.php?id=".$hebahan->fields['kod']."&jenis=view' data-toggle='modal' data-target='#myModal-xl'><i class='fa fa-bullhorn' aria-hidden='true'></i> ".$hebahan->fields['tajuk']."</a>&nbsp;";
                $hebahan->movenext(); } ?>
            </marquee>
        </div>
        <div class="container-xl p-0">
            <div class="row align-items-center justify-content-center p-0">
                <div class="col-lg-8 col-md-9    p-5 mt-5">
                    <!-- Log masuk -->
                    <div class="p-5 pb-2 my-2 mx-auto container shadow-lg border-dark rounded" style="background-color: rgba(0, 0, 0, 0.58);">
                        <h2 class="text-center" style="color: white">Log Masuk</h2>
                            
                            <div class="mb-3 input-icons">
                                <label for="idPengguna" class="form-label" style="color: white">ID Pengguna</label><br>
                                <i class="fa-solid fa-circle-user loginIcon"></i>
                                <input type="text" class="form-control input-field" id="userid" name="userid">
                            </div>
                            
                            <div class="mb-3 input-icons">
                                <label for="katalaluan" class="form-label" style="color: white">Kata Laluan</label><br>
                                <i class="fa-solid fa-lock loginIcon"></i>
                                <input type="password" class="form-control input-field" id="katalaluan" name="katalaluan">
                            </div>

                            <?php 
                                $url = "index.php?data=". base64_encode('../_msys/index;;;;;'); 
                                // $url = "index.php?data=". base64_encode('pemohon/senarai_pemohon_draf;Senarai Pemohon;Senarai Pemohon Draf;ALL;;;');
                            ?>

                            
                            
                            <div class="text-center">
                                <button type="button" class="btn btn-primary align-center" onclick="do_log()">Log Masuk</button>
                                <button type="button" class="btn btn-info align-center" onclick="open_lupa('#modalLupa')">Lupa Kata Laluan?</button>
                            </div>
                        <!-- <div class="row align-items-center justify-content-center mx-auto p-0 mt-2">
                            <div class="col-auto text-center mx-1 p-0">
                            <a href="index.php?pages=lupapassadm" class="card-subtitle link-info" style="text-decoration: none; font-size: 0.9em;"></a>
                            </div>
                        </div> 
                        <div class="row align-items-center justify-content-center mx-auto p-0 mt-2">
                            <div class="col-auto text-center mx-1 p-0">
                                <a class="card-subtitle link-info" style="text-decoration: none; font-size: 1em;cursor: pointer; color: white" onclick="open_modal('POP','1')">Terma Penggunaan</a>
                            </div>
                            
                            <div class="col-auto text-center mx-1 p-0 d-none d-md-block">
                                <div>&emsp;|&emsp;</div>
                            </div>
                            
                            <div class="col-auto text-center mx-1 p-0">
                                <a class="card-subtitle link-info" style="text-decoration: none; font-size: 1em;cursor: pointer;color: white" onclick="open_modal('POP','2')">Polisi Keselamatan</a>
                            </div>
                        </div>-->
                    </div>
                </div>  
            </div>
        </div> 
    </section>
   
<div id="modallupa" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg static"  style="width: 95%;">
                <div class="modal-content">
        		<?php include '../forgot_password.php'; ?>
                </div>
            </div>
        </div>

<!--Modal: Name-->
<div class="modal fade static" id="modalLupa" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg static" role="document">
    <!--Content-->
    <div class="modal-content static" >
    <div class="modal-header static" style="background-color:rgb(38, 167, 228)">
        <h4 class="modal-title" >Lupa Kata Laluan</h4>
        <button type="button" class="btn btn-outline-info btn-md" onclick="close_lupa()"><i class="fas fa-times ml-1" style="color: #000;"></i></button>
      </div>

      <!--Body-->
        <div class="modal-body">
            <div class="modal-body">
                <div class="col-md-12">    
                    <div class="form-group my-2">
                        <div class="row">
                            <label class="col-md-4"><b style="color: #000;">No. Kad Pengenalan : <font color="#f00">*</font></b></label>
                            <div class="col-md-8"><input type="text" name="ICNo" id="ICNo" onchange="do_semaks(this.value)" class="form-control" maxlength="12"><i>(contoh: 760910015001)</i></div>
                        </div>
                    </div>    
                    <div class="form-group my-2">
                        <div class="row">
                            <label class="col-md-4"><b style="color: #000;">E-mel Pengguna : <font color="#f00">*</font></b></label>
                            <div class="col-md-8"><input type="text" name="emel" id="emel" class="form-control"><i>(alamat e-mel peribadi yang telah didaftarkan)</i></div>
                        </div>
                    </div>
                </div>
            </div>
            <!--Footer-->
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-outline-info btn-md" onclick="do_lupa('../module/daftar_proses.php?pro=LUPA_ADMIN')">Hantar <i class="fas fa-save ml-1"></i></button>
                <button type="button" class="btn btn-outline-info btn-md" onclick="close_lupa()">Tutup <i class="fas fa-times ml-1"></i></button>
            </div>
        </div>
      <!--Footer-->
      <!--<div class="modal-footer justify-content-center">
        <button type="button" class="btn btn-outline-info btn-md" onclick="close_lupa()">Tutup <i class="fas fa-times ml-1"></i></button>
      </div>-->

    </div>
    <!--/.Content-->

  </div>
</div>

      

<!--Modal: Name-->
<div class="modal fade static" id="modalRegular" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg static" role="document">
    <!--Content-->
    <div class="modal-content static" >
    <div class="modal-header static">
        <h4 class="modal-title" id="pengumuman">Maklumat Pengumuman</h4>
        <button type="button" class="btn btn-outline-info btn-md" onclick="closem()"><i class="fas fa-times ml-1"></i></button>
      </div>

      <!--Body-->
        <div class="modal-body">
            <div class="col-md-12">    
                <div class="form-group">
                    <div id="tajuk" class="modal-title" style="font-size:16px;font-weight: bold;"></div><br>
                    <div id="maklumat"></div>
                </div>
            </div>
        </div>
      <!--Footer-->
      <div class="modal-footer justify-content-center">
        <button type="button" class="btn btn-outline-info btn-md" onclick="closem()">Close <i class="fas fa-times ml-1"></i></button>
      </div>

    </div>
    <!--/.Content-->

  </div>
</div>
<!--Modal: Name-->
</div>
<br><br>
</div>

</form>
</body>

<footer class="footercolor text-white">
<?php include '../index_footer.php'; ?>  
    <div class="container-xxl py-1 text-center">
        <span style="font-size: 0.7em;">©2023 oleh Suruhanjaya Perkhidmatan Pendidikan. Semua hakcipta terpelihara.</span><br>
           </div>
</footer>
        <!-- Bootstrap core JavaScript -->
        <!-- <script src="index_files/jquery.js"></script>
        <script src="../index_files/bootstrap.js"></script> -->

        <script src="../assets/vendor/jquery/jquery.js"></script>

        <script src="../assets/vendor/jquery-ui/js/jquery-ui-1.10.4.custom.js"></script>
        <script src="../assets/vendor/jquery-ui-touch-punch/jquery.ui.touch-punch.js"></script>
        <script src="../assets/vendor/jquery-appear/jquery.appear.js"></script>
        <script src="../assets/vendor/bootstrap-multiselect/bootstrap-multiselect.js"></script>

        <!-- Theme Base, Components and Settings -->
        <!-- <script src="assets/javascripts/theme.js"></script> -->
        
        <!-- Theme Custom -->
        <!-- <script src="assets/javascripts/theme.custom.js"></script> -->
        
        <!-- Theme Initialization Files -->
        <!-- <script src="assets/javascripts/theme.init.js"></script> -->

        
        <!-- <script src="vendor/jquery/jquery.min.js"></script>
        <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script> -->

        <!-- Additional Scripts -->
        <!-- <script src="index_files/custom.js"></script>
        <script src="../index_files/owl.js"></script>
        <script src="../index_files/slick.js"></script>
        <script src="../index_files/accordions.js"></script>
        <script src="../index_files/aos.js"></script> -->

    <script>
        //Edit SL: more universal
        $(document).on('hidden.bs.modal', function (e) {
            $(e.target).removeData('bs.modal');
        });  
    </script>

<script>
    function get_data(type,id) {
        $.ajax({
            url:'../connection/portal_sql.php?pro='+type, //&datas='+datas,
            type: 'POST',
            data: {val:id},
            success:function(data){
                // console.log(data);
                // alert(data);
                document.getElementById('pengumuman').innerHTML = data[0];
                document.getElementById('tajuk').innerHTML = data[1];
                document.getElementById('maklumat').innerHTML = data[2];
            }
        }); 
    }    
</script>


<script>
function open_lupa(vars){
    $('#modalLupa').modal('show');
};
function close_lupa(vars){ 
    $('#modalLupa').modal('hide');
}


function open_modal(type,id){
    // alert(id);
  // $('#btnLaunch').click(function() {
    $('#modalRegular').modal('show');
    get_data(type,id);
  // });  
};
function closem(){ 
    $('#modalRegular').modal('hide');
}
</script>
<script src="../index_files/bootstrap.js"></script>
</html>