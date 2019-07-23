<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Category Entity
 *
 * @property int $id
 * @property int $section_id
 * @property string $slug
 * @property string $title
 *
 * @property \App\Model\Entity\Section $section
 * @property \App\Model\Entity\Item[] $items
 */
class Category extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'section_id' => true,
        'slug' => true,
        'title' => true,
        'date_analysed' => true,
        'section' => true,
        'items' => true
    ];
}
