<?php
namespace App\View\Helper;

use Cake\View\Helper;
use Cake\View\View;

/**
 * Send helper
 */
class SendHelper extends Helper
{
    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    public function countSubscribers($items, $type = null)
    {
        if (null == $type) {
            return count($items);
        }

        $count = 0;
        foreach($items as $item) {
            switch($type) {
                case 'new':
                    if (null == $item->date_sended) {
                        $count++;
                    }
                    break;
                case 'sended':
                    if (null !== $item->date_sended) {
                        $count++;
                    }
                    break;
            }
        }

        return $count;
    }

    public function subscribers($items)
    {
        $subscribers = ['new', 'sended'];
        foreach($items as $item) {
            if (null !== $item->date_sended) {
                $subscribers['sended'][] = $item;
            } else {
                $subscribers['new'][] = $item;
            }
        }

        return $subscribers;
    }

    public function itemIds($items)
    {
        $data = [];
        foreach($items as $item) {
            $data[] = $item->id;
        }

        return json_encode($data);
    }

    public function countItemsInSections($sections)
    {
        $items = [];
        foreach($sections as $section) {
            foreach($section->categories as $category) {
                foreach($category->items as $item) {
                    $items[] = $item->id;
                }
            }
        }

        return count(array_unique($items));
    }
}
