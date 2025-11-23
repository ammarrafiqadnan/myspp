<?php 
    //$conn->debug=true;
    $sql = "SELECT * FROM $schema2.`calon_polis_ban_oku` WHERE id_pemohon='{$data->fields['id_pemohon']}'";
    $rsData = $conn->query($sql);

    $sql = "SELECT COUNT(*) as total FROM $schema2.`calon_polis_ban_oku` WHERE id_pemohon='{$data->fields['id_pemohon']}'";
    $count = $conn->query($sql);

?>

<small style="color: red;">
    Tarikh dikemaskini : 
    <?php
    if(($count->fields['total'] != 0)){
        if(!empty($rsData->fields['d_kemaskini'])){
            print DisplayDate($rsData->fields['d_kemaskini']);  print '&nbsp;&nbsp;'.DisplayMasa($rsData->fields['d_kemaskini']);
        } else {
            print DisplayDate($rsData->fields['d_cipta']);  print '&nbsp;&nbsp;'.DisplayMasa($rsData->fields['d_cipta']);
        }
    }
    ?>
</small>

<header class="panel-heading"  style="background-color:rgb(38, 167, 228)">
    <h6 class="panel-title"><font color="#000000" size="3"><b>MAKLUMAT BEKAS TENTERA/POLIS</b></font></h6>
</header>
<div class="panel-body">
    <div class="box-body">
        <div class="col-md-12">
            <div class="form-group">
                <div class="row">
                    <div class="col-sm-12">
                        <div>
                            
                        </div>
                        <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                            <!-- <thead  style="background-color:rgb(38, 167, 228)">
								<th width="30%"><font color="#000000"><div>Kategori</div></font></th>
								<th width="70%"><font color="#000000"><div>Bekas Polis</div></font></th>
                            </thead> -->
                            <tbody>
                                <?php 
                                if(($count->fields['total'] != 0)){
                                    $sql = "SELECT * FROM $schema1.`ref_bekas_pol_ten` WHERE kod_pangkat=0 AND kod_bekas_polis_tentera='{$rsData->fields['kategori']}' GROUP BY kod_bekas_polis_tentera";
                                    $rsBekas = $conn->query($sql);

                                    $sql = "SELECT * FROM $schema1.`ref_bekas_pol_ten` WHERE kod_pangkat!=0 AND kod_bekas_polis_tentera='{$rsData->fields['kategori']}'AND kod_pangkat='{$rsData->fields['pangkat']}' GROUP BY kod_bekas_polis_tentera, susunan_kanan DESC";
                                    $rsPangkat = $conn->query($sql);
                                ?>
                                <tr>
                                    <td style="background-color:rgb(38, 167, 228)">Kategori</td>
                                    <td><?=$rsBekas->fields['diskripsi'];?></td>
                                </tr>
                                <tr>
                                    <td style="background-color:rgb(38, 167, 228)">Pangkat</td>
                                    <td><?=$rsPangkat->fields['diskripsi'];?></td>
                                </tr>
                                <tr>
                                    <td style="background-color:rgb(38, 167, 228)">Pencen/Ganjaran</td>
                                    <td>
                                        <?php if($rs_data->fields['rujukan_ganjaran']==1){ print 'MENERIMA PENCEN'; } else { print 'MENERIMA GANJARAN'; } ?>
                                    </td>
                                </tr>
                                <?php } else { ?>
                                    --Tiada rekod dijumpai--
                                <?php } ?>
                            </tbody>
                        </table>
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

