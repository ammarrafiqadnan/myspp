<?php 
$bulan_list=isset($_REQUEST["bulan_list"])?$_REQUEST["bulan_list"]:"";
$tahun_list=isset($_REQUEST["tahun_list"])?$_REQUEST["tahun_list"]:"";
if(empty($bulan_list)){ $bulan_list=date("m"); }
if(empty($tahun_list)){ $tahun_list=date("Y"); }

$cat = array(); $jum = array();
$gkat=''; $gjum='';
$bil=0;
$datas = '';
// $conn->debug=true;
$sqla = "SELECT * FROM `_ref_kluster` WHERE is_deleted=0 AND kluster_status=0";
$rsAkhbar = $conn->query($sqla);     

while(!$rsAkhbar->EOF){ 
    $kluster_id = $rsAkhbar->fields['kluster_id'];
    $kategori = $rsAkhbar->fields['kluster_nama'];

    $jumlah = dlookup("tbl_hinaagama","count(*)","is_deleted=0 AND kluster_id='{$kluster_id}' AND `minggu`='{$minggu_list}'");

    if($bil==0){
        $data = '{ name:"'.$kategori.'", y: '.$jumlah.', drilldown: "'.$kategori.'" }';
    } else {
        $data .= ', { name:"'.$kategori.'", y: '.$jumlah.', drilldown: "'.$kategori.'" }';
    }

    $sql = "SELECT B.`medium_code`, B.`medium_name`, sum(A.`kekerapan`) as nilai 
    FROM `tbl_hinaagama_media` A, `_ref_medium_media` B, `tbl_hinaagama` Z 
    WHERE A.id_media=B.medium_id AND A.`id_hinaagama`=Z.`id` AND Z.`kluster_id`='{$kluster_id}'";
    $sql = "SELECT B.`medium_code`, B.`medium_name`, sum(A.`kekerapan`) as nilai 
    FROM `tbl_hinaagama_media` A, `_ref_medium_media` B 
    WHERE A.id_media=B.medium_id GROUP BY A.id_media";
    // print $sql."<br>";
    $rsData = $conn->query($sql);
    if(!$rsData->EOF){ 
        $datas .= '{
                name: "'.$kategori.'",
                id: "'.$kategori.'",
                data: [';
        while(!$rsData->EOF){
            $datas .= '["'.$rsData->fields['medium_name'].'", '.$rsData->fields['nilai'].'],';
            $rsData->movenext();
        }
        $datas .= '] },';
    }

    // $datas = 



    $cat[] = $kategori;
    $jum[] = $jumlah; 
    $bil++;
    $rsAkhbar->movenext();
}
$bil=count($cat);
$conn->debug=false;

// print_r($cat);
// print_r($jum);
// print $datas;
?>

<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/data.js"></script>
<script src="https://code.highcharts.com/modules/drilldown.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<script src="https://code.highcharts.com/themes/dark-unica.js"></script>


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
    <b>LAPORAN ISU-ISU AGAMA DI MEDIA MASSA BAGI MINGGU KE <?=$minggu_list;?></b> 
    <div class="row">
        <div class="col-md-3">
            <table width="100%" cellpadding="5" cellspacing="0" border="1" class="table">
                <tr bgcolor="#8844ff;">
                    <td width="70%" align="center"><b>Kluster/Bidang</b></td>
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
                <div id="media_massa"></div>
            </figure>

        </div>

    </div>
</div>


<script type="text/javascript">
// Create the chart
Highcharts.chart('media_massa', {
    chart: {
        type: 'column'
    },
    title: {
        align: 'left',
        text: 'LAPORAN PEMANTAUAN ISU-ISU AGAMA DI MEDIA MASSA MINGGU KE <?=$minggu_list;?> BAGI TAHUN <?=$tahun_list;?>'
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
        pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}</b> kekerapan<br/>'
    },

    series: [
        {
            name: "Jumlah Laporan",
            colorByPoint: true,
            data: [ <?=$data;?> ]
        }
    ],
    drilldown: {
        yAxis: {
            title: {
                text: 'Jumlah Kekerapan'
            }

        },
        breadcrumbs: {
            position : { align: 'right' }
        },
        series: [
            <?=$datas;?>
        ]
    }
});
    
</script>
