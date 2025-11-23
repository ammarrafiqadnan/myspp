<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<?php 
$bulan_list=isset($_REQUEST["bulan_list"])?$_REQUEST["bulan_list"]:"";
$tahun_list=isset($_REQUEST["tahun_list"])?$_REQUEST["tahun_list"]:"";
if(empty($bulan_list)){ $bulan_list=date("m"); }
if(empty($tahun_list)){ $tahun_list=date("Y"); }

// $conn->debug=true;
$cat = array(); $jum = array();
$gkat=''; $gjum='';
$bil=0;

for($w=0;$w<=5;$w++){ 

    $kategori = "Minggu ".$w;
    $jumlah = dlookup("tbl_isu_agama","count(*)","is_deleted=0 AND `minggu_bulan`='{$w}' AND year(tarikh)='{$tahun_list}' AND month(tarikh)='{$bulan_list}'");

    if($bil==1){ $gjum = $jumlah; } else { $gjum .= ",".$jumlah; } 

    $cat[] = $kategori;
    $jum[] = $jumlah; 
    $bil++;
    // $rsD->movenext();   
}
$bil=count($cat);
// print_r($cat);
// print_r($jum);
// print $gkat;
?>
<div class="box-body">
    <b>LAPORAN BERDASARKAN BULAN DAN KATEGORI</b> 
    <div class="row">
        <div class="col-md-3">
            <table width="100%" cellpadding="5" cellspacing="0" border="1" class="table">
                <tr bgcolor="#8844ff;">
                    <td width="70%" align="center"><b>Minggu</b></td>
                    <td width="30%" align="center"><b>Jumlah</b></td>
                </tr>
                <?php $total=0;
                 for($i=1;$i<=$bil;$i++){ ?>
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
                <div id="akhbar_minggu"></div>
            </figure>

        </div>

    </div>
</div>

<style type="text/css">
.highcharts-figure,
.highcharts-data-table table {
    min-width: 360px;
    max-width: 800px;
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

<script type="text/javascript">
// Data retrieved https://en.wikipedia.org/wiki/List_of_cities_by_average_temperature
Highcharts.chart('akhbar_minggu', {
    chart: {
        type: 'line'
    },
    title: {
        text: 'STATISTIK LAPORAN MINGGUAN'
    },
    // subtitle: {
    //     text: 'Source: ' +
    //         '<a href="https://en.wikipedia.org/wiki/List_of_cities_by_average_temperature" ' +
    //         'target="_blank">Wikipedia.com</a>'
    // },
    xAxis: {
        categories: ['Minggu 1', 'Minggu 2', 'Minggu 3', 'Minggu 4', 'Minggu 5']
    },
    yAxis: {
        title: {
            text: 'Jumlah'
        }
    },
    plotOptions: {
        line: {
            dataLabels: {
                enabled: true
            },
            enableMouseTracking: false
        }
    },
    series: [{
        name: 'Jumlah',
        data: [<?=$gjum;?>]
    }]
});
    
</script>