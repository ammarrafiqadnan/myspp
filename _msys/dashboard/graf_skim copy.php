
<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Highcharts Example</title>

		<style type="text/css">
            #container {
                height: 400px; 
                min-width: 310px; 
                max-width: 800px;
                margin: 0 auto;
            }
        </style>
    </head>
    <body>

        <script src="hchart/code/highcharts.js"></script>
        <script src="hchart/code/highcharts-3d.js"></script>
        <script src="hchart/code/modules/exporting.js"></script>

        <?php
            // $conn->debug=true;
            $start_dt=strtoupper(isset($_REQUEST["start_dt"])?$_REQUEST["start_dt"]:"");
            $end_dt=strtoupper(isset($_REQUEST["end_dt"])?$_REQUEST["end_dt"]:"");
            // print $start_dt;
            $sql = "SELECT COUNT(*) as nilai, A.kod_jawatan, C.DISKRIPSI FROM $schema2.calon_jawatan_dipohon A, $schema1.ref_skim C  WHERE A.kod_jawatan=C.KOD AND seq_no=1";

            if(!empty($start_dt)){
                if(!empty($end_dt)){
                    $sql .= " AND (date(A.d_mohon) BETWEEN ".tosql($start_dt)." AND ".tosql($end_dt).") GROUP BY A.kod_jawatan";
                } else {
                    $sql .= " AND (date(A.d_mohon) LIKE ".tosql($start_dt).") GROUP BY A.kod_jawatan";
                }
            } 

            $sql .= " ORDER BY 1 DESC LIMIT 3";

            $rsDataP1 = $conn->query($sql); //permohonan 1

            $sql2 = "SELECT COUNT(*) as nilai, A.kod_jawatan, C.DISKRIPSI FROM $schema2.calon_jawatan_dipohon A, $schema1.ref_skim C  WHERE A.kod_jawatan=C.KOD AND seq_no=2";

            if(!empty($start_dt)){
                if(!empty($end_dt)){
                    $sql2 .= " AND (date(A.d_mohon) BETWEEN ".tosql($start_dt)." AND ".tosql($end_dt).") GROUP BY A.kod_jawatan";
                } else {
                    $sql2 .= " AND (date(A.d_mohon) LIKE ".tosql($start_dt).") GROUP BY A.kod_jawatan";
                }
            } 

            $sql2 .= " ORDER BY 1 DESC LIMIT 3";

            $rsDataP2 = $conn->query($sql2); //permohonan2

            $sql3 = "SELECT COUNT(*) as nilai, A.kod_jawatan, C.DISKRIPSI FROM $schema2.calon_jawatan_dipohon A, $schema1.ref_skim C  WHERE A.kod_jawatan=C.KOD AND seq_no=3";

            if(!empty($start_dt)){
                if(!empty($end_dt)){
                    $sql3 .= " AND (date(A.d_mohon) BETWEEN ".tosql($start_dt)." AND ".tosql($end_dt).") GROUP BY A.kod_jawatan";
                } else {
                    $sql3 .= " AND (date(A.d_mohon) LIKE ".tosql($start_dt).") GROUP BY A.kod_jawatan";
                }
            } 

            $sql3 .= " ORDER BY 1 DESC LIMIT 3";

            $rsDataP3 = $conn->query($sql3); //permohonan3

            $datas = '';
            $datas2 = '';
            $datas3 = '';


            if(!$rsDataP1->EOF){ 
                $nilaiPermohonanSkim=''; $bilb=0;
                while(!$rsDataP1->EOF){
                    if($bilb==0){ $nilaiPermohonanSkim= $rsDataP1->fields['nilai']; }
                    else { $nilaiPermohonanSkim.= ",".$rsDataP1->fields['nilai']; }
                    $bilb++;

                    $skim = $rsDataP1->fields['DISKRIPSI'];
                    $rsDataP1->movenext();
                }

                // print $nilaiPermohonanSkim;



                $datas .= "{
                        name: '".$skim."',
                        stack: '".$skim."',
                        data: ";
                                $datas .= "[".$nilaiPermohonanSkim."]";
                $datas .= " }";
            }

            if(!$rsDataP2->EOF){ 
                $nilaiPermohonanSkim2=''; $bilb=0;
                while(!$rsDataP2->EOF){
                    if($bilb==0){ $nilaiPermohonanSkim2= $rsDataP2->fields['nilai']; }
                    else { $nilaiPermohonanSkim2.= ",".$rsDataP2->fields['nilai']; }
                    $bilb++;

                    $skim2 = $rsDataP2->fields['DISKRIPSI'];
                    $rsDataP2->movenext();
                }

                // print $nilaiPermohonanSkim2;



                $datas2 .= "{
                        name: '".$skim2."',
                        stack: '".$skim2."',
                        data: ";
                                $datas2 .= "[".$nilaiPermohonanSkim2."]";
                $datas2 .= " }";
            }

            if(!$rsDataP3->EOF){ 
                $nilaiPermohonanSkim3=''; $bilb=0;
                while(!$rsDataP3->EOF){
                    if($bilb==0){ $nilaiPermohonanSkim3= $rsDataP3->fields['nilai']; }
                    else { $nilaiPermohonanSkim3.= ",".$rsDataP3->fields['nilai']; }
                    $bilb++;

                    $skim3 = $rsDataP3->fields['DISKRIPSI'];
                    $rsDataP3->movenext();
                }

                print $nilaiPermohonanSkim3;



                $datas3 .= "{
                        name: '".$skim3."',
                        stack: '".$skim3."',
                        data: ";
                                $datas3 .= "[".$nilaiPermohonanSkim3."]";
                $datas3 .= " }";
            }
        
        ?>

        <div id="container" style="min-width: 100%; max-width: 800px; height: 500px; margin: 0 auto"></div>

        <script type="text/javascript">

            Highcharts.chart('container', {
                chart: {
                    type: 'column',
                    options3d: {
                        enabled: true,
                        alpha: 15,
                        beta: 15,
                        viewDistance: 25,
                        depth: 40
                    }
                },

                title: {
                    text: 'Statistik Bagi Skim Jawatan'
                },

                xAxis: {
                    categories: ['Panggilan 1', 'Panggilan 2', 'Panggilan 3']
                },

                yAxis: {
                    allowDecimals: false,
                    min: 0,
                    title: {
                        text: 'Jumlah Permohonan'
                    }
                },

                // legend: {
                //     enabled: false
                // },

                // plotOptions: {
                //     series: {
                //         borderWidth: 0,
                //         dataLabels: {
                //             enabled: true,
                //             format: '{point.y:.1f}%'
                //         }
                //     }
                // },

                tooltip: {
                    headerFormat: '<b>{point.key}</b><br>',
                    // pointFormat: '<span style="color:{series.color}">\u25CF</span> {series.name}: {point.y} / {point.stackTotal}'
                    pointFormat: '<span style="color:{series.color}">\u25CF</span> {series.name}: {point.stackTotal}'
                },

                plotOptions: {
                    column: {
                        stacking: 'normal',
                        depth: 40
                    }
                },

                series: [
                    <?=$datas.",".$datas2.",".$datas3;?>
                ]

                // series: [{
                //     name: 'John',
                //     data: [5, 3, 4],
                //     stack: 'male'
                // // }, {
                // //     name: 'Joe',
                // //     data: [3, 4, 4],
                // //     stack: 'male'
                // }, {
                //     name: 'Jane',
                //     data: [2, 5, 6],
                //     stack: 'aa'
                // }, {
                //     name: 'Janet',
                //     data: [3, 0, 4],
                //     stack: 'female'
                // }]
            });
		</script>
	</body>
</html>
