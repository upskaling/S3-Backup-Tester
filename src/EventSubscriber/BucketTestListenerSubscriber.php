<?php

declare(strict_types=1);

namespace App\EventSubscriber;

use App\Event\BucketTestEvent;
use App\Factory\IncidentFactory;
use App\Repository\IncidentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class BucketTestListenerSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private readonly IncidentFactory $incidentFactory,
        private readonly IncidentRepository $incidentRepository,
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    public function onBucketTestEvent(BucketTestEvent $event): void
    {
        $bucket = $event->bucketTests->getBucket();
        $path = $event->content->path();
        $incident = $this->incidentFactory->create(
            $bucket,
            $path,
        );
        $incident->setStatus($event->isOld ? 'Down' : 'Up');

        $incidentOld = $this->incidentRepository->OldIncident(
            $bucket,
            $path
        );

        if (!$incidentOld) {
            $this->entityManager->persist($incident);
            $this->entityManager->flush();

            return;
        }

        if ($incident->getStatus() === $incidentOld->getStatus()) {
            return;
        }

        $incident->setStatus('Up' === $incident->getStatus() ? 'Down' : 'Up');
        $incident->setMessage(
            'Up' === $incident->getStatus() ?
                'Le fichier '.$path.' et dans une plage de temps valide' :
                'Le fichier '.$path.' est trop vieux'
        );
        $this->entityManager->persist($incident);
        $this->entityManager->flush();
    }

    public static function getSubscribedEvents(): array
    {
        return [
            BucketTestEvent::class => 'onBucketTestEvent',
        ];
    }
}
