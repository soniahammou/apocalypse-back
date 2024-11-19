<?php

namespace App\Controller\Api\V1;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Service\EntityNotFound;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/api/v1/', name: 'app_api_user_', format: 'json')]
class UserController extends AbstractController
{
    private $entityNotFound;

    public function __construct(EntityNotFound $entityNotFound)
    {
        $this->entityNotFound = $entityNotFound;
    }

    #[Route('user', name: 'browse', methods: 'GET')]
    public function browse(UserRepository $userRepository, Request $request): JsonResponse
    {

        $user = $userRepository->findAll();

        return $this->json($user, JsonResponse::HTTP_OK, [], ['groups' => User::DEFAULT_SERIALIZATION_GROUP]);
    }

    #[Route('user/{id<\d+>}',  name: 'read', methods: 'GET')]
    public function read(int $id, UserRepository $userRepository, Request $request): JsonResponse
    {
        $user = $userRepository->find($id);

        if (is_null($user)) {
            return $this->entityNotFound->objectNotFound('user');
        }

        return $this->json($user, JsonResponse::HTTP_OK, [], ['groups' => User::DEFAULT_SERIALIZATION_GROUP]);
    }

    #[Route('user', name: 'add', methods: 'POST')]
    public function add(EntityManagerInterface $em, Request $request, SerializerInterface $serializer, ValidatorInterface $validator): JsonResponse
    {
        // on récupère le json fourni dans la requete HTTP
        $json = $request->getContent();

        // on rempli notre objet avec les informations du json
        $user = $serializer->deserialize($json, User::class, "json");

        // on valide les données recues
        $errors = $validator->validate($user);

        if (count($errors) > 0) {
            $data = [
                'success' => false,
                'errors' => (string) $errors,
            ];

            return $this->json($data, Response::HTTP_BAD_REQUEST);
        }

        $em->persist($user);
        $em->flush();

        return $this->json($user, Response::HTTP_OK, [], ['groups' => User::DEFAULT_SERIALIZATION_GROUP]);
    }
    #[Route('user/{id<\d+>}',  name: 'edit', methods: 'PUT')]
    public function edit(int $id, ValidatorInterface $validator, SerializerInterface $serializer, EntityManagerInterface $em, UserRepository $userRepository, Request $request): JsonResponse
    {
        $user = $userRepository->find($id);

        if (is_null($user)) {
            return $this->entityNotFound->objectNotFound('user');
        } 
        
        $json = $request->getContent();
        $serializer->deserialize($json, User::class, "json", [AbstractNormalizer::OBJECT_TO_POPULATE => $user]);

        $errors = $validator->validate($user);

        if (count($errors) > 0) {
            $data = [
                'success' => false,
                'errors' => (string) $errors,
            ];

            return $this->json($data, Response::HTTP_BAD_REQUEST);
        }
        $em->persist($user);
        $em->flush();

        return $this->json($user, JsonResponse::HTTP_OK, [], ['groups' => User::DEFAULT_SERIALIZATION_GROUP]);
    }


    #[Route('user/{id<\d+>}', name: 'delete', methods: 'DELETE')]
    public function delete(int $id, UserRepository $userRepository, EntityManagerInterface $em): JsonResponse
    {

        $user = $userRepository->find($id);

        if (is_null($user)) {
            return $this->entityNotFound->objectNotFound('user');
        }
        $em->remove($user);
        $em->flush();

        $data = [
            "success" => true,
            "message" => "user deleted",
        ];

        return $this->json($data);
    }


    

}
