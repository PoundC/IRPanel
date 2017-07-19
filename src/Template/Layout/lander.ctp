<?php

use Cake\Utility\Menu;

$cakeDescription = '';

?>

<!DOCTYPE html>
<html>
    <head>

        <?= $this->element('adminlte_head', ['skin' => 'blue']); ?>

        <?= $this->element('lander_head'); ?>

    </head>
    <body class="fixed hold-transition skin-blue sidebar-mini">

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
