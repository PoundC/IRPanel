<div class="row">
    <div class="col-lg-8 col-lg-offset-2">
        <!-- general form elements disabled -->
        <div class="box box-warning">
            <div class="box-header with-border">
                <h3 class="box-title">Open Support Ticket</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <form role="form">
                    <div class="form-group">
                        <label>Select support topic</label>
                        <select class="form-control">
                            <option>Login</option>
                            <option>Chat</option>
                            <option>Payment</option>
                            <option>Feature Request</option>
                            <option>Other</option>
                        </select>
                    </div>
                    <!-- text input -->
                    <div class="form-group">
                        <label>Wtih one sentence describe your challenge</label>
                        <input type="text" class="form-control" placeholder="Enter ...">
                    </div>

                    <!-- textarea -->
                    <div class="form-group">
                        <label>Describe the challenge you are facing</label>
                        <textarea class="form-control" rows="3" placeholder="Enter ..."></textarea>
                    </div>

                    <div class="row">
                        <div class="col-xs-4 col-xs-offset-4">
                            <?= $this->Form->button(__d('CakeDC/Users', 'Submit Support Ticket'), ['class' => 'btn btn-primary btn-block btn-flat']) ?>
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