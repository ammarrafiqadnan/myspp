<?php //include '../connection/common.php'; ?>
<script language="javascript">
function do_save(){
    var reg = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
    var id = $('#id').val();
    var nama = $('#nama').val();
    var no_pengenalan = $('#no_pengenalan').val();
    var warganegara = $('#warganegara').val();
    var pengalaman_tahun = $('#pengalaman_tahun').val();
    var no_tel = $('#no_tel').val();
    
    if(nama.trim() == '' ){
        alert('Sila masukkan nama pemegang tauliah sembelihan.');
        $('#nama').focus(); return false;
	} else if(no_pengenalan.trim() == '' ){
        alert('Sila masukkan nombor pengenalan diri.');
        $('#no_pengenalan').focus(); return false;
	} else if(warganegara.trim() == '' ){
        alert('Sila pilih maklumat warganegara.');
        $('#warganegara').focus(); return false;
	} else if(pengalaman_tahun.trim() == '' ){
        alert('Sila masukkan maklumat pemgalaman.');
        $('#pengalaman_tahun').focus(); return false;
	} else if(no_tel.trim() == '' ){
        alert('Sila masukkan maklumat nombor telefon.');
        $('#no_tel').focus(); return false;
	} else {
		$.ajax({
	        url:'maklumat_data/sql_maklumat_data.php?frm=PASS&pro=SAVE',
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
				//window.location.reload();

			},
			//data: datas
	    });
    }
}

function do_simpan(){
	// alert("ss");
	$.ajax({
        url:'maklumat_data/sql_maklumat_data.php?frm=PASS&pro=SAVE',
		type:'POST',
        //dataType: 'json',
		data: $("form").serialize(),
		//data: datas,
		success: function(data){
			if(data=='OK'){
    			document.getElementById("simpan").click();
    		}
    	}
	});
}

</script>
<?php
// $conn->debug=true;
// $noid=isset($_REQUEST["noid"])?$_REQUEST["noid"]:"";
$sql = "SELECT * FROM `tbl_penyembelih` WHERE `id`=".tosql($id);
$rs = $conn->query($sql);

$read_only='';
$rsData = $conn->query("SELECT * FROM `tbl_penyembelih_detail` WHERE `id_penyembelih`='{$id}' ORDER BY `tarikh_sah_akhir` DESC");
if($rsData->EOF){
	$read_only='';
	// $nopengenalan = $noid;
} else if($_SESSION['SESS_ULEVEL']==1){
	$read_only='';
	// $nopengenalan = $rs->fields['no_pengenalan'];
} else {
	// $nopengenalan = $rs->fields['no_pengenalan'];
	$read_only='readonly="readonly"';
}

// PRINT "DD:".$read_only;

