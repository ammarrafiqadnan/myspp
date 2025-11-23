<script src="../js/select2.min.js"></script>
<link href="../css/select2.min.css" rel="stylesheet" />

<script>

	function do_close1(){
		reload = window.location; 
		window.location = reload;
	}
	function do_tambah(id){
		// var id_kmp = document.myspp.id_kmp.value;
		var kod = document.myspp.gkod.value;
		var kluster = document.myspp.gkluster.value;
		var matapelajaran = document.myspp.gmatapelajaran.value;
		var bidang = document.myspp.gbidang.value;
		var kod = document.myspp.gpengkhususan1.value;

		$.ajax({
			url:'pengurusan/kod_kluster/sql_pengkhususan.php?frm=KLUSTER&pro=ADD&kod='+kod+'&gkluster='+kluster+'&gmp='+matapelajaran+'&gbidang='+bidang, //&datas='+datas,
			type:'POST',
			
			data: $("form").serialize(),
			success: function(data){
				console.log(data);
				//alert(data);
				do_reload();
			}
		});
		// do_reload();
	}

	
	function do_pilihkod(){
		var fav = [];
		$.each($("input[name='kods']:checked"), function(){            
		    fav.push($(this).val());
		});
		// alert(fav);
		if(fav == '' ){
			swal({
				title: 'Maklumat',
				text: 'Sila pilih data untuk disimpan',
				type: 'info',
				confirmButtonClass: "btn-info",
				confirmButtonText: "Ok",
				showConfirmButton: true,
			})
		} else { 
			// var kod = document.myspp.gkod.value;
			var kluster = document.myspp.gkluster.value;
			var matapelajaran = document.myspp.gmatapelajaran.value;
			var bidang = document.myspp.gbidang.value;
			// var kod = document.myspp.gpengkhususan1.value;
			$.ajax({
				url:'pengurusan/kod_kluster/sql_pengkhususan.php?frm=KLUSTER&pro=ADD&kod='+fav+'&gkluster='+kluster+'&gmp='+matapelajaran+'&gbidang='+bidang, //&datas='+datas,
				type:'POST',
				
				data: $("form").serialize(),
				success: function(data){
					console.log(data);
					//alert(data);
					do_reload();
				}
			});
		}
	}

	function do_hapus_all(){
	swal({
			title: 'Adakah anda pasti untuk menghapuskan data ini?',
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
			var kluster = document.myspp.gkluster.value;
			var matapelajaran = document.myspp.gmatapelajaran.value;
			var bidang = document.myspp.gbidang.value;

			$.ajax({
				url:'pengurusan/kod_kluster/sql_pengkhususan.php?frm=KLUSTER&pro=HAPUS_ALL&gkluster='+kluster+'&gmp='+matapelajaran+'&gbidang='+bidang, //&datas='+datas,
			type:'POST',
				//dataType: 'json',
				beforeSend: function () {
					//$('.btn-primary').attr("disabled","disabled");
					//$('.modal-body').css('opacity', '.5');
				},
				data: $("form").serialize(),
				//data: datas,
				success: function(data){
					console.log(data);
					// alert(data);
					if(data=='OK' || data=='"OK"'){
						// alert('sini');
						swal({
						title: 'Berjaya',
						text: 'Maklumat telah berjaya dihapuskan',
						type: 'success',
						confirmButtonClass: "btn-success",
						confirmButtonText: "Ok",
						showConfirmButton: true,
						}).then(function () {
							var url = document.myspp.urls.value;
							$("#modal-content").load(url);
						});
					} else if(data=='ERR'){
						// alert('sini2');

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

	function do_hapus(id){
		$.ajax({
			url:'pengurusan/kod_kluster/sql_pengkhususan.php?frm=KLUSTER&pro=HAPUS&id_klu='+id, //&datas='+datas,
			type:'POST',
			
			data: $("form").serialize(),
			success: function(data){
				console.log(data);
				//alert(data);
				do_reload();
			}
		});
		
	}

	function do_reload(){
		var url = document.myspp.urls.value;
		$("#modal-content").load(url);
	}

		function do_save(){
		var kluster = $('#kluster').val();
		var status_kluster = $('#status_kluster').val();

		if(kluster.trim() == '' ){
			alert_msg('Sila isi maklumat kluster.');
			$('#kluster').focus(); return true;
		} else if(status_kluster.trim() == '' ){
			alert_msg('Sila pilih maklumat status kluster.');
			$('#status_kluster').focus(); return true;
		} else { 
			$.ajax({
				url:'pengurusan/sql_pengurusan.php?frm=PARAMETER&jenis=KLUSTER&pro=SAVE',
				type:'POST',
				//dataType: 'json',
				// beforeSend: function () {
				// 	$('.btn-primary').attr("disabled","disabled");
				// 	$('.modal-body').css('opacity', '.5');
				// },
				data: $("form").serialize(),
				success: function(data){
					console.log(data);
					if(data=='OK'){
						swal({
							title: 'Berjaya',
							text: 'Maklumat telah berjaya disimpan',
							type: 'success',
							confirmButtonClass: "btn-success",
							confirmButtonText: "Ok",
							showConfirmButton: true,
						}).then(function () {
							// window.location.href = url;
							reload = window.location; 
							window.location = reload;
						});
					} else if(data=='ERR'){
						swal({
							title: 'Amaran',
							text: 'Terdapat ralat sistem.\nMaklumat anda tidak berjaya diproses.',
							type: 'error',
							confirmButtonClass: "btn-warning",
							confirmButtonText: "Ok",
							showConfirmButton: true,
						});
					}
				},
			});   
		}
	}


	function do_sel(val){
		document.myspp.gkod.value=val;
	}

	function do_cari(jenis){ 
		// var carian = document.myspp.carian.value;
		var carian = $('#makl').val();
		var codes = $('#codes').val();
		let result = carian.replace(/ /g, "_");
		if(carian.trim() == '' ){
			swal({
				title: 'Makluman',
				text: 'Sila isi maklumat carian',
				type: 'info',
				confirmButtonClass: "btn-info",
				confirmButtonText: "Ok",
				showConfirmButton: true,
			});
		} else {
	    	$("#div_element").load('pengurusan/kod_kluster/sql_carian.php?jenis='+jenis+'&makl='+result+'&kod_get='+codes);  
		}
	}; 

	function do_chks(val){
		// alert(val);
	}
</script>
<?php
// $conn->debug=true; 
$kluster=isset($_REQUEST["kluster"])?$_REQUEST["kluster"]:"";
$mp=isset($_REQUEST["mp"])?$_REQUEST["mp"]:"";
$bidang=isset($_REQUEST["bidang"])?$_REQUEST["bidang"]:"";

$href_kelas = "modal_form.php?win=".base64_encode('pengurusan/kod_kluster/padanan_pengkhususan_kluster_form.php;');
$urls_get = $href_kelas."&kluster=".$kluster."&mp=".$mp."&bidang=".$bidang; //."&id_kmp=".$id_kmp;

// print $kluster.":".$matapelajaran.":".$bidang;

// $kluster_desc = dlookup("$schema1.`ref_kluster_main`","diskripsi","kod=".tosql($kluster));
$matapelajaran_desc = dlookup("$schema1.`ref_kluster`","diskripsi","kod=".tosql($mp));
$bidang_desc = dlookup("$schema1.`ref_bidang`","diskripsi","kod=".tosql($bidang));


$kluster_kod=isset($_REQUEST["kluster_kod"])?$_REQUEST["kluster_kod"]:"";
$sql3 = "SELECT * FROM $schema1.`ref_kluster_main` WHERE kod='{$kluster}'";
$rs = $conn->query($sql3);
$km_jenis = $rs->fields['km_jenis'];
$kluster_desc = $rs->fields['diskripsi'];

?>
<div class="col-lg-12">
	<section class="panel">
		<header class="panel-heading"  style="background-color:rgb(38, 167, 228)">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="do_close()">×</button>
			<h6 class="panel-title"><font color="#000000" size="3"><b><?php if(!empty($kluster_kod)){ print 'KEMASKINI'; } else { print 'TAMBAH'; } ?> MAKLUMAT KLUSTER & MATAPELAJARAN</b></font></h6>
		</header>
		<div class="panel-body">
			<div class="box-body">
            
			<input type="hidden" width="300" name="urls" id="urls" value="<?=$urls_get;?>" />
			<input type="hidden" name="id_kmp" id="id_kmp" value="<?php print $id_kmp; ?>"/>
			<input type="hidden" name="gkluster" id="gkluster" value="<?php print $kluster; ?>"/>
			<input type="hidden" name="gmatapelajaran" id="gmatapelajaran" value="<?php print $mp; ?>"/>
			<input type="hidden" name="gbidang" id="gbidang" value="<?php print $bidang; ?>"/>
			<input type="hidden" name="gkod" id="gkod" value=""/>


				<div class="col-md-12">
                    			<div class="form-group">
						<div class="row">
							<label for="kluster" class="col-sm-2 control-label"><b>Kluster <font color="#FF0000">*</font> : </b></label>
							<div class="col-sm-10"><?php print $kluster_desc;?></div>
						</div>
					</div>
                    			<div class="form-group">
						<div class="row">
							<label for="kluster" class="col-sm-2 control-label"><b>Matapelajaran <font color="#FF0000">*</font> : </b></label>
							<div class="col-sm-10"><?php print $matapelajaran_desc;?></div>
						</div>
					</div>
                    <div class="form-group">
						<div class="row">
							<label for="kluster" class="col-sm-2 control-label"><b>Bidang <font color="#FF0000">*</font> : </b></label>
							<div class="col-sm-10"><?php print $bidang_desc;?></div>
						</div>
					</div>
					<!--
					<div class="form-group">
						<div class="row">
                            <label for="tajuk" class="col-sm-2 control-label"><b>Status <font color="#FF0000">*</font> : </b></label>
							<div class="col-sm-3">
                                <select name="status_kluster" id="status_kluster" class="form-control">
                                    <option value="">Sila pilih status</option>
                                    <option value="0" <?php if(!empty($kluster_kod)){ if($rs->fields['status'] == 0){ print 'selected';}} ?>>Aktif</option>
                                    <option value="1" <?php if(!empty($kluster_kod)){  if($rs->fields['status'] == 1){ print 'selected';} } ?>>Tidak Aktif</option>
                                </select>
                            </div>
						</div>
					</div>
					-->

					<?php 
					//$conn->debug=true;
					$rsC = $conn->query("SELECT A.`id` AS id_klu, B.*  
					FROM $schema1.`ref_padanan_kluster` A, $schema1.`padanan_institusi_pengkhususan` B 
				        WHERE A.`kod_pengkhususan`=B.`kod` AND A.`is_deleted`=0 AND A.`kod_kluster`=".tosql($kluster)." 
						AND A.is_deleted=0 AND A.`kod_mpelajaran`=".tosql($mp)." AND A.`kod_bidang`=".tosql($bidang));
					?>
					<div class="form-group">
						<div class="row">
                            <label for="tajuk" class="col-sm-2 control-label"><b>Pengkhususan : </b></label>
							<div class="col-sm-10">
								<table width="100%" cellpadding="5" cellspacing="0" border="0" class="table">
									<tr><td width="5%"><b>Bil</b></td><td width="75%"><b>Pengkhususan</b></td>
									<td width="20%" align="center">
									<label class="btn btn-danger" name="id_klu" value="'.$id_klu.'" onclick="do_hapus_all();">Hapus Semua</label></td>
									</tr>
							<?php 	
								if(!$rsC->EOF){ //$conn->debug=true;
								print ''; $kod_get='';
								$jbil=0;
								while(!$rsC->EOF){ $jbil++;
									// if($jbil==1){ $kod_get=$rsC->fields['kod']; } else { $kod_get.=",".$rsC->fields['kod']; }
									if($jbil==1){ $kod_get="'".$rsC->fields['kod']."'"; } else { $kod_get.=",'".$rsC->fields['kod']."'"; }
									$nama_ins = dlookup("$schema1.ref_institusi","DISKRIPSI","KOD=".tosql($rsC->fields['kod_institusi']));
									$nama_subj = dlookup("$schema1.ref_pengkhususan","DISKRIPSI","kod=".tosql($rsC->fields['kod_pengkhususan']));
									$id_klu = $rsC->fields['id_klu'];
									print '<tr><td valign="top">'.$jbil.' -</td><td>'.
									$rsC->fields['kod_institusi'].":".$nama_ins.":".$rsC->fields['kod_pengkhususan'].":".$nama_subj.'</td>';
									print '<td align="center"><label class="btn btn-danger" name="id_klu" value="'.$id_klu.'" onclick="do_hapus('.$id_klu.');">Hapus</label></td>';
									print '</tr>';
									$rsC->movenext(); 
								}
								print '';
							}

							?>
								</table>
                            </div>
						</div>
					</div>
			<?php
			//$conn->debug=true;
			$sql = "SELECT A.*  FROM $schema1.`padanan_institusi_pengkhususan` A 
			WHERE A.`status`=0 AND A.`is_deleted`=0 ";
			$sql .= " AND A.`kategori`=".tosql($km_jenis);
			if(!empty($kod_get)){ $sql .= " AND A.kod NOT IN ($kod_get)"; }
			//$rsData1 = $conn->query($sql);
			//print $sql;
			// print $rsData1->recordcount();
			?>

					<div class="form-group">
						<div class="row">
							<label for="nama" class="col-sm-2 control-label"><b>Carian Maklumat <div style="float:right">:</div></b></label>
							<div class="col-sm-9">
								<input type="text" name="makl" id="makl" class="form-control" value="">
								<input type="hidden" name="codes" id="codes" class="form-control" value="<?=$kod_get;?>">
							</div>
							<div class="col-sm-1">
								<label class="btn btn-info" onclick="do_cari('<?=$km_jenis;?>');">Cari</label>
							</div>
						</div>
					</div>

					<div class="form-group">
						<div class="row">
							<!-- <label for="nama" class="col-sm-2 control-label"><b>Tambah Pengkususan <div style="float:right">:</div></b></label> -->
							<div class="col-sm-11" id="div_element">
							</div>
							<div class="col-sm-1">
								<!-- <label class="btn btn-primary" onclick="do_tambah('');">ADD</label> -->
								<label class="btn btn-primary" onclick="do_pilihkod('');">ADD</label>
							</div>
						</div>
					</div>

					<!-- <div class="form-group">
						<div class="row">
							<label for="nama" class="col-sm-2 control-label"><b>Tambah Pengkususan <div style="float:right">:</div></b></label>
							<div class="col-sm-9">
								<select name="gpengkhususan1" id="gpengkhususan1" class="form-control select2 gpengkhususan1" style="width: 100%;" aria-hidden="true" onchange="do_sel(this.value)">
							</select>
							</div>
							<div class="col-sm-1">
								<label class="btn btn-primary" onclick="do_tambah('');">ADD</label>
							</div>
						</div>
					</div> -->

					<div class="modal-footer" style="padding:0px;">
						<!--<button type="button" class="btn btn-primary mt-sm mb-sm" onclick="do_save1()"><i class="fa fa-save"></i> Simpan</button>
						&nbsp;-->
						<button type="button" class="btn btn-default" onclick="do_close1()"><i class="fa fa-spinner" style="margin:0px;"></i> Kembali</button>
					</div>
				</div>

			
			</div>
		</div>
	     
	</section>

</div> 

<!-- <script src="../assets/vendor/bootstrap-multiselect/bootstrap-multiselect.js"></script> -->

<script>
    function do_close(){
        reload = window.location; 
        window.location = reload;
    }
</script>

<script language="javascript" type="text/javascript">
//document.frm.gsasar_nama.focus();
// $('#jenis_perkhidmatan').selectpicker('refresh');
$(document).ready(function() {
    $('.select2').select2({
    closeOnSelect: false
});
}); 
</script>   