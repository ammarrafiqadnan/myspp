<small style="color: red;">
    Tarikh dikemskini : 04-03-2022 10:30:23 <br>
    Maklumat Jawatan Dipohon adalah maklumat Jawatan yang dipohon oleh calon.<br><br>
</small>

<header class="panel-heading"  style="background-color:rgb(38, 167, 228)">
    <h6 class="panel-title"><font color="#000000" size="3"><b>MAKLUMAT JAWATAN DIPOHON calon</b></font></h6>
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
                                <th width="85%"><font color="#000000"><div>Matapelajaran</div></font></th>
                            </thead>
                            <tbody>
                                <?php
                                    //$conn->debug=true;
                                    $bil = 0;

                                    $sql = "SELECT C.DISKRIPSI, C.KOD, A.id_pemohon, A.kod_jawatan FROM $schema2.calon_jawatan_dipohon A, $schema1.ref_skim C  WHERE A.kod_jawatan=C.KOD AND A.id_pemohon=".tosql($data->fields['id_pemohon']);

                                    $sql .= " ORDER BY A.seq_no ASC";

                                    $rsJawatan = $conn->query($sql);

                                ?>
                                <?php  while(!$rsJawatan->EOF){ ?>
                                    <tr>
                                        <td><?=++$bil;?></td>
                                        <td><?=$rsJawatan->fields['DISKRIPSI']?></td>
                                    </tr>
                                <?php $rsJawatan->movenext(); } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>	 
