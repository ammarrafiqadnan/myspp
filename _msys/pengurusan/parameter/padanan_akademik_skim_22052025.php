<link href="vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
<link href="vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
<link href="vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
<link href="vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">
<script>
    function do_cari(href, peringkat2){
        // alert('sini');
        var cari = $('#carian').val();
        
        window.location.href = href+"&peringkat2="+peringkat2+"&carian="+cari;
        
        // return sorturl;
    }
</script>
<?php
    // $conn->debug=true;
    $order_by=isset($_REQUEST["order_by"])?$_REQUEST["order_by"]:"";
    $sort=isset($_REQUEST["sort"])?$_REQUEST["sort"]:"";
    $peringkat2=isset($_REQUEST["peringkat2"])?$_REQUEST["peringkat2"]:"";
    $carian=isset($_REQUEST["carian"])?$_REQUEST["carian"]:"";

    $hrefs = 'index.php?data='.base64_encode('pengurusan/parameter/padanan_akademik_skim;Pentadbiran;Parameter;Padanan Peringkat Akademik Dan Skim;;;');
    
    $sql3 = "SELECT A.*, B.DISKRIPSI FROM $schema1.padanan_peringkatakademik_skim A, $schema1.`ref_skim` B WHERE A.kod_skim=B.KOD AND A.status=0 AND A.kod_peringkat_akademik=".tosql($peringkat2);

    if(!empty($carian)){
        $sql3 .= " AND B.DISKRIPSI  LIKE '%$carian%'";
    }

    $rsInstitusi = $conn->query($sql3);

if(!empty($peringkat2)){ $btn_disable ='';  }
else { $btn_disable='disabled';  }

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
            <h6 class="panel-title"><font color="#000000"><b>Senarai Maklumat Jawatan Berdasarkan Kelulusan</b></font></h6> 
        </header>
        </div>
    </div>            
    <br /> 
    <div class="col-md-12" style="background-color:#F2F2F2;">
        <div class="row" style="padding-bottom: 10px;">
            <div class="col-md-2">
                <label for="">Peringkat Akademik : </label>
            </div>
            <div class="col-md-3">
                <?php 
                    $sql = "SELECT * FROM $schema1.`ref_peringkat_akademik` WHERE is_deleted=0 AND `status`=0";
                    $rsPeringkat = $conn->query($sql);
                ?>
                <select name="peringkat" id="peringkat" class="form-control" onchange="do_cari('<?=$hrefs;?>', this.value)">
                    <option value="">Sila pilih peringkat akademik</option>
                    <?php while(!$rsPeringkat->EOF){ $code = $rsPeringkat->fields['kod']; ?>    
                        <option value="<?=$code;?>" <?php if($peringkat2 == $code){ print 'selected';}?>><?php print $rsPeringkat->fields['diskripsi'];?></option>
                    <?php $rsPeringkat->movenext(); } ?>
                </select>
            </div> 
            <div class="col-md-1">
                <label for="">Carian: </label>
            </div>
            <div class="col-md-3" style="background-color:#F2F2F2">
                <input type="text" name="carian" id="carian" value="<?=$carian;?>" class="form-control" placeholder="">
            </div>
            <div class="col-md-1" style="background-color:#F2F2F2">
                <button type="button" class="btn btn-info" onclick="do_cari('<?=$hrefs;?>','<?=$peringkat2?>')">
                    <i class=" fa fa-search"></i> <font style="font-family:Verdana, Geneva, sans-serif">Cari</font>
                </button>
            </div>
            <div class="col-md-2" style="background-color:#F2F2F2">
        	<a href="pengurusan/parameter/form_padananAkademikSkim.php?peringkat2=<?=$peringkat2;?>" class="btn btn-md btn-primary" data-toggle="modal" 
		data-target="#myModal" title="Tambah Maklumat Jawatan" <?=$btn_disable;?> >
            	<i class="fa fa-plus"></i> Tambah Jawatan
        	</a>
            </div>

        </div>   
    </div>
    <br>
    <br>
    <div class="box-body" style="background-color:#F2F2F2">
        <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
            <thead  style="background-color:rgb(38, 167, 228)">
                <th width="5%"><font color="#000000"><div align="center">No.</div></font></th>
                <th width="15%"><font color="#000000"><div align="center">Jawatan</div></font></th>
                <th width="5%"><font color="#000000"><div align="center">Tindakan</div></font></th>
            </thead>
            <tbody>
                <?php 
                    $bil = 0; 
                    while(!$rsInstitusi->EOF){ ?>
                    <tr>
                        <td align="center"><?=++$bil;?></td>
                        <td><?=$rsInstitusi->fields['DISKRIPSI'];?></td>
                        <td align="center">
                            <button type="button" class="btn btn-sm btn-danger" onclick="do_hapus('pengurusan/sql_pengurusan.php?frm=PARAMETER&jenis=PADANAN_PERINGKATAKADEMIK_SKIM&pro=HAPUS&peringkat2=<?=$peringkat2;?>&kod_skim=<?=$rsInstitusi->fields['kod_skim'];?>')">
                                <span style="cursor:pointer;color:red" title="Keluarkan maklumat universiti"><i class="fa fa-trash-o" style="color: #FFFFFF;"></i></span>
                            </button>
                        </td>
                    </tr>
                <?php $rsInstitusi->movenext(); } ?>
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
           