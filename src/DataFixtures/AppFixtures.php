<?php

namespace App\DataFixtures;


use Faker;
use App\Entity\Beer;
use App\Entity\Country;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');

        // créez 4 pays Country 
        $count = 4;
        while($count > 0) {
            $country = new Country();
            $country->setName($faker->country);
            $country->setAddress($faker->address);
            $country->setEmail($faker->email);

            $manager->persist($country);

            $count--;
        }
        $manager->flush();
        // associer un pays au hasard à chaque bière
        $repoCountry = $manager->getRepository(Country::class);

        $countries = $repoCountry->findAll();

        

        $count = 20;
        while($count > 0) {
            $beer = new Beer();
            $beer->setName($faker->company);
            $beer->setPublishedAt(new \DateTime());
            $beer->setDescription($faker->catchPhrase);
            $beer->setRating(rand(0, 10));
            $beer->setStatus(rand(0, 1) ? "available" : "unavailable");
            $beer->setDegree($faker->randomFloat(1, 0, 10));

            $beer->setCountry($countries[rand(0,3)]);

            $manager->persist($beer);

            $count--;
        }

        $manager->flush();
    }
}
