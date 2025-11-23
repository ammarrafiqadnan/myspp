<?php
include 'akademik/sql_akademik.php';
$data = get_exam($conn,$_SESSION['SESS_UID']);
$uid=$_SESSION['SESS_UID'];
// print_r($data);
$tahun_u = $data['spm_tahun_1'];

$rsSijil = $conn->query("SELECT * FROM $schema2.`calon_sijil` WHERE `jenis_sijil`='EXT' AND `id_pemohon`=".tosql($uid));
if(empty($rsSijil->fields['sijil_nama'])){ $sijil="../upload_doc/PMR_Mock_Result_Statement_Certificate.png"; }
else { $sijil = "../uploads_doc/".$uid."/".$rsSijil->fields['sijil_nama']; }
?>
<script type="text/javascript">
function do_save(){
    var reg = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
    var vals1 = $('#vals1').val();
    var vals2 = $('#vals2').val();
    var vals3 = $('#vals3').val();
    var vals4 = $('#vals4').val();

    var tahun1 = $('#tahun1').val();
    var mp1 = $('#mp1').val();
    var gred1 = $('#gred1').val();
    var bm1 = $('#bm1').val();
    var lisan1 = $('#lisan1').val();

    var tahun2 = $('#tahun2').val();
    var mp2 = $('#mp2').val();
    var gred2 = $('#gred2').val();
    var bm2 = $('#bm2').val();
    var lisan2 = $('#lisan2').val();

    var tahun3 = $('#tahun3').val();
    var mp3 = $('#mp3').val();
    var gred3 = $('#gred3').val();
    var bm3 = $('#bm3').val();
    var lisan3 = $('#lisan3').val();

    var tahun4 = $('#tahun4').val();
    var mp4 = $('#mp4').val();
    var gred4 = $('#gred4').val();
    var bm4 = $('#bm4').val();
    var lisan4 = $('#lisan4').val();

	var msg = '';
    
	if(vals1==0 && vals2==0 && vals3==0 && vals4==0){
       	 	msg = msg+"\n- Sila lengkapkan maklumat peperiksaan tambahan.";
	        $('#tahun1').css("border-color","#f00");
	        $('#mp1').css("border-color","#f00");
	        $('#gred1').css("border-color","#f00");
	}

    if(vals1==1){
	    if(tahun1.trim() == '' || mp1.trim() == '' || gred1.trim() == '' ){
	        msg = msg+"\n- Sila lengkapkan maklumat peperiksaan tambahan.";
	        $('#tahun1').css("border-color","#f00");
	        $('#mp1').css("border-color","#f00");
	        $('#gred1').css("border-color","#f00");
	    } else {
	    	if(mp1=='101' && (lisan1.trim()=='' || bm1.trim()=='')){
		        msg = msg+"\n- Sila lengkapkan maklumat peperiksaan tambahan.";
		        $('#bm1').css("border-color","#f00");
		        $('#lisan1').css("border-color","#f00");
	    	}
	    }
	}

    if(vals2==1){
	    if(tahun2.trim() == '' || mp2.trim() == '' || gred2.trim() == '' ){
	        msg = msg+"\n- Sila lengkapkan maklumat peperiksaan tambahan.";
	        $('#tahun2').css("border-color","#f00");
	        $('#mp2').css("border-color","#f00");
	        $('#gred2').css("border-color","#f00");
	    } else {
	    	if(mp2=='101' && (lisan2.trim()=='' || bm2.trim()=='')){
		        msg = msg+"\n- Sila lengkapkan maklumat peperiksaan tambahan.";
		        $('#bm2').css("border-color","#f00");
		        $('#lisan2').css("border-color","#f00");
	    	}
	    }
	} 

    if(vals3==1){
	    if(tahun3.trim() == '' || mp3.trim() == '' || gred3.trim() == '' ){
	        msg = msg+"\n- Sila lengkapkan maklumat peperiksaan tambahan.";
	        $('#tahun3').css("border-color","#f00");
	        $('#mp3').css("border-color","#f00");
	        $('#gred3').css("border-color","#f00");
	    } else {
	    	if(mp3=='101' && (lisan3.trim()=='' || bm3.trim()=='')){
		        msg = msg+"\n- Sila lengkapkan maklumat peperiksaan tambahan.";
		        $('#bm3').css("border-color","#f00");
		        $('#lisan3').css("border-color","#f00");
	    	}
	    }
	} 
    if(vals4==1){
	    if(tahun4.trim() == '' || mp4.trim() == '' || gred4.trim() == '' ){
	        msg = msg+"\n- Sila lengkapkan maklumat peperiksaan tambahan.";
	        $('#tahun4').css("border-color","#f00");
	        $('#mp4').css("border-color","#f00");
	        $('#gred4').css("border-color","#f00");
	    } else {
	    	if(mp4=='101' && (lisan4.trim()=='' || bm4.trim()=='')){
		        msg = msg+"\n- Sila lengkapkan maklumat peperiksaan tambahan.";
		        $('#bm4').css("border-color","#f00");
		        $('#lisan4').css("border-color","#f00");
	    	}
	    }
	} 


	if(mp1.trim() !='' && mp2.trim()!='' && mp1==mp2){
        msg = msg+"\n- Maklumat matapelajaran telah wujud, sila semak semula.";
        $('#mp2').css("border-color","#f00");
	}
	if(mp1.trim() !='' && mp3.trim()!='' && mp1==mp3){
        msg = msg+"\n- Maklumat matapelajaran telah wujud, sila semak semula.";
        $('#mp3').css("border-color","#f00");
	}
	if(mp1.trim() !='' && mp4.trim()!='' && mp1==mp4){
        msg = msg+"\n- Maklumat matapelajaran telah wujud, sila semak semula.";
        $('#mp4').css("border-color","#f00");
	}
	if(mp2.trim() !='' && mp3.trim()!='' && mp2==mp3){
        msg = msg+"\n- Maklumat matapelajaran telah wujud, sila semak semula.";
        $('#mp3').css("border-color","#f00");
	}
	if(mp2.trim() !='' && mp4.trim()!='' && mp2==mp4){
        msg = msg+"\n- Maklumat matapelajaran telah wujud, sila semak semula.";
        $('#mp4').css("border-color","#f00");
	}
	if(mp3.trim() !='' && mp4.trim()!='' && mp3==mp4){
        msg = msg+"\n- Maklumat matapelajaran telah wujud, sila semak semula.";
        $('#mp4').css("border-color","#f00");
	}

    // var files1 = $('#file1')[0].files[0]['name'];
    // if(files1.trim() !=''){
    // 	if(vals1.trim()=='0' && vals2.trim()=='0' && vals3.trim()=='0' && vals4.trim()=='0'){
	//         msg = msg+"\n- Sila lengkapkan maklumat peperiksaan tambahan.";
	//         $('#tahun1').css("border-color","#f00");
	//         $('#mp1').css("border-color","#f00");
	//         $('#gred1').css("border-color","#f00");
	//     }
	// }

	if(msg.trim() !=''){ 
		alert_msg_html(msg);
	} else {
 		var fd = new FormData();
        var files1 = $('#file1')[0].files[0];
        fd.append('file1',files1);

        var other_data = $('form').serializeArray();
		$.each(other_data,function(key,input){
		    fd.append(input.name,input.value);
		});

        $.ajax({
	        url:'akademik/sql_akademik.php?frm=ULANGAN&pro=SAVE',
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
                      text: 'Maklumat telah berjaya dikemaskini',
                      type: 'success',
                      confirmButtonClass: "btn-success",
                      confirmButtonText: "Ok",
                      showConfirmButton: true,
                    }).then(function () {
						refresh = window.location; 
						window.location = refresh;
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

		//else if(data=='XEX'){
                    //swal({
                      //title: 'Amaran',
                      //text: 'Format dokumen yang dimuatnaik tidak dibenarkan.\nHanya format .jpg / .gif / .jpeg / .png / .pdf sahaja yang dibenarkan.',
                      //type: 'error',
                      //confirmButtonClass: "btn-warning",
                      //confirmButtonText: "Ok",
                      //showConfirmButton: true,
                    //});
                //}
                //window.location.reload();

            },
            //data: datas
        });
    }
}	

