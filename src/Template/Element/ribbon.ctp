<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */
?>

<div id="ribbon">
    <span class="ribbon-button-alignment"> 
        <span id="refresh" class="btn btn-ribbon" data-action="resetWidgets" data-title="refresh" rel="tooltip" data-placement="bottom" data-original-title="<i class='text-warning fa fa-warning'></i> Warning! This will reset all your widget settings." data-html="true">
            <i class="fa fa-refresh"></i>
        </span> 
    </span>
    <!-- breadcrumb -->
    <ol class="breadcrumb">
        <?php
        if ($this->request->getParam('controller') == 'Pages' && $this->request->getParam('action') == 'display') {
            echo $this->Html->tag('li', __('Dashboard'));
        } else {
            echo $this->Html->tag('li',
                $this->Html->link(__('Dashboard'),
                    ['controller' => 'Pages', 'action' => 'display']
                )
            );
        }

        if (isset($breadcrumbs) && !empty($breadcrumbs)) {
            foreach($breadcrumbs as $breadcrumb) {
                if (empty($breadcrumb['url'])) {
                    echo $this->Html->tag('li', $breadcrumb['title']);
                } else {
                    echo $this->Html->tag('li',
                        $this->Html->link($breadcrumb['title'], $breadcrumb['url'])
                    );
                }
            }
        }
        ?>
    </ol>
    <!-- end breadcrumb -->

    <!-- You can also add more buttons to the
    ribbon for further usability

    Example below:

    <span class="ribbon-button-alignment pull-right" style="margin-right:25px">
            <a href="#" id="search" class="btn btn-ribbon hidden-xs" data-title="search"><i class="fa fa-grid"></i> Change Grid</a>
            <span id="add" class="btn btn-ribbon hidden-xs" data-title="add"><i class="fa fa-plus"></i> Add</span>
            <button id="search" class="btn btn-ribbon" data-title="search"><i class="fa fa-search"></i> <span class="hidden-mobile">Search</span></button>
    </span> -->

</div>