<?php
/*
 * This file is part of the symapp.
 *
 * (c) Alexander Golovnya <snsanich@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 * Date: 4/11/17
 * Time: 5:55 PM
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @author Alexander Golovnya <snsanich@gmail.com>
 */
/**
 * @ORM\Entity
 * @ORM\Table(name="app_asin")
 */
class Asin
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $asin;

    /**
     * @ORM\Column(type="string")
     */
    private $title;

    /**
     * @ORM\Column(type="float")
     */
    private $map;

    /**
     * @ORM\Column(type="integer")
     */
    private $fosUserId;

    public static function fromArray(array $item) {
        $obj = new self;
        foreach ($item as $property => $value) {
            if (property_exists($obj, $property)) {
                $obj->$property = $value;
            }
        }
        return $obj;
    }

    public function __toString()
    {
        return "asin: [{$this->asin}], title:[{$this->title}], id: {$this->fosUserId}";
    }
}