<?php
namespace SmartAdmin\View\Helper;

use Cake\View\Helper;
use Cake\View\View;

/**
 * Smart helper
 */
class SmartHelper extends Helper
{
    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    public function published($status)
    {
        switch($status) {
            case true:
                $class = 'fa fa-check text-success';
                break;
            case false:
                $class = 'fa fa-ban text-danger';
                break;
        }

        return $this->Html->tag('i', '', ['class' => $class]);
    }
}
