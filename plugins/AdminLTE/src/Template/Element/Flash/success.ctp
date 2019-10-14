<?php
if (!isset($params['escape']) || $params['escape'] !== false) {
    $message = h($message);
}
?>
<div class="row">
    <div class="col-lg-10 col-lg-offset-1">
        <div class="alert alert-success alert-dismissible jlr-flash">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fa fa-thumbs-o-up"></i> Success!</h4>
            <span><?= $message ?></span>
        </div>
    </div>
</div>
