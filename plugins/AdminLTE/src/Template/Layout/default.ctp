<?php

use Cake\Utility\Menu;

$cakeDescription = '';

if($isMember == true && $isAdmin == false && $isSuperUser == false) {

    $skin = 'green';
}
else if($isAdmin == true && $isSuperUser == false) {

    $skin = 'purple';
}
else if($isAdmin == true && $isSuperUser == true) {

    $skin = 'red';
}
else {

    $skin = 'blue';
}

?>

<!DOCTYPE html>
<html>

    <head>

        <?= $this->element('AdminLTE.AdminLTE/adminlte_head', ['skin' => $skin]); ?>

    </head>

    <body class="fixed hold-transition skin-<?= $skin ?> sidebar-mini">

        <div class="wrapper">

            <?= $this->element('AdminLTE.Main/main_header'); ?>

            <?= $this->element('AdminLTE.Main/main_sidebar'); ?>

            <?= $this->element('AdminLTE.Main/main_content_header'); ?>

            <div class="content-wrapper">

                <?= $this->Flash->render(); ?>

                <?= $this->fetch('content') ?>

            </div> <!-- /.content-wrapper -->

            <?= $this->element('AdminLTE.Main/main_footer'); ?>

            <?= $this->element('AdminLTE.Main/main_control_sidebar'); ?>

        </div> <!-- ./wrapper -->

    <?= $this->element('AdminLTE.AdminLTE/adminlte_js_footer'); ?>

    </body>

</html>
