<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Task;
use App\DataFixtures\UserFixtures;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class TaskFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = new Factory;
        $faker = $faker::create('fr_FR');

        for($i = 1; $i <= 20; $i++){
            $task = new Task;
            $task->setUser($this->getReference('user-'.mt_rand(1, 2)));
            $task->setContent($faker->paragraph(2));
            $task->setTitle($faker->sentence());
            $task->setCreatedAt($faker->dateTimeBetween('-6 months'));
            $manager->persist($task);
        }

        $manager->flush();
    }

    /**
     * This method must return an array of fixtures classes
     * on which the implementing class depends on
     *
     * @return array
     */
    public function getDependencies() : array
    {
        return array(
            UserFixtures::class,
        );
    }
}