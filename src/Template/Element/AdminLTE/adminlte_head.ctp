<?= $this->Html->charset() ?>
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<title>
    <?= $this->fetch('title') ?>
</title>
<?= $this->Html->meta('icon') ?>

<?= $this->Html->css('/bootstrap/css/bootstrap') ?>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
<!-- Ionicons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">

<?= $this->Html->css('/dist/css/AdminLTE') ?>
<?= $this->Html->css('/css/cakeadminlte') ?>
<?= $this->Html->css('/css/AdminLTE_important') ?>
<?= $this->Html->css('/dist/css/skins/_all-skins.css') ?>
<?= $this->Html->css('/css/skins/' . $skin) ?>

<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->

<!-- Google Font -->
<link rel="stylesheet"
      href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

<?= $this->fetch('meta') ?>