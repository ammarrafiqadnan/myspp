<?php include '../connection/common.php'; ?>
<script language="javascript">
function do_close(){
    reload = window.location; 
    window.location = reload;
}

function rep_val(vals){
    var val='';
    val = vals.replace("&", "@@");
    return val;
}

function do_save(){
    var reg = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
    var majikan_nossm = $('#majikan_nossm').val();
    var majikan_nama = $('#majikan_nama').val();
    var majikan_alamat = $('#majikan_alamat').val();
    var majikan_notel = $('#majikan_notel').val();
    var premis_nama = $('#premis_nama').val();
    var premis_alamat = $('#premis_alamat').val();
    var premis_notel = $('#premis_notel').val();
    var tarikh_sah_mula = $('#tarikh_sah_mula').val();
    var tarikh_sah_akhir = $('#tarikh_sah_akhir').val();
    var no_sijil = $('#no_sijil').val();
    var no_kad = $('#no_kad').val();
    
    if(majikan_nossm.trim() == '' ){
        alert('Sila masukkan nombor pendaftaran SSM majikan.');
        $('#majikan_nossm').focus(); return false;
    } else if(majikan_nama.trim() == '' ){
        alert('Sila masukkan nama majikan.');
        $('#majikan_nama').focus(); return false;
    } else if(majikan_alamat.trim() == '' ){
        alert('Sila masukkan alamat majikan.');
        $('#majikan_alamat').focus(); return false;
    } else if(majikan_notel.trim() == '' ){
        alert('Sila masukkan nombor telefon majikan.');
        $('#majikan_notel').focus(); return false;
    } else if(premis_nama.trim() == '' ){
        alert('Sila masukkan nama premis sembelihan.');
        $('#premis_nama').focus(); return false;
    } else if(premis_alamat.trim() == '' ){
        alert('Sila masukkan alamat premis sembelihan.');
        $('#premis_alamat').focus(); return false;
    } else if(premis_notel.trim() == '' ){
        alert('Sila masukkan nombor telefon premis sembelihan.');
        $('#premis_notel').focus(); return false;
    } else if(tarikh_sah_mula.trim() == '' ){
        alert('Sila masukkan tarikh mula tauliah.');
        $('#tarikh_sah_mula').focus(); return false;
    } else if(tarikh_sah_akhir.trim() == '' ){
        alert('Sila masukkan tarikh tamat tauliah.');
        $('#tarikh_sah_akhir').focus(); return false;
    } else if(no_sijil.trim() == '' ){
        alert('Sila masukkan nombor sijil tauliah.');
        $('#no_sijil').focus(); return false;
    } else if(no_kad.trim() == '' ){
        alert('Sila masukkan nombor kad tauliah.');
        $('#no_kad').focus(); return false;
    } else {
        $.ajax({
            url:'maklumat_data/sql_maklumat_data.php?frm=PASS_DET&pro=SAVE',
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
                //window.location.reload();

            },
            //data: datas
        });
    }
}

/**/

