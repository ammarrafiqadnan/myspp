<?php //include '../connection/common.php'; 
$urls = "index.php?data=".base64_encode('akademik/spm;MAKLUMAT AKADEMIK;Maklumat SPM/SPM(V)/SVM;;1;;');
?>
<script language="javascript">
function set_spm(fields, vals, ty){
	var spm_jenis_sijil_1 = $('#spm_jenis_sijil_1').val();
	var spm_tahun = $('#spm_tahun_1').val();

	if(spm_tahun==0){
		spm_tahun='';
	}

	// alert(spm_tahun);
	var actions = $('#actions').val();
	//alert(actions); exit;

	if(spm_jenis_sijil_1 == '6' && spm_tahun!=''){
		swal({
		  title: 'Amaran',
		  text: 'Sila pilih tahun 2012 dan ke atas sahaja.1111',
		  type: 'error',
		  confirmButtonClass: "btn-warning",
		  confirmButtonText: "Ok",
		  showConfirmButton: true,

		}).then(function () {
			//document.getElementById("spm_tahun_1").val();
			$('#spm_tahun_1').val(null);
		});

	} else {
		$.ajax({
	        url:'akademik/sql_akademik.php?frm=SPM&pro=AWAL&actions='+actions+'&fields='+fields+'&vals='+vals+'&ty='+ty,
	        // url:'akademik/sql_akademik.php?frm=SPM&pro=UPDATE&actions='+actions+'&fields='+fields+'&vals='+vals+'&ty='+ty,
			type:'POST',
			data: $("form").serialize(),
			//data: datas,
			success: function(data){
				console.log(data);
				if(ty=='R'){
					refresh = window.location; 
					window.location = refresh;
				}
			}
		});
	}
}

