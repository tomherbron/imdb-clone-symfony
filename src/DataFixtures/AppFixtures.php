<?php

namespace App\DataFixtures;

use App\Entity\Serie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $this -> addSeries($manager);
    }

    public function addSeries(ObjectManager $manager): void
    {

        $generator = Factory::create('fr_FR');

        for ($i = 0; $i < 50; $i++) {
            $show = new Serie();
            $show
                -> setName($generator -> word.$i)
                -> setBackdrop("backdrop.png")
                -> setDateCreated($generator->dateTimeBetween('-20 years'))
                -> setGenres($generator->randomElement(['Western', 'Science-Fiction', 'Drama', 'Fantasy', 'Comedy', 'Thriller', 'Action']))
                -> setFirstAirDate($generator -> dateTimeBetween("-10 years", "-1 year"))
                -> setLastAirDate(new \DateTime("-2 month"))
                -> setPopularity($generator -> numberBetween(0, 1000))
                -> setPoster("poster.png")
                -> setStatus("Canceled")
                -> setTmdbId(123456)
                -> setVote(5);

            $manager -> persist($show);

        }

        $manager -> flush();

    }
}
