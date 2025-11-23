<div class="col-lg-12">
	<section class="panel">
		<header class="panel-heading"  style="background-color:rgb(38, 167, 228)">
            <!-- <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="do_close()">×</button> -->
			<h6 class="panel-title"><font color="#000000" size="3"><b>Housekeeping</b></font></h6>
		</header>
		<div class="panel-body">
			<div class="box-body">

			<input type="hidden" name="id" id="id" value="<?php print $id;?>" readonly="readonly"/>

				<div class="col-md-12">
					<div class="form-group">
						<div class="row">
                            <label for="tahun" class="col-sm-2 control-label"><b>Tahun <font color="#FF0000">*</font> : </b></label>
							<div class="col-sm-3">
                                <select name="tahun" id="tahun" class="form-control">
                                    <option value="">Sila pilih tahun</option>
                                    <option value="">1</option>
                                    <option value="">2</option>
                                    <option value="">3</option>
                                    <option value="">4</option>
                                    <option value="">5</option>
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