<?php
$sess = Yii::$app->session;
if ($sess->hasFlash('msg') || $sess->hasFlash('err')):
    if ($sess->hasFlash('msg')) :
        ?>
        <div id="xalert" class="alert alert-success">
            <?= $sess->getFlash('msg') ?>
            <button type="button" class="close" data-dismiss="alert">
                &nbsp; <i class="ace-icon fa fa-times"></i>
            </button>
        </div>
        <?php
    endif;

    if ($sess->hasFlash('err')) :
        ?>
        <div id="xalert" class="alert alert-danger">
            <?= $sess->getFlash('err') ?>
            <button type="button" class="close" data-dismiss="alert">
                &nbsp; <i class="ace-icon fa fa-times"></i>
            </button>
        </div>

    <?php endif;
    ?>

    <script>
        setTimeout(function () {
            $('#xalert').hide('slow');
        }, 5000);
    </script>
<?php endif; ?>