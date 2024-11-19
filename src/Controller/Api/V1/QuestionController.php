<?php

namespace App\Controller\Api\V1;

use App\Entity\Question;
use App\Repository\QuestionRepository;
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

#[Route('/api/v1/', name: 'app_api_question_', format: 'json')]
class QuestionController extends AbstractController
{

    
    private $entityNotFound;

    public function __construct(EntityNotFound $entityNotFound)
    {
        $this->entityNotFound = $entityNotFound;
    }


    #[Route('question', name: 'browse', methods: 'GET')]
    public function browse(QuestionRepository $questionRepository): JsonResponse
    {

        $questionList = $questionRepository->findAll();

        return $this->json($questionList, 200, [], ['groups' => Question::DEFAULT_SERIALIZATION_GROUP]);
    }

    #[Route('question/{id<\d+>}', name: 'read', methods: 'GET')]
    public function read(int $id, QuestionRepository $questionRepository): JsonResponse
    {
        $question = $questionRepository->find($id);

        if (is_null($question)) {
            return $this->entityNotFound->objectNotFound('question');
        }

        return $this->json($question, 200, [], ['groups' => Question::DEFAULT_SERIALIZATION_GROUP]);
    }

    #[Route('question', name: 'add', methods: 'POST')]
    public function add(EntityManagerInterface $em, Request $request, SerializerInterface $serializer, ValidatorInterface $validator): JsonResponse
    {
        // on récupère le json fourni dans la requete HTTP
        $json = $request->getContent();

        // on rempli notre objet avec les informations du json
        $question = $serializer->deserialize($json, Question::class, "json");

        // on valide les données recues
        $errors = $validator->validate($question);

        if (count($errors) > 0) {
            $data = [
                'success' => false,
                'errors' => (string) $errors,
            ];

            return $this->json($data, Response::HTTP_BAD_REQUEST);
        }

        $em->persist($question);
        $em->flush();

        return $this->json($question, Response::HTTP_OK, [], ['groups' => Question::DEFAULT_SERIALIZATION_GROUP]);
    }


    #[Route('question/{id<\d+>}', name: 'edit', methods: 'PUT')]
    public function edit(
        int $id,
        QuestionRepository $questionRepository,
        EntityManagerInterface $em,
        Request $request,
        SerializerInterface $serializer,
        ValidatorInterface $validator
    ): JsonResponse {

        $question = $questionRepository->find($id);

       //404 error
        if (is_null($question)) {
            return $this->entityNotFound->objectNotFound('question');

        }

        // on récupère le json fourni dans la requete HTTP
        $json = $request->getContent();

        // on rempli notre objet avec les informations du json
        $serializer->deserialize($json, Question::class, "json", [AbstractNormalizer::OBJECT_TO_POPULATE => $question]);

        // on valide les données recues
        $errors = $validator->validate($question);

        if (count($errors) > 0) {
            $data = [
                'success' => false,
                'errors' => (string) $errors,
            ];

            return $this->json($data, Response::HTTP_BAD_REQUEST);
        }

        $em->persist($question);
        $em->flush();

        return $this->json($question, Response::HTTP_OK, [], ['groups' => Question::DEFAULT_SERIALIZATION_GROUP]);
    }

    #[Route('question/{id<\d+>}', name: 'delete', methods: 'DELETE')]
    public function delete(int $id, QuestionRepository $questionRepository, EntityManagerInterface $em): JsonResponse
    {

        $question = $questionRepository->find($id);

        if (is_null($question)) {
            return $this->entityNotFound->objectNotFound('question');
        }
        $em->remove($question);
        $em->flush();

        $data = [
            "success" => true,
            "message" => "question deleted",
        ];

        return $this->json($data);
    }




    
}
