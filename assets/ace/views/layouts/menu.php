
<?php 
use app\models\Appli;
use app\models\Cert;
use app\models\Applicant;

$user = Applicant::find()->where(['user_id' => Yii::$app->user->id])->one();
$penjual = Appli::find()->where(['applicant_id' => $user->id, 'appli_type' => 'R2'])->one();
$pembuat = Appli::find()->where(['applicant_id' => $user->id, 'appli_type' => 'R1'])->one();
$lisence = Appli::find()->where(['applicant_id' => $user->id, 'appli_type' => 'L1'])->one();


// query untuk permohonan yang masih dalam proses lagi 30/12/2019
$pembuateRe = Appli::find()->where(['applicant_id' => $user->id, 'appli_type' =>  ['R1','R3','R5'],'appli_sts' => 'PR'])->orderBy(['id' => SORT_DESC])->one();
$penjualRe = Appli::find()->where(['applicant_id' => $user->id, 'appli_type' => ['R2','R4','R6'],'appli_sts' => 'PR'])->orderBy(['id' => SORT_DESC])->one();
$lisenceRe = Appli::find()->where(['applicant_id' => $user->id,  'appli_type' => ['L1','L2','L3'], 'appli_sts' => 'PR'])->orderBy(['id' => SORT_DESC])->one();


$year = date('Y');
//$import = LicenseImport::find()->where(['applicant_id' => $user->id,'YEAR(import_dt)'=>$year])->all();
$import = Appli::find()->where(['applicant_id' => $user->id, 'YEAR(appli_dt)' => $year, 'appli_type' => 'L6'])->one();
$pembuats = Appli::find()->where(['applicant_id' => $user->id, 'YEAR(appli_dt)' => $year, 'appli_type' => 'R13'])->one();
$penjuals = Appli::find()->where(['applicant_id' => $user->id, 'YEAR(appli_dt)' => $year, 'appli_type' => 'R14'])->one();

//query untuk semak lebih dari 2 tahun
$PembuatID = Appli::find()->where(['applicant_id' => $user->id, 'appli_type' => ['R1', 'R3','R5'], 'appli_sts' => ['AP','PM']])->max('id');
$PenjualID = Appli::find()->where(['applicant_id' => $user->id, 'appli_type' => ['R2','R4','R6'], 'appli_sts' => ['AP','PM']])->max('id');
$PelesenanID = Appli::find()->where(['applicant_id' => $user->id, 'appli_type' => ['L1', 'L2','L3'], 'appli_sts' => ['AP','PM']])->max('id');

$PelesenanCert = Cert::find()->where(['applicant_id' => $user->id, 'appli_id' => $PelesenanID ])->one();

$penjualCert = Cert::find()->where(['applicant_id' => $user->id, 'appli_id' => $PenjualID ])->one();
$pembuatCert = Cert::find()->where(['applicant_id' => $user->id, 'appli_id' => $PembuatID ])->one();

$contractPelesenan = Appli::find()->where(['id' => $PelesenanID])->one();
$contractPembuat = Appli::find()->where(['id' => $PembuatID])->one();
$contractPenjual = Appli::find()->where(['id' => $PenjualID])->one();
?>

