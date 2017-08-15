<div class="row jlr-dashbox">
    <div class="col-lg-10 col-lg-offset-1">

        <?= $this->Form->create($answerEntity, ['id' => 'answerForm', 'url' => '/convertfaq/' . $id]) ?>
        <div class="row">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="box">
                    <div class="box-header">
                        <center><h3>Enter The Answer</h3></center>
                    </div>
                    <div class="box-body">
                        <?= $this->Form->control('subject', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Enter Answer Subject Line']) ?><br/>
                        <div class="nav-tabs-custom">
                            <ul class="nav nav-tabs" id="jlr-tabs">
                                <li id="markdowntab" class="active"><a href="#markdown" data-toggle="tab" aria-expanded="false">Markdown</a></li>
                                <li id="markdownpreviewtab" class=""><a href="#markdownpreview" data-toggle="tab" aria-expanded="false">Preview</a></li>
                            </ul>
                            <div class="tab-content" id="jlr-tabs-content">
                                <div class="tab-pane active" id="markdown">

                                    <?= $this->Form->control('answer', ['label' => false, 'type' => 'textarea', 'placeholder' => 'Enter answer with markdown here...', 'class' => 'form-control']); ?>

                                </div>
                                <div class="tab-pane" id="markdownpreview">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-5 col-lg-offset-1">
                <div class="box">
                    <div class="box-header">
                        <center><h3>Topic</h3></center>
                    </div>
                    <div class="box-body" id="topics">
                        <?php if(isset($answerEntity->faq_topic_id)) { ?>
                        <center><?= $this->Form->control('faq_topics.topic', ['class' => 'form-control select2', 'options' => $topics, 'value' => $answerEntity->faq_topic_id, 'label' => false]) ?></center>
                        <?php } else { ?>
                        <center><?= $this->Form->control('faq_topics.topic', ['class' => 'form-control select2', 'options' => $topics, 'label' => false]) ?></center>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="box">
                    <div class="box-header">
                        <center><h3>Tags</h3></center>
                    </div>
                    <div class="box-body" id="tags">
                        <?php if(isset($answerTags)) { ?>
                        <center><?= $this->Form->control('faq_tags.tag', ['style' => 'width: 100%', 'class'=> 'select2', 'multiple' => true, 'options' => $tags, 'value' => $answerTags, 'label' => false]) ?></center>
                        <?php } else { ?>
                        <center><?= $this->Form->control('faq_tags.tag', ['style' => 'width: 100%', 'class'=> 'select2', 'multiple' => true, 'options' => $tags, 'label' => false]) ?></center>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="box">
                    <div class="box-header">
                        <center><h3>Add Questions</h3></center><button type="button" style="float:right;" id="addquestion">Add Another Question</button>
                    </div>
                    <div class="box-body" id="questions">
                        <?php if(isset($answerQuestions)) { ?>
                        <?php foreach($answerQuestions as $question) { ?>
                        <?= $this->Form->control('questions[]', ['label' => false, 'class' => 'form-control', 'value' => $question]) ?><br/>
                        <?php } // End foreach ?>
                        <?php } else { ?>
                        <?= $this->Form->control('questions[]', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Enter related question here...']) ?><br/>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-lg-offset-3">
                <?= $this->Form->button('Save FAQ Page', ['class' => 'btn btn-primary btn-block btn-flat']) ?>
            </div>
        </div>
        <?= $this->Form->end() ?>

        <div style="display:none" id="hiddenpreview">
            <?= $this->element('Help/markdown', ['markdownthis' => '']); ?>
        </div>
    </div>

</div>

<script type="text/javascript">
    $(document).ready( function () {

        $('#faq-tags-tag').select2({
            tags: true
        });

        $('#addquestion').on('click', function () {

            $('#questions').append('<input type="text" name="questions[]" class="form-control" value=""><br />');

            event.preventDefault();

            return false;
        });

        $('#markdownpreviewtab').on('click', function() {

            $('#message-preview').val($('#answer').val());

            $.ajax
            ({
                url: '/markdown',
                data: $('#prevmdform').serialize(),
                type: 'post',
                success: function(result)
                {
                    $('#hiddenpreview').html(result);
                    var frm = $('#previewForm2').html();
                    $('#previewForm2').remove();
                    $('#markdownpreview').html(frm);
                }
            });
        });

    });
</script>