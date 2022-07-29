<div class="row jlr-dashbox">

    <div class="col-lg-11 col-lg-offset-0">

        <div class="box">
            <div class="box-header">
                <center><h3>Search Links</h3></center>
            </div>

            <div class="box-body">

                <?= $this->Form->create(null, ['url' => ['plugin' => 'IRPanelLinks', 'controller' => 'Links', 'action' => 'search']]); ?>

                <div class="row">

                    <div class="col-lg-6 col-lg-offset-2">

                        <div class="form-group">
                            <label>Your search query</label>
                            <?= $this->Form->control('search', ['label' => false, 'type' => 'text', 'placeholder' =>
                                'Enter someone\'s username or word in title or description or content here.', 'class' => 'form-control']); ?>
                        </div>

                    </div>

                    <div class="col-lg-2 col-lg-offset-0">

                        <div class="form-group">
                            <?= $this->Form->button('Search', ['class' => 'btn
                            btn-primary btn-block btn-flat', 'style' => 'margin-top: 20px;']) ?>
                        </div>

                    </div>

                </div>

                <?= $this->Form->end() ?>

            </div>

        </div>

    </div>

</div>

<?php if(isset($results)) { ?>
    <div class="row jlr-dashbox">

        <div class="col-lg-11 col-lg-offset-0">

            <div class="box" style="padding-top: 30px;">

                <div class="box-body">

                    <?php foreach($results as $result): ?>

                        <div class="row" style="padding-bottom: 20px;">
                            <div class="col-sm-4 col-sm-offset-1">
                                <?php $fname = md5($result->link); $fletter = substr($fname, 0, 1); ?>
                                <img src="/ss/<?= $fletter ?>/<?= $fname ?>.400.png" />
                                <br/>
                            </div>
                            <div class="col-sm-6">
                                <div class="row">
                                    <div class="col-sm-10 col-sm-offset-1">
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
                                                Posted by <b>[</b> <?= $result->i_r_c_user->nickname ?>  in <?= $result->i_r_c_channel->pound_name ?><b>]</b> on <b><?= $result->created ?></b>
                                            </div>
                                        </div>
                                        <br/>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <p style="font-size: 18px;"><?= $result->description ?></p>
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
<?php } ?>
