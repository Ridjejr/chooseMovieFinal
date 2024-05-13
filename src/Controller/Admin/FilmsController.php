<?php

namespace App\Controller\Admin;

use App\Entity\Films;
use App\Form\FilmsType;
use App\Form\FiltreFilmsType;
use App\Repository\FilmsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class FilmsController extends AbstractController
{
    /**
     * @Route("/admin/films", name="admin_films", methods={"GET"})
     */
    public function listeFilms(FilmsRepository $repo, PaginatorInterface $paginator, Request $request): Response
    {
        $films = $paginator->paginate(
            $repo->findAll(),
            $request->query->getInt('page', 1), /*page number*/
            10 /*limit per page*/
        );
        return $this->render('admin/films/listeFilms.html.twig', [
            'lesFilms' => $films
        ]);
    }

    /**
     * @Route("/admin/films/ajout", name="admin_films_ajout", methods={"GET","POST"})
     */
    public function ajoutFilms(Request $request, EntityManagerInterface $manager): Response
    {

        $films = new Films();
        $form=$this->createForm(FilmsType::class, $films);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $manager->persist($films);
            $manager->flush();
            $this->addFlash('success', 'Le film a bien été ajouté');
            return $this->redirectToRoute('admin_films');
        }
        return $this->render('admin/films/formAjoutFilms.html.twig', [
            'formFilms' => $form->createView()
        ]);
        
    }


    /**
     * @Route("/admin/films/modif/{id}", name="admin_films_modif", methods={"GET","POST"})
     */
    public function modifFilms($id, Request $request, EntityManagerInterface $manager): Response
    {
        $film = $manager->getRepository(Films::class)->find($id);
        
        if (!$film) {
            throw new NotFoundHttpException('Films non trouvé');
        }
        $form=$this->createForm(FilmsType::class, $film);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $manager->persist($film);
            $manager->flush();
            $this->addFlash('success', 'Le film a bien été modifié');
            return $this->redirectToRoute('admin_films');
        }
        return $this->render('admin/films/formModifFilms.html.twig', [
            'formFilms' => $form->createView()
        ]);
        
    }


    /**
     * @Route("/admin/films/suppression/{id}", name="admin_films_suppression", methods={"GET"})
     */
    public function suppressionFilms($id, EntityManagerInterface $manager): Response
    {
        $film = $manager->getRepository(Films::class)->find($id);
        if (!$film) {
            throw new NotFoundHttpException('Films non trouvé');
        }
        
        $manager->remove($film);
        $manager->flush();
        $this->addFlash('danger', 'Le film a bien été suprimé');
        return $this->redirectToRoute('admin_films');
    
        
    }

}