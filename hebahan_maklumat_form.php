<?php include 'connection/common.php'; ?>

<?php
	// $conn->debug=true;
	$id=isset($_REQUEST["id"])?$_REQUEST["id"]:"";
	$jenis=isset($_REQUEST["jenis"])?$_REQUEST["jenis"]:"";

	$sql3 = "SELECT * FROM $schema2.`hebahan_makluman` WHERE kod='{$id}'";
	$rs = $conn->query($sql3);

	$ext = pathinfo($rs->fields['dokumen'], PATHINFO_EXTENSION);
?>
<section id="intro" class="bg-white big-banner" style="min-height: 630px;">
        
	<div class="container pt-5" style="opacity: 0.9;">
		
		<div class="card p-5 text-md-left">
			<div class="col-lg-12">
				<section class="panel">
					<header class="panel-heading"  style="background-color:rgb(38, 167, 228)">
						<h4 class="panel-title"><font color="#000000" size="3"><b>MAKLUMAT HEBAHAN</b></font></h4>
					</header>
					<div class="panel-body">
						<div class="box-body">

						<input type="hidden" name="id" id="id" value="<?php print $id;?>" readonly="readonly"/>

							<div class="col-md-12">
								<div class="form-group">
									<div class="row">
										<label for="keterangan" class="col-sm-2 control-label"><b>Keterangan <font color="#FF0000">*</font> : </b></label>
										<div class="col-sm-10">
											<?=$rs->fields['keterangan'];?>
										</div>
									</div>
								</div>
								<br><br>
								<div class="form-group">
									<div class="row">

										<label for="tajuk" class="col-sm-2 control-label"><b>Dokumen <font color="#FF0000">*</font> : </b></label>
										<div class="col-sm-3">
											<?php if($ext=='jpg' || $ext=='gif' || $ext=='png' || $ext=='jpeg' || $ext=='PNG' || $ext == 'JPG') { ?>
												<img src="uploads_doc/<?=$rs->fields['dokumen'];?>" width="100%" height="100%"> 
											<?php } else if($ext=='pdf'){ ?>
												<embed src="uploads_doc/<?=$rs->fields['dokumen'];?>" type='application/pdf' width='100%' height='800px' />
											<?php } ?>   
										</div>
									</div>
								</div>
							</div>

						
						</div>
					</div>
					
				</section>

			</div> 
		</div>
	</div>
</section>