function do_open(vals,id){
	var x = '';	
	// alert(id+" : "+vals);
  	if(id==1){
  		x = document.getElementById("tambahan1");
  	} else if(id==2){
  		x = document.getElementById("tambahan2");
  	} else if(id==3){
  		x = document.getElementById("tambahan3");
  	} else if(id==4){
  		x = document.getElementById("tambahan4");
	}

	if(vals=='101'){ 
		x.style.display = "block";
	} else {
		x.style.display = "none";
	}	

 	on_chg(id);

}

function on_chg(vals){
	if(vals==1){
		if($('#tahun1').val()=='' && $('#mp1').val()=='' &&$('#gred1').val()==''){ 
			$('#vals1').val(0);
		} else {
			$('#vals1').val(1);
		}
	} else if(vals==2){
		if($('#tahun2').val()=='' && $('#mp2').val()=='' &&$('#gred2').val()==''){ 
			$('#vals2').val(0);
		} else {
			$('#vals2').val(1);
		}
	} else if(vals==3){
		if($('#tahun3').val()=='' && $('#mp3').val()=='' &&$('#gred3').val()==''){ 
			$('#vals3').val(0);
		} else {
			$('#vals3').val(1);
		}
	} else if(vals==4){
		if($('#tahun4').val()=='' && $('#mp4').val()=='' &&$('#gred4').val()==''){ 
			$('#vals4').val(0);
		} else {
			$('#vals4').val(1);
		}
	}
}

