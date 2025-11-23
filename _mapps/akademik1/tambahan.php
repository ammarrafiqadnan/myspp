<?php
include 'akademik/sql_akademik.php';
$data = get_exam($conn,$_SESSION['SESS_UID']);
print_r($data);
$tahun_u = $data['spm_tahun_1'];

$rsSijil = $conn->query("SELECT * FROM $schema2.`calon_sijil` WHERE `jenis_sijil`='EXT' AND `id_pemohon`=".tosql($uid));
if(empty($rsSijil->fields['sijil_nama'])){ $sijil="../upload_doc/PMR_Mock_Result_Statement_Certificate.png"; }
else { $sijil = "../uploads_doc/".$uid."/".$rsSijil->fields['sijil_nama']; }
?>
<script type="text/javascript">
function do_save(){
    var reg = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
    var tahun1 = $('#tahun1').val();
    var mp1 = $('#mp1').val();
    var gred1 = $('#gred1').val();
    var tahun2 = $('#tahun2').val();
    var mp2 = $('#mp2').val();
    var gred2 = $('#gred2').val();
    var tahun3 = $('#tahun3').val();
    var mp3 = $('#mp3').val();
    var gred3 = $('#gred3').val();
    var tahun4 = $('#tahun4').val();
    var mp4 = $('#mp4').val();
    var gred4 = $('#gred4').val();
	var msg = '';
    
    if(tahun1.trim() == '' || mp1.trim() == '' || gred1.trim() == '' ){
        msg = msg+"\n- Sila lengkapkan maklumat peperiksaan tambahan.";
        $('#tahun1').css("border-color","#f00");
        $('#mp1').css("border-color","#f00");
        $('#gred1').css("border-color","#f00");
    } 
	if(msg.trim() !=''){ 
		alert_msg_html(msg);
	} else {
		var fd = new FormData();
        //var files1 = $('#file_profesional')[0].files[0];
        // var files2 = $('#upload_id2')[0].files[0];
        //fd.append('file_profesional',files1);
        // fd.append('upload_id2',files2);

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
		<header class="panel-heading"  style="background-color:rgb(38, 167, 228)">
			<h6 class="panel-title"><font color="#000000" size="3"><b><?php print strtoupper($menu);?></b></font></h6>
		</header>
		<div class="panel-body">
			<div class="box-body">

			<input type="hidden" name="pemantauan_id" id="pemantauan_id" value="<?php print $id;?>" readonly="readonly"/>

				<div class="col-md-12">

					<?php include 'biodata/biodata_view.php'; ?>

					<div class="form-group">
						<div class="row">
							<p>
							  <button class="btn btn-primary form-control" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample" title="Sila klik untuk membaca arahan berkaitan kemasukan data akademik SPM">
							    ARAHAN:
							  </button>
							</p>
						<!-- <div class="collapse" id="collapseExample"> -->
						  <div class="card card-body">
								<label for="nama" class="col-sm-12 control-label"><b>ARAHAN : Sila Masukkan maklumat pepriksaan tambahan</b>
									<ul>
									<li>Peperiksaan Bahasa Melayu, Matematik, Sejarah bagi Peperiksaan Julai sahaja</li>
									</ul>
								</label>

						  </div>
						<!-- </div> -->

					</div>
					<hr>
					<?php 
					$rssijil = $conn->query("SELECT * FROM $schema1.`ref_paper_julai` WHERE `sah_yt`='Y'");
	
					?>
					<div class="form-group">
						<div class="row">
							<div class="col-sm-8">
								
								<div class="row">
									<div class="col-sm-2" style="padding-bottom:5px">
										<select class="form-control" name="tahun1" id="tahun1">
											<option value="">Sila pilih tahun</option>
											<?php for($tahun=date("Y");$tahun>$tahun_u;$tahun--){ ?>
											<option value="<?=$tahun;?>" <?php if($tahun1==$tahun){ print 'selected'; }?>><?=$tahun;?></option>
											<?php } ?>
										</select>
									</div>
									<div class="col-sm-6" style="padding-bottom:5px">
										<select class="form-control" name="mp1" id="mp1">
											<option value="">Sila pilih matapelajaran</option>
											<?php $rssijil->movefirst();
											while(!$rssijil->EOF){ ?>
											<option value="<?=$rssijil->fields['mpel_kod'];?>" <?php if($mp1==$rssijil->fields['mpel_kod']){ print 'selected'; }?>><?=$rssijil->fields['descripsi'];?></option>
											<?php $rssijil->movenext(); } ?>
										</select>
									</div>
									<div class="col-sm-4" style="padding-bottom:5px">
										<select class="form-control" name="gred1" id="gred1">
											<option value="">Sila pilih gred</option>
											<?php for($bil=1;$bil<=9;$bil++){ ?>
											<option value="<?=$bil;?>" <?php if($gred1==$bil){ print 'selected'; }?>><?=$bil;?></option>
											<?php } ?>
										</select>
									</div>
								</div>
								
								<div class="row">
									<div class="col-sm-2" style="padding-bottom:5px">
										<select class="form-control" name="tahun2" id="tahun2">
											<option value="">Sila pilih tahun</option>
											<?php for($tahun=date("Y");$tahun>$tahun_u;$tahun--){ ?>
											<option value="<?=$tahun;?>" <?php if($tahun1==$tahun){ print 'selected'; }?>><?=$tahun;?></option>
											<?php } ?>
										</select>
									</div>
									<div class="col-sm-6" style="padding-bottom:5px">
										<select class="form-control" name="mp2" id="mp2">
											<option value="">Sila pilih matapelajaran</option>
											<?php $rssijil->movefirst();
											while(!$rssijil->EOF){ ?>
											<option value="<?=$rssijil->fields['mpel_kod'];?>" <?php if($mp1==$rssijil->fields['mpel_kod']){ print 'selected'; }?>><?=$rssijil->fields['descripsi'];?></option>
											<?php $rssijil->movenext(); } ?>
										</select>
									</div>
									<div class="col-sm-4" style="padding-bottom:5px">
										<select class="form-control" name="gred2" id="gred2">
											<option value="">Sila pilih gred</option>
											<?php for($bil=1;$bil<=9;$bil++){ ?>
											<option value="<?=$bil;?>" <?php if($gred1==$bil){ print 'selected'; }?>><?=$bil;?></option>
											<?php } ?>
										</select>
									</div>
								</div>
								
								<div class="row">
									<div class="col-sm-2" style="padding-bottom:5px">
										<select class="form-control" name="tahun3" id="tahun3">
											<option value="">Sila pilih tahun</option>
											<?php for($tahun=date("Y");$tahun>$tahun_u;$tahun--){ ?>
											<option value="<?=$tahun;?>" <?php if($tahun1==$tahun){ print 'selected'; }?>><?=$tahun;?></option>
											<?php } ?>
										</select>
									</div>
									<div class="col-sm-6" style="padding-bottom:5px">
										<select class="form-control" name="mp3" id="mp3">
											<option value="">Sila pilih matapelajaran</option>
											<?php $rssijil->movefirst();
											while(!$rssijil->EOF){ ?>
											<option value="<?=$rssijil->fields['mpel_kod'];?>" <?php if($mp1==$rssijil->fields['mpel_kod']){ print 'selected'; }?>><?=$rssijil->fields['descripsi'];?></option>
											<?php $rssijil->movenext(); } ?>
										</select>
									</div>
									<div class="col-sm-4" style="padding-bottom:5px">
										<select class="form-control" name="gred3" id="gred3">
											<option value="">Sila pilih gred</option>
											<?php for($bil=1;$bil<=9;$bil++){ ?>
											<option value="<?=$bil;?>" <?php if($gred1==$bil){ print 'selected'; }?>><?=$bil;?></option>
											<?php } ?>
										</select>
									</div>
								</div>
								
								<div class="row">
									<div class="col-sm-2" style="padding-bottom:5px">
										<select class="form-control" name="tahun4" id="tahun4">
											<option value="">Sila pilih tahun</option>
											<?php for($tahun=date("Y");$tahun>$tahun_u;$tahun--){ ?>
											<option value="<?=$tahun;?>" <?php if($tahun1==$tahun){ print 'selected'; }?>><?=$tahun;?></option>
											<?php } ?>
										</select>
									</div>
									<div class="col-sm-6" style="padding-bottom:5px">
										<select class="form-control" name="mp4" id="mp4">
											<option value="">Sila pilih matapelajaran</option>
											<?php $rssijil->movefirst();
											while(!$rssijil->EOF){ ?>
											<option value="<?=$rssijil->fields['mpel_kod'];?>" <?php if($mp1==$rssijil->fields['mpel_kod']){ print 'selected'; }?>><?=$rssijil->fields['descripsi'];?></option>
											<?php $rssijil->movenext(); } ?>
										</select>
									</div>
									<div class="col-sm-4" style="padding-bottom:5px">
										<select class="form-control" name="gred4" id="gred4">
											<option value="">Sila pilih gred</option>
											<?php for($bil=1;$bil<=9;$bil++){ ?>
											<option value="<?=$bil;?>" <?php if($gred1==$bil){ print 'selected'; }?>><?=$bil;?></option>
											<?php } ?>
										</select>
									</div>
								</div>



							</div>
							<div class="col-sm-4" align="center">
								<img src="<?=$sijil;?>" width="300" height="400">
								<input type="file" name="" class="form-control">
							</div>

						</div>
					</div>
					
					<div class="modal-footer" style="padding:0px;">
						<button type="button" id="simpan" class="btn btn-primary mt-sm mb-sm" onclick="do_save('SAVE','')"><i class="fa fa-save"></i> Simpan</button>
						&nbsp;
						<!-- <button type="button" class="btn btn-default" onclick="do_page('index.php?data=<?php print base64_encode('maklumat/pemantauan_list;DATA;Maklumat Pemantauan;;;;'); ?>')">
							<i class="fa fa-spinner" style="margin:0px;"></i> Kembali</button> -->
						<input type="hidden" name="progid" id="progid" value="<?php print $progid;?>" />
						<input type="hidden" name="proses" value="<?php print $proses;?>" />
					</div>
				</div>

			
			</div>
		</div>
	     

<script language="javascript" type="text/javascript">
//document.frm.gsasar_nama.focus();
</script>		 
