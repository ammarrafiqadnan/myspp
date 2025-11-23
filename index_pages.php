<script src="../js/select2.min.js"></script>
<link href="../css/select2.min.css" rel="stylesheet" />
<?php //include '../connection/common.php'; ?>
<style type="text/css">

.select2-hidden-accessible {
    border: 0 !important;
    clip: rect(0 0 0 0) !important;
    height: 1px !important;
    margin: -1px !important;
    overflow: hidden !important;
    padding: 0 !important;
    position: absolute !important;
    width: 1px !important;
    font-size: 14px;
}

.select2-container--default .select2-selection--single,
.select2-selection .select2-selection--single {
    border: 1px solid #d2d6de;
    border-radius: 0;
    padding: 6px 12px;
    height: 34px
}

.select2-container--default .select2-selection--single {
    background-color: #fff;
    border: 1px solid #aaa;
    border-radius: 4px
}

.select2-container .select2-selection--single {
    box-sizing: border-box;
    cursor: pointer;
    display: block;
    height: 28px;
    user-select: none;
    -webkit-user-select: none
}

.select2-container .select2-selection--single .select2-selection__rendered {
    padding-right: 10px
}

.select2-container .select2-selection--single .select2-selection__rendered {
    padding-left: 0;
    padding-right: 0;
    height: auto;
    margin-top: -3px
}

.select2-container--default .select2-selection--single .select2-selection__rendered {
    color: #444;
    line-height: 28px
}

.select2-container--default .select2-selection--single,
.select2-selection .select2-selection--single {
    border: 1px solid #d2d6de;
    border-radius: 0 !important;
    padding: 6px 12px;
    height: 40px !important
}

.select2-container--default .select2-selection--single .select2-selection__arrow {
    height: 26px;
    position: absolute;
    top: 6px !important;
    right: 1px;
    width: 20px
}   
</style>
<?php 
$disp_menu = $menu;
?>
        <section role="main" class="content-body">
            <header class="page-header" style="background-image: linear-gradient(to right, rgba(255,0,0,0), rgb(209 29 29)); background-color: #131416;">
                <h2 style="color:#fff"><?//=$nama_dashboard;?>Sistem myDaftar - draf</h2>
            
                <div class="right-wrapper pull-right">
                    <ol class="breadcrumbs">
                        <li style="color:#fff">
                            <a href="index.php">
                                <i class="fa fa-home" style="color:#fff"></i>
                            </a>
                        </li>
                        <li style="color:#fff"><span style="color:#fff;font-weight: bold">DASHBOARD</span></li>
                        <!-- <li style="color:#fff"><span style="color:#fff;font-weight: bold"><?//=$module;?></span></li> -->
                        <?php if(!empty($module)){ ?>
                        <li style="color:#fff"><span style="color:#fff;font-weight: bold"><?=$module;?></span>
                        <?php } ?>
                    </ol>
            
                    &nbsp;&nbsp;&nbsp;
                    <?php //print $pages;?>
                </div>
            </header>
            <div class="form-group">
                <div class="row col-sm-12">
                    <?php include 'apps_menu.php'; ?>
                </div>
            </div>  
			<?php 
			print $pages.":".$module.":".$menu.":".$submenu.":".$actions.":".$id.":".$id2; 
			if(empty($pages)){ $pages = 'dashboard/dashboard_utama'; }
			
            if (file_exists($pages.".php")) {
                include $pages.".php";
            } else { 			
                include "no_file.php";
            }
			?>						
			<?php //print $disp_pages; ?>

		</section>


<script language="javascript" type="text/javascript">
//document.frm.gsasar_nama.focus();
// $('#jenis_perkhidmatan').selectpicker('refresh');
$(document).ready(function() {
    $('.select2').select2({
    closeOnSelect: false
});
}); 
</script>   