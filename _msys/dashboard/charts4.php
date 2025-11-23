<!-- PIE CHART -->
<div class="card card-danger">
  <div class="card-header" align="center">
    <h4 class="card-title">Statistik Permohonan Bukan Ikhtisas</h4>
  </div>
  <div class="card-body">
    <canvas id="pieChart_BI" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 250px;"></canvas>
  </div>
  <!-- /.card-body -->
</div>

<?php
//$conn->debug=true;
$start_dt=strtoupper(isset($_REQUEST["start_dt"])?$_REQUEST["start_dt"]:"");
$end_dt=strtoupper(isset($_REQUEST["end_dt"])?$_REQUEST["end_dt"]:"");
$currYear = date("Y", strtotime(now()));
// print $start_dt;
$sqldh29 = "SELECT COUNT(*) as nilai FROM $schema2.calon_jawatan_dipohon A, $schema2.calon B  WHERE A.id_pemohon=B.id_pemohon AND B.pengakuan='Y' AND A.kod_jawatan='3042'";

if(!empty($start_dt)){
  if(!empty($end_dt)){
    $sqldh29 .= " AND ((date(A.d_cipta) BETWEEN ".tosql($start_dt)." AND ".tosql($end_dt).") OR date(A.d_kemaskini) BETWEEN ".tosql($start_dt)." AND ".tosql($end_dt).")";
  } else {
    $sqldh29 .= " AND ((date(A.d_cipta) LIKE ".tosql($start_dt).") OR (date(A.d_kemaskini) LIKE ".tosql($start_dt)."))";
  }
} else {
  $sqldh29 .= " AND ((year(A.d_cipta) LIKE ".tosql($currYear).") OR (year(A.d_kemaskini) LIKE ".tosql($currYear)."))";
}
$DH29 = $conn->query($sqldh29);

$sqldh41 = "SELECT COUNT(*) as nilai FROM $schema2.calon_jawatan_dipohon A, $schema2.calon B  WHERE A.id_pemohon=B.id_pemohon AND B.pengakuan='Y' AND A.kod_jawatan='1042'";

if(!empty($start_dt)){
  if(!empty($end_dt)){
    $sqldh41 .= " AND ((date(A.d_cipta) BETWEEN ".tosql($start_dt)." AND ".tosql($end_dt).") OR date(A.d_kemaskini) BETWEEN ".tosql($start_dt)." AND ".tosql($end_dt).")";
  } else {
    $sqldh41 .= " AND ((date(A.d_cipta) LIKE ".tosql($start_dt).") OR (date(A.d_kemaskini) LIKE ".tosql($start_dt)."))";
  }
} else {
  $sqldh41 .= " AND ((year(A.d_cipta) LIKE ".tosql($currYear).") OR (year(A.d_kemaskini) LIKE ".tosql($currYear)."))";
}
$DH41 = $conn->query($sqldh41);


$sqlakp11 = "SELECT COUNT(*) as nilai FROM $schema2.calon_jawatan_dipohon A, $schema2.calon B  WHERE A.id_pemohon=B.id_pemohon AND B.pengakuan='Y' AND A.kod_peringkat IN('1')";
if(!empty($start_dt)){
  if(!empty($end_dt)){
    $sqlakp11 .= " AND ((date(A.d_cipta) BETWEEN ".tosql($start_dt)." AND ".tosql($end_dt).") OR date(A.d_kemaskini) BETWEEN ".tosql($start_dt)." AND ".tosql($end_dt).")";
  } else {
    $sqlakp11 .= " AND ((date(A.d_cipta) LIKE ".tosql($start_dt).") OR (date(A.d_kemaskini) LIKE ".tosql($start_dt)."))";
  }
} else {
  $sqlakp11 .= " AND ((year(A.d_cipta) LIKE ".tosql($currYear).") OR (year(A.d_kemaskini) LIKE ".tosql($currYear)."))";
}
$AKP11 = $conn->query($sqlakp11);

$sqlakp19 = "SELECT COUNT(*) as nilai FROM $schema2.calon_jawatan_dipohon A, $schema2.calon B  WHERE A.id_pemohon=B.id_pemohon AND B.pengakuan='Y' AND A.kod_peringkat IN('2','3')";
if(!empty($start_dt)){
  if(!empty($end_dt)){
    $sqlakp19 .= " AND ((date(A.d_cipta) BETWEEN ".tosql($start_dt)." AND ".tosql($end_dt).") OR date(A.d_kemaskini) BETWEEN ".tosql($start_dt)." AND ".tosql($end_dt).")";
  } else {
    $sqlakp19 .= " AND ((date(A.d_cipta) LIKE ".tosql($start_dt).") OR (date(A.d_kemaskini) LIKE ".tosql($start_dt)."))";
  }
} else {
  $sqlakp19 .= " AND ((year(A.d_cipta) LIKE ".tosql($currYear).") OR (year(A.d_kemaskini) LIKE ".tosql($currYear)."))";
}
$AKP19 = $conn->query($sqlakp19);


$sqldh47 = "SELECT COUNT(*) as nilai FROM $schema2.calon_jawatan_dipohon A, $schema2.calon B  WHERE A.id_pemohon=B.id_pemohon AND B.pengakuan='Y' AND A.kod_jawatan='1048'";

