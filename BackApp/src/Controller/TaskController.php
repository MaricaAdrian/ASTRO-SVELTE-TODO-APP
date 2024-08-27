<?php

namespace App\Controller;

use App\Entity\ApiUser;
use App\Entity\Task;
use App\Entity\ToDoList;
use App\Form\TaskType;
use App\Repository\ApiUserRepository;
use App\Repository\ToDoListRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/task')]
class TaskController extends AbstractController
{
    #[Route('/new', name: 'app_task_new', methods: ['GET', 'POST'])]
    public function new(
        Request $request,
        EntityManagerInterface $entityManager,
        SerializerInterface $serializer,
        Security $security,
        ApiUserRepository $apiUserRepository,
        ToDoListRepository $toDoListRepository
    ): Response {
        $jsonData = $request->getContent();

        /**
         * @var $task Task
         */
        $task = $serializer->deserialize($jsonData, Task::class, 'json');
        $data = json_decode($jsonData, true);
        /**
         * @var ApiUser
         */
        $apiUser = $apiUserRepository->find($security->getUser());
        if ($apiUser) {
            $task->setCreatedBy($apiUser);
        }

        if (isset($data['toDoListId'])) {
            /**
             * @var $toDoList ToDoList
             */
            $toDoList = $toDoListRepository->find($data['toDoListId']);
            $task->setToDoList($toDoList);
        }


        $entityManager->persist($task);
        $entityManager->flush();


        return new JsonResponse(['task' => $task]);
    }


    #[Route('/{id}/edit', name: 'app_task_edit', methods: ['PUT'])]
    public function edit(Request $request, EntityManagerInterface $entityManager, Task $task): Response
    {
        $jsonData = $request->getContent();
        $data = json_decode($jsonData, true);
        $task->setStatus($data['status']);
        $entityManager->flush();

        return new JsonResponse(['task' => $task]);
    }
}
