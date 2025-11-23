<?php include '../connection/common.php'; ?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>


<style type="text/css">
.icon {
  padding-right: 15px;
  margin-right: 10px;
  background: url("../cal/img/screenshot.gif") no-repeat right;
  background-size: 20px;
}
</style>


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
        var jenis = $('#jenis').val();
        window.location.href = href+"&tkh_mula="+tkh_mula+"&tkh_akhir="+tkh_akhir+"&skim="+skim+"&turutan="+turutan+"&negeri="+negeri+"&status="+status+'&carian='+carian;

        
        
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

    function hapus(val,idp){
        var tajuk=''; var frms='';
        if(val=='D'){
            frms='S';
            tajuk='Adakah anda pasti untuk menghapuskan data pemohon ini daripada senarai?';
        } else if(val=='L'){
            frms='S';
            tajuk='Adakah anda pasti untuk menghapuskan lampiran yang dimuatnaik oleh pemohon ini?';
        } else if(val=='A'){
            frms='S';
            tajuk='Adakah anda pasti untuk menghapuskan data dan lampiran pemohon ini?';
        } else if(val=='AD'){
            frms='ALL';
            tajuk='Adakah anda pasti untuk menghapuskan semua data daripada senarai ini?';
        } else if(val=='AL'){
            frms='ALL';
            tajuk='Adakah anda pasti untuk menghapuskan semua lampiran daripada senarai ini?';
        } else if(val=='AA'){
            frms='ALL';
            tajuk='Adakah anda pasti untuk menghapuskan semua data dan lampiran daripada senarai ini?';
        }
        swal({
            title: tajuk,
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Teruskan',
            cancelButtonText: 'Tidak, Batal!',
            reverseButtons: true
        }).then(function(e) {
            //e.preventDefault();
            $.ajax({
                url:'hkeeping/housekeeping_sql.php?frm='+frms+'&pro='+val+'&idp='+idp,
                type:'POST',
                //dataType: 'json',
                beforeSend: function () {
                    //$('.btn-primary').attr("disabled","disabled");
                    //$('.modal-body').css('opacity', '.5');
                },
                data: $("form").serialize(),
                //data: datas,
                success: function(data){
                    console.log(data);
                    // alert(data);
                    if(data=='OK' || data=='"OK"'){
                        // alert('sini');
                        swal({
                        title: 'Berjaya',
                        text: 'Maklumat telah berjaya dihapuskan',
                        type: 'success',
                        confirmButtonClass: "btn-success",
                        confirmButtonText: "Ok",
                        showConfirmButton: true,
                        }).then(function () {
                            location.reload();
                            // refresh = window.location; 
                            // window.location = refresh;
                        });
                    }
                    //window.location.reload();
                },
                //data: datas
            });
        });     

    }

