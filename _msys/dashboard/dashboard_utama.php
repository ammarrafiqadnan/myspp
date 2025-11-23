<style>
ul.a {list-style-type: number; font:Arial;}
</style>

<div class="col-lg-12">
	<section class="panel">
		<div class="panel-body">
			<div class="box-body">
                <!-- <div class="box" style="background-color:#F2F2F2"> -->
                <div class="col-md-12">
                    <div class="form-group">
                        <div class="row">
                            <?php include 'dashboard/dashboard_rekod.php'; ?>
                        </div>
                    </div>
		        </div>
		        <div class="col-md-12">
		           <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <?php //include 'dashboard/graf_peringkat2.php'; ?>
	       		            </div>
			                <div class="col-md-6">
                    	       <?php //include 'dashboard/graf_skim.php'; ?>
			                </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                   <div class="form-group">
                        <div class="row">
                            <div class="col-md-7">
                                <?php include 'dashboard/charts1.php'; ?>
                                <?php //include 'dashboard/charts2.php'; ?>
                                <br><br>
                                <div class="col-md-6">
                                    <?php include 'dashboard/charts3.php'; // IKHTISAS?>
                                </div>
                                <div class="col-md-6">
                                    <?php include 'dashboard/charts4.php'; // Bukan Ikhtisas?>
                                </div>
                            </div>
                            <div class="col-md-5">
                               <?php include 'dashboard/bar_charts.php'; ?>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
</div>

