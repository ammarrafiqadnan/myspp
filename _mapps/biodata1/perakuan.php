<?php //include '../connection/common.php'; ?>
<script language="javascript">
function do_save(){
    var reg = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
    // var chk_declare = $('#chk_declare').val();
    var checkedValue = "";
    if($('.chk_declare:checked').val()=='on'){ checkedValue='on'; }
    var msg = '';
    // alert(checkedValue);
    if(checkedValue.trim() == '' ){
        msg = msg+'- Sila tick pada maklumat perakuan pemohon.';
        $("#chk_declare").css("border-color","#f00");
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
                      text: 'Terdapat ralat sistem.\nSila maklumkan kepad apihak penyelia sistem.',
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
// $conn->debug=true;
include 'akademik/sql_akademik.php';
// include 'biodata/sql_biodata.php';
// $user = get_user($conn,$_SESSION['SESS_UID']);
$data_biodata = get_biodata($conn,$_SESSION['SESS_UID']);
$lengkap="";
//print_r($data_biodata);
$icon_tick = '../images/icon_green.png';
$icon_no = '../images/icon_red.png';
$icon_info = '../images/Button-Info-icon.png';

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
								<label for="nama" class="col-sm-4 control-label"><b>MyID (No. Kad Pengenalan)<div style="float:right">:</div></b></label>
								<div class="col-sm-8"><b><?php print $_SESSION['SESS_UID'];?></b></div>
							</div>
							<div class="row">
								<label for="nama" class="col-sm-4 control-label"><b>Nama Penuh<div style="float:right">:</div></b></label>
								<div class="col-sm-8"><b><?php print $_SESSION['SESS_UNAME'];?></b></div>
							</div>
							<div class="row">
								<label for="nama" class="col-sm-4 control-label"><b>Alamat Surat Menyurat<div style="float:right">:</div></b></label>
								<div class="col-sm-8">
									<?php 
									print $data_biodata['addr1'];
									if(!empty($data_biodata['addr2'])){ print "<br>".$data_biodata['addr2']; }
									if(!empty($data_biodata['addr3'])){ print "<br>".$data_biodata['addr3']; }
									?>
								</div>
							</div>
							<div class="row">
								<label for="nama" class="col-sm-4 control-label"><b><div style="float:right"></div></b></label>
								<div class="col-sm-8"><?php print $data_biodata['poskod'];?>, <?php print $data_biodata['bandar']; ?>, 
								<?php print dlookup("$schema2.ref_negeri", "diskripsi", "kod=".tosql($data_biodata['negeri'])); ?></div>
							</div>
							
							<div class="row">
								<label for="nama" class="col-sm-4 control-label"><b>E-mel<div style="float:right">:</div></b></label>
								<div class="col-sm-8"><?php print $data_biodata['e_mail'];?></div>
							</div>
							<div class="row">
								<label for="nama" class="col-sm-4 control-label"><b>No. Telefon<div style="float:right">:</div></b></label>
								<div class="col-sm-4"><?php print $data_biodata['no_tel'];?></div>
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
							<label for="nama" class="col-sm-12 control-label"><b>NOTA : </b>
								<ul>
									<li>Sila pastikan No. Kad Pengenalan, Nama Penuh, Emel dan No. Telefon yang diisi adalah tepat.</li>
									<li>Sekiranya maklumat di atas tidak tepat, sila klik pada pautan Maklumat Pemohon untuk mengemaskini maklumat tersebut sebelum menghantar borang.</li>
									<li>Sila semak status pendaftaran di Menu Semakan Permohonan dan pastikan tarikh daftar adalah terkini.</li>
								</ul>
							</label>
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
	                                    <td width="30%" bgcolor="#999999"><strong>Kategori</strong></td>
	                                    <td width="55%" bgcolor="#999999"><strong>Kenyataan Status</strong></td>
	                                    <td width="20%" bgcolor="#999999"><strong>Status</strong></td>
	                                </tr>
	                                <tr>
	                                    <td bgcolor="#ffffff">Maklumat Pemohon</td>
	                                    <td bgcolor="#ffffff"><span class="style1">Lengkap</span></td>
	                                    <td bgcolor="#ffffff" align="center">
	                                    	<span class="style1"><img src="<?=$icon_tick;?>" width="30" height="25"></span>
	                                	</td>
	                                </tr>
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
	                                	$rsKh = $conn->query("SELECT * FROM `calon_masih_khidmat` WHERE `id_pemohon`=".tosql($_SESSION['SESS_UID']));
	                                	if(!$rsKh->EOF){ 
	                                		$khidmat = $icon_tick; 
	                                		$khidmat_info = 'Lengkap'; 
	                                	} else { 
	                                		$khidmat = $icon_no; 
	                                		$khidmat_info = '<font style="color:red">Tidak Lengkap. Sila semak semula maklumat diisi</font>';
	                                	}	
	                                }
	                            	?>
	                                <tr>
	                                    <td bgcolor="#ffffff">Pegawai Sedang Berkhidmat</td>
	                                    <td bgcolor="#ffffff"><span class="style2"><?=$khidmat_info;?></span></td>
	                                    <td bgcolor="#ffffff" align="center">
	                                    	<span class="style1"><img src="<?=$khidmat;?>" width="30" height="25"></span>
	                                    </td>
	                                </tr>

	                                <tr>
	                                    <td bgcolor="#CCCCCC">Maklumat Akademik</td>
	                                    <td bgcolor="#CCCCCC" colspan="2"></td>
	                                </tr>

									<?php 
									$data_pmr = get_pmr($conn,$_SESSION['SESS_UID']);
									//print_r($data_pmr);
									$SPR_lengkap=''; $SPR_lengkap_ikon='';
									if(empty($data_pmr['srp_tahun'])){ 
										$SPR_lengkap='Tiada Maklumat, Lengkapkan sekiranya perlu'; 
										$SPR_lengkap_ikon=$icon_tick;
									} else {
										if(empty($data_pmr['srp_jenis_sijil']) || empty($data_pmr['srp_pangkat'])){ 
											$SPR_lengkap='<font style="color:red">Tiada Maklumat, Lengkapkan sekiranya perlu.</font>'; 
											$SPR_lengkap_ikon=$icon_info;
										} else {
											$SPR_lengkap='Lengkap';
											$SPR_lengkap_ikon=$icon_tick;
										}
									}
									?>
	                                <tr>
	                                    <td bgcolor="#ffffff">PT3/PMR/SRP</td>
	                                    <td bgcolor="#ffffff"><span class="style2"><?=$SPR_lengkap;?></span></td>
	                                    <td bgcolor="#ffffff" align="center">
	                                    	<span class="style1"><img src="<?=$SPR_lengkap_ikon;?>" width="30" height="25"></span>
	                                    </td>
	                                </tr>

									<?php
									$data_spm = get_exam($conn,$_SESSION['SESS_UID']);
									//print_r($data_spm);
									$SPR_lengkap=''; $SPR_lengkap_ikon='';
									if(empty($data_spm['spm_tahun_1'])){ 
										$SPM_lengkap='Tiada Maklumat, Lengkapkan sekiranya perlu'; 
										$SPM_lengkap_ikon=$icon_info;
									} else {
										if(empty($data_spm['spm_jenis_sijil_1']) || empty($data_spm['spm_pangkat_1']) || empty($data_spm['spm_lisan_1'])){ 
											$SPM_lengkap='<font style="color:red">Tidak Lengkap. Sila semak semula maklumat diisi.</font>'; 
											$SPM_lengkap_ikon=$icon_no;
										} else {
											$SPM_lengkap='Lengkap';
											$SPM_lengkap_ikon=$icon_tick;
										}
									}
									?>
	                                <tr>
	                                    <td bgcolor="#ffffff">SPM/SPM(V)/SVM</td>
	                                    <td bgcolor="#ffffff"><span class="style2"><?=$SPM_lengkap;?></span></td>
	                                    <td bgcolor="#ffffff" align="center">
	                                    	<span class="style1"><img src="<?=$SPM_lengkap_ikon;?>" width="25" height="25"></span>
	                                    </td>
	                                </tr>
	                                <?php
	                                $SPM_tambahan='Tiada Maklumat, Lengkapkan sekiranya perlu'; 
									$SPM_tambahan_ikon=$icon_info;
	                                $rsData = $conn->query("SELECT * FROM $schema2.`calon_spm` WHERE `jenis_xm`='T' AND `id_pemohon`=".tosql($_SESSION['SESS_UID']));
	                                if(!$rsData->EOF){
										$SPM_tambahan='Lengkap';
										$SPM_tambahan_ikon=$icon_tick;
	                                }
	                                ?>
	                                <tr>
	                                    <td bgcolor="#ffffff">Peperiksaan SPM Ulangan</td>
	                                    <td bgcolor="#ffffff"><span class="style1"><?=$SPM_tambahan;?></span></td>
	                                    <td bgcolor="#ffffff" align="center">
	                                    	<span class="style1"><img src="<?=$SPM_tambahan_ikon;?>" width="30" height="25"></span>
	                                    </td>
	                                </tr>
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
									$rsUniv = $conn->query("SELECT * FROM $schema2.`calon_ipt` WHERE `id_pemohon`=".tosql($_SESSION['SESS_UID']));
									$bilUniv1 = $rsUniv->recordcount();

									$SPR_lengkap=''; $SPR_lengkap_ikon='';
									if($rsUniv->EOF){ 
										$SPM_lengkap='Tiada Maklumat, Lengkapkan sekiranya perlu'; 
										$SPM_lengkap_ikon=$icon_info;
									} else {
										// if(empty($data_spm['spm_jenis_sijil_1']) || empty($data_spm['spm_pangkat_1']) || empty($data_spm['spm_lisan_1'])){ 
										// 	$SPM_lengkap='<font style="color:red">Tidak Lengkap. Sila semak semula maklumat diisi.</font>'; 
										// 	$SPM_lengkap_ikon=$icon_no;
										// } else {
											$SPM_lengkap='Lengkap';
											$SPM_lengkap_ikon=$icon_tick;
										// }
									}
									?>
	                                <tr>
	                                    <td bgcolor="#ffffff">Pengajian Tinggi</td>
	                                    <td bgcolor="#ffffff"><span class="style1"><?=$SPM_lengkap;?></span></td>
	                                    <td bgcolor="#ffffff" align="center">
	                                    	<span class="style1"><img src="<?=$SPM_lengkap_ikon;?>" width="30" height="25"></span>
	                                    </td>
	                                </tr>

									<?php
									$data = get_profesional($conn,$_SESSION['SESS_UID']);

									$SPR_lengkap=''; $SPR_lengkap_ikon='';
									if(empty($data['professional_1']) && empty($data['professional_d_1'])){ 
										$SPM_lengkap='Tiada Maklumat, Lengkapkan sekiranya perlu'; 
										$SPM_lengkap_ikon=$icon_info;
									} else {
										// if(empty($data_spm['spm_jenis_sijil_1']) || empty($data_spm['spm_pangkat_1']) || empty($data_spm['spm_lisan_1'])){ 
										// 	$SPM_lengkap='<font style="color:red">Maklumat perlu dilengkapkan.</font>'; 
										// 	$SPM_lengkap_ikon='../images/icon_red.jpg';
										// } else {
											$SPM_lengkap='Lengkap';
											$SPM_lengkap_ikon=$icon_tick;
										}
									// }
									?>
	                                <tr>
	                                    <td bgcolor="#ffffff">Profesional</td>
	                                    <td bgcolor="#ffffff"><span class="style1"><?=$SPM_lengkap;?></span></td>
	                                    <td bgcolor="#ffffff" align="center">
	                                    	<span class="style1"><img src="<?=$SPM_lengkap_ikon;?>" width="30" height="25"></span>
	                                    </td>
	                                </tr>

									<?php
									$SPR_lengkap=''; $SPR_lengkap_ikon='';
									if(empty($data_spm['spm_tahun_1'])){ 
										$SPM_lengkap='Tiada Maklumat, Lengkapkan sekiranya perlu'; 
										$SPM_lengkap_ikon='../images/icon_red.jpg';
									} else {
										if(empty($data_spm['spm_jenis_sijil_1']) || empty($data_spm['spm_pangkat_1']) || empty($data_spm['spm_lisan_1'])){ 
											$SPM_lengkap='<font style="color:red">Maklumat perlu dilengkapkan.</font>'; 
											$SPM_lengkap_ikon='../images/icon_red.jpg';
										} else {
											$SPM_lengkap='Lengkap';
											$SPM_lengkap_ikon='../images/tick_green.webp';
										}
									}
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
	                                <tr>
	                                    <td bgcolor="#ffffff">Bakat / Kebolehan bahasa</td>
	                                    <td bgcolor="#ffffff"><span class="style1"><?=$SPM_lengkap;?></span></td>
	                                    <td bgcolor="#ffffff" align="center">
	                                    	<span class="style1"><img src="<?=$SPM_lengkap_ikon;?>" width="30" height="25"></span>
	                                	</td>
	                                </tr>
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
	                                <tr>
	                                    <td bgcolor="#ffffff">Bekas tentera / Polis</td>
	                                    <td bgcolor="#ffffff"><span class="style1"><?=$SPM_lengkap;?></span></td>
	                                    <td bgcolor="#ffffff" align="center">
	                                    	<span class="style1"><img src="<?=$SPM_lengkap_ikon;?>" width="30" height="25"></span>
	                                	</td>
	                                </tr>

	                                <tr>
	                                    <td bgcolor="#CCCCCC">Maklumat Permohonan</td>
	                                    <td bgcolor="#CCCCCC" colspan="2"></td>
	                                </tr>
	                                
	                                
									<?php
									$sqlJ = "SELECT * FROM $schema2.`calon_jawatan_dipohon` A, $schema1.`ref_skim` B WHERE A.`kod_jawatan`=B.`KOD`";
									$sqlJ .= " AND A.`id_pemohon`=".tosql($_SESSION['SESS_UID']);  
									$sqlJ .= " ORDER BY A.`seq_no` ASC";
									$rsJawatan1 = $conn->query($sqlJ); $bil=0;

									$bl=0; $J1=''; $J2=''; $J3=''; $Jawatan = '<font style="color:red">Tidak Lengkap. Sila semak semula maklumat diisi</font>';
									while(!$rsJawatan1->EOF){
										if($bl==0){
											$J1 = $rsJawatan1->fields['DISKRIPSI'];
										} else if($bl==1){ 
											$J2 = $rsJawatan1->fields['DISKRIPSI'];
										} else {
											$J3 = $rsJawatan1->fields['DISKRIPSI'];
										}
										$bl++; $Jawatan='Lengkap';
										$rsJawatan1->movenext();
									}

									?>
	                                <tr>
	                                    <td bgcolor="#ffffff">Jawatan dimohon</td>
	                                    <td bgcolor="#ffffff"><span class="style1"><?=$Jawatan;?></span></td>
	                                    <td bgcolor="#ffffff" align="center">
	                                    	<?php if(!empty($bl)){ ?>
	                                    	<span class="style1"><img src="<?=$icon_tick;?>" width="30" height="25"></span>
	                                    	<?php } else { ?>
	                                    	<span class="style1"><img src="<?=$icon_no;?>" width="30" height="25"></span>
	                                    	<?php } ?>
	                                    </td>
	                                </tr>
	                                <tr>
	                                    <td bgcolor="#ffffff">Kelayakan Jawatan dimohon</td>
	                                    <td bgcolor="#ffffff"><span class="style1"><?=$Jawatan;?></span></td>
	                                    <td bgcolor="#ffffff" align="center">
	                                    	<?php if(!empty($bl)){ ?>
	                                    	<span class="style1"><img src="<?=$icon_tick;?>" width="30" height="25"></span>
	                                    	<?php } else { ?>
	                                    	<span class="style1"><img src="<?=$icon_no;?>" width="30" height="25"></span>
	                                    	<?php } ?>
	                                    </td>
	                                </tr>
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
							<div class="col-sm-12">
								<label for="nama" class="col-sm-12 control-label">Di bawah Seksyen 5, Akta Suruhanjaya-suruhanjaya Perkhidmatan 1957 (Semakan 1989), seseorang pemohon yang memberi maklumat palsu atau mengelirukan kepada Suruhanjaya berkaitan sesuatu permohonan untuk mendapatkan pekerjaan atau pelantikan adalah melakukan kesalahan dan jika disabitkan boleh dihukum penjara selama tempoh dua (2) tahun atau denda dua ribu Ringgit Malaysia (RM2,000) atau kedua-duanya sekali.
								<br><br>	
								<input type="checkbox" name="chk_declare" class="chk_declare" class="flat-red" <?php if($rsMohon->fields['mohon_status']>=1){ print 'checked'; }?>>
								Saya akui bahawa semua maklumat yang diberikan adalah benar. Sekiranya maklumat itu didapati palsu, saya boleh didakwa dan permohonan saya akan dibatalkan. Sekiranya saya diberi tawaran jawatan atau telah pun berkhidmat, maka maklumat palsu itu akan menjadi bukti dan alasan membatalkan tawaran jawatan atau menamatkan perkhidmatan saya dengan serta-merta. 
							</label>
							</div>
						</div>
					</div>
    			</div>            

					<div class="modal-footer" style="padding:0px;">
						<span style="cursor: pointer;" class="disabled" id="dbtn" >   
							<button type="button" id="simpan" class="btn btn-primary mt-sm mb-sm" onclick="do_save()"><i class="fa fa-save"></i> HANTAR</button>
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
