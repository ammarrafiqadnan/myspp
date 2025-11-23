<?php include '../connection/common.php'; ?>

<script>
    function do_search(href, val){
        // alert('sini');
        var tkh_mula = $('#tkh_mula').val();
        var tkh_akhir = $('#tkh_akhir').val();
        var skim = $('#skim').val();
        var turutan = $('#turutan').val();
        var negeri = $('#negeri').val();
        var status = $('#status').val();
        var carian = $('#carian').val();

        //alert(carian);

        // if(fieldname == 'institusi'){
        //     window.location.href = href+"&institusi_kod="+val;
        // } else if(fieldname == 'peringkatKelulusan'){
        //     window.location.href = href+"&institusi_kod="+institusi+"&peringkatKelulusan="+val;
        // } else if(fieldname == 'carian'){
            window.location.href = href+"&tkh_mula="+tkh_mula+"&tkh_akhir="+tkh_akhir+"&skim="+skim+"&turutan="+turutan+"&negeri="+negeri+"&status="+status+'&carian='+carian;
        // }

        
        
        // return sorturl;
    }

    function do_sort(updown, kategori, url) {
        // alert(updown+'@'+kategori);
        if(updown == 'up'){
            if(kategori == 'namaPemohon'){
                namaPemohon1 = {
                    sortedBy: '',
                    sortDirection: 0
                }

                const sortAsc = 1;
                const sortDesc = -1;


                sortTable = (namaPemohon) => {
                    let sortDirection = sortAsc;
                    if (this.namaPemohon1.namaPemohon === namaPemohon) {
                    if (this.namaPemohon1.sortDirection === sortAsc) {
                        sortDirection = sortDesc;
                    } 
                    } 
                    this.s.TableData.sort((x1, x2) =>  x1[namaPemohon] < x2[namaPemohon] ? -1 * sortDirection :  sortDirection )
                    this.setNamaPemohon1({
                        namaPemohon, sortDirection, data: this.namaPemohon1.data
                    })
                };
            }
        } else {

        }
    }

    function do_print(val){
        do_cetak(val);
    }
