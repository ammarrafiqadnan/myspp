<link href="vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
<link href="vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
<link href="vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
<link href="vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">
<script>
    function sortorder(href, val, fieldname){
        // alert('sini');
        var carian = $('#carian').val();
        var peringkatKelulusan = $('#peringkatKelulusan').val();
        var institusi = $('#institusi').val();

        //alert(carian);

        if(fieldname == 'institusi'){
            window.location.href = href+"&institusi_kod="+val;
        } else if(fieldname == 'peringkatKelulusan'){
            window.location.href = href+"&institusi_kod="+institusi+"&peringkatKelulusan="+val;
        } else if(fieldname == 'carian'){
            window.location.href = href+"&institusi_kod="+institusi+"&peringkatKelulusan="+peringkatKelulusan+'&carian='+carian;
        }

        
        
        // return sorturl;
    }
</script>
<?php
    //$conn->debug=true;
    $order_by=isset($_REQUEST["order_by"])?$_REQUEST["order_by"]:"";
    $sort=isset($_REQUEST["sort"])?$_REQUEST["sort"]:"";
    $institusi_kod=isset($_REQUEST["institusi_kod"])?$_REQUEST["institusi_kod"]:"";
    $carian=isset($_REQUEST["carian"])?$_REQUEST["carian"]:"";
    $peringkatKelulusan=isset($_REQUEST["peringkatKelulusan"])?$_REQUEST["peringkatKelulusan"]:"";

    $hrefs = 'index.php?data='.base64_encode('pengurusan/parameter/padanan_institusi_pengkhususan;Pentadbiran;Parameter;Padanan Institusi Dan Pengkhususan;;;');
    
    //start kod untuk awam
    $sql3 = "SELECT A.*, B.DISKRIPSI FROM $schema1.padanan_institusi_pengkhususan A, $schema1.`ref_pengkhususan` B WHERE A.kod_pengkhususan=B.kod AND A.status=0 AND B.`STATUS`=0 AND B.is_deleted=0";

    if(!empty($institusi_kod)){
        $sql3 .= " AND A.kod_institusi=".tosql($institusi_kod);
    }

    if(!empty($peringkatKelulusan)){
        $sql3 .= " AND A.peringkat_kelulusan=".tosql($peringkatKelulusan);
    }

    if(!empty($carian)){
        $sql3 .= " AND B.DISKRIPSI  LIKE '%".$carian."%'";
    }

    $rsPengkhususan = $conn->query($sql3);
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
            <h6 class="panel-title"><font color="#000000"><b>Padanan Institusi Dan Pengkhususan</b></font></h6> 
        </header>
        </div>
    </div>            
    <br /> 
    <div class="box-body" style="background-color:#F2F2F2;">
        <div class="row"  style="padding-bottom: 10px;">
            <div class="col-md-1">
                <label for="">Institusi: </label>
            </div>
            <div class="col-md-5">
                <?php
                    $sql3 = "SELECT * FROM $schema1.`ref_institusi` WHERE `STATUS`= 0 AND is_deleted=0";
                    $rsInstitusi = $conn->query($sql3);
                ?>
                <select name="institusi" id="institusi" class="form-control" onchange="sortorder('<?=$hrefs;?>',this.value, 'institusi')">
                    <option value="">Sila pilih Institusi</option>
                    <?php while(!$rsInstitusi->EOF){ $code = $rsInstitusi->fields['KOD']; ?>    
                        <option value="<?=$code;?>" <?php if($institusi_kod == $code){ print 'selected';}?>><?php print $rsInstitusi->fields['DISKRIPSI'];?></option>
                    <?php $rsInstitusi->movenext(); } ?>
                </select>
            </div> 
            
            <div class="col-md-2">
                <label for="">Peringkat Kelulusan: </label>
            </div>
            <div class="col-md-4">
                <select name="peringkatKelulusan" id="peringkatKelulusan" class="form-control" onchange="sortorder('<?=$hrefs;?>',this.value, 'peringkatKelulusan')">
                    <option value="">Sila pilih peringkat kelulusan</option>
                    <option value="1" <?php if($peringkatKelulusan == 1){ print 'selected';} ?>>Diploma</option>
                    <option value="2" <?php if($peringkatKelulusan == 2){ print 'selected';} ?>>Ijazah</option>
                    <option value="3" <?php if($peringkatKelulusan == 3){ print 'selected';} ?>>Master</option>
                    <option value="4" <?php if($peringkatKelulusan == 4){ print 'selected';} ?>>PHD</option>
                </select>
            </div> 
        </div>   
    </div>
    <div class="box-body" style="background-color:#F2F2F2;">
        <div class="row" style="padding-bottom: 10px;">
            <div class="col-md-1">
                <label for="">Carian: </label>
            </div>
            <div class="col-md-3" style="background-color:#F2F2F2">
                <input type="text" name="carian" id="carian" value="<?=$carian;?>" class="form-control" placeholder="">
            </div>
            <div class="col-md-2" style="background-color:#F2F2F2">
                <button type="button" class="btn btn-info" onclick="sortorder('<?=$hrefs;?>',this.value, 'carian')">
                    <i class=" fa fa-search"></i> <font style="font-family:Verdana, Geneva, sans-serif">Cari</font>
                </button>
            </div>
            <div class="col-md-3" align="right">
                <a href="pengurusan/parameter/form_padananInstitusiPengkhususan.php?institusi_kod=<?=$institusi_kod;?>&kategori=Ikhtisas&peringkatKelulusan=<?=$peringkatKelulusan;?>" class="btn btn-md btn-primary" data-toggle="modal" data-target="#myModal" title="Tambah Maklumat Notifikasi">
                    <i class="fa fa-plus"></i> Pengkhususan Ikhtisas
                </a>
            </div>
            <div class="col-md-3" align="right">
                <a href="pengurusan/parameter/form_padananInstitusiPengkhususan.php?institusi_kod=<?=$institusi_kod;?>&kategori=BukanIkhtisas&peringkatKelulusan=<?=$peringkatKelulusan;?>" class="btn btn-md btn-primary" data-toggle="modal" data-target="#myModal" title="Tambah Maklumat Notifikasi">
                    <i class="fa fa-plus"></i> Pengkhususan Bukan Ikhtisas
                </a>
            </div>
        </div>   
    </div>
    <br>
    <div class="box-body" style="background-color:#F2F2F2">
        <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
            <thead  style="background-color:rgb(38, 167, 228)">
                <th width="5%"><font color="#000000"><div align="center">No.</div></font></th>
                <th width="15%"><font color="#000000"><div align="center">Pengkhususan</div></font></th>
                <th width="15%"><font color="#000000"><div align="center">Kategori</div></font></th>
                <th width="5%"><font color="#000000"><div align="center">Tindakan</div></font></th>
            </thead>
            <tbody>
                <?php 
                    $bil = 0; 
                    while(!$rsPengkhususan->EOF){ ?>
                    <tr>
                        <td align="center"><?=++$bil;?></td>
                        <td><?=$rsPengkhususan->fields['DISKRIPSI'];?></td>
                        <td align="center">
                            <?php if($rsPengkhususan->fields['kategori'] == '1'){
                                    $kategori = 'IKTISAS';
                                } else {
                                    $kategori = 'BUKAN IKHTISAS';
                                }

                                print $kategori;
                            ?>
                        </td>
                        <td align="center">
                            <button type="button" class="btn btn-sm btn-danger" onclick="do_hapus('pengurusan/sql_pengurusan.php?frm=PARAMETER&jenis=PADANAN_INSTITUSI_PENGKHUSUSAN&pro=HAPUS&institusi_kod=<?=$institusi_kod;?>&peringkatKelulusan=<?=$rsPengkhususan->fields['peringkat_kelulusan'];?>&kod_pengkhususan=<?=$rsPengkhususan->fields['kod_pengkhususan'];?>')">
                                <span style="cursor:pointer;color:red" title="Keluarkan maklumat universiti"><i class="fa fa-trash-o" style="color: #FFFFFF;"></i></span>
                            </button>
                        </td>
                    </tr>
                <?php $rsPengkhususan->movenext(); } ?>
            </tbody>
        </table>
    </div>
    <div class="box-body">
        <a class="btn btn-md btn-success" href="index.php?data=<?php print base64_encode('pengurusan/parameter;Pengurusan;Parameter;ALL;;;'); ?>">
            <i class="fa fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<div class="card-footer">
    <?php 
    // $href_f=$actual_link."&table_search=".$table_search;
    // include 'include/list_footer.php'; 
    ?>  
</div>
           