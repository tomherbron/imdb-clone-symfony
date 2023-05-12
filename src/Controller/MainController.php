<?php

namespace App\Controller;

use App\Entity\Serie;
use App\Repository\SerieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'main_home')]
    public function home(): Response
    {
        return $this -> render('main/home.html.twig');
    }

    #[Route('/test', name: 'main_test')]
    public function test(SerieRepository $serieRepository): Response
    {

            $username = "Tomy";
            $witcher = ["title" => "The Witcher", "year" => 2019];
        /*
                $show = new Serie();
                $show
                    -> setName("Utopia")
                    -> setBackdrop("backdrop.png")
                    -> setDateCreated(new \DateTime())
                    -> setGenres("Thriller/Drama")
                    -> setFirstAirDate(new \DateTime("-2 year"))
                    -> setLastAirDate(new \DateTime("-2 month"))
                    -> setPopularity(500)
                    -> setPoster("poster.png")
                    -> setStatus("Canceled")
                    -> setTmdbId(123456)
                    -> setVote(5);

                // Save instance using EntityManager (Oldskool)
                // $entityManager -> persist($show);
                // $entityManager -> flush();

                // Using SerieRepository

                $serieRepository -> save($show, true);
          */
        return $this -> render('main/test.html.twig', [
            "pseudo" => $username,
            "show" => $witcher
        ]);
    }

}
