<?php 
$bulan_list=isset($_REQUEST["bulan_list"])?$_REQUEST["bulan_list"]:"";
$tahun_list=isset($_REQUEST["tahun_list"])?$_REQUEST["tahun_list"]:"";
if(empty($bulan_list)){ $bulan_list=date("m"); }
if(empty($tahun_list)){ $tahun_list=date("Y"); }

$cat = array(); $jum = array();
$gkat=''; $gjum='';
$bil=0;
$sql = "SELECT * FROM `_ref_isuagama` WHERE `is_deleted`=0";
$rsD = $conn->query($sql);
while(!$rsD->EOF){
	$kategori = $rsD->fields['isuagama_nama'];
	$jumlah = dlookup("tbl_isu_agama","count(*)","is_deleted=0 AND `kategori_id`=".tosql($rsD->fields['isuagama_id'])." AND year(tarikh)='{$tahun_list}' AND month(tarikh)='{$bulan_list}'");

	if($bil==0){ $gkat = "'".$kategori."'"; } else { $gkat .= ",'".$kategori."'"; } 
	if($bil==0){ $gjum = $jumlah; } else { $gjum .= ",".$jumlah; } 

	$cat[] = $kategori;
	$jum[] = $jumlah; 
	$bil++;
	$rsD->movenext();	
}
$bil=count($cat);
// print_r($cat);
// print_r($jum);
// print $gkat;
?>

<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/highcharts-3d.js"></script>
<script src="https://code.highcharts.com/modules/cylinder.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<script src="https://code.highcharts.com/themes/dark-unica.js"></script>


<style type="text/css">
	#container {
    height: 400px;
}

.highcharts-figure,
.highcharts-data-table table {
    min-width: 310px;
    max-width: 1000px;
    margin: 1em auto;
}

.highcharts-data-table table {
    font-family: Verdana, sans-serif;
    border-collapse: collapse;
    border: 1px solid #ebebeb;
    margin: 10px auto;
    text-align: center;
    width: 100%;
    max-width: 500px;
}

.highcharts-data-table caption {
    padding: 1em 0;
    font-size: 1.2em;
    color: #555;
}

.highcharts-data-table th {
    font-weight: 600;
    padding: 0.5em;
}

.highcharts-data-table td,
.highcharts-data-table th,
.highcharts-data-table caption {
    padding: 0.5em;
}

.highcharts-data-table thead tr,
.highcharts-data-table tr:nth-child(even) {
    background: #f8f8f8;
}

.highcharts-data-table tr:hover {
    background: #f1f7ff;
}

</style>
<div class="box-body">
	<b>LAPORAN BERDASARKAN BULAN DAN KATEGORI</b> 
	<div class="row">
    	<div class="col-md-3">
			<table width="100%" cellpadding="5" cellspacing="0" border="1" class="table">
				<tr bgcolor="#8844ff;">
					<td width="70%" align="center"><b>Kategori</b></td>
					<td width="30%" align="center"><b>Jumlah</b></td>
				</tr>
			<?php $total=0;
                 for($i=0;$i<=$bil;$i++){ ?>
				<tr>
					<td align="center"><?php print $cat[$i];?></td>
					<td align="center"><?php print $jum[$i]; $total+=$jum[$i]; ?></td>
				</tr>
			<?php } ?>
                <tr>
                    <td align="center"><b>JUMLAH</b></td>
                    <td align="center"><b><?php print $total;?></b></td>
                </tr>
			</table>
		</div>
    	<div class="col-md-9">

			<figure class="highcharts-figure">
			    <div id="container"></div>
			</figure>

		</div>

    </div>
</div>

<script type="text/javascript">
	Highcharts.chart('container', {
    chart: {
        type: 'cylinder',
        options3d: {
            enabled: true,
            alpha: 15,
            beta: 15,
            depth: 50,
            viewDistance: 25
        }
    },
    title: {
        text: 'LAPORAN BERDASARKAN BULAN DAN KATEGORI BAGI BULAN <?=$bulan_list;?> / <?=$tahun_list;?>'
    },
    // subtitle: {
    //     text: 'Source: ' +
    //         '<a href="https://www.fhi.no/en/id/infectious-diseases/coronavirus/daily-reports/daily-reports-COVID19/"' +
    //         'target="_blank">FHI</a>'
    // },
    xAxis: {
        categories: [<?=$gkat;?>],
        title: {
            text: 'Kategori'
        }
    },
    yAxis: {
        title: {
            margin: 20,
            text: 'Jumlah Laporan'
        }
    },
    tooltip: {
        headerFormat: '<b>Kategori: {point.x}</b><br>'
    },
    plotOptions: {
        series: {
            depth: 25,
            colorByPoint: true
        }
    },
    series: [{
        data: [<?=$gjum;?>],
        name: 'Jumlah Laporan',
        showInLegend: false
    }]
});
</script>