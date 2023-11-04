<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Property;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < 20; $i++) {
            $property = new Property();
            $property->setTitle($faker->text(50));
            $property->setDescription($faker->text(200));
            $property->setSurface($faker->numberBetween(10, 500));
            $property->setRooms($faker->numberBetween(1, 10));
            $property->setBedrooms($faker->numberBetween(1, 5));
            $property->setPrice($faker->numberBetween(50000, 1000000));
            $property->setCity($faker->city);
            $property->setSold($faker->boolean);
            $property->setCreatedAt(\DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-1 year', 'now')));

            $manager->persist($property);
        }

        $manager->flush();
    }
}
