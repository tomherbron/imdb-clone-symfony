<?php

namespace App\Controller;

use App\Entity\Serie;
use App\Repository\SerieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Date;

#[Route('/series', name: 'serie_')]
class SerieController extends AbstractController
{
    #[Route('', name: 'list')]
    public function list(SerieRepository $serieRepository): Response
    {
        $series = $serieRepository->findAll();
        dump($series);
        return $this->render('serie/list.html.twig', [
            "series" => $series
        ]);
    }

    #[Route('/{id}', name: 'show', requirements : ["id" => "\d+"])]
    public function show(int $id): Response
    {
        dump($id);
        return $this->render('serie/show.html.twig');
    }

    #[Route('/add', name: 'add')]
    public function add(EntityManagerInterface $entityManager, SerieRepository $repository): Response
    {
        return $this->render('serie/add.html.twig');
    }

}
