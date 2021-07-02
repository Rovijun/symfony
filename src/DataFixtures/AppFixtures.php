<?php

namespace App\DataFixtures;


use Faker;
use App\Entity\Beer;
use App\Entity\Country;
use App\Entity\Category;
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


        // création des catégories

        $catBeers = [
            'Blonde',
            'Belges',
            'Porter',
            'Weizen'
        ];

        // insertion catégories & insertion des bières

        $count = 20;
        while($count > 0) {
            $category = new Category();
            $rand_keys = array_rand($catBeers, 1);
            $category->setName($catBeers[$rand_keys]);  
            $category->setDescription($faker->realText);

            $beer = new Beer();
            $beer->setName($faker->company);
            $beer->setPublishedAt(new \DateTime());
            $beer->setDescription($faker->catchPhrase);
            $beer->setRating(rand(0, 10));
            $beer->setStatus(rand(0, 1) ? "available" : "unavailable");
            $beer->setDegree($faker->randomFloat(1, 0, 10));
            $beer->setPrice($faker->randomFloat(2, 10, 100));
            
            $beer->setCountry($countries[rand(0,3)]);

            $beer->addCategory($category);
            
            $manager->persist($category);
            $manager->persist($beer);

            $count--;
        }
        
        $manager->flush();
        
        $repoCategory = $manager->getRepository(Category::class);

        $category = $repoCategory->findAll();
    }
   
}
