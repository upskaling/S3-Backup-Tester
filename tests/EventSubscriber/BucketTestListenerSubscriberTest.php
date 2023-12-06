<?php

declare(strict_types=1);

namespace App\Tests\EventSubscriber;

use App\Entity\Bucket;
use App\Entity\BucketTest;
use App\Entity\Incident;
use App\Event\BucketTestEvent;
use App\EventSubscriber\BucketTestListenerSubscriber;
use App\Factory\IncidentFactory;
use App\Repository\IncidentRepository;
use Doctrine\ORM\EntityManagerInterface;
use League\Flysystem\StorageAttributes;
use PHPUnit\Framework\TestCase;

class BucketTestListenerSubscriberTest extends TestCase
{
    public function testOnBucketTestEvent(): void
    {
        $incidentFactory = $this->createMock(IncidentFactory::class);
        $incidentFactory->expects($this->once())
            ->method('create')
            ->willReturn(new Incident());

        $incidentRepository = $this->createMock(IncidentRepository::class);
        $entityManager = $this->createMock(EntityManagerInterface::class);
        $entityManager->expects($this->once())
            ->method('persist')
            ->willReturnCallback(
                function ($incident) {
                    $this->assertSame(Incident::STATUS_DOWN, $incident->getStatus());

                    return $incident;
                }
            );

        $subscriber = new BucketTestListenerSubscriber($incidentFactory, $incidentRepository, $entityManager);

        $bucketTest = $this->createMock(BucketTest::class);
        $bucketTest->expects($this->once())
            ->method('getBucket')
            ->willReturn(new Bucket());

        $event = new BucketTestEvent(
            $bucketTest,
            $this->createMock(StorageAttributes::class),
            true
        );

        $subscriber->onBucketTestEvent($event);
    }

    public function testOnBucketTest2Event(): void
    {
        $incidentFactory = $this->createMock(IncidentFactory::class);
        $incidentFactory->expects($this->once())
            ->method('create')
            ->willReturn(new Incident());

        $incidentRepository = $this->createMock(IncidentRepository::class);
        $entityManager = $this->createMock(EntityManagerInterface::class);
        $entityManager->expects($this->once())
            ->method('persist')
            ->willReturnCallback(
                function ($incident) {
                    $this->assertSame(Incident::STATUS_UP, $incident->getStatus());

                    return $incident;
                }
            );

        $subscriber = new BucketTestListenerSubscriber($incidentFactory, $incidentRepository, $entityManager);

        $bucketTest = $this->createMock(BucketTest::class);
        $bucketTest->expects($this->once())
            ->method('getBucket')
            ->willReturn(new Bucket());

        $event = new BucketTestEvent(
            $bucketTest,
            $this->createMock(StorageAttributes::class),
            false
        );

        $subscriber->onBucketTestEvent($event);
    }

    public function testOnBucketTest3Event(): void
    {
        $incidentFactory = $this->createMock(IncidentFactory::class);
        $incidentFactory->expects($this->once())
            ->method('create')
            ->willReturn(new Incident());

        $incidentOld = new Incident();
        $incidentOld->setStatus(Incident::STATUS_DOWN);
        $incidentRepository = $this->createMock(IncidentRepository::class);
        $incidentRepository->expects($this->once())
            ->method('OldIncident')
            ->willReturn($incidentOld);
        $entityManager = $this->createMock(EntityManagerInterface::class);

        $subscriber = new BucketTestListenerSubscriber($incidentFactory, $incidentRepository, $entityManager);

        $bucketTest = $this->createMock(BucketTest::class);
        $bucketTest->expects($this->once())
            ->method('getBucket')
            ->willReturn(new Bucket());

        $event = new BucketTestEvent(
            $bucketTest,
            $this->createMock(StorageAttributes::class),
            true
        );

        $subscriber->onBucketTestEvent($event);
    }
}
