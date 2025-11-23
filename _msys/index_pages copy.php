<?php 

// $tahun=strtoupper(isset($_REQUEST["tahun"])?$_REQUEST["tahun"]:"");

$disp_menu = $menu;

?>

        <section role="main" class="content-body">

            <!--<header class="page-header visible-lg" style="background: linear-gradient(90deg, rgb(38, 167, 228) 0%, rgba(236, 241, 244, 0.353) 87%);">

                <h2 style="color:#FFF">Dashboard</h2>

            

                <div class="right-wrapper pull-right">

                    <ol class="breadcrumbs">

                        <li>

                            <a href="index.html">

                                <i class="fa fa-home"></i>

                            </a>

                        </li>

                        <li><span>Dashboard</span></li>

                        <?php if(!empty($disp_menu)){ ?>

                        <li><span><?=$disp_menu;?></span>

                        <?php } ?>

                    </ol>

            

                    <a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>

                </div>

            </header>-->

            <header class="page-header" style="background: rgb(128,0,0);background: linear-gradient(90deg, rgb(38, 167, 228) 79%, rgba(236, 241, 244, 0.353) 100%);">

                <h2 style="color:#000"><?//=$nama_dashboard;?>Sistem mySPP</h2>

            

                <div class="right-wrapper pull-right">

                    <ol class="breadcrumbs">

                        <li style="color:#000">

                            <a href="index.php">

                                <i class="fa fa-home" style="color:#000"></i>

                            </a>

                        </li>

                        <?php if(!empty($module)){ ?>

                            <li style="color:#000">

                                <span style="color:#000;font-weight: bold"><?=$module;?>

                                </span>

                            </li>

                        <?php } else { ?>

                            <li style="color:#000"><span style="color:#000;font-weight: bold">Dashboard</span></li>

                        <?php } if(!empty($disp_menu)){ ?>

                        <li style="color:#000"><span style="color:#000;font-weight: bold"><?=$disp_menu;?></span>

                        <?php } ?>

                    </ol>

            

                    &nbsp;&nbsp;&nbsp;

                    <?php //print $pages;?>

                </div>

            </header>

			<?php 

			print $pages.":".$module.":".$menu.":".$submenu.":".$actions.":".$id.":".$id2; 

			//if(empty($pages)){ $pages = 'dashboard/dashboard_utama'; }

			

            if (file_exists($pages.".php")) {

                include $pages.".php";

            } else { 			

                include "no_file.php";

            }

			?>						

			<?php //print $disp_pages; ?>



		</section>





