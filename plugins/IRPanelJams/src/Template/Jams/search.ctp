<div class="row jlr-dashbox">

    <div class="col-lg-11 col-lg-offset-0">

        <div class="box">
            <div class="box-header">
                <center><h3>Search Jams</h3></center>
            </div>

            <div class="box-body">

                <?= $this->Form->create(null, ['url' => ['plugin' => 'IRPanelJams', 'controller' => 'Jams', 'action' => 'search']]); ?>

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
    <style>
        .ytcontainer {
            position: relative;
            width: 100%;
            height: 0;
            padding-bottom: 56.25%;
        }
        .ytvideo {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }
    </style>
    <div class="row jlr-dashbox">
        <div class="col-lg-11 col-lg-offset-0">

            <div class="box">
                <div class="box-header">
                    <center><h3>Jams</h3></center>
                </div>
                <div class="box-body scroll-snappers">
                    <div class="row">
                        <div class="col-lg-12">
                            <?php foreach($results as $result): ?>

                                <center>
                                    <div class="col-sm-12 snapit">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <a href="<?= $result->link ?>" target="_blank">
                                                    <?php if($result->title == ' ') { ?>
                                                        <h3><?= h($result->link) ?></h3>
                                                    <?php } else { ?>
                                                        <h3><?= h($result->title) ?></h3>
                                                    <?php } ?>
                                                </a>
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
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <?php if(strpos($result->link, '=') !== FALSE) { ?>
                                                    <?php $hash = substr($result->link, strpos($result->link, '=')+1); ?>
                                                <?php } else { ?>
                                                    <?php $hash = substr($result->link, strpos($result->link, 'be/')+3); ?>
                                                <?php } ?>
                                                <div class="ytcontainer">
                                                    <iframe class="ytvideo" src="https://www.youtube.com/embed/<?= $hash ?>" frameborder="0" allow="accelerometer; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                                </div>
                                            </div>
                                        </div>
                                        <hr/>
                                    </div>
                                </center>

                            <?php endforeach; ?>
                        </div>
                    </div>
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
