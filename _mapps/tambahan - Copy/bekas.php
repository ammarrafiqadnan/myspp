<?php //include '../connection/common.php'; ?>
<script language="javascript">
function do_polis(){
    var reg = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
    var kategori = $('#kategori').val();
    var pangkat = $('#pangkat').val();
    var ganjaran = $('#ganjaran').val();
    var NONO2 = $('#NONO2').val();
    var msg = '';
    //alert("dd");
    if(kategori.trim() == '' ){
        msg = msg+'- Sila pilih kategori jawatan.';
        $("#kategori").css("border-color","#f00");
    } 
    if(pangkat.trim() == '' ){
        msg = msg+'\n- Sila pilih pangkat bagi jawatan.';
        $("#pangkat").css("border-color","#f00");
    }
    if(ganjaran.trim() == '' ){
        msg = msg+'\n- Sila pilih maklumat pencen/ganjaran.';
        $("#ganjaran").css("border-color","#f00");
    }

    if(msg.trim() !=''){ 
        alert_msg_html(msg);
    } else { 
        $.ajax({
            url: '',
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
                // alert(data);
                if(data=='OK'){
                    swal({
                      title: 'Berjaya',
                      text: 'Maklumat kata laluan baru anda telah dihantar ke alamat e-mel anda.',
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
                      text: 'Terdapat ralat sistem.\nMaklumat lupa kata laluan tidak berjaya diproses.',
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
</script>
<?php
$kategori=isset($_REQUEST["kategori"])?$_REQUEST["kategori"]:"";
// $conn->debug=true;
?>
		<header class="panel-heading"  style="background-color:rgb(38, 167, 228)">
			<h6 class="panel-title"><font color="#000000" size="3"><b><?php print strtoupper($menu);?></b></font></h6>
		</header>
		<div class="panel-body">
			<div class="box-body">

			<input type="hidden" name="pemantauan_id" id="pemantauan_id" value="<?php print $id;?>" readonly="readonly"/>

				<div class="col-md-12">

					<?php include 'biodata/biodata_view.php'; ?>

					<div class="form-group">
					<div class="row">
						<p>
						  <button class="btn btn-primary form-control" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample" title="Sila klik untuk membaca arahan berkaitan kemasukan data akademik SPM">
						    ARAHAN:
						  </button>
						</p>
						<!-- <div class="collapse" id="collapseExample"> -->
						  <div class="card card-body">
								<label for="nama" class="col-sm-12 control-label"><b>ARAHAN : </b>
									<ul>
										<li>Bekas tentera perlu mengemukakan Buku Tamat Perkhidmatan semasa menghadiri temu duga.</li>
										<li>Hanya Bekas Tentera/Polis yang menerima GANJARAN dan telah tamat tempoh perkhidmatan sahaja dibenarkan memohon jawatan dalam perkhidmatan awam untuk lantikan secara tetap dan berpencen.</li>
										<li style="color:red">Pesara Polis/Tentera yang menerima PENCEN, hanya boleh memohon jawatan bagi lantikan Kontrak/Sementara secara terus melalui Kementerian/Jabatan yang mempunyai kekosongan jawatan, tanpa perlu meneruskan permohonan dalam borang SPP.</li>
									</ul>
									<hr>
								</label>

						  </div>
						<!-- </div> -->
					</div>
						
					<?php 
					// $conn->debug=true;
					$sql = "SELECT * FROM $schema1.`ref_bekas_pol_ten` WHERE kod_pangkat=0 GROUP BY kod_bekas_polis_tentera";
					$rsBekas = $conn->query($sql);
					?>
					<div class="form-group">
						<div class="row">
							<label for="nama" class="col-sm-2 control-label"><b>Kategori <font color="#FF0000">*</font><div style="float:right">:</div></b></label>
							<div class="col-sm-4">
								<select name="kategori" id="kategori" class="form-control" onchange="do_pages('<?=$actual_link;?>')">
									<option value="">Sila pilih kategori</option>
									<?php while(!$rsBekas->EOF){ ?>
									<option value="<?=$rsBekas->fields['kod_bekas_polis_tentera'];?>" 
										<?php if($kategori==$rsBekas->fields['kod_bekas_polis_tentera']){ print 'selected'; } ?>><?=$rsBekas->fields['diskripsi'];?></option>
									<?php $rsBekas->movenext(); } ?>
								</select>
							</div>
						</div>
					</div>
					<?php 
					// $conn->debug=true;
					$sql = "SELECT * FROM $schema1.`ref_bekas_pol_ten` WHERE kod_pangkat!=0 AND kod_bekas_polis_tentera='{$kategori}' 
					GROUP BY kod_bekas_polis_tentera, susunan_kanan DESC";
					$rsPangkat = $conn->query($sql);
					?>
					<div class="form-group">
						<div class="row">
							<label for="nama" class="col-sm-2 control-label"><b>Pangkat <font color="#FF0000">*</font><div style="float:right">:</div></b></label>
							<div class="col-sm-8">
								<select class="form-control" name="pangkat" id="pangkat">
									<option value="">Sila pilih</option>
									<?php while(!$rsPangkat->EOF){ ?>
									<option value="<?=$rsPangkat->fields['kod_pangkat'];?>"><?=$rsPangkat->fields['diskripsi'];?></option>
									<?php $rsPangkat->movenext(); } ?>
								</select>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="row">
							<label for="nama" class="col-sm-2 control-label"><b> Pencen / Ganjaran  <font color="#FF0000">*</font><div style="float:right">:</div></b></label>
							<div class="col-sm-3">
								<select class="form-control" name="ganjaran" id="ganjaran">
									<option value="">Sila pilih</option>
									<option value="1">MENERIMA PENCEN</option>
									<option value="2">MENERIMA GANJARAN</option>
								</select>
							</div>
						</div>
					</div>

					
					
					<div class="modal-footer" style="padding:0px;">
						<button type="button" id="simpan" class="btn btn-primary mt-sm mb-sm" onclick="do_polis()"><i class="fa fa-save"></i> Simpan</button>
						&nbsp;
						<!-- <button type="button" id="simpan_next" class="btn btn-success mt-sm mb-sm" onclick="do_save('SAVE','SEND')"><i class="fa fa-save"></i> Simpan & Hantar</button>
						&nbsp; -->
						<!-- <button type="button" class="btn btn-default" onclick="do_page('index.php?data=<?php print base64_encode('maklumat/pemantauan_list;DATA;Maklumat Pemantauan;;;;'); ?>')">
							<i class="fa fa-spinner" style="margin:0px;"></i> Kembali</button> -->
						<input type="hidden" name="progid" id="progid" value="<?php print $progid;?>" />
						<input type="hidden" name="proses" value="<?php print $proses;?>" />
					</div>
				</div>

			
			</div>
		</div>
	     

<script language="javascript" type="text/javascript">
//document.frm.gsasar_nama.focus();
</script>		 
