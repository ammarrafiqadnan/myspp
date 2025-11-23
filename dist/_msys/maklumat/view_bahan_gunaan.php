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
			<h6 class="panel-title"><font color="#000000" size="3"><b>MAKLUMAT PEMANTAUAN - <i style="color:#f00"><?=$status;?></i></b></font></h6>
		</header>
		<div class="panel-body">
			<div class="box-body">

			<input type="hidden" name="pemantauan_id" id="pemantauan_id" value="<?php print $id;?>" readonly="readonly"/>

				<div class="col-md-12">

					<div class="form-group">
						<div class="row">
							<label for="nama" class="col-sm-2 control-label"><b>KATEGORI PEMANTAUAN <font color="#FF0000">*</font> : </b></label>
							<div class="col-sm-10">
								<b><?php print dlookup("`_ref_kategori_sub`","subkat_nama","subkat_id='{$jenis}'"); ?></b>
							</div>
						</div>
					</div>

					<div class="form-group">
						<div class="row">
							<label for="nama" class="col-sm-2 control-label"><b>NAMA BARANG <font color="#FF0000">*</font> : </b></label>
							<div class="col-sm-10"><?php print $rs->fields['tajuk'];?></div>
						</div>
					</div>

					<div class="form-group">
						<div class="row">
							<label for="nama" class="col-sm-2 control-label"><b>JENIS/ MATERIAL <font color="#FF0000">*</font> : </b></label>
							<div class="col-sm-10"><?php print $rs->fields['material'];?></div>
						</div>
					</div>

					<div class="form-group">
						<div class="row">
							<label for="nama" class="col-sm-2 control-label"><b>LOKASI/TEMPAT <font color="#FF0000">*</font> : </b></label>
							<div class="col-sm-10"><?php print nl2br($rs->fields['tempat']);?></div>
						</div>
					</div>

					<div class="form-group">
						<div class="row">
							<label for="nama" class="col-sm-2 control-label"><b>SYARIKAT PENGELUAR <font color="#FF0000">*</font> : </b></label>
							<div class="col-sm-10"><?php print nl2br($rs->fields['pegawai']);?></div>
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

					<?php if($rs->fields['status_proses']>=3){
						$rsKB = $conn->query("SELECT * FROM `tbl_pemantauan_ulasan` WHERE `pemantauan_id`='{$id}' AND `jenis_ulasan`=3");
					?>
					<div class="form-group">
						<div class="row">
							<label for="nama" class="col-sm-2 control-label"><b>ULASAN KETUA BAHAGIAN <font color="#FF0000">*</font> : </b></label>
							<div class="col-sm-10"><?php print nl2br($rsKB->fields['ulasan']); ?></div>
						</div>
					</div>
					<?php } ?>
					

					<?php if($rs->fields['status_proses']>=5){
						$rsKB = $conn->query("SELECT * FROM `tbl_pemantauan_ulasan` WHERE `pemantauan_id`='{$id}' AND `jenis_ulasan`=5");
					?>
					<div class="form-group">
						<div class="row">
							<label for="nama" class="col-sm-2 control-label"><b>ULASAN TIMBALAN PENGARAH <font color="#FF0000">*</font> : </b></label>
							<div class="col-sm-10"><?php print nl2br($rsKB->fields['ulasan']); ?></div>
						</div>
					</div>
					<?php } ?>

					<?php if($rs->fields['status_proses']>=7){
						$rsKB = $conn->query("SELECT * FROM `tbl_pemantauan_ulasan` WHERE `pemantauan_id`='{$id}' AND `jenis_ulasan`=7");
					?>
					<div class="form-group">
						<div class="row">
							<label for="nama" class="col-sm-2 control-label"><b>ULASAN PENGARAH JAWI <font color="#FF0000">*</font> : </b></label>
							<div class="col-sm-10"><?php print nl2br($rsKB->fields['ulasan']); ?></div>
						</div>
					</div>
					<?php } ?>
					<!-- <div class="form-group">
						<div class="row">
							<label for="nama" class="col-sm-2 control-label"><b>STATUS : </b></label>
							<div class="col-sm-10">
								
							</div>
						</div>
					</div> -->
		

					<div class="modal-footer" style="padding:0px;">
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
