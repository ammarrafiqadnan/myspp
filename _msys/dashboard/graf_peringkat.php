
<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Highcharts Example</title>

		<style type="text/css">
#container3, #sliders {
    min-width: 310px; 
    max-width: 800px;
    margin: 0 auto;
}
#container3 {
    height: 400px; 
}
		</style>
	</head>
	<body>
<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
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
                    $sql .= " AND ((date(A.d_cipta) LIKE ".tosql($start_dt).") OR (date(A.d_kemaskini) LIKE ".tosql($start_dt).")"; 
                }
            } else {
                $sql .= " AND ((year(A.d_cipta) LIKE ".tosql($currYear).") OR (year(A.d_kemaskini) LIKE ".tosql($currYear).")";
            }

            $rsIkhtisas = $conn->query($sql);


	    $sql2 = "SELECT COUNT(*) as nilai FROM $schema2.calon_ipt A  WHERE peringkat IN('2','4','6','7')";

            if(!empty($start_dt)){
                if(!empty($end_dt)){
                    $sql2 .= " AND ((date(A.d_cipta) BETWEEN ".tosql($start_dt)." AND ".tosql($end_dt).") OR date(A.d_kemaskini) BETWEEN ".tosql($start_dt)." AND ".tosql($end_dt).")";
                } else {
                    $sql2 .= " AND ((date(A.d_cipta) LIKE ".tosql($start_dt).") OR (date(A.d_kemaskini) LIKE ".tosql($start_dt).")";
                }
            } else {
                $sql2 .= " AND ((year(A.d_cipta) LIKE ".tosql($currYear).") OR (year(A.d_kemaskini) LIKE ".tosql($currYear).")";
            }

            $rsBukanIkhtisas = $conn->query($sql2);

	    $rsIBI = $rsIkhtisas->fields['nilai'].','.$rsBukanIkhtisas->fields['nilai'];

		$datasIBI = "{
                        data: ";
                                $datasIBI.= "[".$rsIBI."],";
		$datasIBI.= "colorByPoint: true";
                $datasIBI.= " }";



		//print $datasIBI;
		

?>

<div id="container3"></div>
<!-- <div id="sliders">
    <table>
        <tr>
        	<td>Alpha Angle</td>
        	<td><input id="alpha" type="range" min="0" max="45" value="15"/> <span id="alpha-value" class="value"></span></td>
        </tr>
        <tr>
        	<td>Beta Angle</td>
        	<td><input id="beta" type="range" min="-45" max="45" value="15"/> <span id="beta-value" class="value"></span></td>
        </tr>
        <tr>
        	<td>Depth</td>
        	<td><input id="depth" type="range" min="20" max="100" value="50"/> <span id="depth-value" class="value"></span></td>
        </tr>
    </table>
</div> -->


		<script type="text/javascript">

// Set up the chart
var chart = new Highcharts.Chart({
    chart: {
        renderTo: 'container3',
        type: 'column',
        options3d: {
            enabled: true,
            alpha: 15,
            beta: 15,
            depth: 50,
            viewDistance: 25
        }
    },
    title: {
        text: 'Statistik Ikhtisas Dan Bukan Ikhtisas'
    },
    // subtitle: {
    //     text: 'Test options by dragging the sliders below'
    // },
    // plotOptions: {
    //     column: {
    //         depth: 25
    //     }
    // },
    plotOptions: {
        series: {
            borderWidth: 0,
            dataLabels: {
                enabled: true,
                // format: '{point.y:.1f}%'
            }
        }
    },
    xAxis: {
        categories: ['Ikhtisas', 'Bukan Ikhtisas']
    },
    yAxis: {
        title: {
            enabled: false
        }
    },
    series: [
        <?=$datasIBI;?> 
    ]
});

function showValues() {
    $('#alpha-value').html(chart.options.chart.options3d.alpha);
    $('#beta-value').html(chart.options.chart.options3d.beta);
    $('#depth-value').html(chart.options.chart.options3d.depth);
}

// Activate the sliders
$('#sliders input').on('input change', function () {
    chart.options.chart.options3d[this.id] = parseFloat(this.value);
    showValues();
    chart.redraw(false);
});

showValues();
		</script>
	</body>
</html>
