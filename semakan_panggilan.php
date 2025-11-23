<script>
    function sortorder(href, val, fieldname){
        var cari = document.myspp.carian.value;
        var btn='';
        // alert('sini'+val);
        // var carian = $('#carian').val();
        // window.location.href = href+"&carian="+carian;
        if(val=='1'){
            document.myspp.carian.value='';
            btn='OK';
        } else {
            if(cari==''){
                swal({
                  title: 'Makluman',
                  text: 'Sila isikan maklumat No. Kad Pengenalan.',
                  type: 'info',
                  confirmButtonClass: "btn-success",
                  confirmButtonText: "Ok",
                  showConfirmButton: true,
                }).then(function () {
                 document.myspp.carian.focus();
                });
            } else {
                btn='OK';
            }
        }

        if(btn=='OK'){ 
            document.myspp.action = href;
            document.myspp.target='_self';
            document.myspp.submit();
        }
        // return sorturl;
    }

	function do_cetak3(URL){
	//alert(URL);
    document.myspp.action = URL+'&prn=OK';
    document.myspp.target = '_blank';
    document.myspp.submit();
}

</script>

    <?php
         //$conn->debug=true;
        $JFORM='LIST';
        $carian=strtoupper(isset($_REQUEST["carian"])?$_REQUEST["carian"]:"");

        $hrefs = 'index.php?pages=semakan_panggilan';

	 //$id_pemohon =  dlookup($schema2.'.calon','id_pemohon','ICNo='.$carian);
	$sqlId = "SELECT id_pemohon FROM $schema2.calon WHERE ICNo=".tosql($carian);
	$id_p = $conn->query($sqlId);
	//print $id_p->fields['id_pemohon'];
	$href_cetakB = "_msys/modal_print.php?win=".base64_encode('cetakan/cetak_permohonan.php;'.$id_p->fields['id_pemohon'].";".$carian);


    ?>
    
    <section id="intro" class="bg-white big-banner" style="min-height: 630px;">
        <div class="container pt-5" style="opacity: 0.9;">
            
            
            
            <div class="row d-flex justify-content-center align-items-center">
                
                <div class="col-lg-12">
                    <div class="card">
                        <div class="text-center py-3">
                            <h3>Semakan Panggilan Temu Duga</h3>
                        </div>
                        <div class="card-body d-flex flex-column">
                            <div class="box-body" style="">
                                <div class="row" align="center">
                                    <div class="col-md-1"></div>
                                    <div class="col-md-2">
                                        <label for="">No. Kad Pengenalan : </label>
                                    </div>
                                    <div class="col-md-5">
                                        <input type="text" id="carian" name="carian" value="<?=$carian;?>" class="form-control" placeholder="No. Kad Pengenalan" maxlength="12">
                                    </div>
                                    <div class="col-md-2"  align="right">
                                        <?php if(empty($carian)){ ?>
                                            <button type="button" class="btn btn-primary" onclick="sortorder('<?=$hrefs;?>',this.value)" style="width:100%">
                                                <i class=" fa fa-search"></i> <font style="font-family:Verdana, Geneva, sans-serif">Semak</font>
                                            </button>
                                        <?php } else { ?>
                                            <button type="button" class="btn btn-primary" onclick="sortorder('<?=$hrefs;?>',1)" style="width:100%">
                                                <i class=" fa fa-search"></i> <font style="font-family:Verdana, Geneva, sans-serif">Reset</font>
                                            </button>
                                        <?php } ?>
                                    	

                                    </div>
					<div class="col-md-2" align="left">
                                        	<a href="index.php" type="button" class="btn btn-outline-info"><i class="fa fa-spinner"></i> Kembali</a>                                    
                                	</div> 
                                </div> 
                                <br><br>
                                <div class="row">
                                <?php
                                    // $conn->debug=true;
                                    $now = date('Y-m-d', strtotime(now()));
                                    
                                    //keputusan temuduga
                                    $sql = "SELECT * FROM $schema2.`senarai_panggilan_temuduga` A, $schema2.panggilan_temuduga B WHERE A.kod IS NOT NULL AND A.is_deleted=0 AND B.kod=A.kod_panggilan_temuduga AND B.is_deleted=0"; 
				    
					$sql .= " AND B.tarikh_mula <=" .tosql($now)." AND B.tarikh_tamat >=".tosql($now); 
                                    $sql .= " AND (A.noKP LIKE '%".$carian."%')";
                                    
                                    $rs = $conn->query($sql);

                                    $sql4 = "SELECT COUNT(*) as total FROM $schema2.`calon` WHERE ICNo=".$carian." AND pengakuan='Y'"; 
                                    $rs4 = $conn->query($sql4);
                                ?>
                                <?php 
                                    if(!empty($carian)){
                                        //if($rs4->fields['total'] != 0) {
                                            if(!$rs->EOF){
                                                while(!$rs->EOF){  ?>
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <div class="row">
                                                                    <label for="nama" class="col-sm-2 control-label"><b>Nama<div style="float:right">:</div></b></label>
                                                                    <div class="col-sm-10"><?=$rs->fields['nama_penuh']; ?></div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="row">
                                                                    <label for="nama" class="col-sm-2 control-label"><b>No. Kad Pengenalan<div style="float:right">:</div></b></label>
                                                                    <div class="col-sm-10"><?=$rs->fields['noKP']; ?></div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="row">
                                                                    <label for="nama" class="col-sm-2 control-label"><b>Panggilan temuduga<div style="float:right">:</div></b></label>
                                                                    <div class="col-sm-10"><?=strtoupper($rs->fields['tajuk']);?></div>
                                                                </div>
                                                            </div>
                                                            <br>
                                                            <div class="form-group">
                                                                <div class="row">
                                                                <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                                                    <thead  style="background-color:rgb(38, 167, 228)">
                                                                        <th width="10%"><font color="#000000"><div align="center">Tarikh/Masa</div></font></th>
                                                                        <!-- <th width="25%"><font color="#000000"><div align="center">Kod</div></font></th> -->
                                                                        <th width="30%"><font color="#000000"><div align="center">Jawatan</div></font></th>
                                                                        <th width="35%"><font color="#000000"><div align="center">Tempat Temu Duga</div></font></th>
                                                                        <th width="25%"><font color="#000000"><div align="center">Catatan</div></font></th>
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr>
                                                                            <td align="center">
                                                                                <?=date('d/m/Y',strtotime($rs->fields['tarikh']));?><br>
                                                                                <?=date('h:i:s',strtotime($rs->fields['masa']));?>
                                                                            </td>
                                                                            <!-- <td align="center"><?=$rs->fields['tajuk'];?></td> -->
                                                                            <td align="center"><?=$rs->fields['skim_jawatan'];?></td>
                                                                            <td align="center"><?=$rs->fields['tempat'];?></td>
                                                                            
                                                                            <td style="text-align: justify;" align="center">
                                                                                <!--<a href="uploads_doc/sliptemuduga.pdf" class="btn btn-md btn-primary" target="_blank">SLIP TEMU DUGA SENARAI SEMAK</a>-->
										<button class="btn btn-md btn-warning" onclick="do_cetak3('<?=$href_cetakB;?>')">SLIP TEMU DUGA SENARAI SEMAK</button>

                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                                </div>
                                                            </div>
                                                            <br><br>
                                                        </div>
                                               <?php $rs->movenext(); }
                                            } else {
                                                 print '<h4><b>Maaf! Permohonan anda tidak berjaya.</b></h4>';
                                             }
                                        //} else {
                                            //print '<h4><b>Maaf! Maklumat anda tiada dalam urusan ini.</b></h4>';
                                        //}
                                    }   ?>
                                </div>

                            </div> 

                        </div>
                    </div>
                </div> 
            </div>
        </div>
    </section>
    
    
    <script type="text/javascript">
        document.myspp.carian.focus();
    </script>
