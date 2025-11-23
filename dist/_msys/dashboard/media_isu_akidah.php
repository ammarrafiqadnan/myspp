<?php
$bulan_list=isset($_REQUEST["bulan_list"])?$_REQUEST["bulan_list"]:"";
$tahun_list=isset($_REQUEST["tahun_list"])?$_REQUEST["tahun_list"]:"";
if(empty($bulan_list)){ $bulan_list=date("m"); }
if(empty($tahun_list)){ $tahun_list=date("Y"); }
?>
<div class="box" style="background-color:#F2F2F2">
    <div class="box-body">
		<!-- <div class="row">
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
        	<div class="col-md-1">
				Bulan :
			</div>
        	<div class="col-md-2">
				<select class="form-control" name="bulan_list" onchange="do_page('<?=$url;?>')">
				<?php for($m=1;$m<=12;$m++){ ?>
					<option value="<?=$m;?>" <?php if($m==$bulan_list){ print 'selected'; }?>><?=$m;?></option>
				<?php } ?>
				</select>
			</div>
        </div> -->

		<br>
    	<div class="row">
        	<div class="col-md-12">
				<?php include 'dashboard/akidah_tahun.php'; ?>
			</div>
        </div>
		<br><br>
    	<div class="row">
        	<div class="col-md-12">
				<?php include 'dashboard/akidah_summary.php'; ?>
			</div>
        </div>

    </div>
    <br /><br />
</div>