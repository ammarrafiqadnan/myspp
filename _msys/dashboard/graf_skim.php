
<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Highcharts Example</title>

		<style type="text/css">
            #container2 {
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
        <script src="hchart/code/modules/drilldown.js"></script>

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

        <div id="container2" style="min-width: 100%; max-width: 800px; height: 500px; margin: 0 auto"></div>

        <script type="text/javascript">

            Highcharts.chart('container2', {
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
                    categories: ['Skim pilihan 1', 'Skim pilihan 2', 'Skim pilihan 3']
                },

                yAxis: {
                    min: 0,
                    title: {
                        text: 'Jumlah'
                    },
                    stackLabels: {
                        enabled: true,
                        style: {
                        fontWeight: 'bold',
                        color: 'gray'
                        }
                    }
                },

                plotOptions: {
                    series: {
                        borderWidth: 0,
                        dataLabels: {
                            enabled: true,
                            // format: '{point.y:.1f}%'
                        }
                    }
                },

                tooltip: {
                    headerFormat: '<b>{point.key}</b><br>',
                    pointFormat: '<span style="color:{series.color}">\u25CF</span> {point.key}: {point.y}'
                },

		credits : { enabled : false },


		legend : { enabled: false },

                series: [
                    <?=$datas.",".$datas2.",".$datas3;?>
                ]
            });
		</script>
	</body>

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


	print 'Skim pilihan 1 : <br> 1.'.$skim_1[0]." (".$jum_1[0].")<br>2.".$skim_2[0]." (".$jum_2[0].")<br>3.".$skim_3[0]." (".$jum_3[0].")<br><br>"; 
	print 'Skim pilihan 2 : <br> 1.'.$skim_1[1]." (".$jum_1[1].")<br>2.".$skim_2[1]." (".$jum_2[1].")<br>3.".$skim_3[1]." (".$jum_3[1].")<br><br>"; 
	print 'Skim pilihan 3 : <br> 1.'.$skim_1[2]." (".$jum_1[2].")<br>2.".$skim_2[2]." (".$jum_2[2].")<br>3.".$skim_3[2]." (".$jum_3[2].")"; ?>
</html>
