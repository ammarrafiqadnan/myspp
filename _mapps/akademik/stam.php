<?php //include '../connection/common.php'; ?>
<script language="javascript">
function set_stpm(fields, vals, ty){
	// var stp_tahun_1 = $('#stp_tahun_1').val();
	// var stp_jenis_1 = $('#stp_jenis_1').val();
	// if(stp_tahun_1.trim()!=''){
		// var stp_tahun_2 = $('#stp_tahun_2').val();
		// var stp_jenis_2 = $('#stp_jenis_2').val();
	// }

	// $.ajax({
    //     url:'akademik/sql_akademik.php?frm=STPM&pro=UPDATE&fields='+fields+'&vals='+vals+'&ty='+ty,
	// 	type:'POST',
    //     //dataType: 'json',
    //     // beforeSend: function () {
    //         //$('.btn-primary').attr("disabled","disabled");
    //         //$('.modal-body').css('opacity', '.5');
    //     // },
	// 	data: $("form").serialize(),
	// 	//data: datas,
	// 	success: function(data){
	// 		console.log(data);
	// 		if(ty=='R'){
	// 			reload = window.location; 
	// 			window.location = reload;
	// 		}
	// 	}
	// });
}

function save_stpm(val){
	var msg = '';
	if(val==1){ 
		var stam_tahun_1 = $('#stam_tahun_1').val();
		var stam_jenis_1 = $('#stam_jenis_1').val();
		var stam_pangkat_1 = $('#stam_pangkat_1').val();

	    if(stam_tahun_1.trim()==''){
	        msg = msg+'\n- Sila pilih tahun peperiksaan.';
	        $("#stam_tahun_1").css("border-color","#f00");
	    }
	    if(stam_jenis_1.trim()==''){
	        msg = msg+'\n- Sila pilih jenis sijil.';
	        $("#stam_tahun_1").css("border-color","#f00");
	    }
	    if(stam_pangkat_1.trim()==''){
	        msg = msg+'\n- Sila pilih pangkat sijil.';
	        $("#stam_pangkat_1").css("border-color","#f00");
	    }
	} else {
		var stam_tahun_1 = $('#stam_tahun_2').val();
		var stam_jenis_1 = $('#stam_jenis_2').val();
		var stam_pangkat_2 = $('#stam_pangkat_2').val();

	    if(stam_tahun_1.trim()==''){
	        msg = msg+'\n- Sila pilih tahun peperiksaan.';
	        $("#stam_tahun_1").css("border-color","#f00");
	    }
	    if(stam_jenis_1.trim()==''){
	        msg = msg+'\n- Sila pilih jenis sijil.';
	        $("#stam_jenis_2").css("border-color","#f00");
	    }
	    if(stam_pangkat_2.trim()==''){
	        msg = msg+'\n- Sila pilih pangkat sijil.';
	        $("#stam_pangkat_2").css("border-color","#f00");
	    }
	}


    var text='';
	let i = 0;
	while (i < 6) {
		i++;
		// alert($('#mp_1'+i).val().trim()+ ":" + $('#gred_1'+i).val().trim());
		if($('#mp_1'+i).val()=='' && $('#gred_1'+i).val()==''){
		} else { 
			if($('#mp_1'+i).val()=='' || $('#gred_1'+i).val()==''){
		    	msg = msg+'\n- Sila pastikan maklumat matapelajaran dan gred lengkap dipilih.'; 
			    $(".mps"+i).each(function() {
				  $(this).siblings(".select2-container").css('border', '1px solid red');
				});
			    $("#gred_1"+i).css("border-color","#f00");
			} 
		}
	}


	if(msg.trim() !=''){ 
		alert_msg_html(msg);
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
	        url:'akademik/sql_akademik.php?frm=STAM&pro=SAVE',
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
				
			}
		});
	}
}

