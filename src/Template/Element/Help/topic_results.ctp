<?php $x = 0; ?>

<?php foreach($topicsResults as $topicResult) { ?>

    <?php if($x == 0) { ?>
    <div class="row">
    <div class="col-lg-5 col-lg-offset-1">
    <?php } else { ?>
    <div class="col-lg-5 col-lg-offset-0">
    <?php } ?>

        <div class="box jlr-help-box">
            <div class="box-header">
                <h3><?= $this->Html->link($topicResult->topic, '/help/topic/' . $topicResult->id) ?></h3>
            </div>
            <div class="box-body">

                <?php foreach($topicResult->answers as $topicResultAnswer) { ?>

                <a href="/help/<?= $topicResultAnswer->id ?>"><?= $topicResultAnswer->subject ?></a><br/><br/>

                <?php } ?>

            </div>

        </div>

        <?php if($x == 1) { ?>
        </div>
        <?php } ?>

        <?php $x = $x + 1; ?>
        <?php if($x == 2) { ?>
        <?php $x = 0 ?>
        <?php } ?>
    </div>

<?php } ?>

    <?php if($x == 1) { ?>
</div>
<?php } ?>