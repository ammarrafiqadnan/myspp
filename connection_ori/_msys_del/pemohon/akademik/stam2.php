
<div class="form-group">
    <div class="row">
        <label for="nama" class="col-sm-2 control-label"><b>Jenis<div style="float:right">:</div></b></label>
        <div class="col-sm-3">
            -
        </div>

        <label for="nama" class="col-sm-2 control-label"><b>Lisan<div style="float:right">:</div></b></label>
        <div class="col-sm-3">
            -
        </div>
    </div>
</div>
<div class="form-group">
    <div class="row">
        <label for="nama" class="col-sm-2 control-label"><b>Pangkat<div style="float:right">:</div></b></label>
        <div class="col-sm-3">
            -
        </div>
        <label for="nama" class="col-sm-2 control-label"><b>Tahun<div style="float:right">:</div></b></label>
        <div class="col-sm-3">
            2019
        </div>
    </div>
</div>

<hr>

<div class="form-group">
    <div class="row">
        <div class="col-sm-8">
            <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                <thead  style="background-color:rgb(38, 167, 228)">
                    <th width="90%"><font color="#000000"><div>Matapelajaran</div></font></th>
                    <th width="10%"><font color="#000000"><div align="center">Gred</div></font></th>
                </thead>
                <tbody>
                    <tr>
                        <td>BAHASA MELAYU</td>
                        <td align="center">A</td>
                    </tr>
                    <tr>
                        <td>PENDIDIKAN ISLAM</td>
                        <td align="center">A</td>
                    </tr>
                    <tr>
                        <td>SEJARAH</td>
                        <td align="center">A</td>
                    </tr>
                    <tr>
                        <td>BAHASA INGGERIS</td>
                        <td align="center">A</td>
                    </tr>
                    <tr>
                        <td>MATEMATIK/MATEMATIK PILIHAN C</td>
                        <td align="center">A</td>
                    </tr>
                    
                    <tr>
                        <td>MATEMATIK TAMBAHAN</td>
                        <td align="center">A</td>
                    </tr>
                    <tr>
                        <td>FIZIK</td>
                        <td align="center">A</td>
                    </tr>
                    <tr>
                        <td>KIMIA</td>
                        <td align="center">A</td>
                    </tr>
                    <tr>
                        <td>BIOLOGI</td>
                        <td align="center">A</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="col-sm-4" align="center">
            <?php 
                //$conn->debug=true;
                $rsSijil = $conn->query("SELECT * FROM $schema2.`calon_sijil` WHERE `jenis_sijil`='STAM2' AND `id_pemohon`=".tosql($data->fields['id_pemohon']));
                if(empty($rsSijil->fields['sijil_nama'])){ 
                    $sijil="../upload_doc/PMR_Mock_Result_Statement_Certificate.png"; }
                else { 
                    $sijil = "../uploads_doc/".$data->fields['id_pemohon']."/".$rsSijil->fields['sijil_nama']; 
                }
            ?>
            <img src="<?=$sijil;?>" width="300" height="350">
        </div>
    </div>
</div>
