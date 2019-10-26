
<!-- Main Header -->
<header class="main-header">

    <!-- Logo -->
    <a href="/" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b>Pnd</b>C</span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg">Pound<b>C</b></span>
    </a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">

        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <?php
                    if($notLoggedIn == false) {
            ?>
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">

            <ul class="nav navbar-nav">
                <?php
                            if($isSuperUser == true) {
                    ?>

                <li>
                    <div class="collapse navbar-collapse pull-right" id="navbar-collapse">
                        <ul class="nav navbar-nav">
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Billing <span class="caret"></span></a>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="/billing/dashboard">Dashboard</a></li>
                                    <li class="divider"></li>
                                    <li><a href="/billing/subscriptions">Subscriptions</a></li>
                                </ul>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">System <span class="caret"></span></a>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="/crontabs">Crontabs</a></li>
                                    <!--<li><a href="#">Another action</a></li>
                                    <li><a href="#">Something else here</a></li>
                                    <li class="divider"></li>
                                    <li><a href="#">Separated link</a></li>
                                    <li class="divider"></li>
                                    <li><a href="#">One more separated link</a></li>-->
                                </ul>
                            </li>
                        </ul>
                    </div>
                </li>
                <?php } ?>
                <?php
                            if ($isAdmin == true) {
                    ?>
                <li>
                    <form class="navbar-form navbar-left" role="search">
                        <div class="form-group">
                            <input type="text" class="form-control" id="navbar-search-input" placeholder="Search">
                        </div>
                    </form>
                </li>
                <?php
                             }
                    ?>
                <li class="dropdown notifications-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-bell-o"></i>
                        <?php if($totalNotificationsCount > 0 ) { ?>
                            <span class="label label-warning"><?= $totalNotificationsCount ?></span>
                        <?php } ?>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header">You have <?= $totalNotificationsCount ?> notifications</li>
                        <?php if($totalNotificationsCount > 0) { ?>
                            <li>
                                <!-- inner menu: contains the actual data -->
                                <ul class="menu">
                                    <?php foreach($navNotificationsArray as $notification) { ?>
                                        <?php switch($notification['type']) {
                                            case 'users':
                                                $icon = 'users';
                                                $color = 'text-aqua';
                                                break;
                                            case 'alert':
                                                $icon = 'warning';
                                                $color = 'text-yellow';
                                                break;
                                            case 'sale':
                                                $icon = 'shopping-cart';
                                                $color = 'text-green';
                                                break;
                                            case 'message':
                                                $icon = 'envelope';
                                                $color = 'text-green';
                                                break;
                                                ?>
                                            <?php } ?>
                                        <li>
                                            <a href="<?= $notification['link'] ?>">
                                                <i class="<?= $notification['type'] ?> <?= $notification['color'] ?>"></i>&nbsp;&nbsp;<?= $notification['message'] ?>
                                            </a>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </li><li class="footer"><a href="/notifications">View all</a></li>
                        <?php } ?>
                    </ul>
                </li>
                <li class="dropdown messages-menu">
                    <a href="/messages" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-envelope-o"></i>
                        <?php if($totalMessageCount > 0) { ?>
                            <span class="label label-success"><?= $totalMessageCount ?></span>
                        <?php } ?>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header">You have <?= $totalMessageCount ?> messages</li>
                        <?php if(count($navMessagesArray) > 0) { ?>
                            <li>
                                <!-- inner menu: contains the actual data -->
                                <ul class="menu">
                                    <?php foreach($navMessagesArray as $navMessage) { ?>
                                        <li><!-- start message -->
                                            <a href="/messages/<?= $navMessage['id'] ?>">
                                                <div class="pull-left">
                                                    <?php if($navMessage['avatar'] != '') { ?>
                                                        <?php echo $this->Html->image($navMessage['avatar'] . '.thumb.jpg', array('class' => 'img-circle', 'alt' => 'User Image')); ?>
                                                    <?php } else { ?>
                                                        <img src="/cake_d_c/users/img/avatar_placeholder.png" class="user-image" alt="User Image" />
                                                    <?php } ?>
                                                </div>
                                                <h4>
                                                    <?= h($navMessage['username']) ?>
                                                    <small><i class="fa fa-clock-o"></i> <?= $navMessage['lapsed'] ?></small>
                                                </h4>
                                                <p><?= h($navMessage['subject']) ?></p>
                                            </a>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </li>
                            <li class="footer"><a href="/messages">See All Messages</a></li>
                        <?php } ?>
                    </ul>
                </li>
                <!-- Tasks Menu -->
                <li class="dropdown tasks-menu">
                    <!-- Menu Toggle Button -->
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-flag-checkered"></i>
                        <?php if($navPendingTasksUncompletedCount > 0) { ?>
                            <span class="label label-danger"><?= $navPendingTasksUncompletedCount ?></span>
                        <?php } ?>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header">You have <?= $navPendingTasksUncompletedCount ?> tasks</li>
                        <?php if($navPendingTasksUncompletedCount > 0) { ?>
                        <li>
                            <!-- Inner menu: contains the tasks -->
                            <ul class="menu">
                                <?php foreach($navPendingTasks as $pendingTask): ?>
                                <li><!-- Task item -->
                                    <a href="<?= $pendingTask->link ?>">
                                        <!-- Task title and progress text -->
                                        <h3>
                                            <?= $pendingTask->title ?>
                                            <small class="pull-right"><i class="<?= $pendingTask->icon ?> <?= $pendingTask->color ?>"></i></small>
                                        </h3>
                                        <!-- The progress bar -->

                                            <p style="white-space: pre-wrap !important;"><?= $pendingTask->message ?></p>

                                    </a>
                                </li>
                                <?php endforeach; ?>
                                <!-- end task item -->
                            </ul>
                        </li>
                        <li class="footer">
                            <a href="/tasks">View all tasks</a>
                        </li>
                        <?php } ?>
                    </ul>
                </li>
                <?php
                            if (false == true) {
                    ?>
                <!-- Messages: style can be found in dropdown.less-->
                <li class="dropdown messages-menu">
                    <!-- Menu toggle button -->
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-envelope-o"></i>
                        <span class="label label-success">4</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header">You have 4 messages</li>
                        <li>
                            <!-- inner menu: contains the messages -->
                            <ul class="menu">
                                <li><!-- start message -->
                                    <a href="#">
                                        <div class="pull-left">
                                            <!-- User Image -->
                                            <img src="dist/img/user2-160x160.jpg" class="img-circle"
                                                 alt="User Image">
                                        </div>
                                        <!-- Message title and timestamp -->
                                        <h4>
                                            Support Team
                                            <small><i class="fa fa-clock-o"></i> 5 mins</small>
                                        </h4>
                                        <!-- The message -->
                                        <p>Why not buy a new awesome theme?</p>
                                    </a>
                                </li>
                                <!-- end message -->
                            </ul>
                            <!-- /.menu -->
                        </li>
                        <li class="footer"><a href="#">See All Messages</a></li>
                    </ul>
                </li>
                <!-- /.messages-menu -->

                <!-- Notifications Menu -->
                <li class="dropdown notifications-menu">
                    <!-- Menu toggle button -->
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-bell-o"></i>
                        <span class="label label-warning">10</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header">You have 10 notifications</li>
                        <li>
                            <!-- Inner Menu: contains the notifications -->
                            <ul class="menu">
                                <li><!-- start notification -->
                                    <a href="#">
                                        <i class="fa fa-users text-aqua"></i> 5 new members joined today
                                    </a>
                                </li>
                                <!-- end notification -->
                            </ul>
                        </li>
                        <li class="footer"><a href="#">View all</a></li>
                    </ul>
                </li>

                <!-- Tasks Menu -->
                <li class="dropdown tasks-menu">
                    <!-- Menu Toggle Button -->
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-flag-o"></i>
                        <span class="label label-danger">9</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header">You have 9 tasks</li>
                        <li>
                            <!-- Inner menu: contains the tasks -->
                            <ul class="menu">
                                <li><!-- Task item -->
                                    <a href="#">
                                        <!-- Task title and progress text -->
                                        <h3>
                                            Design some buttons
                                            <small class="pull-right">20%</small>
                                        </h3>
                                        <!-- The progress bar -->
                                        <div class="progress xs">
                                            <!-- Change the css width attribute to simulate progress -->
                                            <div class="progress-bar progress-bar-aqua" style="width: 20%"
                                                 role="progressbar"
                                                 aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                                <span class="sr-only">20% Complete</span>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <!-- end task item -->
                            </ul>
                        </li>
                        <li class="footer">
                            <a href="#">View all tasks</a>
                        </li>
                    </ul>
                </li>

                <?php
                             }
                    ?>

                <!-- User Account Menu -->
                <li class="dropdown user user-menu">

                    <!-- Menu Toggle Button -->
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">

                        <?php
                                    echo $this->Html->image(
                        empty($currentUser->avatar) ? $avatarPlaceholder : $currentUser->avatar,
                        ['class' => 'user-image']
                        );
                        ?>

                        <!-- hidden-xs hides the username on small devices so only the image appears. -->
                        <?php
                                echo $this->Html->tag(
                        'span',
                        __d('CakeDC/Users', '{0} {1}', $currentUser->first_name, $currentUser->last_name),
                        ['class' => 'hidden-xs']
                        );
                        ?>
                    </a>

                    <ul class="dropdown-menu">

                        <!-- The user image in the menu -->
                        <li class="user-header">
                            <?php
                                        echo $this->Html->image(
                            empty($currentUser->avatar) ? $avatarPlaceholder : $currentUser->avatar,
                            ['class' => 'img-circle']
                            );
                            ?>
                            <p>
                                <?php
                        echo $this->Html->tag(
                                'span',
                                __d('CakeDC/Users', '{0} {1}', $currentUser->first_name, $currentUser->last_name),
                                ['class' => 'full_name']
                                );
                                ?>

                                <small>Member since</small>
                                <small>
                                    <?php
                                                if(isset($currentUser)) {
                                                    echo $currentUser->created;
                                    }
                                    ?>
                                </small>
                            </p>
                        </li>
                        <?php /* ?>
                        <!-- Menu Body -->
                        <li class="user-body">
                            <div class="row">
                                <div class="col-xs-4 text-center">
                                    <a href="#">Followers</a>
                                </div>
                                <div class="col-xs-4 text-center">
                                    <a href="#">Sales</a>
                                </div>
                                <div class="col-xs-4 text-center">
                                    <a href="#">Friends</a>
                                </div>
                            </div>
                            <!-- /.row -->
                        </li>
                        <?php */ ?>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="/profile" class="btn btn-default btn-flat">Profile</a>
                            </div>
                            <div class="pull-right">
                                <a href="/logout" class="btn btn-default btn-flat">Sign out</a>
                            </div>
                        </li>
                    </ul>
                </li>

                <!-- Control Sidebar Toggle Button -->
                <?php
                            if($isSuperUser == true) {
                    ?>
                <li>
                    <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                </li>
                <?php
                            }
                    ?>
            </ul>

        </div>

        <?php
                       }
            ?>

    </nav>

</header>
