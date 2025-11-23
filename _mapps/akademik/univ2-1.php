<script type="text/javascript">

function save_univ(){
	var bil_keputusan2 = $('#bil_keputusan2').val();
	var tahun1 = $('#tahun1').val();
	var peringkat1 = $('#peringkat1').val();
	var inst_keluar_sijil1 = $('#inst_keluar_sijil1').val();
	var pengkhususan1 = $('#pengkhususan1').val();
    
    if(tahun1.trim() =='' && bil_keputusan2.trim() == ''){
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

 	var fd = new FormData();
        var files1 = $('#file1')[0].files[0];
        fd.append('file1',files1);
        var files2 = $('#file2')[0].files[0];
        fd.append('file2',files2);
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
			
			// data: $("form").serialize(),
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

function get_univ(kod){
	var sel="#inst_keluar_sijil1";
	$.ajax({
		url: '../include/get_universiti.php?kod='+kod,
		type: 'post',
		data: {kod:kod},
		dataType: 'json',
		success:function(response){
			var len = response.length;
			$(sel).empty();
			$('#pengkhususan1').empty();
			for( var i = 0; i<len; i++){
				var id = response[i]['id'];
				var name = response[i]['name'];
				$(sel).append("<option value='"+id+"'>"+name+"</option>");
			}
			$('#pengkhususan1').append("<option value=''>Sila pilih</option>");
		}
	});
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
<div class="form-group">
	<div class="row">
		<div class="col-sm-8">
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
					<label for="nama" class="col-sm-4 control-label"><b>Tarikh Kelulusan <font color="#FF0000">*</font><div style="float:right"><img src="../images/info.gif" title="Tarikh kelulusan Senat merujuk kepada tarikh Senat institusi pengajian tinggi pemohon meluluskan penganugerahan Sijil/Diploma/Ijazah Sarjana Muda/Sarjana/Doktor Falsafah anda. Sila rujuk pihak institusi pengajian tinggi mengenai tarikh kelulusan senat pemohon"> :</div></b></label>
					<div class="col-sm-4"><input type="date" id="tkh_senate" name="tkh_senate" class="form-control" value="<?php print $rsUniv2->fields['tkh_senate'];?>">
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
							<option>Sila pilih peringkat kelulusan</option>
							<?php while(!$rfKelulusan->EOF){ ?>
							<option value="<?=$rfKelulusan->fields['kod'];?>" <?php if($rsUniv2->fields['peringkat']==$rfKelulusan->fields['kod']){ print 'selected'; }?>><?php print $rfKelulusan->fields['diskripsi'];?></option>	
							<?php $rfKelulusan->movenext(); } ?>
						</select>
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="row">
					<label for="nama" class="col-sm-4 control-label"><b>CGPA (PNGK) <div style="float:right">:</div></b></label>
					<div class="col-sm-2">
						<input type="text" name="cgpa1" id="cgpa1" class="form-control" value="<?=$rsUniv2->fields['cgpa'];?>" 
						oninput="validate(this)">
					</div>
					<label for="nama" class="col-sm-6 control-label">Masukkan 0.00 jika tiada CGPA/ tidak berkenaan. <br>
					Pemohon tidak dibenarkan untuk membundarkan CGPA(PNGK).</label>
				</div>
			</div>

			<?php //$conn->debug=true;
				// $rsInstitusi = $conn->query("SELECT * FROM `ref_institusi` WHERE `JENIS_INSTITUSI` IN (1,2) AND `SAH_YT`='Y' ORDER BY `DISKRIPSI` ASC "); 
				$query ="SELECT A.`su_id`, B.`DISKRIPSI` FROM $schema1.`ref_sijil_dan_univ` A, $schema1.`ref_institusi` B 
				WHERE A.`KOD`=B.`KOD` AND A.`sijil_kod`=".tosql($rsUniv2->fields['peringkat'])." ORDER BY B.`DISKRIPSI`";
				
				$query ="SELECT A.*, B.`KOD`, B.`DISKRIPSI` FROM $schema1.`padanan_peringkatkelulusan_institusi` A, $schema1.`ref_institusi` B  
				WHERE A.`kod_institusi`=B.`KOD` AND A.`is_deleted`=0 AND A.`status`=0 AND A.`kod_peringkat_kelulusan`=".tosql($rsUniv2->fields['peringkat']);

				$rsInstitusi = $conn->query($query);
			?>
			<div class="form-group">
				<div class="row">
					<label for="nama" class="col-sm-4 control-label"><b>Institusi yang mengeluarkan sijil <font color="#FF0000">*</font><div style="float:right">:</div></b></label>
					<div class="col-sm-8">
						<select name="inst_keluar_sijil1" id="inst_keluar_sijil1" class="form-control select2" style="width: 100%;" aria-hidden="true" onchange="get_pengkhususan(this.value)">
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

				$rsKhusus = $conn->query($query);
			?>
			<div class="form-group">
				<div class="row">
					<label for="nama" class="col-sm-4 control-label"><b>Nama Sijil <font color="#FF0000">*</font><div style="float:right">:</div></b></label>
					<div class="col-sm-8">
						<select name="pengkhususan1" id="pengkhususan1" class="form-control select2" style="width: 100%;" aria-hidden="true">
							<option value="">Sila pilih pengkhususan </option>
							<?php while(!$rsKhusus->EOF){ ?>
							<option value="<?=$rsKhusus->fields['kod'];?>" <?php if($rsUniv2->fields['pengkhususan']==$rsKhusus->fields['kod']){ print 'selected'; }?>><?php print $rsKhusus->fields['DISKRIPSI'];?></option>	
							<?php $rsKhusus->movenext(); } ?>
						</select>
					</div>
				</div>
			</div>
            <div class="form-group">
				<div class="row">
					<label for="nama" class="col-sm-4 control-label"><b>Keputusan MUET/CFER/Setaraf  <div style="float:right">:</div></b></label>
					<div class="col-sm-8">
						<select name="muet1" id="muet1" class="form-control">
							<option value="">Sila pilih </option>
							<option value="Band 1" <?php if($rsUniv2->fields['muet']=='Band 1'){ print 'selected'; }?>>Band 1</option>
							<option value="Band 2" <?php if($rsUniv2->fields['muet']=='Band 2'){ print 'selected'; }?>>Band 2</option>
							<option value="Band 3" <?php if($rsUniv2->fields['muet']=='Band 3'){ print 'selected'; }?>>Band 3</option>
							<option value="Band 4" <?php if($rsUniv2->fields['muet']=='Band 4'){ print 'selected'; }?>>Band 4</option>
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
		if(empty($rsSijil->fields['sijil_nama'])){ $sijil="../upload_doc/PMR_Mock_Result_Statement_Certificate.png"; }
		else { $sijil1 = "../uploads_doc/".$uid."/".$rsSijil->fields['sijil_nama']; }
		$rsSijil = $conn->query("SELECT * FROM $schema2.`calon_sijil` WHERE `jenis_sijil`='UNIV2B' AND `id_pemohon`=".tosql($uid));
		if(empty($rsSijil->fields['sijil_nama'])){ $sijil="../upload_doc/PMR_Mock_Result_Statement_Certificate.png"; }
		else { $sijil2 = "../uploads_doc/".$uid."/".$rsSijil->fields['sijil_nama']; }
		?>
		<div class="col-sm-4" align="center">
			<img src="<?=$sijil1;?>" width="300" height="400">
			<input type="file" name="file1"  id="file1" class="form-control">
		</div>

		<div class="col-sm-4" align="center"><br></div>

		<div class="col-sm-4" align="center">
			<img src="<?=$sijil2;?>" width="300" height="400">
			<input type="file" name="file2"  id="file2" class="form-control">
		</div>
	</div>
</div>