</script>
<?php 
    //print $actual_link;
    //$conn->debug=true; 
    $m=isset($_REQUEST["m"])?$_REQUEST["m"]:"";
    $order_by=isset($_REQUEST["order_by"])?$_REQUEST["order_by"]:"";
    $sort=isset($_REQUEST["sort"])?$_REQUEST["sort"]:"";
    $tkh_mula=isset($_REQUEST["tkh_mula"])?$_REQUEST["tkh_mula"]:"";
    $tkh_akhir=isset($_REQUEST["tkh_akhir"])?$_REQUEST["tkh_akhir"]:"";
    $skim=isset($_REQUEST["skim"])?$_REQUEST["skim"]:"";
    $turutan=isset($_REQUEST["turutan"])?$_REQUEST["turutan"]:"";
    $negeri=isset($_REQUEST["negeri"])?$_REQUEST["negeri"]:"";
    $status=isset($_REQUEST["status"])?$_REQUEST["status"]:"";
    $jenis=isset($_REQUEST["jenis"])?$_REQUEST["jenis"]:"";
    $carian=isset($_REQUEST["carian"])?$_REQUEST["carian"]:"";

    if(empty($jenis)){ $jenis='K'; }

    $actual_link =  str_replace("&m=1","",$actual_link);	
    $_SESSION['SESSADM_BACKLINK']=$actual_link;
    if($m==1){ $_SESSION['SESSADM_NEGERI']=''; }	
    
    if(empty($negeri) && !empty($_SESSION['SESSADM_NEGERI'])){
	   $negeri=$_SESSION['SESSADM_NEGERI'];
    } else {
    	if($negeri!='-'){ $_SESSION['SESSADM_NEGERI']=$negeri; }
    	else { $negeri=''; }
    }

    if(empty($status)){ $status=3; }
    if(empty($tkh_mula) && !empty($tkh_akhir)){ $tkh_mula=$tkh_akhir; }

    $hrefs = 'index.php?data='.base64_encode('hkeeping/senarai_pemohon;Housekeeping;Senarai Pemohon Berdaftar;;;;');
    $_SESSION['SESS_LINKBACK']=$actual_link;

    $link = '&tkh_mula='.$tkh_mula.'&tkh_akhir='.$tkh_akhir.'&skim='.$skim.'&turutan='.$turutan.'&negeri='.$negeri.'&status='.$status.'&carian='.$carian.'&jenis='.$jenis;

    function do_search($href, $fieldname, $sort){
        $sorturl = $href."&order_by=".$fieldname."&sort=".$sort;
        return $sorturl;
    }



    $sqlT = dlookup("$schema2.`kawalan_tempoh_akaun`","tempoh","kod=1");
    $year = "-".$sqlT." year";
	//print $year;
    $dby = date("Y-m-d", strtotime($year));
    $currYear = date("Y", strtotime(now()));
    
    //print $dby;
    
    if($jenis=='D'){
        // tarikh daftar
        $val_tarikh = 'A.d_cipta';
    } else if($jenis=='K'){
        // Tarikh kemaskini
        $val_tarikh = 'A.d_kemaskini';
    }

   //$conn->debug=true;

	$sql = "SELECT A.id_pemohon,A.nama_penuh, A.ICNo,A.d_cipta,A.d_kemaskini,A.pengakuan,A.status_pemohon, A.negeri 
	FROM $schema2.calon A WHERE A.id_pemohon IS NOT NULL ";

    if(!empty($status)){
        if($status == 1){
        	$sql .= " AND A.pengakuan='Y'";
            if(!empty($tkh_mula)){
                if(!empty($tkh_akhir)){
                    $sql .= " AND (date($val_tarikh) BETWEEN ".tosql($tkh_mula)." AND ".tosql($tkh_akhir).")";
                } else {
                    $sql .= " AND date($val_tarikh) LIKE ".tosql($tkh_mula)."";
                }
            } else {
                // $sql .= " AND (year(A.d_cipta) LIKE ".tosql($currYear)." OR year(A.d_kemaskini) LIKE ".tosql($currYear).")";
            }

        } else if($status == 2){
            $sql .= " AND A.pengakuan IS NULL"; // AND A.status_pemohon IS NULL";
            if(!empty($tkh_mula)){
                if(!empty($tkh_akhir)){
                    $sql .= " AND (date($val_tarikh) BETWEEN ".tosql($tkh_mula)." AND ".tosql($tkh_akhir).")";
                } else {
                    $sql .= " AND date($val_tarikh) LIKE ".tosql($tkh_mula)."";
                }
            } else {
                // $sql .= " AND (year(A.d_cipta) LIKE ".tosql($currYear)." OR year(A.d_kemaskini) LIKE ".tosql($currYear).")";
            }
        } else if($status == 3){
            $sql .= " AND (A.pengakuan='Y' OR A.pengakuan IS NULL)";
            if(!empty($tkh_mula)){
                if(!empty($tkh_akhir)){
                    $sql .= " AND (date($val_tarikh) BETWEEN ".tosql($tkh_mula)." AND ".tosql($tkh_akhir).")";
                } else {
                    $sql .= " AND date($val_tarikh) LIKE ".tosql($tkh_mula)."";
                }
            } else {
                // $sql .= " AND (year(A.d_cipta) LIKE ".tosql($currYear)." OR year(A.d_kemaskini) LIKE ".tosql($currYear).")";
            }
        }
    } else {
        //$sql .= " AND (A.pengakuan IS NULL OR A.pengakuan='Y')";
    }
    // }


    if(!empty($carian)){
        $sql .= " AND ((A.nama_penuh  LIKE '%".$carian."%') OR (A.ICNo  LIKE '%".$carian."%'))";
    }

    $sql .= " GROUP BY A.ICNo ORDER BY A.nama_penuh ASC";
	
