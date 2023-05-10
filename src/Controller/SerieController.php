<?php

namespace App\Controller;

use App\Entity\Serie;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Date;

#[Route('/series', name: 'serie_')]
class SerieController extends AbstractController
{
    #[Route('', name: 'list')]
    public function list(): Response
    {
        return $this->render('serie/list.html.twig');
    }

    #[Route('/{id}', name: 'show', requirements : ["id" => "\d+"])]
    public function show(int $id): Response
    {
        dump($id);
        return $this->render('serie/show.html.twig');
    }

    #[Route('/add', name: 'add')]
    public function index(): Response
    {
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




        return $this->render('serie/add.html.twig');
    }

}