function do_input() { 

	var fileUpload = $("#file1")[0];
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
		<header class="panel-heading" style="background-color:#0088cc;">
			<h6 class="panel-title"><font color="#fff" size="3"><b><?php print strtoupper($menu);?></b></font></h6>
		</header>
		<div class="panel-body">
			<div class="box-body">

			<input type="hidden" name="id_pemohon" id="id_pemohon" value="<?php print $_SESSION['SESS_UID'];?>" readonly="readonly"/>

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
								<label for="nama" class="col-sm-12 control-label" style="border: 1px solid rgb(38, 167, 228);"><b>ARAHAN : Sila Masukkan maklumat peperiksaan tambahan</b>
									<ul>
									<li>Peperiksaan Bahasa Melayu, Matematik, Sejarah bagi Peperiksaan Julai sahaja</li>
									</ul>
								</label>

						  </div>
						<!-- </div> -->

					</div>
					<hr>
					<?php 
					//$conn->debug=true;

					$spm_id1 = ''; $mid1 = ''; $tahun1 = ''; $mp1 = ''; $gred1 = ''; $bm1 = ''; $lisan1 = '';
					$spm_id2 = ''; $mid2 = ''; $tahun2 = ''; $mp2 = ''; $gred2 = ''; $bm2 = ''; $lisan2 = '';
					$spm_id3 = ''; $mid3 = ''; $tahun3 = ''; $mp3 = ''; $gred3 = ''; $bm3 = ''; $lisan3 = '';
					$spm_id4 = ''; $mid4 = ''; $tahun4 = ''; $mp4 = ''; $gred4 = ''; $bm4 = ''; $lisan4 = '';



					$rssijil = $conn->query("SELECT * FROM $schema1.`ref_paper_julai` WHERE `sah_yt`='Y'");
					$rsGred = $conn->query("SELECT * FROM $schema1.`ref_gred_matapelajaran` WHERE `TKT`='5' ORDER BY `SUSUNAN`");

					$rsData = $conn->query("SELECT * FROM $schema2.`calon_spm` WHERE `jenis_xm`='T' AND `id_pemohon`=".tosql($_SESSION['SESS_UID'])." ORDER BY `spm_id`");
					$cntt = 0; $vals1=0; $vals2=0; $vals3=0; $vals4=0;
					while(!$rsData->EOF){
						if($cntt==0){
							$vals1=1;
							$spm_id1 = $rsData->fields['spm_id'];
							$mid1 = $rsData->fields['id_pemohon'];
							$tahun1 = $rsData->fields['tahun'];
							$mp1 = $rsData->fields['matapelajaran'];
							$gred1 = $rsData->fields['gred'];
							$bm1 = $rsData->fields['jenis_sijil'];
							$lisan1 = $rsData->fields['ujian_lisan'];
						} else if($cntt==1){
							$vals2=1;
							$spm_id2 = $rsData->fields['spm_id'];
							$mid2 = $rsData->fields['id_pemohon'];
							$tahun2 = $rsData->fields['tahun'];
							$mp2 = $rsData->fields['matapelajaran'];
							$gred2 = $rsData->fields['gred'];
							$bm2 = $rsData->fields['jenis_sijil'];
							$lisan2 = $rsData->fields['ujian_lisan'];
						} else if($cntt==2){
							$vals3=1;
							$spm_id3 = $rsData->fields['spm_id'];
							$mid3 = $rsData->fields['id_pemohon'];
							$tahun3 = $rsData->fields['tahun'];
							$mp3 = $rsData->fields['matapelajaran'];
							$gred3 = $rsData->fields['gred'];
							$bm3 = $rsData->fields['jenis_sijil'];
							$lisan3 = $rsData->fields['ujian_lisan'];
						} else if($cntt==3){
							$vals4=1;
							$spm_id4 = $rsData->fields['spm_id'];
							$mid4 = $rsData->fields['id_pemohon'];
							$tahun4 = $rsData->fields['tahun'];
							$mp4 = $rsData->fields['matapelajaran'];
							$gred4 = $rsData->fields['gred'];
							$bm4 = $rsData->fields['jenis_sijil'];
							$lisan4 = $rsData->fields['ujian_lisan'];
						}
						$cntt++;
						$rsData->movenext();
					}

					?>
					<div class="form-group">
						<div class="row">
							<div class="col-sm-8" style="margin-left:-30px;margin-right:-30px;">

								<table width="100%">
									<tr>
										<td width="25%"><b>TAHUN</b></td>
										<td width="50%"><b>MATAPELAJARAN</b></td>
										<td width="20%"><b>GRED</b></td>
										<td width="5%"><b></b></td>
									</tr>
									<tr>
										<td>
											<select class="form-control" name="tahun1" id="tahun1" onchange="on_chg(1)" >
												<option value="">Sila pilih tahun</option>
												<?php for($tahun=date("Y");$tahun>$tahun_u;$tahun--){ ?>
												<option value="<?=$tahun;?>" <?php if($tahun1==$tahun){ print 'selected'; }?>><?=$tahun;?></option>
												<?php } ?>
											</select>
										</td>
										<td>
											<select class="form-control" name="mp1" id="mp1" onchange="do_open(this.value,1)">
												<option value="">Sila pilih matapelajaran</option>
												<?php $rssijil->movefirst();
												while(!$rssijil->EOF){ ?>
												<option value="<?=$rssijil->fields['mpel_kod'];?>" <?php if($mp1==$rssijil->fields['mpel_kod']){ print 'selected'; }?>><?=$rssijil->fields['descripsi'];?></option>
												<?php $rssijil->movenext(); } ?>
											</select>
										</td>
										<td>
										<select class="form-control" name="gred1" id="gred1" onchange="on_chg(1)">
											<option value="">Sila pilih gred</option>
											<?php $rsGred->movefirst();
											while(!$rsGred->EOF){ ?>
											<option value="<?=$rsGred->fields['GRED'];?>" <?php if($gred1==$rsGred->fields['GRED']){ print 'selected'; } ?>><?=$rsGred->fields['GRED'];?></option>	
											<?php $rsGred->movenext(); } ?>
										</select>
										</td>
										<td>
										<?php if(!empty($spm_id1)){ ?>
										<img src="../images/trash.png" title="Hapus maklumat matapelajaran & gred" style="cursor: pointer;" class="btn" 
										height="35" onclick="do_hapus('akademik/sql_akademik.php?frm=ULANGAN&pro=ULANGAN_DEL&sid=<?=$spm_id1;?>&id_pemohon=<?=$_SESSION['SESS_UID'];?>')">
										<?php } ?>	
										</td>
									</tr>
									<tr><td colspan="4">
									<div class="col-sm-12"  style="padding-bottom:5px">
										<table width="100%" id="tambahan1">
											<tr >
												<td>
													<label for="nama" class="col-sm-12 control-label">Jenis</label><br><br>
												</td>
												<td colspan="2">
													<select name="bm1" id="bm1" class="form-control">
														<option value="">Sila Pilih</option>
														<option value="1" <?php if($bm1=='1'){ print 'selected'; } ?>>Bahasa Melayu Kertas Julai / SPM Ulangan</option>
														<!--<option value="3" <?php if($bm1=='3'){ print 'selected'; } ?>>Bahasa Melayu di Peringkat STPM/STAM</option>-->
													</select>
												</td>
											</tr>
											<tr style="padding-bottom:5px">
												<td><label for="nama" class="col-sm-12 control-label">Ujian Lisan</label>
												</td>
												<td colspan="2">
													<select name="lisan1" id="lisan1" class="form-control">
														<option value="">Sila Pilih</option>
														<option value="L" <?php if($lisan1=='L'){ print 'selected'; } ?>>Lulus</option>
														<option value="G" <?php if($lisan1=='G'){ print 'selected'; } ?>>Gagal</option>
													</select>
												</td>
											</tr>
										</table>
									</div>
									</td></tr>
	

									<tr>
										<td>
											<select class="form-control" name="tahun2" id="tahun2" onchange="on_chg(2)">
												<option value="">Sila pilih tahun</option>
												<?php for($tahun=date("Y");$tahun>$tahun_u;$tahun--){ ?>
												<option value="<?=$tahun;?>" <?php if($tahun2==$tahun){ print 'selected'; }?>><?=$tahun;?></option>
												<?php } ?>
											</select>
										</td>
										<td>
											<select class="form-control" name="mp2" id="mp2" onchange="do_open(this.value,2)">
												<option value="">Sila pilih matapelajaran</option>
												<?php $rssijil->movefirst();
												while(!$rssijil->EOF){ ?>
												<option value="<?=$rssijil->fields['mpel_kod'];?>" <?php if($mp2==$rssijil->fields['mpel_kod']){ print 'selected'; }?>><?=$rssijil->fields['descripsi'];?></option>
												<?php $rssijil->movenext(); } ?>
											</select>
										</td>
										<td>
											<select class="form-control" name="gred2" id="gred2" onchange="on_chg(2)">
												<option value="">Sila pilih gred</option>
												<?php $rsGred->movefirst();
												while(!$rsGred->EOF){ ?>
												<option value="<?=$rsGred->fields['GRED'];?>" <?php if($gred2==$rsGred->fields['GRED']){ print 'selected'; } ?>><?=$rsGred->fields['GRED'];?></option>	
												<?php $rsGred->movenext(); } ?>
											</select>
										</td>
										<td>
										<?php if(!empty($spm_id2)){ ?>
										<img src="../images/trash.png" title="Hapus maklumat matapelajaran & gred" style="cursor: pointer;" class="btn" 
										height="35" onclick="do_hapus('akademik/sql_akademik.php?frm=ULANGAN&pro=ULANGAN_DEL&sid=<?=$spm_id2;?>&id_pemohon=<?=$_SESSION['SESS_UID'];?>')">
										<?php } ?>	
										</td>

									</tr>
									<tr><td colspan="4">
									<div class="col-sm-12"  style="padding-bottom:5px">
										<table width="100%" id="tambahan2">
											<tr >
												<td>
													<label for="nama" class="col-sm-12 control-label">Jenis</label><br><br>
												</td>
												<td colspan="2">
													<select name="bm2" id="bm2" class="form-control">
														<option value="">Sila Pilih</option>
														<option value="1" <?php if($bm2=='1'){ print 'selected'; } ?>>Bahasa Melayu Kertas Julai / SPM Ulangan</option>
														<!--<option value="3" <?php if($bm2=='3'){ print 'selected'; } ?>>Bahasa Melayu di Peringkat STPM/STAM</option>-->
													</select>
												</td>
											</tr>
											<tr style="padding-bottom:5px">
												<td><label for="nama" class="col-sm-12 control-label">Ujian Lisan</label>
												</td>
												<td colspan="2">
													<select name="lisan2" id="lisan2" class="form-control">
														<option value="">Sila Pilih</option>
														<option value="L" <?php if($lisan2=='L'){ print 'selected'; } ?>>Lulus</option>
														<option value="G" <?php if($lisan2=='G'){ print 'selected'; } ?>>Gagal</option>
													</select>
												</td>
											</tr>
										</table>
									</div>
									</td></tr>

									<tr>
										<td>
											<select class="form-control" name="tahun3" id="tahun3" onchange="on_chg(3)">
												<option value="">Sila pilih tahun</option>
												<?php for($tahun=date("Y");$tahun>$tahun_u;$tahun--){ ?>
												<option value="<?=$tahun;?>" <?php if($tahun3==$tahun){ print 'selected'; }?>><?=$tahun;?></option>
												<?php } ?>
											</select>
										</td>
										<td>
											<select class="form-control" name="mp3" id="mp3" onchange="do_open(this.value,3)">
												<option value="">Sila pilih matapelajaran</option>
												<?php $rssijil->movefirst();
												while(!$rssijil->EOF){ ?>
												<option value="<?=$rssijil->fields['mpel_kod'];?>" <?php if($mp3==$rssijil->fields['mpel_kod']){ print 'selected'; }?>><?=$rssijil->fields['descripsi'];?></option>
												<?php $rssijil->movenext(); } ?>
											</select>
										</td>
										<td>
											<select class="form-control" name="gred3" id="gred3" onchange="on_chg(3)">
												<option value="">Sila pilih gred</option>
												<?php $rsGred->movefirst();
												while(!$rsGred->EOF){ ?>
												<option value="<?=$rsGred->fields['GRED'];?>" <?php if($gred3==$rsGred->fields['GRED']){ print 'selected'; } ?>><?=$rsGred->fields['GRED'];?></option>	
												<?php $rsGred->movenext(); } ?>
											</select>
										</td>
										<td>
										<?php if(!empty($spm_id3)){ ?>
										<img src="../images/trash.png" title="Hapus maklumat matapelajaran & gred" style="cursor: pointer;" class="btn" 
										height="35" onclick="do_hapus('akademik/sql_akademik.php?frm=ULANGAN&pro=ULANGAN_DEL&sid=<?=$spm_id3;?>&id_pemohon=<?=$_SESSION['SESS_UID'];?>')">
										<?php } ?>	
										</td>

									</tr>
									<tr><td colspan="4">
									<div class="col-sm-12"  style="padding-bottom:5px">
										<table width="100%" id="tambahan3">
											<tr >
												<td>
													<label for="nama" class="col-sm-12 control-label">Jenis</label><br><br>
												</td>
												<td colspan="2">
													<select name="bm3" id="bm3" class="form-control">
														<option value="">Sila Pilih</option>
														<option value="1" <?php if($bm3=='1'){ print 'selected'; } ?>>Bahasa Melayu Kertas Julai / SPM Ulangan</option>
														<!--<option value="3" <?php if($bm3=='3'){ print 'selected'; } ?>>Bahasa Melayu di Peringkat STPM/STAM</option>-->
													</select>
												</td>
											</tr>
											<tr style="padding-bottom:5px">
												<td><label for="nama" class="col-sm-12 control-label">Ujian Lisan</label>
												</td>
												<td colspan="2">
													<select name="lisan3" id="lisan3" class="form-control">
														<option value="">Sila Pilih</option>
														<option value="L" <?php if($lisan3=='L'){ print 'selected'; } ?>>Lulus</option>
														<option value="G" <?php if($lisan3=='G'){ print 'selected'; } ?>>Gagal</option>
													</select>
												</td>
											</tr>
										</table>
									</div>
									</td></tr>

									<tr>
										<td>
											<select class="form-control" name="tahun4" id="tahun4" onchange="on_chg(4)">
												<option value="">Sila pilih tahun</option>
												<?php for($tahun=date("Y");$tahun>$tahun_u;$tahun--){ ?>
												<option value="<?=$tahun;?>" <?php if($tahun4==$tahun){ print 'selected'; }?>><?=$tahun;?></option>
												<?php } ?>
											</select>
										</td>
										<td>
											<select class="form-control" name="mp4" id="mp4" onchange="do_open(this.value,4)">
												<option value="">Sila pilih matapelajaran</option>
												<?php $rssijil->movefirst();
												while(!$rssijil->EOF){ ?>
												<option value="<?=$rssijil->fields['mpel_kod'];?>" <?php if($mp4==$rssijil->fields['mpel_kod']){ print 'selected'; }?>><?=$rssijil->fields['descripsi'];?></option>
												<?php $rssijil->movenext(); } ?>
											</select>
										</td>
										<td>
											<select class="form-control" name="gred4" id="gred4" onchange="on_chg(4)">
												<option value="">Sila pilih gred</option>
												<?php $rsGred->movefirst();
												while(!$rsGred->EOF){ ?>
												<option value="<?=$rsGred->fields['GRED'];?>" <?php if($gred4==$rsGred->fields['GRED']){ print 'selected'; } ?>><?=$rsGred->fields['GRED'];?></option>	
												<?php $rsGred->movenext(); } ?>
											</select>
										</td>
										<td>
										<?php if(!empty($spm_id4)){ ?>
										<img src="../images/trash.png" title="Hapus maklumat matapelajaran & gred" style="cursor: pointer;" class="btn" 
										height="35" onclick="do_hapus('akademik/sql_akademik.php?frm=ULANGAN&pro=ULANGAN_DEL&sid=<?=$spm_id4;?>&id_pemohon=<?=$_SESSION['SESS_UID'];?>')">
										<?php } ?>	
										</td>

									</tr>
									<tr><td colspan="4">
									<div class="col-sm-12"  style="padding-bottom:5px">
										<table width="100%" id="tambahan4">
											<tr >
												<td>
													<label for="nama" class="col-sm-12 control-label">Jenis</label><br><br>
												</td>
												<td colspan="2">
													<select name="bm4" id="bm4" class="form-control">
														<option value="">Sila Pilih</option>
														<option value="1" <?php if($bm4=='1'){ print 'selected'; } ?>>Bahasa Melayu Kertas Julai / SPM Ulangan</option>
														<!--<option value="3" <?php if($bm4=='3'){ print 'selected'; } ?>>Bahasa Melayu di Peringkat STPM/STAM</option>-->
													</select>
												</td>
											</tr>
											<tr style="padding-bottom:5px">
												<td><label for="nama" class="col-sm-12 control-label">Ujian Lisan</label>
												</td>
												<td colspan="2">
													<select name="lisan4" id="lisan4" class="form-control">
														<option value="">Sila Pilih</option>
														<option value="L" <?php if($lisan4=='L'){ print 'selected'; } ?>>Lulus</option>
														<option value="G" <?php if($lisan4=='G'){ print 'selected'; } ?>>Gagal</option>
													</select>
												</td>
											</tr>
										</table>
									</div>
									</td></tr>

								</table>



							</div>

							<?php
							// $conn->debug=true;
							$rsSijil = $conn->query("SELECT * FROM $schema2.`calon_sijil` WHERE `jenis_sijil`='ULANG' AND `id_pemohon`=".tosql($uid));
							//if(empty($rsSijil->fields['sijil_nama'])){ $sijil1="../upload_doc/sijil_spm.jpg"; }
							//else { $sijil1 = "/upload/".$uid."/".$rsSijil->fields['sijil_nama']; }

							if(empty($rsSijil->fields['sijil_nama'])){ $sijil_pic ="/var/www/myspp/upload_doc/sijil_spm.jpg"; }
							else { $sijil_pic = "/var/www/upload/".$uid."/".$rsSijil->fields['sijil_nama']; }
							if (file_exists($sijil_pic)){
    								$b64image = base64_encode(file_get_contents($sijil_pic));
     								$sijil1 = "data:image/png;base64,$b64image";
							}

							// print $sijil1;
							?>
							<div class="col-sm-4" align="center" style="border: 2px solid black; padding: 10px; border-radius: 25px;">
								<h6><b>Sijil SPM Ulangan</b></h6>
								<img src="<?=$sijil1;?>" width="100%" height="400">
								<?php if(!empty($rsSijil->fields['sijil_nama'])){ print $rsSijil->fields['sijil_nama']; } ?><br>
								<input type="file" name="file1"  id="file1" class="form-control" value="" onchange="do_input()">
								<small style="color: red;">Hanya menerima format png,jpg,jpeg @ gif dan tidak melebihi 300kb</small>
							</div>
							<!-- <div class="col-sm-4" align="center" style="border: 2px solid black; padding: 10px; border-radius: 25px;">
								<img src="<?=$sijil;?>" width="100%" height="400">
								<input type="file" name="" class="form-control">
							</div> -->

						</div>
					</div>
					
					<div class="modal-footer" style="padding:0px;">
						<button type="button" id="simpan" class="btn btn-primary mt-sm mb-sm" onclick="do_save('SAVE','')"><i class="fa fa-save"></i> Simpan</button>
						&nbsp;
						<?php	if(!empty($tahun1)){ ?>
						<label class="btn btn-danger" onclick="do_hapus('akademik/sql_akademik.php?frm=ULANGAN&pro=CLEAR&kep=<?=$actions;?>&id_pemohon=<?=$_SESSION['SESS_UID'];?>')">Hapus</label>
						<?php } ?>
						<input type="hidden" name="progid" id="progid" value="<?php //print $progid;?>" />
						<input type="hidden" name="proses" value="<?php //print $proses;?>" />
						<input type="hidden" name="vals1" id="vals1" value="<?=$vals1;?>" />
						<input type="hidden" name="vals2" id="vals2" value="<?=$vals2;?>" />
						<input type="hidden" name="vals3" id="vals3" value="<?=$vals3;?>" />
						<input type="hidden" name="vals4" id="vals4" value="<?=$vals4;?>" />

						<input type="hidden" name="spm_id1" id="spm_id1" value="<?=$spm_id1;?>" />
						<input type="hidden" name="spm_id2" id="spm_id2" value="<?=$spm_id2;?>" />
						<input type="hidden" name="spm_id3" id="spm_id3" value="<?=$spm_id3;?>" />
						<input type="hidden" name="spm_id4" id="spm_id4" value="<?=$spm_id4;?>" />
					</div>
				</div>

			
			</div>
		</div>
	     

<?php if($mp1=="101"){ ?>
<script language="javascript" type="text/javascript">
	document.getElementById("tambahan1").style.display = "block";
</script>
<?php } else { ?>
<script language="javascript" type="text/javascript">
	document.getElementById("tambahan1").style.display = "none";
</script>
<?php } ?>

<?php if($mp2=="101"){ ?>
<script language="javascript" type="text/javascript">
	document.getElementById("tambahan2").style.display = "block";
</script>
<?php } else { ?>
<script language="javascript" type="text/javascript">
	document.getElementById("tambahan2").style.display = "none";
</script>
<?php } ?>

<?php if($mp3=="101"){ ?>
<script language="javascript" type="text/javascript">
	document.getElementById("tambahan3").style.display = "block";
</script>
<?php } else { ?>
<script language="javascript" type="text/javascript">
	document.getElementById("tambahan3").style.display = "none";
</script>
<?php } ?>

<?php if($mp4=="101"){ ?>
<script language="javascript" type="text/javascript">
	document.getElementById("tambahan4").style.display = "block";
</script>
<?php } else { ?>
<script language="javascript" type="text/javascript">
	document.getElementById("tambahan4").style.display = "none";
</script>
<?php } ?>

