<?php //include '../connection/common.php'; ?>
<script language="javascript">
function do_save(val1, val2){
	var pusat_temuduga = $('#pusat_temuduga').val();
	var id_pemohon = $('#id_pemohon').val();
 	var msg='';
	var selected = [];
	var datas = document.getElementById('selectTo');

     	for(var i=0; i < datas.length; i++){
		//alert(datas[i].value);
    		selected.push(datas[i].value);
     	}

    if(selected ==''){
        msg = msg+'\n- Sila pilih jawatan dipohon.';
        $("#selectTo").css("border-color","#f00");
    } 
    if(pusat_temuduga.trim() ==''){
        msg = msg+"\n- Sila pilih pusat tempat temuduga.";
        $("#poskod").css("border-color","#f00");
    } 

    // alert(selected);
    if(msg.trim() !=''){ 
		alert_msg_html(msg);
	} else {
		// var fd = new FormData();
        // // var jawatan = $('#fileupload')[0].files[0];
        // // var files2 = $('#upload_id2')[0].files[0];
        // fd.append('id_pemohon',id_pemohon);
        // fd.append('pusat_temuduga',pusat_temuduga);
        // fd.append('jawatan',selected);

		$.ajax({
	        url:'biodata/sql_mohon.php?frm=MOHON&pro=SAVE&id_pemohon='+id_pemohon+'&pusat_temuduga='+pusat_temuduga+'&jawatan='+selected,
			type:'POST',
	        //dataType: 'json',
	        beforeSend: function () {
	            // $('.btn-primary').attr("disabled","disabled");
	            // $('.modal-body').css('opacity', '.5');
	        },
			data: $("form").serialize(),
			// data:  fd,
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

function do_updj(){
	var id_pemohon = $('#id_pemohon').val();
	var pusat_temuduga = $('#pusat_temuduga').val();
 	var msg='';
 	var selected = [];
    for (var option of document.getElementById('selectTo').options){
        if (option) {
            selected.push(option.value);
        }
    }
	$.ajax({
        url:'biodata/sql_mohon.php?frm=MOHON&pro=SAVE&id_pemohon='+id_pemohon+'&pusat_temuduga='+pusat_temuduga+'&jawatan='+selected,
		type:'POST',
	    //dataType: 'json',
	    beforeSend: function () {
	        // $('.btn-primary').attr("disabled","disabled");
	        // $('.modal-body').css('opacity', '.5');
	    },
		data: $("form").serialize(),
		// data:  fd,
	    contentType: false,
	    cache: false,
	    processData:false,
		success: function(data){
			console.log(data);
			//alert(data);
		}
	});

}
</script>
<style type="text/css">
	.col-lg-3 {
    border: 1px solid;
}
</style>
<?php
if($_SESSION['SESS_UIC']=='840414145982'){
//$conn->debug=true;
}
// include 'akademik/sql_akademik.php';
// $data = get_exam($conn,$_SESSION['SESS_UID']);
// print_r($data);

$proses=isset($_GET["proses"])?$_GET["proses"]:"";
$progid=isset($_GET["progid"])?$_GET["progid"]:"";
$bilj=0;
$rsData = $conn->query("SELECT * FROM $schema2.`calon` WHERE `id_pemohon`=".tosql($_SESSION['SESS_UID']));

$givenArray = array();
$cond = ""; $bj=0;
// KELULUSAN PMR 
if(!empty($rsData->fields['srp_tahun'])){ 
	//PMR
	if($bj==0){ $cond.='1';  $givenArray[]=1; } else { $cond.=',1'; $givenArray[]=1; } 
	$bj++;
}
// KELULUSAN SPM
if(!empty($rsData->fields['spm_tahun_1']) || !empty($rsData->fields['spm_tahun_2'])){ 
	// if($bj==0){ $cond.='2'; } else { $cond.=',2'; } 
	if(!empty($rsData->fields['spm_jenis_sijil_1']) && $rsData->fields['spm_jenis_sijil_1']<>6){
		//SPM
		if($bj==0){ $cond.='2'; } else { $cond.=',2'; } 
		$bj++; $givenArray[]=2;
	}
	if(!empty($rsData->fields['spm_jenis_sijil_2']) && $rsData->fields['spm_jenis_sijil_2']<>6){
		//SPM
		if($bj==0){ $cond.='2'; } else { $cond.=',2'; } 
		$bj++; $givenArray[]=2; 
	}
	if(!empty($rsData->fields['spm_jenis_sijil_1']) && $rsData->fields['spm_jenis_sijil_1']==6){
		//SVM
		//SELECT * FROM `calon_svm` ORDER BY `calon_svm`.`updated_dt`
		$sijilid = dlookup("$schema2.`calon_svm`","nama_sijil","id_pemohon=".tosql($_SESSION['SESS_UID'])." AND tahun=".tosql($rsData->fields['spm_tahun_1']));
		if($sijilid!='99'){ 
			if($bj==0){ $cond.='3'; } else { $cond.=',3'; } 
			$bj++; $givenArray[]=3;
		}
		//print "DDD: ".$rsData->fields['spm_jenis_sijil_1'].":".$sijilid."<br>";
	}
	if(!empty($rsData->fields['spm_jenis_sijil_2']) && $rsData->fields['spm_jenis_sijil_2']==6){
		//SVM

		$sijilid = dlookup("$schema2.`calon_svm`","nama_sijil","id_pemohon=".tosql($_SESSION['SESS_UID'])." AND tahun=".tosql($rsData->fields['spm_tahun_2']));
		if($sijilid!='99'){ 
			if($bj==0){ $cond.='3'; } else { $cond.=',3'; } 
			$bj++; $givenArray[]=3;
		}
		//print "ZZZ: ".$rsData->fields['spm_jenis_sijil_2'].":".$sijilid."<br>";
	}

}
//print $cond;
// KELULUSAN IPT
// $conn->debug=true;
$rsUniv = $conn->query("SELECT * FROM $schema2.`calon_ipt` WHERE `id_pemohon`=".tosql($_SESSION['SESS_UID'])." ORDER BY peringkat");
if(!empty($rsData->fields['spm_tahun_1']) || !empty($rsData->fields['spm_tahun_2'])){ 
if(!$rsUniv->EOF){
	$DP='';
	$IP='';
	while(!$rsUniv->EOF){

	//print "AKA :".$rsUniv->fields['peringkat']."<br>";

		if(!empty($rsUniv->fields['peringkat'])){
			if($rsUniv->fields['peringkat']=='1'){ 
				//DIP PENDIDIKAN
				if($bj==0){ $cond.='6'; } else { $cond.=',6'; } 
				$bj++; $givenArray[]=6;
				$DP=1;

			} else if($rsUniv->fields['peringkat']=='2'){ 
				//DIP SAHAJA
				if($bj==0){ $cond.='7'; } else { $cond.=',7'; } 
				$bj++; $givenArray[]=7;

			} else if($rsUniv->fields['peringkat']=='3'){ 
				//IJAZAH PENDIDIKAN
				if($bj==0){ $cond.='4'; } else { $cond.=',4'; } 
				$bj++; $givenArray[]=4;
				$IP=1;

			} else if($rsUniv->fields['peringkat']=='4'){ 
				//IJAZAH SAHAJA
				if($bj==0){ $cond.='5'; } else { $cond.=',5'; } 
				$bj++; $givenArray[]=5;
				//print "DD:".$sijilid;
				/*if(!empty($sijilid) && $sijilid=='99'){		
					if($bj==0){ $cond.='9'; } else { $cond.=',9'; } 
					$bj++; $givenArray[]=9;
				}*/
			} else if($rsUniv->fields['peringkat']=='5'){ 
				//MASTER UTHM
				if($bj==0){ $cond.='8'; } else { $cond.=',8'; } 
				$bj++; $givenArray[]=8;

			} else if($rsUniv->fields['peringkat']=='6'){ 
				//MASTER
					if($bj==0){ $cond.='9'; } else { $cond.=',9'; } 
					$bj++; $givenArray[]=9;
				/*if(!empty($DP) && !empty($IP)){
					if($bj==0){ $cond.='9'; } else { $cond.=',9'; } 
					$bj++; $givenArray[]=9;
				} else if(!empty($DP) && empty($IP)){
					//if($bj==0){ $cond.='9'; } else { $cond.=',9'; } 
					//$bj++; $givenArray[]=9;
				} else {
					//if($bj==0){ $cond.='9'; } else { $cond.=',9'; } 
					//$bj++; $givenArray[]=9;
				}*/

			} else if($rsUniv->fields['peringkat']=='7'){ 
				//PHD
				if($bj==0){ $cond.='10'; } else { $cond.=',10'; } 
				$bj++; $givenArray[]=10;
			} 		
		}

		$rsUniv->movenext();
	}
}
} else {
	$cond = 0;
}
//print $cond."<br>";

$uniqueArry = array();
$bilu=0; $gcond=''; $ada5=''; $ada6='';
//print_r($givenArray);
foreach($givenArray as $val) { //Loop1 
	//print $val;
    foreach($uniqueArry as $uniqueValue) { //Loop2 
        if($val == $uniqueValue) {
            continue 2; // Referring Outer loop (Loop 1)
	}
    }
    if($bilu==0){ $gcond.=$val; } else { $gcond.=",".$val; }
    if($val==5){ $ada5='A'; }
    if($val==6){ $ada6='A'; }

    $bilu++;

    $uniqueArry[] = $val;
}

if(!empty($ada5) && !empty($ada6)){ $gcond .= ",4"; }
// print_r($uniqueArry);
if(empty($gcond)){ $gcond=$cond; }

//print '<br><font color="white">'.$cond."</font>";

	if($gcond=='8'){ $gcond=''; }
	else if($gcond=='1,8'){ $gcond='1,8'; } //updated
	else if($gcond=='1,2,8'){ $gcond='1,2,8'; } //updated
	else if($gcond=='1,2,9'){ $gcond='1,2,9'; } //new
	else if($gcond=='2,8'){ $gcond='2,8'; } //updated
	else if($gcond=='1,3,8'){ $gcond='1,3,8'; } //updated
	else if($gcond=='3,8'){ $gcond='3,8'; } //updated
	else if($gcond=='2,9'){ $gcond='2,9'; } //updated
	else if($gcond=='2,3,8'){ $gcond='2,3,8'; } //updated
	else if($gcond=='2,3,9'){ $gcond='2,3,9'; }  //updated
	else if($gcond=='2,5,6'){ $gcond='2,4,5,6'; }
	else if($gcond=='2,6,5'){ $gcond='2,4,5,6'; }

	else if($gcond=='1,2,5,6'){ $gcond='1,2,5,6'; }
	else if($gcond=='1,2,6,5'){ $gcond='1,2,4,5,6'; }
	else if($gcond=='1,2,6,5,4'){ $gcond='1,2,4,6'; }
	else if($gcond=='1,2,4,5'){ $gcond='1,2,4'; }

	else if($gcond=='1,2,5,8'){ $gcond='1,2,4,6'; }

	else if($gcond=='1,3,6,5'){ $gcond='1,3,4,5,6'; }
	else if($gcond=='3,6,5'){ $gcond='3,4,5,6'; }
	else if($gcond=='3,6,5,4'){ $gcond='3,4,6'; }
	else if($gcond=='3,8,5'){ $gcond='3,8'; }
	else if($gcond=='3,5,8'){ $gcond='3,8'; }
	else if($gcond=='5,8'){ $gcond='8'; }
	else if($gcond=='6,5,4'){ $gcond='6,4'; }
	else if($gcond=='4,5,6'){ $gcond='4,6'; }
	else if($gcond=='6,5,8,4'){ $gcond='6,8,4'; }
	else if($gcond=='2,6,5,8,4'){ $gcond='2,6,8,4'; }
	else if($gcond=='3,6,5,8,4'){ $gcond='3,6,8,4'; }
	else if($gcond=='2,3,6,5,8,4'){ $gcond='2,3,6,8,4'; }
	else if($gcond=='2,3,6,5,4'){ $gcond='2,3,6,4'; }
	else if($gcond=='2,3,5,8'){ $gcond='2,3,8'; }

	else if($gcond=='1,5,4,8'){ $gcond='1,3,5,8'; }
	else if($gcond=='1,5,7,8'){ $gcond='1'; }
	else if($gcond=='1,2,10'){ $gcond='1,2'; }
	else if($gcond=='5,9,6'){ $gcond='5,4,6,9'; }
	else if($gcond=='5,6,9'){ $gcond='5,4,6,9'; }

	else if($gcond=='1,5,9,6'){ $gcond='1,5,4,6,9'; }
	else if($gcond=='1,5,6,9'){ $gcond='1,5,4,6,9'; }
	else if($gcond=='3,5,9,6'){ $gcond='3,5,4,6,9'; }
	else if($gcond=='3,5,6,9'){ $gcond='3,5,4,6,9'; }
	else if($gcond=='1,3,5,9,6'){ $gcond='1,3,5,4,6,9'; }
	else if($gcond=='1,3,5,6,9'){ $gcond='1,3,5,4,6,9'; }
	else if($gcond=='1,2,5,9,6'){ $gcond='1,2,5,4,6,9'; }
	else if($gcond=='1,2,5,6,9'){ $gcond='1,2,5,4,6,9'; }	
	else if($gcond=='1,2,5,9,10,6'){ $gcond='1,2,5,4,6,9,10'; }
	else if($gcond=='1,2,5,6,9,10'){ $gcond='1,2,5,4,6,9,10'; }



//print "C:".$gcond;

//$gcond='1,2,9';
//$conn->debug=true;
if(!empty($gcond)){ 
$sqlJ = "SELECT * FROM $schema2.`calon_jawatan_dipohon` A, $schema1.`ref_skim` B, $schema1.`padanan_peringkatakademik_skim` C  
WHERE A.`kod_jawatan`=B.`KOD` AND A.`kod_jawatan`=C.`kod_skim` AND C.status=0";
$sqlJ .= " AND C.`kod_peringkat_akademik` IN ($gcond)";  
$sqlJ .= " AND A.`id_pemohon`=".tosql($_SESSION['SESS_UID']);  
$sqlJ .= "  GROUP BY B.`KOD` ORDER BY A.`seq_no` ASC";
$rsJawatan1 = $conn->query($sqlJ); $bil=0;
//print $rsJawatan1->recordcount();
$conn->debug=false;

$bl=0; $dataj='';
while(!$rsJawatan1->EOF){
	if($bl==0){
		$dataj = $rsJawatan1->fields['KOD'];
	} else {
		$dataj .= ",".$rsJawatan1->fields['KOD'];
	}
	$bl++;
	$rsJawatan1->movenext();
}
}
//$conn->debug=false;

?>
		<header class="panel-heading"  style="background-color:rgb(38, 167, 228)">
			<h6 class="panel-title"><font color="#000000" size="3"><b><?php print strtoupper($menu);?></b></font></h6>
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
							<!-- <div class="collapse" id="collapseExample">
							  <div class="card card-body">
									<label for="nama" class="col-sm-12 control-label"><b>ARAHAN : </b> 
										<ul>
											<li>Jumlah keseluruhan JAWATAN SPP yang dipilih mestilah tidak melebihi 3 jawatan. <br>
											** CONTOH : Jika kelayakan akademik adalah SPM, jawatan PMR + SPM + DIPLOMA = 3 jawatan sahaja.</li>
											<li>Jawatan yang dipilih adalah mengikut turutan nombor pilihan dari atas ke bawah. (Pilihan PERTAMA hingga KETIGA)</li>
										</ul>
									</label>

							  </div>
							</div> -->
							<div class="card">
									<label for="nama" class="col-sm-12 control-label" style="border: 1px solid rgb(38, 167, 228);"><b>ARAHAN : </b>
										<ul>
											<li>Jumlah keseluruhan JAWATAN SPP yang dipilih mestilah tidak melebihi 3 jawatan.</li>
											<li>Jawatan yang dipilih adalah mengikut turutan nombor pilihan dari atas ke bawah. (Pilihan PERTAMA hingga KETIGA)</li>
										</ul>
									</label>

							  </div>

						</div>
					</div>

					
					<div class="form-group">
						<div class="row">
							<div class="col-sm-12">
								<b>JAWATAN MAKSIMUM BERDASARKAN KELAYAKAN PEMOHON</b>
							</div>
						</div>
					</div>
					<?php
					// $conn->debug=true;
					if(!empty($gcond)){ 
					$sqlJ = "SELECT * FROM $schema1.`padanan_peringkatakademik_skim` A, $schema1.`ref_skim` B 
					WHERE A.`kod_skim`=B.`KOD` AND A.status=0 ";
					$sqlJ .= " AND A.`kod_peringkat_akademik` IN ($gcond)";
					if(!empty($dataj)){ $sqlJ .= " AND B.`KOD` NOT IN ($dataj)";  }
					$sqlJ .= " GROUP BY B.`KOD` ORDER BY B.KUMP_PKHIDMAT_JKK ASC";
					//$sqlJ .= " GROUP BY B.`KOD` ORDER BY B.KUMP_PKHIDMAT_JKK ASC, A.`kod_peringkat_akademik` DESC";

					
					$rsJawatan = $conn->query($sqlJ); $bil=0;
					}
					?>
					<fieldset>
				        <div class="row">
				            <div class="col-sm-5">
				                <div class="form-group">
				                    <div class="row">
				                        <label for="selectFrom"><b>Senarai Kelayakan Jawatan</b></label>
				                    </div>
				                    <div class="row">
				                        <select name="selectFrom" id="selectFrom" class="form-control input-medium" multiple size="7" style="overflow: scroll;min-height:200px">
				                        <?php
											if(!empty($gcond)){  
											while(!$rsJawatan->EOF){ $bil++;?>
				                            <option value="<?php print $rsJawatan->fields['kod'];?>"><?php print $rsJawatan->fields['DISKRIPSI'];?></option>
				                            <?php $rsJawatan->movenext(); } 
										} ?>
										</select>
				                    </div>
				                </div>
				            </div>
				            <div class="col-md-2 col-sm-2 col-xm-12">
				                <div class="row">&nbsp;</div>
				                <div class="row">
				                    <div class="col-sm-12" style="min-width: 100px;">
				                        <div class="btn-group-vertical btn-block" style="min-width: 100px;">
				                            <button id="btnAdd" name="btnAdd" type="button" class="btn btn-primary btn-small">Tambah<br><i class="fa fa-arrow-right"></i>
				                            </button>
				                            <button id="btnRemove" name="btnRemove" type="button" class="btn btn-primary btn-small"><i class="fa fa-arrow-left"></i><br>Hapus</button>
				                        </div>
				                    </div>
				                </div>
				                <div class="row">&nbsp;</div>
				            </div>
				            <?php if(!empty($gcond)){ $rsJawatan1->movefirst(); $bilj=0; } ?>
				            <div class="col-sm-4">
				                <div class="form-group">
				                    <div class="row">
				                        <label for="selectTo"><b>Senarai Pilihan Jawatan</b></label>
				                    </div>
				                    <div class="row">
				                        <select name="selectTo" id="selectTo" size="7" class="form-control input-medium" style="overflow: scroll;;min-height:200px">
				                        <?php 
											if(!empty($gcond)){	
											while(!$rsJawatan1->EOF){ $bilj++;?>
				                            <option value="<?php print $rsJawatan1->fields['kod'];?>"><?php print $rsJawatan1->fields['DISKRIPSI'];?></option>
				                            <?php $rsJawatan1->movenext(); } } ?>
				                        </select>
				                    </div>
				                </div>
				            </div>
				            <div class="col-sm-1">
				                <div class="row">&nbsp;</div>
				                <div class="row">
				                    <div class="col-sm-12">
				                        <div class="btn-group-vertical btn-block" style="min-width: 50px;">
				                            <button id="btnUp" name="btnUp" type="button" class="btn btn-primary btn-small"><i class="fa fa-arrow-up"></i>
								<div style="margin-left:-10px">Naik</div></button>
				                            <button id="btnDown" name="btnDown" type="button" class="btn btn-primary btn-small">
								<div style="margin-left:-5px">Turun</div><i class="fa fa-arrow-down"></i></button>
				                        </div>
				                    </div>
				                </div>
				                <div class="row">&nbsp;</div>
				            </div>
				        </div>
				    </fieldset>
				    <hr>
				    <?php $pusat = dlookup("$schema2.`calon_pusat_temuduga`","pusat_temuduga","id_pemohon=".tosql($_SESSION['SESS_UID'])); ?>
					<div class="form-group">
						<div class="row">
							<label for="nama" class="col-sm-7 control-label"><b>Pusat Temu Duga / Ujian Khas yang Dipilih Bagi Jawatan SPP Sahaja<font color="#FF0000">*</font><div style="float:right">:</div></b>
								<br><font style="color: red;">Sila pastikan pilihan Pusat Temu Duga adalah terhampir dengan tempat tinggal semasa.
								<br>Sebarang perubahan/pertukaran Pusat Temu Duga tidak akan dilayan.</font>
								</label>
							<div class="col-sm-5">
								<select name="pusat_temuduga" id="pusat_temuduga" class="form-control"> <!--onchange="do_updj()"-->
									<option value="">Sila pilih Pusat Temuduga</option>
									<?php //print get_negeri($conn, $pusat);  ?>
									<?php print get_pusat_temuduga($conn, $pusat); ?>
								</select>
							</div>
						</div>
					</div>

					
					
					<div class="modal-footer" style="padding:0px;">
						<button type="button" id="simpan" class="btn btn-primary mt-sm mb-sm" onclick="do_save('SAVE','')"><i class="fa fa-save"></i> Simpan</button>
						&nbsp;
						<!-- <button type="button" id="simpan_next" class="btn btn-success mt-sm mb-sm" onclick="do_save('SAVE','SEND')"><i class="fa fa-save"></i> Simpan & Hantar</button>
						&nbsp; -->
						<input type="hidden" name="progid" id="progid" value="<?php print $progid;?>" />
						<input type="hidden" name="proses" value="<?php print $proses;?>" />
					</div>
				</div>

			
			</div>
		</div>
	     

<script language="javascript" type="text/javascript">
/*global $:false */
$(document).ready(function () {
    'use strict';
    var cnt=<?=$bilj;?>;
    var jum=0;
    var totals=0;
    $('#btnAdd').click(function () {

    	jum = $('#selectFrom option:selected').length;
    	// alert(jum);
    	totals = jum+cnt;
    	if(totals>3){
    		swal({
			  title: 'Makluman',
			  text: 'MAAF! Maksimum hanya 3 jawatan sahaja boleh dimohon.',
			  type: 'success',
			  confirmButtonClass: "btn-success",
			  confirmButtonText: "Ok",
			  showConfirmButton: true,
			}).then(function () {
				//reload = window.location; 
				//window.location = reload;
			});
	    } else { 

	        $('#selectFrom option:selected').each(function () {
	        	cnt++;
	        	if(cnt<=3){
	            	$('#selectTo').append('<option value="' + $(this).val() + '">' + $(this).text() + '</option>');
	            }
	            $(this).remove();
	            // alert(cnt);
	            if(cnt>=3){
	            	// alert(cnt);
	            	do_updj();
	            	$("#btnAdd").prop("disabled",true);
	            }
	        });
    	}
    });
    $('#btnRemove').click(function () {
        $('#selectTo option:selected').each(function () {
        	cnt--;
            $('#selectFrom').append('<option value="' + $(this).val() + '">' + $(this).text() + '</option>');
            $(this).remove();
            if(cnt<3){
            	// alert(cnt);
            	do_updj();
            	$("#btnAdd").prop("disabled",false);
            }
        });
    });
    $('#btnUp').bind('click', function () {
        $('#selectTo option:selected').each(function () {
            var newPos = $('#selectTo option').index(this) - 1;
            if (newPos > -1) {
                $('#selectTo option').eq(newPos).before('<option value="' + $(this).val() + '" selected="selected">' + $(this).text() + '</option>');
                $(this).remove();
                do_updj();
            }
        });
    });
    $('#btnDown').bind('click', function () {
        var countOptions = $('#selectTo option').size();
        $('#selectTo option:selected').each(function () {
            var newPos = $('#selectTo option').index(this) + 1;
            if (newPos < countOptions) {
                $('#selectTo option').eq(newPos).after('<option value="' + $(this).val() + '" selected="selected">' + $(this).text() + '</option>');
                $(this).remove();
                do_updj();
            }
        });
    });
});
</script>

<?php 
if($bilj>=3){ 
?>
	<script type="text/javascript">
		$("#btnAdd").prop("disabled",true);
        //do_updj();
	</script>
<?php } 
//$conn->debuh=true;
if(!empty($bilj)){
	if(!empty($id_pemohon)){ 
		$conn->execute("DELETE FROM $schema2.`calon_jawatan_dipohon` WHERE `id_pemohon`=".tosql($id_pemohon));
	}
}
?>		 
