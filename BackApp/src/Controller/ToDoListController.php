<?php

namespace App\Controller;

use App\Entity\ApiUser;
use App\Entity\ToDoList;
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

#[Route('api/todolist')]
class ToDoListController extends AbstractController
{
    #[Route('/all', name: 'app_to_do_list_all', methods: ['GET'])]
    public function all(
        Security $security,
        ToDoListRepository $toDoListRepository,
    ): JsonResponse {
        $todoLists = $toDoListRepository->findBy(['createdBy' => $security->getUser()]);

        return new JsonResponse($todoLists);
    }

    #[Route('/new', name: 'app_to_do_list_new', methods: ['GET', 'POST'])]
    public function new(
        Request $request,
        EntityManagerInterface $entityManager,
        SerializerInterface $serializer,
        ApiUserRepository $apiUserRepository,
        Security $security
    ): JsonResponse {
        $jsonData = $request->getContent();

        // Deserialize the JSON into a ToDoList entity
        $toDoList = $serializer->deserialize($jsonData, ToDoList::class, 'json');

        /**
         * @var ApiUser
         */
        $apiUser = $apiUserRepository->find($security->getUser());
        if ($apiUser) {
            $toDoList->setCreatedBy($apiUser);
        }

        $entityManager->persist($toDoList);
        $entityManager->flush();


        return new JsonResponse(['toDoList' => $toDoList]);
    }

    #[Route('/{id}', name: 'app_to_do_list_show', methods: ['GET'])]
    public function show(ToDoList $toDoList): Response
    {
        return new JsonResponse($toDoList);
    }

    #[Route('/{id}/edit', name: 'app_to_do_list_edit', methods: ['GET', 'POST'])]
    public function edit(
        Request $request,
        ToDoList $toDoList,
        EntityManagerInterface $entityManager,
        SerializerInterface $serializer,
    ): JsonResponse {
        $jsonData = $request->getContent();

        // Deserialize the JSON into the existing ToDoList entity
        $serializer->deserialize($jsonData, ToDoList::class, 'json', ['object_to_populate' => $toDoList]);

        // Persist the changes to the database
        $entityManager->flush();

        return new JsonResponse(['toDoList' => json_encode($toDoList)]);
    }

    #[Route('/{id}', name: 'app_to_do_list_delete', methods: ['DELETE'])]
    public function delete(ToDoList $toDoList, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($toDoList);
        $entityManager->flush();

        return new JsonResponse(['status' => 'Deleted']);
    }
}
