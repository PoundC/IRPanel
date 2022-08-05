<div class="row jlr-dashbox">

    <div class="col-lg-11 col-lg-offset-0">

        <div class="box" style="padding-top: 30px">
            <div class="box-body">

                <?php foreach($links as $result): ?>

                <div class="row" style="padding-bottom: 20px;">
                <div class="col-sm-4 col-sm-offset-1">
                    <?php $fname = md5($result->link); $fletter = substr($fname, 0, 1); ?>
                    <img src="/ss/<?= $fletter ?>/<?= $fname ?>.400.png" />
                    <br/>
                    <br/>
                    <center><h4><a href="/i_r_c_links/links/view/<?= $result->id ?>">View Link Record and Comments</a></h4></center>
                </div>
                <div class="col-sm-6">
                    <div class="row">
                        <div class="col-sm-9 col-sm-offset-2">
                            <div class="row">
                                <div class="col-sm-12">
                                    <?php if($result->title == '') { ?>
                                        <a href="<?= $result->link ?>" target="_blank"><h3><?= h($result->link) ?></h3></a>
                                    <?php } else { ?>
                                        <a href="<?= $result->link ?>" target="_blank"><h3><?= h(str_replace("&amp;", "&", $result->title)) ?></h3></a>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    Posted by <b>[</b> <?= $result->i_r_c_user->nickname ?> in <?= $result->i_r_c_channel->pound_name ?><b>]</b> on <b><?= $result->created ?></b>
                                </div>
                            </div>
                            <br/>
                            <div class="row">
                                <div class="col-sm-12">
                                    <p style="font-size: 18px;"><?= $result->description ?></p>
                                </div>
                            </div>
                            <br/>
                            <div class="row">
                                <div class="col-sm-12">
                                    <h4>Comments</h4>
                                    <?php foreach($result->parent_comments as $comment) { ?>
                                    <div class="row">
                                        <div class="col-sm-8 col-sm-offset-1">[ <?= $comment->i_r_c_user->nickname ?> ] <span></span><?= $comment->comment ?></span></div>
                                    </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                <hr/>
                <br/>

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
