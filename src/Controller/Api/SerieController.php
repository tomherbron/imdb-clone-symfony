<?php

namespace App\Controller\Api;

use App\Repository\SerieRepository;
use phpDocumentor\Reflection\Types\Boolean;
use phpDocumentor\Reflection\Types\This;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/series', name: 'api_series_')]
class SerieController extends AbstractController
{
    #[Route('', name: 'retrieve_all', methods: ['GET'])]
    public function retrieveAll(SerieRepository $repository): Response
    {
        $series = $repository->findAll();
        return $this->json($series, 200, [], ['groups' => 'series_data']);
    }

    #[Route('', name: 'add_one', methods: ['POST'])]
    public function addOne(): Response
    {


    }

    #[Route('/{id}', name: 'retrieve_one', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function retrieveOne(int $id): Response
    {


    }

    #[Route('/{id}', name: 'delete_one', methods: ['DELETE'])]
    public function deleteOne(int $id): Response
    {


    }

    #[Route('/{id}', name: 'update_one', requirements: ['id' => '\d+'], methods: ['PUT'])]
    public function updateOne(int $id, Request $request, SerieRepository $repository): Response
    {
        $series = $repository->find($id);

        if ($series){

            $data = json_decode($request->getContent());
            if ($data->value){
                $series->setNbLike($series->getNbLike() + 1);
            } else {
                $series->setNbLike($series->getNbLike() - 1);
            }
            $repository->save($series,true);
            return $this->json(['nbLike' => $series->getNbLike()]);
        }


        return $this->json(['error' => 'seriesNotFound']);
    }
}
