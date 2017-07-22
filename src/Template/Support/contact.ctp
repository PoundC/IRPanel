<div class="row">
    <div class="col-lg-8 col-lg-offset-2">
        <!-- general form elements disabled -->
        <div class="box box-warning">
            <div class="box-header with-border">
                <h3 class="box-title">Contact Us</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <form role="form">
                    <div class="form-group">
                        <label>Email Address</label>
                        <input type="text" class="form-control" placeholder="Email Address Here...">
                    </div>
                    <!-- text input -->
                    <div class="form-group">
                        <label>Subject line, with one sentence describe this contact</label>
                        <input type="text" class="form-control" placeholder="Subject goes here...">
                    </div>

                    <!-- textarea -->
                    <div class="form-group">
                        <label>Enter your message here</label>
                        <textarea class="form-control" rows="3" placeholder="Message goes here..."></textarea>
                    </div>

                    <div class="row">
                        <div class="col-xs-4 col-xs-offset-4">
                            <?= $this->Form->button(__d('CakeDC/Users', 'Submit Contact Us'), ['class' => 'btn btn-primary btn-block btn-flat']) ?>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
</div>

<?= $this->element('email_us') ?>