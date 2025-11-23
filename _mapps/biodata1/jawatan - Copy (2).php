<?php //include '../connection/common.php'; ?>
<script language="javascript">
function do_save(val1, val2){
 
}
</script>
<style type="text/css">
	.col-lg-3 {
    border: 1px solid;
}
</style>
<?php
// $conn->debug=true;

?>
		<header class="panel-heading"  style="background-color:rgb(38, 167, 228)">
			<h6 class="panel-title"><font color="#000000" size="3"><b><?php print strtoupper($menu);?></b></font></h6>
		</header>
		<div class="panel-body">
			<div class="box-body">

			<!-- <input type="hidden" name="pemantauan_id" id="pemantauan_id" value="<?php print $id;?>" readonly="readonly"/> -->

				<div class="col-md-12">

					<?php include 'biodata/biodata_view.php'; ?>

					<div class="form-group">
						<div class="row">
							<p>
							  <button class="btn btn-primary form-control" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample" title="Sila klik untuk membaca arahan berkaitan kemasukan data akademik SPM">
							    ARAHAN:
							  </button>
							</p>
							<!-- <div class="collapse" id="collapseExample"> -->
							  <div class="card card-body">
									<label for="nama" class="col-sm-12 control-label"><b>ARAHAN : Sila Masukkan 10 Matapelajaran Dengan Keputusan Terbaik</b>
										<ul>
											<li>Jumlah keseluruhan JAWATAN SPP yang dipilih mestilah tidak melebihi 3 jawatan. <br>
											** CONTOH : Jika kelayakan akademik adalah SPM, jawatan PMR + SPM + DIPLOMA = 3 jawatan sahaja.</li>
											<li>Jawatan yang dipilih adalah mengikut turutan nombor pilihan dari atas ke bawah. (Pilihan PERTAMA hingga KETIGA)</li>
										</ul>
										<hr>
									</label>

							  </div>
							<!-- </div> -->
						</div>
					</div>

					
					<div class="form-group">
						<div class="row">
							<div class="col-sm-12">
								<b>JAWATAN MAKSIMUM BERDASARKAN KELAYAKAN PEMOHON</b>
								<!-- <div style="float: right;">
									<a href="biodata/senarai_jawatan.php?id=<?=$id;?>" data-toggle="modal" data-target="#myModal" title="Paparan Maklumat Senarai Jawatan" data-backdrop="">
							          <button type="button" class="btn btn-sm btn-primary">
										!-- <span title="Kemaskini Maklumat"> -->
											<!-- Pilihan Jawatan -->
										<!-- </span> --
										</button>
									</a>
								</div> -->
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="row">
							<label for="nama" class="col-sm-2 control-label">Jawatan yang dipohon</label>
							<div class="col-sm-10">
								<table class="table" width="100%" cellpadding="5" cellspacing="0">
									<tr>
										<td width="5%">BIL</td>
										<td width="30%">SUSUNAN PILIHAN</td>
										<td width="65%">NAMA JAWATAN DIPOHON</td>
									</tr>
									<tr>
										<td align="center">1.</td>
										<td>Pilihan Pertama</td>
										<td>
											<select name="jawatan1" id="jawatan1" class="form-control select2 select2-accessible" style="width: 100%;" aria-hidden="true">
												<option value="">Sila pilih Jawatan</option>
												<?php print get_skim($conn, $data['jawatan1']); ?>
											</select>
										</td>
									</tr>
									<tr>
										<td align="center">2.</td>
										<td>Pilihan Kedua</td>
										<td>
											<select name="jawatan2" id="jawatan2" class="form-control select2 select2-accessible" style="width: 100%;" aria-hidden="true">
												<option value="">Sila pilih Jawatan</option>
												<?php print get_skim($conn, $data['jawatan2']); ?>
											</select>
										</td>
									</tr>
									<tr>
										<td align="center">3.</td>
										<td>Pilihan Ketiga</td>
										<td>
											<select name="jawatan3" id="jawatan3" class="form-control select2 select2-accessible" style="width: 100%;" aria-hidden="true">
												<option value="">Sila pilih Jawatan</option>
												<?php print get_skim($conn, $data['jawatan3']); ?>
											</select>
										</td>
									</tr>
								</table>
							</div>
						</div>
					</div>

					<hr>

