<?php //include '../connection/common.php'; ?>
<script language="javascript">
function do_save(val1, val2){
	var id_pemohon = $('#id_pemohon').val();
	var addr1 = $('#addr1').val();
	var dob = $('#dob').val();
	var poskod = $('#poskod').val();
	var negeri = $('#negeri').val();
	var bandar = $('#bandar').val();
	var e_mail = $('#e_mail').val();
	var no_tel = $('#no_tel').val();
	var negeri_lahir_pemohon = $('#negeri_lahir_pemohon').val();
	var taraf_kawin = $('#taraf_kawin').val();
	var negeri_lahir_ibu = $('#negeri_lahir_ibu').val();
	var ketinggian = $('#ketinggian').val();
	var berat = $('#berat').val();
	var negeri_lahir_bapa = $('#negeri_lahir_bapa').val();
	var lesen = $('#lesen').val();
	var khidmat = $('#khidmat').val();
	var jantina = $('#jantina').val();
	var agama = $('#agama').val();
	var oku = $('#oku').val();
	var no_rujukan_oku = $('#no_rujukan_oku').val();
	var bantuan = $('#bantuan').val();
	var no_rujukan_bantuan = $('#no_rujukan_bantuan').val();
	var msg = '';

	const checkboxes = document.querySelectorAll(`input[name="lesen"]:checked`);
    let values = [];
    checkboxes.forEach((checkbox) => {
        values.push(checkbox.value);
    });

    document.myspp.lesen_kenderaan.value=values;

    if(no_tel.trim() ==''){
        msg = msg+'\n- Sila masukkan nombot telefon.';
        $("#no_tel").css("border-color","#f00");
    } 
    if(dob.trim() ==''){
        msg = msg+'\n- Sila masukkan tarikh lahir pemohon.';
        $("#dob").css("border-color","#f00");
    } 
    if(addr1.trim() ==''){
        msg = msg+'\n- Sila masukkan alamat surat menyurat.';
        $("#addr1").css("border-color","#f00");
    } 
    if(poskod.trim() ==''){
        msg = msg+"\n- Sila masukkan poskod.";
        $("#poskod").css("border-color","#f00");
    } 
    if(negeri.trim() ==''){
        msg = msg+"\n- Sila pilih maklumat negeri.";
        $('#negeri').css("border-color","#f00");
	}
    if(bandar.trim() ==''){
        msg = msg+"\n- Sila pilih maklumat bandar.";
        $('#bandar').css("border-color","#f00");
	}
    if(jantina.trim() ==''){
        msg = msg+"\n- Sila pilih maklumat jantina.";
        $('#jantina').css("border-color","#f00");
	}
    if(agama.trim() ==''){
        msg = msg+"\n- Sila pilih maklumat agama.";
        $('#agama').css("border-color","#f00");
	}
    if(negeri_lahir_pemohon.trim() ==''){
        msg = msg+"\n- Sila pilih maklumat negeri kelahiran pemohon.";
        $('#negeri_lahir_pemohon').css("border-color","#f00");
	}
    if(taraf_kawin.trim() ==''){
        msg = msg+"\n- Sila pilih maklumat taraf perkahwinan.";
        $('#taraf_kawin').css("border-color","#f00");
	}
    if(negeri_lahir_ibu.trim() ==''){
        msg = msg+"\n- Sila pilih maklumat negeri kelahiran Ibu.";
        $('#negeri_lahir_ibu').css("border-color","#f00");
	}
    if(negeri_lahir_bapa.trim() ==''){
        msg = msg+"\n- Sila pilih maklumat negeri kelahiran Bapa.";
        $('#negeri_lahir_bapa').css("border-color","#f00");
	}
    if(ketinggian.trim() ==''){
        msg = msg+"\n- Sila masukkan maklumat ketinggian.";
        $('#ketinggian').css("border-color","#f00");
	}
    if(berat.trim() ==''){
        msg = msg+"\n- Sila masukkan maklumat berat.";
        $('#berat').css("border-color","#f00");
	}
    if(oku.trim()!='' && no_rujukan_oku.trim()==''){
        msg = msg+"\n- Sila masukkan nombor daftar OKU.";
        $('#no_rujukan_oku').css("border-color","#f00");
	}
    if(bantuan.trim()!='' && no_rujukan_bantuan.trim()==''){
        msg = msg+"\n- Sila masukkan nombor pendaftaran bantuan.";
        $('#no_rujukan_bantuan').css("border-color","#f00");
	}
    if(khidmat.trim() ==''){
        msg = msg+"\n- Sila pilih maklumat perkhidmatan awam (Jika Berkenaan).";
        $('#masih_khidmat').css("border-color","#f00");
	}

	// alert(msg);
	if(msg.trim() !=''){ 
		alert_msg_html(msg);
	} else { 
		var fd = new FormData();
        var files1 = $('#fileupload')[0].files[0];
        // var files2 = $('#upload_id2')[0].files[0];
        fd.append('fileupload',files1);
        // fd.append('upload_id2',files2);

        var other_data = $('form').serializeArray();
		$.each(other_data,function(key,input){
		    fd.append(input.name,input.value);
		});

        $.ajax({
	        url:'biodata/sql_biodata.php?frm=BIODATA&pro=SAVE',
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

function do_poskod(poskod){
	//alert(kat);
	var sel="#bandar";
	//var sel_pej="#appl_pejabat";
	//$(sel_pej).empty();
	$.ajax({
		url: '../include/get_daerah.php?poskod='+poskod,
		type: 'post',
		data: {neg:neg},
		dataType: 'json',
		success:function(response){
			//alert(response);
			var len = response.length;
	
			$(sel).empty();
			for( var i = 0; i<len; i++){
				var id = response[i]['id'];
				var name = response[i]['name'];
				$(sel).append("<option value='"+id+"'>"+name+"</option>");
			}
		}
	});
	//get_pejabat();
	//document.kkm.kod_negeri1.value=neg;
	// get_code();
}

function get_dae(neg){
	// alert(kat);
	var sel="#bandar";
	//var sel_pej="#appl_pejabat";
	//$(sel_pej).empty();
	$.ajax({
		url: '../include/get_daerah.php?neg='+neg,
		type: 'post',
		data: {neg:neg},
		dataType: 'json',
		success:function(response){
			//alert(response);
			var len = response.length;
	
			$(sel).empty();
			for( var i = 0; i<len; i++){
				var id = response[i]['id'];
				var name = response[i]['name'];
				$(sel).append("<option value='"+id+"'>"+name+"</option>");
			}
		}
	});
	//get_pejabat();
	//document.kkm.kod_negeri1.value=neg;
	// get_code();
}

function lesen(){
	var checkedValue = $('.messageCheckbox:checked').val();
	alert(checkedValue);
}

function val_khidmat(val){
	document.myspp.khidmat.value = val;
}

var validateH = function(e) {
 	var t = e.value;
  	if(t<=2.5){ 
  		e.value = (t.indexOf(".") >= 0) ? (t.substr(0, t.indexOf(".")) + t.substr(t.indexOf("."), 3)) : t;
	} else {
		alert("Sila pastikan ketinggian tidak boleh melebihi 2.5 meter");
		document.myspp.ketinggian.value='';
	}
}
var validateB = function(e) {
 	var t = e.value;
  	if(t<=200){ 
  		e.value = (t.indexOf(".") >= 0) ? (t.substr(0, t.indexOf(".")) + t.substr(t.indexOf("."), 3)) : t;
	} else {
		alert("Sila pastikan berat tidak boleh melebihi 200 KG");
		document.myspp.berat.value='';
	}
}

</script>
<?php
// $conn->debug=true;
// $_SESSION['page_name']="MAKLUMAT PEMANTAUAN";
$read_only='';


$user = get_user($conn,$_SESSION['SESS_UID']);
$data = get_biodata($conn,$_SESSION['SESS_UID']);

$lesen_kenderaan = $data['lesen_kenderaan'];
$str_arr = explode ("-", $lesen_kenderaan); 

$dob = str_replace(" 00:00:00", "", $data['dob']);
// print $dob;
if(empty($dob)){
	$tahun = substr($user['ICNo'], 0,2);
	$bulan = substr($user['ICNo'], 2,2);
	$hari = substr($user['ICNo'], 4,2);
	if($tahun<='60'){ $tahun="20".$tahun; }
	else { $tahun = "19".$tahun; }

	$dob = $tahun."-".$bulan."-".$hari;;
	// print 
}

//print_r($str_arr); 
?>
		<header class="panel-heading"  style="background-color:rgb(209 29 29)">
			<h6 class="panel-title"><font color="#000000" size="3"><b>MAKLUMAT BIODATA PEMOHON</b></font></h6>
		</header>
		<!-- <div class="panel-body"> -->
		<div>
			<div class="box-body">

			<input type="hidden" name="id_pemohon" id="id_pemohon" value="<?php print $_SESSION['SESS_UID'];?>" readonly="readonly"/>

                <div class="form-group">
					<div class="row">
                    <div class="col-md-9">

                        <div class="form-group">
                            <div class="row">
                                <label for="nama" class="col-sm-4 control-label"><b>MyID (No. Kad Pengenalan)<div style="float:right">:</div></b></label>
                                <div class="col-sm-8"><b><?php print $_SESSION['SESS_UIC'];?></b></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label for="nama" class="col-sm-4 control-label"><b>Nama Penuh<div style="float:right">:</div></b></label>
                                <div class="col-sm-8"><b><?php print $_SESSION['SESS_UNAME'];?></b></div>
                            </div>
                        </div>
						<div class="form-group">
							<div class="row">
								<label for="nama" class="col-sm-4 control-label"><b>Alamat E-mel <font color="#FF0000">*</font><div style="float:right">:</div></b></label>
								<div class="col-sm-8"><b><?php print $_SESSION['SESS_EMEL'];?></b></div>
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<label for="nama" class="col-sm-4 control-label"><b>No. Telefon <font color="#FF0000">*</font><div style="float:right">:</div></b></label>
								<div class="col-sm-3">
									<input type="text" name="no_tel" id="no_tel" class="form-control" value="<?php print $data['no_tel'];?>" 
									 data-inputmask='"mask": "999-9999 9999"' data-mask maxlength="11"><small>( Cth: 0123456789 )</small>
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<label for="nama" class="col-sm-4 control-label"><b>Tarikh Lahir <font color="#FF0000">*</font><div style="float:right">:</div></b></label>
								<div class="col-sm-3">
									<input type="date" name="dob" id="dob" class="form-control" value="<?php print $dob;?>">
								</div>
							</div>
						</div>
<!--                         <div class="form-group">
                            <div class="row">
                                <label for="nama" class="col-sm-4 control-label"><b>Jawapan Soalan Keselamatan<div style="float:right">:</div></b></label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label for="nama" class="col-sm-4 control-label"><b>Nama Ibu Pemohon<div style="float:right">:</div></b></label>
                                <div class="col-sm-8"><b><?php print $user['kod_keselamatan'];?></b></div>
                            </div>
                        </div>
						<div class="form-group">
							<div class="row">
								<label for="nama" class="col-sm-4 control-label"><b>Negeri Kelahiran Pemohon<div style="float:right">:</div></b></label>
								<div class="col-sm-8"><b><?php print dlookup($schema2.".ref_negeri","diskripsi","kod=".tosql($user['neg_keselamatan']));?></b></div>
							</div>
						</div> -->
                    </div>
                    <div class="col-md-3">
                        <div class="col-sm-12" align="center">
                            <img src="<?=$gambar;?>" width="130" height="150">
                            <input type="file" name="fileupload" id="fileupload" class="form-control">
                        </div>
                    </div>
					</div>
                </div>
                <hr>
					<div class="form-group">
						<div class="row">
							<label for="nama" class="col-sm-3 control-label"><b>Alamat Surat Menyurat<font color="#FF0000">*</font><div style="float:right">:</div></b></label>
							<div class="col-sm-9">
								<input type="text" name="addr1" id="addr1" class="form-control" value="<?php print $data['addr1'];?>">
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="row">
							<label for="nama" class="col-sm-3 control-label"></label>
							<div class="col-sm-9">
								<input type="text" name="addr2" id="addr2" class="form-control" value="<?php print $data['addr2'];?>">
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="row">
							<label for="nama" class="col-sm-3 control-label"></label>
							<div class="col-sm-9">
								<input type="text" name="addr3" id="addr3" class="form-control" value="<?php print $data['addr3'];?>">
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="row">
							<label for="nama" class="col-sm-3 control-label"><b>Poskod<div style="float:right">:</div></b></label>
							<div class="col-sm-3">
								<input type="text" name="poskod" id="poskod" class="form-control" value="<?php print $data['poskod'];?>" maxlength="5">
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="row">
							<label for="negeri" class="col-sm-3 control-label"><b>Negeri <font color="#FF0000">*</font><div style="float:right">:</div></b></label>
							<div class="col-sm-3">
								<select name="negeri" id="negeri" class="form-control" style="width: 100%;" aria-hidden="true" onchange="get_dae(this.value)">
									<option value="">Sila pilih Negeri</option>
									<?php print get_negeri($conn, $data['negeri']); ?>
								</select>
							</div>
							<div class="col-sm-1"></div>
							<label for="nama" class="col-sm-2 control-label"><b>Bandar <font color="#FF0000">*</font><div style="float:right">:</div></b></label>
							<div class="col-sm-3">
								<select name="bandar" id="bandar" class="form-control" style="width: 100%;" aria-hidden="true">
									<option value="">Sila pilih bandar</option>
									<?php print get_bandar($conn, $data['bandar'], $data['negeri']); ?>
								</select>
							</div>
						</div>
					</div>

					<div class="form-group">
						<div class="row"> 
							<label for="nama" class="col-sm-3 control-label"><b>Jantina <font color="#FF0000">*</font><div style="float:right">:</div></b></label>
							<div class="col-sm-3">
								<select name="jantina" id="jantina" class="form-control">
									<option value="">Sila pilih Jantina</option>
									<option value="1" <?if($data['jantina']=='1'){ print 'selected'; }?>>LELAKI</option>
									<option value="2" <?if($data['jantina']=='2'){ print 'selected'; }?>>PEREMPUAN</option>
								</select>
							</div>
							<div class="col-sm-1"></div>
							<label for="nama" class="col-sm-2 control-label"><b>Agama <font color="#FF0000">*</font><div style="float:right">:</div></b></label>
							<div class="col-sm-3">
								<select name="agama" id="agama" class="form-control">
									<option value="">Sila pilih Agama</option>
									<?php print get_agama($conn, $data['agama']); ?>
								</select>
							</div>
						</div>
					</div>

					<hr>

					<div class="form-group">
						<div class="row">
							<label for="nama" class="col-sm-3 control-label"><b>Negeri Tempat Lahir<div style="float:right"></div></b></label>
						</div>
					</div>
					<div class="form-group">
						<div class="row">
							<label for="nama" class="col-sm-3 control-label"><b>Pemohon <font color="#FF0000">*</font><div style="float:right">:</div></b></label>
							<div class="col-sm-3">
								<select name="negeri_lahir_pemohon" id="negeri_lahir_pemohon" class="form-control " 
									style="width: 100%;" aria-hidden="true">									
									<option value="">Sila pilih Negeri</option>
									<?php print get_negeri($conn, $data['negeri_lahir_pemohon']); ?>
								</select>
							</div>
							<div class="col-sm-1"></div>
							<label for="nama" class="col-sm-2 control-label" ><b>Taraf Perkahwinan <font color="#FF0000">*</font><div style="float:right">:</div></b></label>
							<div class="col-sm-3">
								<select name="taraf_kawin" id="taraf_kawin" class="form-control">
									<option value="">Sila pilih taraf perkahwinan</option> 
									<?php print get_perkahwinan($conn, $data['taraf_kawin']); ?>
								</select>
							</div>
						</div> 
					</div>
					<div class="form-group">
						<div class="row"> 
							<label for="nama" class="col-sm-3 control-label"><b>Ibu Pemohon <font color="#FF0000">*</font><div style="float:right">:</div></b></label>
							<div class="col-sm-3">
								<select name="negeri_lahir_ibu" id="negeri_lahir_ibu" class="form-control" style="width: 100%;" aria-hidden="true">									
									<option value="">Sila pilih Negeri</option>
									<?php print get_negeri($conn, $data['negeri_lahir_ibu']); ?>
								</select>
							</div>
							<div class="col-sm-1"></div>

							<label for="nama" class="col-sm-2 control-label"><b>Bapa Pemohon <font color="#FF0000">*</font><div style="float:right">:</div></b></label>
							<div class="col-sm-3">
								<select name="negeri_lahir_bapa" id="negeri_lahir_bapa" class="form-control" style="width: 100%;" aria-hidden="true">									
									<option value="">Sila pilih Negeri</option>
									<?php print get_negeri($conn, $data['negeri_lahir_bapa']); ?>
								</select>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="row">
							
							<label for="nama" class="col-sm-3 control-label"><b>Ketinggian (meter) <font color="#FF0000">*</font><div style="float:right">:</div></b></label>
							<div class="col-sm-2">
								<input type="" name="ketinggian" id="ketinggian" value="<?=$data['ketinggian'];?>" class="form-control" oninput="validateH(this)">
							</div>

							<div class="col-sm-2"></div>
							<label for="nama" class="col-sm-2 control-label"><b>Berat (KG) <font color="#FF0000">*</font><div style="float:right">:</div></b></label>
							<div class="col-sm-2">
								<input type="" name="berat" id="berat" value="<?=$data['berat'];?>" class="form-control" oninput="validateB(this)">
							</div>
							
						</div>
					</div>
					<div class="form-group">
						<div class="row">
							<label for="nama" class="col-sm-3 control-label"><b>Lesen Kenderaan <div style="float:right">:</div></b></label>
							<div class="col-sm-9">
								<input type="checkbox" name="lesen" id="lesen" value="A" <?php if(in_array("A",$str_arr)){ print 'checked'; }?>> A&nbsp;
								<input type="checkbox" name="lesen" id="lesen" value="B" <?php if(in_array("B",$str_arr)){ print 'checked'; }?>> B&nbsp;
								<input type="checkbox" name="lesen" id="lesen" value="B1" <?php if(in_array("B1",$str_arr)){ print 'checked'; }?>> B1&nbsp;
								<input type="checkbox" name="lesen" id="lesen" value="B2" <?php if(in_array("B2",$str_arr)){ print 'checked'; }?>> B2&nbsp;
								<input type="checkbox" name="lesen" id="lesen" value="C" <?php if(in_array("C",$str_arr)){ print 'checked'; }?>> C&nbsp;
								<input type="checkbox" name="lesen" id="lesen" value="D" <?php if(in_array("D",$str_arr)){ print 'checked'; }?>> D&nbsp;
								<input type="checkbox" name="lesen" id="lesen" value="E" <?php if(in_array("E",$str_arr)){ print 'checked'; }?>> E&nbsp;
								<input type="checkbox" name="lesen" id="lesen" value="E1" <?php if(in_array("E1",$str_arr)){ print 'checked'; }?>> E1&nbsp;
								<input type="checkbox" name="lesen" id="lesen" value="E2" <?php if(in_array("E2",$str_arr)){ print 'checked'; }?>> E2&nbsp;
								<input type="checkbox" name="lesen" id="lesen" value="F" <?php if(in_array("F",$str_arr)){ print 'checked'; }?>> F&nbsp;
								<input type="checkbox" name="lesen" id="lesen" value="G" <?php if(in_array("G",$str_arr)){ print 'checked'; }?>> G&nbsp;
								<input type="checkbox" name="lesen" id="lesen" value="H" <?php if(in_array("H",$str_arr)){ print 'checked'; }?>> H&nbsp;
								<input type="checkbox" name="lesen" id="lesen" value="I" <?php if(in_array("I",$str_arr)){ print 'checked'; }?>> I&nbsp;
								<input type="checkbox" name="lesen" id="lesen" value="P" <?php if(in_array("P",$str_arr)){ print 'checked'; }?>> P&nbsp;
							</div>
							<div class="col-sm-3">
								<input type="hidden" name="lesen_kenderaan" value="<?=$lesen_kenderaan;?>">
							</div>
							
						</div>
					</div>		
					

					<!-- <div class="form-group">
						<div class="row">
							<label for="nama" class="col-sm-12 control-label"><b>ARAHAN : </b>
								<ul>
									<li>Untuk diisi oleh Orang Kurang Upaya (OKU) sahaja.</li>
								</ul>
							</label>
						</div>
					</div>
					<hr> -->

					<hr>
					<div class="form-group">
						<div class="row">
								<ul>
									<li>Untuk diisi oleh Orang Kurang Upaya (OKU) sahaja.</li>
								</ul>
							</label>
						</div>
					</div>
					<div class="form-group">
						<div class="row">
							<label for="nama" class="col-sm-3 control-label"><b>Jenis Kurang Upaya  <div style="float:right">:</div></b></label>
							<div class="col-sm-3">
								<select name="oku" id="oku" class="form-control">
									<option value="">Sila pilih jenis kecacatan</option>
									<?php print get_oku($conn, $data['oku']); ?>
								</select>
							</div>
							<div class="col-sm-1"></div>
							<label for="nama" class="col-sm-2 control-label"><b>No.Pendaftaran OKU <div style="float:right">:</div></b></label>
							<div class="col-sm-2">
								<input type="text" name="no_rujukan_oku" id="no_rujukan_oku" class="form-control" value="<?=$data['no_rujukan_oku'];?>">
							</div>
						</div>
					</div>
					<hr>
					<div class="form-group">
						<div class="row">
								<ul>
									<li>Isikan sekiranya ibu/bapa/pemohon menerima bantuan Program Kesejahteraan Rakyat / Bantuan Kebajikan Masyarakat / Program Perumahan Rakyat.</li>
								</ul>
							</label>
						</div>
					</div>
				
					<div class="form-group">
						<div class="row">
							<label for="nama" class="col-sm-3 control-label"><b>Jenis Bantuan <div style="float:right">:</div></b></label>
							<div class="col-sm-3">
								<select name="bantuan" id="bantuan" class="form-control">
									<option value="">Sila pilih jenis bantuan</option>
									<?php print get_bantuan($conn, $data['bantuan']); ?>
								</select>
							</div>
							<div class="col-sm-1"></div>
							<label for="nama" class="col-sm-2 control-label"><b>No.Pendaftaran Bantuan <div style="float:right">:</div></b></label>
							<div class="col-sm-3">
								<input type="text" name="no_rujukan_bantuan" id="no_rujukan_bantuan" class="form-control" value="<?=$data['no_rujukan_bantuan'];?>">
							</div>
						</div>
					</div>
										
					<hr>

					<div class="form-group">
						<div class="row">
							<label for="nama" class="col-sm-10 control-label"><b>Adakah anda sedang berkhidmat dalam Perkhidmatan Awam / Kerajaan Tempatan / Badan Berkanun / Polis? <font color="#FF0000">*</font><div style="float:right">:</div></b></label>
							<div class="col-sm-2">
								<input type="radio" name="masih_khidmat" id="masih_khidmat" value="Y" <?php if($data['masih_khidmat']=='Y'){ print 'checked'; }?> onclick="val_khidmat('Y')"> Ya &nbsp;
								<input type="radio" name="masih_khidmat" id="masih_khidmat" value="T" <?php if($data['masih_khidmat']=='T'){ print 'checked'; }?> onclick="val_khidmat('T')"> Tidak &nbsp;
							</div>
						</div>
						<input type="hidden" name="khidmat" id="khidmat" value="<?=$data['masih_khidmat'];?>">

					</div>

					<div class="modal-footer" style="padding:0px;">
						<button type="button" id="simpan" class="btn btn-primary mt-sm mb-sm" onclick="do_save('SAVE','')"><i class="fa fa-save"></i> Simpan</button>
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
	     

<script src="../plugins/moment/moment.min.js"></script>
<script src="../plugins/inputmask/jquery.inputmask.min.js"></script>

<script language="javascript" type="text/javascript">
//document.frm.gsasar_nama.focus();
$(function () {
 $('[data-mask]').inputmask()
})
</script>

