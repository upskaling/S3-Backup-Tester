<?php

declare(strict_types=1);

namespace App\Controller;

use App\BucketFilesystem\BucketFilesystem;
use App\Entity\Bucket;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\Cache;
use Symfony\Component\Routing\Annotation\Route;

class InfoSFController extends AbstractController
{
    public function __construct(
        public readonly BucketFilesystem $bucketFilesystem,
    ) {
    }

    #[Route('/info/sf/{id}', name: 'app_info_sf')]
    #[Cache(expires: '2 minutes', public: true)]
    public function index(Bucket $bucket): Response
    {
        $filesystem = $this->bucketFilesystem->getFileSystem($bucket);

        $liste = [];
        $bucketTests = $bucket->getBucketTests()->first();
        if ($bucketTests) {
            $interval = $bucketTests->getInterval();
            $date = new \DateTime();
            $dateMax = $date->getTimestamp() - $interval;
        }
        $listContents = $filesystem->listContents('/', true);
        foreach ($listContents as $content) {
            $std = new \stdClass();
            $std->content = $content;
            $std->isOld = false;
            if ($bucketTests) {
                $std->isOld = $content->lastModified() < $dateMax;
            }
            $liste[] = $std;
        }

        return $this->render('info_sf/index.html.twig', [
            'bucket' => $bucket,
            'list_contents' => $liste,
        ]);
    }
}
