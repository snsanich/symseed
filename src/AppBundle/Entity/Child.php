<?php
/*
 * This file is part of the symapp.
 *
 * (c) Alexander Golovnya <snsanich@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 * Date: 4/11/17
 * Time: 5:56 PM
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Asin;

/**
 * @author Alexander Golovnya <snsanich@gmail.com>
 */
/**
 * @ORM\Entity
 * @ORM\Table(name="app_child")
 */
class Child
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
    private $sellerName;

    /**
     * @ORM\Column(type="float")
     */
    private $livePrice;

    /**
     * Many Child have One Asin.
     * @ORM\ManyToOne(targetEntity="Asin")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id")
     */
    private $parent;

    public static function fromArray(array $item) {
        $obj = new self;
        foreach ($item as $property => $value) {
            if (property_exists($obj, $property)) {
                $obj->$property = $value;
            }
        }
        return $obj;
    }
}