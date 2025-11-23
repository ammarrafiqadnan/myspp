<?php //include '../connection/common.php'; ?>
<?php //include '../connection/common.php'; ?>
<script language="javascript">
function set_stpm(fields, vals, ty){
	// var stp_tahun_1 = $('#stp_tahun_1').val();
	// alert(ty);
	$.ajax({
        url:'akademik/sql_akademik.php?frm=STPM&pro=UPDATE&fields='+fields+'&vals='+vals+'&ty='+ty,
		type:'POST',
        dataType: 'json',
        beforeSend: function () {
            $('.btn-primary').attr("disabled","disabled");
            $('.modal-body').css('opacity', '.5');
        },
		data: $("form").serialize(),
		//data: datas,
		success: function(data){
			// console.log(data);
			// if(ty=="R"){
			// alert(data);
			if(data=='OK'){
				// alert(ty);
				reload = window.location; 
				window.location = reload;
			}
		}
	});

				reload = window.location; 
				window.location = reload;
}

function save_stpm(val){
	if(val==1){ 
		var stp_tahun_1 = $('#stp_tahun_1').val();
		var stp_jenis_1 = $('#stp_jenis_1').val();
	} else {
		var stp_tahun_1 = $('#stp_tahun_2').val();
		var stp_jenis_1 = $('#stp_jenis_2').val();
	}

    if(stp_tahun_1.trim() =='' && stp_jenis_1.trim() == ''){
        // alert('Sila pilih maklumat jenis sijil.');
        alert_msg('Sila pilih maklumat jenis sijil.');
        $('#stp_jenis_1').focus(); return false;
	} else { 
		var fd = new FormData();
        var files1 = $('#file_pmr')[0].files[0];
        // var files2 = $('#upload_id2')[0].files[0];
        fd.append('file_pmr',files1);
        // fd.append('upload_id2',files2);

        var other_data = $('form').serializeArray();
		$.each(other_data,function(key,input){
		    fd.append(input.name,input.value);
		});

        $.ajax({
	        url:'akademik/sql_akademik.php?frm=STPM&pro=SAVE',
			type:'POST',
	        //dataType: 'json',
	        beforeSend: function () {
	            // $('.btn-primary').attr("disabled","disabled");
	            // $('.modal-body').css('opacity', '.5');
	        },
			// data: $("form").serialize(),
			data:  fd,
            contentType: false,
            cache: false,
            processData:false,
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
}

</script>
<?php
include 'akademik/sql_akademik.php';
$data = get_exam($conn,$_SESSION['SESS_UID']);
print_r($data);
$uid = $data['id_pemohon'];
$tahun = $data['stp_tahun_1'];
?>
		<header class="panel-heading"  style="background-color:rgb(38, 167, 228)">
			<h6 class="panel-title"><font color="#000000" size="3"><b><?php print strtoupper($menu);?></b></font></h6>
		</header>
		<div class="panel-body">
			<div class="box-body">

			<input type="hidden" name="id_pemohon" id="id_pemohon" value="<?php print $uid;?>" readonly="readonly"/>

				<div class="col-md-12">

					<?php include 'biodata/biodata_view.php'; ?>

					<div class="form-group">
						<div class="row">
							<p>
							  <button class="btn btn-primary form-control" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample" title="Sila klik untuk membaca arahan berkaitan kemasukan data akademik STPM">
							    ARAHAN:
							  </button>
							</p>
							<!-- <div class="collapse" id="collapseExample"> -->
							  <div class="card card-body">
								<label for="nama" class="col-sm-12 control-label"><b>ARAHAN : Sila Masukkan 10 Matapelajaran Dengan Keputusan Terbaik</b>
									<ul>
										<li>Calon STPM : Sekiranya mengambil peperiksaan melebihi satu kali dalam tempoh 3 tahun, sila isikan keputusan dua tahun terbaik dalam ruangan yang disediakan.</li>
										<!-- <li>Calon STP/HSC : Sekiranya mengambil peperiksaan melebihi satu kali, sila isikan hanya satu keputusan sahaja dalam ruangan yang disediakan.</li> -->
									</ul>
									<hr>
								</label>

							  </div>
							<!-- </div> -->
						</div>


					<?php 
					$title_2 = '';
				    $hrefs1 = "index.php?data=".base64_encode('akademik/stpm;MAKLUMAT AKADEMIK;Maklumat STPM/STP/HSC;;1;;');  
				    $hrefs2 = "index.php?data=".base64_encode('akademik/stpm;MAKLUMAT AKADEMIK;Maklumat STPM/STP/HSC;;2;;');  
				    if($actions==2){ $bg1= ''; $bg2='style="color: blue;"'; }
				    else { $bg1= 'style="color: blue;"'; $bg2=''; }

				    if(empty($data['stp_tahun_1'])){ $hrefs2="#"; $title_2 = "Sila isikan maklumat STPM kali pertama terlebih dahulu"; }

				    ?>
				        
		    
                    <ul class="nav nav-tabs" role="tablist">
                        <li <?php if($actions=="1"){ print 'class="active"'; }?>><a href="<?=$hrefs1;?>"><b <?=$bg1;?>>Maklumat Peperiksaan Kali Pertama</b></a></li>
                        <?php //if(!empty($data['stp_tahun_2'])){ ?>
                        	<li <?php if($actions=="2"){ print 'class="active"'; }?>><a href="<?=$hrefs2;?>" title="<?=$title_2;?>"><b <?=$bg2;?>>Maklumat Peperiksaan Kali Kedua</b></a></li>
                    	<?php //} ?>


                        <?php if(empty($data['stp_tahun_2'])){ ?>
                        <!-- <li <?php if($actions=="2"){ print 'class="active"'; }?>> -->
                        	<!-- <a href="akademik/stpm_add.php?id_pemohon=<?=$uid;?>&tahun=<?=$data['stp_tahun_1'];?>" data-toggle="modal" data-target="#myModal" title="Tambah Maklumat" class="fa" data-backdrop=""><button type="button" class="btn btn-primary"><i class=" fa fa-plus-square"></i> <font style="font-family:Verdana, Geneva, sans-serif"> Tambah Maklumat Peperiksaan Ke-2</font></button></a> -->
						<!-- </li> -->
                    	<?php } ?>

                    </ul>
                    

                    <div class="tab-content tabs">
                        <?php 
                        if($actions==1){ 
                        	include 'akademik/stpm1.php';
                        } else if($actions=='2'){
                            include 'akademik/stpm2.php';
                        }
                        ?>
                    </div>
                    
				</div>

	
			</div>
		</div>
	     

<script language="javascript" type="text/javascript">
//document.frm.gsasar_nama.focus();
</script>		 
