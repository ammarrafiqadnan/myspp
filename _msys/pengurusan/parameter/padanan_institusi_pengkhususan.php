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
<!-- Select2 -->
<link rel="stylesheet" href="../plugins/select2/css/select2.min.css">
<link rel="stylesheet" href="../plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">

<?php
    //$conn->debug=true;
    $order_by=isset($_REQUEST["order_by"])?$_REQUEST["order_by"]:"";
    $sort=isset($_REQUEST["sort"])?$_REQUEST["sort"]:"";
    $institusi_kod=isset($_REQUEST["institusi_kod"])?$_REQUEST["institusi_kod"]:"";
    $carian=isset($_REQUEST["carian"])?$_REQUEST["carian"]:"";
    $peringkatKelulusan=isset($_REQUEST["peringkatKelulusan"])?$_REQUEST["peringkatKelulusan"]:"";

    $hrefs = 'index.php?data='.base64_encode('pengurusan/parameter/padanan_institusi_pengkhususan;Pentadbiran;Parameter;Padanan Institusi Dan Pengkhususan;;;');
    
    //start kod untuk awam
    $sql3 = "SELECT A.*, B.`DISKRIPSI`, B.`NO_PEMEROLEHAN`, B.`kod` AS KODS 
    FROM $schema1.padanan_institusi_pengkhususan A, $schema1.`ref_pengkhususan` B 
	WHERE A.kod_pengkhususan=B.kod AND A.is_deleted=0 AND B.is_deleted=0"; // AND A.kod_institusi=".tosql($institusi_kod);//." AND A.peringkat_kelulusan=".tosql($peringkatKelulusan);

    if(!empty($institusi_kod)){
        $sql3 .= " AND A.kod_institusi=".tosql($institusi_kod);
    }

    if(!empty($peringkatKelulusan)){
        $sql3 .= " AND A.id_peringkat_kelulusan=".tosql($peringkatKelulusan);
    }

    if(!empty($carian)){
        $sql3 .= " AND B.DISKRIPSI  LIKE '%".$carian."%'";
    }

    $sql3 .= " ORDER BY A.id_peringkat_kelulusan";

    $sql = $sql3;
