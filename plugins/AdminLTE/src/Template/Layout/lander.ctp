<?php

use Cake\Utility\Menu;

$cakeDescription = '';

?>

<!DOCTYPE html>
<html>
    <head>

        <?= $this->element('AdminLTE/adminlte_head', ['skin' => 'blue']); ?>

        <?= $this->element('Lander/lander_head'); ?>

    </head>
    <body class="fixed hold-transition skin-blue sidebar-mini">

        <div class="wrapper">

            <?= $this->element('Main/main_header'); ?>

            <?= $this->element('Main/main_sidebar'); ?>

            <div class="content-wrapper">

                <?= $this->element('Main/main_content_header'); ?>

                <?= $this->Flash->render(); ?>

                <?= $this->fetch('content') ?>

            </div> <!-- /.content-wrapper -->

            <?= $this->element('Main/main_footer'); ?>

            <?= $this->element('Main/main_control_sidebar'); ?>
        </div> <!-- ./wrapper -->

    <?= $this->element('AdminLTE/adminlte_js_footer'); ?>

    <?= $this->element('Lander/lander_js_footer'); ?>

    </body>
</html>
