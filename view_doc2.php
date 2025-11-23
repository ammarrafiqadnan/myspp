<?php 
$doc=isset($_REQUEST["doc"])?$_REQUEST["doc"]:"";
$applicant_id=isset($_REQUEST["applicant_id"])?$_REQUEST["applicant_id"]:"";

$ext = pathinfo($doc, PATHINFO_EXTENSION);
//print "ex:".$ext;
if(!empty($applicant_id)){ 
	$jfiles="uploads_doc/".$applicant_id."/".$doc;
} else {
	$jfiles="../uploads_doc/".$doc;
}
// Send the file to the browser.

//print "DD".$applicant_id.":".$doc.":".filesize($jfiles);
//print "<br>".$ext;
?>
<div class="modal-header bg-primary">
    <h5 class="modal-title"><i class="icon-pen"></i> Paparan Dokumen</h5>
    <div style="float:right;margin-top:-15px"><button type="button" class="close" data-dismiss="modal">&times;</button></div>
</div>

<div class="modal-body">
    <div class="col col-md-12 well">
        <div class="form-group row">
            <div class="col-sm-12">
		<?php if($ext=='jpg' || $ext=='gif' || $ext=='png' || $ext=='jpeg' || $ext=='PNG' || $ext == 'JPG') { ?>
                	<img src="<?=$jfiles;?>" width="100%" height="100%"> 
	        <?php } else if($ext=='pdf'){ ?>
			<embed src="<?=$jfiles;?>" type='application/pdf' width='100%' height='800px' />
		<?php } ?>    
		</div>
        </div>

    </div>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-default" class="close" data-dismiss="modal">Tutup</button>
</div>
