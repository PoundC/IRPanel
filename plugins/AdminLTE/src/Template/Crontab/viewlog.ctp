<div class="row jlr-dashbox">
    <div class="col-lg-6 col-lg-offset-3">
        <?php if($cronJobResult->success != '-1') { ?>
        <div class="box" style="color:white; background-color:green;">
            <?php } else { ?>
        <div class="box" style="color:white; background-color:green;">
        <?php } ?>
            <div class="box-header">
                <center><h3 style="color:white;"><?= $cronJobResult->crontab->name ?></h3></center>
            </div>
            <div class="box-body">
                <center><p>
                    <?= $cronJobResult->created ?>
                </p></center>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-5 col-lg-offset-1">
        <div class="box">
            <div class="box-header">
                <h3>Cronjob Output Log</h3>
            </div>
            <div class="box-body">
                <p>
                    <?= $cronJobResult->output ?>
                </p>
            </div>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="box">
            <div class="box-header">
                <h3>Cronjob Error Log</h3>
            </div>
            <div class="box-body">
                <p>
                    <?= $cronJobResult->error ?>
                </p>
            </div>
        </div>
    </div>
</div>