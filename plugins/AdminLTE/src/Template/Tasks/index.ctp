
<div class="row jlr-dashbox">
    <div class="col-sm-10 col-sm-offset-1">
        <?php $counter = 0; ?>
        <?php foreach ($adminLTETasks as $adminLTETask): ?>
            <div class="col-sm-4 alert alert-dismissable" style="margin-bottom: 0px !important;">
                <div class="box box-<?= $adminLTETask['color'] ?>" style="margin-bottom: 0px !important;">
                    <div class="box-header with-border">
                        <h3 class="box-title"><?= $adminLTETask->title ?></h3>
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true" style="right: 0px !important;" onclick="del(<?= $adminLTETask['id'] ?>);">×</button>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form class="form-horizontal">
                        <div class="box-body">
                            <br/>
                            <center><i class="<?= $adminLTETask['icon'] ?>" style="font-size: 60px !important;"></i></center>
                            <br/>
                            <center><p><?= $adminLTETask->message ?></p></center>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <a href="<?= $adminLTETask->link ?>" class="btn btn-<?= $adminLTETask['color'] ?>" style="text-decoration: unset; width: 100%"><?= $adminLTETask['button_text'] ?></a>
                        </div>
                        <!-- /.box-footer -->
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
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

<script>
    function del(id) {
        $.ajax({
            url: "/admin-l-t-e/tasks/delete/" + id,
            type: 'GET',
            success: function (result) {
                console.log('Deleted');
            }
        });
    }
</script>