</script>
<?php 
    //  $conn->debug=true;
    $order_by=isset($_REQUEST["order_by"])?$_REQUEST["order_by"]:"";
    $sort=isset($_REQUEST["sort"])?$_REQUEST["sort"]:"";
    $tkh_mula=isset($_REQUEST["tkh_mula"])?$_REQUEST["tkh_mula"]:"";
    $tkh_akhir=isset($_REQUEST["tkh_akhir"])?$_REQUEST["tkh_akhir"]:"";
    $skim=isset($_REQUEST["skim"])?$_REQUEST["skim"]:"";
    $turutan=isset($_REQUEST["turutan"])?$_REQUEST["turutan"]:"";
    $negeri=isset($_REQUEST["negeri"])?$_REQUEST["negeri"]:"";
    $status=isset($_REQUEST["status"])?$_REQUEST["status"]:"";
    $carian=isset($_REQUEST["carian"])?$_REQUEST["carian"]:"";

    $hrefs = 'index.php?data='.base64_encode('pemohon/senarai_pemohon;Pentadbiran;Senarai Pemohon;;;;');

    $link = '&tkh_mula='.$tkh_mula.'&tkh_akhir='.$tkh_akhir.'&skim='.$skim.'&turutan='.$turutan.'&negeri='.$negeri.'&status='.$status.'&carian='.$carian;

    function do_search($href, $fieldname, $sort){
        $sorturl = $href."&order_by=".$fieldname."&sort=".$sort;
        return $sorturl;
    }



    $sqlT = dlookup("$schema2.`kawalan_tempoh_akaun`","tempoh","kod=1");

    $year = "-".$sqlT." year";

    $dby = date("Y-m-d", strtotime($year));
    
    print $dby;
    
    // $conn->debug=true;
    $sql = "SELECT A.id_pemohon,A.nama_penuh, A.ICNo,A.d_cipta,A.d_kemaskini,A.pengakuan, B.NEGERI FROM $schema2.calon A, $schema1.ref_negeri B WHERE A.negeri=B.KOD_NEGERI AND A.d_kemaskini IS NOT NULL AND A.d_kemaskini >=".tosql($dby);

    if(!empty($tkh_mula)){
        $sql .= " AND A.d_cipta LIKE '%".$tkh_mula."%'";
    }

    if(!empty($tkh_akhir)){
        $sql .= " AND A.d_kemaskini LIKE '%".$tkh_akhir."%'";
    }

    if(!empty($negeri)){
        $sql .= " AND B.kod=".tosql($negeri);
    }

    if(!empty($status)){
        if($status == 1){
            $sql .= " AND A.pengakuan='Y'";
        } else if($status == 2){
            $sql .= " AND A.pengakuan IS NULL";
        }
        
    }

    if(!empty($carian)){
        $sql .= " AND ((A.nama_penuh  LIKE '%".$carian."%') OR (A.ICNo  LIKE '%".$carian."%'))";
    }

    if(!empty($sort)){
        if($order_by == 'namaPemohon'){
            if($sort == 'up'){
                $sql .= " ORDER BY A.nama_penuh ASC";
            } else if($sort == 'down'){
                $sql .= " ORDER BY A.nama_penuh DESC";
            }
        } 
        
        if($order_by == 'noKP'){
            if($sort == 'up'){
                $sql .= " ORDER BY A.ICNo ASC";
            } else if($sort == 'down'){
                $sql .= " ORDER BY A.ICNo DESC";
            }
        }

        if($order_by == 'negeri'){
            if($sort == 'up'){
                $sql .= " ORDER BY B.NEGERI ASC";
            } else if($sort == 'down'){
                $sql .= " ORDER BY B.NEGERI DESC";
            }
        }

        if($order_by == 'status'){
            if($sort == 'up'){
                $sql .= " ORDER BY A.pengakuan ASC";
            } else if($sort == 'down'){
                $sql .= " ORDER BY A.pengakuan DESC";
            }
        }
    } else {
        $sql .= " ORDER BY A.nama_penuh ASC";
    }

    // $strSQL=$sql. " LIMIT 10";
    // $rs = $conn->query($sql);
    $sSQL1 = "SELECT COUNT(*) as total FROM $schema2.calon A, $schema1.ref_negeri B WHERE A.negeri=B.KOD_NEGERI AND A.d_kemaskini IS NOT NULL AND A.d_kemaskini >=".tosql($dby);

    if(!empty($tkh_mula)){
        $sSQL1 .= " AND A.d_cipta LIKE '%".$tkh_mula."%'";
    }

    if(!empty($tkh_akhir)){
        $sSQL1 .= " AND A.d_kemaskini LIKE '%".$tkh_akhir."%'";
    }

    if(!empty($negeri)){
        $sSQL1 .= " AND B.kod=".tosql($negeri);
    }

    if(!empty($status)){
        if($status == 1){
            $sSQL1 .= " AND A.pengakuan='Y'";
        } else if($status == 2){
            $sSQL1 .= " AND A.pengakuan IS NULL";
        }
        
    }

    if(!empty($carian)){
        $sSQL1 .= " AND ((A.nama_penuh  LIKE '%".$carian."%') OR (A.ICNo  LIKE '%".$carian."%'))";
    }
        $sSQL1 .= " ORDER BY A.nama_penuh ASC";
    // }

