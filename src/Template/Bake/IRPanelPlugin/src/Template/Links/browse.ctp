<div class="row jlr-dashbox">

    <div class="col-lg-11 col-lg-offset-0">

        <div class="box">
            <div class="box-header">
                <center><h3>Links</h3></center>
            </div>

            <div class="box-body">

                <?php foreach($links as $result): ?>

                    <div class="row">
                        <div class="col-sm-10 col-sm-offset-1">
                            <div class="row">
                                <div class="col-sm-12">
                                    <?php if($result->title == '') { ?>
                                        <a href="<?= $result->link ?>" target="_blank"><h3><?= h($result->link) ?></h3></a>
                                    <?php } else { ?>
                                        <a href="<?= $result->link ?>" target="_blank"><h3><?= h($result->title) ?></h3></a>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    Posted by <b>[</b> <?= $result->i_r_c_user->nickname ?> <b>]</b> on <b><?= $result->created ?></b>
                                </div>
                            </div>
                            <br/>
                            <div class="row">
                                <div class="col-sm-12">
                                    <p style="font-size: 18px;"><?= h($result->description) ?></p>
                                </div>
                            </div>
                            <hr/>
                        </div>
                    </div>

                <?php endforeach; ?>

            </div>
            <div class="box-footer no-padding">
                <div class="mailbox-controls">
                    <center>
                        <div class="paginator">
                            <ul class="pagination">
                                <?= $this->Paginator->first('<< ' . __('first')) ?>
                                <?= $this->Paginator->prev('< ' . __('previous')) ?>
                                <?= $this->Paginator->numbers() ?>
                                <?= $this->Paginator->next(__('next') . ' >') ?>
                                <?= $this->Paginator->last(__('last') . ' >>') ?>
                            </ul>
                            <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
                        </div>
                    </center>
                </div>
            </div>
        </div>

    </div>

</div>
