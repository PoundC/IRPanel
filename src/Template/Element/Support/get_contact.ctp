<div class="row">
    <div class="col-lg-8 col-lg-offset-2 text-center">
        <h2>Contact Us</h2>
    </div>
</div>
<div class="row">
    <div class="col-lg-8 col-lg-offset-2 jlr-dashbox">
        <!-- general form elements disabled -->
        <div class="box box-warning" style="border-top-color:white !important;">
            <!-- /.box-header -->
            <div class="box-body">
                <div class="row">&nbsp;</div>
                <?= $this->Form->create($contactEntity, ['url' => '/contact', 'context' => ['validator' => ['Messages'
                => 'contact']]]) ?>
                <div class="form-group">
                    <label>Email Address</label>
                    <?= $this->Form->control('email', ['label' => false, 'type' => 'email', 'placeholder' => 'Enter email address here...', 'class' => 'form-control']); ?>
                </div>

                <div class="row">&nbsp;</div>

                <div class="form-group">
                    <label>Subject line, with one sentence describe this contact</label>
                    <?= $this->Form->control('subject', ['label' => false, 'type' => 'text', 'placeholder' => 'Subject goes here...', 'class' => 'form-control']); ?>
                </div>

                <div class="row">&nbsp;</div>

                <div class="form-group">
                    <label>Enter your message here</label>
                    <?= $this->Form->control('message', ['label' => false, 'type' => 'textarea', 'placeholder' => 'Enter message here...', 'class' => 'form-control']); ?>
                </div>
                <div class="row">&nbsp;</div>
                <div class="row">
                    <div class="col-xs-4 col-xs-offset-4">
                        <?= $this->Form->button(__d('CakeDC/Users', 'Submit Contact Us'), ['class' => 'btn btn-primary
                        btn-block btn-flat']) ?>
                    </div>
                    <!-- /.col -->
                </div>
                <div class="row">&nbsp;</div>
                <?= $this->Form->end() ?>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
</div>