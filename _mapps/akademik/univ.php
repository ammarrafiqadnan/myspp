<?php //include '../connection/common.php'; ?>
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
<style type="text/css">
	a.disabled {
  pointer-events: none;
  cursor: default;
}
</style>
<?php
$urls="index.php?data=".base64_encode('akademik/univ;MAKLUMAT AKADEMIK;Maklumat Pengajian Tinggi;;1;;');
?>
<script language="javascript">
function formatDate(date) {
    var d = new Date(date),
        month = '' + (d.getMonth() + 1),
        day = '' + d.getDate(),
        year = d.getFullYear();

    if (month.length < 2) 
        month = '0' + month;
    if (day.length < 2) 
        day = '0' + day;

    return [year, month, day].join('-');
}

function formatDateLimit(date) {
    var d_limit = new Date("2025-12-31"),
        month = '' + (d_limit.getMonth() + 1),
        day = '' + d_limit.getDate(),
        year = d_limit.getFullYear();

    if (month.length < 2) 
        month = '0' + month;
    if (day.length < 2) 
        day = '0' + day;

    return [year, month, day].join('-');
}

function pro_result(pro, val){
	$.ajax({
        url:'akademik/sql_akademik.php?frm=UNIV&pro='+pro+'&kep='+val,
		type:'POST',
        //dataType: 'json',
        beforeSend: function () {
            // $('.btn-primary').attr("disabled","disabled");
            // $('.modal-body').css('opacity', '.5');
        },
		// data:  formData,
		data: $("form").serialize(),
		success: function(data){
			console.log(data);
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
			
		}
	});
}

function do_input(vars) { 
	if(vars == 'sijil1'){
		var fileUpload = $("#file1")[0];
		var regex = new RegExp("\.(jpe?g|png|jpg|gif)$");
	} else if(vars == 'sijil2'){
		var fileUpload = $("#file2")[0];
		var regex = new RegExp("\.(jpe?g|png|jpg|gif)$");
	} else if(vars == 'sijil3'){
		var fileUpload = $("#file3")[0];
		var regex = new RegExp("\.(pdf)$");
	}

    if (regex.test(fileUpload.value.toLowerCase())) {
        //Initiate the FileReader object.

	    if (!fileUpload.files) { // This is VERY unlikely, browser support is near-universal
	        console.error("This browser doesn't seem to support the `files` property of file inputs.");
	    } else if (!fileUpload.files[0]) {
	        console.log("Please select a file before clicking 'Load'");
		    } else {
			if(vars == 'sijil3'){
		        	var file = fileUpload.files[0];
				if(file.size > 507200){
					swal({
		    				title: 'Amaran',
		    				text: 'Saiz fail yang dimuatnaik melebihi daripada yang dibenarkan (500kb)',
		    				type: 'warning',
		    				confirmButtonClass: "btn-warning",
		    				confirmButtonText: "Ok",
		    				showConfirmButton: true,
		    			});
					return fileUpload.value = '';
		    		}
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
			}
	        //console.log("File " + file.name + " is " + file.size + " bytes in size");
	    }
        
    } else {
		if(vars == 'sijil3'){
			swal({
	            title: 'Amaran',
	            text: 'Kami hanya menerima format PDF sahaja.',
	            type: 'warning',
	            confirmButtonClass: "btn-warning",
	            confirmButtonText: "Ok",
	            showConfirmButton: true,
	        });

		} else {
	        swal({
	            title: 'Amaran',
	            text: 'Kami hanya menerima format JPG, JPEG, GIF @ PNG sahaja.',
	            type: 'warning',
	            confirmButtonClass: "btn-warning",
	            confirmButtonText: "Ok",
	            showConfirmButton: true,
	        });
		}	
        return fileUpload.value = '';
    }
}

