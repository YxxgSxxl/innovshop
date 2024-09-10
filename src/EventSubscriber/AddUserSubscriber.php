<?php

namespace App\EventSubscriber;

use App\Entity\Post;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class AddUserSubscriber implements EventSubscriberInterface
{
    public function __construct(private Security $security)
    {

    }

    public static function getSubscribedEvents()
    {
        return [
            BeforeEntityPersistedEvent::class => 'AddUser',
        ];
    }

    public function AddUser(BeforeEntityPersistedEvent $event)
    {
        $entity = $event->getEntityInstance();

        if($entity instanceof Post) {
            $user = $this->security->getUser();
            $entity->setAuthor($user);
        } else {
            return;
        }
    }
}