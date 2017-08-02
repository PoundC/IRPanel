<div class="row jlr-dashbox">
    <div class="col-lg-6 col-lg-offset-1">
        <div class="row">
            <div class="box">
                <div class="box-body">
                    <h3><?= $this->Markdown->transform($answerResult->answer) ?></h3>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="box">
            <div class="box-header">
                <center><h2><?= $answerResult->subject ?></h2></center>
            </div>
            <div class="box-body">

                <center><h3><a href="/help/topic/<?= $answerResult->topic->id ?>"><?= $answerResult->topic->topic ?></a></h3></center>

                <?php foreach($answerResult->answer_tags as $tag) { ?>

                <center><h4><a href="/help/tag/<?= $tag->tags->id ?>"><?= $tag->tags->tag ?></a></h4></center>

                <?php } ?>

            </div>
        </div>
    </div>
</div>
