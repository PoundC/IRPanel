<div class="row jlr-dashbox">

    <div class="col-sm-8 col-lg-offset-2">

        <div class="box box-solid">
            <div class="box-header with-border">
                <i class="fa fa-quote-right"></i>

                <h3 class="box-title"><?= h($quote->topic) ?></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <blockquote>
                    <p><?= h($quote->quote) ?></p>
                    <small>Created by <cite title="Source Title"><?= h($quote->i_r_c_user->nickname) ?></cite> on <strong><?= $quote->created ?></strong></small>
                </blockquote>
            </div>
            <!-- /.box-body -->
        </div>

    </div>
</div>
