<?php

namespace App\Controller;

use App\Repository\MembreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MembreController extends AbstractController
{
    /**
     * @Route("/membre", name="membre")
     */
    public function index(MembreRepository $repo): Response
    {
        
        return $this->render('membre/index.html.twig', [
            'controller_name' => 'MembreController',
        ]);
    }
}
