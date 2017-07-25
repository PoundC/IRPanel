<?php

use Cake\Core\Configure;

?>

<div class="register-box">

    <?php echo $this->element('Users/users_login'); ?>

  <div class="register-box-body">
    <p class="login-box-msg">Register a new membership</p>

      <?= $this->Form->create($user); ?>
      <div class="form-group has-feedback">
        <?php echo $this->Form->control('fullname', ['label' => false, 'type' => 'text', 'placeholder' => 'Display Name', 'class' => 'form-control']); ?>
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <?php echo $this->Form->control('username', ['label' => false, 'type' => 'text', 'placeholder' => 'Username', 'class' => 'form-control']); ?>
        <span class="glyphicon glyphicon-sunglasses form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
          <?php echo $this->Form->control('email', ['label' => false, 'type' => 'email', 'placeholder' => 'Email', 'class' => 'form-control']); ?>
          <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <?php echo $this->Form->control('password', ['label' => false, 'type' => 'password', 'placeholder' => 'Password', 'class' => 'form-control']); ?>
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
          <?php echo $this->Form->control('password_confirm', ['label' => false, 'type' => 'password', 'placeholder' => 'Retype Password', 'class' => 'form-control']); ?>
        <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
      </div>

      <div class="row">
        <div class="col-xs-8">
            <?php

            if (Configure::read('Users.Tos.required')) {
                echo $this->Form->control('tos', ['type' => 'checkbox', 'label' => __d('CakeDC/Users', 'Accept TOS conditions?'), 'required' => true]);
            }
            if (Configure::read('Users.reCaptcha.registration')) {
            echo $this->User->addReCaptcha();
            } ?>
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
            <?= $this->Form->button(__d('CakeDC/Users', 'Register'), ['class' => 'btn btn-primary btn-block btn-flat']) ?>

        </div>
        <!-- /.col -->
      </div>
      <?= $this->Form->end() ?>

    <!--<div class="social-auth-links text-center">
      <p>- OR -</p>
      <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign up using
        Facebook</a>
      <a href="#" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google-plus"></i> Sign up using
        Google+</a>
    </div>-->
<br />
    <center><a href="/login" class="text-center">I already have a membership</a></center>
  </div>
  <!-- /.form-box -->
</div>