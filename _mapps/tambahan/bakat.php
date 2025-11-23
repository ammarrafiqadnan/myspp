<script language="javascript">
function do_bakat(){
	var reg = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
	var bakat1 = $('#bakat1').val();
	var bakat2 = $('#bakat2').val();
	var bakat3 = $('#bakat3').val();


	var bid1 = $('#bid1').val();
	var bahasa1 = $('#bahasa1').val();
	var penguasaan1 = $('#penguasaan1').val();
	var bid2 = $('#bid2').val();
	var bahasa2 = $('#bahasa2').val();
	var penguasaan2 = $('#penguasaan2').val();
	var bid3 = $('#bid3').val();
	var bahasa3 = $('#bahasa3').val();
	var penguasaan3 = $('#penguasaan3').val();

    var msg = '';

    if(bakat1.trim() =='' && bakat2.trim() =='' && bakat3 =='' && bahasa1.trim() == '' && bahasa2.trim() == '' && bahasa3.trim() == '' && penguasaan1.trim() == '' && penguasaan2.trim() == '' && penguasaan3.trim() == ''){
        msg = msg+'\n- Sila pilih maklumat bakat atau kebolehan bahasa.';
        //$("#bakat1").css("border-color","#f00");
	//$("#bakat2").css("border-color","#f00");
	//$("#bakat3").css("border-color","#f00");
	//$("#bahasa1").css("border-color","#f00");
	//$("#bahasa2").css("border-color","#f00");
	//$("#bahasa3").css("border-color","#f00");
	//$("#penguasaan1").css("border-color","#f00");
	//$("#penguasaan2").css("border-color","#f00");
	//$("#penguasaan3").css("border-color","#f00");
    }


    if(bakat1.trim()!='' && bakat2.trim()!='' && bakat1==bakat2){
        msg = msg+'\n- Maklumat jenis bakat bagi pilihan kedua sama\ndengan pilihan pertama. Sila kemaskini.';
        $("#bakat2").css("border-color","#f00");
    }
    if(bakat1.trim()!='' && bakat3.trim()!='' && bakat1==bakat3){
        msg = msg+'\n- Maklumat jenis bakat bagi pilihan ketiga sama\ndengan pilihan pertama. Sila kemaskini.';
        $("#bakat3").css("border-color","#f00");
    }
    if(bakat2.trim()!='' && bakat3.trim()!='' && bakat2==bakat3){
        msg = msg+'\n- Maklumat jenis bakat bagi pilihan ketiga sama\ndengan pilihan kedua. Sila kemaskini.';
        $("#bakat2").css("border-color","#f00");
    }
    
    if(bahasa1.trim() != '' && penguasaan1.trim() == ''){
        msg = msg+'\n- Sila pilih maklumat penguasaan bahasa pilihan pertama.';
        $("#penguasaan1").css("border-color","#f00");
    } else { $("#penguasaan1").css("border-color","#ccc"); }
    if(bahasa1.trim() == '' && penguasaan1.trim() != ''){
        msg = msg+'\n- Sila pilih maklumat bahasa pada pilihan pertama.';
        $("#bahasa1").css("border-color","#f00");
    } else { $("#bahasa1").css("border-color","#ccc"); }

    if(bahasa2.trim() != '' && penguasaan2.trim() == ''){
        msg = msg+'\n- Sila pilih maklumat penguasaan bahasa pilihan kedua.';
        $("#penguasaan2").css("border-color","#f00");
    } else { $("#penguasaan2").css("border-color","#ccc");  }
    if(bahasa2.trim() == '' && penguasaan2.trim() != ''){
        msg = msg+'\n- Sila pilih maklumat bahasa pada pilihan kedua.';
        $("#bahasa2").css("border-color","#f00");
    } else { $("#bahasa2").css("border-color","#ccc");  }

    if(bahasa3.trim() != '' && penguasaan3.trim() == ''){
        msg = msg+'\n- Sila pilih maklumat penguasaan bahasa pilihan ketiga.';
        $("#penguasaan3").css("border-color","#f00");
    } else { $("#penguasaan3").css("border-color","#ccc");  }
    if(bahasa3.trim() == '' && penguasaan3.trim() != ''){
        msg = msg+'\n- Sila pilih maklumat bahasa pada pilihan ketiga.';
        $("#bahasa3").css("border-color","#f00");
    } else { $("#bahasa3").css("border-color","#ccc");  }


    // alert(bid1+":"+bid2);
    if(bid1.trim() == '1' || bid2.trim() == '1'){ 
	    if(bahasa1==bahasa2){
	        msg = msg+'\n- Maklumat berkaitan kebolehan bahasa bagi pilihan kedua sama\ndengan pilihan pertama. Sila kemaskini.';
	        $("#bahasa2").css("border-color","#f00");
	        $("#peringkat2").css("border-color","#f00");
	    }
	}
    if(bid2.trim() == '1'){ 
		if(bahasa1==bahasa3){
	        msg = msg+'\n- Maklumat berkaitan kebolehan bahasa bagi pilihan ketiga sama\ndengan pilihan pertama. Sila kemaskini.';
	        $("#bahasa3").css("border-color","#f00");
	        $("#penguasaan3").css("border-color","#f00");
	    }
	}
    if(bid3.trim() == '1'){ 
	    if(bahasa2==bahasa3){
	        msg = msg+'\n- Maklumat berkaitan kebolehan bahasa bagi pilihan ketiga sama\ndengan pilihan kedua. Sila kemaskini.';
	        $("#bahasa3").css("border-color","#f00");
	        $("#penguasaan3").css("border-color","#f00");
	    }
	}


    if(msg.trim() !=''){ 
        alert_msg_html(msg);
    } else { 
        $.ajax({
            url: 'tambahan/sql_bukanakademik.php?frm=BAKAT&pro=SAVE',
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
                      text: 'Terdapat ralat sistem.\nMaklumat anda tidak berjaya dikemaskini.',
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

function on_chg(vals){
	if(vals==1){
		$('#bid1').val(1);
		if($('#bahasa1').val()=='' && $('#penguasaan1').val()==''){
			$('#bid1').val(0);
		} 
	} else if(vals==2){
		$('#bid2').val(1);
		if($('#bahasa2').val()=='' && $('#penguasaan2').val()==''){
			$('#bid2').val(0);
		} 
	} else if(vals==3){
		$('#bid3').val(1);
		if($('#bahasa3').val()=='' && $('#penguasaan3').val()==''){
			$('#bid3').val(0);
		} 
	}
}

</script>
<?php
$uid=$_SESSION['SESS_UID'];
$proses=isset($_REQUEST["proses"])?$_REQUEST["proses"]:"";
$progid=isset($_REQUEST["progid"])?$_REQUEST["progid"]:"";
?>


<input type="hidden" name="id_pemohon" id="id_pemohon" value="<?php print $uid;?>" readonly="readonly"/>
		<div class="box" style="background-color:#F2F2F2">
      <div class="box-body">
				<!-- <div class="x_panel" style="background-color:#F2F2F2">
					<header class="panel-heading"  style="background-color:rgb(38, 167, 228)">
						<div class="panel-actions"></div>
						<h6 class="panel-title"><font color="#000000"><b><?=$menu;?></b></font></h6> 
					</header>
				</div> -->
				<div class="form-group">
						<div class="row">
							<div class="col-sm-12">
							<!--<label for="nama" class="col-sm-12 control-label"><b>ARAHAN : </b>
								<ul>
									<li>Ruangan ini hanya diisi oleh pemohon yang memohon jawatan di bawah Klasifikasi Perkhidmatan Bakat dan Seni.</li>
									<li>Sila pilih bakat yang paling mahir.</li>
								</ul>
							</label>-->
							

							<div class="card">
									<label for="nama" class="col-sm-12 control-label" style="border: 1px solid rgb(38, 167, 228);"><b>ARAHAN : </b>
										<ul>
											<li>Ruangan ini hanya diisi oleh pemohon yang memohon jawatan di bawah Klasifikasi Perkhidmatan Bakat dan Seni.</li>
											<li>Sila pilih bakat yang paling mahir.</li>
										</ul>
									</label>

							  </div></div>

						</div>
					</div>
      </div>            
		</div>
		
		<div class="box" style="background-color:#F2F2F2">
      <div class="box-body">
				<div class="x_panel" style="background-color:#F2F2F2">
					<header class="panel-heading"  style="background-color:rgb(38, 167, 228)">
						<div class="panel-actions"></div>
						<h6 class="panel-title"><font color="#000000"><b>Maklumat Bakat</b></font></h6> 
					</header>
				</div>
      </div>            
			<br />
      <div class="box-body" style="background-color:#F2F2F2">
          	<?php 
					// $conn->debug=true;
          	$rsData = $conn->query("SELECT * FROM $schema2.`calon_bakat_bahasa` WHERE `id_pemohon`='{$uid}' AND `bakat_bahasa_ind`='B'");
          	$bil=0;
			$sql = "SELECT * FROM $schema1.`ref_bakat` WHERE 1 GROUP BY kod";
			$rsBakat = $conn->query($sql);
			?>
			<div class="form-group">
				<div class="row">
					<div class="col-sm-4 text-center"><b>JENIS BAKAT</b></div>
				</div>
			</div>
			<?php while(!$rsData->EOF){ $bil++;?>
			<?php $rsBakat->movefirst(); ?>

			<div class="form-group">
				<div class="row">
					<div class="col-sm-4 col-xs-10">
						<select name="bakat<?=$bil;?>" id="bakat<?=$bil;?>" class="form-control">
							<option value="">Sila pilih maklumat bakat</option>
							<?php while(!$rsBakat->EOF){ ?>
							<option value="<?=$rsBakat->fields['kod'];?>" 
								<?php if($rsData->fields['bakat_bahasa']==$rsBakat->fields['kod']){ print 'selected'; } ?>><?=$rsBakat->fields['descripsi'];?></option>
							<?php $rsBakat->movenext(); } ?>
						</select>
					</div>
					<div class="col-sm-2 col-xs-2">
						<img src="../images/trash.png" title="Hapus maklumat sukan" style="cursor: pointer;" 
							onclick="do_hapus('tambahan/sql_bukanakademik.php?frm=BAKAT&pro=DEL_BAKAT&id_pemohon=<?=$uid;?>&v1=<?=$rsData->fields['bakat_bahasa'];?>&v2=B')">
							<input type="hidden" name="bakat_u<?=$bil;?>" value="<?=$rsData->fields['bakat_bahasa'];?>">
					</div>
				</div>
			</div>
			<?php $rsData->movenext(); } ?>

			<?php for($i=$bil;$i<3;$i++){ $p=$i+1; ?>
			<?php $rsBakat->movefirst(); ?>
			<div class="form-group">
				<div class="row">
					<div class="col-sm-4 col-xs-10">
						<select name="bakat<?=$p;?>" id="bakat<?=$p;?>" class="form-control">
							<option value="">Sila pilih maklumat bakat</option>
							<?php $rsBakat->movefirst();
							while(!$rsBakat->EOF){ ?>
							<option value="<?=$rsBakat->fields['kod'];?>"><?=$rsBakat->fields['descripsi'];?></option>
							<?php $rsBakat->movenext(); } ?>
						</select>
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
						<h6 class="panel-title"><font color="#000000"><b>Maklumat Kebolehan Bahasa / Dialek Selain Bahasa Melayu</b></font></h6> 
					</header>
				</div>
            </div>            
			<br />
            <div class="box-body" style="background-color:#F2F2F2">

					<div class="form-group">
						<div class="row">
							<div class="col-sm-5 col-xs-5 text-center"><b>BAHASA/DIALEK</b></div>
							<div class="col-sm-4 col-xs-4 text-center"><b>PENGUASAAN</b></div>
						</div>
					</div>
            	<?php 
							// $conn->debug=true;
		          	$rsData = $conn->query("SELECT * FROM $schema2.`calon_bakat_bahasa` WHERE `id_pemohon`='{$uid}' AND `bakat_bahasa_ind`='L'");
		          	$bil=0;
		
					$sql = "SELECT * FROM $schema1.`ref_bahasa` WHERE 1 GROUP BY kod";
					$rsBahasa = $conn->query($sql);
					$sql = "SELECT * FROM $schema1.`ref_penguasaan_bahasa` WHERE 1 GROUP BY kod";
					$rsPenguasaan = $conn->query($sql);
					?>
					<?php while(!$rsData->EOF){ $bil++;?>
    				<?php $rsBahasa->movefirst(); $rsPenguasaan->movefirst(); ?>
					<div class="form-group">
						<div class="row">
							<div class="col-sm-5 col-xs-5">
								<select name="bahasa<?=$bil;?>" id="bahasa<?=$bil;?>" class="form-control" onchange="on_chg(<?=$bil;?>)">
									<option value="">Sila pilih maklumat bahasa/dialek</option>
									<?php while(!$rsBahasa->EOF){ ?>
									<option value="<?=$rsBahasa->fields['kod'];?>" 
										<?php if($rsData->fields['bakat_bahasa']==$rsBahasa->fields['kod']){ print 'selected'; } ?>><?=$rsBahasa->fields['diskripsi'];?></option>
									<?php $rsBahasa->movenext(); } ?>
								</select>
							</div>
							<div class="col-sm-4 col-xs-5">
								<select name="penguasaan<?=$bil;?>" id="penguasaan<?=$bil;?>" class="form-control" onchange="on_chg(<?=$bil;?>)">
									<option value="">Sila pilih maklumat penguasaan</option>
									<?php while(!$rsPenguasaan->EOF){ ?>
									<option value="<?=$rsPenguasaan->fields['KOD'];?>" 
										<?php if($rsData->fields['penguasaan']==$rsPenguasaan->fields['KOD']){ print 'selected'; } ?>><?=$rsPenguasaan->fields['DISKRIPSI'];?></option>
									<?php $rsPenguasaan->movenext(); } ?>
								</select>
							</div>
							<div class="col-sm-2 col-xs-2">
								<img src="../images/trash.png" title="Hapus maklumat sukan" style="cursor: pointer;" 
									onclick="do_hapus('tambahan/sql_bukanakademik.php?frm=BAKAT&pro=DEL_BAHASA&id_pemohon=<?=$uid;?>&v1=<?=$rsData->fields['bakat_bahasa'];?>&v2=B&v3=<?=$rsData->fields['penguasaan'];?>')">
									<input type="hidden" name="bahasa_u<?=$bil;?>" value="<?=$rsData->fields['bakat_bahasa'];?>">
									<input type="hidden" name="penguasaan_u<?=$bil;?>" value="<?=$rsData->fields['penguasaan'];?>">
									<input type="hidden" name="bid<?=$bil;?>" id="bid<?=$bil;?>" value="0">
							</div>
						</div>
					</div>
					<?php $rsData->movenext(); } ?>

	            	<?php for($i=$bil;$i<3;$i++){ $p=$i+1; ?>
	            	<?php $rsBahasa->movefirst(); $rsPenguasaan->movefirst(); ?>
					<div class="form-group">
						<div class="row">
							<div class="col-sm-5 col-xs-5">
								<select name="bahasa<?=$p;?>" id="bahasa<?=$p;?>" class="form-control" onchange="on_chg(<?=$p;?>)">
									<option value="">Sila pilih maklumat bahasa/dialek</option>
									<?php while(!$rsBahasa->EOF){ ?>
									<option value="<?=$rsBahasa->fields['kod'];?>"><?=$rsBahasa->fields['diskripsi'];?></option>
									<?php $rsBahasa->movenext(); } ?>
								</select>
							</div>
							<div class="col-sm-4 col-xs-5">
								<select name="penguasaan<?=$p;?>" id="penguasaan<?=$p;?>" class="form-control" onchange="on_chg(<?=$bil;?>)">
									<option value="">Sila pilih maklumat penguasaan</option>
									<?php while(!$rsPenguasaan->EOF){ ?>
									<option value="<?=$rsPenguasaan->fields['KOD'];?>"><?=$rsPenguasaan->fields['DISKRIPSI'];?></option>
									<?php $rsPenguasaan->movenext(); } ?>
								</select>
							</div>
							<div class="col-sm-2 col-xs-2">
								<input type="hidden" name="bid<?=$p;?>" id="bid<?=$p;?>" value="0">
							</div>
						</div>
					</div>
					<?php } ?>

            </div>

            <div class="modal-footer" style="padding:0px;">
						<button type="button" id="simpan" class="btn btn-primary mt-sm mb-sm" onclick="do_bakat()"><i class="fa fa-save"></i> Simpan</button>
						&nbsp;
						<!-- <button type="button" id="simpan_next" class="btn btn-success mt-sm mb-sm" onclick="do_save('SAVE','SEND')"><i class="fa fa-save"></i> Simpan & Hantar</button>
						&nbsp; -->
						<!-- <button type="button" class="btn btn-default" onclick="do_page('index.php?data=<?php print base64_encode('maklumat/pemantauan_list;DATA;Maklumat Pemantauan;;;;'); ?>')">
							<i class="fa fa-spinner" style="margin:0px;"></i> Kembali</button> -->
						<input type="hidden" name="progid" id="progid" value="<?php print $progid;?>" />
						<input type="hidden" name="proses" value="<?php print $proses;?>" />
					</div>
		</div>
          