<nav class="navbar navbar-inverse">
	<div class="container-fluid">
		<!-- Brand and toggle get grouped for better mobile display -->
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
		</div>

		<!-- Collect the nav links, forms, and other content for toggling -->
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			<ul class="nav navbar-nav">
				<li><a href="index.php?r=main/home"><span class="fa fa-home" style="font-size: 24px;"></span></a></li>
				<?php if (!\Yii::$app->user->isGuest) : ?>
					<li><a href="index.php?r=main/home/msg"><!--<span class="badge badge-danger">3</span>--> Notis</a></li>
					<li><a href="index.php?r=main/dashboard">Dashboard</a></li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Perlesenan<span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">

							<?php
							$asign = new \DateTime($contractPelesenan->appli_dt);
							$date_now = date('Y-m-d');
							$dates = new \DateTime($date_now);
							$ages = $dates->diff($asign);
							$yearsPelesenan = $ages->y;

                         $certdtLesen = new \DateTime($PelesenanCert->end_dt);
                         $certendDt = $dates->diff($certdtPem);
                         $yearsLesenCert = $certendDt->y;

                         if ($yearsPelesenan >= 2 && $yearsLesenCert >=2) {
                            $class = '';
                        } else {
                            if ($lisence->appli_sts == 'AP') {
                               $class = 'disabled';
                           } else {
                               $class = '';
                           }
                       }
                       ?>
                       <li class="<?= $class ?>"><a href="index.php?r=license/appli/applicant">Permohonan Baru</a></li>
                       <?php
                       if (\Yii::$app->session['has_license'] === 'N') {
                        $class = 'disabled';
                    } else {
                        $class = '';
                    }
                    ?>

                    <?php if ((empty($import) === true)) { ?>
                        <li class="disabled"><a href="index.php?r=license/renewal/create" data-rel="tooltip" title="Sila Isi Rekod Pengimportan Dahulu">Pembaharuan </a></li>
                    <?php } else { ?>
                      <?php if(empty($lisenceRe)) { ?>
                          <li class="<?= $class ?>"><a href="index.php?r=license/renewal/create">Pembaharuan </a></li>
                      <?php }else if ($lisenceRe->appli_sts != 'AP') { ?>
                        <!--condition disable menu untuk permohonan yang masih dalam proses lagi 30/12/2019 start-->

                        <li class="disabled"><a href="index.php?r=license/renewal/create">Pembaharuan </a></li>
                        <?php
                    } else {
                     ?>
                     <li class="<?= $class ?>"><a href="index.php?r=license/renewal/create">Pembaharuan </a></li>
                     <?php
                                } //condition disable menu untuk permohonan yang masih dalam proses lagi 30/12/2019 end
                            }
                            ?>
                            <?php
                            if ($yearsPelesenan >= 2) {
                            	$class = 'disabled';
                            	?>
                            	<li class="<?= $class ?>"><a href="index.php?r=license/copy/create">Sijil Pendua</a></li>
                            	<li class="<?= $class ?>"><a href="index.php?r=license/modify/create" >Perubahan </a></li>
                            	<li class="<?= $class ?>"><a href="index.php?r=license/import/create">Rekod Pengimportan</a></li>
                            	<li class=" "><a href="index.php?r=license/import/list">Senarai Rekod Pengimportan</a></li>
                            	<li class=" "><a href="index.php?r=license/cert/list">Senarai Lesen</a></li>
                            <?php }else{ ?>
                            	<li class="<?= $class ?>"><a href="index.php?r=license/copy/create">Sijil Pendua</a></li>
                            	<li class="<?= $class ?>"><a href="index.php?r=license/modify/create" >Perubahan </a></li>
                            	<li class="<?= $class ?>"><a href="index.php?r=license/import/create">Rekod Pengimportan</a></li>
                            	<li class="<?= $class ?>"><a href="index.php?r=license/import/list">Senarai Rekod Pengimportan</a></li>
                            	<li class="<?= $class ?>"><a href="index.php?r=license/cert/list">Senarai Lesen</a></li>
                            <? } ?>
                        </ul>
                    </li>
                    <li class="dropdown">
                    	<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Pendaftaran<span class="caret"></span></a>
                    	<ul class="dropdown-menu" role="menu">


                    		<?php
                    		$asign = new \DateTime($contractPembuat->appli_dt);
                    		$date_now = date('Y-m-d');
                    		$dates = new \DateTime($date_now);
                    		$ages = $dates->diff($asign);
                    		$yearsPembuat = $ages->y;

                          $certdtPem = new \DateTime($pembuatCert->end_dt);
                          $certendDt = $dates->diff($certdtPem);
                          $yearsPembuatCert = $certendDt->y;
                          ?>

                          <?php
                          if ($yearsPembuat  >= 2 && $yearsPembuatCert >=2) {
                           $class = '';
                       } else {
                           if ($pembuat->appli_sts == 'AP') {
                            $class = 'disabled';
                        } else {
                            $class = '';
                        }
                    }
                    ?>
                    <li class="<?= $class ?>"><a href="index.php?r=producer/appli/applicant">Permohonan Baru Pembuat</a></li>
                    <?php
                    if (\Yii::$app->session['has_licenseP'] === 'N') {
                       $class = 'disabled';
                   } else {
                    if ($yearsPembuat  >= 2 && $yearsPembuatCert >=2) {
                        $class = 'disable';
                    } else {
                        $class = '';
                    }
                }
                ?>
                <?php if ((empty($pembuats) === true)) { ?>

                   <li class="disabled"><a href="index.php?r=producer/renewal/create" data-rel="tooltip" title="Sila Isi Rekod Pembuatan Dahulu">Pembaharuan  Pembuat</a></li>
               <?php } else { ?>

                <?php if(empty($pembuatRe)) { ?>
                    <li class="<?= $class ?>"><a href="index.php?r=producer/renewal/create">Pembaharuan  Pembuat</a></li>
                <?php }else if ($pembuatRe->appli_sts != 'AP') { ?>
                    <!--condition disable menu untuk permohonan yang masih dalam proses lagi 30/12/2019 start-->

                    <li class="disabled"><a href="index.php?r=producer/renewal/create">Pembaharuan  Pembuat</a></li>
                    <?php
                } else {
                    ?>
                    <li class="<?= $class ?>"><a href="index.php?r=producer/renewal/create">Pembaharuan  Pembuat</a></li>

                    <?php
                                }//condition disable menu untuk permohonan yang masih dalam proses lagi 30/12/2019 end
                            }
                            ?>
                            <?php
                            if ($yearsPembuat >= 2 && $yearsPembuatCert >=2) {
                            	$class = 'disabled';
                            	?>

                            	<li class="<?= $class ?>"><a href="index.php?r=producer/modify/create">Perubahan Sijil Pembuat</a></li>
                            	<li class="<?= $class ?>"><a href="index.php?r=producer/copy/create">Salinan Pendua Sijil Pembuat</a></li>
                            	<li class="<?= $class ?>"><a href="index.php?r=producer/record/list">Rekod Pembuatan</a></li>
                            	<li class=""><a href="index.php?r=producer/record/search">Senarai Rekod Pembuatan</a></li>
                            	<li class=""><a href="index.php?r=producer/cert/list">Senarai Sijil Pembuat</a></li>
                            <?php } else { ?>
                            	<li class="<?= $class ?>"><a href="index.php?r=producer/modify/create">Perubahan Sijil Pembuat</a></li>
                            	<li class="<?= $class ?>"><a href="index.php?r=producer/copy/create">Salinan Pendua Sijil Pembuat</a></li>
                            	<li class="<?= $class ?>"><a href="index.php?r=producer/record/list">Rekod Pembuatan</a></li>
                            	<li class="<?= $class ?>"><a href="index.php?r=producer/record/search">Senarai Rekod Pembuatan</a></li>
                            	<li class="<?= $class ?>"><a href="index.php?r=producer/cert/list">Senarai Sijil Pembuat</a></li>
                            <?php } ?>
                            <li role="separator" class="divider"></li>


                            <?php
                            $asign = new \DateTime($contractPenjual->appli_dt);
                            $date_now = date('Y-m-d');
                            $dates = new \DateTime($date_now);
                            $ages = $dates->diff($asign);
                            $yearsPenjual = $ages->y;
                            
                            $certdt = new \DateTime($penjualCert->end_dt);
                            $certendDt = $dates->diff($certdt);
                            $yearsPenjualCert = $certendDt->y;

                            ?>

                            <?php
                            if ($yearsPenjual >= 2 && $yearsPenjualCert >=2 ) {
                            	$class = '';
                            } else {

                            	if ($penjual->appli_sts == 'AP') {
                            		$class = 'disabled';
                            	} else {
                            		$class = '';
                            	}
                            }
                            ?>
                            <li class="<?= $class ?>"><a href="index.php?r=seller/appli/applicant">Permohonan Baru Penjual</a></li>
                            <?php
                            if (\Yii::$app->session['has_licenseJ'] === 'N') {
                            	$class = 'disabled';
                            } else {
                            	if ($yearsPenjual >= 2 && $yearsPenjualCert >=2 ) {
                            		$class = 'disable';
                            	} else {
                            		$class = '';
                            	}
                            }
                            ?>
                            <?php if ((empty($penjuals) === true)) { ?>
                            	<li class="disabled"><a href="index.php?r=seller/renewal/create" data-rel="tooltip" title="Sila Isi Rekod Penjualan Dahulu">Pembaharuan  Penjual</a></li>
                            <?php } else { ?>
                              <?php if(empty($penjualRe)) { ?>
                                <li class="<?= $class ?>"><a href="index.php?r=seller/renewal/create">Pembaharuan  Penjual</a></li>
                            <?php }else if ($penjualRe->appli_sts != 'AP') { ?>
                            	<!--condition disable menu untuk permohonan yang masih dalam proses lagi 30/12/2019 start-->
                            	
                              <li class="disabled"><a href="index.php?r=seller/renewal/create">Pembaharuan  Penjual</a></li>
                              <?php
                          } else {
                              ?>
                              <li class="<?= $class ?>"><a href="index.php?r=seller/renewal/create">Pembaharuan  Penjual</a></li>
                              <?php
                                }//condition disable menu untuk permohonan yang masih dalam proses lagi 30/12/2019 end
                            }
                            ?>
                            <?php
                            if ($yearsPenjual >= 2 && $yearsPenjualCert >=2 ) {
                            	$class = 'disabled';
                            	?>
                            	<li class="<?= $class ?>"><a href="index.php?r=seller/modify/create">Perubahan Sijil Penjual</a></li>
                            	<li class="<?= $class ?>"><a href="index.php?r=seller/copy/create">Salinan Pendua Sijil Penjual</a></li>
                            	<li class="<?= $class ?>"><a href="index.php?r=seller/record/list">Rekod Penjualan</a></li>
                            	<li class=""><a href="index.php?r=seller/record/search">Senarai Rekod Penjualan</a></li>
                            	<li class=""><a href="index.php?r=seller/cert/list">Senarai Sijil Penjual</a></li>
                            <? }else { ?>
                            	<li class="<?= $class ?>"><a href="index.php?r=seller/modify/create">Perubahan Sijil Penjual</a></li>
                            	<li class="<?= $class ?>"><a href="index.php?r=seller/copy/create">Salinan Pendua Sijil Penjual</a></li>
                            	<li class="<?= $class ?>"><a href="index.php?r=seller/record/list">Rekod Penjualan</a></li>
                            	<li class="<?= $class ?>"><a href="index.php?r=seller/record/search">Senarai Rekod Penjualan</a></li>
                            	<li class="<?= $class ?>"><a href="index.php?r=seller/cert/list">Senarai Sijil Penjual</a></li>
                            <? } ?>
                        </ul>
                    </li>
                    <li class="dropdown">
                    	<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Lain-Lain<span class="caret"></span></a>
                    	<ul class="dropdown-menu" role="menu">
                    		<li><a href="index.php?r=main/cancel/create">Pembatalan Permohonan</a></li>
                    		<li><a href="index.php?r=main/cancel/list">Senarai Permohonan Pembatalan</a></li>
                    		<li><a href="index.php?r=main/item/view">Senarai Item Syarikat</a></li>
                    	</ul>
                    </li>
                <?php endif; ?>
            </ul>

            <ul class="nav navbar-nav navbar-right">
            	<li class=""><a href="index.php">FAQ </a></li>
            	<li class=""><a href="index.php">Hubungi Kami </a></li>
            	<li><a href="../themes/ace/Manual Pengguna Awam.pdf" target="_blank"><img src="../themes/ace/images/icon_pdf.png" width="20px" height="24px" style="font-size: 24px;" title="Manual Pengguna"></span></a></li>
            	<?php if (!\Yii::$app->user->isGuest) : ?>
            		<li><a href="index.php?r=main/profile/update">Profil</a></li>
            		<li class=""><a href="index.php?r=main/home/logout">Log Keluar</a></li>
            	<?php endif;
            	?>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>

<script>
	$(function() {
		$("li.disabled a").click(function(e) {
			e.preventDefault();
		}); 
	});
</script>