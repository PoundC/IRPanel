<div class="row jlr-dashbox">
    <div class="col-lg-8 col-lg-offset-2">
        <!-- general form elements disabled -->
        <div class="box box-warning">
            <div class="box-header with-border">
                <h3 class="box-title">Contact Us</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <?= $this->Form->create($contactEntity, ['url' => '/contact', 'context' => ['validator' => ['Messages' => 'contact']]]) ?>
                    <div class="form-group">
                        <label>Email Address</label>
                        <?= $this->Form->control('email', ['label' => false, 'type' => 'email', 'placeholder' => 'Enter email address here...', 'class' => 'form-control']); ?>
                    </div>
                    <!-- text input -->
                    <div class="form-group">
                        <label>Subject line, with one sentence describe this contact</label>
                        <?= $this->Form->control('subject', ['label' => false, 'type' => 'text', 'placeholder' => 'Subject goes here...', 'class' => 'form-control']); ?>
                    </div>

                    <!-- textarea -->
                    <div class="form-group">
                        <label>Enter your message here</label>
                        <?= $this->Form->control('message', ['label' => false, 'type' => 'textarea', 'placeholder' => 'Enter message here...', 'class' => 'form-control']); ?>
                    </div>

                    <div class="row">
                        <div class="col-xs-4 col-xs-offset-4">
                            <?= $this->Form->button(__d('CakeDC/Users', 'Submit Contact Us'), ['class' => 'btn btn-primary btn-block btn-flat']) ?>
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