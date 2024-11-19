<?php

namespace App\Controller\Api\V1;

use App\Entity\User;
use App\Service\MailerService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class SecurityController extends AbstractController
{
    private UserPasswordHasherInterface $hasher;
    private MailerService $mailerService;

    public function __construct(UserPasswordHasherInterface $hasher, MailerService $mailerService)
    {
        $this->hasher = $hasher;
        $this->mailerService = $mailerService;
    }

    /**
     * @param EntityManagerInterface $em
     * @param Request $request
     * @param SerializerInterface $serializer
     * @param ValidatorInterface $validator
     * @return JsonResponse
     *
     * Gets the data from the registration form and creates a new user from it
     */
    #[Route(path: 'api/v1/signin', name: 'app_signin', methods: ['POST'])]
    public function signin(EntityManagerInterface $em,
                           Request $request,
                           SerializerInterface $serializer,
                           ValidatorInterface $validator): JsonResponse
    {
        // get the json from the HTTP request, deserialize it and create a user object with it
        $json = $request->getContent();

        $user = $serializer->deserialize($json, User::class, "json");

        // check if the data is valid and exit if it's not
        $errors = $validator->validate($user);
        if (count($errors) > 0) {
            $data = [
                'success' => false,
                'errors' => (string) $errors,
            ];
            return $this->json($data, Response::HTTP_BAD_REQUEST);
        }

        // hash and set the password then set the role to "user" before persist and flush
        $password = $user->getPassword();
        $hashedPassword = $this->hasher->hashPassword($user, $password);
        $user->setPassword($hashedPassword);
        $user->setRoles(['ROLE_USER']);

        $em->persist($user);
        $em->flush();

        // send the welcome message with the mailer
        $emailUser = $user->getEmail();
        $firstname = $user->getFirstname();
        $lastname = $user->getLastname();
        $this->mailerService->sendWelcomeMessage($emailUser, $firstname, $lastname);

        return $this->json($user, Response::HTTP_OK, [], ['groups' => User::DEFAULT_SERIALIZATION_GROUP]);
    }

    #[Route(path: 'api/v1/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This should never be reached!');
    }
}
