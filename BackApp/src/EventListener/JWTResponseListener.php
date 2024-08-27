<?php

namespace App\EventListener;

use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Symfony\Component\HttpFoundation\Cookie;

class JWTResponseListener
{
    /**
     * Sometimes depending on the localhost environment Lexik Bundle won't set up the cookies
     * In order to enforce this we need to create listen to this event and add it manually
     *
     * @param AuthenticationSuccessEvent $event
     * @return void
     */
    public function onAuthenticationSuccess(AuthenticationSuccessEvent $event)
    {
        $response = $event->getResponse();
        $data = $event->getData();
        $token = $data['token'];

        $cookie = Cookie::create('BEARER')
            ->withValue($token)
            ->withExpires(time() + 3600)
            ->withPath('/')
            ->withSecure(false)
            ->withHttpOnly()
            ->withSameSite(Cookie::SAMESITE_LAX);

        $response->headers->setCookie($cookie);
    }
}