<?php

declare(strict_types=1);

namespace App\Event;

use App\Entity\BucketTest;
use League\Flysystem\StorageAttributes;

class BucketTestEvent
{
    public function __construct(
        public readonly BucketTest $bucketTests,
        public readonly StorageAttributes $content,
        public readonly bool $isOld,
    ) {
    }
}
