<!-- <small style="color: red;">
    Tarikh dikemskini : 04-03-2022 10:30:23 <br>
    Maklumat Jawatan Dipohon adalah maklumat Jawatan yang dipohon oleh calon.<br><br>
</small> -->
<?php

$rsAuditrail = get_auditrail($conn, $id_pemohon);

?>
<header class="panel-heading"  style="background-color:rgb(38, 167, 228)">
    <h6 class="panel-title"><font color="#000000" size="3"><b>MAKLUMAT AUDITRAIL calon</b></font></h6>
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
                                <!-- <th width="85%"><font color="#000000"><div>Aktiviti</div></font></th> -->
                                <th width="85%"><font color="#000000"><div>Maklumat</div></font></th>
                                <th width="10%"><font color="#000000"><div>Tarikh/Masa</div></font></th>
                            </thead>
                            <tbody>
                                <!-- <?php 
                                    $bill = 0;
                                    while(!$rsAuditrail->EOF){
                                ?>
                                <tr>
                                    <td align="center"><?=++$bill;?></td>
                                    <td align="center"><?=++$rsAuditrail->fields['remarks'];?></td>
                                    <td>Kemaskini Maklumat Calon</td>
                                </tr>
                                <?php $rsAuditrail->movenext(); } ?> -->
                                <tr>
                                    <td>1.</td>
                                    <td>Kemaskini Maklumat Pemohon</td>
                                    <td>22/07/2021  00:09:29</td>
                                </tr>
                                <tr>
                                    <td>2.</td>
                                    <td>Kemaskini Maklumat Akademik</td>
                                    <td>22/07/2021  00:15:04</td>
                                </tr>
                                <tr>
                                    <td>3.</td>
                                    <td>Kemaskini Maklumat Ko-kurikulum</td>
                                    <td>04-03-2022 10:30:23</td>
                                </tr>
                                <tr>
                                    <td>4.</td>
                                    <td>Kemaskini Maklumat Perkhidmatan</td>
                                    <td>04-03-2022 10:30:23</td>
                                </tr>
                                <tr>
                                    <td>5.</td>
                                    <td>Kemaskini Maklumat Tambahan</td>
                                    <td>04-03-2022 10:30:23</td>
                                </tr>
                                <tr>
                                    <td>6.</td>
                                    <td>Kemaskini Jawatan Dipohon</td>
                                    <td>04-03-2022 10:30:23</td>
                                </tr>
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>	 
