<div class="row jlr-dashbox">

    <div class="col-sm-8 col-lg-offset-2">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h1 class="box-title"><?= h($quote->topic) ?></h1>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <i class="fa fa-book margin-r-5"></i> Quote
                <br/><br/>
                <p style="font-size: 18px" class="pull-right">
                    <?= h($quote->quote) ?>
                </p>
                <br/>
                <hr>
                <br/>
                <i class="fa fa-map-marker margin-r-5"></i> Created By
                <br/>
                <p class="text-muted pull-right"><?= h($quote->i_r_c_user->nickname) ?></p>
                <br/>
                <hr>
                <br/>
                <i class="fa fa-pencil margin-r-5"></i> Created On
                <br/>
                <p class="pull-right">
                    <?= $quote->created ?>
                </p>
                <br/>
            </div>
            <!-- /.box-body -->
        </div>
    </div>
</div>
