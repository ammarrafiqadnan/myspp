<?php //include '../connection/common.php'; ?>
<?php //include '../connection/common.php'; ?>
<script language="javascript">
function set_spm(fields, vals, ty){
	var spm_tahun_1 = $('#spm_tahun_1').val();
	var spm_jenis_sijil_1 = $('#spm_jenis_sijil_1').val();
	var spm_pangkat_1 = $('#spm_pangkat_1').val();
	if(spm_tahun_1.trim()!=''){
		var spm_tahun_2 = $('#spm_tahun_2').val();
		var spm_jenis_sijil_2 = $('#spm_jenis_sijil_2').val();
		var spm_pangkat_2 = $('#spm_pangkat_2').val();
	}

	$.ajax({
        url:'akademik/sql_akademik.php?frm=SPM&pro=UPDATE&fields='+fields+'&vals='+vals+'&ty='+ty,
		type:'POST',
        //dataType: 'json',
        // beforeSend: function () {
            //$('.btn-primary').attr("disabled","disabled");
            //$('.modal-body').css('opacity', '.5');
        // },
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

function save_spm(){
	var spm_tahun_1 = $('#spm_tahun_1').val();
	var spm_jenis_sijil_1 = $('#spm_jenis_sijil_1').val();
	var srp_pangkat = $('#srp_pangkat').val();
    
    if(spm_tahun_1.trim() =='' && spm_jenis_sijil_1.trim() == ''){
        // alert('Sila pilih maklumat jenis sijil.');
        alert_msg('Sila pilih maklumat jenis sijil.');
        $('#spm_jenis_sijil_1').focus(); return false;
	} else { 
		// var formData = new FormData($('#myspp')[0]);
		// formData.append('file_pmr', $('input[type=file]')[0].files[0]);
		// data:  formData;
		// var formData = new FormData();
		// formData.append('file_pmr', $('input[type=file]')[0].files[0]);
        // var files = $('#file_pmr')[0].files[0];
        // fd.append('file_pmr',files);
        // var formData = new FormData($('#myspp')[0]);
		// formData.append('file_pmr', $('input[type=file]')[0].files[0]);

        $.ajax({
	        url:'akademik/sql_akademik.php?frm=SPM&pro=SAVE',
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
$tahun = $data['spm_tahun_1'];
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
							<label for="nama" class="col-sm-12 control-label"><b>ARAHAN : Sila Masukkan 10 Matapelajaran Dengan Keputusan Terbaik</b>
								<ul>
									<li>Sijil Am Pelajaran (SAP) adalah tidak setaraf dengan SPM/SPM(V) dan oleh itu pemohon yang memilikinya, sila isikan Ruangan Peperiksaan Tambahan</li>
									<li>Sekiranya anda mengambil SPM mengikut sistem terbuka lebih dari sekali, isikan keputusan yang dikumpulkan dalam dua (2) kali peperiksaan bagi tempoh tiga (3) tahun berturut-turut Peperiksaan Kali Pertama dan Peperiksaan Kali Kedua</li>
									<li>Bagi calon yang mengambil peperiksaan SPM ulangan/ kali kedua dalam tempoh melebihi tiga (3) tahun berturut-turut, keputusan terbaik bagi subjek Bahasa Melayu boleh diisi di submenu "Peperiksaan Tambahan"</li>
									<li>Sila lihat Kelayakan Sijil Pelajaran Malaysia (SPM) mengikut sistem terbuka bagi maksud perlantikan ke dalam Perkhidmatan Kerajaan</li>
								</ul>
							</label>
						</div>
					</div>

					<div class="row">
			        	<div class="col-md-12">
				            <div class="tab" role="tabpanel">
				                <!-- Nav tabs -->
				                <ul class="nav nav-tabs" role="tablist">
				                    <li role="presentation" class="active"><a href="#" aria-controls="home" role="tab" data-toggle="tab">
				                    	<b>Maklumat Peperiksaan Kali Pertama</b></a></li>
<!-- 				                    <?php if(!empty($data['spm_tahun_2'])){ ?>
				                    <li role="presentation"><a href="index.php?data=YWthZGVtaWsvc3BtO01BS0xVTUFUIEFLQURFTUlLO01ha2x1bWF0IFNQTS9NQ0UvU1BWTS9TUE0oVik7Ozs7" aria-controls="profile" role="tab" data-toggle="tab">
				                    	<b>Maklumat Peperiksaan Kali Kedua</b></a></li>
				                    <?php } ?> -->
				                    <?php if(!empty($data['spm_tahun_1'])){ ?>
					                <div style="float: right;">
					                	<a href="akademik/spm_add.php?id_pemohon=<?=$uid;?>&tahun=<?=$data['spm_tahun_1'];?>" data-toggle="modal" data-target="#myModal" title="Tambah Maklumat" class="fa" data-backdrop=""><button type="button" class="btn btn-primary">
						                <i class=" fa fa-plus-square"></i> <font style="font-family:Verdana, Geneva, sans-serif"> Tambah Maklumat Peperiksaan Ke-2</font></button>
									</a>
									<!-- <label class="btn btn-primary">Tambah Maklumat Peperiksaan Ke-2</label> -->
					                </div>
					            	<?php } ?>
				                </ul>
				                <!-- Tab panes -->
				                <div class="tab-content tabs">
				                    <!-- <div role="tabpanel" class="tab-pane fade in active"> -->
				                        <?php include 'akademik/spm1.php';?>
				                    <!-- </div> -->

				                </div>
				            </div>
			        	</div>
			    	</div>

			    	<?php if(!empty($data['spm_tahun_2'])){ ?>
					<div class="row">
			        	<div class="col-md-12">
				            <div class="tab" role="tabpanel">
				                <!-- Nav tabs -->
				                <ul class="nav nav-tabs" role="tablist">
				                    <li role="presentation" class="active"><a href="#" aria-controls="home" role="tab" data-toggle="tab">
				                    	<b>Maklumat Peperiksaan Kali Ke-2</b></a></li>
				                    <?php if(!empty($data['spm_tahun_1'])){ ?>
					                <div style="float: right;">
					                	<label class="btn btn-danger" onclick="do_hapus('akademik/sql_akademik.php?frm=SPM&pro=SPM2_DEL&id_pemohon=<?=$uid;?>')">Hapus Maklumat</label>
					                </div>
					            	<?php } ?>
<!-- 				                    <?php if(!empty($data['spm_tahun_2'])){ ?>
				                    <li role="presentation"><a href="index.php?data=YWthZGVtaWsvc3BtO01BS0xVTUFUIEFLQURFTUlLO01ha2x1bWF0IFNQTS9NQ0UvU1BWTS9TUE0oVik7Ozs7" aria-controls="profile" role="tab" data-toggle="tab">
				                    	<b>Maklumat Peperiksaan Kali Kedua</b></a></li>
				                    <?php } ?> -->
				                </ul>
				                <!-- Tab panes -->
				                <div class="tab-content tabs">
				                    <!-- <div role="tabpanel2" class="tab-pane fade"> -->
				                        <?php include 'akademik/spm2.php';?>
				                    <!-- </div> -->

				                </div>
				            </div>
			        	</div>
			    	</div>
			    	<?php } ?>
					
				</div>

					<div class="modal-footer" style="padding:0px;">
						<button type="button" id="simpan" class="btn btn-primary mt-sm mb-sm" onclick="save_spm()"><i class="fa fa-save"></i> Simpan</button>
						<input type="hidden" name="progid" id="progid" value="<?php print $progid;?>" />
						<input type="hidden" name="proses" value="<?php print $proses;?>" />
					</div>
	
			</div>
		</div>
	     

<script language="javascript" type="text/javascript">
//document.frm.gsasar_nama.focus();
</script>		 
