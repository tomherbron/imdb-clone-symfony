<?php

namespace App\Controller;

use App\Entity\Season;
use App\Form\SeasonType;
use App\Repository\SeasonRepository;
use App\Repository\SerieRepository;
use App\Utils\Uploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/season', name:'season_')]
class SeasonController extends AbstractController
{
    #[Route('/add/{id}', name: 'add', requirements: ['id' => '\d+'])]
    public function add(SeasonRepository $repository, SerieRepository $serieRepository, Request $request, int $id, Uploader $uploader): Response
    {

        $serie = $serieRepository->find($id);
        $season = new Season();
        $season->setSerie($serie);
        $seasonForm = $this->createForm(SeasonType::class, $season);

        $seasonForm->handleRequest($request);

        if ($seasonForm->isSubmitted() && $seasonForm->isValid()){

            $file = $seasonForm->get('poster')->getData();

            if ($file){
                /**
                 * @var UploadedFile $file
                 */

               $newFileName = $uploader->save($file,
                    $season->getSerie()->getName(). "-" .$season->getNumber(),
                    $this->getParameter('upload_season_poster'));

               $season->setPoster($newFileName);

            }

            $repository->save($season, true);
            $this->addFlash('success', 'Season added on '. $season->getSerie()->getName());
            return $this->redirectToRoute('serie_show', ['id' => $season->getSerie()->getId()]);

        }

        return $this->render('season/add.html.twig', [
            'seasonform' => $seasonForm->createView()
        ]);
    }

}
