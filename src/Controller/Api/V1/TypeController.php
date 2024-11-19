<?php

namespace App\Controller\Api\V1;

use App\Entity\Type;
use App\Repository\TypeRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('api/v1/', name: 'app_api_type_')]
class TypeController extends AbstractController
{
    #[Route('type', name: 'browse', methods: ['GET'])]
    public function index(TypeRepository $typeRepository): JsonResponse
    {
        return $this->json($typeRepository->findAll(), 200, [], ['groups' => Type::DEFAULT_SERIALIZATION_GROUP]);
    }

    #[Route('type/{id<\d+>}', name: 'read', methods: ['GET'])]
    public function read(TypeRepository $typeRepository, int $id): JsonResponse
    {
        $type = $typeRepository->find($id);

        if (!$type) {
            throw $this->createNotFoundException('Type does not exist');
        }

        return $this->json($type, 200, [], ['groups' => Type::DEFAULT_SERIALIZATION_GROUP]);
    }

    #[Route('type/{id<\d+>}', name: 'edit', methods: ['PUT'])]
    public function edit(TypeRepository $typeRepository, int $id, EntityManagerInterface $entityManager, Request $request, SerializerInterface $serializer, ValidatorInterface $validator): JsonResponse
    {
        $type = $typeRepository->find($id);

        if (!$type) {
            throw $this->createNotFoundException('Type does not exist');
        }

        $editInJson = $request->getContent();

        $serializer->deserialize($editInJson, Type::class, 'json', [AbstractNormalizer::OBJECT_TO_POPULATE => $type]);

        $errors = $validator->validate($type);

        if (count($errors) > 0) {
            return $this->json($errors, 400);
        }

        $entityManager->flush();

        return $this->json($type, 200, [], ['groups' => Type::DEFAULT_SERIALIZATION_GROUP]);
    }

    #[Route('type', name: 'add', methods: ['POST'])]
    public function add(Request $request, SerializerInterface $serializer, EntityManagerInterface $entityManager): JsonResponse
    {
        // get the input from the user (in json format)
        $newTypeInJson = $request->getContent();

        // deserialize it in order to process it
        $newType = $serializer->deserialize($newTypeInJson, Type::class, 'json');

        // persist the type into the database
        $entityManager->persist($newType);

        $entityManager->flush();

        return $this->json($newType, 201, [], ['groups' => Type::DEFAULT_SERIALIZATION_GROUP]);
    }

    #[Route('type/{id<\d+>}', name: 'delete', methods: ['DELETE'])]
    public function delete(TypeRepository $typeRepository, int $id, EntityManagerInterface $entityManager): JsonResponse
    {
        // get the type to delete by the id in the url
        $type = $typeRepository->find($id);

        // handle the case where the type doesn't exist
        if (!$type) {
            throw $this->createNotFoundException('Type not found');
        }

        // delete the type from the database
        $entityManager->remove($type);
        $entityManager->flush();

        // return the success message and http status
        return $this->json('Type successfully deleted', 200);
    }

}
