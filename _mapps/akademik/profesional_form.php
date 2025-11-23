<?php include '../../connection/common.php'; ?>
<script language="javascript">
function do_close(){
    // reload = window.location; 
    // window.location = reload;
    $("#Section2").load('maklumat_data/pass_form2.php');
    // $('.modal-input').val('');
    $('#myModal').modal('hide');
}

function rep_val(vals){
    var val='';
    val = vals.replace("&", "@@");
    return val;
}

function do_save(){
    var reg = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
    var info_tarikh = $('#info_tarikh').val();
    var info_jenis = $('#info_jenis').val();
    var info_kenyataan = $('#info_kenyataan').val();
    
    if(info_tarikh.trim() == '' ){
        alert('Sila masukkan maklumat tarikh.');
        $('#info_tarikh').focus(); return false;
    } else if(info_jenis.trim() == '' ){
        alert('Sila pilih jenis maklumat.');
        $('#info_jenis').focus(); return false;
    } else if(info_kenyataan.trim() == '' ){
        alert('Sila masukkan maklumar kenyataan.');
        $('#info_kenyataan').focus(); return false;
    } else {
        $.ajax({
            url:'maklumat_data/sql_maklumat_data.php?frm=PASS_INFO&pro=SAVE',
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
                      text: 'Maklumat telah berjaya disimpan',
                      type: 'success',
                      confirmButtonClass: "btn-success",
                      confirmButtonText: "Ok",
                      showConfirmButton: true,
                    }).then(function () {
                        do_close();
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
$id=isset($_REQUEST["id"])?$_REQUEST["id"]:"";
$id_det=isset($_GET["id_det"])?$_GET["id_det"]:"";
//print "ID:".$ids;
// $conn->debug=true;
$sql = "SELECT * FROM `tbl_penyembelih_info` WHERE `id_pdetail`=".tosql($id_det);
$rsk = $conn->query($sql);
$tarikh = $rsk->fields['info_tarikh'];
if(empty($tarikh)){ $tarikh=date("Y-m-d"); }
?>
<div class="col-lg-12">
<section class="panel">
    <header class="panel-heading"  style="background-color:rgb(38, 167, 228)">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="do_close()">×</button>
        <h6 class="panel-title"><font color="#000000" size="3"><b>MAKLUMAT SIJIL PROFESIONAL</b></font></h6>
    </header>
    <div class="panel-body">
        <div class="box-body">
        
            <input type="hidden" name="id_penyembelih" id="id_penyembelih" value="<?php print $id;?>" readonly="readonly"/>
            <input type="hidden" name="id_det" id="id_det" value="<?php print $id_det;?>" readonly="readonly"/>
    
            <div class="col-md-12">
            
            <div class="form-group">
                <div class="row">
                    <label for="agensi_nama" class="col-sm-2 control-label">NAMA SIJIL<font color="#FF0000">*</font> : </label>
                    <div class="col-sm-10">
                        <input type="text" name="info_tarikh" id="info_tarikh" class="form-control modal-input" value="" />
                    </div>
                </div>
            </div>
                
            <div class="form-group">
                <div class="row">
                    <label for="agensi_nama" class="col-sm-2 control-label">TARIKH KEAHLIAN<font color="#FF0000">*</font> : </label>
                    <div class="col-sm-3">
                        <input type="date" name="info_tarikh" id="info_tarikh" class="form-control modal-input" value="<?php print $tarikh;?>" />
                    </div>
                    <div class="col-sm-3">
                        <input type="date" name="info_tarikh" id="info_tarikh" class="form-control modal-input" value="<?php print $tarikh;?>" />
                    </div>
                </div>
            </div>
            
            <div class="form-group">
                <div class="row">
                    <label for="agensi_nama" class="col-sm-2 control-label">NO. KEAHLIAN<font color="#FF0000">*</font> : </label>
                    <div class="col-sm-10">
                        <input type="text" name="info_tarikh" id="info_tarikh" class="form-control modal-input" value="" />
                    </div>
                </div>
            </div>
                        
            <div class="form-group">
                <div class="row">
                    <label for="agensi_nama" class="col-sm-2 control-label">MUATNAIK SIJIL<font color="#FF0000">*</font> : </label>
                    <div class="col-sm-10">
                        <input type="file" name="info_tarikh" id="info_tarikh" class="form-control modal-input" value="" />
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
document.jawi.info_tarikh.focus();
</script>        
