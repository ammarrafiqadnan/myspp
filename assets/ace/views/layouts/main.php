<?php
use yii\helpers\Html;
use yii\helpers\Url;
use app\assets\AppAsset;
AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!doctype html>
<html>
    <head>
        <title>eAMH - Portal</title>
        <link rel="stylesheet" href="../themes/ace/dist/css/bootstrap.min.css" />
        <link rel="stylesheet" href="./font-awesome/css/font-awesome.min.css" />
<!--        <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Open+Sans:400,300" />-->
        <link rel="stylesheet" href="../themes/ace/dist/css/ace.min.css" class="ace-main-stylesheet" id="main-ace-style" />
        <link href="./jquery/jquery-ui.min.css" rel="stylesheet"> 
        <script src="./jquery/external/jquery/jquery.js"></script>
        <script src="./js/underscore-min.js"></script>
        <script src="./js/backbone-min.js"></script>
        <script src="./jquery/jquery-ui.js"></script>
        <script src="../themes/ace/dist/js/ace-extra.min.js"></script>
        <script src="./twitter/js/bootstrap.js"></script>
        <script src="./js/amh.js"></script>
            <script src="../themes/ace/dist/js/dataTables/jquery.dataTables.min.js"></script>
        <script src="../themes/ace/dist/js/dataTables/jquery.dataTables.bootstrap.min.js"></script>
        <link href="../themes/ace/css/layout.css" rel="stylesheet">
                <link rel="stylesheet" href="https://cdn.datatables.net/1.10.15/css/dataTables.bootstrap.min.css">

    </head>
    <body>
    <?php $this->beginBody() ?>
        <div id="iwrapper">
            <div id="iheader"></div> 
            <?php include 'menu.php';  ?>
            <div id="icontent">
                <?php include 'msg.php' ?>
                <?php echo $content;  ?>
            </div>
            <div style="clear: both"></div>
            <div id="ifooter" style="text-align: center">
                &COPY; <?php echo date('Y')?> oleh Jabatan Perkhidmatan Veterinar. Semua hakcipta terpelihara.<br>
                Sistem ini berfungsi dengan terbaik menggunakan pelayar Firefox dan Chrome versi terkini serta Internet Explorer versi 10 dan ke atas dengan resolusi 1024 x 768. 
                <div style="clear: both"></div>
            </div>
        </div>
    <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>