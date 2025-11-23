<?php //include '../connection/common.php'; ?>
<?php //include '../connection/common.php'; ?>
<script language="javascript">
function set_spm(fields, vals, ty){
	$.ajax({
        url:'akademik/sql_akademik.php?frm=SPM&pro=UPDATE&fields='+fields+'&vals='+vals+'&ty='+ty,
		type:'POST',
		data: $("form").serialize(),
		//data: datas,
		success: function(data){
			console.log(data);
			if(ty=='R'){
				reload = window.location; 
				window.location = reload;
			}
		}
	});
}

function save_spm(val){
	if(val==1){ 
		var spm_tahun_1 = $('#spm_tahun_1').val();
		var spm_jenis_sijil_1 = $('#spm_jenis_sijil_1').val();
		var srp_pangkat = $('#spm_pangkat_1').val();
    } else {
    	var spm_tahun_1 = $('#spm_tahun_2').val();
		var spm_jenis_sijil_1 = $('#spm_jenis_sijil_2').val();
		var srp_pangkat = $('#spm_pangkat_2').val();
    }
    if(spm_tahun_1.trim() =='' && spm_jenis_sijil_1.trim() == ''){
        // alert('Sila pilih maklumat jenis sijil.');
        alert_msg('Sila pilih maklumat jenis sijil.');
        $('#'+spm_jenis_sijil_1).focus(); return false;
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
	        url:'akademik/sql_akademik.php?frm=SPM&pro=SAVE',
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
// print_r($data);
$uid = $data['id_pemohon'];
$tahun = $data['spm_tahun_1'];
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
						  <button class="btn btn-primary form-control" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample" title="Sila klik untuk membaca arahan berkaitan kemasukan data akademik SPM">
						    ARAHAN:
						  </button>
						</p>
						<!-- <div class="collapse" id="collapseExample"> -->
						  <div class="card card-body">
								<label for="nama" class="col-sm-12 control-label"><b>ARAHAN : Sila Masukkan 10 Matapelajaran Dengan Keputusan Terbaik</b>
									<ul>
										<li>Sijil Am Pelajaran (SAP) adalah tidak setaraf dengan SPM/SPVM/SVM dan oleh itu pemohon yang memilikinya, sila isikan Ruangan Peperiksaan Tambahan</li>
										<li>Sekiranya anda mengambil SPM mengikut sistem terbuka lebih dari sekali, isikan keputusan yang dikumpulkan dalam dua (2) kali peperiksaan bagi tempoh tiga (3) tahun berturut-turut Peperiksaan Kali Pertama dan Peperiksaan Kali Kedua</li>
										<li>Bagi calon yang mengambil peperiksaan SPM ulangan/ kali kedua dalam tempoh melebihi tiga (3) tahun berturut-turut, keputusan terbaik bagi subjek Bahasa Melayu boleh diisi di submenu "Peperiksaan Tambahan"</li>
										<li>Sila lihat Kelayakan Sijil Pelajaran Malaysia (SPM) mengikut sistem terbuka bagi maksud perlantikan ke dalam Perkhidmatan Kerajaan</li>
									</ul>
									<hr>
								</label>

						  </div>
						<!-- </div> -->
					</div>


					<?php 
				    $hrefs1 = "index.php?data=".base64_encode('akademik/spm;MAKLUMAT AKADEMIK;Maklumat SPM/SPVM/SPM(V);;1;;');  
				    $hrefs2 = "index.php?data=".base64_encode('akademik/spm;MAKLUMAT AKADEMIK;Maklumat SPM/SPVM/SPM(V);;2;;');  
				    if($actions==2){ $bg1= ''; $bg2='style="color: blue;"'; }
				    else { $bg1= 'style="color: blue;"'; $bg2=''; }
				    ?>
				        
		            <input type="hidden" name="plik_id" id="plik_id" value="<?php print $id;?>" readonly="readonly"/>
		    
                    <ul class="nav nav-tabs" role="tablist">
                        <li <?php if($actions=="1"){ print 'class="active"'; }?>><a href="<?=$hrefs1;?>"><b <?=$bg1;?>>Maklumat Peperiksaan Kali Pertama</b></a></li>
                        <?php //if(!empty($data['spm_tahun_2'])){ ?>
                        	<li <?php if($actions=="2"){ print 'class="active"'; }?>><a href="<?=$hrefs2;?>"><b <?=$bg2;?>>Maklumat Peperiksaan Kali Kedua</b></a></li>
                    	<?php //} ?>


                        <?php if(empty($data['spm_tahun_2'])){ ?>
                        <!-- <li <?php if($actions=="2"){ print 'class="active"'; }?>> -->
                        	<!-- <a href="akademik/spm_add.php?id_pemohon=<?=$uid;?>&tahun=<?=$data['spm_tahun_1'];?>" data-toggle="modal" data-target="#myModal" title="Tambah Maklumat" class="fa" data-backdrop=""><button type="button" class="btn btn-primary"><i class=" fa fa-plus-square"></i> <font style="font-family:Verdana, Geneva, sans-serif"> Tambah Maklumat Peperiksaan Ke-2</font></button></a> -->
						<!-- </li> -->
                    	<?php } ?>

                    </ul>
                    

                    <div class="tab-content tabs">
                        <?php 
                        if($actions==1){ 
                        	include 'akademik/spm1.php';
                        } else if($actions=='2'){
                            include 'akademik/spm2.php';
                        }
                        ?>
                    </div>
				</div>
			</div>

		</div>
	</div>
	     

<script language="javascript" type="text/javascript">
//document.frm.gsasar_nama.focus();
</script>		 
