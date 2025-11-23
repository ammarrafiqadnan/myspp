<!-- BAR CHART -->
<div class="card card-success">
  <div class="card-header" align="center">
    <h4 class="card-title">Statistik Permohonan Berdasarkan Kekerapan Pilihan</h4>
  </div>
  <div class="card-body">
    <div class="chart">
      <canvas id="barChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
    </div>
  </div>
  <!-- /.card-body -->
</div>

<?php
    // $conn->debug=true;
    $start_dt=strtoupper(isset($_REQUEST["start_dt"])?$_REQUEST["start_dt"]:"");
    $end_dt=strtoupper(isset($_REQUEST["end_dt"])?$_REQUEST["end_dt"]:"");
    $currYear = date("Y", strtotime(now()));
    // print $start_dt;
    $sql = "SELECT COUNT(*) as nilai, A.kod_jawatan, C.DISKRIPSI FROM $schema2.calon_jawatan_dipohon A, $schema1.ref_skim C  WHERE A.kod_jawatan=C.KOD AND seq_no=1";

    if(!empty($start_dt)){
        if(!empty($end_dt)){
            $sql .= " AND (date(A.d_mohon) BETWEEN ".tosql($start_dt)." AND ".tosql($end_dt).")";
        } else {
            $sql .= " AND (date(A.d_mohon) LIKE ".tosql($start_dt).")";
        }
    } else {
        $sql .= " AND (year(A.d_mohon) LIKE ".tosql($currYear).")";
    }

    $sql .= "  GROUP BY A.kod_jawatan ORDER BY 1 DESC LIMIT 3";

    $rsDataP1 = $conn->query($sql); //permohonan 1

    $sql2 = "SELECT COUNT(*) as nilai, A.kod_jawatan, C.DISKRIPSI FROM $schema2.calon_jawatan_dipohon A, $schema1.ref_skim C  WHERE A.kod_jawatan=C.KOD AND seq_no=2";

    if(!empty($start_dt)){
        if(!empty($end_dt)){
            $sql2 .= " AND (date(A.d_mohon) BETWEEN ".tosql($start_dt)." AND ".tosql($end_dt).")";
        } else {
            $sql2 .= " AND (date(A.d_mohon) LIKE ".tosql($start_dt).")";
        }
    } else {
        $sql2 .= " AND (year(A.d_mohon) LIKE ".tosql($currYear).")";
    }

    $sql2 .= "  GROUP BY  A.kod_jawatan ORDER BY 1 DESC LIMIT 3";

    $rsDataP2 = $conn->query($sql2); //permohonan2

    $sql3 = "SELECT COUNT(*) as nilai, A.kod_jawatan, C.DISKRIPSI FROM $schema2.calon_jawatan_dipohon A, $schema1.ref_skim C  WHERE A.kod_jawatan=C.KOD AND seq_no=3";

    if(!empty($start_dt)){
        if(!empty($end_dt)){
            $sql3 .= " AND (date(A.d_mohon) BETWEEN ".tosql($start_dt)." AND ".tosql($end_dt).")";
        } else {
            $sql3 .= " AND (date(A.d_mohon) LIKE ".tosql($start_dt).")";
        }
    } else {
        $sql3 .= " AND (year(A.d_mohon) LIKE ".tosql($currYear).")";
    }

    $sql3 .= "  GROUP BY A.kod_jawatan ORDER BY 1 DESC LIMIT 3";

    $rsDataP3 = $conn->query($sql3); //permohonan3

    $datas = '';
    $datas2 = '';
    $datas3 = '';


    if(!$rsDataP1->EOF){ 
        $nilaiPermohonanSkim1=''; $nilaiPermohonanSkim2=''; $nilaiPermohonanSkim3='';
        $skim1=''; $skim2=''; $skim3=''; $bilb=0;
        while(!$rsDataP1->EOF){
            if($bilb==0){ 
            $nilaiPermohonanSkim1= $rsDataP1->fields['nilai']; 
            $skim1.= "'".$rsDataP1->fields['DISKRIPSI']."'";
            } else if($bilb==1){ 
            $nilaiPermohonanSkim2.= $rsDataP1->fields['nilai']; 
            $skim2.= "'".$rsDataP1->fields['DISKRIPSI']."'";
            } else if($bilb==2){ 
            $nilaiPermohonanSkim3.= $rsDataP1->fields['nilai']; 
            $skim3.= "'".$rsDataP1->fields['DISKRIPSI']."'";
            }
            $bilb++;

            
            $rsDataP1->movenext();
        }

        // print $nilaiPermohonanSkim;

    }


    if(!$rsDataP2->EOF){ 
        //$nilaiPermohonanSkim2=''; 
        $bilb=0;
        while(!$rsDataP2->EOF){
            if($bilb==0){ 
            $nilaiPermohonanSkim1 .= ",".$rsDataP2->fields['nilai']; 
            $skim1.= ",'".$rsDataP2->fields['DISKRIPSI']."'";
            } else if($bilb==1){ 
            $nilaiPermohonanSkim2 .= ",".$rsDataP2->fields['nilai']; 
            $skim2.= ",'".$rsDataP2->fields['DISKRIPSI']."'";
            } else if($bilb==2){ 
            $nilaiPermohonanSkim3 .= ",".$rsDataP2->fields['nilai']; 
            $skim3.= ",'".$rsDataP2->fields['DISKRIPSI']."'";
            }
            $bilb++;

            //$skim2 = $rsDataP2->fields['DISKRIPSI'];
            $rsDataP2->movenext();
        }

        // print $nilaiPermohonanSkim2; 
    }

    if(!$rsDataP3->EOF){ 
        $bilb=0;
        while(!$rsDataP3->EOF){
          if($bilb==0){ 
          $nilaiPermohonanSkim1 .= ",".$rsDataP3->fields['nilai']; 
          $skim1.= ",'".$rsDataP3->fields['DISKRIPSI']."'";
          } else if($bilb==1){ 
          $nilaiPermohonanSkim2.= ",".$rsDataP3->fields['nilai']; 
          $skim2.= ",'".$rsDataP3->fields['DISKRIPSI']."'";
          } else if($bilb==2){ 
          $nilaiPermohonanSkim3.= ",".$rsDataP3->fields['nilai']; 
          $skim3.= ",'".$rsDataP3->fields['DISKRIPSI']."'";
          }

          $bilb++;

          //$skim3 = $rsDataP3->fields['DISKRIPSI'];
          $rsDataP3->movenext();
        }

        // print $nilaiPermohonanSkim3;

    }
  $datas .= "{
          name: [".$skim1."],
          stack: [".$skim1."],
          data: [".$nilaiPermohonanSkim1."]";
  $datas .= " }";
  $datas2 .= "{
          name: [".$skim2."],
          stack: [".$skim2."],
          data: ";
  $datas2 .= "[".$nilaiPermohonanSkim2."]";
  $datas2 .= " }";
  $datas3 .= "{
          name: [".$skim3."],
          stack: [".$skim3."],
          data: ";
  $datas3 .= "[".$nilaiPermohonanSkim3."]";
  $datas3 .= " }";

