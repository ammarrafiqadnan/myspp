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

function do_pilih(){
    var reg = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
    var staff_id = $('#staff_id').val();
	
    if(staff_id.trim() == '' ){
        alert('Tiada maklumat pegawai yang dipilih.');
        $('#staff_id').focus(); return false;
    } else {
        let checkboxes = document.querySelectorAll('input[name="staff_id"]:checked');
        let values = [];
        checkboxes.forEach((checkbox) => {
            values.push(checkbox.value);
        });
        // alert(values);
        document.jawi.pegawai_list.value=values;
        do_save('SAVE','');
        swal({
            title: 'Berjaya',
            text: 'Maklumat telah berjaya kemaskini',
            type: 'success',
            confirmButtonClass: "btn-success",
            confirmButtonText: "Ok",
            showConfirmButton: true,
          }).then(function () {
			reload = window.location; 
			window.location = reload;
          });
    }
}


</script>
<?php
$ids=isset($_REQUEST["ids"])?$_REQUEST["ids"]:"";
$vals=isset($_REQUEST["vals"])?$_REQUEST["vals"]:"";
//print "ID:".$ids;
// $sql = "SELECT * FROM _tbl_users WHERE isdeleted=0";
// $senarai = $conn->query($sql);
// $marks[] = $vals;
$marks = explode(",", $vals);

$sql = "SELECT * FROM _tbl_users WHERE isdeleted=0 AND `level`=3";
$senarai = $conn->query($sql);
$bil=0;
print_r($marks);
?>
<div class="col-lg-12">
<section class="panel">
    <header class="panel-heading"  style="background-color:rgb(38, 167, 228)">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="do_close()">×</button>
        <h6 class="panel-title"><font color="#000000" size="3"><b>SENARAI NAMA PEGAWAI PEMANTAU</b></font></h6>
    </header>
    <div class="panel-body">
        <div class="box-body">
        
            <input type="hidden" name="ids" id="ids" value="<?php print $ids;?>" readonly="readonly"/>
            <input type="hidden" name="" value="<?=$vals;?>">
    	
    		<table width="100%" class="table" cellpadding="5" cellspacing="0" border="1">
				<tr>
					<td width="5%"><b>Bil</b></td>
					<td width="5%"></td>
					<td width="90%"><b>Nama</b></td>
				</tr>
				<?php while(!$senarai->EOF){ $bil++; 
					$staffid = $senarai->fields['id'];
				?>
				<tr>
					<td align="right"><?=$bil;?>.</td>
					<td align="center"><?php //if(in_array($senarai->fields['id'], $marks)){ print  " checked"; } ?>
						<input type="checkbox" name="staff_id" id="staff_id" value="<?php print $staffid;?>" 
						<?php if(in_array($senarai->fields['id'], $marks)){ print  " checked"; } ?>>
					<td><?php print $senarai->fields['nama'];?></td>
				</tr>
				<?php $senarai->movenext(); } ?>
			</table>
            
            <div class="modal-footer" style="padding:0px;">
                <!-- <button id="btn">Get Selected Colors</button> -->
                
                <button type="button" class="btn btn-primary" onclick="do_pilih()" style="margin:0px;"><i class="fa fa-save"></i> Pilih</button>
                <button type="button" class="btn btn-default" onclick="do_close()" style="margin:0px;"><i class="fa fa-spinner"></i> Kembali</button>
                <input type="hidden" name="proses" value="<?php print $proses;?>" />
            </div>
        </div>
		</div>
  </div>
     
</section>

</div> 
<script language="javascript" type="text/javascript">
// document.frm.isuagama_nama.focus();
</script>		 
<!-- <script>
    const btn = document.querySelector('#btn');
    btn.addEventListener('click', (event) => {
        let checkboxes = document.querySelectorAll('input[name="staff_id"]:checked');
        let values = [];
        checkboxes.forEach((checkbox) => {
            values.push(checkbox.value);
        });
        alert(values);
    });    
</script> -->