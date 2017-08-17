<div class="row">
    <div class="col-lg-8 col-lg-offset-2 text-center">
        <h2>Open Support Ticket</h2>
    </div>
</div>
<div class="row">
    <div class="col-lg-8 col-lg-offset-2 jlr-dashbox">
        <!-- general form elements disabled -->
        <div class="box box-warning" style="border-top-color:white !important;">
            <div class="row">
                &nbsp;
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <?= $this->Form->create($supportEntity, ['url' => '/support', 'context' => ['validator' => ['Messages'
                => 'support']]]) ?>
                <div class="row">
                    <div class="col-lg-5 col-lg-offset-1">
                        <div class="form-group">
                            <label>Select support topic</label>
                            <center><?= $this->Form->control('topic', ['class' => 'form-control select2', 'options' => $topics, 'label' => false]) ?></center>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="form-group">
                            <label>Select Priority</label>
                            <center><?= $this->Form->control('priority', ['class' => 'form-control select2', 'options' => [1 => 'Show Stopper', 2 => 'High', 3 => 'Medium', 4 => 'Low', 0 => 'None'], 'value' => '1', 'label' => false]) ?></center>
                        </div>
                    </div>
                </div>
                <div class="row">
                    &nbsp;
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label>Wtih one sentence describe your challenge</label>
                            <?= $this->Form->control('subject', ['label' => false, 'type' => 'text', 'placeholder' =>
                            'Subject goes here...', 'class' => 'form-control']); ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    &nbsp;
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label>Describe the challenge you are facing</label>
                            <?= $this->Form->control('message', ['label' => false, 'type' => 'textarea', 'placeholder'
                            => 'Enter message here...', 'class' => 'form-control']); ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    &nbsp;
                </div>
                <div class="row">
                    &nbsp;
                </div>
                <div class="row">
                    <div class="col-xs-4 col-xs-offset-4">
                        <?= $this->Form->button(__d('CakeDC/Users', 'Submit Support Ticket'), ['class' => 'btn
                        btn-primary btn-block btn-flat']) ?>
                    </div>
                    <!-- /.col -->
                </div>
                <div class="row">
                    &nbsp;
                </div>
                <?= $this->Form->end() ?>
            </div>
            <!-- /.box-body -->

            <div class="row">
                &nbsp;
            </div>
        </div>
        <!-- /.box -->
    </div>
</div>