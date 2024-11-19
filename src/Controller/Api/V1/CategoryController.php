<?php

namespace App\Controller\Api\V1;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use App\Service\EntityNotFound;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\MakerBundle\Validator;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/api/v1/', name: 'app_api_category_', format: 'json')]
class CategoryController extends AbstractController
{
    private $entityNotFound;

    public function __construct(EntityNotFound $entityNotFound)
    {
        $this->entityNotFound = $entityNotFound;
    }


    #[Route('category', name: 'browse', methods: 'GET')]
    public function browse(CategoryRepository $categoryRepository): JsonResponse
    {

        $categorie = $categoryRepository->findAll();

        return $this->json($categorie, Response::HTTP_OK, [], ["groups" => Category::DEFAULT_SERIALIZATION_GROUP]);
    }

    #[Route('category/{id<\d+>}', name: 'read', methods: 'GET')]
    public function read(int $id, CategoryRepository $categoryRepository): JsonResponse
    {
        $categorie = $categoryRepository->find($id);

        if (is_null($categorie)) {
            return $this->entityNotFound->objectNotFound('category');
        }

        return $this->json($categorie, Response::HTTP_OK, [], ["groups" => Category::DEFAULT_SERIALIZATION_GROUP]);

    }

    #[Route('category', name: 'add', methods: 'POST')]
    public function add(EntityManagerInterface $em, Request $request, SerializerInterface $serializer, ValidatorInterface $validator): JsonResponse
    {
        // on récupère le json fourni dans la requete HTTP
        $json = $request->getContent();

        // on rempli notre objet avec les informations du json
        $category = $serializer->deserialize($json, Category::class, "json");

        // on valide les données recues
        $errors = $validator->validate($category);

        if (count($errors) > 0) {
            $data = [
                'success' => false,
                'errors' => (string) $errors,
            ];

            return $this->json($data, Response::HTTP_BAD_REQUEST);
        }

        $em->persist($category);
        $em->flush();

        return $this->json($category, Response::HTTP_OK, [], ['groups' => Category::DEFAULT_SERIALIZATION_GROUP]);
    }


    #[Route('category/{id<\d+>}', name: 'edit', methods: 'PUT')]
    public function edit(int $id, CategoryRepository $categoryRepository, Request $request, SerializerInterface $serializer, 
    ValidatorInterface $validator, EntityManagerInterface $em): JsonResponse
    { 
        $categorie = $categoryRepository->find($id);

        if (is_null($categorie)) {
            return $this->entityNotFound->objectNotFound('category');
        }

        $json = $request->getContent();
        $serializer->deserialize($json, Category::class, "json", [AbstractNormalizer::OBJECT_TO_POPULATE => $categorie]);

        $errors = $validator->validate($categorie);

        if (count($errors) > 0) {
            $data = [
                'success' => false,
                'errors' => (string) $errors,
            ];

            return $this->json($data, Response::HTTP_BAD_REQUEST);
        }
        $em->persist($categorie);
        $em->flush();

        return $this->json($categorie, Response::HTTP_OK, [], ["groups" => Category::DEFAULT_SERIALIZATION_GROUP]);

    }

    #[Route('category/{id<\d+>}', name: 'delete', methods: 'DELETE')]
    public function delete(int $id, CategoryRepository $categoryRepository, EntityManagerInterface $em): JsonResponse
    {

        $categorie = $categoryRepository->find($id);

        if (is_null($categorie)) {
            return $this->entityNotFound->objectNotFound('categorie');
        }
        $em->remove($categorie);
        $em->flush();

        $data = [
            "success" => true,
            "message" => "categorie deleted",
        ];

        return $this->json($data);
    }


}