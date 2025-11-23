<?php 
$bulan_list=isset($_REQUEST["bulan_list"])?$_REQUEST["bulan_list"]:"";
$tahun_list=isset($_REQUEST["tahun_list"])?$_REQUEST["tahun_list"]:"";
if(empty($bulan_list)){ $bulan_list=date("m"); }
if(empty($tahun_list)){ $tahun_list=date("Y"); }

$cat = array(); $jum = array();
$gkat=''; $gjum='';
$bil=0;
// $conn->debug=true;
for($i=0;$i<=12;$i++){ 
    
    if($i<=9){ $bulan = month('0'.$i); } else { $bulan = month($i); }

    $kategori = $bulan;
    $jumlah = dlookup("tbl_isu_agama","count(*)","is_deleted=0 AND year(tarikh)='{$tahun_list}' AND month(tarikh)='{$i}'");

    if($bil==1){
        $data = '{ name:"'.$bulan.'", y: '.$jumlah.', drilldown: "'.$bulan.'" }';
    } else {
        $data .= ', { name:"'.$bulan.'", y: '.$jumlah.', drilldown: "'.$bulan.'" }';
    }

    $cat[] = $kategori;
    $jum[] = $jumlah; 
    $bil++;
}
$bil=count($cat);

// print_r($cat);
// print_r($jum);
// print $data;
?>

<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/data.js"></script>
<script src="https://code.highcharts.com/modules/drilldown.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>

<style type="text/css">
.highcharts-figure,
.highcharts-data-table table {
    min-width: 310px;
    max-width: 1000px;
    margin: 1em auto;
}

#akhbar_tahun {
    height: 500px;
}

.highcharts-data-table table {
    font-family: Verdana, sans-serif;
    border-collapse: collapse;
    border: 1px solid #ebebeb;
    margin: 10px auto;
    text-align: center;
    width: 100%;
    max-width: 1000px;
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
                    <td width="70%" align="center"><b>Bulan</b></td>
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
                <div id="akhbar_tahun"></div>
            </figure>

        </div>

    </div>
</div>


<script type="text/javascript">
// Create the chart
Highcharts.chart('akhbar_tahun', {
    chart: {
        type: 'column'
    },
    title: {
        align: 'left',
        text: 'LAPORAN ISU AGAMA DI AKHBAR BAGI TAHUN <?=$tahun_list;?>'
    },
    // subtitle: {
    //     align: 'left',
    //     text: 'Click the columns to view versions. Source: <a href="http://statcounter.com" target="_blank">statcounter.com</a>'
    // },
    accessibility: {
        announceNewData: {
            enabled: true
        }
    },
    xAxis: {
        type: 'category'
    },
    yAxis: {
        title: {
            text: 'Jumlah Laporan'
        }

    },
    legend: {
        enabled: false
    },
    plotOptions: {
        series: {
            borderWidth: 0,
            dataLabels: {
                enabled: true,
                format: '{point.y}'
            }
        }
    },

    tooltip: {
        headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
        pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}</b> of total<br/>'
    },

    series: [
        {
            name: "Jumlah Laporan",
            colorByPoint: true,
            data: [ <?=$data;?> ]
        }
    ],
    // drilldown: {
    //     breadcrumbs: {
    //         position: {
    //             align: 'right'
    //         }
    //     },
    //     series: [
    //         {
    //             name: "Chrome",
    //             id: "Chrome",
    //             data: [
    //                 [
    //                     "v65.0",
    //                     0.1
    //                 ],
    //                 [
    //                     "v64.0",
    //                     1.3
    //                 ],
    //                 [
    //                     "v63.0",
    //                     53.02
    //                 ],
    //                 [
    //                     "v62.0",
    //                     1.4
    //                 ],
    //                 [
    //                     "v61.0",
    //                     0.88
    //                 ],
    //                 [
    //                     "v60.0",
    //                     0.56
    //                 ],
    //                 [
    //                     "v59.0",
    //                     0.45
    //                 ],
    //                 [
    //                     "v58.0",
    //                     0.49
    //                 ],
    //                 [
    //                     "v57.0",
    //                     0.32
    //                 ],
    //                 [
    //                     "v56.0",
    //                     0.29
    //                 ],
    //                 [
    //                     "v55.0",
    //                     0.79
    //                 ],
    //                 [
    //                     "v54.0",
    //                     0.18
    //                 ],
    //                 [
    //                     "v51.0",
    //                     0.13
    //                 ],
    //                 [
    //                     "v49.0",
    //                     2.16
    //                 ],
    //                 [
    //                     "v48.0",
    //                     0.13
    //                 ],
    //                 [
    //                     "v47.0",
    //                     0.11
    //                 ],
    //                 [
    //                     "v43.0",
    //                     0.17
    //                 ],
    //                 [
    //                     "v29.0",
    //                     0.26
    //                 ]
    //             ]
    //         },
    //         {
    //             name: "Firefox",
    //             id: "Firefox",
    //             data: [
    //                 [
    //                     "v58.0",
    //                     1.02
    //                 ],
    //                 [
    //                     "v57.0",
    //                     7.36
    //                 ],
    //                 [
    //                     "v56.0",
    //                     0.35
    //                 ],
    //                 [
    //                     "v55.0",
    //                     0.11
    //                 ],
    //                 [
    //                     "v54.0",
    //                     0.1
    //                 ],
    //                 [
    //                     "v52.0",
    //                     0.95
    //                 ],
    //                 [
    //                     "v51.0",
    //                     0.15
    //                 ],
    //                 [
    //                     "v50.0",
    //                     0.1
    //                 ],
    //                 [
    //                     "v48.0",
    //                     0.31
    //                 ],
    //                 [
    //                     "v47.0",
    //                     0.12
    //                 ]
    //             ]
    //         },
    //         {
    //             name: "Internet Explorer",
    //             id: "Internet Explorer",
    //             data: [
    //                 [
    //                     "v11.0",
    //                     6.2
    //                 ],
    //                 [
    //                     "v10.0",
    //                     0.29
    //                 ],
    //                 [
    //                     "v9.0",
    //                     0.27
    //                 ],
    //                 [
    //                     "v8.0",
    //                     0.47
    //                 ]
    //             ]
    //         },
    //         {
    //             name: "Safari",
    //             id: "Safari",
    //             data: [
    //                 [
    //                     "v11.0",
    //                     3.39
    //                 ],
    //                 [
    //                     "v10.1",
    //                     0.96
    //                 ],
    //                 [
    //                     "v10.0",
    //                     0.36
    //                 ],
    //                 [
    //                     "v9.1",
    //                     0.54
    //                 ],
    //                 [
    //                     "v9.0",
    //                     0.13
    //                 ],
    //                 [
    //                     "v5.1",
    //                     0.2
    //                 ]
    //             ]
    //         },
    //         {
    //             name: "Edge",
    //             id: "Edge",
    //             data: [
    //                 [
    //                     "v16",
    //                     2.6
    //                 ],
    //                 [
    //                     "v15",
    //                     0.92
    //                 ],
    //                 [
    //                     "v14",
    //                     0.4
    //                 ],
    //                 [
    //                     "v13",
    //                     0.1
    //                 ]
    //             ]
    //         },
    //         {
    //             name: "Opera",
    //             id: "Opera",
    //             data: [
    //                 [
    //                     "v50.0",
    //                     0.96
    //                 ],
    //                 [
    //                     "v49.0",
    //                     0.82
    //                 ],
    //                 [
    //                     "v12.1",
    //                     0.14
    //                 ]
    //             ]
    //         }
    //     ]
    // }
});
    
</script>
