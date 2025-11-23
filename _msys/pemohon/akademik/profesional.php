<?php 
print $PRO_lengkap;

?>

<header class="panel-heading"  style="background-color:rgb(38, 167, 228)">
    <h6 class="panel-title"><font color="#000000" size="3"><b>Maklumat Keputusan Profesional</b></font></h6>
</header>
<div class="panel-body">
    <div class="box-body">
        <div class="col-md-12">

            <div class="form-group">
                <div class="row">
                    <div class="col-sm-8">
                        <?php if(!empty($data->fields['professional_1'])){ ?>
                            <small style="color: red;">
                                Tarikh dikemskini : <?php print DisplayDate($data->fields['d_kemaskini']);  print '&nbsp;&nbsp;'.DisplayMasa($data->fields['d_kemaskini']) ?><br>
                            </small>
                        <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                            <thead  style="background-color:rgb(38, 167, 228)">
                                <th width="5%"><font color="#000000"><div align="center">Bil</div></font></th>
                                <th width="50%"><font color="#000000"><div align="center">Nama Sijil</div></font></th>
                                <th width="15%"><font color="#000000"><div align="center">Tarikh Keahlian</div></font></th>
                                <th width="10%"><font color="#000000"><div align="center">No. Keahlian</div></font></th>
                            </thead>
                            <tbody>
				<?php
					$sql = "SELECT KOD, DISKRIPSI FROM $schema1.`ref_kelulusan` WHERE KATEGORI='P' AND JENIS=1 AND DISKRIPSI IS NOT NULL";
					$sql .= " AND DISKRIPSI NOT LIKE 'PENGALAMAN%'";
					$sql .= " ORDER BY DISKRIPSI";
					$rs = $conn->query($sql);


				?>
                                <tr>
                                    <td align="center">1.</td>
                                    <td align="left">
					<?php while(!$rs->EOF){
						if($rs->fields['KOD']==$data->fields['professional_1']){ 
							print $rs->fields['DISKRIPSI']; }
						$rs->movenext();
					} ?>
				    </td>
                                    <td align="center"><?php print date('d-m-Y',strtotime($data->fields['professional_d_1']));?></td>
                                    <td align="center"><?php print $data->fields['professional_no_ahli_1'];?></td>
                                </tr>
                            </tbody>
                        </table>
                        <?php } else { 
                            print '-- Tiada Maklumat --';
                            
                        } ?>
                    </div>
                    <?php if(!empty($data->fields['professional_1'])){ ?>
                        <div class="col-sm-4" align="center">
                            <?php 
                                //$conn->debug=true;
                                $rsSijil = $conn->query("SELECT * FROM $schema2.`calon_sijil` WHERE `jenis_sijil`='PRO' AND `id_pemohon`=".tosql($data->fields['id_pemohon']));
                                //if(!empty($rsSijil->fields['sijil_nama'])){ 
                                //    $sijil = "/upload/".$data->fields['id_pemohon']."/".$rsSijil->fields['sijil_nama']; 
                                //}
if(!empty($rsSijil->fields['sijil_nama'])){
	$sijil_pic = "/var/www/upload/".$data->fields['id_pemohon']."/".$rsSijil->fields['sijil_nama']; 
	if (file_exists($sijil_pic)){
		$b64image = base64_encode(file_get_contents($sijil_pic));
		$sijil = "data:image/png;base64,$b64image";
	}
}

                            ?>
                            <?php if(!empty($rsSijil->fields['sijil_nama'])){  ?>
                                <img src="<?=$sijil;?>" width="300" height="400">
                            <?php } ?>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>	 
	     
<!--<div class="form-group">
	    	<div class="row">
                	<div class="col-md-12">
                    		<a type="button" class="btn btn-success" href="index.php?data=<?php print base64_encode('pemohon/senarai_pemohon;Senarai Pemohon;;;;;'); ?>"><i class="fa fa-arrow-left" style="margin:0px;"></i> Kembali</a>
                	</div>
		</div>
            </div>-->
