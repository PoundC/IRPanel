<?php if(!isset($answerResult)) { ?>
<div class="row jlr-dashbox">

    <div class="col-lg-10 col-lg-offset-1">

        <div class="box">
            <div class="box-header">
                <center><h3>Search Help</h3></center>
            </div>

            <div class="box-body">

                <?= $this->Form->create(null, ['url' => ['controller' => 'Help', 'action' => 'help']]); ?>

                <div class="row">

                    <div class="col-lg-6 col-lg-offset-2">

                        <div class="form-group">
                            <label>Your search query</label>
                            <?= $this->Form->control('search', ['label' => false, 'type' => 'text', 'placeholder' =>
                            'How do I mine Ghost Coins?', 'class' => 'form-control']); ?>
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
<?php } ?>

<?php if(isset($topicsResults)) { ?>

<?= $this->element('Help/topic_results') ?>

<?php } ?>

<?php if(isset($searchResults) && $searchResults > 0) { ?>

<?= $this->element('Help/help_results') ?>

<?php } ?>

<?php if(isset($answerResult)) { ?>

<?= $this->element('Help/view_answer') ?>

<?php } ?>
