<div class="row jlr-dashbox">

    <div class="col-lg-11 col-lg-offset-0">

        <div class="box">
            <div class="box-header">
                <center><h3>Search IRC Quotes</h3></center>
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

        <div class="box">
            <div class="box-header">
                <center><h3>Search Results</h3></center>
            </div>

            <div class="box-body">

        <?php foreach($results as $result): ?>

            <div class="row">
                <div class="col-sm-10 col-sm-offset-1">
                    <div class="row">
                        <div class="col-sm-12">
                            <a href="/quotes/view/<?= $result->id ?>"><h3><?= h($result->topic) ?></h3></a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <p style="font-size: 18px;"><?= h($result->quote) ?></p>
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
<?php } ?>
