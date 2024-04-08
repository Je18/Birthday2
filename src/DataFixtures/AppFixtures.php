<?php

namespace App\DataFixtures;

use App\Factory\BirthdayFactory;
use App\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        BirthdayFactory::createMany(
            5,
            static function (int $i) {
                return ['name' => "Patoche $i"]; // "Title 1", "Title 2", ... "Title 5"
            }
        );
        UserFactory::createMany(
            2,
            static function (int $i) {
                return ['email' => "user$i@$i.com", 'password' => '$2y$13$WxxSkObUPdFijeZRBXuMWeipskD9a4SNm7NNUYEVhyrLVOTxpxlpW']; // "Title 1", "Title 2", ... "Title 5"
            }
        );

        $manager->flush();
    }
}