function do_hapus_univ(url){
	swal({
		title: 'Adakah anda pasti untuk menghapuskan data ini?',
		//text: "You won't be able to revert this!",
		type: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Ya, Teruskan',
		cancelButtonText: 'Tidak, Batal!',
		reverseButtons: true
	}).then(function(e) {
		//e.preventDefault();
	    $.ajax({
            url:url, 
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
					  text: 'Maklumat telah berjaya dihapuskan',
					  type: 'success',
					  confirmButtonClass: "btn-success",
					  confirmButtonText: "Ok",
					  showConfirmButton: true,
					}).then(function () {
						//window.location.reload();
						window.location.replace("<?=$urls;?>");
						//window.location.reload(true);
						//reload = window.location; 
						//window.location = reload; 
					});
				} else if(data=='ERR'){
					swal({
					  title: 'Amaran',
					  text: 'Terdapat ralat sistem.\nMaklumat anda tidak berjaya dihapuskan.',
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
	});		
}



</script>

<?php
include 'akademik/sql_akademik.php';
$data = get_exam($conn,$_SESSION['SESS_UID']);
//print_r($data);
$uid = $data['id_pemohon'];
?>

		<header class="panel-heading" style="background-color:#0088cc;">
			<h6 class="panel-title"><font color="#fff" size="3"><b><?php print strtoupper($menu);?></b></font></h6>
		</header>
		<div class="panel-body">
			<div class="box-body">

			<input type="hidden" name="id_pemohon" id="id_pemohon" value="<?php print $uid;?>" readonly="readonly"/>

				<div class="col-md-12">

					<?php //include 'biodata/biodata_view.php'; ?>

					<div class="form-group">

						<div class="row">
							<!--<p>
							  <button class="btn btn-primary form-control" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample" title="Sila klik untuk membaca arahan berkaitan kemasukan data akademik Universiti">
							    ARAHAN:
							  </button>
							</p>-->
							<!-- <div class="collapse" id="collapseExample"> -->
							  <div class="card">
								<label for="nama" class="col-sm-12 control-label" style="border: 1px solid rgb(38, 167, 228);"><b>ARAHAN : </b>
									<ul>
									        <li>Pemohon dikehendaki menyemak kelayakan yang dimiliki sebelum mengisi maklumat akademik pengajian tinggi dalam mySPP untuk memastikan kelayakan tersebut diiktiraf oleh Kerajaan untuk tujuan lantikan ke Perkhidmatan Awam. Kegagalan berbuat demikian boleh menyebabkan tawaran pelantikan dibatalkan sekiranya didapati kelayakan yang dimiliki tidak diiktiraf oleh Kerajaan. Sila layari laman web Pengiktirafan Kelayakan atau Agensi Kelayakan Malaysia (MQA).</li>
										<li>Hanya pemohon yang telah memiliki kelayakan akademik dan mendapat kelulusan Senat Universiti, dibenarkan memohon jawatan dalam perkhidmatan awam.</li>
										<li>Bidang PENDIDIKAN perlu dipilih oleh calon yang berkelayakan/mempunyai iktisas Pendidikan.</li>
										<li>Sebelum mengisi maklumat akademik pengajian tinggi, pemohon dikehendaki memastikan kelayakan yang dimiliki adalah diiktiraf oleh kerajaan untuk tujuan lantikan ke dalam perkhidmatan awam. Jika Institusi/Nama Sijil tiada di dalam senarai, sila adukan kepada SISPAA-SPP.</li>
									</ul>

									
								</label>

							  </div>
							<!-- </div> -->
						</div><br>

					</div>

					<?php 
					//$conn->debug=true;
					$rsUniv = $conn->query("SELECT * FROM $schema2.`calon_ipt` WHERE `bil_keputusan`='1' AND `id_pemohon`=".tosql($uid));
					$bilUniv1 = $rsUniv->recordcount();
					$rsUniv2 = $conn->query("SELECT * FROM $schema2.`calon_ipt` WHERE `bil_keputusan`='2' AND `id_pemohon`=".tosql($uid));
					$bilUniv2 = $rsUniv2->recordcount();
					$rsUniv3 = $conn->query("SELECT * FROM $schema2.`calon_ipt` WHERE `bil_keputusan`='3' AND `id_pemohon`=".tosql($uid));
					$bilUniv3 = $rsUniv3->recordcount();
					$conn->debug=false;
					if(empty($bilUniv3)){ $bilUniv3=0; }
					?>					
					<?php 
				    $hrefs1 = "index.php?data=".base64_encode('akademik/univ;MAKLUMAT AKADEMIK;Maklumat Pengajian Tinggi;;1;;');  
				    $hrefs2 = "index.php?data=".base64_encode('akademik/univ;MAKLUMAT AKADEMIK;Maklumat Pengajian Tinggi;;2;;');  
				    $hrefs3 = "index.php?data=".base64_encode('akademik/univ;MAKLUMAT AKADEMIK;Maklumat Pengajian Tinggi;;3;;');  
				    if($actions==2){ $bg1= ''; $bg2='style="color: blue;"'; $bg3='';}
				    else if($actions==3){ $bg1= ''; $bg2=''; $bg3='style="color: blue;"'; }
				    else { $bg1= 'style="color: blue;"'; $bg2=''; $bg3='';}
				    ?>

					<div class="row">
						<input type="hidden" name="bil_keputusan1" id="bil_keputusan1" value="<?=$rsUniv->fields['bil_keputusan'];?>">
						<input type="hidden" name="bil_keputusan2" id="bil_keputusan2" value="<?=$rsUniv2->fields['bil_keputusan'];?>">
						<input type="hidden" name="bil_keputusan3" id="bil_keputusan3" value="<?=$rsUniv3->fields['bil_keputusan'];?>">

			        	<div class="col-md-12"><?php //print $bilUniv1.":".$bilUniv2.":".$bilUniv3; ?>

			        	<!-- <?php if(!empty($bilUniv1)){ ?>
						<div style="float:right;">
							<label class="btn btn-danger" onclick="do_hapus_univ('akademik/sql_akademik_univ.php?frm=UNIV&pro=UNIV_DELALL&kep=ALL&id_pemohon=<?=$_SESSION['SESS_UID'];?>')">Hapus Semua Maklumat</label>
						</div>
						<?php } ?> -->

					<?php if(empty($bilUniv1)){ ?>
			                <ul class="nav nav-tabs" role="tablist">
			                    <li <?php if($actions=="1"){ print 'class="active"'; }?>><a href="<?=$hrefs1;?>"><b <?=$bg1;?>>Maklumat Keputusan 1</b></a></li>
			                    <li <?php if($actions=="2"){ print 'class="active"'; }?> id="li2" title="Sila lengkapkan maklumat keputusan 1 terlebih dahulu.">
			                    		<a href="#" id="href2">
			                    		<b <?=$bg2;?>>Maklumat Keputusan 2</b></a></li>
			                    <li <?php if($actions=="3"){ print 'class="active"'; }?> id="li2" title="Sila lengkapkan maklumat keputusan 2 terlebih dahulu.">
			                    		<a href="#" id="href3">
			                    		<b <?=$bg3;?>>Maklumat Keputusan 3</b></a></li>
			                </ul>
					<?php } else if(!empty($bilUniv1) && empty($bilUniv2)){ ?>
			                <ul class="nav nav-tabs" role="tablist">
			                    <li <?php if($actions=="1"){ print 'class="active"'; }?>><a href="<?=$hrefs1;?>"><b <?=$bg1;?>>Maklumat Keputusan 1</b></a></li>
			                    <li <?php if($actions=="2"){ print 'class="active"'; }?> id="li2" title="Sila klik untuk maklumat keputusan ke 2.">
			                    		<a href="<?=$hrefs2;?>" id="href2">
			                    		<b <?=$bg2;?>>Maklumat Keputusan 2</b></a></li>
			                    <li <?php if($actions=="3"){ print 'class="active"'; }?> id="li2" title="Sila lengkapkan maklumat keputusan 2 terlebih dahulu.">
			                    		<a href="#" id="href3">
			                    		<b <?=$bg3;?>>Maklumat Keputusan 3</b></a></li>
			                </ul>
					<?php } else if(!empty($bilUniv1) && !empty($bilUniv2)){ ?>
			                <ul class="nav nav-tabs" role="tablist">
			                    <li <?php if($actions=="1"){ print 'class="active"'; }?>><a href="<?=$hrefs1;?>"><b <?=$bg1;?>>Maklumat Keputusan 1</b></a></li>
			                    <li <?php if($actions=="2"){ print 'class="active"'; }?> id="li2" title="Sila lengkapkan maklumat keputusan 1 terlebih dahulu.">
			                    		<a href="<?=$hrefs2;?>" id="href2">
			                    		<b <?=$bg2;?>>Maklumat Keputusan 2</b></a></li>
			                    <li <?php if($actions=="3"){ print 'class="active"'; }?> id="li2" title="Sila lengkapkan maklumat keputusan 2 terlebih dahulu.">
			                    		<a href="<?=$hrefs3;?>" id="href3">
			                    		<b <?=$bg3;?>>Maklumat Keputusan 3</b></a></li>
			                </ul>
					<?php } ?>
			    		</div>

                    <div class="tab-content tabs">
                        <?php 
                        $get_univ1=''; $get_univ2='';
                        if($actions=='1'){ 
                        	include 'akademik/univ1.php';
                        } else if($actions=='2'){
                            include 'akademik/univ2.php';
                        } else if($actions=='3'){
                            include 'akademik/univ3.php';
                        }
                        ?>
                    </div>
                    
                    



					<div class="modal-footer" style="padding:0px;">
						<button type="button" id="simpan" class="btn btn-primary mt-sm mb-sm" onclick="save_univ('SAVE','')"><i class="fa fa-save"></i> Simpan</button>
						<?php if(!empty($bilUniv1) || !empty($bilUniv2) || !empty($bilUniv3)){ ?>
							&nbsp;
							<?php if($actions==1 && $bilUniv1==1 && $db_is_integ == 'T'){ ?> 
							<label class="btn btn-danger" onclick="do_hapus_univ('akademik/sql_akademik_univ.php?frm=UNIV&pro=UNIV_DEL&kep=<?=$actions;?>&id_pemohon=<?=$_SESSION['SESS_UID'];?>')">Hapus</label>
							<?php } else if($actions==2 && $bilUniv2==1 && $db_is_integ == 'T'){ ?> 
							<label class="btn btn-danger" onclick="do_hapus_univ('akademik/sql_akademik_univ.php?frm=UNIV&pro=UNIV_DEL&kep=<?=$actions;?>&id_pemohon=<?=$_SESSION['SESS_UID'];?>')">Hapus</label>
							<?php } else if($actions==3 && $bilUniv3==1 && $db_is_integ == 'T'){ ?> 
							<label class="btn btn-danger" onclick="do_hapus_univ('akademik/sql_akademik_univ.php?frm=UNIV&pro=UNIV_DEL&kep=<?=$actions;?>&id_pemohon=<?=$_SESSION['SESS_UID'];?>')">Hapus</label>
							<?php } ?>
						<?php } ?>
						<input type="hidden" name="progid" id="progid" value="<?php print $progid;?>" />
						<input type="hidden" name="proses" value="<?php print $proses;?>" />
					</div>				

				</div>

			</div>
		</div>
	     
<?php
// $conn->debug=true;
$rsSijil1 = $conn->query("SELECT * FROM $schema2.`calon_sijil` WHERE `jenis_sijil`='UNIV1A' AND `id_pemohon`=".tosql($uid));
$rsSijil2 = $conn->query("SELECT * FROM $schema2.`calon_sijil` WHERE `jenis_sijil`='UNIV2A' AND `id_pemohon`=".tosql($uid));
$conn->debug=false;
if(!$rsSijil1->EOF){ $get_univ1='OK'; }
if(!$rsSijil2->EOF){ $get_univ2='OK'; }
//print $get_univ1.":".$get_univ2 .":".$bilUniv1 .":".$bilUniv2 .":".$bilUniv3.":".$actions;
?>
<?php //if($get_univ1=='OK'){ ?>
<!--<script language="javascript" type="text/javascript">
document.getElementById("href2").removeAttribute("class");
document.getElementById("li2").removeAttribute("title");
</script>-->		 
<?php //} ?>

<?php //if($get_univ2=='OK'){ ?>
<!--<script language="javascript" type="text/javascript">
document.getElementById("href3").removeAttribute("class");
document.getElementById("li3").removeAttribute("title");
</script>-->		 
<?php //} ?>

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