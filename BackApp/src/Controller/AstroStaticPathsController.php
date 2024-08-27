<?php

namespace App\Controller;

use App\Entity\ToDoList;
use App\Repository\ToDoListRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/staticPaths')]
class AstroStaticPathsController extends AbstractController
{
    #[Route('/lists', name: 'static_path_lists', methods:['GET'])]
    public function getStaticLists(ToDoListRepository $toDoListRepository): Response
    {
        /**
         * @var $list ToDoList
         */
        $ids = array_map(function(ToDoList $list) {return $list->getId();}, $toDoListRepository->findAll());
        return new JsonResponse($ids);
    }

}