<link href="../vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
<link href="../vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
<link href="../vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
<link href="../vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">
<script>
	function do_save(){
		var tempoh = $('#tempoh').val();

		if(tempoh.trim() == '' ){
			alert_msg('Sila pilih maklumat tempoh kawalan akaun.');
			$('#dokumen').focus(); return true;
		} else { 
			$.ajax({
				url:'pengurusan/sql_pengurusan.php?frm=PENGURUSAN&jenis=KAWALAN_TEMPOH_AKAUN&pro=SAVE',
				type:'POST',
				//dataType: 'json',
				// beforeSend: function () {
				// 	$('.btn-primary').attr("disabled","disabled");
				// 	$('.modal-body').css('opacity', '.5');
				// },
				data: $("form").serialize(),
				success: function(data){
					console.log(data);
					if(data=='OK'){
						swal({
							title: 'Berjaya',
							text: 'Maklumat telah berjaya dikemaskini',
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
<?php
    $sql3 = "SELECT * FROM $schema2.`kawalan_tempoh_akaun` WHERE kod=1";
	$rs = $conn->query($sql3);
?>
        
        <header class="panel-heading"  style="background-color:rgb(38, 167, 228)">
            <h6 class="panel-title"><font color="#000000" size="3"><b><?php print strtoupper($menu);?></b></font></h6>
        </header>

		<div class="box" style="background-color:#F2F2F2">
            <div class="panel-body">
                <div class="box-body">
                
                    <input type="hidden" name="kod" id="kod" value="<?php if(!empty($cgpa_kod)){ print $rs->fields['kod']; }?>"/>

                    <div class="col-md-12">

                        <div class="form-group">
                            <div class="row">
                                <label for="tajuk" class="col-sm-3 control-label"><b>Tempoh (Tahun) <font color="#FF0000">*</font> : </b></label>
                                <div class="col-sm-3">
                                    <select name="tempoh" id="tempoh" class="form-control">
                                        <option value="">Sila pilih</option>
                                        <?php for($i=1; $i<=10; $i++){ ?>
                                            <option value="<?=$i;?>" <?php if($rs->fields['tempoh'] == $i){ print 'selected';}?>><?=$i;?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
						<div class="form-group">
                            <div class="row">
								<div class="col-md-3"></div>
                                <div class="col-sm-9">
									<small style="color: red">Tempoh ini dikira bermula pada tarikh kemaskini maklumat pemohon atau tarikh permohonan (sekiranya tiada tarikh kemaskini)</small>
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
		</div>
     </div>
  </div>    

          