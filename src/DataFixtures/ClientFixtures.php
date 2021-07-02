<?php

namespace App\DataFixtures;

use Faker;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Client;

class ClientFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
     
        $faker = Faker\Factory::create('fr_FR');        
        
        $count = 10;

        while ($count > 0) {
            
            $client = new Client();
            $client->setName($faker->lastName);
            $client->setEmail($faker->email);
            $client->setConso(rand(0,10));
    
            $manager->persist($client);

            $count--;
        }

        $manager->flush();

        $repoClient = $manager->getRepository(Client::class);

        $client = $repoClient->findAll();

    }
}
