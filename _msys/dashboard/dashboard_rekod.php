<style type="text/css">
.icon {
  padding-right: 15px;
  margin-right: 10px;
  background: url("../cal/img/screenshot.gif") no-repeat right;
  background-size: 20px;
}
</style>

<script>
    function sortorder(href){
        var start_dt = $('#start_dt').val();
        var end_dt = $('#end_dt').val();

        window.location.href = href+"?start_dt="+start_dt+"&end_dt="+end_dt;
    }
</script>
<?php 
	//$conn->debug=true; 
    $hrefs = 'index.php';
    $start_dt=strtoupper(isset($_REQUEST["start_dt"])?$_REQUEST["start_dt"]:"");
    $end_dt=strtoupper(isset($_REQUEST["end_dt"])?$_REQUEST["end_dt"]:"");
    

    $sqlT = dlookup("$schema2.`kawalan_tempoh_akaun`","tempoh","kod=1");

    $year = "-".$sqlT." year";

    $dby = date("Y-m-d", strtotime($year));

    $currYear = date("Y", strtotime(now()));

    $now = date("Y-m-d", strtotime(now()));

//$conn->debug=true;
    $sql = "SELECT COUNT(*) as total FROM $schema2.calon A WHERE A.d_cipta IS NOT NULL";

    if(!empty($start_dt)){
        if(!empty($end_dt)){
            //$sql .= " AND (date(A.d_cipta) BETWEEN ".tosql($start_dt)." AND ".tosql($end_dt)." OR date(A.d_kemaskini) BETWEEN ".tosql($start_dt)." AND ".tosql($end_dt).")";
            	$sql .= " AND (date(A.tarikh_akuan) BETWEEN ".tosql($start_dt)." AND ".tosql($end_dt).")";
		$sql .= " AND A.pengakuan='Y'";
        } else {
	    $sql .= " AND (date(A.tarikh_akuan) LIKE ".tosql($start_dt).")";
            //$sql .= " AND (date(A.d_cipta) LIKE ".tosql($start_dt)." OR date(A.d_kemaskini) LIKE ".tosql($start_dt).")";
            $sql .= " AND A.pengakuan='Y'";
        }
    } else {
	$sql .= " AND (year(A.tarikh_akuan) LIKE ".tosql($currYear).")";
        //$sql .= " AND (year(A.d_cipta) LIKE ".tosql($currYear)." OR year(A.d_kemaskini) LIKE ".tosql($currYear).")";
        $sql .= " AND A.pengakuan='Y'";
    }
    //print $sql;
    $rsHantar = $conn->query($sql); 
//$conn->debug=false;
   

    //$hantar = $rs->recordcount(); //hantar
    //$conn->debug=true;
    $sql2 = "SELECT COUNT(*) as total FROM $schema2.calon A WHERE A.d_cipta IS NOT NULL";


    if(!empty($start_dt)){
        if(!empty($end_dt)){
            $sql2 .= " AND (date(A.d_cipta) BETWEEN ".tosql($start_dt)." AND ".tosql($end_dt)." OR date(A.d_kemaskini) BETWEEN ".tosql($start_dt)." AND ".tosql($end_dt).")";
            $sql2 .= " AND A.pengakuan IS NULL AND A.status_pemohon IS NULL";
        } else {
            $sql2 .= " AND (date(A.d_cipta) LIKE".tosql($start_dt)." OR date(A.d_kemaskini) LIKE ".tosql($start_dt).")";
            $sql2 .= " AND A.pengakuan IS NULL AND A.status_pemohon IS NULL";
        }
    }  else {
        $sql2 .= " AND (year(A.d_cipta) LIKE ".tosql($currYear)." OR year(A.d_kemaskini) LIKE ".tosql($currYear).")";
        $sql2 .= " AND A.pengakuan IS NULL AND A.status_pemohon IS NULL";
    }
    
    $rsDraf = $conn->query($sql2);  //draf
	//$conn->debug=false;

    
//$conn->debug=true;
$semalam = date($start_dt, strtotime("-1 days"))." 23:59:59"; 

