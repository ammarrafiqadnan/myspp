<h4 style="color: red;">Maklumat ini diambil dari MyIdentity-Jabatan Pendaftaran Negara(JPN)</h4>
<header class="panel-heading"  style="background-color:rgb(38, 167, 228)">
    <h6 class="panel-title"><font color="#000000" size="3"><b>MAKLUMAT MyIdentity</b></font></h6>
</header>

<table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
    <thead  style="background-color:rgb(38, 167, 228)">
        <th width="20%"><font color="#000000"><div align="center">Jenis</div></font></th>
        <th width="30%"><font color="#000000"><div align="center">Kod/Data</div></font></th>
        <th width="50%"><font color="#000000"><div align="center">Keterangan</div></font></th>
    </thead>
    <tbody>
        <tr>
            <td align="center">No. Kad Pengenalan</td>
            <td align="left"><?=$data->fields['ICNo'];?></td>
            <td align="center"></td>
        </tr>
        <tr>
            <td align="center">Nama</td>
            <td align="left"><?=$data->fields['nama_penuh'];?></td>
            <td align="center"></td>
        </tr>
        <tr>
            <td align="center">Tarikh Lahir</td>
            <td align="left"><?=displayDate($data->fields['dob']);?></td>
            <td align="center"></td>
        </tr>
        <tr>
            <td align="center">Jantina</td>
            <td align="left">
			<?php 
			print $data->fields['jantina'];

			//$icbelakang = substr($data->fields['ICNo'], 1);

			//if($icbelakang % 2 == 0) {
			//if($data->fields['dob']){
				//print 'P';
			//} else {
				//print 'L';
			//}

		 ?>
		</td>
            <td align="center">
			<?php //$icbelakang = substr($data->fields['ICNo'], 1);
			//if($icbelakang % 2 == 0) {
			if($data->fields['jantina'] == 'P'){
				print 'Perempuan';
			} else {
				print 'Lelaki';
			}

		 ?>
		</td>
        </tr>
        <tr>
            <td align="center">Keturunan</td>
            <td align="left"><?=$data->fields['keturunan'];?></td>
            <td align="center">
		<?php $keturunan = $conn->query("SELECT keturunan FROM $schema1.ref_keturunan WHERE kod_jpn=".tosql($data->fields['keturunan']));

			print $keturunan->fields['keturunan'];
		 ?>

            </td>
        </tr>
        <tr>
            <td align="center">Agama</td>
            <td align="left"><?=$data->fields['agama'];?></td>
            <td align="center">
		<?php $agama = $conn->query("SELECT agama FROM $schema1.ref_agama WHERE kod_jpn=".tosql($data->fields['agama']));

			print $agama->fields['agama'];
		 ?>

	    </td>
        </tr>
        <tr>
            <td align="center">Status Kewarganegaraan</td>
            <td align="left"></td>
            <td align="center">WARGANEGARA</td>
        </tr>
    </tbody>
</table>
	     
<!--<div class="form-group">
	    	<div class="row">
                	<div class="col-md-12">
                    		<a type="button" class="btn btn-success" href="index.php?data=<?php print base64_encode('pemohon/senarai_pemohon;Senarai Pemohon;;;;;'); ?>"><i class="fa fa-arrow-left" style="margin:0px;"></i> Kembali</a>
                	</div>
		</div>
            </div>-->
