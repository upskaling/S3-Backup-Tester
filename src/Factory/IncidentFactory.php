<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\Bucket;
use App\Entity\Incident;

class IncidentFactory
{
    public function create(
        Bucket $bucket,
        string $path,
    ): Incident {
        return (new Incident())
            ->setBucket($bucket)
            ->setCreatedAt(new \DateTimeImmutable())
            ->setMessage('')
            ->setPath($path);
    }
}
