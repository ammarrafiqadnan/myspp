<?php //include '../connection/common.php'; ?>
<script language="javascript">
function get_spr(fields, vals,ty){
	$.ajax({
        url:'akademik/sql_akademik.php?frm=SRP&pro=UPDATE&fields='+fields+'&vals='+vals+'&ty='+ty,
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
				refresh = window.location; 
				window.location = refresh;
			}
		}
	});
}

function save_spr(){
	var id_pemohon = $('#id_pemohon').val();
	var srp_tahun = $('#srp_tahun').val();
	var srp_jenis_sijil = $('#srp_jenis_sijil').val();
	// var mp = $('#mp').val();
	// var gred = $('#gred').val();
	// var mp = document.getElementById('mp');; //$('#mp').val();
	// var gred = $('#gred').val();
	var msg = '';

	var inputmp = document.getElementsByName('mp[]');
	var input = document.getElementsByName('gred[]');
	var a = input[0].value;

	if(srp_tahun.trim() ==''){
        msg = msg+'\n- Sila pilih tahun peperiksaan.';
        $("#srp_tahun").css("border-color","#f00");
    } 
    if(srp_jenis_sijil.trim() ==''){
        msg = msg+'\n- Sila pilih jenis sijil.';
        $("#srp_jenis_sijil").css("border-color","#f00");
    } 
    if(a.trim() ==''){
        msg = msg+'\n- Sila pilih gred.';
        $("#gred").css("border-color","#f00");
    } 



	let i = 1;
	while (i < 10) {
		// text += "<br>The number is " + i;
		i++;
		// alert($('#mp'+i).val().trim()+ ":" + $('#gred'+i).val().trim());
		if($('#mp'+i).val()=='' && $('#gred'+i).val()==''){
		} else { 
			if($('#mp'+i).val()=='' || $('#gred'+i).val()==''){
		    	msg = msg+'\n- Sila pastikan maklumat lengkap.'; 
			    $(".mps"+i).each(function() {
				  $(this).siblings(".select2-container").css('border', '1px solid red');
				});
			    $("#gred"+i).css("border-color","#f00");
			} 
		}
	}


	var files2 = $("#file_pmr").val();
	if(files2.trim() != ''){
		var files1 = $('#file_pmr')[0].files[0];
		var size = files1.size;
	//alert(size);
    	if(size>300000){
        	msg = msg+"\n- Sila pastikan gambar yang dimuatnaik kurang daripada 300kb.";
		}
	}

	// alert(mp);
	// const strArray = [ "q", "w", "w", "e", "i", "u", "r", "q"];
	// const alreadySeen = {};
  // 
	// strArray.forEach(str => alreadySeen[str] ? console.log(str) : alreadySeen[str] = true);


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
	        url:'akademik/sql_akademik.php?frm=SRP&pro=SAVE',
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
	let z = 1;
	while (z < 9) {
		z++;
		dat = $('#mp'+z).val();
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

function do_sijil(tahun){
//alert('here');
	var srp_tahun= $('#srp_tahun').val();
	//var srp_jenis_sijil_1= $('#srp_jenis_sijil_1').val();
	var sel="#srp_jenis_sijil_1";
	var sel1="#gred";
	var sel2="#gred2";
	var sel3="#gred3";
	var sel4="#gred4";
	var sel5="#gred5";
	var sel6="#gred6";
	var sel7="#gred7";
	var sel8="#gred8";
	var sel9="#gred9";
	var sel10="#gred10";

	//alert(srp_tahun);

	if(srp_tahun <= 1992){
		var jenis = '2';
	} else {
		var jenis = '1';
	}

	document.myspp.srp_jenis_sijil.value=jenis;

			
	$.ajax({
		url: '../include/get_srp_jenis_sijil.php?srp_tahun='+srp_tahun,
		type: 'post',
		data: {srp_tahun:srp_tahun},
		dataType: 'json',
		success:function(response){
			//console.log(response);
			var len = response[0].length;
			var len2 = response[1].length;

			//console.log(len2);
			$(sel).empty();
			$(sel1).empty();
			$(sel2).empty();
			$(sel3).empty();
			$(sel4).empty();
			$(sel5).empty();
			$(sel6).empty();
			$(sel7).empty();
			$(sel8).empty();
			$(sel9).empty();
			$(sel10).empty();
			for( var i = 0; i<len; i++){
				//console.log(i);

				var kod = response[0][i]['kod'];
				var jenis_sijil= response[0][i]['jenis_sijil'];
				console.log(response[0][i]['kod']);
				$(sel).append("<option value='"+kod+"'>"+jenis_sijil+"</option>");
			}

			for(var j = 0; j<=len2; j++){
				console.log(response[1][j]['KOD']);
				var kod = response[1][j]['KOD'];
				var gred= response[1][j]['gred'];
				
				$(sel1).append("<option value='"+kod+"'>"+gred+"</option>");
				$(sel2).append("<option value='"+kod+"'>"+gred+"</option>");
				$(sel3).append("<option value='"+kod+"'>"+gred+"</option>");
				$(sel4).append("<option value='"+kod+"'>"+gred+"</option>");
				$(sel5).append("<option value='"+kod+"'>"+gred+"</option>");
				$(sel6).append("<option value='"+kod+"'>"+gred+"</option>");
				$(sel7).append("<option value='"+kod+"'>"+gred+"</option>");
				$(sel8).append("<option value='"+kod+"'>"+gred+"</option>");
				$(sel9).append("<option value='"+kod+"'>"+gred+"</option>");
				$(sel10).append("<option value='"+kod+"'>"+gred+"</option>");
			}

		}
	});
}

</script>
<?php
include 'akademik/sql_akademik.php';
$data = get_pmr($conn,$_SESSION['SESS_UID']);
//print_r($data);
$uid = $data['id_pemohon'];
$tahun = $data['srp_tahun'];
// $conn->debug=true;
$rsSijil = $conn->query("SELECT * FROM $schema2.`calon_sijil` WHERE `jenis_sijil`='PMR' AND `id_pemohon`=".tosql($uid));
if(empty($rsSijil->fields['sijil_nama'])){ $sijil_pic ="/var/www/myspp/upload_doc/sijil_pmr.jpg"; }
else { $sijil_pic = "/var/www/upload/".$uid."/".$rsSijil->fields['sijil_nama']; }
 //print $sijil;

if (file_exists($sijil_pic)){
     $b64image = base64_encode(file_get_contents($sijil_pic));
     $sijil = "data:image/png;base64,$b64image";
} else {
	$sijil='';
}
?>
		<header class="panel-heading"  style="background-color:#0088cc;">
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
							</p> -->
							<!-- <div class="collapse" id="collapseExample"> -->
							  <div class="card">
									<label for="nama" class="col-sm-12 control-label" style="border: 1px solid rgb(38, 167, 228);"><b>ARAHAN : Sila Masukkan 10 Matapelajaran Dengan Keputusan Terbaik</b>
										<ul>
											<li>Bagi sijil PT3, sila pilih gred A hingga F.</li>
											<li>Bagi sijil PMR, sila pilih gred A hingga E.</li>
											<li>Bagi sijil SRP, sila pilih gred 1 hingga 9.</li>
										</ul>
									</label>

							  </div>
							<!-- </div> -->
						</div>
					</div>

					<!-- <hr> -->

					
					<div class="form-group">
						<div class="row">
							<label for="nama" class="col-sm-2 control-label"><b>Tahun <font color="#FF0000">*</font><div style="float:right">:</div></b></label>
							<div class="col-sm-3"><!--onchange="get_spr('srp_tahun',this.value,'R')"-->
								<select name="srp_tahun" id="srp_tahun" class="form-control"  
								<?php if(!empty($data['srp_tahun'])){ print 'disabled'; }?> onchange="do_sijil(this.value)">
									<option value="">Sila pilih tahun</option>
									<?php for($t=date("Y");$t>=1970;$t--){
										print '<option value="'.$t.'"'; 
										if($data['srp_tahun']==$t){ print 'selected'; }
										print '>'.$t.'</option>';
									} ?>
								</select>
								<input type="hidden" name="srp_tahun_pilih" value="<?=$data['srp_tahun'];?>">
							</div>
							<div class="col-sm-1"></div>
					<?php 
					$rssijil = $conn->query("SELECT * FROM $schema1.`ref_sijil` WHERE `TKT`='3' AND is_aktif=0");//;// AND (".$data['srp_tahun']." BETWEEN tahun_mula AND tahun_akhir)
					$rspangkat = $conn->query("SELECT * FROM $schema1.`ref_sijil_pangkat` WHERE `TKT`=3 ORDER BY `DISKRIPSI`");
					?>
							<label for="nama" class="col-sm-2 control-label"><b>Jenis Sijil <font color="#FF0000">*</font><div style="float:right">:</div></b></label>
							<div class="col-sm-3">
								<select class="form-control" id="srp_jenis_sijil_1" name="srp_jenis_sijil_1" onchange="get_spr('srp_jenis_sijil',this.value,'')" <?php if(!empty($data['srp_jenis_sijil'])){ print 'disabled'; };?> disabled>
									<option value=""></option>
									<?php while(!$rssijil->EOF){ ?>
									<option value="<?=$rssijil->fields['KOD'];?>" 
									<?php if($rssijil->fields['KOD']==$data['srp_jenis_sijil']){ print 'selected';} ?>	
									><?=$rssijil->fields['DISKRIPSI'];?></option>
									<?php $rssijil->movenext(); } ?>
								</select>

								<input type="hidden" name="srp_jenis_sijil" id="srp_jenis_sijil" value="<?php if(!empty($data['srp_jenis_sijil'])){ print $data['srp_jenis_sijil']; } ?>">

								<?php //if(!empty($data['srp_jenis_sijil'])){ ?>
									<!--<input type="hidden" name="srp_jenis_sijil" id="srp_jenis_sijil" value="<?=$data['srp_jenis_sijil'];?>">-->
								<?php //}?>
							</div>
							<div class="col-sm-1"></div>
							<!-- <label for="nama" class="col-sm-2 control-label"><b>Pangkat <font color="#FF0000">*</font><div style="float:right">:</div></b></label>
							<div class="col-sm-3">
								<select class="form-control" name="srp_pangkat" id="srp_pangkat" onchange="get_spr('srp_pangkat',this.value,'')">
									<option value="">Sila pilih pangkat</option>
									<?php while(!$rspangkat->EOF){ ?>
									<option value="<?=$rspangkat->fields['KOD'];?>" 
									<?php if($rspangkat->fields['KOD']==$data['srp_pangkat']){ print 'selected';} ?>	
									><?=$rspangkat->fields['DISKRIPSI'];?></option>
									<?php $rspangkat->movenext(); } ?>
								</select>
							</div> -->
						</div>
					</div>

					<?php //if(!empty($data['srp_tahun'])){ 
						$rsSRP = $conn->query("SELECT * FROM $schema1.`ref_matapelajaran` WHERE `TKT`='3' AND `SAH_YT`='Y' AND `GAB_YT`='T' 
							ORDER BY `DISKRIPSI`");
						if(!empty($data['srp_jenis_sijil'] == 2)){ 
							$rsGred = $conn->query("SELECT * FROM $schema1.`ref_gred_matapelajaran` WHERE `TKT`='3' AND `GRED` NOT IN ('A','B','C','D','E','F') ORDER BY `SUSUNAN`");
						} else {
							$rsGred = $conn->query("SELECT * FROM $schema1.`ref_gred_matapelajaran` WHERE `TKT`='3' AND `GRED` IN ('A','B','C','D','E','F') ORDER BY `SUSUNAN`");

						}
					?>
					<hr>

					<div class="form-group">
						<div class="row">
							<div class="col-sm-8" style="margin-left:-20px">
								<div class="row">
									<div class="col-sm-8 col-xs-7" style="padding-bottom:5px;text-align: center;"><b>MATAPELAJARAN</b></div>
									<div class="col-sm-4 col-xs-3" style="padding-bottom:5px;text-align: center;"><b>GRED</b></div>
									<div class="col-sm-4 col-xs-2" style="padding-bottom:5px;text-align: center;"><b></b></div>
								</div>
								<div class="row">
									<?php
										$result = get_pmr_result($conn, $uid, "002", $tahun);
									?>
									<div class="col-sm-8 col-xs-8" style="padding-bottom:5px"><b>BAHASA MELAYU/BAHASA MALAYSIA</b></div>
									<div class="col-sm-3 col-xs-3" style="padding-bottom:5px;margin-left:-20px">

										<input type="hidden" name="mp_old[]" value="002">
										<input type="hidden" name="mp[]" id="mp[]" value="002">
										<select class="form-control" name="gred[]" id="gred">
											<option value="">Sila pilih gred</option>
											<?php  //$datas='';
											
											
											$datas='002'; 
											if(!empty($result['gred'])){ $greds = $result['gred']; } else { $greds=''; }
											$rsGred->movefirst();
											while(!$rsGred->EOF){ ?>
											<option value="<?=$rsGred->fields['GRED'];?>" <?php if($rsGred->fields['GRED']==$greds){ print 'selected'; } ?>><?=$rsGred->fields['GRED'];?></option>	
											<?php $rsGred->movenext(); } ?>
										</select>
									</div>
								</div>

								<?php $bilr=1;
								$sql="SELECT * FROM $schema2.`calon_srp` WHERE `id_pemohon`=".tosql($uid). " AND tahun=".tosql($tahun). " AND matapelajaran NOT IN ('002') ORDER BY d_cipta";
								$rsResult = $conn->query($sql);
								while(!$rsResult->EOF){  
									$datas.=",".$rsResult->fields['matapelajaran'];
									$bilr++;
								?>								
								<div class="row">
									<input type="hidden" name="mp_old[]" value="<?=$rsResult->fields['matapelajaran'];?>">
									<div class="col-sm-8 col-xs-8" style="padding-bottom:5px">
										<select name="mp[]" id="mp<?=$bilr;?>" class="form-control select2 select2-accessible mps<?=$bilr;?>" style="width: 100%;" aria-hidden="true" 
											onchange="Geeks(this.value,<?=$bilr;?>)">
											<option value="">Sila pilih matapelajaran</option>
											<?php $rsSRP->movefirst();
											while(!$rsSRP->EOF){ ?>
											<option value="<?=$rsSRP->fields['kod'];?>"<?php if($rsSRP->fields['kod']==$rsResult->fields['matapelajaran']){ print ' selected'; } ?>><?=$rsSRP->fields['DISKRIPSI'];?></option>	
											<?php $rsSRP->movenext(); } ?>
										</select>
									</div>
									<div class="col-sm-3 col-xs-3" style="padding-bottom:5px;margin-left:-20px">
										<select class="form-control" name="gred[]" id="gred<?=$bilr;?>">
											<option value="">Sila pilih gred</option>
											<?php $rsGred->movefirst();
											while(!$rsGred->EOF){ ?>
											<option value="<?=$rsGred->fields['GRED'];?>"<?php if($rsGred->fields['GRED']==$rsResult->fields['gred']){ print ' selected'; } ?>><?=$rsGred->fields['GRED'];?></option>	
											<?php $rsGred->movenext(); } ?>
										</select>
									</div>
									<div class="col-sm-1">
										<img src="../images/trash.png" title="Hapus maklumat matapelajaran & gred" style="cursor: pointer;"  
										width="25" height="30	" onclick="do_hapus('akademik/sql_akademik.php?frm=SRP&pro=SRP_DEL_REC&sid=<?=$rsResult->fields['srp_id'];?>')">
									</div>
								</div>
								<?php $rsResult->movenext(); } ?>

								<?php for($i=$bilr+1;$i<=10;){ ?>
								<div class="row">
									<div class="col-sm-8 col-xs-8" style="padding-bottom:5px;">
										<select name="mp[]" id="mp<?=$i;?>" class="form-control select2 select2-accessible mps<?=$i;?>" style="width: 100%;" aria-hidden="true" 
											onchange="Geeks(this.value,<?=$i;?>)">
											<option value="">Sila pilih matapelajaran</option>
											<?php $rsSRP->movefirst();
											while(!$rsSRP->EOF){ ?>
											<option value="<?=$rsSRP->fields['kod'];?>"><?=$rsSRP->fields['DISKRIPSI'];?></option>	
											<?php $rsSRP->movenext(); } ?>
										</select>
									</div>
									<div class="col-sm-3 col-xs-3" style="padding-bottom:5px;margin-left:-20px">
										<select class="form-control" name="gred[]" id="gred<?=$i;?>">
											<option value="">Sila pilih gred</option>
											<?php $rsGred->movefirst();
											while(!$rsGred->EOF){ ?>
											<option value="<?=$rsGred->fields['GRED'];?>"><?=$rsGred->fields['GRED'];?></option>	
											<?php $rsGred->movenext(); } ?>
										</select>
									</div>
									<input type="hidden" name="mp_old[]" value="">
								</div>
							<?php $i++; } ?>
							</div>
							<?php
								$sql = "SELECT COUNT(*) as total FROM $schema2.`kawalan_muatnaik_dokumen` WHERE is_deleted=0 AND `status`=0"; 
								$sql .=" AND tajuk_dokumen LIKE '%KEPUTUSAN PEPERIKSAAN PT3/PMR%'" ;
								$rsDoc = $conn->query($sql);
							?>
							<?php if($rsDoc->fields['total'] > 0){ ?>
							<div class="col-sm-4" align="center" style="border: 2px solid black; padding: 10px; border-radius: 25px;">
								<h6><b>Sijil PMR</b></h6>
								<img src="<?=$sijil;?>" width="100%" height="400">
								<?php if(!empty($rsSijil->fields['sijil_nama'])) { print $rsSijil->fields['sijil_nama']; }?><br>
								<input type="file" name="file_pmr" id="file_pmr" class="form-control" value="" onchange="do_input()">
								<small style="color: red;">Hanya menerima format png,jpg,jpeg @ gif dan tidak melebihi 300kb</small>
							</div>
							<?php } ?>
						</div>
					</div>
					<?php //} ?>

					<div class="modal-footer" style="padding:0px;">
						<button type="button" id="simpan" class="btn btn-primary mt-sm mb-sm" onclick="save_spr()"><i class="fa fa-save"></i> Simpan</button>
						<?php if(!empty($data['srp_tahun'])){ ?>
							<label class="btn btn-danger" onclick="do_hapus('akademik/sql_akademik.php?frm=SRP&pro=SRP_DEL&actions=<?=$actions;?>&id_pemohon=<?=$_SESSION['SESS_UID'];?>')">Hapus</label>
						<?php } ?>
						<input type="hidden" name="progid" id="progid" value="<?php //print $progid;?>" />
						<input type="hidden" name="proses" value="<?php //print $proses;?>" />
						<input type="hidden" name="chk" id="chk" value="<?=$datas;?>">

					</div>
				</div>

			
			</div>
		</div>
	     

<script language="javascript" type="text/javascript">
var srp_tahun = document.getElementById('srp_tahun').value;
//var srp_pangkat = document.getElementById('srp_pangkat');
// alert(srp_tahun);
// if(srp_tahun>='1993'){
// 	srp_pangkat.setAttribute('disabled', '');
// } else {
// 	srp_pangkat.removeAttribute('disabled');
// }
</script>		 
