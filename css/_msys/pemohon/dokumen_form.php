<?php include '../../connection/common.php'; ?>
<div class="col-lg-12">
	<section class="panel">
		<header class="panel-heading"  style="background-color:rgb(38, 167, 228)">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="do_close()">×</button>
			<h6 class="panel-title"><font color="#000000" size="3"><b>SENARAI PEMOHON</b></font></h6>
		</header>
		<div class="panel-body">
			<div class="box-body">

			    <input type="hidden" name="id" id="id" value="<?php print $id;?>" readonly="readonly"/>

                <div class="form-group">
                    <div class="row">
                        <div class="col-md-1"></div>
                        <label for="nama" class="col-sm-1 control-label"><b>Carian : </b></label>
                        <div class="col-sm-8">
                            <input type="text" name="nama_penuh" id="nama_penuh" class="form-control" value="" placeholder="Nama/No. KP">
                        </div>
                        <div class="col-sm-2">
                            <button type="button" class="btn btn-primary" onclick="do_save()"><i class="fa fa-save"></i> Cetak</button>
                        </div>
                    </div>
                </div>

                <?php
                    $sql = "SELECT A.id_pemohon,A.nama_penuh, A.ICNo,A.d_cipta,A.d_kemaskini,A.pengakuan, B.diskripsi FROM $schema2.calon A, $schema2.ref_negeri B WHERE A.negeri=B.kod";

                    $sSQL1 = "SELECT COUNT(*) as total FROM $schema2.calon A, $schema2.ref_negeri B WHERE A.negeri=B.kod";

                    include '../include/list_head.php';
                    include '../include/page_list.php';
                ?>

				<div class="col-md-12">
                    <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                        <thead  style="background-color:rgb(38, 167, 228)">
                            <th width="5%"><font color="#000000"><div align="center">Bil</div></font></th>
                            <th width="35%"><font color="#000000"><div align="center">Nama Pemohon</div></font></th>
                            <th width="10%"><font color="#000000"><div align="center">No. Kad Pengenalan</div></font></th>
                            <!-- <th width="10%"><font color="#000000"><div align="center">Negeri</div></font></th>
                            <th width="10%"><font color="#000000"><div align="center">Skim Jawatan</div></font></th>
                            <th width="10%"><font color="#000000"><div align="center">Status</div></font></th> -->
                            <th width="10%"><font color="#000000"><div align="center">Dokumen <br><small style="color: red;">Nota: Tanda / untuk muat turun dokumen pemohon</small><br>Pilih semua <br> <input type="checkbox" onclick="selecctall(this)"></div></font></th>
                            <!-- <th width="10%" class="d-print-none"><font color="#000000"><div align="center">Tindakan</div></font></th> -->
                        </thead>
                        <tbody>
                    
                        <?php 
                            // $conn->debug=true;
                            // $result = get_pemohon($conn, $uid, "103", $tahun, "1");
                            // $pg = 1;
                            // $pgSize = 10;
                            
                            // $rs = get_pemohon($conn, $pg, $pgSize);

                            // print $rs;

                            // $p = (explode(":",$rs));

                            $cnt = 0;
			                $bil = 0;
                            
                            
                            while(!$rs->EOF){ $bil2=0;
                                $bil = $cnt + ($PageNo-1)*$PageSize;  ?>
                                <tr>
                                    <td align="center"><?=++$bil;?></td>
                                    <td align="left">
                                        <?=$rs->fields['nama_penuh']?>
                                    </td>
                                    <td align="center"><?=$rs->fields['ICNo']?></td>
                                    <td align="center">
                                        <input type="checkbox">
                                    </td>
                                </tr>
                            <?php 
                             $cnt = $cnt + 1;
                            $rs->movenext(); } ?>
                        </tbody>
                    </table>
				</div>

                <div class="modal-footer" style="padding:0px;">
                    <button type="button" class="btn btn-primary mt-sm mb-sm" onclick="do_save()"><i class="fa fa-save"></i> Cetak</button>
                    &nbsp;
                    <button type="button" class="btn btn-default" onclick="do_close()"><i class="fa fa-spinner" style="margin:0px;"></i> Kembali</button>
                </div>

                <!-- <div class="card-footer">
                    <?php 
                        $href_f=$actual_link."&table_search=".$table_search;
                        include 'include/list_footer.php'; 
                    ?>  
                </div> -->
			</div>
		</div>
	</section>

</div> 

<script>
    function do_close(){
        reload = window.location; 
        window.location = reload;
    }
</script>