<fieldset>
        <legend>Learning Experience</legend>
        <div class="row">
            <div class="col-sm-3">
                <div class="form-group">
                    <div class="row">
                        <label for="selectFrom">Options</label>
                    </div>
                    <div class="row">
                        <select name="selectFrom" id="selectFrom" class="form-control input-medium" multiple size="5">
                            <option value="1">Inpatient</option>
                            <option value="2">Outpatient</option>
                            <option value="3">Newborn</option>
                            <option value="4">Emergency / Night</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="row">&nbsp;</div>
                <div class="row">&nbsp;</div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="btn-group-vertical btn-block">
                            <button id="btnAdd" name="btnAdd" type="button" class="btn btn-primary btn-small">Add <i class="fa fa-arrow-right"></i>

                            </button>
                            <button id="btnRemove" name="btnRemove" type="button" class="btn btn-primary btn-small"><i class="fa fa-arrow-left"></i> Remove</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                    <div class="row">
                        <label for="selectTo">Selected</label>
                    </div>
                    <div class="row">
                        <select name="selectTo" id="selectTo" size="5" class="form-control input-medium">
                            <option value="1">Inpatient</option>
                            <option value="2">Outpatient</option>
                            <option value="3">Newborn</option>
                            <option value="4">Emergency / Night</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="row">&nbsp;</div>
                <div class="row">&nbsp;</div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="btn-group-vertical btn-block">
                            <button id="btnUp" name="btnUp" type="button" class="btn btn-primary btn-small"><i class="fa fa-arrow-up"></i> Up</button>
                            <button id="btnDown" name="btnDown" type="button" class="btn btn-primary btn-small"><i class="fa fa-arrow-down"></i> Down</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </fieldset>
    <hr>
					<div class="form-group">
						<div class="row">
							<label for="nama" class="col-sm-6 control-label"><b>Pusat Temu Duga / Ujian Khas yang Dipilih Bagi Jawatan SPP Sahaja<font color="#FF0000">*</font><div style="float:right">:</div></b>
								<br><font style="color: red;">Sila pastikan pilihan Pusat Temu Duga adalah terhampir dengan tempat tinggal semasa.
								<br>Sebarang perubahan/pertukaran Pusat Temu Duga tidak akan dilayan.</font>
								</label>
							<div class="col-sm-4">
								<select name="negeri_lahir_pemohon" id="negeri_lahir_pemohon" class="form-control">
									<option value="">Sila pilih Negeri</option>
									<?php print get_negeri($conn, $data['negeri_lahir_pemohon']); ?>
								</select>
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
/*global $:false */
$(document).ready(function () {
    'use strict';
    $('#btnAdd').click(function () {
        $('#selectFrom option:selected').each(function () {
            $('#selectTo').append('<option value="' + $(this).val() + '">' + $(this).text() + '</option>');
            //$(this).remove();
        });
    });
    $('#btnRemove').click(function () {
        $('#selectTo option:selected').each(function () {
            //$('#selectFrom').append('<option value="' + $(this).val() + '">' + $(this).text() + '</option>');
            $(this).remove();
        });
    });
    $('#btnUp').bind('click', function () {
        $('#selectTo option:selected').each(function () {
            var newPos = $('#selectTo option').index(this) - 1;
            if (newPos > -1) {
                $('#selectTo option').eq(newPos).before('<option value="' + $(this).val() + '" selected="selected">' + $(this).text() + '</option>');
                $(this).remove();
            }
        });
    });
    $('#btnDown').bind('click', function () {
        var countOptions = $('#selectTo option').size();
        $('#selectTo option:selected').each(function () {
            var newPos = $('#selectTo option').index(this) + 1;
            if (newPos < countOptions) {
                $('#selectTo option').eq(newPos).after('<option value="' + $(this).val() + '" selected="selected">' + $(this).text() + '</option>');
                $(this).remove();
            }
        });
    });
});
</script>		 
