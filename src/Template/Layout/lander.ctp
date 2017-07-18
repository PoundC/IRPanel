<?php

use Cake\Utility\Menu;

$cakeDescription = '';

if($isAdmin == true && $isSuperUser == false) {

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

        <?= $this->element('adminlte_head'); ?>

        <?= $this->element('lander_head'); ?>

    </head>
    <body class="fixed hold-transition skin-<?= $skin ?> sidebar-mini">

        <div class="wrapper">

            <?= $this->element('main_header'); ?>

            <?= $this->element('main_sidebar'); ?>

            <div class="content-wrapper">

                <?= $this->element('content_header'); ?>

                <?= $this->Flash->render(); ?>

                <?= $this->fetch('content') ?>

            </div> <!-- /.content-wrapper -->

            <?= $this->element('main_footer'); ?>

            <?= $this->element('control_sidebar'); ?>
        </div> <!-- ./wrapper -->

    <?= $this->element('adminlte_js_footer'); ?>

    <?= $this->element('lander_js_footer'); ?>

    </body>
</html>
