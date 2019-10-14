<div class="row jlr-dashbox" style="margin:15px;">
    <div class="col-lg-9">
        <div class="row">
            <div class="box">
                <div class="box-header">
                    <center><h2><?= $answerResult->subject ?></h2></center>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="box">
                <div class="box-body">
                    <h3><?= $this->Markdown->transform($answerResult->answer) ?></h3>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="box">
            <div class="box-body">

                <center><h3><a href="/help/topic/<?= $answerResult->topic->slug ?>"><?= $answerResult->topic->topic ?></a></h3></center>

                <?php foreach($answerResult->answer_tags as $tag) { ?>

                <center><h4><a href="/help/tag/<?= $tag->tags->slug ?>"><?= $tag->tags->tag ?></a></h4></center>

                <?php } ?>

            </div>
        </div>
        <?php if($isAdmin == true) { ?>
        <div class="row">
            <div class="col-md-12">
                <!-- About Me Box -->
                <div class="box box-primary" style="border-top-color: white !important;">
                    <div class="box-body">
                        <a type="button" class="btn btn-default" style="width:100%" href="/convertfaq/<?= $answerResult->id ?>">
                            <i class="fa fa-space-shuttle"></i>
                            <span>Edit FAQ Page</span>
                        </a>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
        </div>
        <?php } ?>
    </div>
</div>