</script>
<?php
$_SESSION['page_name']="SKM DETAIL";
$id=isset($_REQUEST["id"])?$_REQUEST["id"]:"";
$ids=isset($_GET["ids"])?$_GET["ids"]:"";
//print "ID:".$ids;
// $conn->debug=true;
$sql = "SELECT * FROM `tbl_penyembelih_detail` WHERE `id_det`=".tosql($ids);
$rsk = $conn->query($sql);
?>
<div class="col-lg-12">
<section class="panel">
    <header class="panel-heading"  style="background-color:rgb(38, 167, 228)">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="do_close()">×</button>
        <h6 class="panel-title"><font color="#000000" size="3"><b>MAKLUMAT KAD TAULIAH KEBENARAN MENYEMBELIH</b></font></h6>
    </header>
    <div class="panel-body">
        <div class="box-body">
        
            <input type="hidden" name="id_penyembelih" id="id_penyembelih" value="<?php print $id;?>" readonly="readonly"/>
            <input type="hidden" name="id_det" id="id_det" value="<?php print $ids;?>" readonly="readonly"/>
    
            <div class="col-md-12">
            

            <div class="form-group">
              <div class="row">
                <label for="agensi_nama" class="col-sm-2 control-label">NO. DAFTAR SSM <font color="#FF0000">*</font> : </label>
                <div class="col-sm-3">
                    <input type="text" name="majikan_nossm" id="majikan_nossm" class="form-control" value="<?php print $rsk->fields['majikan_nossm'];?>" />
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="row">
                <label for="agensi_nama" class="col-sm-2 control-label">NAMA MAJIKAN <font color="#FF0000">*</font> : </label>
                <div class="col-sm-10">
                    <input type="text" name="majikan_nama" id="majikan_nama" class="form-control" value="<?php print $rsk->fields['majikan_nama'];?>" />
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="row">
                <label for="agensi_nama" class="col-sm-2 control-label">ALAMAT MAJIKAN <font color="#FF0000">*</font> : </label>
                <div class="col-sm-10">
                    <textarea name="majikan_alamat" id="majikan_alamat" class="form-control" rows="4"><?php print $rsk->fields['majikan_alamat'];?></textarea>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="row">
                <label for="agensi_nama" class="col-sm-2 control-label">NO. TELEFON <font color="#FF0000">*</font> : </label>
                <div class="col-sm-3">
                    <input type="text" name="majikan_notel" id="majikan_notel" class="form-control" value="<?php print $rsk->fields['majikan_notel'];?>" />
                </div>
                <label for="agensi_nama" class="col-sm-1 col-xs-12 control-label"></label>
                <label for="agensi_nama" class="col-sm-2 control-label">NO. FAKS : </label>
                <div class="col-sm-3">
                    <input type="text" name="majikan_nofaks" id="majikan_nofaks" class="form-control" value="<?php print $rsk->fields['majikan_nofaks'];?>" />
                </div>
              </div>
            </div>


            <div class="form-group">
              <div class="row">
                <label for="agensi_nama" class="col-sm-2 control-label">NAMA PREMIS <font color="#FF0000">*</font> : </label>
                <div class="col-sm-10">
                    <input type="text" name="premis_nama" id="premis_nama" class="form-control" value="<?php print $rsk->fields['premis_nama'];?>" />
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="row">
                <label for="agensi_nama" class="col-sm-2 control-label">ALAMAT PREMIS <font color="#FF0000">*</font> : </label>
                <div class="col-sm-10">
                    <textarea name="premis_alamat" id="premis_alamat" class="form-control" rows="4"><?php print $rsk->fields['premis_alamat'];?></textarea>
                </div>
              </div>
            </div>

            <div class="form-group">
              <div class="row">
                <label for="agensi_nama" class="col-sm-2 control-label">NO. TELEFON <font color="#FF0000">*</font> : </label>
                <div class="col-sm-3">
                    <input type="text" name="premis_notel" id="premis_notel" class="form-control" value="<?php print $rsk->fields['premis_notel'];?>" />
                </div>
                
              </div>
            </div>

            <div class="form-group">
              <div class="row">
                <label for="agensi_nama" class="col-sm-2 control-label">TARIKH MULA <font color="#FF0000">*</font> : </label>
                <div class="col-sm-3">
                    <input type="date" name="tarikh_sah_mula" id="tarikh_sah_mula" class="form-control" value="<?php print $rsk->fields['tarikh_sah_mula'];?>" />
                </div>
                <label for="agensi_nama" class="col-sm-1 col-xs-12 control-label"></label>
                <label for="agensi_nama" class="col-sm-2 control-label">TARIKH TAMAT <font color="#FF0000">*</font> : </label>
                <div class="col-sm-3">
                    <input type="date" name="tarikh_sah_akhir" id="tarikh_sah_akhir" class="form-control" value="<?php print $rsk->fields['tarikh_sah_akhir'];?>" />
                </div>
              </div>
            </div>

            <div class="form-group">
              <div class="row">
                <label for="agensi_nama" class="col-sm-2 control-label">NO. SIJIL <font color="#FF0000">*</font> : </label>
                <div class="col-sm-3">
                    <input type="text" name="no_sijil" id="no_sijil" class="form-control" value="<?php print $rsk->fields['no_sijil'];?>" />
                </div>
                <label for="agensi_nama" class="col-sm-1 col-xs-12 control-label"></label>
                <label for="agensi_nama" class="col-sm-2 control-label">NO. KAD <font color="#FF0000">*</font> : </label>
                <div class="col-sm-3">
                    <input type="text" name="no_kad" id="no_kad" class="form-control" value="<?php print $rsk->fields['no_kad'];?>" />
                </div>
              </div>
            </div>

            <div class="form-group">
              <div class="row">
                <label for="jenis" class="col-sm-2 control-label">JENIS PERMOHONAN : </label>
                <div class="col-sm-3">
                    <select class="form-control" name="jenis" id="jenis" required="required">
                        <option value="">Sila Pilih</option>
                        <option value="B"<?php if($rsk->fields['jenis']=='B'){ print 'selected';}?>>Permohonan Baharu</option>
                        <option value="L"<?php if($rsk->fields['jenis']=='L'){ print 'selected';}?>>Permohonan Lanjutan</option>
                    </select>
                </div>    
                <label for="agensi_nama" class="col-sm-1 control-label"></label>
                <label for="status" class="col-sm-2 control-label">STATUS : </label>
                <div class="col-sm-3">
                    <select class="form-control" name="status" id="status" required="required">
                        <option value="0"<?php if($rsk->fields['status']=="0"){ print 'selected';}?>>Rekod Aktif</option>
                        <option value="1"<?php if($rsk->fields['status']=="1"){ print 'selected';}?>>Tamat Tempoh</option>
                        <option value="2"<?php if($rsk->fields['status']=="2"){ print 'selected';}?>>Pembatalan</option>
                        <option value="3"<?php if($rsk->fields['status']=="3"){ print 'selected';}?>>Berhenti</option>
                        <option value="4"<?php if($rsk->fields['status']=="4"){ print 'selected';}?>>Pengantungan Sementara</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
              <div class="row">
                
               </div>
            </div>
    
            <div class="modal-footer" style="padding:0px;">
                <button type="button" class="mt-sm mb-sm btn btn-primary" onclick="do_save()"><i class="fa fa-save"></i> Simpan</button>
                &nbsp;
                <!--<?php if(!empty($ids)){ ?>
                <input type="button" value="Hapus" onclick="do_del('<?=$id;?>')" class="btn btn-danger"/>&nbsp;
                <?php } ?>-->
                <button type="button" class="btn btn-default" onclick="do_close()" style="margin:0px;"><i class="fa fa-spinner"></i> Kembali</button>
                <input type="hidden" name="proses" value="<?php print $proses;?>" />
            </div>
        </div>
        </div>
  </div>
     
</section>

</div> 
<script language="javascript" type="text/javascript">
document.jawi.majikan_nossm.focus();
</script>        
