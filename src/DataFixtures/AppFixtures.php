<?php

namespace App\DataFixtures;

use App\Entity\MyList;
use App\Factory\MyListFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        MyListFactory::createMany(10);
    }
}
