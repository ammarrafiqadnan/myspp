<!-- <link rel="stylesheet" type="text/css" href="scripts/styles.css"> -->

<!-- START Modal: Registration-->
<div class="modal fade static" id="modalReg" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg static" role="document">
        <!--Content-->
        <div class="modal-content static" >
            <div class="modal-header static">
                <h4 class="modal-title" id="pengumuman">Maklumat Pendaftaran Baru Pemohon</h4>
                <button type="button" class="btn btn-outline-info btn-md" onclick="closeReg('#modalReg')"><i class="fas fa-times ml-1"></i></button>
            </div>

            <!--Body-->
            <div class="modal-body">
                <div class="col-md-12">    
                    <div class="form-group my-3">
                        <div class="row">
                            <label class="col-md-4"><b>No. Kad Pengenalan : <font color="#f00">*</font></b></label>
                            <div class="col-md-8"><input type="" name="" class="form-control" maxlength="12">(contoh: 760910015001)</div>
                        </div>
                    </div>    
                    <div class="form-group my-3">
                        <div class="row">
                            <label class="col-md-4"><b>Nama Penuh : <font color="#f00">*</font></b></label>
                            <div class="col-md-8"><input type="" name="" class="form-control">(seperti dalam kad pengenalan) </div>
                        </div>
                    </div>    
                    <div class="form-group my-3">
                        <div class="row">
                            <label class="col-md-4"><b>Alamat E-mel : <font color="#f00">*</font></b></label>
                            <div class="col-md-8"><input type="" name="" class="form-control">(alamat e-mel peribadi)</div>
                        </div>
                    </div>    
                    <div class="form-group my-3">
                        <div class="row">
                            <label class="col-md-4"><b>No. Telefon Bimbit : <font color="#f00">*</font></b></label>
                            <div class="col-md-8"><input type="" name="" class="form-control"></div>
                        </div>
                    </div>    
                    <div class="form-group my-3">
                        <div class="row">
                            <label class="col-md-4"><b>Captcha : <font color="#f00">*</font></b></label>
                            <div class="col-md-4">
                                <input type="text" id="textBox" name="captcha_challenge" pattern="[A-Z]{6}" class="form-control">
                            </div>
                            <!-- <div class="col-md-4">
                                <canvas id="captcha" style="font-size: 30px;">captcha</canvas>
                                !-- <input id="submitButton" type="submit"> --
                                <button id="refreshButton" type="submit">Refresh</button>
                            </div> -->
                        </div>
                    </div>
                </div>


            </div>
            <!--Footer-->
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-outline-info btn-md" onclick="do_send('#modalReg')">Hantar <i class="fas fa-save ml-1"></i></button>
                <button type="button" class="btn btn-outline-info btn-md" onclick="closeReg('#modalReg')">Tutup <i class="fas fa-times ml-1"></i></button>
            </div>

        </div>
        <!--/.Content-->
    </div>
</div>
<!--END Modal: Registration-->

<!-- <script src="scripts/script.js"></script> -->