?>
<div class="box" style="background-color:#F2F2F2">

    <div class="box-body">
        <input type="hidden" name="id" value="" />
        <div class="x_panel">
        <header class="panel-heading"  style="background-color:rgb(38, 167, 228)">
            <div class="panel-actions">
            <!--<a href="#" class="fa fa-caret-down"></a>
            <a href="#" class="fa fa-times"></a>-->
            </div>
            <h6 class="panel-title"><font color="#000000"><b>Maklumat Senarai Pemohon</b></font></h6> 
        </header>
        </div>
    </div>            
    <br />
    <div class="box-body d-print-none" style="background-color:#F2F2F2;">
        <div class="row" style="padding-bottom: 10px;">
            <div class="col-md-2 control-label">
                <label for="">Tarikh Mula Kemas kini: </label>
            </div>
            <div class="col-md-3">
                <input type="date" class="form-control" name="tkh_mula" id="tkh_mula" value="<?=$tkh_mula;?>">
            </div>  
            <div class="col-md-1 control-label">
                <label for=""></label>
            </div>
            <div class="col-md-3 control-label">
                <label for="">Tarikh Akhir Kemas kini: </label>
            </div>
            <div class="col-md-3">
                <input type="date" class="form-control" name="tkh_akhir" id="tkh_akhir" value="<?=$tkh_akhir;?>">
            </div> 
        </div>   
    </div> 
    <div class="box-body d-print-none" style="background-color:#F2F2F2;">
        <div class="row" style="padding-bottom: 10px;">
            <div class="col-md-2 control-label">
                <label for="">Jenis Skim: </label>
            </div>
            <div class="col-md-4">
                <?php
                    // $conn->debug=true;
                    $sql2 = "SELECT DISKRIPSI, KOD FROM $schema1.`ref_skim`";
                    $rsSkim = $conn->query($sql2);
                ?>

                <select name="skim" id="skim" class="form-control">
                    <option value="">Sila pilih skim jawatan</option>
                    <?php while(!$rsSkim->EOF){ $skim_code = $rsSkim->fields['KOD']; ?>    
                        <option value="<?=$skim_code;?>" <?php if($skim == $skim_code){ print 'selected';}?>><?php print $rsSkim->fields['DISKRIPSI'];?></option>
                    <?php $rsSkim->movenext(); } ?>
                </select>
            </div>  
            <div class="col-md-3">
                <label for="">Turutan Skim: </label>
            </div>
            <div class="col-md-3" style="background-color:#F2F2F2">
                <select name="turutan" id="turutan" class="form-control">
                    <option value="">Sila pilih turutan skim</option>
                    <option value="1" <?php if($turutan == 1){ print 'selected';}?>>1</option>
                    <option value="2" <?php if($turutan == 2){ print 'selected';}?>>2</option>
                    <option value="3" <?php if($turutan == 3){ print 'selected';}?>>3</option>
                </select>
            </div>
        </div>   
    </div> 
    <div class="box-body d-print-none" style="background-color:#F2F2F2;">
        <div class="row" style="padding-bottom: 10px;">
            <div class="col-md-2">
                <label for="">Negeri: </label>
            </div>
            <div class="col-md-3">
                <?php
                    $sql3 = "SELECT * FROM $schema1.`ref_negeri` WHERE `status`= 0";
                    $rsState = $conn->query($sql3);
                ?>
                <select name="negeri" id="negeri" class="form-control">
                    <option value="">Sila pilih Negeri</option>
                    <?php while(!$rsState->EOF){ $state_code = $rsState->fields['kod']; ?>    
                        <option value="<?=$state_code;?>" <?php if($negeri == $state_code){ print 'selected';}?>><?php print $rsState->fields['NEGERI'];?></option>
                    <?php $rsState->movenext(); } ?>
                </select>
            </div> 
            <div class="col-md-1">
                <label for=""></label>
            </div>
            <div class="col-md-3">
                <label for="">Status: </label>
            </div> 
            <div class="col-md-2">
                <select name="status" id="status" class="form-control">
                    <option value="">Sila pilih status</option>
                    <option value="2" <?php if($status == 2){ print 'selected';}?>>Draf</option>
                    <option value="1" <?php if($status == 1){ print 'selected';}?>>Hantar</option>
                </select>
            </div> 
        </div>   
    </div> 
    <div class="box-body d-print-none" style="background-color:#F2F2F2;">
        <div class="row">
            <div class="col-md-2">
                <label for="">Carian: </label>
            </div>
            <div class="col-md-4" style="background-color:#F2F2F2">
                <input type="text" name="carian" id="carian" class="form-control" placeholder="nama/no. kad pengenalan" value="<?=$carian;?>">
            </div>
            <div class="col-md-2" style="background-color:#F2F2F2">
                <button type="button" class="btn btn-primary" onclick="do_search('<?=$hrefs;?>',this.value)">
                    <i class=" fa fa-search"></i> <font style="font-family:Verdana, Geneva, sans-serif">Cari</font>
                </button>
            </div>
            <div class="col-md-2" align="right">
                <a href="" class="btn btn-md btn-success" data-toggle="tooltip" data-title="Salin Maklumat Kepada excel/csv" onclick="do_print('cetak.php?pages=pemohon/pemohon_cetak&prn=EXCEL&filename=senarai_pemohon')" >
                    <i class="fa fa-file-excel-o" aria-hidden="true"></i>
                </a>
                <a href="" class="btn btn-md btn-warning" data-toggle="tooltip" data-title="Salin Maklumat Kepada MS word" onclick="do_print('cetak.php?pages=pemohon/pemohon_cetak&prn=WORD&filename=senarai_pemohon')" >
                    <i class="fa fa-file-word-o" aria-hidden="true"></i>
                </a>
            </div>
            <?php
                // $sqlSijil = "SELECT * FROM $schema2.`calon_sijil`";
                // $rsSijil = $conn->query($sqlSijil);

                // while(!$rsSijil->EOF){ 
                //     $datas = print "'".$rsSijil->fields['sijil_nama']."',";
                //     $p = (explode(",",$datas));
                //     $cnt = count($p); $datap='';
                //     for($a=0;$a<$cnt;$a++){
                //         if($a==0){
                //             $datap="'".$p[$a]."'";
                //         } else {
                //             $datap.=",'".$p[$a]."'";
                //         }
                //     }
                // $rsSijil->movenext(); }

                // print $datap;

                // $files = array($datap);

                // // # create new zip opbject
                // $zip = new ZipArchive();

                // # create a temp file & open it
                // $tmp_file = tempnam('.','');
                // $zip->open($tmp_file, ZipArchive::CREATE);

                // # loop through each file
                // foreach($files as $file){

                //     # download file
                //     $download_file = file_get_contents($file);

                //     #add it to the zip
                //     $zip->addFromString(basename($file),$download_file);

                // }

                // # close zip
                // $zip->close();

                // # send the file to the browser as a download
                // header('Content-disposition: attachment; filename=Resumes.zip');
                // header('Content-type: application/zip');
                // readfile($tmp_file);
            ?>
            <div class="col-md-2" style="background-color:#F2F2F2; padding-left: 0px;">
                <a href="pemohon/dokumen_form.php?id=" class="btn btn-md btn-primary" data-toggle="modal" data-target="#myModal" title="Cetak Dokumen-dokumen Pemohon">
                    <i class="fa fa-print"></i> Cetak Dokumen
                </a>
            </div>
        </div>   
    </div> 
    <br>
        <!-- <div align="right">
            <a href="" onclick="window.print()">
                <button type="button" class="btn btn-sm btn-info">
                    <span style="cursor:pointer;" title="Cetak Semua Dokumen Pemohon">
                        <i class="fa fa-print" style="color: #FFFFFF;"></i> Cetak
                    </span>
                </button>
            </a>
        </div> -->
    <?php
        include '../include/list_head.php';
        include '../include/page_list.php';
        
    ?>
    <div class="box-body" style="background-color:#F2F2F2">
        <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
            <thead  style="background-color:rgb(38, 167, 228)">
                <th width="5%"><font color="#000000"><div align="center">Bil</div></font></th>
                <th width="28%" id="namaPemohon" name="namaPemohon">
                    <font color="#000000">
                        <div align="center">Nama Pemohon/Daftar/Kemaskini &nbsp;
                            <!-- <a href="<?php echo do_search($hrefs,'namaPemohon', 'down'); ?>" class="sort"><i class="fa fa-long-arrow-down text-dark" aria-hidden="true"></i></a>
                            <a href="<?php echo do_search($hrefs,'namaPemohon', 'up'); ?>" class="sort"><i class="fa fa-long-arrow-up text-dark" aria-hidden="true"></i></a> -->
                        </div>
                    </font>
                </th>
                <th width="18%">
                    <font color="#000000">
                        <div align="center">No. Kad Pengenalan &nbsp;
                            <!-- <a href="<?php echo do_search($hrefs,'noKP', 'down'); ?>" class="sort"><i class="fa fa-long-arrow-down text-dark" aria-hidden="true"></i></a>
                            <a href="<?php echo do_search($hrefs,'noKP', 'up'); ?>" class="sort"><i class="fa fa-long-arrow-up text-dark" aria-hidden="true"></i></a> -->
                        </div>
                    </font>
                </th>
                <th width="10%">
                    <font color="#000000">
                        <div align="center">Negeri &nbsp;
                            <!-- <a href="<?php echo do_search($hrefs,'negeri', 'down'); ?>" class="sort"><i class="fa fa-long-arrow-down text-dark" aria-hidden="true"></i></a>
                            <a href="<?php echo do_search($hrefs,'negeri', 'up'); ?>" class="sort"><i class="fa fa-long-arrow-up text-dark" aria-hidden="true"></i></a> -->
                        </div>
                    </font>
                </th>
                <th width="20%"><font color="#000000"><div align="center">Skim Jawatan</div></font></th>
                <th width="9%">
                    <font color="#000000">
                        <div align="center">Status &nbsp;
                            <!-- <a href="<?php echo do_search($hrefs,'status', 'down'); ?>" class="sort"><i class="fa fa-long-arrow-down text-dark" aria-hidden="true"></i></a>
                            <a href="<?php echo do_search($hrefs,'status', 'up'); ?>" class="sort"><i class="fa fa-long-arrow-up text-dark" aria-hidden="true"></i></a> -->
                        </div>
                    </font>
                </th>
                <!-- <th width="10%"><font color="#000000"><div align="center">Dokumen <br><small style="color: red;">Nota: Tanda untuk muat turun dokumen pemohon</small></div></font></th> -->
                <th width="10%" class="d-print-none"><font color="#000000"><div align="center">Tindakan</div></font></th>
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
                    $bil = $cnt + ($PageNo-1)*$PageSize; ?>	
                    <?php 
                        // $conn->debug=true;
                        $sql = "SELECT C.DISKRIPSI, C.KOD, A.id_pemohon, A.kod_jawatan FROM $schema2.calon_jawatan_dipohon A, $schema1.ref_skim C  WHERE A.kod_jawatan=C.KOD AND A.id_pemohon=".tosql($rs->fields['id_pemohon']);

                        if(!empty($skim)){
                            $sql .= " AND C.KOD=".tosql($skim);
                        }
                    
                        if(!empty($turutan)){
                            $sql .= " AND A.seq_no=".tosql($turutan);
                        }

                        $sql .= " ORDER BY A.seq_no ASC";

                        $rsJawatan = $conn->query($sql);
                    ?>
                    <tr>
                        <td align="center"><?=++$bil;?></td>
                        <td align="left">
                            <?=$rs->fields['nama_penuh']?> <br><br>
                            Daftar &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <?=DisplayDate($rs->fields['d_cipta']);  print '&nbsp;&nbsp;('.DisplayMasa($rs->fields['d_cipta']).')';?><br>
                            Kemas Kini : <?=DisplayDate($rs->fields['d_kemaskini']);  print '&nbsp;&nbsp;('.DisplayMasa($rs->fields['d_kemaskini']).')';?>
                        </td>
                        <td align="center"><?=$rs->fields['ICNo']?></td>
                        <td align="center"><?=$rs->fields['NEGERI']?></td>
                        <td>
                            <?php  while(!$rsJawatan->EOF){ 
                                print ++$bil2.'. '.$rsJawatan->fields['DISKRIPSI'].'<br>';
                            $rsJawatan->movenext(); } ?>
                        </td>
                        <td align="center">
                            <?php if($rs->fields['pengakuan'] == 'Y'){ ?>
                                <button class="btn-success badge">Hantar</button>
                            <?php } else { ?>
                                <button class="btn-warning badge">Draf</button>
                            <?php } ?>
                        </td>
                        <td align="center" class="d-print-none">
                            <a href="index.php?data=<?php print base64_encode('pemohon/maklumat_pemohon;Senarai Pemohon;Nama: '.$rs->fields['nama_penuh'].' (No.K/P: '.$rs->fields['ICNo'].');;;;'); ?>&id_pemohon=<?=$rs->fields['id_pemohon']?>">
                                <button type="button" class="btn btn-sm btn-success">
                                    <span style="cursor:pointer;color:red" title="Maklumat Terperinci Pemohon">
                                        <i class="fa fa-search" style="color: #FFFFFF;"></i>
                                    </span>
                                </button>
                            </a>
                            <button type="button" class="btn btn-sm btn-info" onclick="do_print('cetak.php?pages=pemohon/dokumen_print_all&prn=&id_pemohon=<?=$rs->fields['id_pemohon'];?>&filename=semua_dokumen_pemohon')">
                                <span style="cursor:pointer;" title="Cetak Semua Dokumen Pemohon">
                                    <i class="fa fa-print" style="color: #FFFFFF;"></i>
                                </span>
                            </button>
                        </td>
                    </tr>
                <?php 
                $cnt = $cnt + 1;
                $rs->movenext(); } ?>
            </tbody>
        </table>
    </div>

    <div class="card-footer">
        <?php 
            $href_f=$actual_link."&table_search=".$table_search;
            include 'include/list_footer.php'; 
        ?>  
    </div>
</div>   

          