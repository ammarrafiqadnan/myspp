<?php 
print $PRO_lengkap;

?>

<header class="panel-heading"  style="background-color:rgb(38, 167, 228)">
    <h6 class="panel-title"><font color="#000000" size="3"><b>Maklumat Keputusan Profesional calon</b></font></h6>
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
                                Maklumat Profesional adalah maklumat akademik profesional bagi calon.<br><br>
                            </small>
                        <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                            <thead  style="background-color:rgb(209 29 29)">
                                <th width="5%"><font color="#000000"><div align="center">Bil</div></font></th>
                                <th width="50%"><font color="#000000"><div align="center">Nama Sijil</div></font></th>
                                <th width="15%"><font color="#000000"><div align="center">Tarikh Keahlian</div></font></th>
                                <th width="10%"><font color="#000000"><div align="center">No. Keahlian</div></font></th>
                                <th width="10%"><font color="#000000"><div align="center">Sijil</div></font></th>
                            </thead>
                            <tbody>
                                <tr>
                                    <td align="center">1.</td>
                                    <td align="left"><?php print $data->fields['professional_1'];?></td>
                                    <td align="center"><?php print $data->fields['professional_d_1'];?></td>
                                    <td align="center"><?php print $data->fields['professional_no_ahli_1'];?></td>
                                    <td align="center">
                                        <img src="../upload_doc/PMR_Mock_Result_Statement_Certificate.png" width="300" height="350">
                                    </td>
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
                                if(empty($rsSijil->fields['sijil_nama'])){ 
                                    $sijil="../upload_doc/PMR_Mock_Result_Statement_Certificate.png"; }
                                else { 
                                    $sijil = "../uploads_doc/".$data->fields['id_pemohon']."/".$rsSijil->fields['sijil_nama']; 
                                }
                            ?>
                            <img src="<?=$sijil;?>" width="300" height="350">
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>	 
