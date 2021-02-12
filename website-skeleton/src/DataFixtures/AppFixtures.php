<?php

namespace App\DataFixtures;

use App\Entity\Acteur;
use App\Entity\Categorie;
use App\Entity\Film;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $rogen = new Acteur();
        $rogen->setNom("Seth Rogen");
        $manager->persist($rogen);

        $franco = new Acteur();
        $franco->setNom("James Franco");
        $manager->persist($franco);

        $comique = new Categorie();
        $comique->setNom('comique');
        $manager->persist($comique);

        $action = new Categorie();
        $action->setNom('action');
        $manager->persist($action);

        $film1 = new Film();
        $film1->setNom('The Boyfriend');
        $manager->persist($film1);

        $film2 = new Film();
        $film2->setNom('Spiderman');
        $manager->persist($film2);
        $manager->flush();
    }
}