//$givenDate = "2021-09-01";
$timestampForGivenDate = strtotime ( $start_dt );
$englishText = '-1 day';
$requireDateFormat = "Y-m-d";
$semalam = date($requireDateFormat,strtotime ( $englishText , $timestampForGivenDate ))." 23:59:59" ;


    if(!empty($start_dt)){
	$sqlA = "SELECT COUNT(*) as total FROM $schema2.calon A WHERE A.d_cipta IS NOT NULL AND A.d_kemaskini IS NOT NULL";

        if(!empty($end_dt)){
            //$sqlA .= " AND (date(A.d_cipta) BETWEEN ".tosql($start_dt)." AND ".tosql($end_dt)." OR date(A.d_kemaskini) BETWEEN ".tosql($start_dt)." AND ".tosql($end_dt).")";
            $sqlA .= " AND date(A.d_cipta)<='{$semalam}' AND (date(A.d_kemaskini) BETWEEN ".tosql($start_dt)." AND ".tosql($end_dt).")";
            //$sqlA .= " AND A.status_pemohon='Y'";
        } else {
            $sqlA .= " AND (date(A.d_kemaskini) > ".tosql($start_dt).")";
            //$sqlA .= " AND A.status_pemohon='Y'";
        }
    } else {
        $sqlA = "SELECT COUNT(*) as total FROM $schema2.calon A WHERE A.d_cipta IS NOT NULL AND A.d_kemaskini IS NOT NULL AND A.d_cipta NOT LIKE '%".$now." %'";

        $sqlA .= " AND (year(A.d_cipta) LIKE ".tosql($currYear).")";
        //$sqlA .= " AND A.pengakuan='Y'";
    }
    
    $rsAkaunSediaAda = $conn->query($sqlA); //akaun sedia ada
//$conn->debug=false;

	//$conn->debug=true;
    

    if(!empty($start_dt)){
	$sqlB = "SELECT COUNT(*) as total FROM $schema2.calon A WHERE A.d_cipta IS NOT NULL";

        if(!empty($end_dt)){
            //$sqlB .= " AND (date(A.d_cipta) BETWEEN ".tosql($start_dt)." AND ".tosql($end_dt)." OR date(A.d_kemaskini) BETWEEN ".tosql($start_dt)." AND ".tosql($end_dt).")";
            $sqlB .= " AND (date(A.d_cipta) BETWEEN ".tosql($start_dt)." AND ".tosql($end_dt).")";
            $sqlB .= " AND A.status_pemohon IS NULL";
        } else {
            $sqlB .= " AND (date(A.d_cipta) LIKE ".tosql($start_dt).")";
            $sqlB .= " AND A.status_pemohon IS NULL";
        }
    } else {
	$sqlB = "SELECT COUNT(*) as total FROM $schema2.calon A WHERE A.d_cipta IS NOT NULL AND A.d_cipta LIKE '%".$now." %'";

        $sqlB .= " AND (year(A.d_cipta) LIKE ".tosql($currYear).")";
        //$sqlB .= " AND A.pengakuan IS NULL AND A.status_pemohon IS NULL";
    }
    
    $rsAkaunBaru = $conn->query($sqlB); //akaun baru
	
$conn->debug=false;

    
    //$conn->debug=true;
    $sSQL1 = "SELECT COUNT(*) as total FROM $schema2.`senarai_panggilan_temuduga` WHERE kod IS NOT NULL AND is_deleted=0";

    $rsPanggilan = $conn->query($sSQL1); 
    //$conn->debug=false;

    $sSQL2 = "SELECT COUNT(*) as total FROM $schema2.`senarai_keputusan_temuduga` WHERE kod IS NOT NULL AND is_deleted=0";

    $rsKeputusan = $conn->query($sSQL2); 

    //$draf = $rs2->recordcount(); //hantar

    // print $total;

