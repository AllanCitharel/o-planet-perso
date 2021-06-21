<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Nelmio\Alice\Loader\NativeLoader;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $user = new User();
        // $manager->persist($user);
        // $user->setEmail('test@test.test');
        // $user->setPassword('test');
        // $user->setRoles(["ROLE_ADMIN"]);
        // $user->setUserAlias('test');
        // $user->setFirstname('test');
        // $user->setLastname('test');
        // $user->setIsBanned(false);
        // $user->setCreatedAt(new \DateTime());
        // $manager->persist($user);
        // $manager->flush();




        $loader = new NativeLoader();

        $objectSet = $loader->loadFile(__DIR__ . '/CustomFixtures.yaml')->getObjects();

        foreach($objectSet as $object){
            $manager->persist($object);
        }

        $manager->flush();



    }
}
