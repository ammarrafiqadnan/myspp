<link href="../vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
<link href="../vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
<link href="../vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
<link href="../vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" id="font-awesome-style-css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" type="text/css" media="all">
<link rel="stylesheet" id="font-awesome-style-css" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap.min.css" type="text/css" media="all">
<link rel="stylesheet" id="font-awesome-style-css" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap.min.css" type="text/css" media="all">


<script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.colVis.min.js"></script>

<script>
    function sortorder(href){
        // alert('sini');
        var cari = $('#carian').val();
        var peringkat2 = $('#peringkat2').val();
        var gkategori = $('#gkategori').val();

        // if(fieldname == 'peringkat'){
        //     window.location.href = href+"&order_by="+fieldname+"&peringkat2="+peringkat2;
        // } else if(fieldname == 'carian'){
            window.location.href = href+"&peringkat2="+peringkat2+"&gkategori="+gkategori+"&carian="+cari;
        // }
        // return sorturl;
    }
</script>
<?php
    // $conn->debug=true;
    $order_by=isset($_REQUEST["order_by"])?$_REQUEST["order_by"]:"";
    $sort=isset($_REQUEST["sort"])?$_REQUEST["sort"]:"";
    $peringkat2=isset($_REQUEST["peringkat2"])?$_REQUEST["peringkat2"]:"";
    $gkategori=isset($_REQUEST["gkategori"])?$_REQUEST["gkategori"]:"";
    $carian=isset($_REQUEST["carian"])?$_REQUEST["carian"]:"";


    if(empty($peringkat2)){ 
        $btn_disable_a='disabled'; $btn_disable_s='disabled'; $btn_disable_ln='disabled'; $tit="Sila klik maklumat peringkat terlebih dahulu"; 
    } else { 
        $btn_disable_a=''; $btn_disable_s=''; $btn_disable_ln='';  $tit="Sila klik maklumat menambah maklumat institusi"; 
        
        if($gkategori==1){ 
            $btn_disable_a=''; $btn_disable_s='disabled'; $btn_disable_ln='disabled';     
        } else if($gkategori==2){ 
            $btn_disable_a='disabled'; $btn_disable_s=''; $btn_disable_ln='disabled';     
        } else if($gkategori==3){ 
            $btn_disable_a='disabled'; $btn_disable_s='disabled'; $btn_disable_ln='';     
        }

    }






    $hrefs = 'index.php?data='.base64_encode('pengurusan/jawatan_kelulusan/senarai_jawatan_kelulusan;Pentadbiran;Parameter;Peringkat Kelulusan;;;');
    
    $sql3 = "SELECT A.*, B.DISKRIPSI, B.KATEGORI, B.JENIS_INSTITUSI, B.NEGARA FROM $schema1.padanan_peringkatkelulusan_institusi A, $schema1.`ref_institusi` B 
        WHERE A.kod_institusi=B.KOD AND A.status=0 AND A.is_deleted=0 AND B.SAH_YT='Y' ";
    if(!empty($peringkat2)){
	$sql3 .= " AND A.kod_peringkat_kelulusan=".tosql($peringkat2);
    }

    if(!empty($gkategori)){
        if($gkategori==1){
            $sql3 .= " AND B.JENIS_INSTITUSI=1 AND B.NEGARA='130'";
        } else if($gkategori==2){
            $sql3 .= " AND B.JENIS_INSTITUSI=2 AND B.NEGARA='130'";
        } else { 
            $sql3 .= " AND B.NEGARA!='130'";
        }
    }
    if(!empty($carian)){
        $sql3 .= " AND B.DISKRIPSI  LIKE '%".$carian."%'";
    }
    $sql = $sql3." ORDER BY B.DISKRIPSI";
    // $rsInstitusi = $conn->query($sql3);
    /*
	$count = "SELECT COUNT(*) as total FROM $schema1.padanan_peringkatkelulusan_institusi A, $schema1.`ref_institusi` B WHERE A.kod_institusi=B.KOD AND A.status=0 AND A.is_deleted=0 AND B.SAH_YT='Y' AND A.kod_peringkat_kelulusan=".tosql($peringkat2);

    if(!empty($carian)){
        $count .= " AND B.DISKRIPSI  LIKE '%".$carian."%'";
    }

    // $rsCount = $conn->query($count);
    */


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
            <h6 class="panel-title"><font color="#000000"><b>Senarai Institusi Berdasarkan Peringkat Kelulusan</b></font></h6> 
        </header>
        </div>
    </div>            
    <br /> 
    <div class="col-md-12" style="background-color:#F2F2F2;">
        <div class="row" style="padding-bottom: 10px;">
            <div class="col-md-2">
                <label for="">Peringkat Kelulusan: </label>
            </div>
            <div class="col-md-3">
                <?php 
                    $sqls = "SELECT * FROM $schema1.`ref_peringkat_kelulusan` WHERE is_deleted=0";
                    $rsPeringkat = $conn->query($sqls);
                ?>
                <select name="peringkat2" id="peringkat2" class="form-control" onchange="sortorder('<?=$hrefs;?>')">
                    <option value="">Sila pilih peringkat kelulusan</option>
                    <?php while(!$rsPeringkat->EOF){ $code = $rsPeringkat->fields['kod']; ?>    
                        <option value="<?=$code;?>" <?php if($peringkat2 == $code){ print 'selected';}?>><?php print $rsPeringkat->fields['diskripsi'];?></option>
                    <?php $rsPeringkat->movenext(); } ?>
                </select>
            </div> 
            <div class="col-md-1">
                <label for="">Kategori: </label>
            </div>
            <div class="col-md-2" style="background-color:#F2F2F2">
                <select name="gkategori" id="gkategori" class="form-control" onchange="sortorder('<?=$hrefs;?>')">
                    <option value="">Semua kategori</option>
                    <option value="1" <?php if($gkategori == '1'){ print 'selected';}?>>Awam (Dalam Negara)</option>
                    <option value="2" <?php if($gkategori == '2'){ print 'selected';}?>>Swasta (Dalam Negara)</option>
                    <option value="3" <?php if($gkategori == '3'){ print 'selected';}?>>Luar Negara</option>
                </select>
            </div>
            <div class="col-md-1">
                <label for="">Carian: </label>
            </div>
            <div class="col-md-3" style="background-color:#F2F2F2">
                <input type="text" name="carian" id="carian" value="<?=$carian;?>" class="form-control" placeholder="">
            </div>
        </div>   
    </div>
    <br>
    <div class="col-md-12" align="right">
        <button type="button" class="btn btn-success" onclick="sortorder('<?=$hrefs;?>')">
            <i class=" fa fa-search"></i> <font style="font-family:Verdana, Geneva, sans-serif">Cari</font>
        </button>
        <a href="pengurusan/jawatan_kelulusan/form_institusi.php?peringkat2=<?=$peringkat2;?>&kategori=awam" class="btn btn-md btn-primary" data-toggle="modal" data-target="#myModal-xl" data-backdrop=""  title="Tambah Maklumat Institusi Awam"" 
        <?php print $btn_disable_a;?>>
            <i class="fa fa-plus"></i> Tambah Institusi Awam
        </a>
        
        <a href="pengurusan/jawatan_kelulusan/form_institusi.php?peringkat2=<?=$peringkat2;?>&kategori=swasta" class="btn btn-md btn-info" data-toggle="modal" data-target="#myModal-xl" data-backdrop="" title="Tambah Maklumat Institusi Swasta" <?php print $btn_disable_s;?>>
            <i class="fa fa-plus"></i> Tambah Institusi Swasta
        </a>

        <a href="pengurusan/jawatan_kelulusan/form_institusi.php?peringkat2=<?=$peringkat2;?>&kategori=luarnegara" class="btn btn-md btn-default" data-toggle="modal" data-target="#myModal-xl" data-backdrop="" title="Tambah Maklumat Institusi Luar Negara"<?php print $btn_disable_ln;?>>
            <i class="fa fa-plus"></i> Tambah Institusi Luar Negara
        </a>

	<!--<a href="pengurusan/jawatan_kelulusan/test.php?peringkat2=<?=$peringkat2;?>&kategori=luarnegara" class="btn btn-md btn-default" data-toggle="modal" data-target="#myModal-xl" data-backdrop="" title="Tambah Maklumat Institusi Luar Negara"<?php print $btn_disable_ln;?>>
            <i class="fa fa-plus"></i> Tambah Institusi Luar Negara
        </a>-->

        <?php if(empty($peringkat2)){ print '<b><br>Sila pilih maklumat peringkat kelulusan terlebih dahulu</b>'; } ?>
    </div>
    <br>
    <?php include_once 'include/list_head.php'; ?>
    <?php include_once 'include/page_list.php'; ?>
    <div class="box-body" style="background-color:#F2F2F2">
        <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
            <thead  style="background-color:rgb(38, 167, 228)">
                <th width="5%"><font color="#000000"><div align="center">No.</div></font></th>
                <th width="15%"><font color="#000000"><div align="center">Institusi</div></font></th>
                <th width="15%"><font color="#000000"><div align="center">Peringkat Kelulusan</div></font></th>
                <th width="15%"><font color="#000000"><div align="center">Kategori</div></font></th>
                <th width="5%"><font color="#000000"><div align="center">Tindakan</div></font></th>
            </thead>
            <tbody>
