<?php include '../connection/common.php'; ?>
<script language="javascript">
function do_close(){
	reload = window.location; 
	window.location = reload;	
}
function do_save(){
    var reg = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
    var ids = $('#ids').val();
	var href = $('#href').val();
    if(ids.trim() == '' ){
        alert('Sila pilih maklumat pemantauan yang dijalankan.');
        $('#ids').focus(); return false;
    } else {
    	window.location.href = href+"&kategori="+ids;
    }
}

function do_chk(val){
	document.jawi.ids.value = val;
}

</script>
<?php 
$href = "index.php?data=". base64_encode('maklumat/pemantauan_form;DATA;Maklumat Pemantauan;;;'); 
?>
<div class="col-lg-12">
<section class="panel">
    <header class="panel-heading"  style="background-color:rgb(38, 167, 228)">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="do_close()">×</button>
        <h6 class="panel-title"><font color="#000000" size="3"><b>TAMBAH MAKLUMAT PEMANTAUAN</b></font></h6>
    </header>
    <div class="panel-body">
        <div class="box-body">
        	<input type="hidden" name="ids" id="ids" value="" />
        	<input type="hidden" name="href" id="href" value="<?=$href;?>" />
            <div class="col-md-12">
            
            <?php $rsP = $conn->query("SELECT * FROM `_ref_kategori_sub` WHERE `kategori_id`=1 AND `subkat_status`=0 AND `is_deleted`=0"); ?>

            <div class="form-group">
              <div class="row">
                <label for="agensi_nama" class="col-sm-3 control-label"><b>MAKLUMAT PEMANTAUAN : </b><br>
                Sila pilih jenis maklumat pemantauan</label>
                <div class="col-sm-8">
                	<!-- <select class="form-control"> -->
                		<!-- <option value="">-- Sila pilih --</option> -->
                		<?php while(!$rsP->EOF){ ?>
                		<!-- <option value="<?=$rsP->fields['subkat_id'];?>"><?php print $rsP->fields['subkat_nama'];?></option>	 -->
                		<input type="radio" name="subkat_id" id="subkat_id" onclick="do_chk(this.value)" value="<?=$rsP->fields['subkat_id'];?>"> <?php print $rsP->fields['subkat_nama'];?><br>
                		<?php $rsP->movenext(); } ?>
                	<!-- </select> -->
                </div>
              </div>
            </div>

    
            <div class="modal-footer" style="padding:0px;">
                <button type="button" class="mt-sm mb-sm btn btn-primary" onclick="do_save()"><i class="fa fa-save"></i> Tambah</button>
                &nbsp;
                <button type="button" class="btn btn-default" onclick="do_close()" style="margin:0px;"><i class="fa fa-spinner"></i> Kembali</button>
                
            </div>
        </div>
		</div>
  </div>
     
</section>

</div> 
<script language="javascript" type="text/javascript">
// document.jawi.no_id.focus();
</script>		 