function do_input() {  

	var fileUpload = $("#file_pmr")[0]; 
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

function hasDuplicates(arr) {
    var counts = [];

    for (var i = 0; i <= arr.length; i++) {
        if (counts[arr[i]] === undefined) {
            counts[arr[i]] = 1;
        } else {
            return true;
        }
    }
    return false;
}

function Geeks(vals,bil) {
	var dat='',k='';
	let z = 0;
	while (z < 6) {
		z++;
		dat = $('#mp_1'+z).val();
		if(dat!='' && dat!='undefined'){
			//if($('#mp'+i).val()!='undefined')
			// alert(dat);
			if(k==''){ k = dat; }
        	else { k = k + ","+ dat; } 
			//}
		}
	}

	document.myspp.chk.value=k;

	var arr = k.split(',');

	if (hasDuplicates(arr)) {
	  // alert('Error: you have duplicates values !')
 		swal({
     		title: 'Amaran',
     		text: 'Maklumat matapelajaran telah ada dalam senarai pilihan.',
     		type: 'warning',
     		confirmButtonClass: "btn-warning",
     		confirmButtonText: "Ok",
     		showConfirmButton: true,
     	});
     	// const changeSelected = (e) => {
 		  var $exampleMulti = $(".mps"+bil).select2();
 		  $exampleMulti.val(null).trigger("change");
	}

}

</script>
<?php
// $conn->debug=true;
include 'akademik/sql_akademik.php';
$data = get_exam($conn,$_SESSION['SESS_UID']);
//print_r($data);
$uid = $data['id_pemohon'];
$tahun = $data['stam_tahun_1'];
?>
		<header class="panel-heading"  style="background-color:#0088cc;">
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
							  <button class="btn btn-primary form-control" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample" title="Sila klik untuk membaca arahan berkaitan kemasukan data akademik STAM">
							    ARAHAN:
							  </button>
							</p>-->
							<!-- <div class="collapse" id="collapseExample"> -->
							  <div class="card">
								<label for="nama" class="col-sm-12 control-label" style="border: 1px solid rgb(38, 167, 228);"><b>ARAHAN : Sila Masukkan 5 Matapelajaran Dengan Keputusan Terbaik</b>
									<ul>
										<li>Sekiranya mengambil peperiksaan melebihi satu kali dalam tempoh 3 tahun, sila isikan keputusan dua tahun terbaik dalam ruangan yang disediakan.</li>
									<li>Sila lihat Kelayakan Sijil Tinggi Agama Malaysia (STAM) bagi Maksud Pelantikan ke dalam Perkhidmatan Kerajaan.</li>
									</ul>
									
								</label>

							  </div>
							<!-- </div> -->
						</div><br>
					</div>

					<div class="row">

					<?php 
					$title_2 = '';
				    $hrefs1 = "index.php?data=".base64_encode('akademik/stam;MAKLUMAT AKADEMIK;Maklumat STAM;;1;;');  
				    $hrefs2 = "index.php?data=".base64_encode('akademik/stam;MAKLUMAT AKADEMIK;Maklumat STAM;;2;;');  
				    if($actions==2){ $bg1= ''; $bg2='style="color: blue;"'; }
				    else { $bg1= 'style="color: blue;"'; $bg2=''; }

				    // if(empty($data['stam_tahun_1'])){ $hrefs2="#"; $title_2 = "Sila isikan maklumat STAM kali pertama terlebih dahulu"; }
                    $s_tahun='';
                    $s_sijil='';


				    ?>
				        
		    
                    <ul class="nav nav-tabs" role="tablist">

                        <li <?php if($actions=="1"){ print 'class="active"'; }?>><a href="<?=$hrefs1;?>"><b <?=$bg1;?>>Maklumat Peperiksaan Pertama</b></a></li>
                        <?php if(!empty($data['stam_tahun_1']) && empty($disp2)){ ?>
                        	<li <?php if($actions=="2"){ print 'class="active"'; }?>><a href="<?=$hrefs2;?>"><b <?=$bg2;?>>Maklumat Peperiksaan Kedua</b></a></li>
                    	<?php } else { ?>
                        	<li title="Sila lengkapkan Maklumat Peperiksaan Pertama"><a title="Sila lengkapkan Maklumat Peperiksaan Pertama"><b>Maklumat Peperiksaan Kedua</b></a></li>
                    	<?php }?>


                        <?php if(empty($data['stam_tahun_2'])){ ?>
                        <!-- <li <?php if($actions=="2"){ print 'class="active"'; }?>> -->
                        	<!-- <a href="akademik/stam_add.php?id_pemohon=<?=$uid;?>&tahun=<?=$data['stam_tahun_1'];?>" data-toggle="modal" data-target="#myModal" title="Tambah Maklumat" class="fa" data-backdrop=""><button type="button" class="btn btn-primary"><i class=" fa fa-plus-square"></i> <font style="font-family:Verdana, Geneva, sans-serif"> Tambah Maklumat Peperiksaan Ke-2</font></button></a> -->
						<!-- </li> -->
                    	<?php } ?>

                    </ul>
                    

                    <div class="tab-content tabs">
                        <?php 
                        if($actions==1){ 
							$s_sijil = $data['stam_jenis_1'];
							$s_tahun = $data['stam_tahun_1'];
							$s_pangkat = $data['stam_pangkat_1'];
							$tahun_1 = "2000";
							$tahun_2 = date("Y");
                        	include 'akademik/stam1.php';
                        } else if($actions=='2'){
							$s_sijil = $data['stam_jenis_2'];
							$s_tahun = $data['stam_tahun_2'];
							$s_pangkat = $data['stam_pangkat_2'];
							$tahun_1 = $data['stam_tahun_1']+1;
							$tahun_2 = $data['stam_tahun_1']+3;

							if($data['stam_tahun_1']==date("Y")){
								$tahun_2=$data['stam_tahun_1'];
							}
                            include 'akademik/stam1.php';
                        }
                        ?>
                        <input type="hidden" name="actions" value="<?=$actions;?>">
                    </div>

					
				</div>

	
			</div>
		</div>
	     

<script language="javascript" type="text/javascript">
//document.frm.gsasar_nama.focus();
</script>		 
