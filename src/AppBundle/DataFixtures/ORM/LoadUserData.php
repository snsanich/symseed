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
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\User;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\Encoder\BCryptPasswordEncoder;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;

class LoadUserData extends AbstractFixture implements FixtureInterface, ContainerAwareInterface, OrderedFixtureInterface
{
    /**
     * @var UserPasswordEncoder
     */
    private $encoder;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->encoder = $container->get('security.password_encoder');
    }

    public function load(ObjectManager $manager)
    {
        $columns = ['username', 'email', 'enabled', 'salt', 'password', 'roles'];
        $users = [
            ['admin', 'admin@test.com', true, '', '123456', ['ROLE_ADMIN']],
            ['user', 'user@test.com', true, '', '123456', ['ROLE_USER']],
            ['guest', 'guest@test.com', true, '', '123456', ['ROLE_USER']]
        ];

        $encoder = $this->encoder;
        foreach ($users as $values) {
            $data = array_combine($columns, $values);
            $user = User::fromArray($data);

            $password = $encoder->encodePassword($user, $data['password']);
            $user->setPassword($password);

            $manager->persist($user);

            $this->addReference($user->getUsername(), $user);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 5;
    }
}