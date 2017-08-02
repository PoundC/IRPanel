<div class="col-lg-10 col-lg-offset-1">
    <div class="box">
        <div class="box-body">
            <div class="row">
                <div class="col-sm-12">
                    <table id="example1" class="table table-bordered table-striped dataTable" role="grid"
                           aria-describedby="example1_info">
                        <thead>
                        <tr>
                            <th colspan="1"><?= $this->Paginator->sort('faq_topics.topic', 'Topic') ?></th>
                            <th colspan="3"><?= $this->Paginator->sort('faq_questions.question', 'Question') ?></th>
                            <th colspan="4"><?= $this->Paginator->sort('faq_answers.subject', 'Description') ?></th>
                            <th class="actions"><?= 'Actions' ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach (${$tableAlias} as $message) : ?>
                        <tr>
                            <td colspan="1">
                                <?= $message->answer->topic->topic ?>
                            </td>
                            <td colspan="3">
                                <?= $message->question ?>
                            </td>
                            <td colspan="4"><?= h($message->answer->subject) ?></td>
                            <td class="actions">
                                <?= $this->Html->link('[ View Answer ]', '/help/' . $message->answer->id) ?>
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
</div>