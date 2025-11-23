<?php //include '../connection/common.php'; ?>
<script language="javascript">

function do_save(){
    var reg = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
    var plik_nama = $('#plik_nama').val();
    var plik_pasport = $('#plik_pasport').val();
    var plik_warga = $('#plik_warga').val();
    var plik_tlahir = $('#plik_tlahir').val();
    var plik_notel = $('#plik_notel').val();
    var plik_status = $('#plik_status').val();
	//alert(program_pendekatan);
	
    if(plik_nama.trim() == '' ){
        alert('Sila masukkan nama pemegang pas lawatan ikhtisas.');
        $('#plik_nama').focus(); return false;
	} else if(plik_pasport.trim() == '' ){
        alert('Sila masukkan nombor pasport pemegang PLIK.');
        $('#plik_pasport').focus(); return false;
	} else if(plik_warga.trim() == '' ){
        alert('Sila pilih maklumat warganegara.');
        $('#plik_warga').focus(); return false;
	} else if(plik_tlahir.trim() == '' ){
        alert('Sila masukkan tarikh lahir.');
        $('#plik_tlahir').focus(); return false;
	} else if(plik_notel.trim() == '' ){
        alert('Sila masukkan nombor telefon.');
        $('#plik_notel').focus(); return false;
	} else if(plik_status.trim() == '' ){
        alert('Sila pilih status.');
        $('#plik_status').status; return false;
	} else {
        $.ajax({
            url:'maklumat_data/sql_maklumat_data.php?frm=PLIK&pro=SAVE',
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
				//alert(data);
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
$_SESSION['page_name']="PAS LAWATAN";
// $conn->debug=true;
//$progid=isset($_REQUEST["progid"])?$_REQUEST["progid"]:"";
$sql = "SELECT * FROM tbl_plik WHERE plik_id=".tosql($id);
$rs = $conn->query($sql);

$read_only='';
$rsData = $conn->query("SELECT * FROM `tbl_plik_detail` WHERE `plik_id`='{$id}' AND `is_deleted`=0 ORDER BY `tkh_mula` DESC");
if($rsData->EOF){
	$read_only='';
} else if($_SESSION['SESS_ULEVEL']==1){
	$read_only='';
} else {
	$read_only='readonly="readonly"';
}

// PRINT "DD:".$read_only;

?>
<div class="col-lg-12">
<section class="panel">
    <header class="panel-heading"  style="background-color:rgb(38, 167, 228)">
        <h6 class="panel-title"><font color="#000000" size="3"><b>MAKLUMAT PEMEGANG PAS LAWATAH IKHTISAS</b></font></h6>
    </header>
    <div class="panel-body">
        <div class="box-body">
        
            <input type="hidden" name="plik_id" id="plik_id" value="<?php print $id;?>" readonly="readonly"/>
 
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
                                <?php include 'plik_form1.php';?>
                            </div>
                            <div role="tabpanel" class="tab-pane fade" id="Section2">
                                <?php include 'plik_form2.php';?>
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
