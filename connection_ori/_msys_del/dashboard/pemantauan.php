<?php 
// $bulan_list=isset($_REQUEST["bulan_list"])?$_REQUEST["bulan_list"]:"";
$tahun_list=isset($_REQUEST["tahun_list"])?$_REQUEST["tahun_list"]:"";
// if(empty($bulan_list)){ $bulan_list=date("m"); }
if(empty($tahun_list)){ $tahun_list=date("Y"); }

$cat = array(); $jum = array();
$gkat=''; $gjum='';
$bil=0;
$datas = '';
// $conn->debug=true;
$sqla = "SELECT * FROM `_ref_kategori_sub` WHERE kategori_id=1 AND is_deleted=0 AND subkat_status=0";
$rsAkhbar = $conn->query($sqla);     

while(!$rsAkhbar->EOF){ 
    $subkat_id = $rsAkhbar->fields['subkat_id'];
    $kategori = $rsAkhbar->fields['subkat_nama'];

    // $cat[] = $kategori;
    $rsc = $conn->query("SELECT count(*) AS jum FROM tbl_pemantauan WHERE is_deleted=0 AND pemantauan_type='{$subkat_id}' AND year(`tarikh`)='{$tahun_list}'");
    $rscS = $conn->query("SELECT count(*) AS jum FROM tbl_pemantauan WHERE status_proses=9 AND is_deleted=0 AND pemantauan_type='{$subkat_id}' AND year(`tarikh`)='{$tahun_list}'");


    if($bil==0){ 
        $cat = "'".$kategori."'"; 
        // $jum = dlookup("tbl_pemantauan","count(*)","is_deleted=0 AND pemantauan_type='{$subkat_id}' AND year(`tarikh`)='{$tahun_list}'");
        $jum = $rsc->fields['jum'];
        // $selesai = $rscS->fields['jum'];
    } else {
        $cat .= ",'".$kategori."'";
        // $jum = ",".dlookup("tbl_pemantauan","count(*)","is_deleted=0 AND pemantauan_type='{$subkat_id}' AND year(`tarikh`)='{$tahun_list}'");
        $jum .= ",".$rsc->fields['jum'];
        // $selesai .= $rscS->fields['jum'];
    }
    
    // $cat[] = $kategori;
    // $jum[] = $jumlah; 
    $bil++;
    $rsAkhbar->movenext();
}
// $bil=count($cat);
$conn->debug=false;

// print_r($cat);
// print_r($jum);
// print $cat;
print $jum;
print "<br>".$selesai;
?>
<div class="box" style="background-color:#F2F2F2">
    <div class="box-body">
        <div class="row">
            <div class="col-md-1">
                Tahun :
            </div>
            <div class="col-md-2">
                <select class="form-control" name="tahun_list" onchange="do_page('<?=$url;?>')">
                <?php for($y=date("Y");$y>=2021;$y--){ ?>
                    <option value="<?=$y;?>" <?php if($y==$tahun_list){ print 'selected'; }?>><?=$y;?></option>
                <?php } ?>
                </select>
            </div>
            <!--< div class="col-md-1">
                Bulan :
            </div>
            <div class="col-md-2">
                <select class="form-control" name="minggu_list" onchange="do_page('<?=$url;?>')">
                <?php for($m=1;$m<=52;$m++){ ?>
                    <option value="<?=$m;?>" <?php if($m==$minggu_list){ print 'selected'; }?>><?=$m;?></option>
                <?php } ?>
                </select>
            </div> -->
        </div>
    </div>
</div>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>

<figure class="highcharts-figure">
    <div id="container"></div>
    <!-- <p class="highcharts-description">
        Chart showing overlapping placement of columns, using different data
        series. The chart is also using multiple y-axes, allowing data in
        different ranges to be visualized on the same chart.
    </p> -->
</figure>

<style type="text/css">
.highcharts-figure,
.highcharts-data-table table {
    min-width: 310px;
    max-width: "100%";
    margin: 1em auto;
}

#container {
    height: 400px;
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
Highcharts.chart('container', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Maklumat Pemantauan Berdasarkan Kategori'
    },
    xAxis: {
        categories: [<?=$cat;?>]
    },
    yAxis: [{
        min: 0,
        title: {
            text: 'Jumlah Pemantauan'
        }
    }, {
        // title: {
            // text: 'Profit (millions)'
        // },
        // opposite: true
    }],
    legend: {
        shadow: false
    },
    tooltip: {
        shared: true
    },
    plotOptions: {
        column: {
            grouping: false,
            shadow: false,
            borderWidth: 0
        }
    },
    series: [{
        name: 'Jumlah Dipantau',
        color: 'rgba(165,170,217,1)',
        data: [<?=$jum;?>],
        pointPadding: 0.3,
        pointPlacement: -0.2
    }, {
        name: 'Selesai',
        color: 'rgba(126,86,134,.9)',
        data: [<?=$selesai;?>],
        pointPadding: 0.4,
        pointPlacement: -0.2
    }]
});
</script>