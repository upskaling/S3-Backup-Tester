<?php

declare(strict_types=1);

namespace App\BucketFilesystem;

use App\Entity\Bucket;
use Aws\S3\S3Client;
use League\Flysystem\AwsS3V3\AwsS3V3Adapter;
use League\Flysystem\Filesystem;

final class BucketFilesystem
{
    public function getFileSystem(Bucket $bucket): Filesystem
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
            $client,
            $bucket->getName()
        );

        return new Filesystem($adapter);
    }
}
