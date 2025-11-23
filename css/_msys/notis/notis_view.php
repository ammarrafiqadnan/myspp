<?php include '../connection/common.php'; ?>
<script language="javascript">
function do_close(){
	reload = window.location; 
	window.location = reload;
}

</script>
<?php
$ids=isset($_REQUEST["id"])?$_REQUEST["id"]:"";
//print "ID:".$ids;
$sql = "SELECT * FROM `tbl_notis` WHERE id=".tosql($ids);
$rsk = $conn->query($sql);
$rs = $conn->query("SELECT A.`tajuk`, A.`create_dt`, B.`subkat_nama` FROM tbl_pemantauan A, _ref_kategori_sub B 
	WHERE A.`pemantauan_type`=B.`subkat_id` AND A.`pemantauan_id`=".tosql($rsk->fields['pemantauan_id']));

$conn->execute("UPDATE `tbl_notis` SET `is_read`=1 WHERE `id`=".tosql($ids));

?>
<div class="col-lg-12">
<section class="panel">
    <header class="panel-heading"  style="background-color:rgb(38, 167, 228)">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="do_close()">X</button>
        <h6 class="panel-title"><font color="#000000" size="3"><b>MAKLUMAT NOTIS</b></font></h6>
    </header>
    <div class="panel-body">
        <div class="box-body">
        
            <div class="col-md-12">
            

            <div class="form-group">
              <div class="row">
                <label for="agensi_nama" class="col-sm-3 control-label"><b>MAKLUMAT PEMANTAUAN : </b></label>
                <div class="col-sm-9">
                	<?php print $rs->fields['subkat_nama'];?><br>
                	Tajuk : <?php print $rs->fields['tajuk'];?><br>	
                	Tarikh Laporan : <?php print DisplayDate($rs->fields['create_dt']);?> <?php print DisplayTime($rs->fields['create_dt']);?>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="row">
                <label for="agensi_status" class="col-sm-3 control-label"><b>NOTIS : </b></label>
                <div class="col-sm-9"><?php print $rsk->fields['message'];?></div>
               </div>
            </div>

    
            <div class="modal-footer" style="padding:0px;">
                <button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true" onclick="do_close()"><i class="fa fa-spinner"></i> Kembali</button>
                <input type="hidden" name="proses" value="<?php print $proses;?>" />
            </div>
        </div>
		</div>
  </div>
     
</section>

</div> 
