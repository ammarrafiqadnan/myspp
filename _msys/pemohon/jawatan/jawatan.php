<small style="color: red;">
    Tarikh/masa kemas kini : <?=DisplayDate($rsTarikh->fields['tkh_upd_jawatan']);  print '&nbsp;&nbsp;'.DisplayMasa($rsTarikh->fields['tkh_upd_jawatan']);?>
</small>

<header class="panel-heading"  style="background-color:rgb(38, 167, 228)">
    <h6 class="panel-title"><font color="#000000" size="3"><b>MAKLUMAT JAWATAN DIMOHON</b></font></h6>
</header>
<div class="panel-body">
    <div class="box-body">
        <div class="col-md-12">
            <div class="form-group">
                <div class="row">
                    <div class="col-sm-12">
                        <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                            <thead  style="background-color:rgb(38, 167, 228)">
                                <th width="5%"><font color="#000000"><div align="center">No.</div></font></th>
                                <th width="85%"><font color="#000000"><div>Jawatan</div></font></th>
                            </thead>
                            <tbody>
                                <?php
                                    //$conn->debug=true;
                                    $bil = 0;

                                    $sql = "SELECT C.DISKRIPSI, C.KOD, A.id_pemohon, A.kod_jawatan FROM $schema2.calon_jawatan_dipohon A, $schema1.ref_skim C  WHERE A.kod_jawatan=C.KOD AND A.id_pemohon=".tosql($data->fields['id_pemohon']);

                                    $sql .= " ORDER BY A.seq_no ASC";

                                    $rsJawatan = $conn->query($sql);

                                    $sql2 = "SELECT COUNT(*) as total FROM $schema2.calon_jawatan_dipohon A, $schema1.ref_skim C  WHERE A.kod_jawatan=C.KOD AND A.id_pemohon=".tosql($data->fields['id_pemohon']);

                                    $sql2 .= " ORDER BY A.seq_no ASC";

                                    $countJawatan = $conn->query($sql2);

                                ?>
                                <?php  
                                if($countJawatan->fields['total'] != 0){
                                while(!$rsJawatan->EOF){ ?>
                                    <tr>
                                        <td><?=++$bil;?></td>
                                        <td><?=$rsJawatan->fields['DISKRIPSI']?></td>
                                    </tr>
                                <?php $rsJawatan->movenext(); }
                                } else { ?>
                                    <tr>
                                        <td colspan="7" align="center">Tiada rekod dijumpai</td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>	 

<div class="form-group">
    <div class="col-md-12">
        <div class="row">
            <?php 
		//$conn->debug=true;
		$pusat = dlookup("$schema2.`calon_pusat_temuduga`","pusat_temuduga","id_pemohon=".tosql($data->fields['id_pemohon'])); 
		$p = dlookup("$schema1.ref_pusat_temuduga", "diskripsi","kod=".tosql($pusat));
            
            $sqlNeg = "SELECT NEGERI FROM $schema1.`ref_negeri` WHERE KOD_NEGERI=$pusat GROUP BY KOD_NEGERI";
	        $rsNeg = $conn->query($sqlNeg);
            ?>

            <div class="form-group">
                <div class="row">
                    <label for="nama" class="col-sm-7 control-label"><b>Pusat Temu Duga / Ujian Khas yang Dipilih Bagi Jawatan SPP Sahaja
                        <div style="float:right">:</div></b></label>
                    <div class="col-sm-5">
                        <?=$p;?>
                    </div>
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

