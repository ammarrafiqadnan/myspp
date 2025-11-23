<?php //include '../connection/common.php'; ?>
<script language="javascript">
function do_save(){
    var reg = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
    var id = $('#id').val();
    var nama = $('#nama').val();
    var no_pengenalan = $('#no_pengenalan').val();
    var warganegara = $('#warganegara').val();
    var pengalaman_tahun = $('#pengalaman_tahun').val();
    var no_tel = $('#no_tel').val();
    
    if(nama.trim() == '' ){
        alert('Sila masukkan nama pemegang tauliah sembelihan.');
        $('#nama').focus(); return false;
	} else if(no_pengenalan.trim() == '' ){
        alert('Sila masukkan nombor pengenalan diri.');
        $('#no_pengenalan').focus(); return false;
	} else if(warganegara.trim() == '' ){
        alert('Sila pilih maklumat warganegara.');
        $('#warganegara').focus(); return false;
	} else if(pengalaman_tahun.trim() == '' ){
        alert('Sila masukkan maklumat pemgalaman.');
        $('#pengalaman_tahun').focus(); return false;
	} else if(no_tel.trim() == '' ){
        alert('Sila masukkan maklumat nombor telefon.');
        $('#no_tel').focus(); return false;
	} else {
		$.ajax({
	        url:'maklumat_data/sql_maklumat_data.php?frm=PASS&pro=SAVE',
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
					  text: 'Maklumat telah berjaya dikemaskini',
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

function do_simpan(){
	// alert("ss");
	$.ajax({
        url:'maklumat_data/sql_maklumat_data.php?frm=PASS&pro=SAVE',
		type:'POST',
        //dataType: 'json',
		data: $("form").serialize(),
		//data: datas,
		success: function(data){
			if(data=='OK'){
    			document.getElementById("simpan").click();
    		}
    	}
	});
}




</script>
<?php
$_SESSION['page_name']="SKM";
// $conn->debug=true;
// $noid=isset($_REQUEST["noid"])?$_REQUEST["noid"]:"";
$_SESSION['SESS_DATAID']=$id;
$sql = "SELECT * FROM `tbl_penyembelih` WHERE `id`=".tosql($id);
$rs = $conn->query($sql);

$read_only='';
$rsData = $conn->query("SELECT * FROM `tbl_penyembelih_detail` WHERE `id_penyembelih`='{$id}' ORDER BY `tarikh_sah_akhir` DESC");
if($rsData->EOF){
	$read_only='';
	// $nopengenalan = $noid;
} else if($_SESSION['SESS_ULEVEL']==1){
	$read_only='';
	// $nopengenalan = $rs->fields['no_pengenalan'];
} else {
	// $nopengenalan = $rs->fields['no_pengenalan'];
	$read_only='readonly="readonly"';
}

// PRINT "DD:".$read_only;

?>
<div class="col-lg-12">
<section class="panel">
    <header class="panel-heading"  style="background-color:rgb(38, 167, 228)">
        <h6 class="panel-title"><font color="#000000" size="3"><b>MAKLUMAT PEMEGANG KAD TAULIAH SEMBELIHAN</b></font></h6>
    </header>
    <div class="panel-body">
        <div class="box-body">
        
            <input type="hidden" name="id" id="id" value="<?php print $id;?>" readonly="readonly"/>

		    <div class="row">
		        <div class="col-md-12">
		            <div class="tab" role="tabpanel">
		                <!-- Nav tabs -->
		                <ul class="nav nav-tabs" role="tablist">
		                    <li role="presentation" class="active"><a href="#Section1" aria-controls="home" role="tab" data-toggle="tab"><b>Maklumat Pemegang Kad</b></a></li>
		                    <li role="presentation"><a href="#Section2" aria-controls="profile" role="tab" data-toggle="tab"><b>Maklumat Tambahan/Pemantauan</b></a></li>
		                    <!-- <li role="presentation"><a href="#Section3" aria-controls="messages" role="tab" data-toggle="tab">Section 3</a></li> -->
		                </ul>
		                <!-- Tab panes -->
		                <div class="tab-content tabs">
		                    <div role="tabpanel" class="tab-pane fade in active" id="Section1">
		                        <?php include 'pass_form1.php';?>
		                    </div>
		                    <div role="tabpanel" class="tab-pane fade" id="Section2">
		                        <?php include 'pass_form2.php';?>
		                    </div>
		                    <!-- <div role="tabpanel" class="tab-pane fade" id="Section3">
		                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce semper, magna a ultricies volutpat, mi eros viverra massa, vitae consequat nisi justo in tortor. Proin accumsan felis ac felis dapibus, non iaculis mi varius.</p>
		                    </div> -->
		                </div>
		            </div>
		        </div>
		    </div>
    
		</div>
  </div>
</section>
</div> 
<script language="javascript" type="text/javascript">
//document.frm.gsasar_nama.focus();
</script>		 
