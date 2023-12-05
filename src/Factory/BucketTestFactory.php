<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\Bucket;
use App\Entity\BucketTest;

final class BucketTestFactory
{
    public function create(Bucket $bucket): BucketTest
    {
        $bucketTest = new BucketTest();
        $bucketTest->setBucket($bucket);

        return $bucketTest;
    }
}