//print $sql;
    //$rsPengkhususan = $conn->query($sql3);
    //$rec = $rsPengkhususan->recordcount();

    if(empty($institusi_kod)){ $disabled_btn='disabled'; } else { $disabled_btn=''; }
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
    <div class="col-md-12" style="background-color:#F2F2F2;">
        <div class="row"  style="padding-bottom: 10px;">
            <div class="col-md-1">
                <label for="">Institusi: </label>
            </div>
            <div class="col-md-5">
                <?php
                    $sql3 = "SELECT * FROM $schema1.`ref_institusi` WHERE `STATUS`= 0 AND is_deleted=0";
                    $rsInstitusi = $conn->query($sql3);
                ?>
                <select name="institusi" id="institusi" class="form-control select2" onchange="sortorder('<?=$hrefs;?>',this.value, 'institusi')">
                    <option value="">Sila pilih Institusi</option>
                    <?php while(!$rsInstitusi->EOF){ $code = $rsInstitusi->fields['KOD']; ?>    
                        <option value="<?=$code;?>" <?php if($institusi_kod == $code){ print 'selected';}?>><?php print $rsInstitusi->fields['DISKRIPSI'];?></option>
                    <?php $rsInstitusi->movenext(); } ?>
                </select>
            </div> 
            
            <div class="col-md-2">
                <label for="">Peringkat Kelulusan: </label>
            </div>
            <?php 
                // $rfKelulusan = $conn->query("SELECT * FROM $schema1.`ref_sijil_universiti` WHERE `sijil_YT`='Y' ORDER BY `sijil_susun`"); 
                $rfKelulusan = $conn->query("SELECT * FROM $schema1.`ref_peringkat_kelulusan` WHERE `is_deleted`='0' AND `status`=0"); 
            ?>
            <div class="col-md-4">
                <!-- <select name="peringkatKelulusan" id="peringkatKelulusan" class="form-control" onchange="sortorder('<?=$hrefs;?>',this.value, 'peringkatKelulusan')"> -->
                <select name="peringkatKelulusan" id="peringkatKelulusan" class="form-control" onchange="sortorder('<?=$hrefs;?>',this.value, 'peringkatKelulusan')">
                    <option value="">Sila pilih peringkat kelulusan</option>
                    <?php while(!$rfKelulusan->EOF){ ?>
                    <option value="<?=$rfKelulusan->fields['kod'];?>" <?php if($peringkatKelulusan==$rfKelulusan->fields['kod']){ print 'selected'; }?>><?php print $rfKelulusan->fields['diskripsi'];?></option>  
                    <?php $rfKelulusan->movenext(); } ?>
                </select>
            </div> 
        </div>  
    </div>
    <div class="col-md-12" style="background-color:#F2F2F2;">
        <div class="row" style="padding-bottom: 10px;">
            <div class="col-md-1">
                <label for="">Carian: </label>
            </div>
            <div class="col-md-3" style="background-color:#F2F2F2">
                <input type="text" name="carian" id="carian" value="<?=$carian;?>" class="form-control" placeholder="">
            </div>
            <div class="col-md-2" style="background-color:#F2F2F2">
                <button type="button" class="btn btn-info" onclick="sortorder('<?=$hrefs;?>',this.value, 'carian')" title="Sila klik untuk membuat carian maklumat">
                    <i class=" fa fa-search"></i> <font style="font-family:Verdana, Geneva, sans-serif">Cari</font>
                </button>
            </div>
            <!--
            <div class="col-md-3" align="right">
                <a href="pengurusan/parameter/form_padananInstitusiPengkhususan.php?institusi_kod=<?=$institusi_kod;?>&kategori=Ikhtisas&peringkatKelulusan=<?=$peringkatKelulusan;?>" class="btn btn-md btn-primary" data-toggle="modal" data-target="#myModal"  title="Tambah maklumat Pengkhusunan Ikhtisas" data-backdrop="">
                    <i class="fa fa-plus"></i> Pengkhususan Ikhtisas
                </a>
            </div>
            <div class="col-md-3" align="right">
                <a href="pengurusan/parameter/form_padananInstitusiPengkhususan.php?institusi_kod=<?=$institusi_kod;?>&kategori=BukanIkhtisas&peringkatKelulusan=<?=$peringkatKelulusan;?>" class="btn btn-md btn-primary" data-toggle="modal" data-target="#myModal" title="Tambah maklumat Pengkhusunan Bukan Ikhtisas" data-backdrop="">
                    <i class="fa fa-plus"></i> Pengkhususan Bukan Ikhtisas
                </a>
            </div>
            -->
            <div class="col-md-5" align="left">
                <a href="pengurusan/parameter/form_InstitusiPengkhususan.php?institusi_kod=<?=$institusi_kod;?>&peringkat=<?=$peringkatKelulusan;?>" class="btn btn-md btn-primary" data-toggle="modal" data-target="#myModal" title="Tambah maklumat Pengkhusunan Bukan Ikhtisas" data-backdrop="" <?=$disabled_btn;?>>
                    <i class="fa fa-plus"></i> Tambah Maklumat Pengkhususan
                </a><br>
                <?php if(!empty($disabled_btn)){ print "<b><i>Sila pilih maklumat Institusi terlebih dahulu.</i></b>"; } ?>
            </div>

        </div>   
    </div>
   <?php
        include '../include/list_head.php';
        include '../include/page_list.php';
        
    ?>
    <!--<div class="col-md-12" style="background-color:#F2F2F2;">
        <div class="row" style="padding-bottom: 10px;">
            <div class="col-md-12" align="right">
                <b>Terdapat <?php print $rec;?> Rekod Dijumpai</b> 
            </div>
        </div>
    </div>-->
    <br>
    <div class="box-body" style="background-color:#F2F2F2">
        <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
            <thead  style="background-color:rgb(38, 167, 228)">
                <th width="5%"><font color="#000000"><div align="center">No.</div></font></th>
                <th width="5%"><font color="#000000"><div align="center">Kod Padanan</div></font></th> 
                <th width="5%"><font color="#000000"><div align="center">Kod Pengkhususan</div></font></th>               
		<th width="15%"><font color="#000000"><div align="center">Pengkhususan</div></font></th>  
                <th width="5%"><font color="#000000"><div align="center">Kod Institusi</div></font></th>              
		<th width="15%"><font color="#000000"><div align="center">Nama Institusi</div></font></th>
                <th width="15%"><font color="#000000"><div align="center">Peringkat Kelulusan</div></font></th>
                <th width="12%"><font color="#000000"><div align="center">Kategori</div></font></th>
                <!--<th width="13%"><font color="#000000"><div align="center">No Pemerolehan</div></font></th>-->
                <th width="8%"><font color="#000000"><div align="center">Status</div></font></th>
                <th width="8%"><font color="#000000"><div align="center">Tindakan</div></font></th>
            </thead>
            <tbody>
                <?php 
                    // $conn->debug=true;
                    $bil = 0; 
                    while(!$rs->EOF){  
                        $bil = $cnt + ($PageNo-1)*$PageSize;
                        $kod_ip = $rs->fields['kod'];
                        $KODS = $rs->fields['KODS'];
                        $peringkat_pengajian = dlookup("$schema1.ref_peringkat_kelulusan","diskripsi","kod=".tosql($rs->fields['id_peringkat_kelulusan']));
                        $institusi_pengajian = dlookup("$schema1.ref_institusi","DISKRIPSI","KOD=".tosql($rs->fields['kod_institusi']));
                ?>
                    <tr>
                        <td align="center"><?=++$bil;?></td>
                        <td align="center"><?=$rs->fields['kod'];?></td>
                        <td align="center"><?=$KODS;?></td>
                        <td><?=$rs->fields['DISKRIPSI'];?></td>
                        <td align="center"><?=$rs->fields['kod_institusi'];?></td>
                        <td><?=$institusi_pengajian;?></td>
                        <td align="center"><?php print strtoupper($peringkat_pengajian);?></td>
                        <td align="center">
                            <?php if($rs->fields['kategori'] == '1'){
                                    $kategori = 'IKTISAS';
                                } else {
                                    $kategori = 'BUKAN IKHTISAS';
                                }

                                print $kategori;
                            ?>
                        </td>
                        <!--<td align="center"><?=$rs->fields['NO_PEMEROLEHAN'];?></td>-->
                        <td align="center">
                            <?php 
                            if($rs->fields['status'] == 0){
                                print '<button class="btn-success badge">Aktif</button>';
                            } else {
                                print '<button class="btn-danger badge">Tidak Aktif</button>';
                            }
                            ?>
                        </td>
                        <td align="center">
                            <a href="pengurusan/parameter/form_InstitusiPengkhususan.php?institusi_kod=<?=$institusi_kod;?>&peringkat=<?=$peringkatKelulusan;?>&kod_ip=<?=$kod_ip;?>" class="btn btn-sm btn-primary" data-toggle="modal"  data-target="#myModal" title="Kemaskini maklumat Pengkhusunan Bukan Ikhtisas" data-backdrop="" <?=$disabled_btn;?>>
                                <i class="fa fa-edit"></i>
                            </a>

                            <button type="button" class="btn btn-sm btn-danger" onclick="do_hapus('pengurusan/sql_pengurusan.php?frm=PARAMETER&jenis=PENGKHUSUSAN&pro=HAPUS&kod_ip=<?=$kod_ip;?>&kod=<?=$KODS;?>')">
                                <span style="cursor:pointer;color:red" title="Keluarkan maklumat universiti"><i class="fa fa-trash-o" style="color: #FFFFFF;"></i></span>
                            </button>
                        </td>
                    </tr>
                <?php $cnt = $cnt + 1; $rs->movenext(); } ?>
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
     $href_f=$actual_link."&table_search=".$table_search;
     include 'include/list_footer.php'; 
    ?>  
</div>

<script>
    $(function () {
        //Initialize Select2 Elements
        $('.select2').select2();
        //Initialize Select2 Elements
        $('.select2bs4').select2({
            theme: 'bootstrap4',
            maximumSelectionLength: 25,

            language: {
                // You can find all of the options in the language files provided in the
                // build. They all must be functions that return the string that should be
                // displayed.
                maximumSelected: function (e) {
                    var t = "PERHATIAN ! Telah Mencapai Had Maksimum Negeri";
                    // + e.maximum + " item";
                    e.maximum != 1;
                    return t;
                    // return t + ' - Upgrade Now and Select More';
                }
            }
            
        });
    });
</script>
<script src="../plugins/jquery/jquery.min.js"></script>
<script src="../plugins/select2/js/select2.full.min.js"></script>

           