<?php

namespace App\DataFixtures;

use App\Entity\Project;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProjectFixture extends Fixture
{

    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 20; $i++) {
            $task = new Project();
            $task->setName('Project '.$i);
            $manager->persist($task);
        }

        $manager->flush();
    }

}