<?php include '../connection/common.php'; //$conn->debug=true; ?>
<script type="text/javascript">
    window.onload = function() { window.print(); }
</script>
<?php 
$id_pemohon=isset($_REQUEST["id_pemohon"])?$_REQUEST["id_pemohon"]:"";
// $doc=isset($_REQUEST["doc"])?$_REQUEST["doc"]:"";


//print $ext;
?>
    <!-- <div class="modal-title"><i class="icon-pen"></i> Paparan Dokumen</div> -->

                
    <?php
        $sql = "SELECT * FROM $schema2.`calon_sijil` WHERE id_pemohon=".tosql($id_pemohon);
        $rsData = $conn->query($sql);

        while(!$rsData->EOF){ 
            $tmp = explode('.', $rsData->fields['sijil_nama']);
            $ext = end($tmp);

    ?>
        <?php if($ext=='jpg' || $ext=='gif' || $ext=='png' || $ext=='jpeg' || $ext=='PNG' || $ext == 'JPG' || $ext == 'JPEG' || $ext == 'GIF') { ?>
            <img src="../uploads_doc/<?=$id_pemohon?>/<?=$rsData->fields['sijil_nama'];?>" width="100%" height="100%"> 
        <?php } else if($ext=='pdf'){ ?>
            <embed src="../uploads_doc/<?=$id_pemohon?>/<?=$rsData->fields['sijil_nama'];?>" type='application/pdf' width='100%' height='800px' />
        <?php } ?>  
    <?php 
    $rsData->movenext(); } ?>
                        
                      


