<!-- <link href="vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
<link href="vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
<link href="vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
<link href="vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet"> -->
<script language="javascript">
function do_sukan(){
    var reg = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
	var sid_1 = $('#sid_1').val();
	var sid_2 = $('#sid_2').val();
	var sid_3 = $('#sid_3').val();

    var sukan1 = $('#sukan1').val();
    var peringkat1 = $('#peringkat1').val();
    var sukan2 = $('#sukan2').val();
    var peringkat2 = $('#peringkat2').val();
    var sukan3 = $('#sukan3').val();
    var peringkat3 = $('#peringkat3').val();

	var pid_1 = $('#pid_1').val();
	var pid_2 = $('#pid_2').val();
	var pid_3 = $('#pid_3').val();

	var persatuan1 = $('#persatuan1').val();
	var jawatan1 = $('#jawatan1').val();
    var pperingkat1 = $('#pperingkat1').val();
	var persatuan2 = $('#persatuan2').val();
	var jawatan2 = $('#jawatan2').val();
    var pperingkat2 = $('#pperingkat2').val();
	var persatuan3 = $('#persatuan3').val();
	var jawatan3 = $('#jawatan3').val();
    var pperingkat3 = $('#pperingkat3').val();
    

    var msg = '';
    // alert(sukan1);
    // alert(peringkat1);
    if(sukan1.trim() != '' && peringkat1.trim() == ''){
        msg = msg+'\n- Sila pilih maklumat peringkat sukan pilihan pertama.';
        $("#peringkat1").css("border-color","#f00");
    } else { $("#peringkat1").css("border-color","#ccc");  $('#sid_1').val(0);  sid_1='0'; }
    if(sukan1.trim() == '' && peringkat1.trim() != ''){
        msg = msg+'\n- Sila pilih maklumat sukan pada pilihan pertama.';
        $("#sukan1").css("border-color","#f00");
    } else { $("#sukan1").css("border-color","#ccc");  $('#sid_1').val(0);  sid_1='0'; }

    if(sukan2.trim() != '' && peringkat2.trim() == ''){
        msg = msg+'\n- Sila pilih maklumat peringkat sukan pilihan kedua.';
        $("#peringkat2").css("border-color","#f00");
    } else { $("#peringkat2").css("border-color","#ccc"); $('#sid_2').val(0);  sid_2='0'; }
    if(sukan2.trim() == '' && peringkat2.trim() != ''){
        msg = msg+'\n- Sila pilih maklumat sukan pada pilihan kedua.';
        $("#sukan2").css("border-color","#f00");
    } else { $("#sukan2").css("border-color","#ccc"); $('#sid_2').val(0);  sid_2='0'; }

    if(sukan3.trim() != '' && peringkat3.trim() == ''){
        msg = msg+'\n- Sila pilih maklumat peringkat sukan pilihan ketiga.';
        $("#peringkat3").css("border-color","#f00");
    } else { $("#peringkat3").css("border-color","#ccc"); $('#sid_3').val(0); sid_3='0'; }
    if(sukan3.trim() == '' && peringkat3.trim() != ''){
        msg = msg+'\n- Sila pilih maklumat sukan pada pilihan ketiga.';
        $("#sukan3").css("border-color","#f00");
    } else { $("#sukan3").css("border-color","#ccc"); $('#sid_3').val(0);  sid_3='0'; }

    if(sid_1.trim() == '1'){ 
	    if(sukan1==sukan2 && peringkat1==peringkat2){
	        msg = msg+'\n- Maklumat berkaitan sukan bagi pilihan kedua sama\ndengan pilihan pertama. Sila kemaskini.';
	        $("#sukan2").css("border-color","#f00");
	        $("#peringkat2").css("border-color","#f00");
	    }
	}
    if(sid_2.trim() == '1'){ 
		if(sukan1==sukan3 && peringkat1==peringkat3){
	        msg = msg+'\n- Maklumat berkaitan sukan bagi pilihan ketiga sama\ndengan pilihan pertama. Sila kemaskini.';
	        $("#sukan3").css("border-color","#f00");
	        $("#peringkat3").css("border-color","#f00");
	    }
	}
    if(sid_3.trim() == '1'){ 
	    if(sukan2==sukan3 && peringkat2==peringkat3){
	        msg = msg+'\n- Maklumat berkaitan sukan bagi pilihan ketiga sama\ndengan pilihan kedua. Sila kemaskini.';
	        $("#sukan3").css("border-color","#f00");
	        $("#peringkat3").css("border-color","#f00");
	    }
	}

    // MAKLUMAT BAGI PERSATUAN
    // alert(pid_1);
    if(pid_1.trim() == '1'){
	    if(persatuan1.trim() == '' || jawatan1.trim() == '' || pperingkat1.trim() == ''){
	        msg = msg+'\n- Sila lengkapkan maklumat pertama persatuan.';
	        $("#persatuan1").css("border-color","#f00");
	        $("#jawatan1").css("border-color","#f00");
	        $("#pperingkat1").css("border-color","#f00");
	    // } else {
	    // 	 $('#pid_1').val(0);  pid_1='0'; 
	    }
	    if(persatuan1==persatuan2 && jawatan1==jawatan2 && pperingkat1==pperingkat2){
	        msg = msg+'\n- Maklumat berkaitan persatuan bagi pilihan kedua sama\ndengan pilihan pertama. Sila kemaskini.';
	        $("#persatua2").css("border-color","#f00");
	        $("#jawatan2").css("border-color","#f00");
	        $("#pperingkat2").css("border-color","#f00");
	    }
    }
    if(pid_2.trim() == '1'){
	    if(persatuan2.trim() == '' || jawatan2.trim() == '' || pperingkat2.trim() == ''){
	        msg = msg+'\n- Sila lengkapkan maklumat kedua persatuan.';
	        $("#persatuan2").css("border-color","#f00");
	        $("#jawatan2").css("border-color","#f00");
	        $("#pperingkat2").css("border-color","#f00");
	    // } else {
	    // 	 $('#pid_2').val(0);  pid_2='0'; 
	    }
	    if(persatuan2==persatuan3 && jawatan2==jawatan3 && pperingkat2==pperingkat3){
	        msg = msg+'\n- Maklumat berkaitan persatuan bagi pilihan ketiga sama\ndengan pilihan kedua. Sila kemaskini.';
	        $("#persatua3").css("border-color","#f00");
	        $("#jawatan3").css("border-color","#f00");
	        $("#pperingkat3").css("border-color","#f00");
	    }
    }
    if(pid_3.trim() == '1'){
	    if(persatuan3.trim() == '' || jawatan3.trim() == '' || pperingkat3.trim() == ''){
	        msg = msg+'\n- Sila lengkapkan maklumat ketiga persatuan.';
	        $("#persatuan3").css("border-color","#f00");
	        $("#jawatan3").css("border-color","#f00");
	        $("#pperingkat3").css("border-color","#f00");
	    // } else {
	    // 	 $('#pid_3').val(0);  pid_3='0'; 
	    }
	    if(persatuan1==persatuan3 && jawatan1==jawatan3 && pperingkat1==pperingkat3){
	        msg = msg+'\n- Maklumat berkaitan persatuan bagi pilihan ketiga sama\ndengan pilihan pertama. Sila kemaskini.';
	        $("#persatua3").css("border-color","#f00");
	        $("#jawatan3").css("border-color","#f00");
	        $("#pperingkat3").css("border-color","#f00");
	    }
    }


    if(msg.trim() !=''){ 
        alert_msg_html(msg);
    } else { 
        $.ajax({
            url: 'tambahan/sql_bukanakademik.php?frm=SUKAN&pro=SAVE',
            type:'POST',
            //dataType: 'json',
            // beforeSend: function () {
            //     $('.btn-primary').attr("disabled","disabled");
            //     $('.modal-body').css('opacity', '.5');
            // },
            data: $("form").serialize(),
            //data: datas,
            success: function(data){
                console.log(data);
                // alert(data);
                if(data=='OK'){
                    swal({
                      title: 'Berjaya',
                      text: 'Maklumat telah berjaya disimpan/kemaskini.',
                      type: 'success',
                      confirmButtonClass: "btn-success",
                      confirmButtonText: "Ok",
                      showConfirmButton: true,
                    }).then(function () {
                        reload = window.location; 
                        window.location = reload;
                        // window.href = "index.php";
                    });
                } else if(data=='ERR'){
                    swal({
                      title: 'Amaran',
                      text: 'Terdapat ralat sistem.\nSila berhubung dengan penyedia sistem.',
                      type: 'error',
                      confirmButtonClass: "btn-warning",
                      confirmButtonText: "Ok",
                      showConfirmButton: true,
                    });
                }
            }
            //data: datas
        });
        
    }
}

