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
        <h6 class="panel-title"><font color="#000000" size="3"><b>MAKLUMAT SENARAI JAWATAN YANG LAYAK DIPOHON BERDASARKAN KELULUSAN PEMOHON</b></font></h6>
    </header>
    <div class="panel-body">
        <div class="box-body">
        
            <input type="hidden" name="id_penyembelih" id="id_penyembelih" value="<?php print $id;?>" readonly="readonly"/>
            <input type="hidden" name="id_det" id="id_det" value="<?php print $id_det;?>" readonly="readonly"/>
    
            <div class="col-md-12">
            
            <div class="form-group">
                <div class="row">
                    <table class="table" width="100%" cellpadding="5" cellspacing="0">
                        <tr style="font-weight: bold;">
                            <td width="5%" rowspan="2">BIL</td>
                            <td width="55%" rowspan="2">NAMA JAWATAN DIPPOHON</td>
                            <td width="40%" colspan="3" align="center">SUSUNAN PILIHAN</td>
                        </tr>
                        <tr style="font-weight: bold;">
                            <td align="center">Pilihan Pertama</td>
                            <td align="center">Pilihan Kedua</td>
                            <td align="center">Pilihan Ketiga</td>
                        </tr>
                        <tr>
                            <td align="center">1.</td>
                            <td>Kerani Makmal</td>
                            <td align="center"><input type="radio" name="pilihan" value="1"></td>
                            <td align="center"><input type="radio" name="pilihan" value="2"></td>
                            <td align="center"><input type="radio" name="pilihan" value="3"></td>
                        </tr>

                        <tr>
                            <td align="center">2.</td>
                            <td>Kerani Pentadbiran</td>
                            <td align="center"><input type="radio" name="pilihan1" value="1"></td>
                            <td align="center"><input type="radio" name="pilihan1" value="2"></td>
                            <td align="center"><input type="radio" name="pilihan1" value="3"></td>
                        </tr>

                        <tr>
                            <td align="center">3.</td>
                            <td>Pembantu Asrama</td>
                            <td align="center"><input type="radio" name="pilihan1" value="1"></td>
                            <td align="center"><input type="radio" name="pilihan1" value="2"></td>
                            <td align="center"><input type="radio" name="pilihan1" value="3"></td>
                        </tr>
                        
                    </table>
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
