<?php 
include 'connection/common_log.php';
$doc=isset($_REQUEST["doc"])?$_REQUEST["doc"]:"";
$applicant_id=isset($_REQUEST["applicant_id"])?$_REQUEST["applicant_id"]:"";
// Send the file to the browser.

//print "DD".$applicant_id.":".$doc.":".filesize($jfiles);
//print "<br>".$ext;
?>
<div class="modal-header bg-primary">
    <h5 class="modal-title"><i class="icon-pen"></i><b>SENARAI UJIAN YANG DIJAJARKAN DENGAN CEFR MENGIKUT PEKELILING SURAT - KPM.100.-1/3/2 JLD.2 (50)</b></h5>
    <div style="float:right;margin-top:-15px"><button type="button" class="close" data-dismiss="modal">&times;</button></div>
</div>

<div class="modal-body">
    <div class="col col-md-12 well">
        <div class="form-group row">
            <div class="col-sm-12">
            		
            	<table width="100%" class="table" border="1" cellpadding="5" cellspacing="0">
            		<tr>
            			<td width="10%" align="center"><b>BIL</b></td>
            			<td width="45%" align="center"><b>JENIS UJIAN</b></td>
            			<td width="15%" align="center"><b>BAND</b></td>
            			<td width="15%" align="center"><b>GRED</b></td>
            			<td width="15%" align="center"><b>TAHAP CEFR</b></td>
            		</tr>
            		<?php
            		$bil=0;
            		$rsData = $conn->query("SELECT * FROM $schema1.`ref_jenis_peperiksaanBI` WHERE `status`=0 AND `is_deleted`=0");
            		while(!$rsData->EOF){ $bil++;
            			$rdDet = $conn->query("SELECT * FROM $schema1.`padanan_jenisPeperiksaan_keputusan` WHERE kod_jenis_peperiksaan=".tosql($rsData->fields['kod']));
            			$cnt=$rdDet->recordcount(); $bilr=0;
            			while(!$rdDet->EOF){ 
            			if($bilr==0){
            		?>
	            		<tr>
	            			<td align="center" rowspan="<?=$cnt;?>"><?=$bil;?></td>
	            			<td align="center" rowspan="<?=$cnt;?>"><?=$rsData->fields['diskripsi'];?></td>
	            			<td align="center" <?php if(empty($rdDet->fields['band'])){ print 'bgcolor="#000"';} ?>><?=$rdDet->fields['band'];?></td>
	            			<td align="center" <?php if(empty($rdDet->fields['gred'])){ print 'bgcolor="#000"';} ?>><?=$rdDet->fields['gred'];?></td>
	            			<td align="center" <?php if(empty($rdDet->fields['cefr'])){ print 'bgcolor="#000"';} ?>><?=$rdDet->fields['cefr'];?></td>
	            		</tr>
            		<?php } else { ?>
	            		<tr>
	            			<td align="center" <?php if(empty($rdDet->fields['band'])){ print 'bgcolor="#000"';} ?>><?=$rdDet->fields['band'];?></td>
	            			<td align="center" <?php if(empty($rdDet->fields['gred'])){ print 'bgcolor="#000"';} ?>><?=$rdDet->fields['gred'];?></td>
	            			<td align="center" <?php if(empty($rdDet->fields['cefr'])){ print 'bgcolor="#000"';} ?>><?=$rdDet->fields['cefr'];?></td>
	            		</tr>
            		<?php }
            			$bilr++;	
            			$rdDet->movenext(); }
            		$rsData->movenext(); } ?>
            	</table>
			</div>
        </div>

    </div>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-default" class="close" data-dismiss="modal">Tutup</button>
</div>
