<div class="col-lg-12">
	<section class="panel">
		<header class="panel-heading"  style="background-color:rgb(38, 167, 228)">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="do_close()">×</button>
			<h6 class="panel-title"><font color="#000000" size="3"><b>TAMBAH MAKLUMAT SURAT</b></font></h6>
		</header>
		<div class="panel-body">
			<div class="box-body">

			<input type="hidden" name="id" id="id" value="<?php print $id;?>" readonly="readonly"/>

				<div class="col-md-12">
                    <div class="form-group">
						<div class="row">
							<label for="nama" class="col-sm-2 control-label"><b>Jenis Surat <font color="#FF0000">*</font> : </b></label>
							<div class="col-sm-3">
                                <select name="jenis_surat" id="jenis_surat" class="form-control">
									<option value="">Sila pilih jenis surat</option>
									<option value="">Panggilan Temuduga</option>
                                    <option value="">Keputusan Temuduga</option>
                                    <option value="">Tawaran Jawatan</option>
								</select>
							</div>
						</div>
					</div>

                    <div class="form-group">
						<div class="row">
							<label for="tajuk" class="col-sm-2 control-label"><b>Tajuk <font color="#FF0000">*</font> : </b></label>
							<div class="col-sm-10">
								<input type="text" name="tajuk" id="tajuk" class="form-control" value="">
							</div>
						</div>
					</div>

                    <div class="form-group">
						<div class="row">
							<label for="tajuk" class="col-sm-2 control-label"><b>Keterangan <font color="#FF0000">*</font> : </b></label>
							<div class="col-sm-10">
								<textarea type="text" name="keterangan" id="keterangan" class="form-control" value="" style="height: 450px;"></textarea>
							</div>
						</div>
					</div>

                    <div class="form-group">
						<div class="row">
							<label for="nama" class="col-sm-2 control-label"><b>Status <font color="#FF0000">*</font> : </b></label>
							<div class="col-sm-4">
                                <select name="status" id="status" class="form-control">
									<option value="">Sila pilih status</option>
									<option value="">Aktif</option>
									<option value="">Tidak Aktif</option>
								</select>
							</div>
						</div>
					</div>

					<div class="modal-footer" style="padding:0px;">
						<button type="button" class="btn btn-primary mt-sm mb-sm" onclick="do_save()"><i class="fa fa-save"></i> Simpan</button>
						&nbsp;
						<button type="button" class="btn btn-default" onclick="do_close()"><i class="fa fa-spinner" style="margin:0px;"></i> Kembali</button>
					</div>
				</div>

			
			</div>
		</div>
	     
	</section>

</div> 

<script>
    function do_close(){
        reload = window.location; 
        window.location = reload;
    }
</script>