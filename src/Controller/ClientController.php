<?php

namespace App\Controller;

use App\Entity\Client;
use App\Events\ClientRegisteredEvent;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ClientController extends AbstractController
{
    #[Route('/client', name: 'app_client')]
    public function index(): Response
    {
        return $this->render('client/index.html.twig', [
            'controller_name' => 'ClientController',
        ]);
    }

    #[Route('/client', name: 'app_client')]
    public function sendMail(Request $request, EventDispatcherInterface $eventDispatcher): Response
    {
        // Assume we have a User entity and registration logic here.
        $client = new Client();
        // ...registration logic
        $client->setNom("Baila Wane");
        $client->setEmail("douvewane85@gmail.com");
        // Dispatch the UserRegisteredEvent
        $eventDispatcher->dispatch(new ClientRegisteredEvent($client), ClientRegisteredEvent::NAME);

        return new Response('User registered!');
    }
}
