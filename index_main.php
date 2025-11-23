<script type="text/javascript">
    $(document).ready(function(){
        $("#pwcheck").click(function(){
            var x = document.getElementById("katalaluan");
            if ($("#pwcheck").is(":checked")) {
                if (x.type === "password") {
                    x.type = "text";
                } 
                // else {
                //     x.type = "password";
                // }
            } else {
                x.type = "password";
            }
        });
        
    });

</script>

    <section id="intro" class="bg-light big-banner px-0">
        
        <div class="container-xl pt-5 px-0">
            <div class="row align-items-center justify-content-center px-3">
                
                <div class="col-lg-8 col-md-7 my-2 px-0">
			<?php //include 'index_pengumumans.php'; ?>
                </div>
                
                <div class="col-lg-4 col-md-5 m-0">
                    <!-- Log masuk -->
                    <div class="p-3 pb-2 my-2 container shadow-lg border border-primary rounded" style="background-color: #ffffffa6;">
    
                        <?php if(empty($_SESSION['SESS_UID']) || $_SESSION['SESS_USER']!='COMP-USER'){ ?> 
			<!--<h2 class="text-center">PENGUMUMAN </h2>
			<h3 class="text-center">Harap maaf, <br> Sistem mengalami gangguan dan dalam proses penyelenggaraan. <br><br> Sistem akan beroperasi sehingga diberitahu. </h3> -->


                        <h2 class="text-center">Log Masuk</h2>
                            
                            <div class="mb-3 input-icons">
                                <label for="idPengguna" class="form-label">No. Kad Pengenalan</label><br>
                                <i class="fa-solid fa-circle-user loginIcon"></i>
                                <input type="text" class="form-control input-field shadow-info" name="userid" id="userid" maxlength="12">
                            </div>
                            
                            <div class="mb-3 input-icons">
                                <label for="katalaluan" class="form-label">Kata Laluan</label><br>
                                <i class="fa-solid fa-lock loginIcon"></i>
                                <input type="password" name="katalaluan" id="katalaluan" class="form-control input-field">
                                <div align="right">
                                    <input type="checkbox" id="pwcheck" /> Lihat Kata Laluan
                                </div>
                            </div>

                            
                            
                            <div class="text-center">
                                <button type="button" class="btn btn-primary align-center" onclick="do_log()">Log Masuk</button>
                            </div>
                            
                            <div class="text-center my-2">
                                <label class="btn btn-block mb-2 btn-info" style="text-decoration: none;" onclick="open_reg('#modalReg')">Pendaftaran Baharu</label>
                                <label class="btn btn-block mb-2 btn-info" style="text-decoration: none;" onclick="open_lupa('#modalLupa')">Lupa Kata Laluan?</label>
                                </div>
                                <div class="row align-items-center justify-content-center mx-auto p-0">
				<!--
                                    <div class="col-auto text-center mx-1 p-0">
                                        <label class="card-subtitle link-info" style="text-decoration: none; font-size: 1em;cursor: pointer;" onclick="open_modal('POP','1')">Penafian</label>
                                    </div>
                                    |
                                    <div class="col-auto text-center mx-1 p-0">
                                        <label class="card-subtitle link-info" style="text-decoration: none; font-size: 1em;cursor: pointer;" onclick="open_modal('POP','3')">Dasar Privasi</label>
                                    </div>
                                    |
                                    <div class="col-auto text-center mx-1 p-0">
                                        <label class="card-subtitle link-info" style="text-decoration: none; font-size: 1em;cursor: pointer;" onclick="open_modal('POP','2')">Dasar Keselamatan</label>
                                    </div>
				-->
                                </div>
                            </div>
                            

                        <?php } else { ?>
                        <div class="section-heading mb-3">
                            <h3 class="text-center">Maklumat Pemohon</h3>
                        </div>

                        <div class="text-center">
                            <!-- <p class="login-card-description"><b></b></p> -->
                            <div class="form-group">
                                <?php print $_SESSION['SESS_UIC'];?>
                            </div>
                            <div class="form-group">
                                <?php print $_SESSION['SESS_UNAME'];?>
                            </div>
                            <div class="form-group">
                                <?php print $_SESSION['SESS_UCOMP'];?>
                            </div>


                            <div class="text-center"><br>
                                <a href="_usys/"><input name="login" id="login" class="btn btn-block login-btn mb-4 btn-primary" type="button" value="Maklumat Permohonan"></a>
                            </div>
                            <div class="text-center">
                                <a href="_usys/logoutm.php"><input name="login" id="login" class="btn btn-block login-btn mb-4 btn-primary" type="button" value="Log Keluar"></a>
                            </div>
                        </div>
                        <!-- <script type="text/javascript">document.getElementById('admin_log').addClass('disabled');</script> -->
                        <?php } ?>

                    </div>
                </div>
            </form>
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
            <button type="button" class="btn btn-outline-info btn-md" onclick="closem()">Tutup <i class="fas fa-times ml-1"></i></button>
          </div>

        </div>
        <!--/.Content-->

      </div>
    </div>
    </section>

    <?php //include 'index_pengumuman.php'; ?>
    <?php include 'index_pengumumans.php'; ?>

    <?php include 'module/forgot_password.php'; ?>
    </div>
    
    <?php include 'module/registration.php'; ?>

</div>
<br><br>
</div>

<script>
    function get_data(type,id) {
        $.ajax({
            url:'connection/portal_sql.php?pro='+type, //&datas='+datas,
            type: 'POST',
            data: {val:id},
            success:function(data){
                // console.log(data);
                // alert(data[1]);
                document.getElementById('pengumuman').innerHTML = data[0];
                document.getElementById('tajuk').innerHTML = data[1];
                document.getElementById('maklumat').innerHTML = data[2];
            }
        }); 
    }   
    function get_data_pengumuman(type,id) {
        $.ajax({
            url:'connection/portal_sql.php?pro='+type, //&datas='+datas,
            type: 'POST',
            data: {val:id},
            success:function(data){
                // console.log(data);
                // alert(data[1]);
                document.getElementById('pengumuman').innerHTML = data[0];
                document.getElementById('tajuk').innerHTML = data[1];
                document.getElementById('maklumat').innerHTML = data[2];
            }
        }); 
    }        
</script>


<script>
function open_modal(type,id){
    $('#modalRegular').modal('show');
    get_data(type,id);
};
function open_pengumuman(type,id){
    $('#modalRegular').modal('show');
    get_data_pengumuman(type,id);
};


function closem(){ 
    $('#modalRegular').modal('hide');
}
function open_reg(vars){
    $(vars).modal('show');
};
function closeReg(vars){ 
    $(vars).modal('hide');
}
function open_lupa(vars){
    $('#modalLupa').modal('show');
};
function close_lupa(vars){ 
    $('#open_lupa').modal('hide');
}
</script>
