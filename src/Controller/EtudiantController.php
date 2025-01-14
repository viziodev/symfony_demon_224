<?php

namespace App\Controller;

use App\Repository\ClasseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class EtudiantController extends AbstractController
{
    #[Route('/etudiant/classe/{id_client}', name: 'etudiant_classe_id')]
    public function index(int $id_client,ClasseRepository $classeRepository): Response
    {
        $classe = $classeRepository->find($id_client);
        return $this->render('etudiant/index.html.twig', [
            'classe' => $classe ,
        ]);
    }
}
