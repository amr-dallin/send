<aside id="left-panel">
    <!-- User info -->
    <div class="login-info">
        <span> <!-- User image size is adjusted inside CSS, it should stay as is -->

            <a href="javascript:void(0);" id="show-shortcut" data-action="toggleShortcut">
                <?php echo $this->Html->image('avatars/sunny.png', ['class' => 'online']); ?>
                <span>
                    admin
                </span>
                <i class="fa fa-angle-down"></i>
            </a>

        </span>
    </div>
    <!-- end user info -->

    <!-- NAVIGATION : This navigation is also responsive

    To make this navigation dynamic please make sure to link the node
    (the reference to the nav > ul) after page load. Or the navigation
    will not initialize.
    -->
    <nav>
        <!--
        NOTE: Notice the gaps after each icon usage <i></i>..
        Please note that these links work a bit different than
        traditional href="" links. See documentation for details.
        -->

        <ul>
            <!-- Dashboard menu -->
            <li class="<?php if (isset($menu['dashboard'])) echo 'active open'; ?>">
                <?php
                echo $this->Html->link(
                    $this->Html->tag('i', '', ['class' => 'fa fa-lg fa-fw fa-home']).
                    ' '.
                    $this->Html->tag('span', __('Dashboard'),
                        ['class' => 'menu-item-parent']
                    ),
                    ['controller' => 'pages', 'action' => 'display'],
                    ['escape' => false]
                );
                ?>
            </li>

            <!-- Customers menu -->
            <li class="<?php if (isset($menu['customers'])) echo 'active open'; ?>">
                <?php
                echo $this->Html->link(
                    $this->Html->tag('i', '', ['class' => 'fa-lg fa-fw fa fa-users']).
                    ' '.
                    $this->Html->tag('span', __('Customers'),
                        ['class' => 'menu-item-parent']
                    ),
                    '#',
                    ['escape' => false]
                );
                ?>
                <ul>
                    <li <?php if (isset($menu['customers'][0])) echo 'class="active"'; ?>>
                        <?php
                        echo $this->Html->link(__('Add'),
                            ['controller' => 'Customers', 'action' => 'add']
                        );
                        ?>
                        </li>
                        <li <?php if (isset($menu['customers'][1])) echo 'class="active"'; ?>>
                        <?php
                        echo $this->Html->link(__('List'),
                            ['controller' => 'Customers', 'action' => 'index']
                        );
                        ?>
                    </li>
                </ul>
            </li>

            <!-- Campaigns menu -->
            <li class="<?php if (isset($menu['campaigns'])) echo 'active open'; ?>">
                <?php
                echo $this->Html->link(
                    $this->Html->tag('i', '', ['class' => 'fa fa-lg fa-fw fa-building-o']).
                    ' '.
                    $this->Html->tag('span', __('Campaigns'),
                        ['class' => 'menu-item-parent']
                    ),
                    '#',
                    ['escape' => false]
                );
                ?>
                <ul>
                    <li <?php if (isset($menu['campaigns'][0])) echo 'class="active"'; ?>>
                        <?php
                        echo $this->Html->link(__('Add'),
                            ['controller' => 'Campaigns', 'action' => 'add']
                        );
                        ?>
                        </li>
                        <li <?php if (isset($menu['campaigns'][1])) echo 'class="active"'; ?>>
                        <?php
                        echo $this->Html->link(__('List'),
                            ['controller' => 'Campaigns', 'action' => 'index']
                        );
                        ?>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>
    <span class="minifyme" data-action="minifyMenu"> <i class="fa fa-arrow-circle-left hit"></i> </span>
</aside>