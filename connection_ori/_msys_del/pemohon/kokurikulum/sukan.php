

<header class="panel-heading"  style="background-color:rgb(38, 167, 228)">
    <h6 class="panel-title"><font color="#000000" size="3"><b>MAKLUMAT SUKAN/PERSATUAN CALON</b></font></h6>
</header>
<div class="panel-body">
    <div class="box-body">
        <div class="col-md-12">
            <div class="form-group">
                <div class="row">
                    <div class="col-sm-12">
                        <div>
                            Maklumat Ko-kurikulum bahagian sukan bagi calon.<br><br>
                        </div>
                        <?php 
                            // $conn->debug=true;
                            $rsData = $conn->query("SELECT * FROM $schema2.`calon_ko_sukan` WHERE `id_pemohon`='{$data->fields['id_pemohon']}'");

                            $count = $conn->query("SELECT COUNT(*) as total FROM $schema2.`calon_ko_sukan` WHERE `id_pemohon`='{$data->fields['id_pemohon']}'");

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
                        <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                            <thead  style="background-color:rgb(38, 167, 228)">
                            
								<th width="80%"><font color="#000000"><div>Sukan</div></font></th>
                                <th width="20%"><font color="#000000"><div>Peringkat</div></font></th>
                            </thead>
                            <tbody>
                                <?php
                                    $bil=0;

                                    while(!$rsData->EOF){ 
                                        $sql = "SELECT * FROM $schema1.`ref_sukan` WHERE kod=".tosql($rsData->fields['sukan'])." GROUP BY kod";
                                        $rsSukan = $conn->query($sql); 

                                        $sql = "SELECT * FROM $schema1.`ref_peringkat` WHERE KOD=".tosql($rsData->fields['peringkat'])." AND SAH_YT='Y' ORDER BY KOD";
                                        $rsPeringkat = $conn->query($sql);
                                    ?>
                                    <tr>
                                        <td align="center"><?=$rsSukan->fields['deskripsi']; ?></td>
                                        <td align="center"><?=$rsPeringkat->fields['DISKRIPSI']; ?></td>
                                    </tr>
                                <?php 
                                $rsData->movenext(); } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-sm-12">
                        <div>
                            Maklumat Ko-kurikulum bahagian persatuan bagi calon.<br><br>
                        </div>
                        <?php 
                            // $conn->debug=true;
                            $rsData = $conn->query("SELECT * FROM $schema2.`calon_ko_persatuan` WHERE `id_pemohon`='{$data->fields['id_pemohon']}'");

                            $count = $conn->query("SELECT COUNT(*) as total FROM $schema2.`calon_ko_persatuan` WHERE `id_pemohon`='{$data->fields['id_pemohon']}'");

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
                        <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                            <thead  style="background-color:rgb(38, 167, 228)">
								<th width="50%"><font color="#000000"><div>Nama Persatuan</div></font></th>
                                <th width="25%"><font color="#000000"><div>Jawatan</div></font></th>
                                <th width="25%"><font color="#000000"><div>Peringkat</div></font></th>
                            </thead>
                            <tbody>
                                <?php 

                                    while(!$rsData->EOF){ 
                                        $sql = "SELECT * FROM $schema1.`ref_jawatan_persatuan` WHERE kod=".tosql($rsData->fields['jawatan'])." ORDER BY KOD";
                                        $rsJawatan = $conn->query($sql);

                                        $sql = "SELECT * FROM $schema1.`ref_peringkat` WHERE kod=".tosql($rsData->fields['peringkat'])." AND SAH_YT='Y' ORDER BY KOD";
                                        $rsPeringkat = $conn->query($sql);

                                    ?>
                                    <tr>
                                        <td align="center"><?=$rsData->fields['persatuan']; ?></td>
                                        <td align="center"><?=$rsPeringkat->fields['DISKRIPSI']; ?></td>
                                        <td align="center"><?=$rsPeringkat->fields['DISKRIPSI']; ?></td>

                                    </tr>
                                <?php 
                                $rsData->movenext(); } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>	 
