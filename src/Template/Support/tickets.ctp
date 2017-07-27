<div class="row jlr-dashbox">
    <div class="col-md-10 col-md-offset-1">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Your Support Tickets</h3>
                <?php if ($isAdmin == false) { ?>
                <div class="col-md-4 pull-right">
                    <button type="button" class="btn btn-default" style="width:100%" onclick="location.href='/support'">
                        <i class="fa fa-magic"></i> Create New Ticket
                    </button>
                </div>
                <?php } ?>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                    <?php /* Admin Row
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="dataTables_length" id="example1_length"><label>Show <select
                                        name="example1_length" aria-controls="example1" class="form-control input-sm">
                                    <option value="10">10</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                    </select> entries</label>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div id="example1_filter" class="dataTables_filter" style="float:right;">
                                    <div class="col-sm-3">
                                        <label>Search:</label>
                                    </div>
                                    <div class="col-sm-3">
                                        <input type="search" class="form-control input-sm" placeholder="" aria-controls="example1">
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php */ ?>
                    <div class="row">
                        <div class="col-sm-12">
                            <table id="example1" class="table table-bordered table-striped dataTable" role="grid"
                                   aria-describedby="example1_info">
                                <thead>
                                <tr>
                                    <th colspan="1"><?= $this->Paginator->sort('topic', 'Category') ?></th>
                                    <th colspan="4"><?= $this->Paginator->sort('subject', 'Subject') ?></th>
                                    <th colspan="2"><?= $this->Paginator->sort('modified', 'Last') ?></th>
                                    <th class="actions"><?= 'Actions' ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach (${$tableAlias} as $message) : ?>
                                <tr>
                                    <td colspan="1">
                                    <?php switch($message->topic) {
                                            case 0:
                                                echo h('Contact');
                                                break;
                                            case 2:
                                                echo h('Payment');
                                                break;
                                            case 3:
                                                echo h('Chat');
                                                break;
                                            case 4:
                                                echo h('Request');
                                                break;
                                            case 5:
                                                echo h('Feedback');
                                                break;
                                            case 6:
                                                echo h('Other');
                                                break;
                                            }
                                    ?>
                                    </td>
                                    <td colspan="4"><?= h($message->subject) ?></td>
                                    <td colspan="2" style="white-space: nowrap;"><?= h($message->modified) ?></td>
                                    <td class="actions">
                                        <?= $this->Html->link('[ View ]', ['action' => 'view', $message->id]) ?>
                                    </td>
                                </tr>

                                <?php endforeach; ?>
                                </tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="box-footer">
                                <ul class="pagination pagination-sm no-margin pull-right">
                                    <li><a href="#">&laquo;</a></li>
                                    <?= $this->Paginator->prev('< ' . 'previous') ?>
                                    <?= $this->Paginator->numbers() ?>
                                    <?= $this->Paginator->next('next' . ' >') ?>
                                </ul>
                                <p><?= $this->Paginator->counter() ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
    <!-- /.col -->
</div>

