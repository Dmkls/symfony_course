<?php

namespace App\Controller;

use App\Entity\Task;
use App\Form\TaskType;
use App\Repository\TaskRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

use Symfony\Component\HttpFoundation\JsonResponse;

#[Route('/task')]
final class TaskController extends AbstractController
{
    #[Route(name: 'app_task_index', methods: ['GET'])]
    public function index(TaskRepository $repository): JsonResponse
    {
        $projects = $repository->findAll();

        $data = array_map(fn($project) => [
            'id'   => $project->getId(),
            'name' => $project->getName(),
            'description' => $project->getDescription(),
            'created_at' => $project->getCreatedAt()->format('Y-m-d H:i:s'),
            'updated_at' => $project->getUpdatedAt()->format('Y-m-d H:i:s'),
        ], $projects);

        return $this->json(['data' => $data]);
    }

    #[Route('/new', name: 'app_task_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $project = new Task();
        $form = $this->createForm(TaskType::class, $project);
        $form->submit(json_decode($request->getContent(), true));

        if ($form->isValid()) {
            $em->persist($project);
            $em->flush();

            $data = [
                'id'   => $project->getId(),
                'name' => $project->getName(),
                'description' => $project->getDescription(),
                'created_at' => $project->getCreatedAt()->format('Y-m-d H:i:s'),
                'updated_at' => $project->getUpdatedAt()->format('Y-m-d H:i:s'),
            ];

            return $this->json(['data' => $data], 201);
        }

        $errors = [];
        foreach ($form->getErrors(true) as $error) {
            $errors[$error->getOrigin()->getName()][] = $error->getMessage();
        }

        return $this->json(['data' => $errors], 400);
    }

    #[Route('/{id}', name: 'app_task_show', methods: ['GET'])]
    public function show(string $id, TaskRepository $repository): JsonResponse
    {
        $project = $repository ->find($id);
        if (!$project) {
            return $this->json(['data' => ['id' => ['Not found']]], 400);
        }
        $data = [
            'id'   => $project->getId(),
            'name' => $project->getName(),
            'description' => $project->getDescription(),
            'created_at' => $project->getCreatedAt()->format('Y-m-d H:i:s'),
            'updated_at' => $project->getUpdatedAt()->format('Y-m-d H:i:s'),
        ];
        return $this->json(['data' => $data]);
    }

    #[Route('/{id}/edit', name: 'app_task_edit', methods: ['GET', 'PATCH'])]
    public function update(string $id, Request $request, EntityManagerInterface $em, TaskRepository $repository): JsonResponse
    {
        $project = $repository ->find($id);
        if (!$project) {
            return $this->json(['data' => ['id' => ['Not found']]], 400);
        }
        $old_name = $project->getName();
        $form = $this->createForm(ProjectGroupType::class, $project);
        $form->submit(json_decode($request->getContent(), true), false);

        if ($form->isValid()) {
            if ($project->getName() != $old_name)
                $em->flush();

            $data = [
                'id'   => $project->getId(),
                'name' => $project->getName(),
                'description' => $project->getDescription(),
                'created_at' => $project->getCreatedAt()->format('Y-m-d H:i:s'),
                'updated_at' => $project->getUpdatedAt()->format('Y-m-d H:i:s'),
            ];

            return $this->json(['data' => $data]);
        }

        $errors = [];
        foreach ($form->getErrors(true) as $error) {
            $errors[$error->getOrigin()->getName()][] = $error->getMessage();
        }

        return $this->json(['data' => $errors], 400);
    }

    #[Route('/{id}/delete', name: 'app_task_delete', methods: ['DELETE'])]
    public function delete(string $id, EntityManagerInterface $em, TaskRepository $repository): JsonResponse
    {
        $project = $repository ->find($id);
        if (!$project) {
            return $this->json(['data' => ['id' => ['Not found']]], 400);
        }

        $em->remove($project);
        $em->flush();

        return $this->json([], 204);
    }
}