?>
<div class="col-lg-12">
<section class="panel">
    <header class="panel-heading"  style="background-color:rgb(38, 167, 228)">
        <h6 class="panel-title"><font color="#000000" size="3"><b>MAKLUMAT PEMEGANG KAD TAULIAH SEMBELIHAN</b></font></h6>
    </header>
    <div class="panel-body">
        <div class="box-body">
        
            <input type="hidden" name="id" id="id" value="<?php print $id;?>" readonly="readonly"/>
    
            <div class="col-md-12">
            
            <div class="form-group">
              <div class="row">
                <label for="nama" class="col-sm-2 control-label"><b>NAMA <font color="#FF0000">*</font> : </b></label>
                <div class="col-sm-10">
                	<input type="text" name="nama" id="nama" class="form-control" value="<?php print $rs->fields['nama'];?>" <?=$read_only;?>>
                </div>
              </div>
            </div>

			<?php $rsNEGARA = $conn->query("SELECT * FROM `_ref_negara` WHERE 1"); ?>
            <div class="form-group">
              <div class="row">
                <label for="no_pengenalan" class="col-sm-2 control-label"><b>NO. PENGENALAN <font color="#FF0000">*</font> : </b></label>
                <div class="col-sm-3">
                   <input type="text" name="no_pengenalan" id="no_pengenalan" class="form-control" value="<?php print $rs->fields['no_pengenalan'];?>" readonly <?//=$read_only;?>>
                </div>
                <label for="warganegara" class="col-sm-1 col-xs-12 control-label"></label>
                <label for="warganegara" class="col-sm-2 control-label"><b>WARGANEGARA <font color="#FF0000">*</font> : </b></label>
                <div class="col-sm-3">
					<select name="warganegara" id="warganegara" class="form-control" <?=$read_only;?>>
						<option value="">Sila pilih Negara</option>
						<?php while(!$rsNEGARA->EOF){ ?>
						<option value="<?php print $rsNEGARA->fields['fldcountry_id'];?>" <?php if($rsNEGARA->fields['fldcountry_id']==$rs->fields['warganegara']){ print 'selected'; }
						?>><?php print strtoupper($rsNEGARA->fields['fldcountry']);?></option>
						<?php $rsNEGARA->movenext(); } ?>
					</select>
                </div>
              </div>
            </div>

            <div class="form-group">
              <div class="row">
                <label for="pengalaman_tahun" class="col-sm-2 control-label"><b>PENGALAMAN <font color="#FF0000">*</font> : </b></label>
                <div class="col-sm-3">
                   <input type="text" name="pengalaman_tahun" id="pengalaman_tahun" class="form-control" value="<?php print $rs->fields['pengalaman_tahun'];?>" <?=$read_only;?>>
                </div>
                <label for="no_tel" class="col-sm-1 col-xs-12 control-label"></label>
                <label for="no_tel" class="col-sm-2 control-label"><b>NO. TELEFON <font color="#FF0000">*</font> : </b></label>
                <div class="col-sm-3">
                   <input type="text" name="no_tel" id="no_tel" class="form-control" value="<?php print $rs->fields['no_tel'];?>" <?=$read_only;?>>
                </div>
              </div>
            </div>

            <div class="form-group">
              <div class="row">
                <label for="agensi_nama" class="col-sm-2 control-label"><b>TARIKH MULA : </b></label>
                <div class="col-sm-3">
					<input type="date" name="tkh_mula" id="tkh_mula"  class="form-control" value="<?php print $rsData->fields['tarikh_sah_mula'];?>" readonly/>
				</div>
                <label for="agensi_nama" class="col-sm-1 col-xs-12 control-label"></label>
                <label for="agensi_nama" class="col-sm-2 control-label"><div align="left"><b>HINGGA </b></div></label>
                <div class="col-sm-3">
					<input type="date" name="tkh_tamat" id="tkh_tamat"  class="form-control" value="<?php print $rsData->fields['tarikh_sah_akhir'];?>" readonly/>
				</div>
              </div>
            </div>


            <div class="form-group">
              <div class="row">
                <label for="catatan" class="col-sm-2 control-label"><b>CATATAN : </b></label>
                <div class="col-sm-10">
 					<textarea rows="3" name="catatan" id="catatan" class="form-control"><?php print $rs->fields['catatan'];?></textarea>
               </div>
              </div>
            </div>
    	

            <div class="form-group">
              <div class="row">
                <label for="status" class="col-sm-2 control-label"><b>STATUS REKOD <font color="#FF0000">*</font> : </b></label>
                <div class="col-sm-3">
                    <select class="form-control" name="status" id="status" required="required">
                        <option value="0"<?php if($rs->fields['status']==0){ print 'selected';}?>>Rekod Aktif</option>
                        <option value="1"<?php if($rs->fields['status']==1){ print 'selected';}?>>Rekod Tidak Aktif</option>
                    </select>
                </div>
              </div>
            </div>
    
            <div class="modal-footer" style="padding:0px;">
                <button type="button" class="btn btn-primary mt-sm mb-sm" onclick="do_save()"><i class="fa fa-save"></i> Simpan</button>
                &nbsp;
                <button type="button" class="btn btn-default" onclick="do_page('index.php?data=<?php print base64_encode('maklumat_data/pass_list;DATA;Maklumat Pemegang Pas Sembelihan;;;;'); ?>')">
                	<i class="fa fa-spinner" style="margin:0px;"></i> Kembali</button>
                <input type="hidden" name="progid" id="progid" value="<?php print $progid;?>" />
                <input type="hidden" name="proses" value="<?php print $proses;?>" />
                <?php if(!empty($id)){ ?>
	                &nbsp;
	                <button type="button" class="btn btn-info mt-sm mb-sm" onclick="do_simpan()" title="Tambah Maklumat Pas Lawatan Ikhtisas">
	                	<i class="fa fa-save"></i> Tambah Maklumat Tauliah</button>
                    
                    <a id="simpan" href="maklumat_data/pass_form_detail.php?id=<?=$id;?>" data-toggle="modal" data-target="#myModal" data-backdrop="" style="font-family: Arial;"></a>

                <?php } ?>
            </div>
        </div>

        <?php 
			// $conn->debug=true;
			$sql = "SELECT * FROM `tbl_penyembelih_detail` WHERE is_deleted=0 AND `id_penyembelih`='{$id}' ORDER BY tarikh_sah_akhir DESC"; 
			$kbil=0; $tbil=0;
			$rs = $conn->query($sql);
            ?>    
            <div class="box-body" style="background-color:#F2F2F2">
              <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                <thead  style="background-color:rgb(38, 167, 228)">
                  <th width="5%"><font color="#000000"><div align="center">Bil</div></font></th>
                  <th width="25%"><font color="#000000"><div align="center">Nama Majikan & Alamat</div></font></th>
                  <th width="10%"><font color="#000000"><div align="center">No. Telefon<br>/ No. Faks</div></font></th>
                  <th width="25%"><font color="#000000"><div align="center">Nama Premis & Alamat</div></font></th>
                  <th width="10%"><font color="#000000"><div align="center">No. Telefon<br>/ No. Faks</div></font></th>
                  <th width="15%"><font color="#000000"><div align="center">No. Sijil <br>(No. Kad)</div></font></th>
                  <th width="10%"><font color="#000000"><div align="center">Tarikh</div></font></th>
                  <th width="10%"><font color="#000000"><div align="center">Status</div></font></th>
                  <th width="5%"><font color="#000000"><div align="center">Tindakan</div></font></th>
                </thead>
                <tbody>
            <?php 
				$cnt = 1; 
				$bil = $StartRec;
				while(!$rs->EOF){ $kbil++; $tbil++;
					$bil = $cnt + ($PageNo-1)*$PageSize;
					$id_det = $rs->fields['id_det'];
					if($rs->fields['tarikh_sah_akhir']<date("Y-m-d")){ $status = '<font color="red">Tamat</font>'; } else { $status = 'Aktif'; }
					// $data = $conn->query("SELECT `nama_sekolah`, `tkh_mula`, `tkh_tamat` FROM `tbl_plik_detail` WHERE plik_id='{$plik_id}' ORDER BY tkh_mula DESC");
					// $hrefs = "index.php?data=". base64_encode('maklumat_data/plik_form;DATA;Maklumat Pemegang Pas Lawatan Ikhtisas;;;'.$plik_id);
				?>
				  <tr>
					  <td align="center"><?=$bil;?></td>
					  <td align="left"><?php print $rs->fields['majikan_nama'];?><br><?php print nl2br($rs->fields['majikan_alamat']);?></td>
					  <td align="center"><?php print $rs->fields['majikan_notel'];?><br>/<br><?php print $rs->fields['majikan_nofaks'];?></td>
					  <td align="left"><?php print $rs->fields['premis_nama'];?><br><?php print nl2br($rs->fields['premis_alamat']);?></td>
					  <td align="center"><?php print $rs->fields['majikan_notel'];?><br>/<br><?php print $rs->fields['majikan_nofaks'];?></td>
					  <td align="left">No. Sijil: <?php print $rs->fields['no_sijil'];?><br><br>(No. Kad: <?php print $rs->fields['no_kad'];?>)</td>
					  <td align="center"><?php print DisplayDate($rs->fields['tarikh_sah_mula']);?><br>-<br><?php print DisplayDate($rs->fields['tarikh_sah_akhir']);?></td>
					  <td align="center">
					  	<b><?php print $status;?></b><br><?=$jenis;?>

					  </td>
					  <td align="center">
					  	<?php if($status=='Aktif'){ ?>
						<a href="maklumat_data/pass_form_detail.php?id=<?=$id;?>&ids=<?=$id_det;?>" data-toggle="modal" data-target="#myModal" 
							title="Tambah Maklumat Kad Tauliah" class="fa" data-backdrop="static">
							<label class="btn btn-sm btn-success">
								<i class="fa fa-edit" style="color:white;"></i>
							</label></a>
							<br><br>
						<?php } ?>	
						<button type="button" class="btn btn-sm btn-danger" onclick="do_delete('maklumat_data/sql_maklumat_data.php?frm=PASS_DET&pro=DEL&ID=<?=$id_det;?>')">
							<span style="cursor:pointer;color:red" title="Hapus Maklumat Kad Tauliah">
								<i class="fa fa-trash-o" style="color: #FFFFFF;"></i>
							</span>
						</button>
                      </td>
				  </tr>
				<?php 
					$cnt = $cnt + 1;
					$bil = $bil + 1;
					$rs->movenext();
			}
			
			?>
                </tbody>
              </table>
            </div>
  </div>
     
</section>

</div> 
<script language="javascript" type="text/javascript">
//document.frm.gsasar_nama.focus();
</script>		 
