<div class="row jlr-dashbox">
    <div class="col-lg-8 col-lg-offset-2">
        <!-- general form elements disabled -->
        <div class="box box-warning">
            <div class="box-header with-border">
                <h3 class="box-title">Open Support Ticket</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <?= $this->Form->create($supportEntity, array('url' => '/support')) ?>
                    <div class="form-group">
                        <label>Select support topic</label>
                        <?= $this->Form->select('topic', [
                        'multiple' => false,
                        'value' => [2 => 'payment', 3 => 'chat', 4 => 'feature request', 5 => 'feedback', 6 => 'other']
                        ]); ?>
                    </div>
                    <!-- text input -->
                    <div class="form-group">
                        <label>Wtih one sentence describe your challenge</label>
                        <?= $this->Form->control('subject', ['label' => false, 'type' => 'text', 'placeholder' => 'Subject goes here...', 'class' => 'form-control']); ?>
                    </div>

                    <!-- textarea -->
                    <div class="form-group">
                        <label>Describe the challenge you are facing</label>
                        <?= $this->Form->control('message', ['label' => false, 'type' => 'textarea', 'placeholder' => 'Enter message here...', 'class' => 'form-control']); ?>
                    </div>

                    <div class="row">
                        <div class="col-xs-4 col-xs-offset-4">
                            <?= $this->Form->button(__d('CakeDC/Users', 'Submit Support Ticket'), ['class' => 'btn btn-primary btn-block btn-flat']) ?>
                        </div>
                        <!-- /.col -->
                    </div>
                <?= $this->Form->end() ?>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
</div>

<?= $this->element('email_us') ?>