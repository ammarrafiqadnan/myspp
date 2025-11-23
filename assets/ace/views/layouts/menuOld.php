
 <?php 
 use app\models\Appli;
 use app\models\Applicant;
 
 $user = Applicant::find()->where(['user_id' => Yii::$app->user->id])->one();
 $penjual = Appli::find()->where(['applicant_id' => $user->id, 'appli_type' => 'R2'])->one();
 $pembuat = Appli::find()->where(['applicant_id' => $user->id, 'appli_type' => 'R1'])->one();
 $lisence = Appli::find()->where(['applicant_id' => $user->id, 'appli_type' => 'L1'])->one();

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
                           
                            <?php if ($lisence->appli_sts == 'AP') {$class = 'disabled'; } else { $class = ''; }?>
                            <li class="<?=$class?>"><a href="index.php?r=license/appli/applicant">Permohonan Baru</a></li>

                            <?php if (\Yii::$app->session['has_license'] === 'N') { $class = 'disabled'; } else { $class = ''; } ?>
                            <li class="<?=$class?>"><a href="index.php?r=license/renewal/create">Pembaharuan </a></li>
                            <li class="<?=$class?>"><a href="index.php?r=license/copy/create">Sijil Pendua</a></li>
                            <li class="<?=$class?>"><a href="index.php?r=license/modify/create">Perubahan </a></li>
                            <li class="<?=$class?>"><a href="index.php?r=license/import/create">Rekod Pengimportan</a></li>
                            <li class="<?=$class?>"><a href="index.php?r=license/import/list">Senarai Rekod Pengimportan</a></li>
                            <li class="<?=$class?>"><a href="index.php?r=license/cert/list">Senarai Lesen</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Pendaftaran<span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            
                             <?php if ($pembuat->appli_sts == 'AP') {$class = 'disabled'; } else { $class = ''; }?>
                            <li class="<?=$class?>"><a href="index.php?r=producer/appli/applicant">Permohonan Baru Pembuat</a></li>

                            <?php if (\Yii::$app->session['has_licenseP'] === 'N') { $class = 'disabled'; } else { $class = ''; } ?>
                            <li class="<?=$class?>"><a href="index.php?r=producer/renewal/create">Pembaharuan  Pembuat</a></li>
                            <li class="<?=$class?>"><a href="index.php?r=producer/modify/create">Perubahan Sijil Pembuat</a></li>
                            <li class="<?=$class?>"><a href="index.php?r=producer/copy/create">Salinan Pendua Sijil Pembuat</a></li>
                            <li class="<?=$class?>"><a href="index.php?r=producer/record/list">Rekod Pembuatan</a></li>
                            <li class="<?=$class?>"><a href="index.php?r=producer/record/search">Senarai Rekod Pembuatan</a></li>
                            <li class="<?=$class?>"><a href="index.php?r=producer/cert/list">Senarai Sijil Pembuat</a></li>
                            <li role="separator" class="divider"></li>
                            
                             <?php if ($penjual->appli_sts == 'AP') {$class = 'disabled'; } else { $class = ''; }?>
                            <li class="<?=$class?>"><a href="index.php?r=seller/appli/applicant">Permohonan Baru Penjual</a></li>

	                    <?php if (\Yii::$app->session['has_licenseJ'] === 'N') { $class = 'disabled'; } else { $class = ''; } ?>
                            <li class="<?=$class?>"><a href="index.php?r=seller/renewal/create">Pembaharuan  Penjual</a></li>
                            <li class="<?=$class?>"><a href="index.php?r=seller/modify/create">Perubahan Sijil Penjual</a></li>
                            <li class="<?=$class?>"><a href="index.php?r=seller/copy/create">Salinan Pendua Sijil Penjual</a></li>
                            <li class="<?=$class?>"><a href="index.php?r=seller/record/list">Rekod Penjualan</a></li>
                            <li class="<?=$class?>"><a href="index.php?r=seller/record/search">Senarai Rekod Penjualan</a></li>
                            <li class="<?=$class?>"><a href="index.php?r=seller/cert/list">Senarai Sijil Penjual</a></li>
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