<div class="row jlr-dashbox">

    <div class="col-lg-10 col-lg-offset-1">

        <div class="box">
            <div class="box-header">
                <center><h3>Search Users</h3></center>
            </div>

            <div class="box-body">

                <?= $this->Form->create(null, ['url' => ['controller' => 'Search', 'action' => 'users']]); ?>

                <div class="row">

                    <div class="col-lg-2 col-lg-offset-2">

                        <div class="form-group" style="margin-top:6px;">
                            <label>Select field</label>
                            <?= $this->Form->select('field', ['value' =>
                            [
                                'email'      => 'Email',
                                'username'   => 'Username',
                                'first_name' => 'First Name',
                                'last_name'  => 'Last Name',
                                'role'       => 'Role'

                            ]]); ?>
                        </div>

                    </div>

                    <div class="col-lg-5 col-lg-offset-0">

                        <div class="form-group">
                            <label>Your search query</label>
                            <?= $this->Form->control('search', ['label' => false, 'type' => 'text', 'placeholder' =>
                            'ex: email@host.com', 'class' => 'form-control']); ?>
                        </div>

                    </div>

                    <div class="col-lg-2 col-lg-offset-0">

                        <div class="form-group">
                            <?= $this->Form->button('Search', ['class' => 'btn
                            btn-primary btn-block btn-flat', 'style' => 'margin-top: 20px;']) ?>
                        </div>

                    </div>

                </div>

                <?= $this->Form->end() ?>

            </div>

        </div>

    </div>

</div>

<?php if(isset($usersResults) && $usersResults > 0) { ?>

<div class="row">

    <?= $this->element('Users/users_index') ?>

</div>

<?php } ?>