<?php 
            if(!$rs->EOF) {
                $cnt = 0;
                $bil = $StartRec;
                while(!$rs->EOF){ 
                    //$bil++;
                    $bil = $cnt + ($PageNo-1)*$PageSize;
?>
                    <tr>
                        <td align="center"><?=++$bil;?></td>
                        <td><?=$rs->fields['DISKRIPSI'];?></td>
                        <td align="center">
                            <?php print dlookup("$schema1.`ref_peringkat_kelulusan`","diskripsi","kod=".tosql($rs->fields['kod_peringkat_kelulusan'])); ?>
                        </td>

                        <td align="center">
                            <?php 
                                if($rs->fields['JENIS_INSTITUSI'] == '1' && $rs->fields['NEGARA']=='130'){
                                    $kategori = 'AWAM';
                                } else if($rs->fields['JENIS_INSTITUSI'] == '2' && $rs->fields['NEGARA']=='130'){
                                    $kategori = 'SWASTA';
                                } else {                                     
                                    $kategori = 'LUAR NEGARA';
                                }

                                print $kategori;
                            ?>
                        </td>
                        <td align="center">
                            <button type="button" class="btn btn-sm btn-danger" onclick="do_hapus('pengurusan/sql_pengurusan1.php?frm=PARAMETER&jenis=PADANAN_PERINGKATKELULUSAN_INSTITUSI&pro=HAPUS&peringkat2=<?=$peringkat2;?>&kod_institusi=<?=$rs->fields['kod_institusi'];?>&kategori=<?=$kategori;?>&kod=<?=$rs->fields['kod']?>')">
                                <span style="cursor:pointer;color:red" title="Keluarkan maklumat universiti"><i class="fa fa-trash-o" style="color: #FFFFFF;"></i></span>
                            </button>
                        </td>
                    </tr>
            <?php 
                    $cnt = $cnt + 1;
                    $bil = $bil + 1;
                    $rs->movenext(); 
                } 
            }
            ?>
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
         
<script language="Javascript">
    $(document).ready(function() {
    var table = $('#example').DataTable( {
        lengthChange: false,
        //buttons: [ 'copy', 'excel', 'pdf', 'colvis' ]
    } );
 
    table.buttons().container()
        .appendTo( '#example_wrapper .col-sm-6:eq(0)' );
} );
</script>  