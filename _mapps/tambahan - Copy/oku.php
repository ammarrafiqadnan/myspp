<?php //include '../connection/common.php'; ?>
<?php

?>
		<div class="box" style="background-color:#F2F2F2">
      		<div class="box-body">
				<div class="x_panel" style="background-color:#F2F2F2">
					<header class="panel-heading"  style="background-color:rgb(38, 167, 228)">
						<div class="panel-actions"></div>
						<h6 class="panel-title"><font color="#000000"><b><?=strtoupper($menu);?></b></font></h6> 
					</header>
				</div>
				<!-- <div class="form-group">
						<div class="row">
							<div class="col-sm-12">
							<label for="nama" class="col-sm-12 control-label"><b>ARAHAN : </b>
								<ul>
									<li>Ruangan ini hanya diisi oleh pemohon yang memohon jawatan di bawah Klasifikasi Perkhidmatan Bakat dan Seni.</li>
									<li>Sila pilih bakat yang paling mahir.</li>
								</ul>
							</label>
						</div>
						</div>
					</div> -->
      		</div>            
		</div>
		<br>
		<header class="panel-heading"  style="background-color:rgb(38, 167, 228)">
			<h6 class="panel-title"><font color="#000000" size="3"><b>Penerima Bantuan</b></font></h6>
		</header>
		<div class="panel-body">
			<div class="box-body">

			<input type="hidden" name="pemantauan_id" id="pemantauan_id" value="<?php print $id;?>" readonly="readonly"/>

				<div class="col-md-12">

					<?php include 'biodata/biodata_view.php'; ?>

					<div class="form-group">
						<div class="row">
							<label for="nama" class="col-sm-12 control-label"><b>ARAHAN : </b>
								<ul>
									<li>Isikan sekiranya ibu/bapa/pemohon menerima bantuan Program Kesejahteraan Rakyat / Bantuan Kebajikan Masyarakat / Program Perumahan Rakyat.</li>
								</ul>
							</label>
						</div>
					</div>
					<hr>

					
					<div class="form-group">
						<div class="row">
							<label for="nama" class="col-sm-2 control-label"><b>Jenis Bantuan <font color="#FF0000">*</font><div style="float:right">:</div></b></label>
							<div class="col-sm-8">
								<select name="" id="" class="form-control">
									<option>Sila pilih</option>
									<option>BANTUAN KEBAJIKAN MASYARAKAT</option>
									<option>BANTUAN KESEJAHTERAAN RAKYAT</option>
								</select>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="row">
							<label for="nama" class="col-sm-2 control-label"><b>No.Pendaftaran / Rujukan <font color="#FF0000">*</font><div style="float:right">:</div></b></label>
							<div class="col-sm-4">
								<input type="text" name="" class="form-control" value="">
							</div>
						</div>
					</div>
					
					
				</div>

			
			</div>
		</div>


		<br>
		<header class="panel-heading"  style="background-color:rgb(38, 167, 228)">
			<h6 class="panel-title"><font color="#000000" size="3"><b>Kurang Upaya</b></font></h6>
		</header>
		<div class="panel-body">
			<div class="box-body">

			<input type="hidden" name="pemantauan_id" id="pemantauan_id" value="<?php print $id;?>" readonly="readonly"/>

				<div class="col-md-12">

					<?php //include 'biodata/biodata_view.php'; ?>

					<div class="form-group">
						<div class="row">
							<label for="nama" class="col-sm-12 control-label"><b>ARAHAN : </b>
								<ul>
									<li>Untuk diisi oleh Orang Kurang Upaya (OKU) sahaja.</li>
								</ul>
							</label>
						</div>
					</div>
					<hr>

					
					<div class="form-group">
						<div class="row">
							<label for="nama" class="col-sm-2 control-label"><b>Jenis Kurang Upaya  <font color="#FF0000">*</font><div style="float:right">:</div></b></label>
							<div class="col-sm-8">
								<select name="" id="" class="form-control">
									<option>Sila pilih</option>
									<option>KURANG UPAYA FIZIKAL</option>
									<option>KURANG UPAYA MASALAH PEMBELAJARAN</option>
								</select>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="row">
							<label for="nama" class="col-sm-2 control-label"><b>No.Pendaftaran / Rujukan <font color="#FF0000">*</font><div style="float:right">:</div></b></label>
							<div class="col-sm-4">
								<input type="text" name="" class="form-control" value="">
							</div>
						</div>
					</div>
					
					
					<div class="modal-footer" style="padding:0px;">
						<button type="button" id="simpan" class="btn btn-primary mt-sm mb-sm" onclick="do_save('SAVE','')"><i class="fa fa-save"></i> Simpan</button>
						&nbsp;
						<!-- <button type="button" id="simpan_next" class="btn btn-success mt-sm mb-sm" onclick="do_save('SAVE','SEND')"><i class="fa fa-save"></i> Simpan & Hantar</button>
						&nbsp; -->
						<button type="button" class="btn btn-default" onclick="do_page('index.php?data=<?php print base64_encode('maklumat/pemantauan_list;DATA;Maklumat Pemantauan;;;;'); ?>')">
							<i class="fa fa-spinner" style="margin:0px;"></i> Kembali</button>
						<input type="hidden" name="progid" id="progid" value="<?php print $progid;?>" />
						<input type="hidden" name="proses" value="<?php print $proses;?>" />
					</div>
				</div>

			
			</div>
		</div>
	     

<script language="javascript" type="text/javascript">
//document.frm.gsasar_nama.focus();
</script>		 
