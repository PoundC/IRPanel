<div class="row jlr-dashbox">

    <div class="col-sm-8 col-lg-offset-2">

        <div class="box box-solid">
            <div class="box-header with-border">
                <?php if($link->title == '') { ?>
                    <h3 class="box-title"><a href="<?= $link->link ?>"><?= h($link->link) ?></a></h3>
                <?php } else { ?>
                    <h3 class="box-title"><a href="<?= $link->link ?>"><?= h($link->title) ?></a></h3>
                <?php } ?>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <blockquote>
                    <p><?= h($link->description) ?></p>
                    <small>Created by <cite title="Source Title"><?= h($link->i_r_c_user->nickname) ?></cite> on <strong><?= $link->created ?></strong></small>
                </blockquote>
            </div>
            <!-- /.box-body -->
        </div>

    </div>
</div>
