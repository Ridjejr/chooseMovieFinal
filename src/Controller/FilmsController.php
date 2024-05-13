<?php

namespace App\Controller;

use App\Entity\Films;
use App\Model\FiltreFilms;
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
     * @Route("/films", name="films", methods={"GET"})
     */
    public function listeFilms(FilmsRepository $repo, PaginatorInterface $paginator, Request $request): Response
    {
    
        $filtre = new FiltreFilms();
        $formFiltreFilms = $this->createForm(FiltreFilmsType::class, $filtre);
        $formFiltreFilms->handleRequest($request);
        
        // if ($formFiltreFilms->isSubmitted() && $formFiltreFilms->isValid()) {
        //     // On récupère les données du formulaire
        //     $titre = $formFiltreFilms->get('titre')->getData();         
        // } 
        // else {
        //     $titre = null;
        // }
        $film = $paginator->paginate(
            $repo->listeFilmsCompletePaginee($filtre),
            $request->query->getInt('page', 1), /*page number*/
            18 /*limit per page*/
        );
        return $this->render('film/listeFilms.html.twig', [
            'lesFilms' => $film,
            'formFiltreFilms' => $formFiltreFilms->createView()
        ]);
    }

    /**
     * @Route("/films/{id}", name="ficheFilm", methods={"GET"})
     */
    public function ficheFilm($id, EntityManagerInterface $mamager): Response
    {
        $film = $mamager->getRepository(Films::class)->find($id);
        if (!$film) {
            throw new NotFoundHttpException('Ce film n\'existe pas');
        }
        return $this->render('film/ficheFilm.html.twig', [
            'leFilm' => $film
        ]);
    }

        /**
     * @Route("/films/genre/{id}", name="films_par_genre", methods={"GET"})
     */
    public function filmsParGenre($id, FilmsRepository $filmsRepository): Response
    {
        $films = $filmsRepository->findByGenre($id);
        
        return $this->render('film/listeFilmsParGenre.html.twig', [
            'lesFilms' => $films,
        ]);
    }
}