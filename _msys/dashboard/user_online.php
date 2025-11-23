<?php
include_once("../../connection/common.php");
//$conn->debug=true;
$sql = "SELECT B.`nama`, B.`MyID` FROM $schema2.`user_log` A, $schema2.`myid` B WHERE A.`id_pemohon`=B.`id_pemohon`";
$rsk = $conn->query($sql);
$bil=0;
?>
<div class="modal-header" style="background-color:">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" title="Tutup paparan">
    <img src="images/close-button.png" width="30" height="30" title="Tutup paparan" />
    </button>
    <h4 class="modal-title">SENARAI PEMOHON DALAM TALIAN</h4>
</div>
<div class="modal-body">
    <div class="box-body">

        <div class="form-group">
        	<table class="table" cellpadding="5" cellspacing="0" border="1">
        		<tr style="background-color: #ccc;">
        			<td width="5%"><b>Bil</b></td>
        			<td width="70%"><b>Nama Pemohon</b></td>
        			<td width="25%"><b>No. Kad Pengenalan</b></td>
        		</tr>
        		<?php while(!$rsk->EOF){ $bil++; ?>
        		<tr>	
        			<td><?=$bil;?></td>
        			<td><?php print $rsk->fields['nama'];?></td>
        			<td><?php print $rsk->fields['MyID'];?></td>

        		</tr>
        		<?php $rsk->movenext(); } ?>
        	</table>
        </div>

    </div>

</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default"  data-dismiss="modal" aria-hidden="true">Kembali</button>
</div>