$jum = $rsAkaunBaru->fields['total'] + $rsAkaunSediaAda->fields['total'];
//print $jum;
$draff = $jum - $rsHantar->fields['total'];
?>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <?php
            //$conn->debug=true;
            $now = date('Y-m-d', strtotime(now()));
            $sql = "SELECT * FROM $schema2.`hebahan_makluman` WHERE is_deleted=0 AND jenis=2 AND tarikh_mula <=" .tosql($now)." AND tarikh_tamat >=".tosql($now); 
            $hebahan = $conn->query($sql);
        ?>
        <!--<marquee class="marq" behavior="" direction="left" onmouseover="this.stop();" onmouseout="this.start();">
            <?php while(!$hebahan->EOF){
                print "<a href='pengurusan/hebahan_maklumat_form.php?id=".$hebahan->fields['kod']."&jenis=view' data-toggle='modal' data-target='#myModal-xl'><i class='fa fa-bullhorn' aria-hidden='true'></i> ".$hebahan->fields['tajuk']."</a>&nbsp;";
            $hebahan->movenext(); } ?>
        </marquee>-->
        <div class="x_panel">
            <div class="x_title">
		<div style="float:right"class="col-sm-4">
<?php $user = dlookup("$schema2.user_log","count(*)","1"); ?>
    <div class="col-sm-8" align="center">
        <a href="dashboard/user_online.php" data-toggle="modal" data-target="#myModal" title="Pengguna Online" class="fa col-sm-12" data-backdrop="">
          <div class="small-box bg-gray">
            <div class="inner">
              <i class=" fa fa-users"></i> <font style="font-family:Verdana, Geneva, sans-serif"> <b><?=$user;?> Pemohon Online</b></font>
            </div>
          </div>
        </a>  
    </div>
