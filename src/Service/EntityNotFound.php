<?php


namespace App\Service;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class EntityNotFound extends AbstractController
{

    
    /**
     * Check if an object exist or not
     *
     * @param [string] $objectString
     * @return JsonResponse
     */
    public function objectNotFound($objectString):JsonResponse
    {
        $data = [
            "success" => false,
            "message" => $objectString . " not found"
        ];

        return $this->json($data, Response::HTTP_NOT_FOUND);
    }
}