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
    var no_daftar_ssm = $('#no_daftar_ssm').val();
    var nama_sekolah = $('#nama_sekolah').val();
    var alamat = $('#alamat').val();
    var nama_penganjur = $('#nama_penganjur').val();
    var jawatan = $('#jawatan').val();
    var notel = $('#notel').val();
    var tkh_mula = $('#tkh_mula').val();
    var tkh_tamat = $('#tkh_tamat').val();
    var jenis = $('#jenis').val();
    
    if(no_daftar_ssm.trim() == '' ){
        alert('Sila masukkan nombor pendaftaran sekloah/madrasah.');
        $('#no_daftar_ssm').focus(); return false;
    } else if(nama_sekolah.trim() == '' ){
        alert('Sila masukkan nama sekolah/madrasah.');
        $('#nama_sekolah').focus(); return false;
    } else if(alamat.trim() == '' ){
        alert('Sila masukkan alamat.');
        $('#alamat').focus(); return false;
    } else if(nama_penganjur.trim() == '' ){
        alert('Sila masukkan nama penganjur.');
        $('#nama_penganjur').focus(); return false;
    } else if(jawatan.trim() == '' ){
        alert('Sila masukkan jawatan penganjur.');
        $('#jawatan').focus(); return false;
    } else if(notel.trim() == '' ){
        alert('Sila masukkan nombor telefon.');
        $('#notel').focus(); return false;
    } else if(tkh_mula.trim() == '' ){
        alert('Sila masukkan tarikh mula.');
        $('#tkh_mula').focus(); return false;
    } else if(tkh_tamat.trim() == '' ){
        alert('Sila masukkan tarikh tamat.');
        $('#tkh_tamat').focus(); return false;
    } else if(jenis.trim() == '' ){
        alert('Sila masukkan jenis permohonan.');
        $('#jenis').focus(); return false;
    } else {
        $.ajax({
            url:'maklumat_data/sql_maklumat_data.php?frm=PLIK_DET&pro=SAVE',
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
                //alert(data);
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


</script>
<?php
$_SESSION['page_name']="PAS LAWATAN DETAIL";
$id=isset($_REQUEST["id"])?$_REQUEST["id"]:"";
$ids=isset($_GET["ids"])?$_GET["ids"]:"";
//print "ID:".$ids;
// $conn->debug=true;
$sql = "SELECT * FROM tbl_plik_detail WHERE plik_detid=".tosql($ids);
$rsk = $conn->query($sql);
?>
<div class="col-lg-12">
<section class="panel">
    <header class="panel-heading"  style="background-color:rgb(38, 167, 228)">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="do_close()">×</button>
        <h6 class="panel-title"><font color="#000000" size="3"><b>MAKLUMAT PAS LAWATAN IKHTISAS</b></font></h6>
    </header>
    <div class="panel-body">
        <div class="box-body">
        
            <input type="hidden" name="plik_id" id="plik_id" value="<?php print $id;?>" readonly="readonly"/>
            <input type="hidden" name="plik_detid" id="plik_detid" value="<?php print $ids;?>" readonly="readonly"/>
    
            <div class="col-md-12">
            

            <div class="form-group">
              <div class="row">
                <label for="no_daftar_ssm" class="col-sm-2 control-label">NO. DAFTAR <font color="#FF0000">*</font> : </label>
                <div class="col-sm-3">
                    <input type="text" name="no_daftar_ssm" id="no_daftar_ssm" class="form-control" value="<?php print $rsk->fields['no_daftar_ssm'];?>" />
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="row">
                <label for="nama_sekolah" class="col-sm-2 control-label">NAMA SEKOLAH <font color="#FF0000">*</font> : </label>
                <div class="col-sm-10">
                    <input type="text" name="nama_sekolah" id="nama_sekolah" class="form-control" value="<?php print $rsk->fields['nama_sekolah'];?>" />
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="row">
                <label for="alamat" class="col-sm-2 control-label">ALAMAT SEKOLAH <font color="#FF0000">*</font> : </label>
                <div class="col-sm-10">
                    <textarea name="alamat" id="alamat" class="form-control" rows="4"><?php print $rsk->fields['alamat'];?></textarea>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="row">
                <label for="nama_penganjur" class="col-sm-2 control-label">NAMA PENGANJUR <font color="#FF0000">*</font> : </label>
                <div class="col-sm-10">
                    <input type="text" name="nama_penganjur" id="nama_penganjur" class="form-control" value="<?php print $rsk->fields['nama_penganjur'];?>" />
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="row">
                <label for="jawatan" class="col-sm-2 control-label">JAWATAN <font color="#FF0000">*</font> : </label>
                <div class="col-sm-10">
                    <input type="text" name="jawatan" id="jawatan" class="form-control" value="<?php print $rsk->fields['jawatan'];?>" />
                </div>
              </div>
            </div>

            <div class="form-group">
              <div class="row">
                <label for="notel" class="col-sm-2 control-label">NO. TELEFON <font color="#FF0000">*</font> : </label>
                <div class="col-sm-3">
                    <input type="text" name="notel" id="notel" class="form-control" value="<?php print $rsk->fields['notel'];?>" />
                </div>
                <label for="nofaks" class="col-sm-1 control-label"></label>
                <label for="nofaks" class="col-sm-2 control-label">NO. FAKS : </label>
                <div class="col-sm-3">
                    <input type="text" name="nofaks" id="nofaks" class="form-control" value="<?php print $rsk->fields['nofaks'];?>" />
                </div>
              </div>
            </div>

            <div class="form-group">
              <div class="row">
                <label for="tkh_mula" class="col-sm-2 control-label">TARIKH MULA <font color="#FF0000">*</font> : </label>
                <div class="col-sm-3">
                    <input type="date" name="tkh_mula" id="tkh_mula" class="form-control" value="<?php print $rsk->fields['tkh_mula'];?>" />
                </div>
                <label for="tkh_tamat" class="col-sm-1 control-label"></label>
                <label for="tkh_tamat" class="col-sm-2 control-label">TARIKH TAMAT <font color="#FF0000">*</font> : </label>
                <div class="col-sm-3">
                    <input type="date" name="tkh_tamat" id="tkh_tamat" class="form-control" value="<?php print $rsk->fields['tkh_tamat'];?>" />
                </div>
              </div>
            </div>

            <div class="form-group">
              <div class="row">
                <label for="jenis" class="col-sm-2 control-label">PERMOHONAN <font color="#FF0000">*</font> : </label>
                <div class="col-sm-6">
                    <select class="form-control" name="jenis" id="jenis" required="required">
                        <option value="">Sila Pilih</option>
                        <option value="B"<?php if($rsk->fields['jenis']=='B'){ print 'selected';}?>>Permohonan Baharu</option>
                        <option value="L"<?php if($rsk->fields['jenis']=='L'){ print 'selected';}?>>Permohonan Lanjutan</option>
                    </select>
                </div>
               </div>
            </div>

            <div class="form-group">
              <div class="row">
                <label for="status" class="col-sm-2 control-label">STATUS : </label>
                <div class="col-sm-6">
                    <select class="form-control" name="status" id="status" required="required">
                        <option value="0"<?php if($rsk->fields['status']==0){ print 'selected';}?>>Rekod Aktif</option>
                        <!-- <option value="1"<?php if($rsk->fields['status']==1){ print 'selected';}?>>Rekod Tidak Aktif</option> -->
                        <option value="2"<?php if($rsk->fields['status']==2){ print 'selected';}?>>Pembatalan</option>
                        <option value="3"<?php if($rsk->fields['status']==3){ print 'selected';}?>>Berhenti</option>
                        <option value="4"<?php if($rsk->fields['status']==4){ print 'selected';}?>>Pengantungan Sementara</option>
                    </select>
                </div>
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
document.jawi.no_daftar_ssm.focus();
</script>        