function save_spm(val){
	//alert(val);
	var msg = '';
	var acts = $('#actions').val();

	if(val==1){ 
		var spm_tahun_1 = $('#spm_tahun_1').val();
		var spm_jenis_sijil_1 = $('#spm_jenis_sijil_1').val();
		var srp_pangkat = $('#spm_pangkat_1').val();
   	} else {
    		var spm_tahun_1 = $('#spm_tahun_1').val();
		var spm_jenis_sijil_1 = $('#spm_jenis_sijil_1').val();
		//var srp_pangkat = $('#spm_pangkat_1').val();
    	}

    
    	if(spm_tahun_1.trim()=='' || spm_tahun_1.trim()=='0'){
        	msg = msg+'\n- Sila pilih tahun peperiksaan.';
        	$("#spm_tahun_1").css("border-color","#f00");
    	}
	if(spm_jenis_sijil_1.trim()=='' || spm_jenis_sijil_1.trim()=='0'){
        	msg = msg+'\n- Sila pilih jenis sijil.';
        	$("#spm_jenis_sijil_1").css("border-color","#f00");
    	}
	if(spm_tahun_1.trim()<='1999' && acts==1){
		if(srp_pangkat.trim()=='' || srp_pangkat.trim()=='0'){
        		msg = msg+'\n- Sila pilih pangkat.';
        		$("#spm_pangkat_1").css("border-color","#f00");
    		}
	}



	let i = 1;
	if(spm_tahun_1 <= 1999 && acts==1){
		var spm_lisan_1 = $('#spm_lisan_1').val();
		if(spm_lisan_1.trim()==''){
      			msg = msg+'\n- Sila pilih maklumat ujian lisan.';
       		$("#spm_lisan_1").css("border-color","#f00");
   		}
		if(srp_pangkat.trim()==''){
      			msg = msg+'\n- Sila pilih pangkat peperiksaan.';
       		$("#spm_pangkat_1").css("border-color","#f00");
   		}
		var input = document.getElementsByName('gred_1[]');
		var a = input[0].value;
	    if(a.trim() ==''){
	        msg = msg+'\n- Sila pilih gred.';
	        $("#gred_1").css("border-color","#f00");
	    }

	} else if(spm_tahun_1 >= 2000 && spm_tahun_1<=2012){
    		
		var input = document.getElementsByName('gred_1[]');
		var a = input[0].value;
	    if(a.trim() ==''){
	        msg = msg+'\n- Sila pilih gred bagi matapelajaran Bahasa Melayu.';
	        $("#gred_1").css("border-color","#f00");
	    } 
	
	} else if(spm_tahun_1 >= 2013){
		var input = document.getElementsByName('gred_1[]');
		var a = input[0].value;
	    if(a.trim() ==''){
	        msg = msg+'\n- Sila pilih gred bagi matapelajaran Bahasa Melayu.';
	        $("#gred_10").css("border-color","#f00");
	    } 
		// var input = document.getElementsByName('gred_1[]');
		var a = input[1].value;
	    if(a.trim() ==''){
	        msg = msg+'\n- Sila pilih gred bagi matapelajaran Sejarah.';
	        $("#gred_11").css("border-color","#f00");
	    } 

	   	i = 1;	
	}

   	i = i + 1;	
	while (i < 11) {
		// text += "<br>The number is " + i;
		i++;
		// alert($('#mp'+i).val().trim()+ ":" + $('#gred'+i).val().trim());
		if($('#mp_1'+i).val()=='' && $('#gred_1'+i).val()==''){
		} else { 
			if($('#mp_1'+i).val()=='' || $('#gred_1'+i).val()==''){
		    	msg = msg+'\n- Sila pastikan maklumat lengkap.'; 
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
	        url:'akademik/sql_akademik.php?frm=SPM&pro=SAVE',
			type:'POST',
	        //dataType: 'json',
	        beforeSend: function () {
	            $('.btn-primary').attr("disabled","disabled");
	            $('.modal-body').css('opacity', '.5');
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
	let z = 1;
	while (z < 11) {
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

function do_hapus_spm(url){
	swal({
		title: 'Adakah anda pasti untuk menghapuskan semua data ini?',
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
                $('.btn-primary').attr("disabled","disabled");
                $('.modal-body').css('opacity', '.5');
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
$progid=isset($_REQUEST["progid"])?$_REQUEST["progid"]:"";
$proses=isset($_REQUEST["proses"])?$_REQUEST["proses"]:"";

//print_r($data);
$uid = $data['id_pemohon'];
$tahun = $data['spm_tahun_1'];

if(!empty($data['spm_jenis_sijil_1'])){ $jsijil1 = $data['spm_jenis_sijil_1']; }
if(!empty($data['spm_jenis_sijil_2'])){ $jsijil2 = $data['spm_jenis_sijil_2']; }
//$jsijil2 = $data['spm_jenis_sijil_2'];

if(!empty($data['spm_tahun_1'])){ $gtahun1 = $data['spm_tahun_1']; }
if(!empty($data['spm_tahun_2'])){ $gtahun2 = $data['spm_tahun_2']; }
//$gtahun2 = $data['spm_tahun_2'];

//if(

if(empty($jsijil1) && !empty($_SESSION['SESS_SPMSIJIL'])){ $jsijil1=$_SESSION['SESS_SPMSIJIL']; }
if(empty($gtahun1) && !empty($_SESSION['SESS_SPMTAHUN'])){ $gtahun1=$_SESSION['SESS_SPMTAHUN']; }

//$jsijil2=isset($_POST["spm_jenis_sijil_1"])?$_POST["spm_jenis_sijil_1"]:"";

if($actions==2){
	//print '..'.$_POST["spm_jenis_sijil_1"]."..";
	//$_SESSION['SESS_SPMSIJIL2']=$jsijil2;
	//$_SESSION['SESS_SPMSIJIL']=$jsijil1;
	if(!empty($data['spm_jenis_sijil_2'])){ 
		$jsijil2 = $data['spm_jenis_sijil_2']; 
	} else {
		$jsijil2=isset($_REQUEST["spm_jenis_sijil_1"])?$_REQUEST["spm_jenis_sijil_1"]:""; 
	}

		// print '..'.$jsijil2;

	if(!empty($jsijil2)){
		// print '.';
	// REMOVE ON 11 Nov 2023	
	// } else if(empty($jsijil2) && !empty($jsijil1) && $jsijil1=='6'){ 
		// $jsijil2='6'; $_SESSION['SESS_SPMSIJIL2']='6';
		// print '..'.$jsijil2."..";
	} else {
		if(empty($jsijil2) && !empty($jsijil1) && !empty($_SESSION['SESS_SPMSIJIL2'])){ $jsijil2=$_SESSION['SESS_SPMSIJIL2']; }
		if(empty($gtahun2) && !empty($jsijil1) && !empty($_SESSION['SESS_SPMTAHUN2'])){ $gtahun2=$_SESSION['SESS_SPMTAHUN2']; }
		// print '...'.$jsijil2."...";
	}
}
// print $actions.":".$jsijil2.":".$gtahun2;

?>
	<header class="panel-heading" style="background-color:#0088cc;">
		<h6 class="panel-title"><font color="#fff" size="3"><b><?php print strtoupper($menu);?></b></font></h6>
	</header>
		<div class="box-body">

		<input type="hidden" name="id_pemohon" id="id_pemohon" value="<?php print $uid;?>" readonly="readonly"/>
		<input type="hidden" name="actions" id="actions" value="<?php print $actions;?>" readonly="readonly"/>

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
								<label for="nama" class="col-sm-12 control-label" style="border: 1px solid rgb(38, 167, 228);"><b>ARAHAN : Sila Masukkan 10 Matapelajaran Dengan Keputusan Terbaik</b>
									<ul>
										<li> Sijil Am Pelajaran (SAP) adalah tidak setaraf dengan SPM/SPM(V)/SVM dan oleh itu pemohon yang memilikinya, sila isikan Ruangan Peperiksaan Tambahan</li>
										<li> Sekiranya anda mengambil SPM mengikut sistem terbuka lebih dari sekali, isikan keputusan yang dikumpulkan dalam dua (2) kali peperiksaan bagi tempoh tiga (3) tahun berturut-turut Peperiksaan Kali Pertama dan Peperiksaan Kali Kedua</li>
										<li> Bagi calon yang mengambil peperiksaan SPM ulangan/ kali kedua dalam tempoh melebihi tiga (3) tahun berturut-turut, keputusan terbaik bagi subjek Bahasa Melayu boleh diisi di submenu "Peperiksaan SPM Ulangan".</li>
										<li> Sila lihat Kelayakan Sijil Pelajaran Malaysia (SPM) mengikut sistem terbuka bagi maksud perlantikan ke dalam Perkhidmatan Kerajaan.</li>
									</ul>
								</label>

						  </div>
						
						<!-- </div> -->
					</div><br>


					<?php 
				    $hrefs1 = "index.php?data=".base64_encode('akademik/spm;MAKLUMAT AKADEMIK;Maklumat SPM/SPVM/SPM(V);;1;;');  
				    $hrefs2 = "index.php?data=".base64_encode('akademik/spm;MAKLUMAT AKADEMIK;Maklumat SPM/SPVM/SPM(V);;2;;');  
				    if($actions==2){ $bg1= ''; $bg2='style="color: blue;"'; }
				    else { $bg1= 'style="color: blue;"'; $bg2=''; }
				    $disp2='';
					if($jsijil1==1 || $jsijil1==3){
						$result = get_spm_result($conn, $uid, "103", $tahun, "1");
						if(empty($result['gred'])){ $disp2 = 'ERR1'; }
						if($data['spm_tahun_1']>=2013){
							$result = get_spm_result($conn, $uid, "249", $tahun, "1");
							if(empty($result['gred'])){ $disp2 = 'ERR2'; }
						}
					}    
					$act2='';
					if($jsijil1==1 || $jsijil1==1){
						$act2 = "1,2";
					} else if($jsijil1==6){
						$act2 = "1,2";
					}
					// print $disp2;
				    ?>
				        
		    <?php if(!empty($data['spm_jenis_sijil_1'])){ ?>
			<div style="float:right;">
				<label class="btn btn-danger" onclick="do_hapus_spm('akademik/sql_akademik.php?frm=SPM&pro=SPM_DELALL&id_pemohon=<?=$_SESSION['SESS_UID'];?>')">Hapus Semua Maklumat</label>
			</div>
		    <?php } ?>

                    <ul class="nav nav-tabs" role="tablist">
                        <li <?php if($actions=="1"){ print 'class="active"'; }?>><a href="<?=$hrefs1;?>"><b <?=$bg1;?>>Maklumat Peperiksaan Pertama</b></a></li>
                        <?php if(!empty($data['spm_tahun_1']) && empty($disp2)){ ?>
                        	<li <?php if($actions=="2"){ print 'class="active"'; }?>><a href="<?=$hrefs2;?>"><b <?=$bg2;?>>Maklumat Peperiksaan Kedua</b></a></li>
                    	<?php } else { ?>
                        	<li title="Sila lengkapkan Maklumat Peperiksaan Pertama"><a title="Sila lengkapkan Maklumat Peperiksaan Pertama"><b>Maklumat Peperiksaan Kedua</b></a></li>
                    	<?php }?>


                        <?php if(empty($data['spm_tahun_2'])){ ?>
                        <!-- <li <?php if($actions=="2"){ print 'class="active"'; }?>> -->
                        	<!-- <a href="akademik/spm_add.php?id_pemohon=<?=$uid;?>&tahun=<?=$data['spm_tahun_1'];?>" data-toggle="modal" data-target="#myModal" title="Tambah Maklumat" class="fa" data-backdrop=""><button type="button" class="btn btn-primary"><i class=" fa fa-plus-square"></i> <font style="font-family:Verdana, Geneva, sans-serif"> Tambah Maklumat Peperiksaan Ke-2</font></button></a> -->
						<!-- </li> -->
                    	<?php } ?>

                    </ul>
                    

                    <div class="tab-content tabs">
                        <?php 
	// print_r($data);
                        $dty = date("Y")."-06";
                        $s_tahun='';
                        $s_sijil='';
               			if($actions==1){
							$s_sijil = $jsijil1;
							$s_tahun = $gtahun1;
							$s_pangkat = $data['spm_pangkat_1'];
							$s_lisan = $data['spm_lisan_1'];
							$tahun_1 = "1975";
							if(date("Y-m")<=$dty){ $tahun_2 = date("Y")-1; }
							else { $tahun_2 = date("Y"); }
						} else if($actions==2){
							$s_sijil = $jsijil2;
							$s_tahun = $gtahun2;
							$s_pangkat = $data['spm_pangkat_2'];
							$s_lisan = $data['spm_lisan_2'];
							$tahun_1 = $gtahun1+1;
							$tahun_2 = $gtahun1+3;

							if($tahun_1==date("Y")){
								$tahun_2=$tahun_1;
							}
						}
//print "<br>ACT:".$actions.":".$s_sijil.":".$s_tahun.":".$s_pangkat.":".$jsijil1;
						
                        if($actions==1){
                        	if($jsijil1==6){
	                        	include 'akademik/svm1.php';
                        	} else {
	                        	include 'akademik/spm1.php';
                        	}
                        } else if($actions=='2'){
                        	if($jsijil2==6){
	                        	include 'akademik/svm1.php';
                        	} else {
	                            include 'akademik/spm1.php';
				}
                        }
                        ?>
                        <!-- <input type="hidden" name="actions" value="<?=$actions;?>"> -->
                    </div>
				</div>
			</div>

		</div>
	</div>
	     

<script language="javascript" type="text/javascript">
//document.frm.gsasar_nama.focus();
</script>		 