if(!empty($start_dt)){
  if(!empty($end_dt)){
    $sqldh47 .= " AND ((date(A.d_cipta) BETWEEN ".tosql($start_dt)." AND ".tosql($end_dt).") OR date(A.d_kemaskini) BETWEEN ".tosql($start_dt)." AND ".tosql($end_dt).")";
  } else {
    $sqldh47 .= " AND ((date(A.d_cipta) LIKE ".tosql($start_dt).") OR (date(A.d_kemaskini) LIKE ".tosql($start_dt)."))";
  }
} else {
  $sqldh47 .= " AND ((year(A.d_cipta) LIKE ".tosql($currYear).") OR (year(A.d_kemaskini) LIKE ".tosql($currYear)."))";
}
$DH47 = $conn->query($sqldh47);


//$rsIBI = $rsIkhtisas->fields['nilai'].','.$rsBukanIkhtisas->fields['nilai'];

$datasIBI = "{
type: 'pie',
name: 'Jumlah',
data: [";
$datasIBI.= "['DH29 ( ".$DH29->fields['nilai']." )',".$DH29->fields['nilai']."],";
$datasIBI.= "['DH41 ( ".$DH41->fields['nilai']." )',".$DH41->fields['nilai']."]";
$datasIBI.= "['DH47 ( ".$DH47->fields['nilai']." )',".$DH47->fields['nilai']."]";
$datasIBI.= "['AKP11 ( ".$AKP11->fields['nilai']." )',".$AKP11->fields['nilai']."]";
$datasIBI.= "['AKP19 ( ".$AKP19->fields['nilai']." )',".$AKP19->fields['nilai']."]";

$datasIBI.= " ]}";


//print $datasIBI;
    

?>
<!-- ChartJS -->
<!-- <script src="../plugins/chart.js/Chart.min.js"></script> -->
<script type="text/javascript">
  $(function () {

      var donutData = {
      labels: [
          'DH29',
          'DH41',
	  'DH47',
          'AKP11',
          'AKP19',
      ],
      datasets: [
        {
          data: ['<?=$DH29->fields['nilai'];?>','<?=$DH41->fields['nilai'];?>','<?=$DH47->fields['nilai'];?>','<?=$AKP11->fields['nilai'];?>','<?=$AKP19->fields['nilai'];?>'],
          backgroundColor : ['#f39c12', '#00c0ef', '#e53f1b','#3c8dbc', '#009'],
        }
      ]
    }

    //-------------
    //- PIE CHART -
    //-------------
    // Get context with jQuery - using jQuery's .get() method.
    var pieChartCanvas = $('#pieChart_BI').get(0).getContext('2d')
    var pieData        = donutData;
    var pieOptions     = {
        maintainAspectRatio : true,
        responsive : true,
         tooltips: {
           enabled: true,
         },
          plugins: {
          datalabels: {
            formatter: (value, ctx) => {
         let datasets = ctx.chart.data.datasets;
         if (datasets.indexOf(ctx.dataset) === datasets.length - 1) {
           let sum = datasets[0].data.reduce((a, b) => a + b, 0);
           let percentage = Math.round((value / sum) * 100) + '%';
           return percentage;
         } else {
           return percentage;
         }
       },
            color: '#fff',
          }
        }}
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    var ctx = document.getElementById("pieChart").getContext('2d');
     
    new Chart(pieChartCanvas, {
      type: 'pie',
      data: pieData,
      options: pieOptions
    })


  })

</script>
<br>
<b>Nota: Jumlah Permohonan</b><br>
  <?php
  $jum = $DH29->fields['nilai']+$DH41->fields['nilai']+$DH47->fields['nilai']+$AKP11->fields['nilai']+$AKP19->fields['nilai'];

  if(!empty($jum)){
    $pct1 = ($DH29->fields['nilai']/$jum)*100;
    $pct2 = ($DH41->fields['nilai']/$jum)*100;
    $pct3 = ($AKP11->fields['nilai']/$jum)*100;
    $pct4 = ($AKP19->fields['nilai']/$jum)*100;
    $pct5 = ($DH47->fields['nilai']/$jum)*100;

  }

  print '<label style="color:#f39c12"><b>DH29 : '. number_format($DH29->fields['nilai'],0)." (".number_format($pct1,2)."%)</b></label><br>"; 
  print '<label style="color:#00c0ef"><b>DH41 : '.number_format($DH41->fields['nilai'],0)."  (".number_format($pct2,2)."%)</b></label><br>";
  print '<label style="color:#e53f1b"><b>DH47 : '.number_format($DH47->fields['nilai'],0)."  (".number_format($pct5,2)."%)</b></label><br>";
  print '<label style="color:#3c8dbc"><b>AKP11 : '.number_format($AKP11->fields['nilai'],0)."  (".number_format($pct3,2)."%)</b></label><br>";
  print '<label style="color:#009"><b>AKP19 : '.number_format($AKP19->fields['nilai'],0)." (".number_format($pct4,2)."%)</b></label><br>"; 
 ?>