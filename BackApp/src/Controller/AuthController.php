<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class AuthController extends AbstractController
{
    #[Route('/api/check_token', name: 'api_check_token', methods:['GET'])]
    public function checkToken(): JsonResponse
    {
        return new JsonResponse(['status' => 'Token is valid']);
    }

    #[Route('/api/logout', name: 'api_logout', methods:['POST'])]
    public function logout(): JsonResponse
    {
        $response = new JsonResponse();
        // Invalidate cookie BEARER by creating an invalid & expired one
        $cookie = Cookie::create('BEARER')
            ->withValue('')
            ->withExpires(time() - 3600)
            ->withPath('/')
            ->withSecure(false)
            ->withHttpOnly()
            ->withSameSite(Cookie::SAMESITE_LAX);

        $response->headers->setCookie($cookie);

        return $response;
    }
}