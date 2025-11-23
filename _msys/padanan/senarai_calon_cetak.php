<?php include '../../connection/common.php'; ?>
<script language="javascript">

</script>

<?php
//$conn->debug=true;
$mp=isset($_REQUEST["mp"])?$_REQUEST["mp"]:"";
$kl=isset($_REQUEST["kl"])?$_REQUEST["kl"]:"";
$bdg=isset($_REQUEST["bdg"])?$_REQUEST["bdg"]:"";

$jbil=0;
$rsC = $conn->query("SELECT A.`id` AS id_klu, A.kod_pengkhususan AS PKOD, B.*  
	FROM $schema1.`ref_padanan_kluster` A, $schema1.`padanan_institusi_pengkhususan` B 
        WHERE A.`kod_pengkhususan`=B.`kod` AND A.`is_deleted`=0 AND A.`kod_kluster`=".tosql($kl)." 
	AND A.is_deleted=0 AND A.`kod_mpelajaran`=".tosql($mp)." AND A.`kod_bidang`=".tosql($bdg));

while(!$rsC->EOF){ $jbil++; 
	if($jbil==1){ $pkod= "'".$rsC->fields['kod_pengkhususan']."'"; }
	else { $pkod .= ",'".$rsC->fields['kod_pengkhususan']."'"; }	
	$rsC->movenext(); 
}

$sql = "SELECT C.nama_penuh, C.ICNo, C.negeri, C.`id_pemohon` FROM $schema2.`calon_ipt` A, $schema1.`padanan_institusi_pengkhususan` B, $schema2.`calon` C  
WHERE A.`pengkhususan`=B.`kod` AND A.`id_pemohon`=C.`id_pemohon` AND B.`kod_pengkhususan` IN ($pkod)";
$rsJK = $conn->query($sql);
$bil=0;
?>
<div class="col-lg-12">
	<section class="panel">
		<div class="panel-body">
			<div class="box-body">
				<div class="form-group">
					<div class="row">
						Kluster : <?php print dlookup("$schema1.`ref_kluster_main`","diskripsi","kod=".tosql($kl));?>
					</div>
				</div>
				<div class="form-group">
					<div class="row">
						Mata Pelajaran : <?php print dlookup("$schema1.`ref_kluster`","diskripsi","kod=".tosql($mp));?>
					</div>
				</div>

				<div class="form-group">
					<div class="row">
						Bidang : <?php print dlookup("$schema1.`ref_bidang`","diskripsi","kod=".tosql($bdg));?>
					</div>
				</div>

				<div class="col-md-12">
        		            <div class="form-group">
					<div class="row">
						<table width="100%" cellpadding="5" cellspacing="0" border="1" class="table">
							<thead>
							<tr>
								<th width="5%"><b>Bil</b></th>
								<th width="15%"><b>Nama</b></th>
								<th width="10%"><b>No. Kad Pengenalan</b></th>
								<th width="10%"><b>Negeri</b></th>
								<th width="20%"><b>IPT 1</b></th>
								<th width="20%"><b>IPT 2</b></th>
								<th width="20%"><b>IPT 3</b></th>
							</tr>
							</thead>
							<tbody>
							<?php while(!$rsJK->EOF){ $bil++;
							//$conn->debug=true;
							$rs1 = $conn->query("SELECT B.`DISKRIPSI`, D.`DISKRIPSI` AS matapelajaran 
								FROM spp_calon.`calon_ipt` A, spp_ref.`ref_institusi` B, spp_ref.`padanan_institusi_pengkhususan` C, spp_ref.`ref_pengkhususan` D  
								WHERE A.`inst_keluar_sijil`=B.`KOD` AND A.`pengkhususan`=C.`kod` AND C.`kod_pengkhususan`=D.`kod` AND A.bil_keputusan=1 AND A.`id_pemohon`=".tosql($rsJK->fields['id_pemohon']));
							$rs2 = $conn->query("SELECT B.`DISKRIPSI`, D.`DISKRIPSI` AS matapelajaran 
								FROM spp_calon.`calon_ipt` A, spp_ref.`ref_institusi` B, spp_ref.`padanan_institusi_pengkhususan` C, spp_ref.`ref_pengkhususan` D  
								WHERE A.`inst_keluar_sijil`=B.`KOD` AND A.`pengkhususan`=C.`kod` AND C.`kod_pengkhususan`=D.`kod` AND A.bil_keputusan=2 AND A.`id_pemohon`=".tosql($rsJK->fields['id_pemohon']));
							$rs3 = $conn->query("SELECT B.`DISKRIPSI`, D.`DISKRIPSI` AS matapelajaran 
								FROM spp_calon.`calon_ipt` A, spp_ref.`ref_institusi` B, spp_ref.`padanan_institusi_pengkhususan` C, spp_ref.`ref_pengkhususan` D  
								WHERE A.`inst_keluar_sijil`=B.`KOD` AND A.`pengkhususan`=C.`kod` AND C.`kod_pengkhususan`=D.`kod` AND A.bil_keputusan=3 AND A.`id_pemohon`=".tosql($rsJK->fields['id_pemohon']));
							$conn->debug=false;
							?>
							<tr>
								<td><?php print $bil;?></td>
								<td><?php print $rsJK->fields['nama_penuh'];?></td>
								<td><?php print $rsJK->fields['ICNo'];?></td>
								<td><?php print dlookup("$schema1.`ref_negeri`","NEGERI","KOD_NEGERI=".$rsJK->fields['negeri']);?></td>
								<td><?php print $rs1->fields['DISKRIPSI'];?><br><i><?php print $rs1->fields['matapelajaran'];?></i></td>
								<td><?php print $rs2->fields['DISKRIPSI'];?><br><i><?php print $rs2->fields['matapelajaran'];?></i></td>
								<td><?php print $rs3->fields['DISKRIPSI'];?><br><i><?php print $rs3->fields['matapelajaran'];?></i></td>
							</tr>
							<?php $rsJK->movenext(); } ?>
							</tbody>
						</table>
					</div>
				</div>

                    	</div>
		</div>
	     
	</section>

</div> 
