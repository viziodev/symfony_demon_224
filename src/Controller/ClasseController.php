<?php

namespace App\Controller;

use App\Dto\ClasseSearchDto;
use App\Entity\Classe;
use App\Form\ClasseSearchType;
use App\Form\ClasseType;
use App\Repository\ClasseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ClasseController extends AbstractController
{
    
    #[Route('/classe/list', name: 'classe_list',methods:["GET","POST"])]
    public function index(ClasseRepository $classeRepository,Request $request): Response
    {
     
          $page=$request->query->getInt('page',1);
          $nbreElementParPage=5;
          $classeSearchDto=new ClasseSearchDto();
          $formSearchClasse=$this->createForm(ClasseSearchType::class, $classeSearchDto);
          /*
           *   offset=0    page=1   offset=(1-1)*5=0
           *   offset=5    page=2   offset=(2-1)*5=5
           *   offset=10   page=3   offset=(3-1)*5=10
           * 
           *   offset =(page-1)* nbreElParPage
           */
          $offset=($page-1)*$nbreElementParPage;
          //13/5 =2,55555 => 3 pages (2 p 5 3 3)
       
           $formSearchClasse->handleRequest($request);
        $filtre=[];
          if ($formSearchClasse->isSubmitted() ) {
             $filtre=[
                 "filiere"=>$classeSearchDto->getFiliere(),
                 "niveau"=>$classeSearchDto->getNiveau()
                ];  
           }
           $totalElement=$classeRepository->count($filtre);
           $nbrePage=ceil($totalElement/5) ;
          $datas= $classeRepository->findBy($filtre,["id"=>"desc"],$nbreElementParPage,$offset);

          return $this->render('classe/index.html.twig',[
            "classes" =>$datas,
            "nbrePage" =>$nbrePage,
            "pageActive" =>   $page,
            "formSearchClasse"=> $formSearchClasse->createView()
          ]);
    }

    #[Route('/classe/store', name: 'classe_store',methods:["GET","POST"])]
    public function store(Request $request,EntityManagerInterface $manager): Response
    { 
          $classe=new Classe();
          $formClasse=$this->createForm(ClasseType::class, $classe);
          $formClasse->handleRequest($request);
          if ($formClasse->isSubmitted() ) {
              $manager->persist($classe);
              $manager->flush();
              return $this->redirectToRoute("classe_list");
          }
          return $this->render('classe/store.html.twig',[
              "formClasse"=> $formClasse->createView()
          ]);
    }
}
