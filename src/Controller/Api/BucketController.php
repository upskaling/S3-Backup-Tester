<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Entity\Bucket;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BucketController extends AbstractController
{
    #[Route('/api/v1/bucket/{id}', name: 'app_api_bucket')]
    public function index(
        Bucket $bucket
    ): Response {
        return $this->json($bucket->getStatus());
    }
}
