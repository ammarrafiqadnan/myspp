<?php //include '../connection/common.php'; ?>
<script language="javascript">
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

function save_univ(){
	var bil_keputusan1 = $('#bil_keputusan1').val();
	var tahun1 = $('#tahun1').val();
	var peringkat1 = $('#peringkat1').val();
	var inst_keluar_sijil1 = $('#inst_keluar_sijil1').val();
	var pengkhususan1 = $('#pengkhususan1').val();
    
    if(tahun1.trim() =='' && bil_keputusan1.trim() == ''){
        alert_msg('Sila pilih maklumat tahun.');
        $('#tahun1').focus(); return false;
    } else if(peringkat1.trim() ==''){
        alert_msg('Sila pilih maklumat peringkat kelulusan.');
        $('#peringkat1').focus(); return false;
    } else if(inst_keluar_sijil1.trim() ==''){
        alert_msg('Sila pilih maklumat institusi yang mengeluarkan sijil.');
        $('#inst_keluar_sijil1').focus(); return false;
    } else if(pengkhususan1.trim() ==''){
        alert_msg('Sila pilih maklumat pengkhususan.');
        $('#pengkhususan1').focus(); return false;
	} else { 

        $.ajax({
	        url:'akademik/sql_akademik.php?frm=UNIV&pro=SAVE',
			type:'POST',
	        //dataType: 'json',
	        beforeSend: function () {
	            // $('.btn-primary').attr("disabled","disabled");
	            // $('.modal-body').css('opacity', '.5');
	        },
			// data:  formData,
			data: $("form").serialize(),
			// data.append('file_pmr', $('input[type=file]')[0].files[0]),
			// files: true,
            // contentType: false,
            // cache: false,
            // processData:false,
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
?>

		<header class="panel-heading"  style="background-color:rgb(209 29 29)">
			<h6 class="panel-title"><font color="#000000" size="3"><b><?php print strtoupper($menu);?></b></font></h6>
		</header>
		<div class="panel-body">
			<div class="box-body">

			<input type="hidden" name="id_pemohon" id="id_pemohon" value="<?php print $uid;?>" readonly="readonly"/>

				<div class="col-md-12">

					<?php include 'biodata/biodata_view.php'; ?>

					<div class="form-group">
						<div class="row">
							<label for="nama" class="col-sm-12 control-label"><b>ARAHAN : </b>
								<ul>
									<li>Pemohon dikehendaki menyemak kelayakan yang dimiliki dengan Unit Pengiktirafan Kelayakan Perkhidmatan Awam, Bahagian Pengurusan Sumber Manusia, Kementerian Pendidikan Tinggi sebelum mengisi maklumat akademik pengajian tinggi dalam SPA8i untuk memastikan kelayakan tersebut diiktiraf oleh Kerajaan untuk tujuan lantikan ke Perkhidmatan Awam. Kegagalan berbuat demikian boleh menyebabkan tawaran pelantikan dibatalkan sekiranya didapati kelayakan yang dimiliki tidak diiktiraf oleh Kerajaan. Sila layari laman web Pengiktirafan Kelayakan atau Agensi Kelayakan Malaysia (MQA) dengan pautan yang boleh diakses Sistem Daftar Kelayakan Malaysia.</li>
									<li>Hanya pemohon yang telah memiliki kelayakan akademik dan mendapat kelulusan Senat Universiti, dibenarkan memohon jawatan dalam perkhidmatan awam.</li>
									<li>Pilihan pengkhususan PENDIDIKAN perlu dipilih oleh calon yang berkelayakan/mempunyai iktisas di dalam bidang pendidikan.</li>
									<li>Sebelum mengisi maklumat akademik pengajian tinggi, pemohon dikehendaki memastikan kelayakan yang dimiliki adalah diiktiraf oleh kerajaan untuk tujuan lantikan ke dalam perkhidmatan awam.<br>
          							Jika Institusi Institusi yang mengeluarkan sijil atau Bidang Pengkhususan tiada di dalam senarai, sila adukan kepada SISPAA-SPP.</li>
								</ul>
							</label>
						</div>
					</div>

					<?php 
					$conn->debug=true;
					$rsUniv = $conn->query("SELECT * FROM $schema2.`calon_ipt` WHERE `bil_keputusan`='1' AND `id_pemohon`=".tosql($uid));
					$bilUniv1 = $rsUniv->recordcount();
					$rsUniv2 = $conn->query("SELECT * FROM $schema2.`calon_ipt` WHERE `bil_keputusan`='2' AND `id_pemohon`=".tosql($uid));
					$bilUniv2 = $rsUniv2->recordcount();
					$rsUniv3 = $conn->query("SELECT * FROM $schema2.`calon_ipt` WHERE `bil_keputusan`='3' AND `id_pemohon`=".tosql($uid));
					$bilUniv3 = $rsUniv3->recordcount();
					$conn->debug=false;
					?>					
					<div class="row">
						<input type="text" name="bil_keputusan1" id="bil_keputusan1" value="<?=$rsUniv->fields['bil_keputusan'];?>">
						<input type="text" name="bil_keputusan2" id="bil_keputusan2" value="<?=$rsUniv2->fields['bil_keputusan'];?>">
						<input type="text" name="bil_keputusan3" id="bil_keputusan3" value="<?=$rsUniv3->fields['bil_keputusan'];?>">

			        	<div class="col-md-12">
				            <div class="tab" role="tabpanel">
				                <!-- Nav tabs -->
				                <ul class="nav nav-tabs" role="tablist">
				                    <li role="presentation" class="active"><a href="#" aria-controls="home" role="tab" data-toggle="tab">
				                    	<b>Maklumat Keputusan - 1</b></a></li>
				                    <?php if(!empty($bilUniv1)){ ?>
					                <div style="float: right;">
					                
					                	<button type="button" class="btn btn-primary" onclick="pro_result('ADD', '2')">
						                <i class=" fa fa-plus-square"></i> <font style="font-family:Verdana, Geneva, sans-serif"> Tambah Maklumat Keputusan Ke-2</font></button>
									
					                </div>
					            	<?php } ?>
				                </ul>
				                <div class="tab-content tabs">
				                    <?php include 'akademik/univ1.php';?>
				                </div>
				            </div>
			        	</div>

			        	<?php if(!empty($bilUniv2)){ ?>
			        	<div class="col-md-12">
				            <div class="tab" role="tabpanel">
				                <!-- Nav tabs -->
				                <ul class="nav nav-tabs" role="tablist">
				                    <li role="presentation" class="active"><a href="#" aria-controls="home" role="tab" data-toggle="tab">
				                    	<b>Maklumat Keputusan - 2</b></a></li>
				                    <?php if(!empty($bilUniv2)){ ?>
					                <div style="float: right;">
					                	<?php if(empty($bilUniv3)){ ?>
						                	<button type="button" class="btn btn-danger" onclick="pro_result('DEL','2')">
							                <i class=" fa fa-plus-square"></i> <font style="font-family:Verdana, Geneva, sans-serif"> Hapus Maklumat Keputusan</font></button>
						                	&nbsp;&nbsp;
						            	<?php } ?>
					                	<button type="button" class="btn btn-primary" onclick="pro_result('ADD', '3')">
						                <i class=" fa fa-plus-square"></i> <font style="font-family:Verdana, Geneva, sans-serif"> Tambah Maklumat Keputusan Ke-3</font></button>
									
					                </div>
					            	<?php } ?>
				                </ul>
				                <div class="tab-content tabs">
				                    <?php include 'akademik/univ2.php';?>
				                </div>
				            </div>
			        	</div>
			        <?php } ?>
			        	
			        	<?php if(!empty($bilUniv3)){ ?>
			        	<div class="col-md-12">
				            <div class="tab" role="tabpanel">
				                <!-- Nav tabs -->
				                <ul class="nav nav-tabs" role="tablist">
				                    <li role="presentation" class="active"><a href="#" aria-controls="home" role="tab" data-toggle="tab">
				                    	<b>Maklumat Keputusan - 3</b></a></li>
				                    <?php if(!empty($bilUniv3)){ ?>
					                <div style="float: right;">
					                	<button type="button" class="btn btn-danger" onclick="pro_result('DEL','3')">
						                <i class=" fa fa-plus-square"></i> <font style="font-family:Verdana, Geneva, sans-serif"> Hapus Maklumat Keputusan</font></button>

					                	<!-- <button type="button" class="btn btn-primary" onclick="pro_result('ADD', '3')">
						                <i class=" fa fa-plus-square"></i> <font style="font-family:Verdana, Geneva, sans-serif"> Tambah Maklumat Keputusan Ke-3</font></button> -->
									
					                </div>
					            	<?php } ?>
				                </ul>
				                <div class="tab-content tabs">
				                    <?php include 'akademik/univ3.php';?>
				                </div>
				            </div>
			        	</div>
			        <?php } ?>


			    	</div>



					<div class="modal-footer" style="padding:0px;">
						<button type="button" id="simpan" class="btn btn-primary mt-sm mb-sm" onclick="save_univ('SAVE','')"><i class="fa fa-save"></i> Simpan</button>
						&nbsp;
						<input type="hidden" name="progid" id="progid" value="<?php print $progid;?>" />
						<input type="hidden" name="proses" value="<?php print $proses;?>" />
					</div>				

				</div>

			</div>
		</div>
	     

<script language="javascript" type="text/javascript">
//document.frm.gsasar_nama.focus();
</script>		 
