<?php

namespace App\Controller;

use App\Entity\Serie;
use App\Form\SerieType;
use App\Repository\SerieRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/series', name: 'serie_')]
class SerieController extends AbstractController
{
    #[Route('/{page}', name: 'list', requirements : ["page" => "\d+"])]
    public function list(SerieRepository $serieRepository, int $page = 1): Response
    {

        $nbSeries = $serieRepository->count([]);
        $maxPage = ceil($nbSeries / Serie::MAX_RESULT);

        if ($page < 1){
            return $this->redirectToRoute('serie_list');
        } else if ($page > $maxPage){
            return $this->redirectToRoute('serie_list', ['page' => $maxPage]);
        } else {
            $series = $serieRepository->findSeriesWithPagination($page);
            return $this->render('serie/list.html.twig', [
                "series" => $series,
                "currentPage" => $page,
                "maxPage" => $maxPage
            ]);
        }
    }

    #[Route('/detail/{id}', name: 'show', requirements : ["id" => "\d+"])]
    public function show(int $id, SerieRepository $serieRepository): Response
    {

        $serie = $serieRepository -> find($id);

        if (!$serie){
            throw $this->createNotFoundException('Oops... not found.');
        }

        return $this->render('serie/show.html.twig', [
            'serie' => $serie
        ]);
    }

    #[IsGranted('ROLE_USER')]
    #[Route('/add', name: 'add')]
    public function add(Request $request, SerieRepository $repository): Response
    {

        $newSeries = new Serie();
        $seriesForm = $this->createForm(SerieType::class, $newSeries);

        $seriesForm->handleRequest($request);

        if ($seriesForm->isSubmitted()){
            dump($newSeries);
            $genres = $seriesForm->get('genres')->getData();
            $newSeries->setGenres(implode('/', $genres));
            $newSeries->setDateCreated(new \DateTime());

            $repository->save($newSeries, true);

            $this->addFlash('success', 'Your show has been added !');
            return $this->redirectToRoute('serie_show', ['id' => $newSeries->getId()]);

        }

        return $this->render('serie/add.html.twig', [
            'seriesForm' => $seriesForm->createView()
        ]);
    }

    #[Route('/update/{id}', name:'update', requirements:["id" => "\d+"])]
    public function edit(int $id, SerieRepository $repository)
    {
        $series = $repository->find($id);
        $seriesForm = $this->createForm(SerieType::class, $series);

        return $this->render('serie/update.html.twig', [
            'seriesForm' => $seriesForm->createView()
        ]);

    }

    #[Route('/delete/{id}', name:'delete', requirements:["id" => "\d+"])]
    public function delete(int $id, SerieRepository $repository){
        $serie = $repository->find($id);
        $repository->remove($serie, true);

        $this->addFlash('success', $serie->getName() . " has been removed.");
        return $this->redirectToRoute('main_home');
    }

}
