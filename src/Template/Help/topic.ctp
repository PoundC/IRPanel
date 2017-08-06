<div class="row jlr-dashbox">
    <div class="col-lg-10 col-lg-offset-1">
        <div class="box">
            <div class="box-header">
                <h3><?php echo $topicsResults->topic; ?></h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-12">
                        <table id="example1" class="table table-bordered table-striped dataTable" role="grid"
                               aria-describedby="example1_info">
                            <thead>
                            <tr>
                                <th colspan="4">Subject</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($topicsResults->answers as $answer) : ?>
                            <tr>
                                <td colspan="4">
                                    <?= $this->Html->link($answer->subject, '/help/' . $answer->id) ?>
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