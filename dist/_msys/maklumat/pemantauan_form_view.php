<?php 
// @session_start();
include '../connection/common.php'; ?>
<script type="text/javascript">
function do_close(){
    // refresh = parent.location;
    // parent.location = refresh;
    location.reload();
}
</script>
<?php 
$lawat_id=isset($_REQUEST["lawat_id"])?$_REQUEST["lawat_id"]:"";
$files=isset($_REQUEST["files"])?$_REQUEST["files"]:"";
//$id=$_SESSION['SESS_COMPID'];
?>
<input type="hidden" name="lawat_id" value="<?=$lawat_id;?>">
<div class="modal-header bg-primary">
    <h5 class="modal-title"><i class="icon-pen"></i> Dokumen Pemantauan</h5>
    <div style="float:right;margin-top:-15px"><button type="button" class="close" data-dismiss="modal">&times;</button></div>
</div>

<div class="modal-body">
    <div class="col col-md-12 well">
        <div class="form-group row">
            <img src="upload_doc/<?=$files;?>" width="100%" height="100%">
        </div>

    </div>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-danger btn-labeled btn-xlg" onclick="do_hapus('maklumat/sql_maklumat.php?frm=UPLOAD_DOC&pro=DEL&lawat_id=<?=$lawat_id;?>')"><b>
        <i class="icon-checkmark"></i></b> Hapus</button>
    <button type="button" class="btn btn-default" class="close" data-dismiss="modal">Tutup</button>
</div>


