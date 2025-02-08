<?php

namespace App\DataFixtures;

use App\Entity\ProjectGroup;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProjectGroupFixture extends Fixture
{

    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 20; $i++) {
            $task = new ProjectGroup();
            $task->setName('Project '.$i);
            $manager->persist($task);
        }

        $manager->flush();
    }

}