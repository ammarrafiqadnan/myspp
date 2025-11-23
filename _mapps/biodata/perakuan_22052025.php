<?php //include '../connection/common.php'; ?>
<script language="javascript">
function do_alert(){
	swal({
		title: 'Makluman',
		text: 'Terdapat maklumat yang tidak lengkap. Sila lengkapkan sebelum butang hantar diaktifkan.',
		type: 'info',
		confirmButtonClass: "btn-success",
		confirmButtonText: "Ok",
		showConfirmButton: true,
	});
}

function do_save(){
    var reg = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
    // var chk_declare = $('#chk_declare').val();
    var checkedValue = "";
    if($('.chk_declare:checked').val()=='on'){ checkedValue='on'; }
    var msg = '';
    // alert(checkedValue);
    if(checkedValue.trim() == '' ){
        msg = msg+'- Sila tanda pada Maklumat Perakuan Pemohon.';
        // $("#chk_declare").css("border-color","#f00");
	    document.getElementsByClassName("btn-group")[0].style.border = '2px solid red';
    } else {
    	document.getElementsByClassName("btn-group")[0].style.border = '';
    } 

    if(msg.trim() !=''){ 
        alert_msg_html(msg);
    } else { 
        $.ajax({
            url: 'biodata/sql_mohon.php?frm=PERAKUAN&pro=SAVE',
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
                //alert(data);
                if(data=='OK' || data=='Oracle ODBC connection failed!OK'){
                    swal({
                      title: 'Berjaya',
                      text: 'Maklumat telah berjaya dihantar. Anda boleh mencetak slip permohonan di menu Dashboard.',
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
                      text: 'Terdapat ralat sistem.\nSila maklumkan kepada pihak penyelia sistem.',
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

</script>
<?php
$btn_ok='OK';
// $conn->debug=true;
include 'akademik/sql_akademik.php';
// include 'biodata/sql_biodata.php';
// $user = get_user($conn,$_SESSION['SESS_UID']);
$data_biodata = get_biodata($conn,$_SESSION['SESS_UID']);
$uid=$_SESSION['SESS_UID'];
$lengkap="";
// print_r($data_biodata);
$icon_tick = '../images/icon_green.png';
$icon_no = '../images/icon_red.png';
$icon_info = '../images/Button-Info-icon.png';

$rsGambar = $conn->query("SELECT * FROM $schema2.`calon_gambar` WHERE `id_pemohon`=".tosql($_SESSION['SESS_UID']));
if(!$rsGambar->EOF){
       	$sijil_pic1 = "/var/www/upload/".$_SESSION['SESS_UID']."/".$rsGambar->fields['gambar'];
} else {
       	$sijil_pic1 = '../images/person.jpg';
}

if (file_exists($sijil_pic1)){
	$b64image = base64_encode(file_get_contents($sijil_pic1));
	$gambar = "data:image/png;base64,$b64image";
}

?>
		<header class="panel-heading"  style="background-color:rgb(38, 167, 228)">
			<h6 class="panel-title"><font color="#000000" size="3"><b><?php print strtoupper($menu);?></b></font></h6>
			<input type="hidden" name="id_pemohon" id="id_pemohon" value="<?php print $_SESSION['SESS_UID'];?>" readonly="readonly"/>

		</header>
		<div class="panel-body">
			<div class="box-body">

				<div class="col-md-12">

					<div class="form-group">
						<div class="col-sm-9">
							<div class="row">
								<label for="nama" class="col-sm-4 control-label"><b>No. Kad Pengenalan<div style="float:right">:</div></b></label>
								<div class="col-sm-8"><b><?php print strtoupper($_SESSION['SESS_UIC']);?></b></div>
							</div>
							<div class="row">
								<label for="nama" class="col-sm-4 control-label"><b>Nama Penuh<div style="float:right">:</div></b></label>
								<div class="col-sm-8"><b><?php print strtoupper($_SESSION['SESS_UNAME']);?></b></div>
							</div>
							<div class="row">
								<label for="nama" class="col-sm-4 control-label"><b>Alamat Surat Menyurat<div style="float:right">:</div></b></label>
								<div class="col-sm-8">
									<?php 
									print strtoupper($data_biodata['addr1']);
									if(!empty($data_biodata['addr2'])){ print "<br>".strtoupper($data_biodata['addr2']); }
									if(!empty($data_biodata['addr3'])){ print "<br>".strtoupper($data_biodata['addr3']); }
									?>
								</div>
							</div>
							<div class="row">
								<label for="nama" class="col-sm-4 control-label"><b><div style="float:right"></div></b></label>
								<div class="col-sm-8"><?php print strtoupper($data_biodata['poskod']);?>, <?php print strtoupper($data_biodata['bandar']); ?>, 
								<?php print strtoupper(dlookup("$schema2.ref_negeri", "diskripsi", "kod=".tosql($data_biodata['negeri']))); ?></div>
							</div>
							
							<div class="row">
								<label for="nama" class="col-sm-4 control-label"><b>E-mel<div style="float:right">:</div></b></label>
								<div class="col-sm-8"><?php print $_SESSION['SESS_EMEL'];?></div>
							</div>
							<div class="row">
								<label for="nama" class="col-sm-4 control-label"><b>No. Telefon<div style="float:right">:</div></b></label>
								<div class="col-sm-4"><?php print $data_biodata['no_depan']."-".$data_biodata['no_tel'];?></div>
							</div>
						</div>
						<div class="col-md-3">
	                        <div class="col-sm-12" align="center">
	                            <img src="<?=$gambar;?>" width="130" height="150">
	                        </div>
	                    </div>
					</div>

					<div class="form-group">
						<div class="row">
							<!--<label for="nama" class="col-sm-12 control-label"><b>NOTA : </b>
								<ul>
									<li>Sila pastikan No. Kad Pengenalan, Nama Penuh, Emel dan No. Telefon yang diisi adalah tepat.</li>
									<li>Sekiranya maklumat di atas tidak tepat, sila klik pada menu "Maklumat Pemohon" untuk mengemaskini maklumat tersebut sebelum menghantar borang.</li>
									<li>Sila semak status pendaftaran di menu "Semakan Permohonan" dan pastikan tarikh daftar adalah terkini.</li>
								</ul>
							</label>-->

							<div class="card">
									<label for="nama" class="col-sm-12 control-label" style="border: 1px solid rgb(38, 167, 228);"><b>NOTA : </b>
										<ul>
									<li>Sila pastikan No. Kad Pengenalan, Nama Penuh, Emel dan No. Telefon yang diisi adalah tepat.</li>
									<li>Sekiranya maklumat di atas tidak tepat, sila klik pada pautan Maklumat Pemohon untuk mengemaskini maklumat tersebut sebelum membuat Pengakuan dan Hantar.</li>
									<li>Sila semak status pendaftaran di menu "Dashboard - Status Permohonan Terkini" dan pastikan tarikh daftar adalah terkini.</li>
								</ul>
									</label>

							  </div>


							
						</div>
					</div>
					<hr>
					
					<div class="form-group">
						<div class="row">
							<div class="col-sm-12">
								<b>SEMAKAN MAKLUMAT PERMOHONAN</b>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="row">
							<div class="col-sm-12">
								<table width="100%" cellspacing="1" cellpadding="10" border="1" align="center" class="table">
	                                <tbody>
	                                <tr>
	                                    <td width="30%" bgcolor="#999999"><strong>KATEGORI</strong></td>
	                                    <td width="55%" bgcolor="#999999"><strong>KENYATAAN STATUS</strong></td>
	                                    <td width="20%" bgcolor="#999999"><strong>STATUS</strong></td>
	                                </tr>
					<?php
						$sql = "SELECT COUNT(*) as total FROM $schema2.`menu_pemohon` WHERE is_deleted=0 AND `status`=0"; 
						$sql .=" AND keterangan LIKE '%MAKLUMAT PEMOHON%'" ;
						$rsMenu = $conn->query($sql);
					?>
					<?php if($rsMenu->fields['total'] > 0){ ?>

	                                <tr>
					    <?php 
						//$conn->debug=true;
						$rsCalon = $conn->query("SELECT * FROM $schema2.calon WHERE `id_pemohon`=".tosql($_SESSION['SESS_UID']));  
						//$conn->debug=false;
						if(!$rsCalon->EOF){ 
							if(!empty($rsCalon->fields['dob']) && !empty($rsCalon->fields['addr1']) && !empty($rsCalon->fields['negeri']) && !empty($rsCalon->fields['bandar']) && !empty($rsCalon->fields['taraf_kawin']) && !empty($rsCalon->fields['ketinggian']) && !empty($rsCalon->fields['berat']) && !empty($rsCalon->fields['negeri_lahir_pemohon']) && !empty($rsCalon->fields['negeri_lahir_ibu']) && !empty($rsCalon->fields['negeri_lahir_bapa'])){
								$khidmat = $icon_tick; 
	                            $khidmat_info = 'Lengkap';
								
								//if($rsCalon->fields['bmi'] >= '25' ||  $rsCalon->fields['bmi'] <= '18.5'){
								if($rsCalon->fields['ketinggian'] < 100 || $rsCalon->fields['ketinggian'] > 190 ){
									$khidmat = $icon_no; 
	                                $khidmat_info = '<font style="color:red">Ketinggian atau berat tidak sah. Sila semak</font>';
	                                $btn_ok='';										
								}		
								
								if($rsCalon->fields['berat'] > 180 || $rsCalon->fields['berat'] < 29 ){
									$khidmat = $icon_no; 
	                                $khidmat_info = '<font style="color:red">Ketinggian atau erat tidak sah. Sila semak</font>';
	                                $btn_ok='';										
								}
							} else { 
	                                			$khidmat = $icon_no; 
	                                			$khidmat_info = '<font style="color:red">Tidak Lengkap. Sila semak semula maklumat diisi</font>';
	                                			$btn_ok='';
	                                		}

	                                		 
	                                	} else { 
	                                		$khidmat = $icon_no; 
	                                		$khidmat_info = '<font style="color:red">Tidak Lengkap. Sila semak semula maklumat diisi</font>';
	                                		$btn_ok='';
	                                	}

					    ?>
	                                    <td bgcolor="#ffffff">Maklumat Pemohon</td>
	                                    <td bgcolor="#ffffff"><span class="style1"><?=$khidmat_info;?></span></td>
	                                    <td bgcolor="#ffffff" align="center">
	                                    	<span class="style1"><img src="<?=$khidmat;?>" width="30" height="25"></span>
	                                	</td>
	                                </tr>
					<?php } ?>
	                                <?php 
	                                $bantuan = $icon_info; $bantuan_info = 'Tiada Maklumat, Lengkapkan sekiranya perlu';
	                                if(!empty($data_biodata['oku']) || !empty($data_biodata['bantuan'])){
	                            		$bantuan = $icon_tick; 
	                            		$bantuan_info = 'Lengkap'; 
	                                }
	                            	?>
	                                <tr>
	                                    <td bgcolor="#ffffff">Penerima bantuan / Kurang upaya</td>
	                                    <td bgcolor="#ffffff"><span class="style1"><?=$bantuan_info;?></span></td>
	                                    <td bgcolor="#ffffff" align="center">
	                                    	<span class="style1"><img src="<?=$bantuan;?>" width="30" height="25"></span>
	                                    </td>
	                                </tr>
	                                <?php 
	                                $khidmat = $icon_info; $khidmat_info = 'Tiada Maklumat, Lengkapkan sekiranya perlu';
	                                if($data_biodata['masih_khidmat']=='Y'){
						$rsKh = $conn->query("SELECT * FROM $schema2.`calon_masih_khidmat` WHERE `id_pemohon`=".tosql($_SESSION['SESS_UID']));
						if(!$rsKh->EOF){ 
	                                		$khidmat = $icon_tick; 
	                                		$khidmat_info = 'Lengkap'; 
							
							if(!empty($rsKh->fields['jenis_xm'])){
								if(empty($rsKh->fields['d_lulus_kpsl'])){
	                                				$khidmat = $icon_no; 
	                                				$khidmat_info = '<font style="color:red">Tidak Lengkap. Sila pastikan tarikh peperiksaan telah diisi</font>';
	                                				$btn_ok='';
								} else if($rsKh->fields['d_lulus_kpsl']>=date("Y-m-d")){
	                                				$khidmat = $icon_no; 
	                                				$khidmat_info = '<font style="color:red">Sila pastikan tarikh peperiksaan lebih kecil daripada tarikh semasa</font>';
	                                				$btn_ok='';
								}
							}							

	                                	} else { 
	                                		$khidmat = $icon_no; 
	                                		$khidmat_info = '<font style="color:red">Tidak Lengkap. Sila semak semula maklumat diisi</font>';
	                                		$btn_ok='';
	                                	}
						//$conn->debug=false;	
	                                }
	                            	?>
					<?php
						$sql = "SELECT COUNT(*) as total FROM $schema2.`menu_pemohon` WHERE is_deleted=0 AND `status`=0"; 
						$sql .=" AND keterangan LIKE '%PEGAWAI SEDANG BERKHIDMAT%'" ;
						$rsMenu = $conn->query($sql);
					?>
					<?php if($rsMenu->fields['total'] > 0){ ?>

	                                <tr>
	                                    <td bgcolor="#ffffff">Pegawai Sedang Berkhidmat</td>
	                                    <td bgcolor="#ffffff"><span class="style2"><?=$khidmat_info;?></span></td>
	                                    <td bgcolor="#ffffff" align="center">
	                                    	<span class="style1"><img src="<?=$khidmat;?>" width="30" height="25"></span>
	                                    </td>
	                                </tr>
					<?php } ?>

	                                <tr>
	                                    <td bgcolor="#CCCCCC">Maklumat Akademik</td>
	                                    <td bgcolor="#CCCCCC" colspan="2"></td>
	                                </tr>

									<?php 
									$data_pmr = get_pmr($conn,$_SESSION['SESS_UID']);
									// print_r($data_pmr);
									$SPR_lengkap=''; $SPR_lengkap_ikon='';
									if(empty($data_pmr['srp_tahun'])){ 
										$SPR_lengkap='Tiada Maklumat, Lengkapkan sekiranya perlu'; 
										$SPR_lengkap_ikon=$icon_info;
									} else {
										//if(empty($data_pmr['srp_jenis_sijil'])){ 
										//	$SPR_lengkap='<font style="color:red">Tidak Lengkap. Sila semak semula maklumat diisi.</font>'; 
										//	$SPR_lengkap_ikon=$icon_no; 
										//	$btn_ok='';
										//} else {
											$SPR_lengkap='Lengkap';
											$SPR_lengkap_ikon=$icon_tick;
										//}
									}
									// $conn->debug=true;
									if($SPR_lengkap=='Lengkap'){ 
										$rsSijil = $conn->query("SELECT * FROM $schema2.`calon_sijil` WHERE `jenis_sijil`='PMR' AND `id_pemohon`=".tosql($uid));
										if(empty($rsSijil->fields['sijil_nama'])){
											$SPR_lengkap='<font style="color:red">Tidak Lengkap. Sila semak semula maklumat diisi.<br>Sila muatnaik sijil berkaitan.</font>'; 
											$SPR_lengkap_ikon=$icon_no;
											$btn_ok='';
										}
									}
									?>
					<?php
						$sql = "SELECT COUNT(*) as total FROM $schema2.`menu_pemohon` WHERE is_deleted=0 AND `status`=0"; 
						$sql .=" AND keterangan LIKE '%PT3/PMR%'" ;
						$rsMenu = $conn->query($sql);
					?>
					<?php if($rsMenu->fields['total'] > 0){ ?>

	                                <tr>
	                                    <td bgcolor="#ffffff">SRP/ PT3/ PMR</td>
	                                    <td bgcolor="#ffffff"><span class="style2"><?=$SPR_lengkap;?></span></td>
	                                    <td bgcolor="#ffffff" align="center">
	                                    	<span class="style1"><img src="<?=$SPR_lengkap_ikon;?>" width="30" height="25"></span>
	                                    </td>
	                                </tr>
					<?php } ?>

									<?php
									$data_spm = get_exam($conn,$_SESSION['SESS_UID']);
									//print_r($data_spm); $conn->debug=true;
									$SPR_lengkap=''; $SPR_lengkap_ikon='';
									if(empty($data_spm['spm_tahun_1'])){ 
										$SPM_lengkap='Tiada Maklumat, Lengkapkan sekiranya perlu'; 
										$SPM_lengkap_ikon=$icon_info;
									} else {
										// KENA CHECK BY TAHUN
										if($data_spm['spm_tahun_1'] < '2000'){ 
											if(empty($data_spm['spm_jenis_sijil_1']) || empty($data_spm['spm_tahun_1']) || empty($data_spm['spm_lisan_1'])){ 
												$SPM_lengkap='<font style="color:red">Tidak Lengkap. Sila semak semula maklumat diisi.</font>'; 
												$SPM_lengkap_ikon=$icon_no; 
												$btn_ok='';
											} else {
												$SPM_lengkap='Lengkap';
												$SPM_lengkap_ikon=$icon_tick;
											}
										} else {
											if(empty($data_spm['spm_jenis_sijil_1']) || empty($data_spm['spm_tahun_1'])){ 
												$SPM_lengkap='<font style="color:red">Tidak Lengkap. Sila semak semula maklumat diisi.</font>'; 
												$SPM_lengkap_ikon=$icon_no; 
												$btn_ok='';
											} else {
												$SPM_lengkap='Lengkap';
												$SPM_lengkap_ikon=$icon_tick;
											}
										}
									}
									if($SPM_lengkap=='Lengkap'){ 
										if(!empty($data_spm['spm_jenis_sijil_1']) && $data_spm['spm_jenis_sijil_1']==6){
										$rsSijil = $conn->query("SELECT * FROM $schema2.`calon_sijil` WHERE `jenis_sijil`='SVM1' AND `id_pemohon`=".tosql($uid));
										if(empty($rsSijil->fields['sijil_nama'])){
											$SPM_lengkap='<font style="color:red">Tidak Lengkap. Sila semak semula maklumat diisi.<br>Sila muatnaik sijil berkaitan.</font>'; 
											$SPM_lengkap_ikon=$icon_no; 
											$btn_ok='';
										}

										} else if(!empty($data_spm['spm_jenis_sijil_1']) && $data_spm['spm_jenis_sijil_1']<>6){
										$rsSijil = $conn->query("SELECT * FROM $schema2.`calon_sijil` WHERE `jenis_sijil`='SPM1' AND `id_pemohon`=".tosql($uid));
										if(empty($rsSijil->fields['sijil_nama'])){
											$SPM_lengkap='<font style="color:red">Tidak Lengkap. Sila semak semula maklumat diisi.<br>Sila muatnaik sijil berkaitan.</font>'; 
											$SPM_lengkap_ikon=$icon_no; 
											$btn_ok='';
										}
										}

										if(!empty($data_spm['spm_jenis_sijil_2']) && $data_spm['spm_jenis_sijil_2']==6){
										$rsSijil = $conn->query("SELECT * FROM $schema2.`calon_sijil` WHERE `jenis_sijil`='SVM2' AND `id_pemohon`=".tosql($uid));
										if(empty($rsSijil->fields['sijil_nama'])){
											$SPM_lengkap='<font style="color:red">Tidak Lengkap. Sila semak semula maklumat diisi.<br>Sila muatnaik sijil berkaitan.</font>'; 
											$SPM_lengkap_ikon=$icon_no; 
											$btn_ok='';
										}

										} else if(!empty($data_spm['spm_jenis_sijil_2']) && $data_spm['spm_jenis_sijil_2']<>6){
										$rsSijil = $conn->query("SELECT * FROM $schema2.`calon_sijil` WHERE `jenis_sijil`='SPM2' AND `id_pemohon`=".tosql($uid));
										if(empty($rsSijil->fields['sijil_nama'])){
											$SPM_lengkap='<font style="color:red">Tidak Lengkap. Sila semak semula maklumat diisi.<br>Sila muatnaik sijil berkaitan.</font>'; 
											$SPM_lengkap_ikon=$icon_no; 
											$btn_ok='';
										}
										}
									} $conn->debug=false;
									?>
					<?php
						$sql = "SELECT COUNT(*) as total FROM $schema2.`menu_pemohon` WHERE is_deleted=0 AND `status`=0"; 
						$sql .=" AND keterangan LIKE '%SPM/SPM(V)/SVM%'" ;
						$rsMenu = $conn->query($sql);
					?>
					<?php if($rsMenu->fields['total'] > 0){ ?>

	                                <tr>
	                                    <td bgcolor="#ffffff">SPM/ SPM(V)/ SVM</td>
	                                    <td bgcolor="#ffffff"><span class="style2"><?=$SPM_lengkap;?></span></td>
	                                    <td bgcolor="#ffffff" align="center">
	                                    	<span class="style1"><img src="<?=$SPM_lengkap_ikon;?>" width="25" height="25"></span>
	                                    </td>
	                                </tr>
					<?php } ?>

	                                <?php
	                                $SPM_tambahan='Tiada Maklumat, Lengkapkan sekiranya perlu'; 
									$SPM_tambahan_ikon=$icon_info;
	                                $rsData = $conn->query("SELECT * FROM $schema2.`calon_spm` WHERE `jenis_xm`='T' AND `id_pemohon`=".tosql($_SESSION['SESS_UID']));
	                                if(!$rsData->EOF){
										$SPM_tambahan='Lengkap';
										$SPM_tambahan_ikon=$icon_tick;
	                                }
									if($SPM_tambahan=='Lengkap'){ 
										$rsSijil = $conn->query("SELECT * FROM $schema2.`calon_sijil` WHERE `jenis_sijil`='ULANG' AND `id_pemohon`=".tosql($uid));
										if(empty($rsSijil->fields['sijil_nama'])){
											$SPM_tambahan='<font style="color:red">Tidak Lengkap. Sila semak semula maklumat diisi.<br>Sila muatnaik sijil berkaitan.</font>'; 
											$SPM_tambahan_ikon=$icon_no; 
											$btn_ok='';
										}
									}
	                                ?>
					<?php
						$sql = "SELECT COUNT(*) as total FROM $schema2.`menu_pemohon` WHERE is_deleted=0 AND `status`=0"; 
						$sql .=" AND keterangan LIKE '%PEPERIKSAAN SPM ULANGAN%'" ;
						$rsMenu = $conn->query($sql);
					?>
					<?php if($rsMenu->fields['total'] > 0){ ?>

	                                <tr>
	                                    <td bgcolor="#ffffff">Peperiksaan SPM Ulangan</td>
	                                    <td bgcolor="#ffffff"><span class="style1"><?=$SPM_tambahan;?></span></td>
	                                    <td bgcolor="#ffffff" align="center">
	                                    	<span class="style1"><img src="<?=$SPM_tambahan_ikon;?>" width="30" height="25"></span>
	                                    </td>
	                                </tr>
					<?php } ?>
	                                <!-- <tr>
	                                    <td bgcolor="#ffffff">STPM/STP/HSC</td>
	                                    <td bgcolor="#ffffff"><span class="style1">Tiada Maklumat, Lengkapkan sekiranya perlu</span></td>
	                                    <td bgcolor="#ffffff" align="center"><span class="style1">
	                                    	<img src="../images/ico_tick.png" width="25" height="25">
	                                    </span></td>
	                                </tr>
	                                <tr>
	                                    <td bgcolor="#ffffff">STAM</td>
	                                    <td bgcolor="#ffffff"><span class="style1">Tiada Maklumat, Lengkapkan sekiranya perlu</span></td>
	                                    <td bgcolor="#ffffff" align="center"><span class="style1">
	                                    	<img src="../images/ico_tick.png" width="25" height="25">
	                                    </span></td>
	                                </tr> -->

									<?php
									// $data_spm = get_exam($conn,$_SESSION['SESS_UID']);
									// print_r($data_spm);
									$SPR_lengkap=''; $SPR_lengkap_ikon='';
									if(empty($data_spm['stp_tahun_1'])){ 
										$SPM_lengkap='Tiada Maklumat, Lengkapkan sekiranya perlu'; 
										$SPM_lengkap_ikon=$icon_info;
									} else {
										// KENA CHECK BY TAHUN
										if(empty($data_spm['stp_jenis_1']) || empty($data_spm['stp_tahun_1'])){ 
											$SPM_lengkap='<font style="color:red">Tidak Lengkap. Sila semak semula maklumat diisi.</font>'; 
											$SPM_lengkap_ikon=$icon_no; 
											$btn_ok='';
										} else {
											$SPM_lengkap='Lengkap';
											$SPM_lengkap_ikon=$icon_tick;
										}
									}
									if($SPM_lengkap=='Lengkap'){ 
										$rsSijil = $conn->query("SELECT * FROM $schema2.`calon_sijil` WHERE `jenis_sijil`='STPM1' AND `id_pemohon`=".tosql($uid));
										if(empty($rsSijil->fields['sijil_nama'])){
											$SPM_lengkap='<font style="color:red">Tidak Lengkap. Sila semak semula maklumat diisi.<br>Sila muatnaik sijil berkaitan.</font>'; 
											$SPM_lengkap_ikon=$icon_no; 
											$btn_ok='';
										}
										if($SPM_lengkap=='Lengkap' && !empty($data_spm['stp_tahun_2'])){ 
											// KENA CHECK BY TAHUN
											if(empty($data_spm['stp_jenis_2']) || empty($data_spm['stp_tahun_2'])){ 
												$SPM_lengkap='<font style="color:red">Tidak Lengkap. Sila semak semula maklumat diisi bagi tab ke 2.</font>'; 
												$SPM_lengkap_ikon=$icon_no; 
												$btn_ok='';
											} else {
												$SPM_lengkap='Lengkap';
												$SPM_lengkap_ikon=$icon_tick;
											}
											if($SPM_lengkap=='Lengkap'){ 
												$rsSijil = $conn->query("SELECT * FROM $schema2.`calon_sijil` WHERE `jenis_sijil`='STPM2' AND `id_pemohon`=".tosql($uid));
												if(empty($rsSijil->fields['sijil_nama'])){
													$SPM_lengkap='<font style="color:red">Tidak Lengkap. Sila semak semula maklumat diisi bagi tab ke 2.<br>Sila muatnaik sijil berkaitan.</font>'; 
													$SPM_lengkap_ikon=$icon_no; 
													$btn_ok='';
												}
											}
										}
									}
									?>
	                                <?php
						$sql = "SELECT COUNT(*) as total FROM $schema2.`menu_pemohon` WHERE is_deleted=0 AND `status`=0"; 
						$sql .=" AND keterangan LIKE '%STPM%'" ;
						$rsMenu = $conn->query($sql);
					?>
					<?php if($rsMenu->fields['total'] > 0){ ?>

					<tr>
	                                    <td bgcolor="#ffffff">STPM</td>
	                                    <td bgcolor="#ffffff"><span class="style2"><?=$SPM_lengkap;?></span></td>
	                                    <td bgcolor="#ffffff" align="center">
	                                    	<span class="style1"><img src="<?=$SPM_lengkap_ikon;?>" width="25" height="25"></span>
	                                    </td>
	                                </tr>

					<?php } ?>

									<?php
									// $data_spm = get_exam($conn,$_SESSION['SESS_UID']);
									// print_r($data_spm);
									$SPR_lengkap=''; $SPR_lengkap_ikon='';
									if(empty($data_spm['stam_tahun_1'])){ 
										$SPM_lengkap='Tiada Maklumat, Lengkapkan sekiranya perlu'; 
										$SPM_lengkap_ikon=$icon_info;
									} else {
										// KENA CHECK BY TAHUN
										if(empty($data_spm['stam_jenis_1']) || empty($data_spm['stam_tahun_1'])){ 
											$SPM_lengkap='<font style="color:red">Tidak Lengkap. Sila semak semula maklumat diisi.</font>'; 
											$SPM_lengkap_ikon=$icon_no; 
											$btn_ok='';
										} else {
											$SPM_lengkap='Lengkap';
											$SPM_lengkap_ikon=$icon_tick;
											
											$rsResult = $conn->query("SELECT * FROM $schema2.`calon_stp_stam` WHERE `jenis_xm`='A' AND `id_pemohon`=".tosql($_SESSION['SESS_UID']). " AND tahun=".tosql($data_spm['stam_tahun_1'])." ORDER BY stp_id");
											if($rsResult->EOF){
												$SPM_lengkap='<font style="color:red">Tidak Lengkap. Sila semak semula maklumat diisi.</font>'; 
												$SPM_lengkap_ikon=$icon_no; 
												$btn_ok='';
											}
										}
									}
									if($SPM_lengkap=='Lengkap'){ 
										$rsSijil = $conn->query("SELECT * FROM $schema2.`calon_sijil` WHERE `jenis_sijil`='STAM1' AND `id_pemohon`=".tosql($uid));
										if(empty($rsSijil->fields['sijil_nama'])){
											$SPM_lengkap='<font style="color:red">Tidak Lengkap. Sila semak semula maklumat diisi.<br>Sila muatnaik sijil berkaitan.</font>'; 
											$SPM_lengkap_ikon=$icon_no; 
											$btn_ok='';
										}
										if($SPM_lengkap=='Lengkap' && !empty($data_spm['stam_tahun_2'])){ 
											// KENA CHECK BY TAHUN
											if(empty($data_spm['stam_jenis_2']) || empty($data_spm['stam_tahun_2'])){ 
												$SPM_lengkap='<font style="color:red">Tidak Lengkap. Sila semak semula maklumat diisi bagi tab ke 2.</font>'; 
												$SPM_lengkap_ikon=$icon_no; 
												$btn_ok='';
											} else {
												$SPM_lengkap='Lengkap';
												$SPM_lengkap_ikon=$icon_tick;

											
												$rsResult = $conn->query("SELECT * FROM $schema2.`calon_stp_stam` WHERE `jenis_xm`='AT' AND `id_pemohon`=".tosql($uid). " AND tahun=".tosql($data_spm['stam_tahun_2'])." ORDER BY stp_id");
												if($rsResult->EOF){
													$SPM_lengkap='<font style="color:red">Tidak Lengkap. Sila semak semula maklumat diisi bagi tab ke 2.</font>'; 
													$SPM_lengkap_ikon=$icon_no; 
													$btn_ok='';
												}

											}
											if($SPM_lengkap=='Lengkap'){ 
												$rsSijil = $conn->query("SELECT * FROM $schema2.`calon_sijil` WHERE `jenis_sijil`='STAM2' AND `id_pemohon`=".tosql($uid));
												if(empty($rsSijil->fields['sijil_nama'])){
													$SPM_lengkap='<font style="color:red">Tidak Lengkap. Sila semak semula maklumat diisi bagi tab ke 2.<br>Sila muatnaik sijil berkaitan.</font>'; 
													$SPM_lengkap_ikon=$icon_no; 
													$btn_ok='';
												}
											}
										}
									}
									?>
					<?php
						$sql = "SELECT COUNT(*) as total FROM $schema2.`menu_pemohon` WHERE is_deleted=0 AND `status`=0"; 
						$sql .=" AND keterangan LIKE '%STAM%'" ;
						$rsMenu = $conn->query($sql);
					?>
					<?php if($rsMenu->fields['total'] > 0){ ?>

	                                <tr>
	                                    <td bgcolor="#ffffff">STAM</td>
	                                    <td bgcolor="#ffffff"><span class="style2"><?=$SPM_lengkap;?></span></td>
	                                    <td bgcolor="#ffffff" align="center">
	                                    	<span class="style1"><img src="<?=$SPM_lengkap_ikon;?>" width="25" height="25"></span>
	                                    </td>
	                                </tr>
					<?php } ?>

									<?php
									// $conn->debug=true;
									$rsUniv = $conn->query("SELECT * FROM $schema2.`calon_ipt` WHERE `id_pemohon`=".tosql($_SESSION['SESS_UID']));
									$bilUniv1 = $rsUniv->recordcount();
									// print "BILK:".$bilUniv1;

									$SPM_lengkap=''; $SPM_lengkap_ikon='';
									if($rsUniv->EOF){
										$SPM_lengkap='Tiada Maklumat, Lengkapkan sekiranya perlu'; 
										$SPM_lengkap_ikon=$icon_info;
									} else {
									while(!$rsUniv->EOF){
										if($rsUniv->fields['bil_keputusan']==1){ 
											$rsSijil = $conn->query("SELECT * FROM $schema2.`calon_sijil` WHERE `jenis_sijil`='UNIV1A' AND `id_pemohon`=".tosql($uid));
											if($rsSijil->EOF){
												$SPM_lengkap='<font style="color:red">Tidak Lengkap. Sila semak semula maklumat diisi.<br>Sila muatnaik sijil berkaitan bagi tab maklumat keputusan 1.</font>'; 
												$SPM_lengkap_ikon=$icon_no; 
												$btn_ok='';
											} else {
												$SPM_lengkap='Lengkap';
												$SPM_lengkap_ikon=$icon_tick;
											}
											// ENG
											if($SPM_lengkap=='Lengkap'){
												$rsSijil = $conn->query("SELECT * FROM $schema2.`calon_sijil` WHERE `jenis_sijil`='UNIV1B' AND `id_pemohon`=".tosql($uid));
												//if($rsSijil->EOF && $rsUniv->fields['muet']==1){
												if($rsSijil->EOF){
													if($rsUniv->fields['muet'] != '' && $rsUniv->fields['muet_tahun'] != '' && $rsUniv->fields['muet_gred'] != ''){
														$SPM_lengkap='<font style="color:red">Tidak Lengkap. Sila semak semula maklumat diisi.<br>Sila muatnaik sijil berkaitan bagi tab maklumat keputusan 1.</font>'; 
														$SPM_lengkap_ikon=$icon_no; 
														$btn_ok='';
													}
												} else {
													if($rsUniv->fields['muet'] == '' && $rsUniv->fields['muet_tahun'] == '' && $rsUniv->fields['muet_gred'] == ''){
														$SPM_lengkap='Lengkap';
														$SPM_lengkap_ikon=$icon_tick;
													} else if($rsUniv->fields['muet'] != '' && $rsUniv->fields['muet_tahun'] != '' && $rsUniv->fields['muet_gred'] != ''){
														$SPM_lengkap='Lengkap';
														$SPM_lengkap_ikon=$icon_tick;
													} else {
														$SPM_lengkap='<font style="color:red">Tidak Lengkap. Sila semak semula maklumat diisi.</font>'; 
														$SPM_lengkap_ikon=$icon_no; 
														$btn_ok='';

													}
												}
											}
											//PDF
											// print $SPM_lengkap;
											if($SPM_lengkap=='Lengkap'){ 
												$rsSijil = $conn->query("SELECT * FROM $schema2.`calon_sijil` WHERE `jenis_sijil`='UNIV1C' AND `id_pemohon`=".tosql($uid));
												if($rsSijil->EOF){
													$SPM_lengkap='<font style="color:red">Tidak Lengkap. Sila semak semula maklumat diisi.<br>Sila muatnaik sijil berkaitan bagi tab maklumat keputusan 1.</font>'; 
													$SPM_lengkap_ikon=$icon_no; 
													$btn_ok='';
												} else {
													$SPM_lengkap='Lengkap';
													$SPM_lengkap_ikon=$icon_tick;
												}
											}
										} else if($rsUniv->fields['bil_keputusan']==2 && $SPM_lengkap=='Lengkap'){ 
											$rsSijil = $conn->query("SELECT * FROM $schema2.`calon_sijil` WHERE `jenis_sijil`='UNIV2A' AND `id_pemohon`=".tosql($uid));
											if($rsSijil->EOF){
												$SPM_lengkap='<font style="color:red">Tidak Lengkap. Sila semak semula maklumat diisi.<br>Sila muatnaik sijil berkaitan bagi tab maklumat keputusan 2.</font>'; 
												$SPM_lengkap_ikon=$icon_no; 
												$btn_ok='';
											} else {
												$SPM_lengkap='Lengkap';
												$SPM_lengkap_ikon=$icon_tick;
											}
											if($SPM_lengkap=='Lengkap'){
												$rsSijil = $conn->query("SELECT * FROM $schema2.`calon_sijil` WHERE `jenis_sijil`='UNIV2B' AND `id_pemohon`=".tosql($uid));
												if($rsSijil->EOF){
													if($rsUniv->fields['muet'] != '' && $rsUniv->fields['muet_tahun'] != '' && $rsUniv->fields['muet_gred'] != ''){
														$SPM_lengkap='<font style="color:red">Tidak Lengkap. Sila semak semula maklumat diisi.<br>Sila muatnaik sijil berkaitan bagi tab maklumat keputusan 2.</font>'; 
														$SPM_lengkap_ikon=$icon_no; 
														$btn_ok='';
													}
												} else {
													if($rsUniv->fields['muet'] == '' && $rsUniv->fields['muet_tahun'] == '' && $rsUniv->fields['muet_gred'] == ''){
														$SPM_lengkap='Lengkap';
														$SPM_lengkap_ikon=$icon_tick;
													} else if($rsUniv->fields['muet'] != '' && $rsUniv->fields['muet_tahun'] != '' && $rsUniv->fields['muet_gred'] != ''){
														$SPM_lengkap='Lengkap';
														$SPM_lengkap_ikon=$icon_tick;
													} else {
														$SPM_lengkap='<font style="color:red">Tidak Lengkap. Sila semak semula maklumat diisi.</font>'; 
														$SPM_lengkap_ikon=$icon_no; 
														$btn_ok='';

													}
												}
											}
											if($SPM_lengkap=='Lengkap'){
												$rsSijil = $conn->query("SELECT * FROM $schema2.`calon_sijil` WHERE `jenis_sijil`='UNIV2C' AND `id_pemohon`=".tosql($uid));
												if($rsSijil->EOF){
													$SPM_lengkap='<font style="color:red">Tidak Lengkap. Sila semak semula maklumat diisi.<br>Sila muatnaik sijil berkaitan bagi tab maklumat keputusan 2.</font>'; 
													$SPM_lengkap_ikon=$icon_no; 
													$btn_ok='';
												} else {
													$SPM_lengkap='Lengkap';
													$SPM_lengkap_ikon=$icon_tick;
												}
											}
										} else if($rsUniv->fields['bil_keputusan']==3 && $SPM_lengkap=='Lengkap'){ 
											$rsSijil = $conn->query("SELECT * FROM $schema2.`calon_sijil` WHERE `jenis_sijil`='UNIV3A' AND `id_pemohon`=".tosql($uid));
											if($rsSijil->EOF){
												$SPM_lengkap='<font style="color:red">Tidak Lengkap. Sila semak semula maklumat diisi.<br>Sila muatnaik sijil berkaitan bagi tab maklumat keputusan 3.</font>'; 
												$SPM_lengkap_ikon=$icon_no; 
												$btn_ok='';
											} else {
												$SPM_lengkap='Lengkap';
												$SPM_lengkap_ikon=$icon_tick;
											}
											if($SPM_lengkap=='Lengkap'){
												$rsSijil = $conn->query("SELECT * FROM $schema2.`calon_sijil` WHERE `jenis_sijil`='UNIV3B' AND `id_pemohon`=".tosql($uid));
												if($rsSijil->EOF){
													if($rsUniv->fields['muet'] != '' && $rsUniv->fields['muet_tahun'] != '' && $rsUniv->fields['muet_gred'] != ''){
														$SPM_lengkap='<font style="color:red">Tidak Lengkap. Sila semak semula maklumat diisi.<br>Sila muatnaik sijil berkaitan bagi tab maklumat keputusan 3.</font>'; 
														$SPM_lengkap_ikon=$icon_no; 
														$btn_ok='';
													}
												} else {
													if($rsUniv->fields['muet'] == '' && $rsUniv->fields['muet_tahun'] == '' && $rsUniv->fields['muet_gred'] == ''){
														$SPM_lengkap='Lengkap';
														$SPM_lengkap_ikon=$icon_tick;
													} else if($rsUniv->fields['muet'] != '' && $rsUniv->fields['muet_tahun'] != '' && $rsUniv->fields['muet_gred'] != ''){
														$SPM_lengkap='Lengkap';
														$SPM_lengkap_ikon=$icon_tick;
													} else {
														$SPM_lengkap='<font style="color:red">Tidak Lengkap. Sila semak semula maklumat diisi.</font>'; 
														$SPM_lengkap_ikon=$icon_no; 
														$btn_ok='';

													}
												}
											}

											if($SPM_lengkap=='Lengkap'){
												$rsSijil = $conn->query("SELECT * FROM $schema2.`calon_sijil` WHERE `jenis_sijil`='UNIV3C' AND `id_pemohon`=".tosql($uid));
												if($rsSijil->EOF){
													$SPM_lengkap='<font style="color:red">Tidak Lengkap. Sila semak semula maklumat diisi.<br>Sila muatnaik sijil berkaitan bagi tab maklumat keputusan 3.</font>'; 
													$SPM_lengkap_ikon=$icon_no; 
													$btn_ok='';
												} else {
													$SPM_lengkap='Lengkap';
													$SPM_lengkap_ikon=$icon_tick;
												}
											}
										}
										$rsUniv->movenext();
									}

									
									}


									?>
					<?php
						$sql = "SELECT COUNT(*) as total FROM $schema2.`menu_pemohon` WHERE is_deleted=0 AND `status`=0"; 
						$sql .=" AND keterangan LIKE '%PENGAJIAN TINGGI%'" ;
						$rsMenu = $conn->query($sql);
					?>
					<?php if($rsMenu->fields['total'] > 0){ ?>

	                                <tr>
	                                    <td bgcolor="#ffffff">Pengajian Tinggi</td>
	                                    <td bgcolor="#ffffff"><span class="style1"><?=$SPM_lengkap;?></span></td>
	                                    <td bgcolor="#ffffff" align="center">
	                                    	<span class="style1"><img src="<?=$SPM_lengkap_ikon;?>" width="30" height="25"></span>
	                                    </td>
	                                </tr>
					<?php } ?>

									<?php
									$data = get_profesional($conn,$_SESSION['SESS_UID']);

									$SPM_lengkap=''; $SPM_lengkap_ikon='';
									if(empty($data['professional_1']) && empty($data['professional_d_1'])){ 
										$SPM_lengkap='Tiada Maklumat, Lengkapkan sekiranya perlu'; 
										$SPM_lengkap_ikon=$icon_info;
									} else {
										$SPM_lengkap='Lengkap';
										$SPM_lengkap_ikon=$icon_tick;
									}
									if($SPM_lengkap=='Lengkap'){ 
										$rsSijil = $conn->query("SELECT * FROM $schema2.`calon_sijil` WHERE `jenis_sijil`='PRO' AND `id_pemohon`=".tosql($uid));
										if(empty($rsSijil->fields['sijil_nama'])){
											$SPM_lengkap='<font style="color:red">Tidak Lengkap. Sila semak semula maklumat diisi.<br>Sila muatnaik sijil berkaitan.</font>'; 
											$SPM_lengkap_ikon=$icon_no; 
											$btn_ok='';
										}
									}
									?>
					<?php
						$sql = "SELECT COUNT(*) as total FROM $schema2.`menu_pemohon` WHERE is_deleted=0 AND `status`=0"; 
						$sql .=" AND keterangan LIKE '%PROFESIONAL%'" ;
						$rsMenu = $conn->query($sql);
					?>
					<?php if($rsMenu->fields['total'] > 0){ ?>

	                                <tr>
	                                    <td bgcolor="#ffffff">Profesional</td>
	                                    <td bgcolor="#ffffff"><span class="style1"><?=$SPM_lengkap;?></span></td>
	                                    <td bgcolor="#ffffff" align="center">
	                                    	<span class="style1"><img src="<?=$SPM_lengkap_ikon;?>" width="30" height="25"></span>
	                                    </td>
	                                </tr>
					<?php } ?>

									<?php
									// $SPM_lengkap=''; $SPM_lengkap_ikon='';
									// if(empty($data_spm['spm_tahun_1'])){ 
									// 	$SPM_lengkap='Tiada Maklumat, Lengkapkan sekiranya perlu'; 
									// 	$SPM_lengkap_ikon='../images/icon_red.jpg';
									// } else {
									// 	if(empty($data_spm['spm_jenis_sijil_1']) || empty($data_spm['spm_pangkat_1']) || empty($data_spm['spm_lisan_1'])){ 
									// 		$SPM_lengkap='<font style="color:red">Maklumat perlu dilengkapkan.</font>'; 
									// 		$SPM_lengkap_ikon='../images/icon_red.jpg';
									// 	} else {
									// 		$SPM_lengkap='Lengkap';
									// 		$SPM_lengkap_ikon='../images/tick_green.webp';
									// 	}
									// }
									?>
	                                <tr>
	                                    <td bgcolor="#CCCCCC">Maklumat Bukan Akademik</td>
	                                    <td bgcolor="#CCCCCC" colspan="2"></td>
	                                </tr>
	                                <?php
	                                // $conn->debug=true;
									$rsData = $conn->query("SELECT * FROM $schema2.`calon_ko_sukan` WHERE `id_pemohon`=".tosql($_SESSION['SESS_UID']));
									$SPR_lengkap=''; $SPR_lengkap_ikon='';
									if($rsData->EOF){ 
										$SPM_lengkap='Tiada Maklumat, Lengkapkan sekiranya perlu'; 
										$SPM_lengkap_ikon=$icon_info;
									} else {
										$SPM_lengkap='Lengkap';
										$SPM_lengkap_ikon=$icon_tick;
									}
									?>
					<?php
						$sql = "SELECT COUNT(*) as total FROM $schema2.`menu_pemohon` WHERE is_deleted=0 AND `status`=0"; 
						$sql .=" AND keterangan LIKE '%SUKAN/PERSATUAN%'" ;
						$rsMenu = $conn->query($sql);
					?>
					<?php if($rsMenu->fields['total'] > 0){ ?>

	                                <tr>
	                                    <td bgcolor="#ffffff">Sukan</td>
	                                    <td bgcolor="#ffffff"><span class="style1"><?=$SPM_lengkap;?></span></td>
	                                    <td bgcolor="#ffffff" align="center">
	                                    	<span class="style1"><img src="<?=$SPM_lengkap_ikon;?>" width="30" height="25"></span>
	                                	</td>
	                                </tr>
	                                <?php
	                                // $conn->debug=true;
									$rsData = $conn->query("SELECT * FROM $schema2.`calon_ko_persatuan` WHERE `id_pemohon`=".tosql($_SESSION['SESS_UID']));
									$SPR_lengkap=''; $SPR_lengkap_ikon='';
									if($rsData->EOF){ 
										$SPM_lengkap='Tiada Maklumat, Lengkapkan sekiranya perlu'; 
										$SPM_lengkap_ikon=$icon_info;
									} else {
										$SPM_lengkap='Lengkap';
										$SPM_lengkap_ikon=$icon_tick;
									}
									?>
	                                <tr>
	                                    <td bgcolor="#ffffff">Persatuan</td>
	                                    <td bgcolor="#ffffff"><span class="style1"><?=$SPM_lengkap;?></span></td>
	                                    <td bgcolor="#ffffff" align="center">
	                                    	<span class="style1"><img src="<?=$SPM_lengkap_ikon;?>" width="30" height="25"></span>
	                                	</td>
	                                </tr>
					<?php } ?>
	                                <?php
	                                // $conn->debug=true;
									$rsData = $conn->query("SELECT * FROM $schema2.`calon_ko_rekacipta` WHERE `id_pemohon`=".tosql($_SESSION['SESS_UID']));
									$SPR_lengkap=''; $SPR_lengkap_ikon='';
									if($rsData->EOF){ 
										$SPM_lengkap='Tiada Maklumat, Lengkapkan sekiranya perlu'; 
										$SPM_lengkap_ikon=$icon_info;
									} else {
										$SPM_lengkap='Lengkap';
										$SPM_lengkap_ikon=$icon_tick;
									}
									?>

					<?php
						$sql = "SELECT COUNT(*) as total FROM $schema2.`menu_pemohon` WHERE is_deleted=0 AND `status`=0"; 
						$sql .=" AND keterangan LIKE '%REKACIPTA/PENCAPAIAN%'" ;
						$rsMenu = $conn->query($sql);
					?>
					<?php if($rsMenu->fields['total'] > 0){ ?>

	                                <tr>
	                                    <td bgcolor="#ffffff">Rekacipta</td>
	                                    <td bgcolor="#ffffff"><span class="style1"><?=$SPM_lengkap;?></span></td>
	                                    <td bgcolor="#ffffff" align="center">
	                                    	<span class="style1"><img src="<?=$SPM_lengkap_ikon;?>" width="30" height="25"></span>
	                                	</td>
	                                </tr>
	                                <?php
	                                // $conn->debug=true;
									$rsData = $conn->query("SELECT * FROM $schema2.`calon_ko_khas` WHERE `id_pemohon`=".tosql($_SESSION['SESS_UID']));
									$SPR_lengkap=''; $SPR_lengkap_ikon='';
									if($rsData->EOF){ 
										$SPM_lengkap='Tiada Maklumat, Lengkapkan sekiranya perlu'; 
										$SPM_lengkap_ikon=$icon_info;
									} else {
										$SPM_lengkap='Lengkap';
										$SPM_lengkap_ikon=$icon_tick;
									}
									?>
	                                <tr>
	                                                
	                                    <td bgcolor="#ffffff">Pencapaian Khas / Istimewa</td>
	                                    <td bgcolor="#ffffff"><span class="style1"><?=$SPM_lengkap;?></span></td>
	                                    <td bgcolor="#ffffff" align="center">
	                                    	<span class="style1"><img src="<?=$SPM_lengkap_ikon;?>" width="30" height="25"></span>
	                                	</td>
	                                </tr>
					<?php } ?>
	                                <?php
	                                // $conn->debug=true;
									$rsData = $conn->query("SELECT * FROM $schema2.`calon_bakat_bahasa` WHERE `bakat_bahasa_ind` IN ('B','L') AND `id_pemohon`=".tosql($_SESSION['SESS_UID']));
									$SPR_lengkap=''; $SPR_lengkap_ikon='';
									if($rsData->EOF){ 
										$SPM_lengkap='Tiada Maklumat, Lengkapkan sekiranya perlu'; 
										$SPM_lengkap_ikon=$icon_info;
									} else {
										$SPM_lengkap='Lengkap';
										$SPM_lengkap_ikon=$icon_tick;
									}
									?>

					<?php
						$sql = "SELECT COUNT(*) as total FROM $schema2.`menu_pemohon` WHERE is_deleted=0 AND `status`=0"; 
						$sql .=" AND keterangan LIKE '%BAKAT/KEBOLEHAN/BAHASA%'" ;
						$rsMenu = $conn->query($sql);
					?>
					<?php if($rsMenu->fields['total'] > 0){ ?> 

	                                <tr>
	                                    <td bgcolor="#ffffff">Bakat / Kebolehan bahasa</td>
	                                    <td bgcolor="#ffffff"><span class="style1"><?=$SPM_lengkap;?></span></td>
	                                    <td bgcolor="#ffffff" align="center">
	                                    	<span class="style1"><img src="<?=$SPM_lengkap_ikon;?>" width="30" height="25"></span>
	                                	</td>
	                                </tr>
					<?php } ?>
	                                <?php
	                                // $conn->debug=true;
									$rsData = $conn->query("SELECT * FROM $schema2.`calon_polis_ban_oku` WHERE `id_pemohon`=".tosql($_SESSION['SESS_UID']));
									$SPR_lengkap=''; $SPR_lengkap_ikon='';
									if($rsData->EOF){ 
										$SPM_lengkap='Tiada Maklumat, Lengkapkan sekiranya perlu'; 
										$SPM_lengkap_ikon=$icon_info;
									} else {
										$SPM_lengkap='Lengkap';
										$SPM_lengkap_ikon=$icon_tick;
									}
									?>
					<?php
						$sql = "SELECT COUNT(*) as total FROM $schema2.`menu_pemohon` WHERE is_deleted=0 AND `status`=0"; 
						$sql .=" AND keterangan LIKE '%BEKAS TENTERA/POLIS%'" ;
						$rsMenu = $conn->query($sql);
					?>
					<?php if($rsMenu->fields['total'] > 0){ ?>

	                                <tr>
	                                    <td bgcolor="#ffffff">Bekas tentera / Polis</td>
	                                    <td bgcolor="#ffffff"><span class="style1"><?=$SPM_lengkap;?></span></td>
	                                    <td bgcolor="#ffffff" align="center">
	                                    	<span class="style1"><img src="<?=$SPM_lengkap_ikon;?>" width="30" height="25"></span>
	                                	</td>
	                                </tr>
					<?php } ?>

	                                <tr>
	                                    <td bgcolor="#CCCCCC">Maklumat Permohonan</td>
	                                    <td bgcolor="#CCCCCC" colspan="2"></td>
	                                </tr>
	                                
	                                
									<?php
									$sqlJ = "SELECT * FROM $schema2.`calon_jawatan_dipohon` A, $schema1.`ref_skim` B WHERE A.`kod_jawatan`=B.`KOD` AND kod_jawatan IS NOT NULL";
									$sqlJ .= " AND A.`id_pemohon`=".tosql($_SESSION['SESS_UID']);  
									$sqlJ .= " ORDER BY A.`seq_no` ASC";
									$rsJawatan1 = $conn->query($sqlJ); $bil=0;

									$bl=0; $J1=''; $J2=''; $J3=''; $JawatanD = '<font style="color:red">Tidak Lengkap. Sila semak semula maklumat diisi</font>';
									if(!$rsJawatan1->EOF){
										while(!$rsJawatan1->EOF){
											if($bl==0){
												$J1 = $rsJawatan1->fields['DISKRIPSI'];
											} else if($bl==1){ 
												$J2 = $rsJawatan1->fields['DISKRIPSI'];
											} else {
												$J3 = $rsJawatan1->fields['DISKRIPSI'];
											}
											$bl++; $JawatanD ='Lengkap';
											$rsJawatan1->movenext();
										}
									} else {
										$btn_ok='';
									}
									$sqlp = "SELECT * FROM $schema2.`calon_pusat_temuduga` WHERE pusat_temuduga!='' AND id_pemohon=".tosql($_SESSION['SESS_UID']);
									$rsp = $conn->query($sqlp);
									if(!$rsp->EOF){
										$Jawatan='Lengkap';
									} else {
										$bl='';
										$Jawatan='Sila lengkapkan maklumat berkaitan Pusat Temu Duga di bahagian "Jawatan Dimohon"';
									}
									?>
					<?php
						$sql = "SELECT COUNT(*) as total FROM $schema2.`menu_pemohon` WHERE is_deleted=0 AND `status`=0"; 
						$sql .=" AND keterangan LIKE '%JAWATAN DIMOHON%'" ;
						$rsMenu = $conn->query($sql);
					?>
					<?php if($rsMenu->fields['total'] > 0){ ?>

	                                <tr>
	                                    <td bgcolor="#ffffff">Jawatan dimohon</td>
	                                    <td bgcolor="#ffffff"><span class="style1"><?=$JawatanD;?></span></td>
	                                    <td bgcolor="#ffffff" align="center">
	                                    	<?php if(!empty($bl)){ ?>
	                                    	<span class="style1"><img src="<?=$icon_tick;?>" width="30" height="25"></span>
	                                    	<?php } else { ?>
	                                    	<span class="style1"><img src="<?=$icon_no;?>" width="30" height="25"></span>
	                                    	<?php } ?>
	                                    </td>
	                                </tr>
					<?php
					if(!empty($bl)){ $proses='Lengkap.'; } else { $proses='Sila lengkapkan semua maklumat yang berkaitan.'; }
					?>
	                                <tr>
	                                    <td bgcolor="#ffffff">Kelayakan Jawatan dimohon</td>
	                                    <td bgcolor="#ffffff"><span class="style1"><?=$proses;?></span></td>
	                                    <td bgcolor="#ffffff" align="center">
	                                    	<?php if(!empty($bl)){ ?>
	                                    	<span class="style1"><img src="<?=$icon_tick;?>" width="30" height="25"></span>
	                                    	<?php } else { ?>
	                                    	<span class="style1"><img src="<?=$icon_no;?>" width="30" height="25"></span>
	                                    	<?php } ?>
	                                    </td>
	                                </tr>
					<?php } ?>
	                            </tbody>
                        	</table>
							</div>
						</div>
					</div>

					<div class="form-group">
						<div class="row">
							<div class="col-sm-12">
								<b>Jawatan Yang Dimohon: </b>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="row">
							<label for="nama" class="col-sm-2 control-label"><b>Pilihan Pertama<div style="float:right">:</div></b></label>
							<div class="col-sm-10"><b><?=$J1;?></b></div>
						</div>
						<?php if(!empty($J2)){ ?>
						<div class="row">
							<label for="nama" class="col-sm-2 control-label"><b>Pilihan Kedua<div style="float:right">:</div></b></label>
							<div class="col-sm-10"><b><?=$J2;?></b></div>
						</div>
						<?php } ?>
						<?php if(!empty($J3)){ ?>
						<div class="row">
							<label for="nama" class="col-sm-2 control-label"><b>Pilihan Ketiga<div style="float:right">:</div></b></label>
							<div class="col-sm-10"><b><?=$J3;?></b></div>
						</div>
						<?php } ?>
					</div>
			
				</div>

			</div>
			</div>

			<div class="box" style="background-color:#F2F2F2">
      			<div class="box-body">
					<div class="x_panel" style="background-color:#F2F2F2">
						<header class="panel-heading"  style="background-color:rgb(38, 167, 228)">
							<div class="panel-actions"></div>
							<h6 class="panel-title text-center"><font color="#000000"><b>MAKLUMAT PERAKUAN PEMOHON</b></font></h6> 
						</header>
					</div>
					<div class="form-group">
						<div class="row">
							<div class="col-sm-12 btn-group">
								<label for="nama" class="col-sm-12 control-label" style="color:red;text-align: justify;">
									Di bawah Seksyen 5, Akta Suruhanjaya-suruhanjaya Perkhidmatan 1957 (Semakan 1989), seseorang pemohon yang memberi maklumat palsu atau mengelirukan kepada Suruhanjaya berkaitan sesuatu permohonan untuk mendapatkan pekerjaan atau pelantikan adalah melakukan kesalahan dan jika disabitkan boleh dihukum penjara selama tempoh dua (2) tahun atau denda dua ribu Ringgit Malaysia (RM2,000) atau kedua-duanya sekali.								</label>
								<br><br>
								<?php
								//$conn->debug=true;
								$rsHantar = $conn->query("SELECT * FROM $schema2.`calon_tarikh` WHERE `id_pemohon`=".tosql($_SESSION['SESS_UID']));
								//print $rsHantar->fields['pengakuan'];
								?>
								<label for="nama" class="col-sm-12 control-label" style="text-align: justify;">	<br>
								<input type="checkbox" name="chk_declare" id="chk_declare" class="chk_declare" <?php if($rsHantar->fields['pengakuan']=='Y'){ print 'checked'; }?>>
									Saya akui bahawa semua maklumat yang diberikan adalah benar. Sekiranya maklumat itu didapati palsu, saya boleh didakwa dan permohonan saya akan dibatalkan. Sekiranya saya diberi tawaran jawatan atau telah pun berkhidmat, maka maklumat palsu itu akan menjadi bukti dan alasan membatalkan tawaran jawatan atau menamatkan perkhidmatan saya dengan serta-merta.
								 
							</label>
							</div>
						</div>
					</div>
    			</div>            

					<div class="modal-footer" style="padding:0px;">
						<span style="cursor: pointer;" class="disabled" id="dbtn" >   
						<?php if($btn_ok=='OK'){ 
							if(empty($rsHantar->fields['pengakuan'])){ 
						?>
							<button type="button" id="simpan" class="btn btn-primary mt-sm mb-sm" onclick="do_save()"><i class="fa fa-save"></i> HANTAR</button>
						<?php } ?>
						<?php } else { ?>
							<font color="red">Terdapat maklumat yang tidak lengkap. Sila lengkapkan sebelum butang hantar diaktifkan <i class="fa fa-arrow-circle-right" aria-hidden="true"></i></font>
							<button type="button" id="simpan" class="btn btn-default" title="Terdapat maklumat yang tidak lengkap. Sila lengkapkan sebelum butang hantar diaktifkan." onclick="do_alert()"><i class="fa fa-save"></i> HANTAR</button>
						<?php } ?>	
						&nbsp;
						</span>

						
						<!--  -->
						<input type="hidden" name="progid" id="progid" value="<?php print $progid;?>" />
						<input type="hidden" name="proses" value="<?php print $proses;?>" />
					</div>

			</div>		
		</div>

	     

<script language="javascript" type="text/javascript">
//document.frm.gsasar_nama.focus();
// Disable #x
 // $('#dbtn').prop('title', 'Butang ini hanya akan aktif setelah semua maklumat lengkap disediakan');
 // $("#simpan").attr('disabled', 'disabled');
 // Enable #x
 // $("#simpan").removeAttr('disabled');
</script>		 
