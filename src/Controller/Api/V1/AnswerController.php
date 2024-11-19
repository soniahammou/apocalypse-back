<?php

namespace App\Controller\Api\V1;

use App\Entity\Answer;
use App\Repository\AnswerRepository;
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

#[Route('/api/v1/', name: 'app_answer_', format:'json')]
class AnswerController extends AbstractController
{
    private $entityNotFound;

    public function __construct(EntityNotFound $entityNotFound)
    {
        $this->entityNotFound = $entityNotFound;
    }
    

    #[Route('answer', name: 'browse',methods: 'GET')]
    public function browse(AnswerRepository $answerRepository ): JsonResponse
    {
        $answers = $answerRepository->findAll();

        return $this->json($answers, Response::HTTP_OK,[],['groups'=>Answer::DEFAULT_SERIALIZATION_GROUP]);
    }

    #[Route('answer/{id<\d+>}', name: 'read', methods: 'GET')]
    public function read(int $id,AnswerRepository $answerRepository): JsonResponse
    {
        $answer = $answerRepository->find($id);

        if (is_null($answer)) {
            return $this->entityNotFound->objectNotFound('category');
        }

        return $this->json($answer, 200, [], ['groups' => Answer::DEFAULT_SERIALIZATION_GROUP]);
    }

    #[Route('answer', name: 'add', methods: 'POST')]
    public function add(EntityManagerInterface $em, Request $request, 
    SerializerInterface $serializer, ValidatorInterface $validator): JsonResponse
    {
        $json = $request->getContent();

        $answer = $serializer->deserialize($json, Answer::class, "json");

        $errors = $validator->validate($answer);

        if (count($errors) > 0) {
            $data = [
                'success' => false,
                'errors' => (string) $errors,
            ];

            return $this->json($data, Response::HTTP_BAD_REQUEST);
        }

        $em->persist($answer);
        $em->flush();

        return $this->json($answer, Response::HTTP_OK, [], ['groups' => Answer::DEFAULT_SERIALIZATION_GROUP]);
    }

    #[Route('answer/{id<\d+>', name: 'edit', methods: 'PUT')]
    public function edit(int $id, AnswerRepository $answerRepository,
    EntityManagerInterface $em, Request $request, 
    SerializerInterface $serializer, ValidatorInterface $validator): JsonResponse
    {
        $answer = $answerRepository->find($id);

        $json = $request->getContent();

        $serializer->deserialize($json, Answer::class, "json", [AbstractNormalizer::OBJECT_TO_POPULATE => $answer]);

        $errors = $validator->validate($answer);

        if (count($errors) > 0) {
            $data = [
                'success' => false,
                'errors' => (string) $errors,
            ];

            return $this->json($data, Response::HTTP_BAD_REQUEST);
        }

        $em->persist($answer);
        $em->flush();

        return $this->json($answer, Response::HTTP_OK, [], ['groups' => Answer::DEFAULT_SERIALIZATION_GROUP]);
    }

    #[Route('answer/{id<\d+>}', name: 'delete', methods: 'DELETE')]
    public function delete(int $id, AnswerRepository $answerRepository, EntityManagerInterface $em): JsonResponse
    {

        $answer = $answerRepository->find($id);

        if (is_null($answer)) {
            return $this->entityNotFound->objectNotFound('answer');
        }
        $em->remove($answer);
        $em->flush();

        $data = [
            "success" => true,
            "message" => "answer deleted",
        ];

        return $this->json($data);
    }


}
