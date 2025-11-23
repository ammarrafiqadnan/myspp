<?php
// $conn->debug=true;
// print $id_pemohon;
// print_r($data);

?>
<script>
	function do_save(){
		var e_mail = $('#e_mail').val();

		var fd = new FormData();
		fd.append('e_mail',e_mail);


		var other_data = $('form').serializeArray();
		$.each(other_data,function(key,input){
			fd.append(input.name,input.value);
		});

		if(e_mail.trim() == '' ){
			alert_msg('Sila isi maklumat emel.');
			$('#e_mail').focus(); return true;
		} else {
			$.ajax({
				url:'pemohon/sql_pemohon.php?frm=BIODATA&pro=SAVE',
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

</script>


<small style="color: red;">
    Tarikh/masa kemas kini : <?=DisplayDate($rsCalon->fields['d_kemaskini']);  print '&nbsp;&nbsp;'.DisplayMasa($rsCalon->fields['d_kemaskini']);?> </small>

<header class="panel-heading"  style="background-color:rgb(38, 167, 228)">
    <h6 class="panel-title"><font color="#000000" size="3"><b>MAKLUMAT CALON</b></font></h6>
</header>
<div class="panel-body">
    <div class="box-body">
        <div class="col-md-12">
            <div class="form-group">
                <div class="row">
                <div class="col-md-9">
                    <div class="form-group">
                        <div class="row">
                            <label for="nama" class="col-sm-4 control-label"><b>No. Kad Pengenalan<div style="float:right">:</div></b></label>
                            <div class="col-sm-8"><?=$rsCalon->fields['ICNo'];?></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label for="nama" class="col-sm-4 control-label"><b>Nama Penuh<div style="float:right">:</div></b></label>
                            <div class="col-sm-8"><?php print $rsCalon->fields['nama_penuh'];?></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label for="nama" class="col-sm-4 control-label"><b>Tarikh Lahir<div style="float:right">:</div></b></label>
                            <div class="col-sm-8"><?=DisplayDate($rsCalon->fields['dob'])?></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label for="nama" class="col-sm-4 control-label"><b>Alamat Surat Menyurat<div style="float:right">:</div></b></label>
                            <div class="col-sm-8">
                                <?=$rsCalon->fields['addr1']?> <br>
                                <?=$rsCalon->fields['addr2']?> <br>
                                <?=$rsCalon->fields['addr3']?> 
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label for="nama" class="col-sm-4 control-label"></label>
                            <div class="col-sm-8">
                                
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="col-sm-12" align="center">
                        
                        <?php
                            global $schema2;
                            //$conn->debug=true;
                            $sql3 = "SELECT * FROM $schema2.`calon_gambar` WHERE id_pemohon=".tosql($rsCalon->fields['id_pemohon']);
                            $rs3 = $conn->query($sql3);

                            //if(!empty($rs3->fields['gambar'])){
                            //    $gambar = "/upload/".$rsCalon->fields['id_pemohon']."/".$rs3->fields['gambar'];
                            //} else { $gambar= '../images/person.jpg'; }

if(!empty($rs3->fields['gambar'])){
    	//$gambar = "/upload/".$_SESSION['SESS_UID']."/".$getGambar['gambar'];
	$gambar = "/var/www/upload/".$rsCalon->fields['id_pemohon']."/".$rs3->fields['gambar'];
} else { $gambar= '../images/person.jpg'; }

if (file_exists($gambar)){
	$b64image = base64_encode(file_get_contents($gambar));
	$gambars = "data:image/png;base64,$b64image";
	//print $gambars;
}

                        ?>
                        <img src="<?=$gambars?>" width="130" height="150">
                    </div>
                </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <label for="nama" class="col-sm-3 control-label"><b>Poskod<div style="float:right">:</div></b></label>
                    <div class="col-sm-3">
                        <?=$rsCalon->fields['poskod']?>
                    </div>
                    <label for="nama" class="col-sm-3 control-label"><b>Bandar <font color="#FF0000">*</font><div style="float:right">:</div></b></label>
                    <div class="col-sm-3">
                        <?=$rsCalon->fields['bandar']?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label for="nama" class="col-sm-3 control-label"><b>Negeri <font color="#FF0000">*</font><div style="float:right">:</div></b></label>
                    <div class="col-sm-3">
			<?php print dlookup("$schema1.`ref_negeri`","NEGERI","KOD_NEGERI=".tosql($rsCalon->fields['negeri'])); ?>
                    </div>
                    
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label for="nama" class="col-sm-3 control-label"><b>No. Telefon <font color="#FF0000">*</font><div style="float:right">:</div></b></label>
                    <div class="col-sm-3">
                        <?=$rsCalon->fields['no_depan']?><?=$rsCalon->fields['no_tel']?>
                    </div>   
                    <label for="nama" class="col-sm-3 control-label"><b>Alamat Emel <font color="#FF0000">*</font><div style="float:right">:</div></b></label>
			<?php
				//$conn->debug=true;
				$sql4 = "SELECT * FROM $schema2.`myid` WHERE id_pemohon=".tosql($rsCalon->fields['id_pemohon']);
                            $rs4 = $conn->query($sql4); 

			?>
                    <div class="col-sm-3">
			<input type="hidden" name="id_pemohon" id="id_pemohon" value="<?php print $data->fields['id_pemohon'];?>" readonly="readonly"/>
			<?php if(!empty($rsCalon->fields['e_mail'])){ ?>
				<input type="email" id="e_mail" name="e_mail" class="form-control text-lowercase" value="<?=$rsCalon->fields['e_mail']?>">
                        <?php } else { ?>
				<input type="email" id="e_mail" name="e_mail" class="form-control text-lowercase" value="<?=$rs4 ->fields['emel']?>">

			<?php } ?>
                    </div>
                </div>
            </div>
	<div class="form-group">
                <div class="row">
                    
                    <label for="nama" class="col-sm-3 control-label"><b>Ketinggian (sentimeter) <font color="#FF0000">*</font><div style="float:right">:</div></b></label>
                    <div class="col-sm-3">
                        <?=$rsCalon->fields['ketinggian'];?>
                    </div>

                    <label for="nama" class="col-sm-3 control-label"><b>Berat (KG) <font color="#FF0000">*</font><div style="float:right">:</div></b></label>
                    <div class="col-sm-3">
                        <?=$rsCalon->fields['berat'];?>
                    </div>
                    
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label for="nama" class="col-sm-3 control-label"><b>BMI <font color="#FF0000">*</font><div style="float:right">:</div></b></label>
                    <?php
                        //$HInches = ($rsCalon->fields['ketinggian'])*39.3700787;
                        /*Convert kg to pound*/
                        //$WPound = ($rsCalon->fields['berat'])*2.2;
                        //$BMIIndex = round($WPound/($HInches*$HInches)* 703,2);
        
                        /*Set Message*/
                        //if ($BMIIndex < 18.5) {
                                //$Message="Kurang berat badan";
                        //} else if ($BMIIndex <= 24.9) {
                                //$Message="Mempunyai berat badan unggul";
                        //} else if ($BMIIndex <= 29.9) {
                                //$Message="Berlebihan berat badan";
                        //} else {
                                //$Message="Obesiti";
                        //}

			if(!empty($rsCalon->fields['bmi'])){
			if ($rsCalon->fields['bmi'] < 18.5) {
                                $Message="Kurang berat badan";
                        } else if ($rsCalon->fields['bmi'] <= 24.9) {
                                $Message="Mempunyai berat badan ideal";
                        } else if ($rsCalon->fields['bmi'] <= 29.9) {
                                $Message="Berlebihan berat badan";
                        } else {
                                $Message="Obesiti";
                        }
			}


                        
                    ?>
                    <div class="col-sm-3">
                        <?php  
				if(!empty($rsCalon->fields['bmi'])){
					print $rsCalon->fields['bmi'].' ('.$Message.')';
				}
			?>
                    </div>
                    
			<label for="nama" class="col-sm-3 control-label"><b>Taraf Perkahwinan <font color="#FF0000">*</font><div style="float:right">:</div></b></label>
                    <div class="col-sm-3">
			
                        <?php 
				if($rsCalon->fields['taraf_kawin'] == '1'){
					print 'Bujang';
				} else if($rsCalon->fields['taraf_kawin'] == '2'){
					print 'Berkahwin';
				} else if($rsCalon->fields['taraf_kawin'] == '3'){
					print 'Janda';
				} else if($rsCalon->fields['taraf_kawin'] == '4'){
					print 'Duda';
				}

			?>
                    </div>
                </div>
            </div>
		
	<div class="form-group">
                <div class="row">
                    <label for="nama" class="col-sm-3 control-label"><b>Lesen Kenderaan <div style="float:right">:</div></b></label>
                    <div class="col-sm-3">
                        <?=$rsCalon->fields['lesen_kenderaan']?>
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
                    <label for="nama" class="col-sm-3 control-label"><b>Pemohon<div style="float:right">:</div></b></label>
                    <div class="col-md-3">
			<?php print dlookup("$schema1.`ref_negeri`","NEGERI","KOD_NEGERI=".tosql($rsCalon->fields['negeri_lahir_pemohon'])); ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label for="nama" class="col-sm-3 control-label"><b>Ibu Pemohon<font color="#FF0000">*</font><div style="float:right">:</div></b></label>
                    <div class="col-sm-3">
			<?php print dlookup("$schema1.`ref_negeri`","NEGERI","KOD_NEGERI=".tosql($rsCalon->fields['negeri_lahir_ibu'])); ?>
                    </div>
                    <label for="nama" class="col-sm-3 control-label"><b>Bapa Pemohon<font color="#FF0000">*</font><div style="float:right">:</div></b></label>
                    <div class="col-sm-3">
                        <?php print dlookup("$schema1.`ref_negeri`","NEGERI","KOD_NEGERI=".tosql($rsCalon->fields['negeri_lahir_bapa'])); ?>
                    </div>
                    
                </div>
            </div>
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
                        <?php
                            if(!empty($rsCalon->fields['oku'])){
                                global $schema1;
                                //$conn->debug=true;
                                $sql2 = "SELECT * FROM $schema1.`ref_kecacatan_calon` WHERE KOD=".tosql($rsCalon->fields['oku']);
                                $rs2 = $conn->query($sql2);
                                
                        
                                print $rs2->fields['DISKRIPSI']; 
                            } else {
                                print '-';
                            }
                        ?>
                    </div>
                    <div class="col-sm-1"></div>
                    <label for="nama" class="col-sm-2 control-label"><b>No.Pendaftaran OKU <div style="float:right">:</div></b></label>
                    <div class="col-sm-2">
                        <?php
                            if(!empty($rsCalon->fields['no_rujukan_oku'])){
                                print $rsCalon->fields['no_rujukan_oku']; 
                            } else {
                                print '-';
                            }
                        ?>
                        
                    </div>
                </div>
            </div>

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
                        <?php
                            if(!empty($rsCalon->fields['bantuan'])){
                                global $schema1;
                                //$conn->debug=true;
                                $sql2 = "SELECT * FROM $schema1.`ref_bantuan` WHERE kod_bantuan=".tosql($rsCalon->fields['bantuan']);
                                $rs2 = $conn->query($sql2);
                                
                        
                                print $rs2->fields['bantuan']; 
                            } else {
                                print '-';
                            }
                        ?>
                    </div>
                    <div class="col-sm-1"></div>
                    <label for="nama" class="col-sm-2 control-label"><b>No.Pendaftaran Bantuan <div style="float:right">:</div></b></label>
                    <div class="col-sm-3">
                        <?php
                            if(!empty($rsCalon->fields['no_rujukan_bantuan'])){
                                print $rsCalon->fields['no_rujukan_bantuan']; 
                            } else {
                                print '-';
                            }
                        ?>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <label for="nama" class="col-sm-11 control-label"><b>Adakah anda sedang berkhidmat dalam Perkhidmatan Awam / Kerajaan Tempatan / Badan Berkanun / Polis? <font color="#FF0000">*</font><div style="float:right">:</div></b></label>
                    <div class="col-sm-1">
                        <?php if($rsCalon->fields['masih_khidmat']=='Y'){ print 'Ya'; } else { print 'Tidak'; }?>
                    </div>
                </div>
            </div>
	    
		<div class="modal-footer" style="padding:0px;">
			<div class="form-group">
	    			<div class="row">
                			<div class="col-md-12">
						<div class="col-md-6" align="left">
                    					<!--<a type="button" class="btn btn-success mt-sm mb-sm" href="index.php?data=<?php print base64_encode('pemohon/senarai_pemohon;Senarai Pemohon;;;;;'); ?>"><i class="fa fa-arrow-left" style="margin:0px;"></i> Kembali</a>-->
                				</div>
						<div class="col-md-6">
							<button type="button" id="simpan" class="btn btn-primary mt-sm mb-sm" onclick="do_save('SAVE','')">
								<i class="fa fa-save"></i> Simpan
							</button>
						</div>
					</div>
				</div>
            		</div>

			

		</div>

        </div>
    </div>
</div>