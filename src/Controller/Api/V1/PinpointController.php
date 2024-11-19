<?php

namespace App\Controller\Api\V1;

use App\Entity\Pinpoint;
use App\Repository\PinpointRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/api/v1/', name: 'app_api_pinpoint_')]
class PinpointController extends AbstractController
{
    #[Route('pinpoint', name: 'browse', methods: ['GET'])]
    public function browse(PinpointRepository $pinpointRepository): JsonResponse
    {
        return $this->json($pinpointRepository->findAll(), 200, [], ['groups' => Pinpoint::DEFAULT_SERIALIZATION_GROUP]);
    }

    #[Route('pinpoint/{id<\d+>}', name: 'read', methods: ['GET'])]
    public function read(PinpointRepository $pinpointRepository, int $id): JsonResponse
    {
        // get the pinpoint to read by the id in the url
        $pinpoint = $pinpointRepository->find($id);

        // handle the case where the pinpoint doesn't exist
        if (!$pinpoint) {
            throw $this->createNotFoundException('Pinpoint not found');
        }

        // return the data from the pinpoint and its type
        return $this->json($pinpoint, 200, [], ['groups' => Pinpoint::DEFAULT_SERIALIZATION_GROUP]);
    }

    #[Route('pinpoint', name: 'add', methods: ['POST'])]
    public function add(Request $request, SerializerInterface $serializer, EntityManagerInterface $entityManager, ValidatorInterface $validator): JsonResponse
    {
        // get the input from the user (in json format)
        $newPinpointInJson = $request->getContent();

        // deserialize it in order to process it
        $newPinpoint = $serializer->deserialize($newPinpointInJson, Pinpoint::class, 'json');

        // set creation date
        $newPinpoint->setCreatedAt(new \DateTimeImmutable('now'));
        
        // validate the new pinpoint
        $errors = $validator->validate($newPinpoint);

        if (count($errors) > 0) {
            return $this->json($errors, 400);
        }


        // persist the pinpoint into the database
        $entityManager->persist($newPinpoint);

        $entityManager->flush();

        return $this->json($newPinpoint, 201, [], ['groups' => Pinpoint::DEFAULT_SERIALIZATION_GROUP]);
    }

    #[Route('pinpoint/{id<\d+>}', name: 'delete', methods: ['DELETE'])]
    public function delete(PinpointRepository $pinpointRepository, int $id, EntityManagerInterface $entityManager): JsonResponse
    {
        // get the pinpoint to delete by the id in the url
        $pinpoint = $pinpointRepository->find($id);

        // handle the case where the pinpoint doesn't exist
        if (!$pinpoint) {
            throw $this->createNotFoundException('Pinpoint not found');
        }

        // delete the pinpoint from the database
        $entityManager->remove($pinpoint);
        $entityManager->flush();

        // return the success message and http status
        return $this->json('Pinpoint successfully deleted', 200);
    }
}
