<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Bucket;
use App\Repository\IncidentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BucketIncidentsController extends AbstractController
{
    #[Route('/bucket/{id}/incidents', name: 'app_bucket_incidents_sf', methods: ['GET'])]
    public function index(Bucket $bucket, IncidentRepository $incidentRepository): Response
    {
        return $this->render('bucket_incidents/index.html.twig', [
            'incidents' => $incidentRepository->findBy(['bucket' => $bucket]),
        ]);
    }
}
