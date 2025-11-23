<!-- <small style="color: red;">
    Tarikh dikemskini : 04-03-2022 10:30:23 <br>
    Maklumat Jawatan Dipohon adalah maklumat Jawatan yang dipohon oleh calon.<br><br>
</small> -->


<script>
    function do_print(val){
        do_cetak(val);
    }
</script>
<header class="panel-heading"  style="background-color:rgb(38, 167, 228)">
    <h6 class="panel-title"><font color="#000000" size="3"><b>MAKLUMAT DOKUMEN calon</b></font></h6>
</header>
<div class="panel-body">
    <div class="box-body">
        <div class="col-md-12">
            <div class="form-group">
                <div align="right">
                    <button type="button" class="btn btn-sm btn-info" onclick="do_print('cetak.php?pages=pemohon/dokumen_print_all&prn=&id_pemohon=<?=$data->fields['id_pemohon'];?>&filename=semua_dokumen_pemohon')">
                        <span style="cursor:pointer;" title="Cetak Semua Dokumen Pemohon">
                            <i class="fa fa-print" style="color: #FFFFFF;"></i> Cetak
                        </span>
                    </button>
                </div>
                <br>
                <div class="row">
                    <div class="col-sm-12">
                        <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                            <thead  style="background-color:rgb(38, 167, 228)">
                                <th width="5%"><font color="#000000"><div align="center">No.</div></font></th>
                                <th width="85%"><font color="#000000"><div>Dokumen</div></font></th>
                                <th width="10%"><font color="#000000"><div>Cetak</div></font></th>
                            </thead>
                            <tbody>
                                <?php
                                // $conn->debug=true;  
                                $bil = 0;
                                    $sql = "SELECT * FROM $schema2.`calon_sijil` WHERE id_pemohon=".tosql($data->fields['id_pemohon']);
                                    $rsData = $conn->query($sql);

                                    while(!$rsData->EOF){ 
                
                                ?>
                                <tr>
                                    <td><?=++$bil;?></td>
                                    <td>
                                        <a href="../view_doc_pemohon.php?id_pemohon=<?=$data->fields['id_pemohon'];?>&doc=<?=$rsData->fields['sijil_nama'];?>" data-toggle="modal" data-target="#myModal"><?=$rsData->fields['sijil_nama'];?></a>
                                    </td>
                                    <td>
                                        <!-- <a href="cetak_borang.php?pages=pemohon/view_doc_pemohon&id_pemohon=<?=$data->fields['id_pemohon'];?>&doc=<?=$rsData->fields['sijil_nama'];?>" data-rel="tooltip" title="Cetak permohonan" target="_window"><span class='fa fa-print bigger-300' ></a> -->

                                        <button class="btn btn-info" onclick="do_print('cetak.php?pages=pemohon/dokumen_print&prn=&id_pemohon=<?=$data->fields['id_pemohon'];?>&doc=<?=$rsData->fields['sijil_nama'];?>&filename=dokumen_pemohon')" ><span class='fa fa-print bigger-300' ></button>
                                    </td>
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
