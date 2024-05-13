<?php

namespace App\Controller\Admin;

use App\Entity\Genre;
use App\Form\GenreType;
use App\Repository\GenreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class GenreController extends AbstractController
{
    /**
     * @Route("/admin/genres", name="admin_genres", methods={"GET"})
     */
    public function listeGenres(GenreRepository $repo) 
    {
        $genre = $repo->findAll();
        return $this->render('admin/genre/listeGenres.html.twig', [
            'lesGenres' => $genre,
        ]);
    }
    
    /**
     * @Route("/admin/genre/ajout", name="admin_genre_ajout", methods={"GET","POST"})
     * @Route("/admin/genre/modif/{id}", name="admin_genre_modif", methods={"GET","POST"})
     */
    public function ajoutModifGenre(Genre $genre=null, Request $request, EntityManagerInterface $manager ) 
    {
        if($genre == null){
            $genre = new Genre();
            $mode="ajouté";
        }else {
            $mode="modifié";
        }
        $form=$this->createForm(GenreType::class, $genre);
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid() ) 
        {
                $manager->persist($genre);
                $manager->flush();
                $this->addFlash(
                    'success', "Le genre a été bien $mode"
                );
                return $this->redirectToRoute('admin_genres');
        }
        return $this->render('admin/genre/formAjoutModifGenre.html.twig', [
            'formGenre' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/genre/suppression/{id}", name="admin_genre_suppression", methods={"DELETE"})
     */
    public function suppressionGenre($id, EntityManagerInterface $manager)
    {
        $genre = $manager->find(Genre::class, $id);
        if($genre == null) {
            throw $this->createNotFoundException("Le genre n'existe pas");
        }
        $manager->remove($genre);
        $manager->flush();
        $this->addFlash(
            'success', "Le genre a été bien été supprimé");
        return $this->redirectToRoute('admin_genres');
    }
    
}