<?php
function generateRandomString($length = 6) {
    $characters = '123456789abcdefghjkmnpqrstuvwxyz';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
$uniq = substr(generateRandomString(),0,5);


$emel=isset($_REQUEST["emel"])?$_REQUEST["emel"]:"";
$ICNo=isset($_REQUEST["ICNo"])?$_REQUEST["ICNo"]:"";

?>    
   <section id="intro" class="bg-white big-banner" style="min-height: 630px;">
        
        <div class="container pt-5" style="opacity: 0.9;">
            
            <div class="card p-5 text-md-left">
                <div align="center"><h2>SEMAKAN KEPUTUSAN TEMUDUGA</h2></div>
                <?php //print "PG:".$emel.":".$ICNo; ?>

                <?php if(empty($emel) && empty($ICNo)){ ?>

                    <div class="modal-body">
                        <div class="col-md-12">    
                            <div class="form-group my-3">
                                <div class="row">
                                    <label class="col-md-3"><b>Alamat E-mel : <font color="#f00">*</font></b></label>
                                    <div class="col-md-9"><input type="text" name="emel" id="emel" class="form-control" value="<?=$module;?>"></div>
                                </div>
                            </div>    

                            <div class="form-group my-3">
                                <div class="row">
                                    <label class="col-md-3"><b>No. Kad Pengenalan : <font color="#f00">*</font></b></label>
                                    <div class="col-md-4"><input type="text" id="ICNo" name="ICNo" class="form-control" maxlength="12">(contoh: 760910015001)</div>
                                </div>
                            </div>    
                            <div class="form-group my-3">
                                <div class="row">
                                    <label class="col-md-3"><b>Captcha : <font color="#f00">*</font></b></label>
                                    <div class="col-lg-4 col-sm-6">
                                        <div class="input-group input-group-icon">
                                            <input name="keselamatan" id="keselamatan" type="text" class="form-control input-lg" placeholder="Kod Keselamatan Sistem" maxlength="5" value="" />
                                        </div>
                                    </div>
                                    <div class="col-md-5 col-sm-6" align="center">
                                        <label style="text-decoration:line-through;font-size:22px" id="NONO1"><b><?=$uniq;?></b></label>
                                        <input type="hidden" class="form-control input-lg" name="NONO" id="NONO" style="text-decoration:line-through;" value="<?=$uniq;?>" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--Footer-->
                    <div class="modal-footer justify-content-center">
                        <button type="button" class="btn btn-outline-info btn-md" onclick="do_semakan('index.php?pages=module/semak_panggilan')">Hantar <i class="fas fa-save ml-1"></i></button>
                        <button type="button" class="btn btn-outline-info btn-md" onclick="do_page('index.php')">Tutup <i class="fas fa-times ml-1"></i></button>
                    </div>

                <?php } else if(!empty($emel) && !empty($ICNo)){ ?>
                    
                    <div class="modal-body">
                        <div class="col-md-12">    
                            <div class="form-group my-3">
                                <div class="row">
                                    <label class="col-md-12 text-md-center"><b>Tahniah</b>
                                    <p>anda Ahmad bin Abu (<?=$ICNo;?>) Tahniah ! Anda telah berjaya. Tarikh lapor diri dan penempatan akan dimaklumkan oleh Kementerian/Jabatan berkenaan..</p>

                                        <p>Sila klik disini untuk mencetak surat anda.</p> 
                                    </label>
                                </div>
                            </div>    

                        </div>
                    </div>
                    <!--Footer-->
                    <div class="modal-footer justify-content-center">
                        <button type="button" class="btn btn-outline-info btn-md" onclick="do_page('index.php?pages=module/semak_keputusan')">Semak Semula <i class="fas fa-save ml-1"></i></button>
                        <button type="button" class="btn btn-outline-info btn-md" onclick="do_page('index.php')">Tutup <i class="fas fa-times ml-1"></i></button>
                    </div>

                <?php } ?>
            </div>
            
        </div>
    </section>
    
 