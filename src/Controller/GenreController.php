<?php

namespace App\Controller;

use App\Entity\Genre;
use App\Repository\FilmsRepository;
use App\Repository\GenreRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class GenreController extends AbstractController
{
    /**
     * @Route("/genres", name="genres", methods={"GET"})
     */
    public function index(GenreRepository $repo) : Response
    {
        $genre = $repo->findAll();
        return $this->render('genre/listeGenres.html.twig', [
            'lesGenres' => $genre,
        ]);
    }

}