function on_schg(vals){
	// alert(vals);
	if(vals==1){
		$('#sid_1').val(1);
	} else if(vals==2){
		$('#sid_2').val(1);
	} else if(vals==3){
		$('#sid_3').val(1);
	}
}

function on_chg(vals){
	if(vals==1){
		$('#pid_1').val(1);
		if($('#persatuan1').val()=='' && $('#jawatan1').val()=='' && $('#pperingkat1').val()==''){
			$('#pid_1').val(0);
		} 
	} else if(vals==2){
		$('#pid_2').val(1);
		if($('#persatuan2').val()=='' && $('#jawatan2').val()=='' && $('#pperingkat2').val()==''){
			$('#pid_2').val(0);
		} 
	} else if(vals==3){
		$('#pid_3').val(1);
		if($('#persatuan3').val()=='' && $('#jawatan3').val()=='' && $('#pperingkat3').val()==''){
			$('#pid_3').val(0);
		} 
	}
}
</script>
<?php
$uid=$_SESSION['SESS_UID'];
?>

<input type="hidden" id="vals" name="vals" value=""  />
		<div class="box" style="background-color:#F2F2F2">
      <div class="box-body">
				<div class="x_panel" style="background-color:#F2F2F2">
					<header class="panel-heading"  style="background-color:rgb(38, 167, 228)">
						<div class="panel-actions"></div>
						<h6 class="panel-title"><font color="#000000"><b>Maklumat Sukan</b></font></h6> 
					</header>
					<input type="hidden" name="id_pemohon" id="id_pemohon" value="<?php print $uid;?>" readonly="readonly"/>
				</div>
      </div>            
			<br />
      <div class="box-body" style="background-color:#F2F2F2">
          <?php 
					// $conn->debug=true;
          $rsData = $conn->query("SELECT * FROM $schema2.`calon_ko_sukan` WHERE `id_pemohon`='{$uid}'");
          $bil=0;
			$sql = "SELECT * FROM $schema1.`ref_sukan` WHERE 1 GROUP BY kod";
			$rsSukan = $conn->query($sql);
			$sql = "SELECT * FROM $schema1.`ref_peringkat` WHERE SAH_YT='Y' ORDER BY KOD";
			$rsPeringkat = $conn->query($sql);
			?>
			<div class="form-group">
				<div class="row">
					<div class="col-sm-4 col-xs-5 text-center"><b>SUKAN</b></div>
					<div class="col-sm-4 col-xs-5 text-center"><b>PERINGKAT</b></div>
				</div>
			</div>
			<?php while(!$rsData->EOF){ $bil++;?>
			<?php $rsSukan->movefirst(); $rsPeringkat->movefirst();  ?>
			<div class="form-group">
				<div class="row">
					<div class="col-sm-4 col-xs-5">
						<select name="sukan<?=$bil;?>" id="sukan<?=$bil;?>" class="form-control" onchange="on_schg(<?=$bil;?>)">
							<option value="">Sila pilih maklumat sukan</option>
							<?php while(!$rsSukan->EOF){ ?>
							<option value="<?=$rsSukan->fields['kod'];?>" 
								<?php if($rsData->fields['sukan']==$rsSukan->fields['kod']){ print 'selected'; } ?>><?=$rsSukan->fields['deskripsi'];?></option>
							<?php $rsSukan->movenext(); } ?>
						</select>
					</div>
					<div class="col-sm-4 col-xs-5">
						<select class="form-control" name="peringkat<?=$bil;?>" id="peringkat<?=$bil;?>" onchange="on_schg(<?=$bil;?>)">
							<option value="">Sila pilih peringkat sukan</option>
							<?php while(!$rsPeringkat->EOF){ ?>
							<option value="<?=$rsPeringkat->fields['KOD'];?>" 
								<?php if($rsData->fields['peringkat']==$rsPeringkat->fields['KOD']){ print 'selected'; } ?>><?=$rsPeringkat->fields['DISKRIPSI'];?></option>
							<?php $rsPeringkat->movenext(); } ?>
						</select>
					</div>
					<div class="col-sm-2 col-xs-2">
						<img src="../images/trash.png" title="Hapus maklumat sukan" style="cursor: pointer;" 
							onclick="do_hapus('tambahan/sql_bukanakademik.php?frm=SUKAN&pro=DEL_SUK&id_pemohon=<?=$uid;?>&v1=<?=$rsData->fields['sukan'];?>&v2=<?=$rsData->fields['peringkat'];?>')">
							<input type="hidden" name="sukan_u<?=$bil;?>" value="<?=$rsData->fields['sukan'];?>">
							<input type="hidden" name="peringkat_u<?=$bil;?>" value="<?=$rsData->fields['peringkat'];?>">
							<input type="hidden" name="sid_<?=$bil;?>" id="sid_<?=$bil;?>" value="0">
					</div>
				</div>
			</div>
			<?php $rsData->movenext(); } ?>

			<?php for($i=$bil;$i<3;$i++){ $p=$i+1; ?>
			<?php $rsSukan->movefirst(); $rsPeringkat->movefirst();  ?>
			<div class="form-group">
				<div class="row">
					<div class="col-sm-4 col-xs-5">
						<select name="sukan<?=$p;?>" id="sukan<?=$p;?>" class="form-control" onchange="on_schg(<?=$p;?>)">
							<option value="">Sila pilih maklumat sukan</option>
							<?php while(!$rsSukan->EOF){ ?>
							<option value="<?=$rsSukan->fields['kod'];?>" 
								<?php if($kategori==$rsSukan->fields['kod']){ print 'selected'; } ?>><?=$rsSukan->fields['deskripsi'];?></option>
							<?php $rsSukan->movenext(); } ?>
						</select>
					</div>
					<div class="col-sm-4 col-xs-5">
						<select class="form-control" name="peringkat<?=$p;?>" id="peringkat<?=$p;?>" onchange="on_schg(<?=$p;?>)">
							<option value="">Sila pilih peringkat sukan</option>
							<?php while(!$rsPeringkat->EOF){ ?>
							<option value="<?=$rsPeringkat->fields['KOD'];?>"><?=$rsPeringkat->fields['DISKRIPSI'];?></option>
							<?php $rsPeringkat->movenext(); } ?>
						</select>
					</div>
					<div class="col-sm-2 col-xs-2">
						<input type="hidden" name="sid_<?=$p;?>" id="sid_<?=$p;?>" value="0">
					</div>
				</div>
			</div>

		<?php } ?>

      	</div>

		<br><br>

		<div class="box" style="background-color:#F2F2F2">

            <div class="box-body">
				<div class="x_panel" style="background-color:#F2F2F2">
					<header class="panel-heading"  style="background-color:rgb(38, 167, 228)">
						<div class="panel-actions"></div>
						<h6 class="panel-title"><font color="#000000"><b>Maklumat Persatuan / Kepimpinan</b></font></h6> 
					</header>
				</div>
            </div>            
			<br />
      		<div class="box-body" style="background-color:#F2F2F2">
	          <?php 
				// $conn->debug=true;
	          	$rsData = $conn->query("SELECT * FROM $schema2.`calon_ko_persatuan` WHERE `id_pemohon`='{$uid}'");
	          	$bil=0;
				$sql = "SELECT * FROM $schema1.`ref_jawatan_persatuan` WHERE 1 ORDER BY KOD";
				$rsJawatan = $conn->query($sql);
				$sql = "SELECT * FROM $schema1.`ref_peringkat` WHERE SAH_YT='Y' ORDER BY KOD";
				$rsPeringkat = $conn->query($sql);
				?>

				<div class="form-group">
					<div class="row">
						<div class="col-sm-5 col-xs-5 text-center"><b>NAMA PERSATUAN</b></div>
						<div class="col-sm-3 col-xs-3 text-center"><b>JAWATAN</b></div>
						<div class="col-sm-3 col-xs-3 text-center"><b>PERINGKAT</b></div>
					</div>
				</div>
				<?php while(!$rsData->EOF){ $bil++;?>
				<?php $rsJawatan->movefirst(); $rsPeringkat->movefirst();  ?>
				<div class="form-group">
					<div class="row">
						<div class="col-sm-5 col-xs-5">
							<input type="text" name="persatuan<?=$bil;?>" id="persatuan<?=$bil;?>" placeholder="Sila masukkan maklumat persatuan/Kepimpinan" class="form-control" value="<?php print $rsData->fields['persatuan'];?>" onchange="on_chg(<?=$bil;?>)">
						</div>
						<div class="col-sm-3 col-xs-3">
							<select name="jawatan<?=$bil;?>" id="jawatan<?=$bil;?>" class="form-control" onchange="on_chg(<?=$bil;?>)">
								<option value="">Sila pilih maklumat jawatan</option>
								<?php while(!$rsJawatan->EOF){ ?>
								<option value="<?=$rsJawatan->fields['KOD'];?>" 
									<?php if($rsData->fields['jawatan']==$rsJawatan->fields['KOD']){ print 'selected'; } ?>><?=$rsJawatan->fields['DISKRIPSI'];?></option>
								<?php $rsJawatan->movenext(); } ?>
							</select>
						</div>
						<div class="col-sm-3 col-xs-3">
							<select class="form-control" name="pperingkat<?=$bil;?>" id="pperingkat<?=$bil;?>" onchange="on_chg(<?=$bil;?>)">
								<option value="">Sila pilih peringkat</option>
								<?php while(!$rsPeringkat->EOF){ ?>
								<option value="<?=$rsPeringkat->fields['KOD'];?>" 
									<?php if($rsData->fields['peringkat']==$rsPeringkat->fields['KOD']){ print 'selected'; } ?>><?=$rsPeringkat->fields['DISKRIPSI'];?></option>
								<?php $rsPeringkat->movenext(); } ?>
							</select>
						</div>
						<div class="col-sm-1">
							<img src="../images/trash.png" title="Hapus maklumat persatuan/kepimpinan" style="cursor: pointer;" 
								onclick="do_hapus('tambahan/sql_bukanakademik.php?frm=SUKAN&pro=DEL_PER&id_pemohon=<?=$uid;?>&v1=<?=$rsData->fields['persatuan'];?>&v2=<?=$rsData->fields['jawatan'];?>&v3=<?=$rsData->fields['peringkat'];?>')">
								<input type="hidden" name="persatuan_u<?=$bil;?>" value="<?=$rsData->fields['persatuan'];?>">
								<input type="hidden" name="jawatan_u<?=$bil;?>" value="<?=$rsData->fields['jawatan'];?>">
								<input type="hidden" name="pperingkat_u<?=$bil;?>" value="<?=$rsData->fields['peringkat'];?>">
								<input type="hidden" name="pid_<?=$bil;?>" id="pid_<?=$bil;?>" value="0">
						</div>
					</div>
				</div>
				<?php $rsData->movenext(); } ?>

				<?php for($i=$bil;$i<3;$i++){ $p=$i+1; ?>
				<?php $rsJawatan->movefirst(); $rsPeringkat->movefirst();  ?>
				<div class="form-group">
					<div class="row">
						<div class="col-sm-5 col-xs-5">
							<input type="text"  name="persatuan<?=$p;?>" id="persatuan<?=$p;?>" placeholder="Sila masukkan maklumat persatuan/Kepimpinan" 
							class="form-control" onchange="on_chg(<?=$p;?>)">
						</div>
						<div class="col-sm-3 col-xs-3">
							<select name="jawatan<?=$p;?>" id="jawatan<?=$p;?>" class="form-control" onchange="on_chg(<?=$p;?>)">
								<option value="">Sila pilih maklumat jawatan</option>
								<?php while(!$rsJawatan->EOF){ ?>
								<option value="<?=$rsJawatan->fields['KOD'];?>" 
									<?php if($kategori==$rsJawatan->fields['KOD']){ print 'selected'; } ?>><?=$rsJawatan->fields['DISKRIPSI'];?></option>
								<?php $rsJawatan->movenext(); } ?>
							</select>
						</div>
						<div class="col-sm-3 col-xs-3">
							<select class="form-control" name="pperingkat<?=$p;?>" id="pperingkat<?=$p;?>" onchange="on_chg(<?=$p;?>)">
								<option value="">Sila pilih peringkat</option>
								<?php while(!$rsPeringkat->EOF){ ?>
								<option value="<?=$rsPeringkat->fields['KOD'];?>"><?=$rsPeringkat->fields['DISKRIPSI'];?></option>
								<?php $rsPeringkat->movenext(); } ?>
							</select>
						</div>
						<div>
							<input type="hidden" name="pid_<?=$p;?>" id="pid_<?=$p;?>" value="0">
						</div>
					</div>
				</div>
				<?php } ?>

				<?php 
				// $conn->debug=true;
				$plkn = dlookup("$schema2.calon_ko_plkn","plkn","id_pemohon=".tosql($uid));
				// print "PLKN:".$plkn;
				if(empty($plkn)){ $plkn='T'; }
				?>
				<br><br>
				<div class="form-group">
					<div class="row">
						<div class="col-sm-12 col-xs-12">
							Adakah anda pernah menjalani Prgram Latihan Khidmat Negara? <font color="red">*</font> 
							<input type="radio" name="plkn" id="plkn" <?php if($plkn=='Y'){ print 'checked'; }?> value="Y"> YA &nbsp;
							<input type="radio" name="plkn" id="plkn" <?php if($plkn=='T'){ print 'checked'; }?> value="T"> TIDAK &nbsp;
						</div>
					</div>
				</div>

        </div>

            <div class="modal-footer" style="padding:0px;">
						<button type="button" id="simpan" class="btn btn-primary mt-sm mb-sm" onclick="do_sukan()"><i class="fa fa-save"></i> Simpan</button>
						&nbsp;
						<!-- <button type="button" id="simpan_next" class="btn btn-success mt-sm mb-sm" onclick="do_save('SAVE','SEND')"><i class="fa fa-save"></i> Simpan & Hantar</button>
						&nbsp; -->
						<!-- <button type="button" class="btn btn-default" onclick="do_page('index.php?data=<?php print base64_encode('maklumat/pemantauan_list;DATA;Maklumat Pemantauan;;;;'); ?>')">
							<i class="fa fa-spinner" style="margin:0px;"></i> Kembali</button> -->
						<input type="hidden" name="progid" id="progid" value="<?php print $progid;?>" />
						<input type="hidden" name="proses" value="<?php print $proses;?>" />
					</div>
		</div>
          