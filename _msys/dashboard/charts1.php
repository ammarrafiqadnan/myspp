<!-- PIE CHART -->
<div class="card card-danger">
  <div class="card-header" align="center">
    <h4 class="card-title">Statistik Ikhtisas dan Bukan Ikhtisas</h4>
  </div>
  <div class="card-body" align="center">
    <canvas id="pieChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 250px;"></canvas>
  </div>
  <!-- /.card-body -->
</div>

<?php
///$conn->debug=true;
$start_dt=strtoupper(isset($_REQUEST["start_dt"])?$_REQUEST["start_dt"]:"");
$end_dt=strtoupper(isset($_REQUEST["end_dt"])?$_REQUEST["end_dt"]:"");
$currYear = date("Y", strtotime(now()));
// print $start_dt;
$sql = "SELECT COUNT(*) as nilai FROM $schema2.calon_jawatan_dipohon A, $schema2.calon B  WHERE A.id_pemohon=B.id_pemohon AND B.pengakuan='Y' AND A.kod_peringkat IN('4','6')";

if(!empty($start_dt)){
  if(!empty($end_dt)){
    $sql .= " AND ((date(A.d_cipta) BETWEEN ".tosql($start_dt)." AND ".tosql($end_dt).") OR date(A.d_kemaskini) BETWEEN ".tosql($start_dt)." AND ".tosql($end_dt).")";
  } else {
    $sql .= " AND ((date(A.d_cipta) LIKE ".tosql($start_dt).") OR (date(A.d_kemaskini) LIKE ".tosql($start_dt)."))";
  }
} else {
  $sql .= " AND ((year(A.d_cipta) LIKE ".tosql($currYear).") OR (year(A.d_kemaskini) LIKE ".tosql($currYear)."))";
}
$rsIkhtisas = $conn->query($sql);


$sql2 = "SELECT COUNT(*) as nilai FROM $schema2.calon_jawatan_dipohon A, $schema2.calon B  WHERE A.id_pemohon=B.id_pemohon AND B.pengakuan='Y' AND A.kod_peringkat IN('1','2','3','5','7','8','9','10')";

if(!empty($start_dt)){
  if(!empty($end_dt)){
    $sql2 .= " AND ((date(A.d_cipta) BETWEEN ".tosql($start_dt)." AND ".tosql($end_dt).") OR date(A.d_kemaskini) BETWEEN ".tosql($start_dt)." AND ".tosql($end_dt).")";
  } else {
    $sql2 .= " AND ((date(A.d_cipta) LIKE ".tosql($start_dt).") OR (date(A.d_kemaskini) LIKE ".tosql($start_dt)."))";
  }
} else {
  $sql2 .= " AND ((year(A.d_cipta) LIKE ".tosql($currYear).") OR (year(A.d_kemaskini) LIKE ".tosql($currYear)."))";
}
$rsBukanIkhtisas = $conn->query($sql2);

$rsIBI = $rsIkhtisas->fields['nilai'].','.$rsBukanIkhtisas->fields['nilai'];

$datasIBI = "{
type: 'pie',
name: 'Jumlah',
data: [";
$datasIBI.= "['Ikhtisas ( ".$rsIkhtisas->fields['nilai']." )',".$rsIkhtisas->fields['nilai']."],";
$datasIBI.= "['Bukan Ikhtisas ( ".$rsBukanIkhtisas->fields['nilai']." )',".$rsBukanIkhtisas->fields['nilai']."]";

$datasIBI.= " ]}";


    //print $datasIBI;
    

?>
<!-- ChartJS -->
<script src="../plugins/chart.js/Chart.min.js"></script>
<script type="text/javascript">
  $(function () {

      var donutData = {
      labels: [
          'Ikhtisas',
          'Bukan Ikhtisas',
      ],
      datasets: [
        {
          data: ['<?=$rsIkhtisas->fields['nilai'];?>','<?=$rsBukanIkhtisas->fields['nilai'];?>'],
          backgroundColor : ['#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de'],
        }
      ]
    }

    //-------------
    //- PIE CHART -
    //-------------
    // Get context with jQuery - using jQuery's .get() method.
    var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
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
  <?php
  $jum = $rsIkhtisas->fields['nilai']+$rsBukanIkhtisas->fields['nilai'];

  if(!empty($jum)){
    $pct1 = ($rsIkhtisas->fields['nilai']/$jum)*100;
    $pct2 = ($rsBukanIkhtisas->fields['nilai']/$jum)*100;
  }

  print '<div align="center"><b>Nota:</b><br>
  <label style="color:#f39c12"><b>Ikhtisas : '. number_format($rsIkhtisas->fields['nilai'],0)." Permohonan (".number_format($pct1,2)."%)</b></label><br>"; 
  print '<label style="color:#00c0ef"><b>Bukan Ikhtisas : '.number_format($rsBukanIkhtisas->fields['nilai'],0)." Permohonan (".number_format($pct2,2)."%)</b></label><br></div>"; 
 ?>