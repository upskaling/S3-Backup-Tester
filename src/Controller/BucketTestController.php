<?php

declare(strict_types=1);

namespace App\Controller;

use App\Factory\BucketTestFactory;
use App\Form\BucketTestType;
use App\Repository\BucketRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BucketTestController extends AbstractController
{
    public function __construct(
        private readonly BucketRepository $bucketRepository,
        private readonly BucketTestFactory $bucketTestFactory,
    ) {
    }

    #[Route('bucket/test/{id}', name: 'app_bucket_test_add')]
    public function index(
        int $id,
        Request $request,
        EntityManagerInterface $entityManager,
    ): Response {
        $bucket = $this->bucketRepository->find($id);
        $bucketTest = $bucket->getBucketTests()->first();
        $bucketTest = $bucketTest ?: $this->bucketTestFactory->create($bucket);

        $form = $this->createForm(BucketTestType::class, $bucketTest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($bucketTest);
            $entityManager->flush();

            $this->addFlash('success', 'Bucket test saved!');

            return $this->redirectToRoute('app_bucket_test_add', ['id' => $id]);
        }

        return $this->render('bucket_test/index.html.twig', [
            'form' => $form,
            'bucket' => $bucket,
        ]);
    }
}
