<script language="javascript">
function set_stpm(fields, vals, ty){
	// alert("dd");
	// $.ajax({
    //     url:'akademik/sql_akademik.php?frm=STPM&pro=UPDATE&fields='+fields+'&vals='+vals+'&ty='+ty,
	// 	type:'POST',
    //     dataType: 'json',
    //     beforeSend: function () {
    //         $('.btn-primary').attr("disabled","disabled");
    //         $('.modal-body').css('opacity', '.5');
    //     },
	// 	data: $("form").serialize(),
	// 	//data: datas,
	// 	success: function(data){
	// 		console.log(data);
	// 		// alert(data);
	// 		if(data=='OK'){
	// 			// alert(ty);
	// 			reload = window.location; 
	// 			window.location = reload;
	// 		}
	// 	}
	// });

	// reload = window.location; 
	// window.location = reload;
}

function save_stpm(val){
    var msg = '';
    
    // Tentukan variable tahun/jenis berdasarkan tab
    // Gunakan conditional check: Jika element wujud, ambil val(). Jika tak, ambil string kosong "".
    var stp_tahun_1 = (val==1) ? ($('#stp_tahun_1').val() || "") : ($('#stp_tahun_2').val() || "");
    var stp_jenis_1 = (val==1) ? ($('#stp_jenis_1').val() || "") : ($('#stp_jenis_2').val() || "");

    // Validation Asas
    if(stp_jenis_1.trim() == ''){
        msg += '\n- Sila pilih jenis sijil.';
        // Highlight border hanya jika elemen wujud
        if(val==1) $("#stp_jenis_1").css("border-color","#f00"); else $("#stp_jenis_2").css("border-color","#f00");
    }
    if(stp_tahun_1.trim() == ''){
        msg += '\n- Sila pilih tahun peperiksaan.';
        if(val==1) $("#stp_tahun_1").css("border-color","#f00"); else $("#stp_tahun_2").css("border-color","#f00");
    }

    // Validation Gred PA (Kertas Am)
    // PENTING: Bila guna Integrasi, ID gred_10 kini ada pada <input type="hidden">, bukan select.
    // .val() berfungsi untuk kedua-duanya, tapi pastikan element wujud.
    var val_pa = $('#gred_10').val() || ""; 
    
    // Logic tambahan: Kalau Integrasi input val 'Y', mungkin kita skip validation ketat 
    // SEBAB field kosong tak dipaparkan. 
    // TAPI data integrasi PA (900) mesti ada.
    var is_integ = $('#is_integrasi_input').val();

    if(val_pa.trim() == ''){
        // Kalau Integrasi, jika PA tak wujud dalam data yang ditarik, ini mungkin isu.
        // Tapi selalunya PA wajib ada.
        msg += '\n- Sila pastikan gred Pengajian Am/Kertas Am lengkap.';
        $("#gred_10").css("border-color","#f00");
    } 

    // Validation 4 Subjek Lain
    // Semak element mp_1X dan gred_1X
    // Dalam Integrasi, ID ini ditambah secara dinamik (mp_11, mp_12, etc).
    // Loop 1 hingga 4 (slot).
    let i = 0;
    while (i < 4) {
        i++;
        var el_mp = $('#mp_1'+i);
        var el_gr = $('#gred_1'+i);
        
        var val_mp = el_mp.length ? (el_mp.val() || "") : "";
        var val_gr = el_gr.length ? (el_gr.val() || "") : "";

        // Logic Manual: Kalau user pilih MP, mesti pilih Gred.
        // Logic Integrasi: Hidden input sentiasa ada value (pair). 
        // Jika row tak wujud (sebab data kosong), el_mp.length == 0, so selamat.
        
        if (is_integ !== 'Y') { // Hanya validate ketat untuk MANUAL
            if(val_mp !== '' && val_gr === ''){
                 msg += '\n- Sila pilih gred untuk matapelajaran ke-'+i;
                 $("#gred_1"+i).css("border-color","#f00");
            } else if(val_mp === '' && val_gr !== ''){
                 msg += '\n- Sila pilih matapelajaran ke-'+i;
                 // Select2 border handling
                 $(".mps"+i).next(".select2-container").css('border', '1px solid red');
            }
        }
    }

    if(msg.trim() != ''){ 
        alert_msg_html(msg);
    } else { 
        var fd = new FormData();
        
        // Handle file upload (hanya wujud masa manual)
        if ($('#file_pmr').length && $('#file_pmr')[0].files.length > 0) {
            var files1 = $('#file_pmr')[0].files[0];
            fd.append('file_pmr', files1);
        }

        // Enable disabled inputs temporarily for serialization (kalau ada)
        var disabledInputs = $('form :input:disabled');
        disabledInputs.removeAttr('disabled');

        var other_data = $('form').serializeArray();
        
        // Restore disabled state
        disabledInputs.attr('disabled', 'disabled');

        $.each(other_data, function(key, input){
            fd.append(input.name, input.value);
        });

        // Debug: Check data sebelum hantar
        // for (var pair of fd.entries()) { console.log(pair[0]+ ', ' + pair[1]); }

        $.ajax({
            url: 'akademik/sql_akademik.php?frm=STPM&pro=SAVE',
            type: 'POST',
            data: fd,
            contentType: false,
            cache: false,
            processData: false,
            success: function(data){
                // console.log(data);
                // Trim whitespace respons server (kadang-kadang ada newline)
                data = $.trim(data);
                
                if(data == 'OK'){
                    swal({
                      title: 'Berjaya',
                      text: 'Maklumat telah berjaya dikemaskini',
                      type: 'success',
                      confirmButtonClass: "btn-success",
                      confirmButtonText: "Ok",
                      showConfirmButton: true,
                    }).then(function () {
                        window.location.reload();
                    });
                } else {
                    swal({
                      title: 'Ralat',
                      text: 'Maklumat tidak berjaya dikemaskini. Sila cuba lagi.',
                      type: 'error',
                      confirmButtonClass: "btn-warning",
                      confirmButtonText: "Ok",
                      showConfirmButton: true,
                    });
                }
            },
            error: function() {
                 swal("Ralat", "Gagal menghubungi pelayan.", "error");
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
	while (z < 4) {
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

}</script>
<?php
include 'akademik/sql_akademik.php';
$data = get_exam($conn,$_SESSION['SESS_UID']);
// print_r($data);
$uid = $data['id_pemohon'];
$tahun = $data['stp_tahun_1'];
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
							  <button class="btn btn-primary form-control" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample" title="Sila klik untuk membaca arahan berkaitan kemasukan data akademik STPM">
							    ARAHAN:
							  </button>
							</p>-->
							<!-- <div class="collapse" id="collapseExample"> -->
							  <div class="card">
								<label for="nama" class="col-sm-12 control-label" style="border: 1px solid rgb(38, 167, 228);"><b>ARAHAN : Sila Masukkan 5 Matapelajaran Dengan Keputusan Terbaik</b>
									<ul>
										<li>Calon STPM : Sekiranya mengambil peperiksaan melebihi satu kali dalam tempoh 3 tahun, sila isikan keputusan dua tahun terbaik dalam ruangan yang disediakan.</li>
										<!-- <li>Calon STP/HSC : Sekiranya mengambil peperiksaan melebihi satu kali, sila isikan hanya satu keputusan sahaja dalam ruangan yang disediakan.</li> -->
									</ul>
									
								</label>

							  </div>
							<!-- </div> -->
						</div><br>


					<?php 
					$title_2 = '';
				    $hrefs1 = "index.php?data=".base64_encode('akademik/stpm;MAKLUMAT AKADEMIK;Maklumat STPM;;1;;');  
				    $hrefs2 = "index.php?data=".base64_encode('akademik/stpm;MAKLUMAT AKADEMIK;Maklumat STPM;;2;;'); 
				    $jxm='A'; 
				    if($actions==2){ $bg1= ''; $bg2='style="color: blue;"';  $jxm='AT'; }
				    else { $bg1= 'style="color: blue;"'; $bg2=''; }
				    $disp2='';
					if($data['stp_jenis_sijil_1']==1 || $data['stp_jenis_sijil_1']==3){
						$result = get_stp_result($conn, $uid, "900", $s_tahun, $jxm);
						if(empty($result['gred'])){ $disp2 = 'ERR1'; }
					}    
					$act2='';
					if($data['stpm_jenis_sijil_1']==1 || $data['stpm_jenis_sijil_1']==1){
						$act2 = "1,2";
					} else if($data['stpm_jenis_sijil_1']==5){
						$act2 = "1,2";
					}
					// print "DDD".$disp2.":".$data['stp_tahun_1'];

                    $s_tahun='';
                    $s_sijil='';
				    ?>
		    
                    <ul class="nav nav-tabs" role="tablist">

                        <li <?php if($actions=="1"){ print 'class="active"'; }?>><a href="<?=$hrefs1;?>"><b <?=$bg1;?>>Maklumat Peperiksaan Pertama</b></a></li>
                        <?php if(!empty($data['stp_tahun_1']) && empty($disp2)){ ?>
                        	<li <?php if($actions=="2"){ print 'class="active"'; }?>><a href="<?=$hrefs2;?>"><b <?=$bg2;?>>Maklumat Peperiksaan Kedua</b></a></li>
                    	<?php } else { ?>
                        	<li title="Sila lengkapkan Maklumat Peperiksaan Pertama"><a title="Sila lengkapkan Maklumat Peperiksaan Pertama"><b>Maklumat Peperiksaan Kedua</b></a></li>
                    	<?php }?>


                        <?php if(empty($data['stp_tahun_2'])){ ?>
                        <!-- <li <?php if($actions=="2"){ print 'class="active"'; }?>> -->
                        	<!-- <a href="akademik/stpm_add.php?id_pemohon=<?=$uid;?>&tahun=<?=$data['stp_tahun_1'];?>" data-toggle="modal" data-target="#myModal" title="Tambah Maklumat" class="fa" data-backdrop=""><button type="button" class="btn btn-primary"><i class=" fa fa-plus-square"></i> <font style="font-family:Verdana, Geneva, sans-serif"> Tambah Maklumat Peperiksaan Ke-2</font></button></a> -->
						<!-- </li> -->
                    	<?php } ?>

                    </ul>
                    

                    <div class="tab-content tabs">
                        <?php 
                        if($actions==1){ 
							$s_sijil = $data['stp_jenis_1'];
							$s_tahun = $data['stp_tahun_1'];
							$tahun_1 = "1990";
							$tahun_2 = date("Y");
                        	include 'akademik/stpm1.php';
                        } else if($actions=='2'){
							$s_sijil = $data['stp_jenis_2'];
							$s_tahun = $data['stp_tahun_2'];
							$tahun_1 = $data['stp_tahun_1']+1;
							$tahun_2 = $data['stp_tahun_1']+3;

							if($data['stp_tahun_1']==date("Y")){
								$tahun_2=$data['stp_tahun_1'];
							}

                            include 'akademik/stpm1.php';
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
