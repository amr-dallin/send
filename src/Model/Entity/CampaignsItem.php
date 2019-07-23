<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * CampaignsItem Entity
 *
 * @property int $id
 * @property int $campaign_id
 * @property int $item_id
 * @property \Cake\I18n\FrozenTime $date_created
 * @property \Cake\I18n\FrozenTime|null $date_sended
 *
 * @property \App\Model\Entity\Campaign $campaign
 * @property \App\Model\Entity\Item $item
 */
class CampaignsItem extends Entity
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
        'campaign_id' => true,
        'item_id' => true,
        'date_created' => true,
        'date_sended' => true,
        'campaign' => true,
        'item' => true
    ];
}
