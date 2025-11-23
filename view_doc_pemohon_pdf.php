<?php 
$id_pemohon=isset($_REQUEST["id_pemohon"])?$_REQUEST["id_pemohon"]:"";
$doc=isset($_REQUEST["doc"])?$_REQUEST["doc"]:"";
$tmp = explode('.', $doc);
$ext = end($tmp);

//print $ext;
?>
<!--
<div class="modal-header bg-primary">
    <h5 class="modal-title"><i class="icon-pen"></i> Paparan Dokumen</h5>
    <div style="float:right;margin-top:-15px"><button type="button" class="close" data-dismiss="modal">&times;</button></div>
</div>
-->
<!-- <div class="pull-left">
    <h4 style="margin-left: 30px; color: #336699; font-family: Arial;">Makanan Haiwan / Makanan Tambahan Haiwan</h4>
</div> -->

<?php
?>
<div class="modal-body">
    <div class="col col-md-12 well">
        <div class="form-group row">
            <div class="col-sm-12">
                <?php if($ext=='jpg' || $ext=='gif' || $ext=='png' || $ext=='jpeg' || $ext=='PNG' || $ext == 'JPG' || $ext == 'JPEG' || $ext == 'GIF') { 

		$sijil_pic1 = "/var/www/upload/".$id_pemohon."/".$doc; 
 		//print $sijil;
		if (file_exists($sijil_pic1)){
    			$b64image = base64_encode(file_get_contents($sijil_pic1));
     			$sijil1 = "data:image/png;base64,$b64image";
		}
		?>
                       <img src="<?=$sijil1;?>" width="100%" height="100%"> 
                <?php } else if($ext=='pdf'){ 
//print "PDF";
$fileDir = "/var/www/upload/";
$filename = $fileDir.$id_pemohon."/".$doc;
file_exists($filename)or die("No File available");

//header("Content-Type: application/pdf");
$fp = fopen($filename, 'rb');
//fpassthru($fp);

//header("Content-type: application/pdf");
//header("Content-Length: " . filesize($filename));
// Send the file to the browser.
//readfile($filename);

?>		<div>
                    <!--<embed src="<?=$filename;?>" type='application/pdf' width='100%' height='800px' />-->
		<!--<object data="<?=fpassthru($fp);?>" type="application/pdf" width="500px" height="300px">-->
        	</div>     
	<?php } ?>    
		    </div>
        </div>
    </div>
</div>
<!--
<div class="modal-footer">
    <button type="button" class="btn btn-default" class="close" data-dismiss="modal">Tutup</button>
</div>
-->

