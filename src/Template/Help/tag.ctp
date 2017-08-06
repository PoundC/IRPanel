<div class="row jlr-dashbox">
    <div class="col-lg-10 col-lg-offset-1">
        <div class="box">
            <div class="box-header">
                <h3><?php echo $tagsResults->tag; ?></h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-12">
                        <table id="example1" class="table table-bordered table-striped dataTable" role="grid"
                               aria-describedby="example1_info">
                            <thead>
                            <tr>
                                <th colspan="1">Topic</th>
                                <th colspan="4">Subject</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($tagsResults->tags as $tag) : ?>
                            <tr>
                                <td colspan="1">
                                    <?= $this->Html->link($tag->answer->topic->topic, '/help/topic/' . $tag->answer->topic->id) ?>
                                </td>
                                <td colspan="4">
                                    <?= $this->Html->link($tag->answer->subject, '/help/' . $tag->answer->id) ?>
                                </td>
                            </tr>

                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>