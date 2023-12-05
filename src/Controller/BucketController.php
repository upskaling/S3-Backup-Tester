<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Bucket;
use App\Form\BucketType;
use App\Repository\BucketRepository;
use Aws\S3\S3Client;
use Doctrine\ORM\EntityManagerInterface;
use League\Flysystem\AwsS3V3\AwsS3V3Adapter;
use League\Flysystem\Filesystem;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/bucket')]
class BucketController extends AbstractController
{
    #[Route('/', name: 'app_bucket_index', methods: ['GET'])]
    public function index(BucketRepository $bucketRepository): Response
    {
        return $this->render('bucket/index.html.twig', [
            'buckets' => $bucketRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_bucket_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $bucket = new Bucket();
        $form = $this->createForm(BucketType::class, $bucket);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($bucket);
            $entityManager->flush();

            return $this->redirectToRoute('app_bucket_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('bucket/new.html.twig', [
            'bucket' => $bucket,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_bucket_show', methods: ['GET'])]
    public function show(Bucket $bucket): Response
    {
        $options = [
            'version' => 'latest',
            'endpoint' => $bucket->getEndpoint(),
            'region' => $bucket->getRegion(),
            'credentials' => [
                'key' => $bucket->getCredentialsKey(),
                'secret' => $bucket->getCredentialsSecret(),
            ],
        ];
        $client = new S3Client($options);

        $adapter = new AwsS3V3Adapter(
            // S3Client
            $client,
            // Bucket name
            $bucket->getName()
        );

        $filesystem = new Filesystem($adapter);

        return $this->render('bucket/show.html.twig', [
            'bucket' => $bucket,
            'list_contents' => $filesystem->listContents('/', true),
        ]);
    }

    #[Route('/{id}/edit', name: 'app_bucket_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Bucket $bucket, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(BucketType::class, $bucket);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_bucket_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('bucket/edit.html.twig', [
            'bucket' => $bucket,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_bucket_delete', methods: ['POST'])]
    public function delete(Request $request, Bucket $bucket, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$bucket->getId(), $request->request->get('_token'))) {
            $entityManager->remove($bucket);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_bucket_index', [], Response::HTTP_SEE_OTHER);
    }
}
