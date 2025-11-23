
<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Highcharts Example</title>

		<style type="text/css">

		</style>
	</head>
	<body>

<script src="hchart/code/highcharts.js"></script>
<script src="hchart/code/highcharts-3d.js"></script>
<script src="hchart/code/modules/exporting.js"></script>

<?php
            //$conn->debug=true;
            $start_dt=strtoupper(isset($_REQUEST["start_dt"])?$_REQUEST["start_dt"]:"");
            $end_dt=strtoupper(isset($_REQUEST["end_dt"])?$_REQUEST["end_dt"]:"");
            $currYear = date("Y", strtotime(now()));
            // print $start_dt;
            $sql = "SELECT COUNT(*) as nilai FROM $schema2.calon_ipt A  WHERE peringkat IN('1','3','5')";

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


	    $sql2 = "SELECT COUNT(*) as nilai FROM $schema2.calon_ipt A  WHERE peringkat IN('2','4','6','7')";

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

		//$datasIBI = "{ data: ";
                                //$datasIBI.= "[".$rsIBI."],";
		//$datasIBI.= "colorByPoint: true";
                //$datasIBI.= " }";


		$datasIBI = "{
		type: 'pie',
        name: 'Jumlah',
        data: [";
		$datasIBI.= "['Ikhtisas ( ".$rsIkhtisas->fields['nilai']." )',".$rsIkhtisas->fields['nilai']."],";
		$datasIBI.= "['Bukan Ikhtisas ( ".$rsBukanIkhtisas->fields['nilai']." )',".$rsBukanIkhtisas->fields['nilai']."]";

	$datasIBI.= " ]}";


		//print $datasIBI;
		

?>


<div id="container" style="height: 400px"></div>


<script type="text/javascript">

Highcharts.chart('container', {
    chart: {
        type: 'pie',
        options3d: {
            enabled: true,
            alpha: 45,
            beta: 0
        }
    },
    title: {
        text: 'Statistik Ikhtisas Dan Bukan Ikhtisas'
    },
        plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            depth: 35,
            dataLabels: {
                enabled: true,
                format: '{point.name}'
            }
        }
    },
	credits : { enabled : false }, 
	
    series: [ <?=$datasIBI;?> ]
});
		</script>
	</body>
</html>
