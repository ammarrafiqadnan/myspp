<script type="text/javascript">
function save_univ(){
	var bil_keputusan1 = $('#bil_keputusan1').val();
	var tahun1 = $('#tahun1').val();
	var tkh_senate = $('#tkh_senate').val();
	var peringkat1 = $('#peringkat1').val();
	var inst_keluar_sijil1 = $('#inst_keluar_sijil1').val();
	var pengkhususan1 = $('#pengkhususan1').val();
	var jenisMuetCefr1 = $('#jenisMuetCefr1').val();
	var tahunMuetCefr1 = $('#tahunMuetCefr1').val();
	var keputusanMuetCefr1 = $('#keputusanMuetCefr1').val(); 
	var cgpa1 = $('#cgpa1').val(); 

	var res = tkh_senate.split("/");
	var tkh = res[2]+'-'+res[1]+'-'+res[0];
	var yourDate = new Date();
	var tarikh_semasa = formatDate(yourDate);	

	var msg = '';
	if(jenisMuetCefr1.trim() != '' || tahunMuetCefr1 != '' || keputusanMuetCefr1 != ''){

	if(jenisMuetCefr1.trim() ==''){
		//if(tahunMuetCefr1.trim() =='' && keputusanMuetCefr1 ==''){
        		//msg = msg+'\n- Sila pilih jenis, tahun dan keputusan MUET.';
			//$("#jenisMuetCefr1").css("border-color","#f00");
        		//$("#tahunMuetCefr1").css("border-color","#f00");
			//$("#keputusanMuetCefr1").css("border-color","#f00");
		if(tahunMuetCefr1.trim() ==''){
			msg = msg+'\n- Sila pilih jenis dan tahun MUET.';
			$("#jenisMuetCefr1").css("border-color","#f00");
        		$("#tahunMuetCefr1").css("border-color","#f00");
		} else if(keputusanMuetCefr1.trim() ==''){
			msg = msg+'\n- Sila pilih jenis dan keputusan MUET.';
			$("#jenisMuetCefr1").css("border-color","#f00");
        		$("#keputusanMuetCefr1").css("border-color","#f00");
		} else {
			msg = msg+'\n- Sila pilih jenis MUET.';
        		$("#jenisMuetCefr1").css("border-color","#f00");
		}

    	} else if(tahunMuetCefr1.trim() ==''){
		//if(jenisMuetCefr1.trim() =='' && keputusanMuetCefr1 ==''){
        		//msg = msg+'\n- Sila pilih tahun, jenis dan keputusan MUET.';
			//$("#tahunMuetCefr1").css("border-color","#f00");
        		//$("#jenisMuetCefr1").css("border-color","#f00");
			//$("#keputusanMuetCefr1").css("border-color","#f00");
		if(jenisMuetCefr1.trim() ==''){
			msg = msg+'\n- Sila pilih tahun dan jenis MUET.';
			$("#tahunMuetCefr1").css("border-color","#f00");
        		$("#jenisMuetCefr1").css("border-color","#f00");
		} else if(keputusanMuetCefr1.trim() ==''){
			msg = msg+'\n- Sila pilih tahun dan keputusan MUET.';
			$("#tahunMuetCefr1").css("border-color","#f00");
        		$("#keputusanMuetCefr1").css("border-color","#f00");
		} else {
			msg = msg+'\n- Sila pilih tahun MUET.';
        		$("#tahunMuetCefr1").css("border-color","#f00");
		}

    	} else if(keputusanMuetCefr1.trim() ==''){
		//if(tahunMuetCefr1.trim() =='' && jenisMuetCefr1==''){
        		//msg = msg+'\n- Sila pilih jenis, tahun dan keputusan MUET.';
			//$("#jenisMuetCefr1").css("border-color","#f00");
        		//$("#tahunMuetCefr1").css("border-color","#f00");
			//$("#keputusanMuetCefr1").css("border-color","#f00");
		if(tahunMuetCefr1.trim() ==''){
			msg = msg+'\n- Sila pilih tahun dan keputusan MUET.';
			$("#keputusanMuetCefr1").css("border-color","#f00");
        		$("#tahunMuetCefr1").css("border-color","#f00");
		} else if(jenisMuetCefr1.trim() ==''){
			msg = msg+'\n- Sila pilih jenis dan keputusan MUET.';
			$("#jenisMuetCefr1").css("border-color","#f00");
        		$("#keputusanMuetCefr1").css("border-color","#f00");
		} else {
			msg = msg+'\n- Sila pilih keputusan MUET.';
        		$("#keputusanMuetCefr1").css("border-color","#f00");
		}
	} 
	}

	if(tahun1.trim() ==''){
        msg = msg+'\n- Sila pilih tahun graduasi.';
        $("#tahun1").css("border-color","#f00");
    } 
	if(tkh_senate.trim() ==''){
        msg = msg+'\n- Sila pilih tarikh kelulusan.';
        $("#tkh_senate").css("border-color","#f00");
    } 
	if(peringkat1.trim() ==''){
        msg = msg+'\n- Sila pilih peringkat kelulusan.';
        $("#peringkat1").css("border-color","#f00");
    } 
	if(cgpa1.trim() ==''){
        msg = msg+'\n- Sila masukkan 0.00 jika tiada CGPA/ tidak berkenaan. Pemohon tidak dibenarkan untuk membundarkan CGPA(PNGK).';
        $("#cgpa1").css("border-color","#f00");
    } 
	if(inst_keluar_sijil1.trim() ==''){
        msg = msg+'\n- Sila pilih institusi yang mengeluarkan sijil.';
        //$("#inst_keluar_sijil1").css("border-color","#f00");
	$(".inst_keluar_sijil1").each(function() {
		  $(this).siblings(".select2-container").css('border', '1px solid red');
		});

    } 
	if(pengkhususan1.trim() ==''){
        msg = msg+'\n- Sila pilih nama sijil.';
        //$("#pengkhususan1").css("border-color","#f00");
 		$(".pengkhususan1").each(function() {
		  $(this).siblings(".select2-container").css('border', '1px solid red');
		});
    } 
    
	if(tkh_senate.trim() !=''){
		if(tkh > tarikh_semasa){
        		msg = msg+'\n- Tarikh yang dipilih melepasi tarikh semasa.';
        		$("#tkh_senate").css("border-color","#f00");
		}
    	} 

    if(msg.trim() !=''){ 
	
		alert_msg_html(msg);
	
	} else {

 		var fd = new FormData();
        var files1 = $('#file1')[0].files[0];
        fd.append('file1',files1);
        var files2 = $('#file2')[0].files[0];
        fd.append('file2',files2);
	var files3 = $('#file3')[0].files[0];
        fd.append('file3',files3);
	fd.append('tahunMuetCefr1',tahunMuetCefr1);

	

        // fd.append('upload_id2',files2);

        var other_data = $('form').serializeArray();
	$.each(other_data,function(key,input){
		   fd.append(input.name,input.value);
	}); 

        $.ajax({
	        url:'akademik/sql_akademik.php?frm=UNIV&pro=SAVE2',
			type:'POST',
	        //dataType: 'json',
	        beforeSend: function () {
	            // $('.btn-primary').attr("disabled","disabled");
	            // $('.modal-body').css('opacity', '.5');
	        },
			// data:  formData,
			//data: $("form").serialize(),
			data:  fd,
            		contentType: false,
            		cache: false,
            		processData:false,
			// data.append('file_pmr', $('input[type=file]')[0].files[0]),
			// files: true,
            // contentType: false,
            // cache: false,
            // processData:false,
			success: function(data){
				//alert(data);
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

function get_univ(kod){
	var kods=$('#inst_keluar_sijil1').val();
	var sel="#inst_keluar_sijil1";
	$.ajax({
		url: '../include/get_universiti.php?kod='+kod,
		type: 'post',
		data: {kod:kod},
		dataType: 'json',
		success:function(data){
			var len = data.length;
			console.log(len);
			$(sel).empty();
			$('#pengkhususan1').empty();
			for( var i = 0; i<len; i++){
				var id = data[i]['id'];
				var name = data[i]['name'];
				$(sel).append("<option value='"+id+"'>"+name+"</option>");
			}
			$('#pengkhususan1').append("<option value=''>Sila pilih</option>");
		}
	});

	get_pengkhususan(kods);

}

function get_pengkhususan(kod){
	var peringkat1 = $('#peringkat1').val();
	var sel="#pengkhususan1";
	$.ajax({
		url: '../include/get_pengkhususan.php?kod='+kod+'&peringkat1='+peringkat1,
		type: 'post',
		data: {kod:kod},
		dataType: 'json',
		success:function(response){
			var len = response.length;
			$(sel).empty();
			for( var i = 0; i<len; i++){
				var id = response[i]['id'];
				var name = response[i]['name'];
				$(sel).append("<option value='"+id+"'>"+name+"</option>");
			}
		}
	});
}

function get_keputusan(tahun){
	var jenisMuetCefr1 = $('#jenisMuetCefr1').val();
	var sel="#keputusanMuetCefr1";
	$.ajax({
		url: '../include/get_keputusan.php?tahun='+tahun+'&jenisMuetCefr1='+jenisMuetCefr1 ,
		type: 'post',
		data: {jenisMuetCefr1:jenisMuetCefr1},
		dataType: 'json',
		success:function(response){
			var len = response.length;
			$(sel).empty();
			$('#keputusanMuetCefr1').empty();
			if(len > 0){
			for( var i = 0; i<len; i++){
				var kod = response[i]['kod'];
				var keputusan = response[i]['keputusan'];
				$(sel).append("<option value='"+kod+"'>"+keputusan+"</option>");
			}	
			} else {
				$(sel).append("<option value=''>Sila pilih Keputusan MUET/CEFR</option>");

			}
		}
	});
}
	

var validate = function(e) {
 	var t = e.value;
  	if(t<=4){ 
  		e.value = (t.indexOf(".") >= 0) ? (t.substr(0, t.indexOf(".")) + t.substr(t.indexOf("."), 3)) : t;
	} else {
		document.myspp.cgpa1.value='';
		//alert(t);
	}
}
</script>
<?php //$conn->debug=true;?>
<div class="form-group">
	<div class="row">
		<div class="col-sm-8"><br>
			<div class="form-group">
				<div class="row">
					<label for="nama" class="col-sm-4 control-label"><b>Tahun Graduasi <font color="#FF0000">*</font><div style="float:right">:</div></b></label>
					<div class="col-sm-4">
						<select class="form-control" name="tahun1" id="tahun1">
							<option value="">Sila pilih tahun</option>
							<?php for($t1=date("Y");$t1>=1978;$t1--){ ?>
							<option value="<?=$t1;?>" <?php if($rsUniv2->fields['tahun']==$t1){ print 'selected'; }?>><?=$t1;?></option>	
							<?php } ?>
						</select>
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="row">
					<label for="nama" class="col-sm-4 control-label"><b>Tarikh Kelulusan Senat </b><font color="#FF0000">*</font>
						<div style="float:right">
							<a title="Tarikh kelulusan Senat merujuk kepada tarikh Senat institusi pengajian tinggi pemohon meluluskan penganugerahan Sijil/Diploma/Ijazah Sarjana Muda/Sarjana/Doktor Falsafah anda. Sila rujuk pihak institusi pengajian tinggi mengenai tarikh kelulusan senat pemohon" >
                    						<i class="fa fa-info-circle fa-lg" aria-hidden="true"></i>
                					</a> :
						</div>
					</label>
					<div class="col-sm-4">
						<!--<input type="date" id="tkh_senate" name="tkh_senate" class="form-control" value="<?php print $rsUniv2->fields['tkh_senate'];?>">-->
						<input type="text" name="tkh_senate" id="tkh_senate"  size="15" maxlength="10" value="<?php print DisplayDate($rsUniv2->fields['tkh_senate']);?>" 
						data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask 
						class="form-control disableFuturedate icon" style="background-color: #fff; cursor: pointer;">
					</div>
				</div>
			</div>
			<?php 
				// $rfKelulusan = $conn->query("SELECT * FROM $schema1.`ref_sijil_universiti` WHERE `sijil_YT`='Y' ORDER BY `sijil_susun`"); 
				$rfKelulusan = $conn->query("SELECT * FROM $schema1.`ref_peringkat_kelulusan` WHERE `is_deleted`='0' AND `status`=0"); 
			?>
			<div class="form-group">
				<div class="row">
					<label for="nama" class="col-sm-4 control-label"><b>Peringkat Kelulusan <font color="#FF0000">*</font><div style="float:right">:</div></b></label>
					<div class="col-sm-8">
						<select name="peringkat1" id="peringkat1" class="form-control" onchange="get_univ(this.value)">
							<option value="">Sila pilih peringkat kelulusan</option>
							<?php while(!$rfKelulusan->EOF){ ?>
							<option value="<?=$rfKelulusan->fields['kod'];?>" <?php if($rsUniv2->fields['peringkat']==$rfKelulusan->fields['kod']){ print 'selected'; }?>><?php print $rfKelulusan->fields['diskripsi'];?></option>	
							<?php $rfKelulusan->movenext(); } ?>
						</select>
					</div>
				</div>
			</div>
			<?php
			$cgpa = $rsUniv2->fields['cgpa'];
			if(empty($cgpa)){ $cgpa=''; }
			?>
			<div class="form-group">
				<div class="row">
					<label for="nama" class="col-sm-4 control-label"><b>CGPA (PNGK) <div style="float:right"><a title="Masukkan 0.00 jika tiada CGPA/ tidak berkenaan. Pemohon tidak dibenarkan untuk membundarkan CGPA(PNGK)." >
                    						<i class="fa fa-info-circle fa-lg" aria-hidden="true"></i>
                					</a> :
					</div></b></label>
					<div class="col-sm-2">
						<input type="text" name="cgpa1" id="cgpa1" class="form-control" value="<?=$cgpa;?>" oninput="validate(this)">
					</div>
					<!--<label for="nama" class="col-sm-6 control-label">Masukkan 0.00 jika tiada CGPA/ tidak berkenaan. <br>
					Pemohon tidak dibenarkan untuk membundarkan CGPA(PNGK).</label>-->
				</div>
			</div>

			<?php 
				$rsInstitusi = $conn->query("SELECT * FROM $schema1.`ref_institusi` WHERE `JENIS_INSTITUSI` IN (1,2) AND `SAH_YT`='Y' ORDER BY `JENIS_INSTITUSI`, `DISKRIPSI` ASC "); 
				// $query ="SELECT A.`su_id`, B.`DISKRIPSI` FROM $schema1.`ref_sijil_dan_univ` A, $schema1.`ref_institusi` B 
				// WHERE A.`KOD`=B.`KOD` AND A.`sijil_kod`=".tosql($rsUniv2->fields['peringkat'])." ORDER BY B.`DISKRIPSI`";
				// $query ="SELECT B.`KOD`, B.`DISKRIPSI` FROM $schema1.`padanan_peringkatkelulusan_institusi` A, $schema1.`ref_institusi` B  
				// WHERE A.`kod_institusi`=B.`KOD` AND A.`is_deleted`=0 AND A.`status`=0 AND A.`kod_peringkat_kelulusan`=".tosql($rsUniv2->fields['peringkat']);  
				// $rsInstitusi = $conn->query($query);

			?>
			<div class="form-group">
				<div class="row">
					<label for="nama" class="col-sm-4 control-label"><b>Institusi yang mengeluarkan sijil <font color="#FF0000">*</font><div style="float:right">:</div></b></label>
					<div class="col-sm-8">
						<select name="inst_keluar_sijil1" id="inst_keluar_sijil1" class="form-control select2 inst_keluar_sijil1" style="width: 100%;" aria-hidden="true" onchange="get_pengkhususan(this.value)">
							<option value="">Sila pilih institusi</option>
							<?php while(!$rsInstitusi->EOF){ ?>
							<option value="<?=$rsInstitusi->fields['KOD'];?>" <?php if($rsUniv2->fields['inst_keluar_sijil']==$rsInstitusi->fields['KOD']){ print 'selected'; }?>><?php print $rsInstitusi->fields['DISKRIPSI'];?></option>	
							<?php $rsInstitusi->movenext(); } ?>
						</select>
					</div>
				</div>
			</div>

			<?php if(empty($rsUniv2->fields['inst_francais'])){ $inst_francais='T'; } else { $inst_francais = $rsUniv2->fields['inst_francais']; } ?>
			<div class="form-group">
				<div class="row">
					<label for="nama" class="col-sm-4 control-label"><b>Institusi Francais Luar Negara <font color="#FF0000">*</font><div style="float:right">:</div></b></label>
					<div class="col-sm-8">
						<input type="radio" name="inst_francais1" value="Y" <?php if($inst_francais=='Y'){ print 'checked'; }?>> YA &nbsp; 
						<input type="radio" name="inst_francais1" value="T" <?php if($inst_francais=='T'){ print 'checked'; }?>> TIDAK 
					</div>
				</div>
			</div>
			<!-- <?php if(empty($rsUniv2->fields['bidang'])){ $bidang='S'; } else { $bidang = $rsUniv2->fields['bidang']; } ?>
			<div class="form-group">
				<div class="row">
					<label for="nama" class="col-sm-4 control-label"><b>Bidang pengkhususan <font color="#FF0000">*</font><div style="float:right">:</div></b></label>
					<div class="col-sm-8">
						<input type="radio" name="bidang1" value="P" <?php if($bidang=='P'){ print 'checked'; }?>> Pendidikan &nbsp; 
						<input type="radio" name="bidang1" value="B" <?php if($bidang=='B'){ print 'checked'; }?>> Bukan Pendidikan &nbsp;
						<input type="radio" name="bidang1" value="S" <?php if($bidang=='S'){ print 'checked'; }?>> Semua &nbsp; 
					</div>
				</div>
			</div> -->

			<?php 
				//$conn->debug=true;
				$peringkats = $rsUniv2->fields['peringkat'];
				$query ="SELECT A.`kod`, B.`DISKRIPSI` FROM $schema1.`padanan_institusi_pengkhususan` A, $schema1.`ref_pengkhususan` B 
				WHERE A.`kod_pengkhususan`=B.`kod` AND A.`kod_institusi`=".tosql($rsUniv2->fields['inst_keluar_sijil'])." 
				AND A.status=0 AND B.STATUS=0 AND B.is_deleted=0 ";  
				if($peringkats == '1' || $peringkats == '3' || $peringkats == '5'){
					$query .= " AND A.kategori=1";
					if($peringkats == '1'){
						$query .= " AND A.peringkat_kelulusan=1";
					} else if($peringkats == '3'){
						$query .= " AND A.peringkat_kelulusan=2";
					}  else if($peringkats == '5'){
						$query .= " AND A.peringkat_kelulusan=3";
					}
				} else if($peringkats == '2' || $peringkats == '4' || $peringkats == '6' || $peringkats == '7'){
					$query .= " AND A.kategori=2";

					if($peringkats == '2'){
						$query .= " AND A.peringkat_kelulusan=1";
					} else if($peringkats == '4'){
						$query .= " AND A.peringkat_kelulusan=2";
					}  else if($peringkats == '6'){
						$query .= " AND A.peringkat_kelulusan=3";
					}  else if($peringkats == '7'){
						$query .= " AND A.peringkat_kelulusan=4";
					}
				}
				$query .= " ORDER BY B.`DISKRIPSI`";
				//print $query;
				$rsKhusus = $conn->query($query);
			?>
			<div class="form-group">
				<div class="row">
					<label for="nama" class="col-sm-4 control-label"><b>Nama Sijil <font color="#FF0000">*</font><div style="float:right">:</div></b></label>
					<div class="col-sm-8">
						<select name="pengkhususan1" id="pengkhususan1" class="form-control  select2 pengkhususan1" style="width: 100%;" aria-hidden="true">
							<option value="">Sila pilih </option>
							<?php while(!$rsKhusus->EOF){ ?>
							<option value="<?=$rsKhusus->fields['kod'];?>" <?php if($rsUniv2->fields['pengkhususan']==$rsKhusus->fields['kod']){ print 'selected'; }?>><?php print $rsKhusus->fields['DISKRIPSI'];?></option>	
							<?php $rsKhusus->movenext(); } ?>
						</select>
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="row">
					<!-- PENJAJARAN UJIAN BAHASA INGGERIS DENGAN TAHAP CEFR_FINAL.pdf -->
					<label for="nama" class="col-sm-12 control-label"><b>Keputusan Penguasaan Bahasa Inggeris</b> 
						<a href="../view_doc3.php"  data-toggle="modal" data-target="#myModal">
                    		<i class="fa fa-info-circle fa-lg" aria-hidden="true"></i>
                		</a>

					</label>
				</div>
			</div>

            		<div class="form-group">
				<div class="row">
					<label for="nama" class="col-sm-4 control-label"><b>Jenis Peperiksaan</b><div style="float:right">:</div></label>

					<?php
					//$conn->debug=true;
    				$sql3 = "SELECT * FROM $schema1.`ref_jenis_peperiksaanBI` WHERE `status`=0 AND `is_deleted`=0";
    				$rsJP = $conn->query($sql3);
        			?>
					<div class="col-sm-8">
						<select name="jenisMuetCefr1" id="jenisMuetCefr1" class="form-control" onchange="get_keputusan(this.value)">
							<option value="">Sila pilih </option>
        					<?php while(!$rsJP->EOF){ $code = $rsJP->fields['kod']; ?>    
            				<option value="<?=$code;?>" <?php if($rsUniv2->fields['muet']==$code){ print 'selected'; }?>><?php print $rsJP->fields['diskripsi'];?></option>
        					<?php $rsJP->movenext(); } ?>
						</select>
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="row">
					<label for="nama" class="col-sm-4 control-label"><b>Tahun</b><div style="float:right">:</div></label>
					<div class="col-sm-4">
						<?php $d = date("Y");?>
						<select name="tahunMuetCefr1" id="tahunMuetCefr1" class="form-control" onchange="get_keputusan(this.value)" value="<?=$i;?>">
							<option value="">Sila pilih tahun</option>
							<?php for($t1=date("Y");$t1>=1999;$t1--){ ?>
                   			<option value="<?=$t1;?>" <?php if($rsUniv2->fields['muet_tahun']==$t1){ print 'selected'; }?>><?=$t1;?></option>
                    		<?php } ?>						
						</select>
					</div>
					
				</div>
			</div>

			<div class="form-group">
				<div class="row">

					<label for="nama" class="col-sm-4 control-label"><b>Keputusan BAND/TAHAP CEFR</b><div style="float:right">:</div></label>
					<?php
					$sql3 = "SELECT * FROM $schema1.padanan_jenisPeperiksaan_keputusan WHERE kod_jenis_peperiksaan=".tosql($rsUniv2->fields['muet']);
    				$rsJK = $conn->query($sql3);
        			?>

					<div class="col-sm-7">
						<select name="keputusanMuetCefr1" id="keputusanMuetCefr1" class="form-control">
							<option value="">Sila pilih Keputusan MUET/CEFR</option>
							<?php while(!$rsJK->EOF){ 
								$code = $rsJK->fields['kod']; 
								$kep = '';
								if(!empty($rsJK->fields['band'])){ $kep = $rsJK->fields['band']; }
								if(!empty($rsJK->fields['gred'])){ 
									if(!empty($kep)){ $kep .= " / "; }
									$kep .= $rsJK->fields['gred']; 
								}
								if(!empty($rsJK->fields['cefr'])){ 
									if(!empty($kep)){ $kep .= " / "; } 
									$kep .= $rsJK->fields['cefr']; 
								}
							?>    
            				<option value="<?=$code;?>" <?php if($rsUniv2->fields['muet_gred']==$code){ print 'selected'; }?>><?php print $kep;?></option>
        					<?php $rsJK->movenext(); } ?>
						</select>
					</div>

					
				</div>
			</div>


			<div class="form-group">
				<div class="row">
					<label for="nama" class="col-sm-12 control-label"><b>Salah satu biasiswa yang diperolehi bagi salah satu pengajian di atas:</b></label>
				</div>
			</div>

			<?php $rsBiasiswa = $conn->query("SELECT * FROM $schema1.`ref_biasiswa` WHERE 1 ORDER BY `kod_biasiswa` ASC "); ?>
			<div class="form-group">
				<div class="row">
					<label for="nama" class="col-sm-4 control-label"><b>Biasiswa Pengajian  <div style="float:right">:</div></b></label>
					<div class="col-sm-8">
						<select name="biasiswa1" id="biasiswa" class="form-control">
							<option value="">Sila pilih biasiswa</option>
							<?php while(!$rsBiasiswa->EOF){ ?>
							<option value="<?=$rsBiasiswa->fields['kod_biasiswa'];?>" <?php if($rsUniv2->fields['biasiswa']==$rsBiasiswa->fields['kod_biasiswa']){ print 'selected'; }?>><?php print $rsBiasiswa->fields['biasiswa'];?></option>	
							<?php $rsBiasiswa->movenext(); } ?>
						</select>
						</select>
					</div>
				</div>
			</div>
		</div>

		<?php
		$rsSijil = $conn->query("SELECT * FROM $schema2.`calon_sijil` WHERE `jenis_sijil`='UNIV2A' AND `id_pemohon`=".tosql($uid));
		//if(empty($rsSijil->fields['sijil_nama'])){ $sijil1="../upload_doc/sijil_diploma.jpg"; }
		//else { $sijil1 = "/upload/".$uid."/".$rsSijil->fields['sijil_nama']; }
		if(empty($rsSijil->fields['sijil_nama'])){ $sijil_pic1 ="/var/www/html/myspp/upload_doc/sijil_diploma.jpg"; }
		else { $sijil_pic1 = "/var/www/upload/".$uid."/".$rsSijil->fields['sijil_nama']; }
 		//print $sijil;
		if (file_exists($sijil_pic1)){
    			$b64image = base64_encode(file_get_contents($sijil_pic1));
     			$sijil1 = "data:image/png;base64,$b64image";
		}

		$rsSijil2 = $conn->query("SELECT * FROM $schema2.`calon_sijil` WHERE `jenis_sijil`='UNIV2B' AND `id_pemohon`=".tosql($uid));
		//if(empty($rsSijil2->fields['sijil_nama'])){ $sijil2="../upload_doc/sijil_muet.jpg"; }
		//else { $sijil2 = "/upload/".$uid."/".$rsSijil2->fields['sijil_nama']; }
		if(empty($rsSijil2->fields['sijil_nama'])){ $sijil_pic2 ="/var/www/html/myspp/upload_doc/sijil_muet.jpg"; }
		else { $sijil_pic2 = "/var/www/upload/".$uid."/".$rsSijil2->fields['sijil_nama']; }
 		//print $sijil;
		if (file_exists($sijil_pic2)){
		     $b64image = base64_encode(file_get_contents($sijil_pic2));
		     $sijil2 = "data:image/png;base64,$b64image";
		}

		$rsSijil32 = $conn->query("SELECT * FROM $schema2.`calon_sijil` WHERE `jenis_sijil`='UNIV2C' AND `id_pemohon`=".tosql($uid));

		?>
		<?php
			$sql = "SELECT COUNT(*) as total FROM $schema2.`kawalan_muatnaik_dokumen` WHERE is_deleted=0 AND `status`=0"; 
			$sql .=" AND tajuk_dokumen LIKE '%Keputusan Pengajian Tinggi (Sijil Akademik)%'" ;
			$rsDoc = $conn->query($sql);
		?>
		<?php if($rsDoc->fields['total'] > 0){ ?>

		<div class="col-sm-4" align="center" style="border: 2px solid black; padding: 10px; border-radius: 25px;">
			<h6><b>Sijil Pengajian Tinggi</b></h6>
			<img src="<?=$sijil1;?>" width="100%" height="350">
			<?php print $rsSijil->fields['sijil_nama'];?>
			<input type="file" name="file1"  id="file1" class="form-control" onchange="do_input('sijil1')" value="">
			<small style="color: red;">Hanya menerima format png,jpg,jpeg @ gif dan tidak melebihi 300kb</small>
		</div>
		<?php } ?>
		<?php
			$sql = "SELECT COUNT(*) as total FROM $schema2.`kawalan_muatnaik_dokumen` WHERE is_deleted=0 AND `status`=0"; 
			$sql .=" AND tajuk_dokumen LIKE '%Keputusan Pengajian Tinggi (Sijil Akademik)%'" ;
			$rsDoc = $conn->query($sql);
		?>
		<?php if($rsDoc->fields['total'] > 0){ ?>

		<div class="col-sm-4" align="center"><br></div>

		<div class="col-sm-4" align="center" style="border: 2px solid black; padding: 10px; border-radius: 25px;">
			<h6><b>Transkrip Pengajian Tinggi</b></h6>
			<?php if(empty($rsSijil32->fields['sijil_nama'])){ 
				print "Tiada Sijil Dimuat Naik"; 
			} else { ?>
				<!--<a href="../view_doc_pemohon.php?id_pemohon=<?=$uid;?>&doc=<?=$rsSijil32->fields['sijil_nama'];?>" data-toggle="modal" data-target="#myModal"><?=$rsSijil32->fields['sijil_nama'];?></a>--> 
				<a href="../view_doc_pemohon.php?id_pemohon=<?=$uid;?>&doc=<?=$rsSijil32->fields['sijil_nama'];?>" 
				onclick="return popitup('../view_doc_pemohon.php?id_pemohon=<?=$uid;?>&doc=<?=$rsSijil32->fields['sijil_nama'];?>')"><?=$rsSijil32->fields['sijil_nama'];?></a> 
			<?php } ?>

			<input type="file" name="file3"  id="file3" class="form-control" onchange="do_input('sijil3')" value="">
			<small style="color: red;">Hanya menerima format pdf</small>
		</div>
		<?php } ?>
		<?php
			$sql = "SELECT COUNT(*) as total FROM $schema2.`kawalan_muatnaik_dokumen` WHERE is_deleted=0 AND `status`=0"; 
			$sql .=" AND tajuk_dokumen LIKE '%KEPUTUSAN PENGAJIAN TINGGI (MUET/CEFR/SETARAF)%'" ;
			$rsDoc = $conn->query($sql);
		?>
		<?php if($rsDoc->fields['total'] > 0){ ?>

		<div class="col-sm-4" align="center"><br></div>

		<div class="col-sm-4" align="center" style="border: 2px solid black; padding: 10px; border-radius: 25px;">
			<h6><b>Sijil Penguasaan Bahasa Inggeris</b></h6>
			<img src="<?=$sijil2;?>" width="100%" height="350">
			<?php print $rsSijil2->fields['sijil_nama'];?>
			<input type="file" name="file2"  id="file2" class="form-control" onchange="do_input('sijil2')" value="">
			<small style="color: red;">Hanya menerima format png,jpg,jpeg @ gif dan tidak melebihi 300kb</small>
		</div>
		<?php } ?>
	</div>
</div>