</div>
                <h2><b>Dashboard</b> </h2>
                <div class="clearfix"></div>
            </div>
			<br />	
	
            <!-- MULA BARIS PERTAMA -->
            <div class="clearfix"></div>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-2">
                                    <label for="">Tarikh Mula: </label>
                                </div>
                                <div class="col-md-3">
					<!--<input type="text" name="start_dt" id="start_dt"  size="15" maxlength="10" value="<?=$start_dt;?>" 
					data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask 
					class="form-control disableFuturedate icon" style="background-color: #fff; cursor: pointer;">-->

                                    <input type="date" id="start_dt" name="start_dt" class="form-control" value="<?=$start_dt;?>">
                                </div>  
                                <div class="col-md-2">
                                    <label for="">Tarikh Akhir: </label>
                                </div>
                                <div class="col-md-3">
					<!--<input type="text" name="end_dt" id="end_dt"  size="15" maxlength="10" value="<?=$end_dt;?>" 
					data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask 
					class="form-control disableFuturedate icon" style="background-color: #fff; cursor: pointer;">-->

                                    <input type="date" id="end_dt" name="end_dt" class="form-control" value="<?=$end_dt;?>">
                                </div>
                                <div class="col-md-2">
                                    <button type="button" class="btn btn-primary" onclick="sortorder('<?=$hrefs;?>')">
                                        <i class=" fa fa-search"></i> <font style="font-family:Verdana, Geneva, sans-serif">Cari</font>
                                    </button>
                                </div> 
                            </div>   
                    </div>
                </div>
            </div>
	    <div class="col-md-12 col-lg-12 col-xl-12">
                <div class="row"> 
                    <div class="col-md-12 col-lg-6 col-xl-6">
                        <section class="panel panel-featured-left panel-featured-success">
                            <div class="panel-body">
                                <div class="widget-summary">
                                    <div class="widget-summary-col widget-summary-col-icon">
                                        <div class="summary-icon bg-success">
                                            <i class="fa fa-users"></i>
                                        </div>
                                    </div>
                                    <div class="widget-summary-col">
                                        <div class="summary">
                                            <h6 class="title visible-lg visible-md">Akaun  </h6>
                                            <h6 class="title visible-xs">Akaun </h6>
                                            <div class="info">
                                                <strong style="font-size: 14px"><?//=$jum;?> Sedia Ada<br>&nbsp;</strong>
                                            </div>
                                            
                                            <div class="danger">
                                                <strong style="font-size: 14px; color: red"><?=$rsAkaunSediaAda->fields['total'];?></strong>
                                            </div>
                                        </div>
                                        <!--<div class="summary-footer">
                                            <a href="index.php?data=<?php print base64_encode('pemohon/senarai_pemohon;Pengurusan;Senarai Pemohon;;;;'); ?>&tkh_mula=<?=$start_dt;?>&tkh_akhir=<?=$end_dt;?>&skim=&turutan=&negeri=&status=2&carian=" class="text-muted"><i class="fa fa-eye"></i> Paparan Maklumat</a>
                                        </div>-->
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
		    <div class="col-md-12 col-lg-6 col-xl-6">
                        <section class="panel panel-featured-left panel-featured-primary">
                            <div class="panel-body">
                                <div class="widget-summary">
                                    <div class="widget-summary-col widget-summary-col-icon">
                                        <div class="summary-icon bg-primary">
                                            <i class="fa fa-users"></i>
                                        </div>
                                    </div>
                                    <div class="widget-summary-col">
                                        <div class="summary">
                                            <h6 class="title visible-lg visible-md">Akaun</h6>
                                            <h6 class="title visible-xs">Akaun</h6>
                                            <div class="info">
                                                <strong style="font-size: 14px"><?//=$jum;?> Baru<br>&nbsp;</strong>
                                            </div>
                                            
                                            <div class="danger">
                                                <strong style="font-size: 14px; color: red"><?=$rsAkaunBaru->fields['total'];?></strong>
                                            </div>
                                        </div>
                                        <!--<div class="summary-footer">
                                            <a href="index.php?data=<?php print base64_encode('pemohon/senarai_pemohon;Pengurusan;Senarai Pemohon;;;;'); ?>&tkh_mula=<?=$start_dt;?>&tkh_akhir=<?=$end_dt;?>&skim=&turutan=&negeri=&status=2&carian=" class="text-muted"><i class="fa fa-eye"></i> Paparan Maklumat</a>
                                        </div>-->
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
		</div>
                <div class="row"> 
                    <div class="col-md-12 col-lg-3 col-xl-3">
                        <section class="panel panel-featured-left panel-featured-warning">
                            <div class="panel-body">
                                <div class="widget-summary">
                                    <div class="widget-summary-col widget-summary-col-icon">
                                        <div class="summary-icon bg-warning">
                                            <i class="fa fa-pencil-square-o"></i>
                                        </div>
                                    </div>
                                    <div class="widget-summary-col">
                                        <div class="summary">
                                            <h3 class="title visible-lg visible-md">Permohonan </h3>
                                            <h3 class="title visible-xs">Permohonan</h3>
                                            <div class="info">
                                                <strong style="font-size: 14px"><?//=$jum;?> Draf<br>&nbsp;</strong>
                                            </div>
                                            
                                            <div class="danger">
                                                <strong style="font-size: 14px; color: red"><?=$rsDraf->fields['total']; //$rsAkaunBaru->fields['total']?></strong>
                                            </div>
                                        </div>
                                        <div class="summary-footer">
                                            <a href="index.php?data=<?php print base64_encode('pemohon/senarai_pemohon;Pengurusan;Senarai Pemohon;;;;'); ?>&tkh_mula=<?=$start_dt;?>&tkh_akhir=<?=$end_dt;?>&skim=&turutan=&negeri=&status=2&carian=&m=1" class="text-muted"><i class="fa fa-eye"></i> Paparan Maklumat</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                    
                    <div class="col-md-12 col-lg-3 col-xl-3">
                        <section class="panel panel-featured-left panel-featured-tertiary">
                            <div class="panel-body">
                                <div class="widget-summary">
                                    <div class="widget-summary-col widget-summary-col-icon">
                                        <div class="summary-icon bg-tertiary">
                                            <i class="fa fa-paper-plane"></i>
                                        </div>
                                    </div>
                                    <div class="widget-summary-col">
                                        <div class="summary">
                                            <h3 class="title visible-lg visible-md">Permohonan</h3>
                                            <h3 class="title visible-xs">Permohonan</h3>
                                            <div class="info">
                                                <strong style="font-size: 14px"><?//=$bil_skm;?> Hantar <br>&nbsp;</strong>
                                            </div>
                                            
                                            <div class="info">
                                                <strong style="font-size: 14px; color: green"><?=$rsHantar->fields['total']?></strong>
                                            </div>
                                        </div>
                                        <div class="summary-footer">
                                            <a href="index.php?data=<?php print base64_encode('pemohon/senarai_pemohon;Pengurusan;Senarai Pemohon;;;;'); ?>&tkh_mula=<?=$start_dt;?>&tkh_akhir=<?=$end_dt;?>&skim=&turutan=&negeri=&status=1&carian=&m=1" class="text-muted"><i class="fa fa-eye"></i> Paparan Maklumat</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>

                    <div class="col-md-12 col-lg-3 col-xl-3">
                        <section class="panel panel-featured-left panel-featured-secondary">
                            <div class="panel-body">
                                <div class="widget-summary">
                                    <div class="widget-summary-col widget-summary-col-icon">
                                        <div class="summary-icon bg-secondary">
                                            <i class="fa fa-list-alt"></i>
                                        </div>
                                    </div>
                                    <div class="widget-summary-col">
                                        <div class="summary">
                                            <h3 class="title visible-lg visible-md">Permohonan </h3>
                                            <h3 class="title visible-xs">Permohonan</h3>
                                            <div class="info">
                                                <strong style="font-size: 14px"><?//=$jum;?> Panggilan <br> Temu Duga</strong>
                                            </div>
                                            
                                            <div class="danger">
                                                <strong style="font-size: 14px; color: red"><?=$rsPanggilan->fields['total'];?></strong>
                                            </div>
                                        </div>
                                        <div class="summary-footer">
                                            <a href="index.php?data=<?php print base64_encode('pemohon/senarai_pemohon;Pengurusan;Senarai Pemohon;;;;'); ?>&tkh_mula=<?=$start_dt;?>&tkh_akhir=<?=$end_dt;?>&skim=&turutan=&negeri=&status=3&carian=" class="text-muted"><i class="fa fa-eye"></i> Paparan Maklumat</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                    
                    <div class="col-md-12 col-lg-3 col-xl-3">
                        <section class="panel panel-featured-left panel-featured-info">
                            <div class="panel-body">
                                <div class="widget-summary">
                                    <div class="widget-summary-col widget-summary-col-icon">
                                        <div class="summary-icon bg-info">
                                            <i class="fa fa-list-alt"></i>
                                        </div>
                                    </div>
                                    <div class="widget-summary-col">
                                        <div class="summary">
                                            <h3 class="title visible-lg visible-md">Permohonan</h3>
                                            <h3 class="title visible-xs">Permohonan</h3>
                                            <div class="info">
                                                <strong style="font-size: 14px"><?//=$bil_skm;?> Keputusan <br> Temu Duga</strong>
                                            </div>
                                            
                                            <div class="info">
                                                <strong style="font-size: 14px; color: green"><?=$rsKeputusan->fields['total'];?></strong>
                                            </div>
                                        </div>
                                        <div class="summary-footer">
                                            <a href="index.php?data=<?php print base64_encode('pemohon/senarai_pemohon;Pengurusan;Senarai Pemohon;;;;'); ?>&tkh_mula=<?=$start_dt;?>&tkh_akhir=<?=$end_dt;?>&skim=&turutan=&negeri=&status=4&carian=" class="text-muted"><i class="fa fa-eye"></i> Paparan Maklumat</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
            <!-- AKHIR BARIS PERTAMA -->
            

        </div>
    </div>
</div>
<script type="text/javascript">

// // Use datepicker on the date inputs
// $("input[type=date]").datepicker({
//   dateFormat: 'yy-mm-dd',
//   onSelect: function(dateText, inst) {
//     $(inst).val(dateText); // Write the value in the input
//   }
// });

// // Code below to avoid the classic date-picker
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

</script>
<script src="../plugins/inputmask/jquery.inputmask.min.js"></script>
<script src="../plugins/daterangepicker/daterangepicker.js"></script>

<script>
//   $(function () {
//     //Datemask dd/mm/yyyy
//     $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
//     //Datemask2 mm/dd/yyyy
//     $('#datemask2').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
//     //Money Euro
//     $('[data-mask]').inputmask()
// });
</script>

                        