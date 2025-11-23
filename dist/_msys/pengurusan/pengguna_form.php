<div class="col-lg-12">
	<section class="panel">
		<header class="panel-heading"  style="background-color:rgb(38, 167, 228)">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="do_close()">×</button>
			<h6 class="panel-title"><font color="#000000" size="3"><b>TAMBAH MAKLUMAT PENGGUNA</b></font></h6>
		</header>
		<div class="panel-body">
			<div class="box-body">

			<input type="hidden" name="id" id="id" value="<?php print $id;?>" readonly="readonly"/>

				<div class="col-md-12">

					<div class="form-group">
						<div class="row">
							<label for="nama" class="col-sm-2 control-label"><b>ID Pengguna <font color="#FF0000">*</font> : </b></label>
							<div class="col-sm-3">
								<input type="text" name="id_pengguna" id="id_pengguna" class="form-control" value="">
							</div>
						</div>
					</div>

                    <div class="form-group">
						<div class="row">
							<label for="nama" class="col-sm-2 control-label"><b>Nama Penuh<font color="#FF0000">*</font> : </b></label>
							<div class="col-sm-10">
								<input type="text" name="nama_penuh" id="nama_penuh" class="form-control" value="">
							</div>
						</div>
					</div>

					<div class="form-group">
						<div class="row">
							<label for="nama" class="col-sm-2 control-label"><b>No. K/P <font color="#FF0000">*</font> : </b></label>
							<div class="col-sm-3">
								<input type="text" name="noKP" id="noKP" class="form-control" value="">
							</div>
							<label for="nama" class="col-sm-2 control-label"><b>Emel <font color="#FF0000">*</font> : </b></label>
							<div class="col-sm-5">
								<input type="email" name="email" id="email" class="form-control" value="">
							</div>
						</div>
					</div>

                    <div class="form-group">
						<div class="row">
							<label for="nama" class="col-sm-2 control-label"><b>Bahagian <font color="#FF0000">*</font> : </b></label>
							<div class="col-sm-3">
                                <select name="bahagian" id="bahagian" class="form-control">
									<option value="">Sila pilih bahagian</option>
								</select>
							</div>
							<label for="nama" class="col-sm-2 control-label"><b>Jawatan <font color="#FF0000">*</font> : </b></label>
							<div class="col-sm-3">
                                <select name="jawatan" id="jawatan" class="form-control">
									<option value="">Sila pilih jawatan</option>
								</select>
							</div>
						</div>
					</div>

                    <div class="form-group">
						<div class="row">
							<label for="nama" class="col-sm-2 control-label"><b>No. Tel <font color="#FF0000">*</font> : </b></label>
							<div class="col-sm-3">
								<input type="text" name="no_tel" id="no_tel" class="form-control" value="">
							</div>
							<label for="nama" class="col-sm-2 control-label"><b>Peranan <font color="#FF0000">*</font> : </b></label>
							<div class="col-sm-3">
                                <select name="peranan" id="peranan" class="form-control">
									<option value="">Sila pilih peranan</option>
									<option value="">Pentadbir/Admin</option>
									<option value="">Pengurusan</option>
									<option value="">Meja Bantu (Helpdesk)</option>

								</select>
							</div>

						</div>
					</div>

                    <div class="form-group">
						<div class="row">
							<label for="nama" class="col-sm-2 control-label"><b>Status <font color="#FF0000">*</font> : </b></label>
							<div class="col-sm-3">
                                <select name="status" id="status" class="form-control">
									<option value="">Sila pilih status</option>
									<option value="">Aktif</option>
									<option value="">Tidak Aktif</option>
								</select>
							</div>
						</div>
					</div>

					<div class="form-group">
						<div class="row">
							<label for="nama" class="col-sm-2 control-label"><b>Capaian <font color="#FF0000">*</font> : </b></label>
							<div class="col-sm-3">
								<input type="checkbox"> Dashboard
							</div>
							<div class="col-sm-3">
								<input type="checkbox"> Senarai Pemohon Temuduga
							</div>
							<div class="col-sm-3">
								<input type="checkbox"> Senarai Pemohon Rayuan
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="row">
							<label for="nama" class="col-sm-2 control-label"></label>
							
							<div class="col-sm-3">
								<input type="checkbox"> Senarai Pemohon
								<br>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox">	Draf <br>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox">	Hantar
							</div>
							<div class="col-sm-3">
								<input type="checkbox"> Pengurusan
								<br>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox">	Senarai Pengguna
								<br>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox">	Kandungan Surat
								<br>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox">	Hebahan dan Maklumat
								<br>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox">	FAQ
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