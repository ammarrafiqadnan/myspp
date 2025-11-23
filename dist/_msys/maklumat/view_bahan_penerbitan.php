<?php include '../connection/common.php'; ?>
<script language="javascript">
</script>
<?php
// $conn->debug=true;
$id=isset($_REQUEST["id"])?$_REQUEST["id"]:"";
$kategori=isset($_REQUEST["kategori"])?$_REQUEST["kategori"]:"";
$read_only='';

$sql = "SELECT * FROM `tbl_pemantauan` WHERE `pemantauan_id`=".tosql($id);
$rs = $conn->query($sql);
$jenis = $rs->fields['pemantauan_type'];
$status = dlookup("_ref_status","status_nama","status_id=".tosql($rs->fields['status_proses']));
// PRINT "DD:".$read_only;

?>
<div class="col-lg-12">
	<section class="panel">
		<header class="panel-heading"  style="background-color:rgb(38, 167, 228)">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="do_close()">×</button>
			<h6 class="panel-title"><font color="#000000" size="3"><b>MAKLUMAT LAPORAN KAJIAN BAHAN PENERBITAN BERUNSUR ISLAM MERAGUKAN</b> - <i style="color:#f00">DRAF LAPORAN</i></font>
			</h6>
		</header>
		<div class="panel-body">
			<div class="box-body">

			<input type="hidden" name="pemantauan_id" id="pemantauan_id" value="<?php print $id;?>" readonly="readonly"/>

				<div class="col-md-12">

					<div class="form-group">
						<div class="row">
							<label for="nama" class="col-sm-2 control-label"><b>KATEGORI LAPORAN <font color="#FF0000">*</font> : </b></label>
							<div class="col-sm-10"><b><?php print dlookup("`_ref_kategori_sub`","subkat_nama","subkat_id='{$jenis}'"); ?></b></div>
						</div>
					</div>

					<div class="form-group">
						<div class="row">
							<label for="nama" class="col-sm-2 control-label"><b>TAJUK BUKU <font color="#FF0000">*</font> : </b></label>
							<div class="col-sm-10"><?php print $rs->fields['tajuk'];?></div>
						</div>
					</div>

					<div class="form-group">
						<div class="row">
							<label for="nama" class="col-sm-2 control-label"><b>TAJUK PENERBITAN <font color="#FF0000">*</font> : </b></label>
							<div class="col-sm-10"><?php print $rs->fields['tajuk_penerbitan'];?></div>
						</div>
					</div>

					<div class="form-group">
						<div class="row">
							<label for="nama" class="col-sm-2 control-label"><b>NAMA PENGARANG/ PENTERJEMAH <font color="#FF0000">*</font> : </b></label>
							<div class="col-sm-10"><?php print nl2br($rs->fields['tempat']);?></div>
						</div>
					</div>

					<div class="form-group">
						<div class="row">
							<label for="nama" class="col-sm-2 control-label"><b>TARIKH TERBITAN <font color="#FF0000">*</font> : </b></label>
							<div class="col-sm-3"><?php print DisplayDate($rs->fields['tarikh']);?></div>
							<div class="col-sm-2"></div>
							<label for="nama" class="col-sm-2 control-label"><b>BAHASA <font color="#FF0000">*</font> : </b></label>
							<div class="col-sm-3">
								<?php if($rs->fields['pemantauan_jenis']=='M'){ print 'MELAYU'; }
								else if($rs->fields['pemantauan_jenis']=='A'){ print 'ARAB'; }
								else if($rs->fields['pemantauan_jenis']=='E'){ print 'ENGLISH'; }
								else if($rs->fields['pemantauan_jenis']=='C'){ print 'CHINA'; }
								else if($rs->fields['pemantauan_jenis']=='T'){ print 'TAMIL'; }
								else if($rs->fields['pemantauan_jenis']=='U'){ print 'URDU'; }
								?>
							</div>
						</div>
					</div>


					<div class="form-group">
						<div class="row">
							<label for="nama" class="col-sm-2 control-label"><b>SYARIKAT PENERBIT <font color="#FF0000">*</font> : </b></label>
							<div class="col-sm-10"><?php print nl2br($rsDet->fields['sykt_penerbit']);?></div>
						</div>
					</div>

					<div class="form-group">
						<div class="row">
							<label for="nama" class="col-sm-2 control-label"><b>SYARIKAT PENGELUAR <font color="#FF0000">*</font> : </b></label>
							<div class="col-sm-10"><?php print nl2br($rsDet->fields['sykt_pengeluar']);?></div>
						</div>
					</div>

					<div class="form-group">
						<div class="row">
							<label for="nama" class="col-sm-2 control-label"><b>SYARIKAT PENGEDAR <font color="#FF0000">*</font> : </b></label>
							<div class="col-sm-10"><?php print nl2br($rsDet->fields['sykt_pengedar']);?></div>
						</div>
					</div>

					<div class="form-group">
						<div class="row">
							<label for="nama" class="col-sm-2 control-label"><b>SYARIKAT PENCETAK <font color="#FF0000">*</font> : </b></label>
							<div class="col-sm-10"><?php print nl2br($rsDet->fields['sykt_pencetak']);?></div>
						</div>
					</div>

					<div class="form-group">
						<div class="row">
							<label for="nama" class="col-sm-2 control-label"><b>LAPORAN KAJIAN <font color="#FF0000">*</font> : </b></label>
							<div class="col-sm-10"><?php print nl2br($rs->fields['laporan_kajian']);?>
								<div style="height: 8px;">&nbsp</div>
								<?php 
		                        // $conn->debug=true;
		                        $rsImg = $conn->query("SELECT * FROM `tbl_pemantauan_upload` WHERE `pemantauan_id`='{$id}'");
		                        while(!$rsImg->EOF){
		                        ?>
		                            <!-- <a href="maklumat/pemantauan_form_view.php?lawat_id=<?=$rsImg->fields['id'];?>&files=<?=$rsImg->fields['file_name'];?>" 
		                                data-toggle="modal" data-target="#myModal" style="font-family:Arial, Helvetica, sans-serif" title="Tambah Maklumat Gambar" class="fa" data-backdrop=""> -->
		                            <img src="upload_doc/<?=$rsImg->fields['file_name'];?>" width="200px" width="200px"></a>
		                        <?php
		                            $rsImg->movenext();
		                        } ?>
							</div>
						</div>
					</div>

					<div class="form-group">
						<div class="row">
							<label for="nama" class="col-sm-2 control-label"><b>SYOR / CADANGAN <font color="#FF0000">*</font> : </b></label>
							<div class="col-sm-10"><?php print nl2br($rs->fields['syor']);?></div>
						</div>
					</div>

					<?php if($rs->fields['status_proses']==1){ 
						$rsKB = $conn->query("SELECT * FROM `tbl_pemantauan_ulasan` WHERE `pemantauan_id`='{$id}' AND `jenis_ulasan`=3");
					?>
					<div class="form-group">
						<div class="row">
							<label for="nama" class="col-sm-2 control-label"><b>ULASAN KETUA BAHAGIAN : </b></label>
							<div class="col-sm-10">
								<?php print nl2br($rsKB->fields['ulasan']); ?>
							</div>
						</div>
					</div>
					<?php } ?>
		

					<div class="modal-footer" style="padding:0px;">
						<!-- <span class="button" data-dismiss="modal" aria-label="Close">Kembali</span> -->
						<button class="button" data-dismiss="modal" aria-label="Kembali">
							<i class="fa fa-spinner" style="margin:0px;"></i> Kembali</button>
						<input type="hidden" name="progid" id="progid" value="<?php print $progid;?>" />
						<input type="hidden" name="proses" value="<?php print $proses;?>" />
					</div>
				</div>

			
			</div>
		</div>
	     
	</section>

</div>  
<script language="javascript" type="text/javascript">
//document.frm.gsasar_nama.focus();
</script>		 