//print $sql;
$conn->debug=false;
?>

<!-- Select2 -->
<link rel="stylesheet" href="../plugins/select2/css/select2.min.css">
<link rel="stylesheet" href="../plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">

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
    <div class="col-md-12 d-print-none" style="background-color:#F2F2F2;">
        <div class="row" style="padding-bottom: 10px;">
	
	    <div class="col-md-1">
                <label for="">Berdasarkan : </label>
            </div> 
            <div class="col-md-2">
                <select name="jenis" id="jenis" class="form-control select2">
                    <option value="K" <?php if($jenis=='K'){ print 'selected';}?>>Tarikh Kemaskini</option>
                    <option value="D" <?php if($jenis=='D'){ print 'selected';}?>>Tarikh Daftar</option>
                </select>
            </div> 

            <div class="col-md-2 control-label">
                <label for="">Tarikh Mula : </label>
            </div>
            <div class="col-md-2">
		<!--<input type="text" name="tkh_mula" id="tkh_mula"  size="15" maxlength="10" value="<?=$tkh_mula;?>" 
		data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask 
		class="form-control disableFuturedate icon" style="background-color: #fff; cursor: pointer;">-->

		<input type="date" class="form-control" name="tkh_mula" id="tkh_mula" value="<?=$tkh_mula;?>">
            </div> 
	    <div class="col-md-1 control-label">
                <label for=""></label>
            </div> 
            
            <div class="col-md-2 control-label">
                <label for="">Tarikh Akhir : </label>
            </div>
            <div class="col-md-2">
                <input type="date" class="form-control" name="tkh_akhir" id="tkh_akhir" value="<?=$tkh_akhir;?>">
            </div> 
 
	    <div class="col-md-1">
                <label for=""></label>
            </div>
             
        </div>   
    </div> 
    <div class="col-md-12 d-print-none" style="background-color:#F2F2F2;">
        <div class="row">
            <div class="col-md-1">
                <label for="">Status: </label>
            </div> 
            <div class="col-md-2">
                <select name="status" id="status" class="form-control select2">
                    <option value="3" <?php if($status == 3){ print 'selected';}?>>Draf & Hantar</option>
                    <option value="2" <?php if($status == 2){ print 'selected';}?>>Draf</option>
                    <option value="1" <?php if($status == 1){ print 'selected';}?>>Hantar</option>
                </select>
            </div> 
 
            <div class="col-md-1">
                <label for="">Carian: </label>
            </div>
            <div class="col-md-3" style="background-color:#F2F2F2">
                <input type="text" name="carian" id="carian" class="form-control" placeholder="nama/no. kad pengenalan" value="<?=$carian;?>">
            </div>
            <div class="col-md-1" style="background-color:#F2F2F2">
                <button type="button" class="btn btn-primary" onclick="do_search('<?=$hrefs;?>',this.value)">
                    <i class=" fa fa-search"></i> <font style="font-family:Verdana, Geneva, sans-serif">Cari</font>
                </button>
            </div>

            <div class="col-md-1" style="background-color:#F2F2F2">
                <button type="button" class="btn btn-primary" onclick="hapus('AD','')" style="width:105px;text-align: left;">
                    <i class=" fa fa-trash-o"></i> <font style="font-family:Verdana, Geneva, sans-serif">Hapus Data</font>
                </button>
            </div>
            <div class="col-md-1" style="background-color:#F2F2F2">
                <button type="button" class="btn btn-primary" onclick="hapus('AL','')" style="width:105px;text-align: left;">
                    <i class=" fa fa-trash-o"></i> <font style="font-family:Verdana, Geneva, sans-serif">Hapus Lampiran</font>
                </button>
            </div>

            <div class="col-md-2" style="background-color:#F2F2F2">
                <button type="button" class="btn btn-primary" onclick="hapus('AA','')" style="width:150px;text-align: left;">
                    <i class=" fa fa-trash-o"></i> <font style="font-family:Verdana, Geneva, sans-serif">Hapus Data & Lampiran</font>
                </button>
            </div>


            <!-- <div class="col-md-2" align="right">
                <a href="" class="btn btn-md btn-success" data-toggle="tooltip" data-title="Salin Maklumat Kepada excel/csv" onclick="do_print('cetak.php?pages=pemohon/pemohon_cetak&prn=EXCEL&filename=senarai_pemohon')" >
                    <i class="fa fa-file-excel-o" aria-hidden="true"></i>
                </a>
                <a href="" class="btn btn-md btn-warning" data-toggle="tooltip" data-title="Salin Maklumat Kepada MS word" onclick="do_print('cetak.php?pages=pemohon/pemohon_cetak&prn=WORD&filename=senarai_pemohon')" >
                    <i class="fa fa-file-word-o" aria-hidden="true"></i>
                </a>
            </div> -->
         </div>   
    </div> 
    <br>
 
    <?php
	//$conn->debug=true;
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
                <th width="10%">
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
                <th width="25%"><font color="#000000"><div align="center">Skim Jawatan</div></font></th>
                <th width="7%">
                    <font color="#000000">
                        <div align="center">Status &nbsp;
                            <!-- <a href="<?php echo do_search($hrefs,'status', 'down'); ?>" class="sort"><i class="fa fa-long-arrow-down text-dark" aria-hidden="true"></i></a>
                            <a href="<?php echo do_search($hrefs,'status', 'up'); ?>" class="sort"><i class="fa fa-long-arrow-up text-dark" aria-hidden="true"></i></a> -->
                        </div>
                    </font>
                </th>
                <!-- <th width="15%"><font color="#000000"><div align="center">Dokumen <br><small style="color: red;">Nota: Tanda untuk muat turun dokumen pemohon</small></div></font></th> -->
                <th width="15%" class="d-print-none"><font color="#000000"><div align="center">Tindakan</div></font></th>
            </thead>
            <tbody>
        
            <?php 
                $cnt = 0;
			    $bil = 0; 
                
                //if(($rs1->fields['total']) > 0){
		        if(!$rs->EOF){
                    while(!$rs->EOF){ $bil2=0; 
                        $idp = $rs->fields['id_pemohon'];
                        $bil = $cnt + ($PageNo-1)*$PageSize; ?>	
                        <?php 
                            // $conn->debug=true;
                            $sql = "SELECT C.DISKRIPSI, C.KOD, A.id_pemohon, A.kod_jawatan FROM $schema2.calon_jawatan_dipohon A, 
                            $schema1.ref_skim C WHERE A.kod_jawatan=C.KOD AND A.id_pemohon=".tosql($rs->fields['id_pemohon']);
                            $sql .= " ORDER BY A.seq_no ASC";
                            $rsJawatan = $conn->query($sql);
				
                            $conn->debug=false;
                            $sqlPTemuduga = "SELECT B.kod, B.tajuk FROM $schema2.senarai_panggilan_temuduga A, $schema2.panggilan_temuduga B 
				            WHERE A.noKP=".tosql($rs->fields['ICNo']). " AND A.kod_panggilan_temuduga=B.kod";
                            $rsPanggilanTemuduga = $conn->query($sqlPTemuduga);

                            $sqlKTemuduga = "SELECT B.kod, B.tajuk FROM $schema2.senarai_keputusan_temuduga A, $schema2.keputusan_temuduga B 
				            WHERE A.noKP=".tosql($rs->fields['ICNo']). " AND A.kod_keputusan_temuduga=B.kod";
                            $rsKeputusanTemuduga = $conn->query($sqlKTemuduga);

                            //$conn->debug=true;

            				if(!empty($rs->fields['negeri'])){
            			    		//$rsNegeri = $conn->query("SELECT NEGERI FROM $schema1.ref_negeri WHERE KOD_NEGERI=".$rs->fields['negeri']."");
            					$negeri = dlookup("$schema1.ref_negeri","NEGERI","KOD_NEGERI=".tosql($rs->fields['negeri']));
            				}
            				//$conn->debug=false;
                        ?>
                        <tr>
                            <td align="center"><?=++$bil;?></td>
                            <td align="left">
                                <?=$rs->fields['nama_penuh']?> <br><br>
                                Daftar &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <?=DisplayDate($rs->fields['d_cipta']);  print '&nbsp;&nbsp;('.DisplayMasa($rs->fields['d_cipta']).')';?><br>
                                Kemas Kini : <?=DisplayDate($rs->fields['d_kemaskini']);  print '&nbsp;&nbsp;('.DisplayMasa($rs->fields['d_kemaskini']).')';?>
                            </td>
                            <td align="center"><?=$rs->fields['ICNo']?></td>
                            <td align="center"><?=$negeri;?></td>
                            <td>
                                <?php  while(!$rsJawatan->EOF){ 
                                    print ++$bil2.'. '.$rsJawatan->fields['DISKRIPSI'].'<br>';
                                $rsJawatan->movenext(); } ?>
                            </td>
                            <td align="center">
                                <?php if($rs->fields['pengakuan'] == 'Y'){  //&& $rs->fields['status_pemohon'] == 'Y' ?>
                                    <span class="badge" style="background-color: green;">Hantar</span><br><br>
                                    <?php if(!$rsPanggilanTemuduga->EOF){ 
                                        print 'Panggilan Temu Duga : <a href="index.php?data='.base64_encode('muatnaikExcel/senarai_pemohon_panggilan_temuduga;PENGURUSAN;Senarai Panggilan Temu Duga;;;'.$rsPanggilanTemuduga->fields['kod']).'&carian='.$rs->fields['ICNo'].'">'.$rsPanggilanTemuduga->fields['tajuk'].'</a>';

                                        if(!$rsKeputusanTemuduga->EOF){ 
                                            print '<br><br>';
                                        }
                                    }

                                    if(!$rsKeputusanTemuduga->EOF){ 
                                        print 'Keputusan Temu Duga : <a href="index.php?data='.base64_encode('muatnaikExcel/senarai_pemohon_keputusan_temuduga;PENGURUSAN;Senarai Keputusan Temu Duga;;;'.$rsKeputusanTemuduga->fields['kod']).'&carian='.$rs->fields['ICNo'].'">'.$rsKeputusanTemuduga->fields['tajuk'].'</a>';
                                    }
                                    ?>

                                <?php } else { ?>
                                    <span class="badge" style="background-color: #ed9c28;">Draf</span>
                                <?php } ?>


                            </td>
                            <td align="center" class="d-print-none">
                				<label class="btn btn-primary" title="Hapus data sahaja" onclick="hapus('D','<?=$idp;?>')">Hapus Data</label>
                				<label class="btn btn-warning" title="Hapus lampiran sahaja" onclick="hapus('L','<?=$idp;?>')">
                                Hapus Lampiran</label>
                				<label class="btn btn-info" title="Hapus maklumat data dan lampiran" onclick="hapus('A','<?=$idp;?>')">
                                Hapus Data & Lampiran</label>
                            </td>
                        </tr>
                    <?php 
                    $cnt = $cnt + 1;
                    $rs->movenext(); } 
                } else { ?>
                    <tr>
                        <td colspan="7" align="center">Tiada rekod dijumpai</td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <div class="card-footer">
        <?php 
            $href_f=$actual_link."&table_search=".$table_search;
	    //print $href_f;
            include 'include/list_footer.php'; 
        ?>  
    </div>
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


<script type="text/javascript">

// Use datepicker on the date inputs
//$("input[type=date]").datepicker({
  //dateFormat: 'yy-mm-dd',
  //onSelect: function(dateText, inst) {
    //$(inst).val(dateText); // Write the value in the input
  //}
//});

// Code below to avoid the classic date-picker
// $("input[type=date]").on('click', function() {
//   return false;
// });

// $(document).ready(function () {
//       var currentDate = new Date();
//       $('.disableFuturedate').datepicker({
//       format: 'dd/mm/yyyy',
//       autoclose:true,
//       endDate: "currentDate",
//       maxDate: currentDate
//    });
// });
</script>

<!--<script src="../plugins/inputmask/jquery.inputmask.min.js"></script>
<script src="../plugins/daterangepicker/daterangepicker.js"></script>

<script>
  $(function () {
    //Datemask dd/mm/yyyy
    $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
    //Datemask2 mm/dd/yyyy
    $('#datemask2').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
    //Money Euro
    $('[data-mask]').inputmask()
});
</script>
-->




          