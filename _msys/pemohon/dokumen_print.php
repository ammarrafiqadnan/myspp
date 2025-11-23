<script type="text/javascript">
    window.onload = function() { window.print(); }
</script>
<?php 
$id_pemohon=isset($_REQUEST["id_pemohon"])?$_REQUEST["id_pemohon"]:"";
$doc=isset($_REQUEST["doc"])?$_REQUEST["doc"]:"";
$tmp = explode('.', $doc);
$ext = end($tmp);

//print $ext;
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
	$fileDir = "/var/www/upload/";
$filename = $fileDir.$id_pemohon."/".$doc;
file_exists($filename)or die("No File available");
header("Content-Type: application/pdf");
$fp = fopen($filename, 'rb');
fpassthru($fp);

$b64pdf = base64_encode(file_get_contents($filename));

	?>
                    <!--<embed src="<?=$b64pdf?>" type='application/pdf' width='100%' height='800px' />-->
                <?php } ?>    
		    </div>
        </div>
    </div>
</div>


