<?php

namespace App\Controller;

use App\Repository\ClasseRepository;
use App\Repository\EtudiantRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EtudiantController extends AbstractController
{
    #[Route('/etudiant/classe/{id_client}', name: 'etudiant_classe_id')]
    public function index(int $id_client,Request $request,ClasseRepository $classeRepository,EtudiantRepository $etudiantRepository): Response
    {
        $classe = $classeRepository->find($id_client);
        $page=$request->query->getInt('page',1);
        $limit=$this->getParameter("limit");
        $offset=($page-1)*$limit;
        
        $etudiants=$etudiantRepository->findByEtudiantByClasse($id_client, $limit, $offset);
        $count=$etudiants->count();
        $nbrePage=ceil($count/$limit) ;
        return $this->render('etudiant/index.html.twig', [
            'classe' => $classe ,
            'etudiants' => $etudiants ,
            "nbrePage" =>  $nbrePage,
            "pageActive" =>   $page,
            "idClasse"=>$id_client
        ]);
    }
}