?>
<!-- ChartJS -->
<script src="../plugins/chart.js/Chart.min.js"></script>
<script type="text/javascript">
  $(function () {
    // var areaChartCanvas = $('#areaChart').get(0).getContext('2d')

    var areaChartData = {
      labels  : ['Pilihan Pertama', 'Pilihan Kedua', 'Pilihan Ketiga'],
      datasets: [
        {
          label               : 'Skim 1',
          backgroundColor     : 'rgba(60,141,188,0.9)',
          borderColor         : 'rgba(60,141,188,0.8)',
          pointRadius          : false,
          pointColor          : '#3b8bba',
          pointStrokeColor    : 'rgba(60,141,188,1)',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(60,141,188,1)',
          data                : [<?=$nilaiPermohonanSkim1;?>]
        },
        {
          label               : 'Skim 2',
          backgroundColor     : 'rgba(210, 214, 222, 1)',
          borderColor         : 'rgba(210, 214, 222, 1)',
          pointRadius         : false,
          pointColor          : 'rgba(210, 214, 222, 1)',
          pointStrokeColor    : '#c1c7d1',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(220,220,220,1)',
          data                : [<?=$nilaiPermohonanSkim2;?>]
        },
        {
          label               : 'Skim 3',
          backgroundColor     : 'rgba(90, 214, 0, 1)',
          borderColor         : 'rgba(90, 214, 0, 1)',
          pointRadius         : false,
          pointColor          : 'rgba(210, 214, 222, 1)',
          pointStrokeColor    : '#c1c7d1',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(220,220,220,1)',
          data                : [<?=$nilaiPermohonanSkim3;?>]
        },
      ]
    }

    // var areaChartOptions = {
    //   maintainAspectRatio : false,
    //   responsive : true,
    //   legend: {
    //     display: false
    //   },
    //   scales: {
    //     xAxes: [{
    //       gridLines : {
    //         display : false,
    //       }
    //     }],
    //     yAxes: [{
    //       gridLines : {
    //         display : false,
    //       }
    //     }]
    //   }
    // }

    // This will get the first returned node in the jQuery collection.
    // new Chart(areaChartCanvas, {
    //   type: 'line',
    //   data: areaChartData,
    //   options: areaChartOptions
    // })


    //-------------
    //- BAR CHART -
    //-------------
    var barChartCanvas = $('#barChart').get(0).getContext('2d')
    var barChartData = $.extend(true, {}, areaChartData)
    var temp0 = areaChartData.datasets[0]
    var temp1 = areaChartData.datasets[1]
    var temp2 = areaChartData.datasets[2]
    barChartData.datasets[0] = temp0
    barChartData.datasets[1] = temp1
    barChartData.datasets[2] = temp2

    var barChartOptions = {
      responsive              : true,
      maintainAspectRatio     : false,
      datasetFill             : false
    }

    new Chart(barChartCanvas, {
      type: 'bar',
      data: barChartData,
      options: barChartOptions
    })
  })

</script>

  <?php 
  $skim1 = str_replace("'", "", $skim1);
  $skim_1 = explode(',', $skim1);
  $jum_1 = explode(',', $nilaiPermohonanSkim1);

  $skim2 = str_replace("'", "", $skim2);
  $skim_2 = explode(',', $skim2);
  $jum_2 = explode(',', $nilaiPermohonanSkim2);

  $skim3 = str_replace("'", "", $skim3);
  $skim_3 = explode(',', $skim3);
  $jum_3 = explode(',', $nilaiPermohonanSkim3);


  print '<b>Pilihan Pertama :</b> <br> 1.'.$skim_1[0]." (".$jum_1[0].")<br>2.".$skim_2[0]." (".$jum_2[0].")<br>3.".$skim_3[0]." (".$jum_3[0].")<br><br>"; 
  print '<b>Pilihan Kedua :</b> <br> 1.'.$skim_1[1]." (".$jum_1[1].")<br>2.".$skim_2[1]." (".$jum_2[1].")<br>3.".$skim_3[1]." (".$jum_3[1].")<br><br>"; 
  print '<b>Pilihan Ketiga :</b> <br> 1.'.$skim_1[2]." (".$jum_1[2].")<br>2.".$skim_2[2]." (".$jum_2[2].")<br>3.".$skim_3[2]." (".$jum_3[2].")"; ?>
