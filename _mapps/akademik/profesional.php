<!-- <link href="vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
<link href="vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
<link href="vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
<link href="vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet"> -->

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<style type="text/css">
.icon {
  padding-right: 15px;
  margin-right: 10px;
  background: url("cal/img/screenshot.gif") no-repeat right;
  background-size: 20px;
}
</style>

<script language="javascript">
function do_click_btn(vals){
	//alert("hai");
	var href='index.php?data=bWFrbHVtYXQvdGluZGFrYW5fbGlzdDtEQVRBO01ha2x1bWF0IFRpbmRha2FuOzs7Ow==&#'+vals;
	document.jawi.action=href;
	document.jawi.target='_self';
	document.jawi.submit();
}
function do_save(){
    var reg = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
    var professional_1 = $('#professional_1').val();
    var professional_d_1 = $('#professional_d_1').val();
    var professional_no_ahli_1 = $('#professional_no_ahli_1').val();
	var msg = '';
    
    if(professional_1.trim() == '' ){
        msg = msg+"\n- Sila pilih maklumat sijil professional.";
        $('#professional_1').css("border-color","#f00");
    } 
    if(professional_d_1.trim() == '' ){
        msg = msg+"\n- Sila masukkan maklumat tarikh.";
        $('#professional_d_1').css("border-color","#f00");
    } 
    if(professional_no_ahli_1.trim() == '' ){
        msg = msg+"\n- Sila masukkan maklumat nombor keahlian.";
        $('#professional_no_ahli_1').css("border-color","#f00");
    }
	if(msg.trim() !=''){ 
		alert_msg_html(msg);
	} else {
		var fd = new FormData();
        var files1 = $('#file_profesional')[0].files[0];
        // var files2 = $('#upload_id2')[0].files[0];
        fd.append('file_profesional',files1);
        // fd.append('upload_id2',files2);

        var other_data = $('form').serializeArray();
		$.each(other_data,function(key,input){
		    fd.append(input.name,input.value);
		});

        $.ajax({
	        url:'akademik/sql_akademik.php?frm=PROFESIONAL&pro=SAVE',
            type:'POST',
            //dataType: 'json',
            beforeSend: function () {
                //$('.btn-primary').attr("disabled","disabled");
                //$('.modal-body').css('opacity', '.5');
            },
			data:  fd,
            contentType: false,
            cache: false,
            processData:false,
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

function do_input() { 

		var fileUpload = $("#file_profesional")[0];
    

	//alert(fileUpload);
	var regex = new RegExp("\.(jpe?g|png|jpg|gif)$");

    if (regex.test(fileUpload.value.toLowerCase())) {
        //Initiate the FileReader object.

    if (!fileUpload.files) { // This is VERY unlikely, browser support is near-universal
        console.error("This browser doesn't seem to support the `files` property of file inputs.");
    } else if (!fileUpload.files[0]) {
        console.log("Please select a file before clicking 'Load'");
    } else {
        var file = fileUpload.files[0];
	if(file.size > 307200){
		swal({
            		title: 'Amaran',
            		text: 'Saiz fail yang dimuatnaik melebihi daripada yang dibenarkan (300kb)',
            		type: 'warning',
            		confirmButtonClass: "btn-warning",
            		confirmButtonText: "Ok",
            		showConfirmButton: true,
        	});
		return fileUpload.value = '';
	}
        //console.log("File " + file.name + " is " + file.size + " bytes in size");
    }
        
    } else {
        swal({
            title: 'Amaran',
            text: 'Kami hanya menerima format JPG, JPEG, GIF @ PNG sahaja.',
            type: 'warning',
            confirmButtonClass: "btn-warning",
            confirmButtonText: "Ok",
            showConfirmButton: true,
        });
        return fileUpload.value = '';
    }
}

</script>
<?php
$JFORM='LIST';
$user = get_user($conn,$_SESSION['SESS_UID']);
$data = get_profesional($conn,$_SESSION['SESS_UID']);
$uid=$_SESSION['SESS_UID'];
//print_r($data);
// $conn->debug=true;
$sijil=''; $sijil_pic='';
$rsSijil = $conn->query("SELECT * FROM $schema2.`calon_sijil` WHERE `jenis_sijil`='PRO' AND `id_pemohon`=".tosql($uid));
//if(empty($rsSijil->fields['sijil_nama'])){ $sijil="../upload_doc/professional.jpg"; }
//else { $sijil = "/upload/".$uid."/".$rsSijil->fields['sijil_nama']; }

if(empty($rsSijil->fields['sijil_nama'])){ $sijil_pic ="/var/www/myspp/upload_doc/professional.jpg"; }
else { $sijil_pic = "/var/www/upload/".$uid."/".$rsSijil->fields['sijil_nama']; }
 //print $sijil;

if (file_exists($sijil_pic)){
     $b64image = base64_encode(file_get_contents($sijil_pic));
     $sijil = "data:image/png;base64,$b64image";
}

?>

<input type="hidden" id="vals" name="vals" value=""  />
		<div class="box" style="background-color:#F2F2F2">

            <div class="box-body">
				<div class="x_panel" style="background-color:#F2F2F2">
					<header class="panel-heading" style="background-color:#0088cc;">
						<div class="panel-actions"></div>
						<h6 class="panel-title"><font color="#fff"><b><?=$menu;?></b></font></h6> 
					</header>
				</div>
            </div>            
			<div class="panel-body">
			<div class="box-body">

			<input type="hidden" name="id_pemohon" id="id_pemohon" value="<?php print $data['id_pemohon'];?>" readonly="readonly"/>

				<div class="col-md-12">

					<?php //include 'biodata/biodata_view.php'; ?>

					<div class="form-group">
						<div class="row">
							<!--<p>
							  <button class="btn btn-primary form-control" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample" title="Sila klik untuk membaca arahan berkaitan kemasukan data akademik SPM">
							    ARAHAN:
							  </button>
							</p>-->
							<!-- <div class="collapse" id="collapseExample"> -->
							  <div class="card">
									<label for="nama" class="col-sm-12 control-label" style="border: 1px solid rgb(38, 167, 228);"><b>ARAHAN :</b>
										<ul>
											<li>Ruangan ini perlu diisi oleh pemohon yang memiliki sijil daripada badan-badan profesional yang diiktiraf oleh Kerajaan selain daripada butiran Kelulusan Pengajian Tinggi ATAU salah satu daripada syarat-syarat kelayakan masuk ke jawatan berkenaan.</li>
										</ul>
									</label>

							  </div>
							<!-- </div> -->
						</div>
					</div>
					<hr>

					<div class="form-group">
						<div class="row">
							<div class="col-sm-8">
								<div class="form-group">
                <div class="row">
                    <label for="professional_1" class="col-sm-3 control-label"><b>Nama Sijil</b><font color="#FF0000">*</font> : </label>
                    <div class="col-sm-9">
						<select name="professional_1" id="professional_1" class="form-control select2 select2-accessible" style="width: 100%;" aria-hidden="true">
							<option value="">Sila pilih</option>
							<?php print get_sijil_pro($conn, $data['professional_1']); ?>
						</select>
                    </div>
                </div>
            </div>
                <?php //print substr($data['professional_d_1'],0,10);?>
            <div class="form-group">
                <div class="row">
                    <label for="professional_d_1" class="col-sm-3 control-label"><b>Tarikh Keahlian</b><font color="#FF0000">*</font> : </label>
                    <div class="col-sm-3">
                        <!--<input type="date" name="professional_d_1" id="professional_d_1" class="form-control modal-input" 
                        value="<?php print substr($data['professional_d_1'],0,10);?>" />-->
			<input type="text" name="professional_d_1" id="professional_d_1"  size="15" maxlength="10" 
				value="<?php if(!empty($data['professional_d_1'])){ print DisplayDate($data['professional_d_1']); } ?>" 
			data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask 
			class="form-control disableFuturedate icon" style="background-color: #fff; cursor: pointer;">
                    </div>
                </div>
            </div>
            
            <div class="form-group">
                <div class="row">
                    <label for="professional_no_ahli_1" class="col-sm-3 control-label"><b>No. Keahlian</b><font color="#FF0000">*</font> : </label>
                   
                    <div class="col-sm-9">
                        <input type="text" name="professional_no_ahli_1" id="professional_no_ahli_1" class="form-control modal-input" 
                        value="<?php if(!empty($data['professional_no_ahli_1'])){ print $data['professional_no_ahli_1']; } ?>" maxlength="20" />
                    </div>
                </div>
            </div>
                        
            
					</div>

					<div class="col-sm-4" align="center">
						<h6><b>Sijil Profesional</b></h6>
						<?php if(!empty($rsSijil->fields['sijil_nama'])){ print $rsSijil->fields['sijil_nama']; } ?><br>
						<img src="<?=$sijil;?>" width="300" height="400">
						
						<?php if(!empty($rsSijil->fields['sijil_nama'])){ print $rsSijil->fields['sijil_nama']; } ?> 
						<input type="file" name="file_profesional" id="file_profesional" class="form-control" value="" onchange="do_input()">
						<small style="color: red;">Hanya menerima format png,jpg,jpeg @ gif dan tidak melebihi 300kb</small>

					</div>

				</div>
			</div>

			<div class="modal-footer" style="padding:0px;">
				<button type="button" id="simpan" class="btn btn-primary mt-sm mb-sm" onclick="do_save()"><i class="fa fa-save"></i> Simpan</button>
				<?php if(!empty($data['professional_1'])){ ?>
					<label class="btn btn-danger" onclick="do_hapus('akademik/sql_akademik.php?frm=PROFESIONAL&pro=DEL&id_pemohon=<?=$uid;?>')">Hapus</label>
				<?php } ?>
			</div>
		</div>

	
	</div>
</div>

<script type="text/javascript">

// Use datepicker on the date inputs
$("input[type=date]").datepicker({
  dateFormat: 'yy-mm-dd',
  onSelect: function(dateText, inst) {
    $(inst).val(dateText); // Write the value in the input
  }
});

// Code below to avoid the classic date-picker
$("input[type=date]").on('click', function() {
  return false;
});

$(document).ready(function () {
      var currentDate = new Date();
      $('.disableFuturedate').datepicker({
      format: 'dd/mm/yyyy',
      autoclose:true,
      endDate: "currentDate",
      maxDate: currentDate
      // }).on('changeDate', function (ev) {
      //    $(this).datepicker('hide');
      });
      // $('.disableFuturedate').keyup(function () {
      //    if (this.value.match(/[^0-9]/g)) {
      //       this.value = this.value.replace(/[^0-9^-]/g, '');
      //    }
      // });
   });

// $(function() {
//   $( "#d_lulus_kpsl" ).datepicker({  maxDate: new Date() });
//  });
// $(function(){
//     var dtToday = new Date();
    
//     var month = dtToday.getMonth() + 1;
//     var day = dtToday.getDate();
//     var year = dtToday.getFullYear();
//     if(month < 10)
//         month = '0' + month.toString();
//     if(day < 10)
//         day = '0' + day.toString();
    
//     var maxDate = year + '-' + month + '-' + day;
//     // alert(maxDate);
//     $('#d_lulus_kpsl').attr('max', maxDate);
// });
</script>
<script src="../plugins/inputmask/jquery.inputmask.min.js"></script>
<script src="../plugins/daterangepicker/daterangepicker.js"></script>

<script>
  $(function () {
    //Datemask dd/mm/yyyy
    $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
    //Datemask2 mm/dd/yyyy
    $('#datemask2').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
    //Money Euro
    $('[data-mask]').inputmask()

});
</script>          
