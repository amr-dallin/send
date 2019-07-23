<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Item Entity
 *
 * @property int $id
 * @property int $country_id
 * @property int|null $region_id
 * @property int|null $city_id
 * @property string $slug
 * @property string $legal_name
 * @property string|null $brand_name
 * @property string|null $email
 * @property string|null $website
 * @property string|null $fax
 * @property string|null $landmarks
 * @property string|null $postal_code
 * @property string|null $address
 * @property string|null $latitude
 * @property string|null $longitude
 * @property \Cake\I18n\FrozenTime $date_created
 * @property \Cake\I18n\FrozenTime $date_analysed
 *
 * @property \App\Model\Entity\Country $country
 * @property \App\Model\Entity\Region $region
 * @property \App\Model\Entity\City $city
 * @property \App\Model\Entity\ItemTelephone[] $item_telephones
 * @property \App\Model\Entity\Category[] $categories
 */
class Item extends Entity
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
        'country_id' => true,
        'region_id' => true,
        'city_id' => true,
        'slug' => true,
        'legal_name' => true,
        'brand_name' => true,
        'email' => true,
        'website' => true,
        'fax' => true,
        'landmarks' => true,
        'postal_code' => true,
        'address' => true,
        'latitude' => true,
        'longitude' => true,
        'date_created' => true,
        'date_analysed' => true,
        'live' => true,
        'country' => true,
        'region' => true,
        'city' => true,
        'item_telephones' => true,
        'categories' => true,
        'campaigns' => true,
    ];
}
