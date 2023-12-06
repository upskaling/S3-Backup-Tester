<?php

declare(strict_types=1);

namespace App\MessageHandler;

use App\BucketFilesystem\BucketFilesystem;
use App\Entity\Bucket;
use App\Event\BucketTestEvent;
use App\Message\CheckBucketMessage;
use App\Repository\BucketRepository;
use Psr\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class CheckBucketMessageHandler
{
    public function __construct(
        private readonly BucketRepository $bucketRepository,
        private readonly BucketFilesystem $bucketFilesystem,
        private readonly EventDispatcherInterface $eventDispatcher,
    ) {
    }

    public function __invoke(CheckBucketMessage $message): void
    {
        $buckets = $this->bucketRepository->findAll();
        foreach ($buckets as $bucket) {
            $this->checkBucket($bucket);
        }
    }

    private function checkBucket(Bucket $bucket): void
    {
        $filesystem = $this->bucketFilesystem->getFileSystem($bucket);
        $bucketTests = $bucket->getBucketTests()->first();
        if ($bucketTests) {
            $interval = $bucketTests->getInterval();
            $date = new \DateTime();
            $dateMax = $date->getTimestamp() - $interval;
        }

        $liste = [];
        $listContents = $filesystem->listContents('/', true);

        foreach ($listContents as $content) {
            $std = new \stdClass();
            $std->isOld = false;
            if ($bucketTests) {
                $std->isOld = $content->lastModified() < $dateMax;
            }
            $this->eventDispatcher->dispatch(new BucketTestEvent($bucketTests, $content, $std->isOld));
            $liste[] = $std;
        }
    }
}
