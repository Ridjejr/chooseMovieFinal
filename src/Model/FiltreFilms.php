<?php 

namespace App\Model;
use App\Entity\Genre;
use Symfony\Component\Validator\Constraints as Assert;

class FiltreFilms {
    // /**
    //  * @Assert\Length(
    //  *     min = 3,
    //  *     minMessage = "Le titre doit contenir au moins {{ limit }} caractères"
    //  * )
    //  */

    public  $titre;

    public  $genre;
}