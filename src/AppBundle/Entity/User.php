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

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @author Alexander Golovnya <snsanich@gmail.com>
 */

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    public function __construct()
    {
        parent::__construct();
        // your own logic
    }

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