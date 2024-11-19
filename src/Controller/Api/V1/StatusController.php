<?php

namespace App\Controller\Api\V1;

use App\Entity\Status;
use App\Repository\StatusRepository;
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

#[Route('/api/v1/', name: 'app_api_status_', format: 'json')]

class StatusController extends AbstractController
{
    private $entityNotFound;

    public function __construct(EntityNotFound $entityNotFound)
    {
        $this->entityNotFound = $entityNotFound;
    }

    #[Route('status', name: 'browse', methods: 'GET')]
    public function browse(StatusRepository $statusRepository): JsonResponse
    {
        $statusList = $statusRepository->findAll();

        return $this->json($statusList, Response::HTTP_OK, [], ['groups' => Status::DEFAULT_SERIALIZATION_GROUP]);
    }


    #[Route('status/{id<\d+>}', name: 'read', methods: 'GET')]
    public function read(Status $status): JsonResponse
    {

        return $this->json($status, Response::HTTP_OK, [], ['groups' => Status::DEFAULT_SERIALIZATION_GROUP]);
    }


    #[Route('status', name: 'add', methods: 'POST')]
    public function add(
        Request $request,
        SerializerInterface $serializer,
        EntityManagerInterface $em,
        ValidatorInterface $validator
    ): JsonResponse {
        //1 je recupere le tableau de creation de status
        $json = $request->getContent();

        // je deserealise le contenu json
        $status = $serializer->deserialize($json, Status::class, "json");
        $errors = $validator->validate($status);

        if (count($errors) > 0) {
            $data = [
                'success' => false,
                'errors' => (string) $errors,
            ];

            return $this->json($data, Response::HTTP_BAD_REQUEST);
        }

        $em->persist($status);
        $em->flush();

        return $this->json($status, Response::HTTP_OK, [], ['groups' => Status::DEFAULT_SERIALIZATION_GROUP]);
    }


    #[Route('status/{id<\d+>}', name: 'edit', methods: 'PUT')]
    public function edit( int $id, StatusRepository $statusRepository,
        Request $request,
        SerializerInterface $serializer,
        ValidatorInterface $validator,
        EntityManagerInterface $em
    ): JsonResponse {

        $status = $statusRepository->find($id);

        //404 error
        if (is_null($status)) {
            return $this->entityNotFound->objectNotFound('status');
        }

        // recupere le contenu requete
        $json = $request->getContent();

        // je deserealise ce contenu 
        $serializer->deserialize($json, Status::class, 'json', [AbstractNormalizer::OBJECT_TO_POPULATE => $status]);

        $errors = $validator->validate($status);

        if (count($errors) > 0) {
            $data = [
                'success' => false,
                'errors' => (string) $errors,
            ];

            return $this->json($data, Response::HTTP_BAD_REQUEST);
        }
        $em->persist($status);
        $em->flush();
        return $this->json($status, Response::HTTP_OK, [], ['groups' => Status::DEFAULT_SERIALIZATION_GROUP]);
    }

    #[Route('status/{id<\d+>}', name: 'delete', methods: 'DELETE')]
    public function delete(int $id, StatusRepository $statusRepository, EntityManagerInterface $em): JsonResponse
    {

        $status = $statusRepository->find($id);

        if (is_null($status)) {
            return $this->entityNotFound->objectNotFound('status');
        }
        $em->remove($status);
        $em->flush();

        $data = [
            "success" => true,
            "message" => "status deleted",
        ];


        return $this->json([]);
    }
}
