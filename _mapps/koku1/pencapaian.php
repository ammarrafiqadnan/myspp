<script language="javascript">
function do_pencapaian(){
  var reg = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
  var rekacipta = $('#rekacipta').val();
  var rekaciptaAsal = $('#rekaciptaAsal').val();
  var sumbangan = $('#sumbangan').val();
  var sumbanganAsal = $('#sumbanganAsal').val();
  var peringkat = $('#peringkat').val();
  var peringkatAsal = $('#peringkatAsal').val();

	var pencapaian = $('#pencapaian').val();
	var pencapaianAsal = $('#pencapaianAsal').val();
    

  var msg = '';
  // alert(sukan1);
  // alert(peringkat1);
  if(rekacipta.trim() != '' && sumbangan.trim() == '' && peringkat.trim() == ''){
      msg = msg+'\n- Sila pilih maklumat sumbangan.';
      msg = msg+'\n- Sila pilih maklumat peringkat.';
      $("#sumbangan").css("border-color","#f00");
      $("#peringkat").css("border-color","#f00");
  } else if(rekacipta.trim() != '' && sumbangan.trim() != '' && peringkat.trim() == ''){
      msg = msg+'\n- Sila pilih maklumat peringkat.';
      $("#sumbangan").css("border-color","");
      $("#peringkat").css("border-color","#f00");
  } else if(rekacipta.trim() != '' && sumbangan.trim() == '' && peringkat.trim() != ''){
      msg = msg+'\n- Sila pilih maklumat sumbangan.';
      $("#sumbangan").css("border-color","#f00");
      $("#peringkat").css("border-color","");
  } else if(rekacipta.trim() == '' && sumbangan.trim() != '' && peringkat.trim() != ''){
      msg = msg+'\n- Sila masukkan maklumat jenis rekacipta/inovasi.';
      $("#rekacipta").css("border-color","#f00");
      $("#sumbangan").css("border-color","");
      $("#peringkat").css("border-color","");
  } else if(rekacipta.trim() == '' && sumbangan.trim() == '' && peringkat.trim() != ''){
      msg = msg+'\n- Sila masukkan maklumat jenis rekacipta/inovasi.';
      msg = msg+'\n- Sila pilih maklumat sumbangan.';
      $("#rekacipta").css("border-color","#f00");
      $("#sumbangan").css("border-color","#f00");
      $("#peringkat").css("border-color","");
  } 



  if(msg.trim() !=''){ 
      alert_msg_html(msg);
  } else { 
      $.ajax({
          url: 'tambahan/sql_bukanakademik.php?frm=INNOVASI&pro=SAVE',
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

function do_btn(){
  var rekacipta = $('#rekacipta').val();
  var sumbangan = $('#sumbangan').val();
  var peringkat = $('#peringkat').val();
	var pencapaian = $('#pencapaian').val();

  if(rekacipta.trim() == '' && sumbangan.trim() == '' && peringkat.trim() == '' && pencapaian.trim() == ''){
		document.getElementById("simpan").disabled = true; 
	} else {
		document.getElementById("simpan").disabled = false; 
	}
}
</script>

<?php 
// $conn->debug=true;
$uid=$_SESSION['SESS_UID'];
$rsRekacipta = $conn->query("SELECT * FROM $schema2.`calon_ko_rekacipta` WHERE `id_pemohon`=".tosql($uid));
$rsPencapaian = $conn->query("SELECT * FROM $schema2.`calon_ko_khas` WHERE `id_pemohon`=".tosql($uid));
print "R:".$rsRekacipta->fields['rekacipta'];
?>

		<!-- <div class="box" style="background-color:#F2F2F2">
      <div class="box-body">
				<div class="x_panel" style="background-color:#F2F2F2">
					<header class="panel-heading"  style="background-color:rgb(38, 167, 228)">
						<div class="panel-actions"></div>
						<h6 class="panel-title"><font color="#000000"><b><?=$menu;?></b></font></h6> 
					</header>
				</div>
      </div>            
		</div><br> -->
		<div class="box" style="background-color:#F2F2F2">
      <div class="box-body">
				<div class="x_panel" style="background-color:#F2F2F2">
					<header class="panel-heading"  style="background-color:rgb(38, 167, 228)">
						<div class="panel-actions"></div>
						<h6 class="panel-title"><font color="#000000"><b>Maklumat Rekacipta & Inovasi</b></font></h6> 
					</header>
					<input type="hidden" name="id_pemohon" id="id_pemohon" value="<?php print $uid;?>" readonly="readonly"/>
				</div>
      </div>            
      <br>
					<div class="form-group">
						<div class="row">
							<label for="nama" class="col-sm-2 control-label"><b>Jenis <font color="#FF0000">*</font><div style="float:right">:</div></b></label>
							<div class="col-sm-8">
								<input type="text" name="rekacipta" id="rekacipta" value="<?php print $rsRekacipta->fields['rekacipta'];?>" class="form-control" onchange="do_btn()">
								<input type="hidden" name="rekaciptaAsal" id="rekaciptaAsal" value="<?php print $rsRekacipta->fields['rekacipta'];?>" class="form-control">
								<input type="hidden" name="sumbanganAsal" id="sumbanganAsal" value="<?php print $rsRekacipta->fields['sumbangan'];?>" class="form-control">
								<input type="hidden" name="peringkatAsal" id="peringkatAsal" value="<?php print $rsRekacipta->fields['peringkat'];?>" class="form-control">
							</div>
						</div>
					</div>
					<?php 
					// $conn->debug=true;
					$sql = "SELECT * FROM $schema1.`ref_rekacipta` WHERE SAH_YT='Y' ORDER BY KOD";
					$rsPangkat = $conn->query($sql);
					?>
					<div class="form-group">
						<div class="row">
							<label for="nama" class="col-sm-2 control-label"><b>Sumbangan <font color="#FF0000">*</font><div style="float:right">:</div></b></label>
							<div class="col-sm-6">
								<select class="form-control" name="sumbangan" id="sumbangan" onchange="do_btn()">
									<option value="">Sila pilih</option>
									<?php while(!$rsPangkat->EOF){ ?>
									<option value="<?=$rsPangkat->fields['KOD'];?>" <?php if($rsRekacipta->fields['sumbangan']==$rsPangkat->fields['KOD']){ print 'selected'; }?>><?=$rsPangkat->fields['DISKRIPSI'];?></option>
									<?php $rsPangkat->movenext(); } ?>
								</select>
							</div>
						</div>
					</div>

					<?php 
					// $conn->debug=true;
					$sql = "SELECT * FROM $schema1.`ref_peringkat` WHERE SAH_YT='Y' ORDER BY KOD";
					$rsPeringkat = $conn->query($sql);
					?>
					<div class="form-group">
						<div class="row">
							<label for="nama" class="col-sm-2 control-label"><b>Peringkat <font color="#FF0000">*</font><div style="float:right">:</div></b></label>
							<div class="col-sm-6">
								<select class="form-control" name="peringkat" id="peringkat" onchange="do_btn()">
									<option value="">Sila pilih</option>
									<?php while(!$rsPeringkat->EOF){ ?>
									<option value="<?=$rsPeringkat->fields['KOD'];?>" <?php if($rsRekacipta->fields['peringkat']==$rsPeringkat->fields['KOD']){ print 'selected'; }?>><?=$rsPeringkat->fields['DISKRIPSI'];?></option>
									<?php $rsPeringkat->movenext(); } ?>
								</select>
							</div>
						</div>
					</div>
		</div>
		<br>

		<div class="box" style="background-color:#F2F2F2">

            <div class="box-body">
				<div class="x_panel" style="background-color:#F2F2F2">
					<header class="panel-heading"  style="background-color:rgb(38, 167, 228)">
						<div class="panel-actions"></div>
						<h6 class="panel-title"><font color="#000000"><b>Maklumat Pencapaian Khas / Istimewa</b></font></h6> 
					</header>
				</div>
            </div>            
			<br />
            <div class="box-body" style="background-color:#F2F2F2">
              <div class="form-group">
						<div class="row">
							<label for="nama" class="col-sm-2 control-label"><b>Maklumat Pencapaian <div style="float:right">:</div></b></label>
							<div class="col-sm-10">
								<input type="text" name="pencapaian" id="pencapaian" class="form-control" value="<?php print $rsPencapaian->fields['pencapaian'];?>" onchange="do_btn()">
								<input type="hidden" name="pencapaianAsal" id="pencapaianAsal" class="form-control" value="<?php print $rsPencapaian->fields['pencapaian'];?>">
							</div>
						</div>
					</div>
            </div>

            <div class="modal-footer" style="padding:0px;">
						<button type="button" id="simpan" class="btn btn-primary mt-sm mb-sm" onclick="do_pencapaian()"><i class="fa fa-save"></i> Simpan</button>
						&nbsp;
						<?php if(!empty($rsRekacipta->fields['rekacipta'])){ ?>
							<label class="btn btn-danger" onclick="do_hapus('tambahan/sql_bukanakademik.php?frm=INNOVASI&pro=DEL&id_pemohon=<?=$uid;?>')">Hapus</label>
						<?php } ?>
						<input type="hidden" name="progid" id="progid" value="<?php print $progid;?>" />
						<input type="hidden" name="proses" value="<?php print $proses;?>" />
					</div>
		</div>
<script type="text/javascript">
	document.getElementById("simpan").disabled = true;
</script>          