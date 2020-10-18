<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Location Entity
 *
 * @property int $id
 * @property string $breed_id
 * @property string|null $name
 * @property \Cake\I18n\FrozenTime $seen
 * @property string $lat
 * @property string $lon
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Breed $breed
 */
class Location extends Entity
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
        'breed_id' => true,
        'name' => true,
        'seen' => true,
        'lat' => true,
        'lon' => true,
        'created' => true,
        'modified' => true,
        'breed' => true,
    ];
    
    protected $_virtual = ['lat', 'lon'];
    protected function _getLat($lat)
    {
        return $lat ? (float) $lat : $lat;
    }

    protected function _getLon($lon)
    {
        return $lon ? (float) $lon : $lon;
    }
}
