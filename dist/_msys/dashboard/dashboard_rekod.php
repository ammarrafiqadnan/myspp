<?php 
// $conn->debug=true;// include 'dashboard/sql_data.php'; 

$dt = date("Y-m-d");
?>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><b>Dashboard</b> </h2>
                <div class="clearfix"></div>
            </div>
			<br />	
	
            <!-- MULA BARIS PERTAMA -->
            <div class="clearfix"></div>
            <div class="col-md-12 col-lg-12 col-xl-12" style="padding-bottom: 20px;">
                <div class="row">
                    <dov class="col-md-12">
                        <div class="box-body d-print-none" style="height: 40px;background-color:#F2F2F2;">
                            <div class="row">
                                <div class="col-md-2">
                                    <label for="">Tarikh Mula: </label>
                                </div>
                                <div class="col-md-4">
                                    <input type="date" class="form-control">
                                </div>  
                                <div class="col-md-2">
                                    <label for="">Tarikh Akhir: </label>
                                </div>
                                <div class="col-md-4">
                                    <input type="date" class="form-control">
                                </div> 
                            </div>   
                        </div>
                    </dov>
                </div>
            </div>
            <div class="col-md-12 col-lg-12 col-xl-12">
                <div class="row"> 
                    <div class="col-md-12 col-lg-6 col-xl-6">
                        <section class="panel panel-featured-left panel-featured-secondary">
                            <div class="panel-body">
                                <div class="widget-summary">
                                    <div class="widget-summary-col widget-summary-col-icon">
                                        <div class="summary-icon bg-secondary">
                                            <i class="fa fa-users"></i>
                                        </div>
                                    </div>
                                    <div class="widget-summary-col">
                                        <div class="summary">
                                            <h4 class="title visible-lg visible-md">Permohonan </h4>
                                            <h4 class="title visible-xs">Permohonan</h4>
                                            <div class="info">
                                                <strong style="font-size: 18px"><?//=$jum;?> Draf</strong>
                                            </div>
                                            
                                            <div class="danger">
                                                <strong style="font-size: 18px; color: red">1,000</strong>
                                            </div>
                                        </div>
                                        <div class="summary-footer">
                                            <a href="index.php?data=<?php print base64_encode('pemohon/senarai_pemohon_draf;Senarai Pemohon;Senarai Pemohon Draf;ALL;;;'); ?>&kategori=draf" class="text-muted"><i class="fa fa-eye"></i> Paparan Maklumat</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                    
                    <div class="col-md-12 col-lg-6 col-xl-6">
                        <section class="panel panel-featured-left panel-featured-tertiary">
                            <div class="panel-body">
                                <div class="widget-summary">
                                    <div class="widget-summary-col widget-summary-col-icon">
                                        <div class="summary-icon bg-tertiary">
                                            <i class="fa fa-users"></i>
                                        </div>
                                    </div>
                                    <div class="widget-summary-col">
                                        <div class="summary">
                                            <h4 class="title visible-lg visible-md">Permohonan</h4>
                                            <h4 class="title visible-xs">Permohonan</h4>
                                            <div class="info">
                                                <strong style="font-size: 18px"><?//=$bil_skm;?> Hantar</strong>
                                            </div>
                                            
                                            <div class="info">
                                                <strong style="font-size: 18px; color: green">2,538</strong>
                                            </div>
                                        </div>
                                        <div class="summary-footer">
                                            <a href="index.php?data=<?php print base64_encode('pemohon/senarai_pemohon_hantar;Senarai Pemohon;Senarai Pemohon Hantar;ALL;;;'); ?>&kategori=hantar" class="text-muted"><i class="fa fa-eye"></i> Paparan Maklumat</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
            <!-- AKHIR BARIS PERTAMA -->
            

        </div>
    </div>
</div>

                        