<?php
/*
 * This file is part of the symapp.
 *
 * (c) Alexander Golovnya <snsanich@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 * Date: 4/11/17
 * Time: 6:54 PM
 */

namespace AppBundle\DataFixtures\ORM;


/**
 * @author Alexander Golovnya <snsanich@gmail.com>
 */

use AppBundle\Entity\Asin;
use AppBundle\Entity\Child;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\User;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\Encoder\BCryptPasswordEncoder;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;

class LoadAsinData extends AbstractFixture implements FixtureInterface, OrderedFixtureInterface
{

    public function load(ObjectManager $manager)
    {
        $admin = $this->getReference('admin');
        $user = $this->getReference('user');

        $columns = ['asin', 'title', 'map', 'children', 'fosUserId'];
        $childColumns = ['sellerName', 'livePrice'];
        $asins = [
            ['arr1', 'hello to you', 3.53, [
                ['seller1', 5523.34],
                ['seller2', 34.34]
            ], $admin->getId()],
            ['arr2', 'and to you', 0.123, [
                ['seller21', 123.34]
            ], $user->getId()],
            ['arr3', '.. to you', 3245.2, [
                ['seller31', 437.4],
                ['seller32', 73.763],
                ['seller09', 1.895]
            ], $user->getId()]
        ];

        foreach($asins as $values) {
            $data = array_combine($columns, $values);
            $asin = Asin::fromArray($data);

            $manager->persist($asin);

            foreach ($data['children'] as $values) {
                $dataChild = array_combine($childColumns, $values);
                $dataChild['parent'] = $asin;
                $child = Child::fromArray($dataChild);

                $manager->persist($child);
            }
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 10;
    }
}