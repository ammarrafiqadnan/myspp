					<div class="form-group">
						<div class="row">
							<div class="col-md-8">
								<div class="row">
									<label for="nama" class="col-sm-4 control-label"><b>MyID (No. Kad Pengenalan)<div style="float:right">:</div></b></label>
									<div class="col-sm-8"><b><?php print strtoupper($_SESSION['SESS_UIC']);?></b></div>
								</div>
								<div class="row">
									<label for="nama" class="col-sm-4 control-label"><b>Nama Penuh<div style="float:right">:</div></b></label>
									<div class="col-sm-8"><b><?php print strtoupper($_SESSION['SESS_UNAME']);?></b></div>
								</div>
							</div>
							<div class="col-md-4 visible-lg visible-md">
		                        <div class="col-sm-12" align="center" style="margin-top: -10px;">
		                            <img src="<?=$gambar;?>" width="60" height="60">
		                        </div>
		                    </div>
						</div>
					</div>
					<div class="form-group">
					</div>
					<!-- <hr> -->
