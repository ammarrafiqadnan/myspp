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
<script src="hchart/code/modules/exporting.js"></script>

<div id="container" style="min-width: 100%; max-width: 800px; height: 400px; margin: 0 auto"></div>



		<script type="text/javascript">

Highcharts.chart('container', {
    chart: {
        type: 'bar'
    },
    title: {
        text: 'STATISTIK LAPORAN  '
    },
    xAxis: {
        categories: ['Johor', 'Kedah', 'Perak', 'Selangor', 'Melaka', 'Pahang', 'Pulau Pinang', 'Kelantan', 'Terengganu', 'Wilayah Persekutuan', 'Sabah', 'Sarawak', 'Perlis', 'Negeri Sembilan']
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Jumlah Pemohon'
        }
    },
    legend: {
        reversed: true
    },
    plotOptions: {
        series: {
            stacking: 'normal'
        }
    },
    series: [{
        name: 'Universiti Awam Pendidikan',
        data: [2, 2, 3, 2, 1,2, 5,3,2,9,8,1,6,4]
    },{
        name: 'Universiti Awam Bukan Pendidikan',
        data: [5, 3, 4, 7, 2,4, 1,2, 5,3,2,9,4,5]
    },{
        name: 'Universiti Swasta Pendidikan',
        data: [5, 3, 4, 7, 2,4,2,9,4,5,6,7]
    },{
        name: 'Universiti Swasta Bukan Pendidikan',
        data: [5, 3, 4, 7, 2,4,5,6,7,10,22,1,5,4]
    }]
});
		</script>
	</body>
</html>


