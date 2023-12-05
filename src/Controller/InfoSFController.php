<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Bucket;
use Aws\S3\S3Client;
use League\Flysystem\AwsS3V3\AwsS3V3Adapter;
use League\Flysystem\Filesystem;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InfoSFController extends AbstractController
{
    #[Route('/info/sf/{id}', name: 'app_info_sf')]
    public function index(Bucket $bucket): Response
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

        $liste = [];
        $interval = $bucket->getBucketTests()->first()->getInterval();
        $listContents = $filesystem->listContents('/', true);
        $date = new \DateTime();
        $dateMax = $date->getTimestamp() - $interval;
        foreach ($listContents as $content) {
            $std = new \stdClass();
            $std->content = $content;
            $std->isOld = $content->lastModified() < $dateMax;
            $liste[] = $std;
        }

        return $this->render('info_sf/index.html.twig', [
            'bucket' => $bucket,
            'list_contents' => $liste,
        ]);
    }
}
