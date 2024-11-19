<?php
namespace App\EventListener;

use Doctrine\Common\EventSubscriber;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Symfony\Component\Security\Core\User\UserInterface;

class AuthenticationSuccessListener
{
    public function onAuthenticationSuccessResponse(AuthenticationSuccessEvent $event)
    {
        $data = $event->getData();
        $user = $event->getUser();

        // TODO demander à Greg si cette condition est vraiment utile
        if (!$user instanceof UserInterface) {
            return;
        }

        $data['data'] = array(
            'roles' => $user->getRoles(),
            'firstname' => $user->getFirstName(),
            'lastname' => $user->getLastName(),
            'id' => $user->getId(),
        );

        $event->setData($data);

    }

}
