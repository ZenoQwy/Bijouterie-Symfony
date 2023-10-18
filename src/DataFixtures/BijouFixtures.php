<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use App\Entity\Bijou;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class BijouFixtures extends Fixture implements DependentFixtureInterface
{

    private $faker;
    public function __construct(){
        $this->faker = Factory::create("fr_FR");
      }

    public function load(ObjectManager $manager): void
    {
        for ($i=0;$i<10;$i++){
            $bijou = new Bijou();
            $bijou->setDescription($this->faker->text());
            $bijou->setPrixVente($this->faker->randomFloat(2, 55, 350));  // 2 chiffres apres la virgule, chiffre compris entre 55 et 350
            $bijou->setPrixLocation($this->faker->randomFloat(2, 35, 125));  // 2 chiffres apres la virgule, chiffre compris entre 35 et 125
            $bijou->setCategorie($this->getReference('categorie'.mt_rand(0,9)));
            $this->addReference('bijou'.$i,$bijou);
            $manager->persist($bijou);
        }

        $manager->flush();
    }
    public function getDependencies(){
        return [CategorieFixtures::class];
    }
}