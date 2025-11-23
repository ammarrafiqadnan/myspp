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
<div class="modal-header bg-primary">
    <h5 class="modal-title"><i class="icon-pen"></i> Paparan Dokumen <?=$doc;?></h5>
</div>

<!-- <div class="pull-left">
    <h4 style="margin-left: 30px; color: #336699; font-family: Arial;">Makanan Haiwan / Makanan Tambahan Haiwan</h4>
</div> -->

<div class="modal-body">
    <div class="col col-md-12 well">
        <div class="form-group row">
            <div class="col-sm-12">
                <?php if($ext=='jpg' || $ext=='gif' || $ext=='png' || $ext=='jpeg' || $ext=='PNG' || $ext == 'JPG' || $ext == 'JPEG' || $ext == 'GIF') { ?>
                            <img src="../uploads_doc/<?=$id_pemohon?>/<?=$doc;?>" width="100%" height="100%"> 
                    <?php } else if($ext=='pdf'){ ?>
                    <embed src="../uploads_doc/<?=$id_pemohon?>/<?=$doc;?>" type='application/pdf' width='100%' height='800px' />
                <?php } ?>    
		    </div>
        </div>
    </div>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-default" class="close" data-dismiss="modal">Tutup</button>
</div>


