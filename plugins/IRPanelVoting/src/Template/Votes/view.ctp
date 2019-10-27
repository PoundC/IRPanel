<div class="row jlr-dashbox">

    <div class="col-sm-6">

        <div class="box box-solid">
            <div class="box-header with-border">
                <i class="fa fa-quote-right"></i>

                <h3 class="box-title"><?= h($proposal->name) ?></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <blockquote>
                    <p><?= h($proposal->description) ?></p>
                    <small>Created by <cite title="Source Title"><?= h($proposal->i_r_c_user_registration->registered_nickname) ?></cite> on <strong><?= $proposal->created ?></strong></small>
                </blockquote>
            </div>
            <!-- /.box-body -->
        </div>
    </div>

    <div class="col-sm-6">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Vote Results</h3>
            </div>

            <?php $totalVotes = $proposal->yay + $proposal->nay + $proposal->abstain; ?>
            <?php $yayProgress = ($proposal->yay / $totalVotes) * 100; ?>
            <?php $nayProgress = ($proposal->nay / $totalVotes) * 100; ?>
            <?php $abstainProgress = ($proposal->abstain / $totalVotes) * 100; ?>
            <div class="box-body no-padding">
                <table class="table table-striped">
                    <tbody>
                    <tr>
                        <th style="width: 25%"></th>
                        <th style="width: 60%"></th>
                        <th style="width: 15%"></th>
                    </tr>
                    <tr>
                        <td>Yay (<?= $proposal->yay ?>)</td>
                        <td>
                            <div class="progress progress-xs progress-striped active">
                                <div class="progress-bar progress-bar-success" style="width: <?= $yayProgress ?>%"></div>
                            </div>
                        </td>
                        <td><span class="badge bg-green"><?= $yayProgress ?>%</span></td>
                    </tr>
                    <tr>
                        <td>Nay (<?= $proposal->nay ?>)</td>
                        <td>
                            <div class="progress progress-xs progress-striped active">
                                <div class="progress-bar progress-bar-yellow" style="width: <?= $nayProgress ?>%"></div>
                            </div>
                        </td>
                        <td><span class="badge bg-yellow"><?= $nayProgress ?>%</span></td>
                    </tr>
                    <tr>
                        <td>Abstain (<?= $proposal->abstain ?>)</td>
                        <td>
                            <div class="progress progress-xs progress-striped active">
                                <div class="progress-bar progress-bar-primary" style="width: <?= $abstainProgress ?>%"></div>
                            </div>
                        </td>
                        <td><span class="badge bg-light-blue"><?= $abstainProgress ?>%</span></td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <!-- /.box-body -->
            <?php if($userCanVote == true) { ?>
                <div class="box-footer">
                    <center><h4>Vote NOW, with the buttons below.</h4></center>
                    <?= $this->Form->create(null, ['url' => '/voting/vote/' . $proposal->id]) ?>
                    <div class="row">
                        <div class="col-sm-4">
                            <?= $this->Form->button('Yay', ['name' => 'sbmt', 'value' => 'yay', 'class' => 'btn btn-block btn-success']) ?>
                        </div>
                        <div class="col-sm-4">
                            <?= $this->Form->button('Nay', ['name' => 'sbmt', 'value' => 'nay', 'class' => 'btn btn-block btn-warning']) ?>
                        </div>
                        <div class="col-sm-4">
                            <?= $this->Form->button('Abstain', ['name' => 'sbmt', 'value' => 'abstain', 'class' => 'btn btn-block btn-info']) ?>
                        </div>
                    </div>
                    <?= $this->Form->end() ?>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
<div class="row jlr-dashbox">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Votes by Individual</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
                <table class="table table-hover">
                    <tbody>
                    <tr>
                        <th>User</th>
                        <th>Date</th>
                        <th>Vote</th>
                        <th>Reason</th>
                    </tr>
                    <?php foreach($proposal->i_r_c_vote_votes as $voter): ?>
                    <tr>
                        <td><?= $voter->i_r_c_user_registration->registered_nickname ?></td>
                        <td><?= $voter->created ?></td>
                        <?php if($voter->vote == 'yay') { ?>
                        <td><span class="label label-success"><?= $voter->vote ?></span></td>
                        <?php } else if($voter->vote == 'nay') { ?>
                        <td><span class="label label-warning"><?= $voter->vote ?></span></td>
                        <?php } else { ?>
                        <td><span class="label label-info"><?= $voter->vote ?></span></td>
                        <?php } ?>
                        <td><?= $voter->message ?></td>
                    </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
</div>
