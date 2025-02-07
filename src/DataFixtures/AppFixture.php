<?php

namespace App\DataFixtures;

use App\Entity\Project;
use App\Entity\ProjectGroup;
use App\Entity\Task;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 5; $i++) {

            $group = new ProjectGroup();
            $group->setName('Project Group: '.$i);

            for ($j = 1; $j <= 3; $j++) {
                $project = new Project();
                $project->setName("Project {$j}. Group $i");
                $group->addProject($project);

                for ($k = 1; $k <= 5; $k++) {
                    $task = new Task();
                    $task->setName("Task {$k}. Project $j");
                    $task->setDescription("Description Task {$k}, Project $j");
                    $project->addTask($task);
                }
            }

            $manager->persist($group);
        }

        $manager->flush();
    }

}