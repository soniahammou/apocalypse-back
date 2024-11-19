<?php

namespace App\Controller\Api\V1;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use App\Service\EntityNotFound;
use App\Service\UploaderService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;

#[Route('/api/v1/', name: 'app_api_article_', format: 'json')]
class ArticleController extends AbstractController
{
    private $entityNotFound;
    private $uploaderService;

    public function __construct(EntityNotFound $entityNotFound,UploaderService $uploaderService)
    {
        $this->entityNotFound = $entityNotFound;
        $this->uploaderService = $uploaderService;

    }

    #[Route('article', name: 'browse', methods: 'GET')]
    public function browse(ArticleRepository $articleRepository, Request $request): JsonResponse
    {

        $articleList = $articleRepository->findAll();

        return $this->json($articleList, 200, [], ['groups' => Article::DEFAULT_SERIALIZATION_GROUP]);
    }
    #[Route('article/{id<\d+>}', name: 'read', methods: 'GET')]
    public function read(int $id, ArticleRepository $articleRepository): JsonResponse
    {
        $article = $articleRepository->find($id);

        if (is_null($article)) {
            return $this->entityNotFound->objectNotFound('category');
        }

        return $this->json($article, 200, [], ['groups' => Article::DEFAULT_SERIALIZATION_GROUP]);
    }


    #[Route('article', name: 'add', methods: 'POST')]
    public function add(UploaderHelper $helper, EntityManagerInterface $em, Request $request, SerializerInterface $serializer, ValidatorInterface $validator): JsonResponse
    {
        // Le contenu File n'est pas de type JSON donc on récupere tout le contenu sous forme de tableau associatif
        $data = $request->request->all();
        $article = $serializer->deserialize(json_encode($data), Article::class, 'json');


        $uploadResponse = $this->uploaderService->uploadFile($request, $article, 'articles');
        
        // Si le service retourne une réponse, cela signifie qu'il y a eu une erreur
        if ($uploadResponse instanceof JsonResponse) {
            return $uploadResponse;
        }    
     

        $errors = $validator->validate($article);

        if (count($errors) > 0) {
            return $this->json([
                'success' => false,
                'errors' => (string) $errors,
            ], JsonResponse::HTTP_BAD_REQUEST);
        }

        // je ne peux pas recuperer l'image car elle est null car pas encore persisé en BDD
        // dump($article->getPicture());
        $em->persist($article);


        // si le fichier est null sans cette condition ca laisse le persiste et ca envoie en BDD le lien 
        $this->uploaderService->uploadFileAfterPersit($request,$article, 'articles');
        $em->flush();




        return $this->json($article, JsonResponse::HTTP_OK, [], ['groups' => Article::DEFAULT_SERIALIZATION_GROUP]);
    }

    #[Route('article/{id<\d+>}', name: 'edit', methods: 'PATCH')]
    public function edit(int $id, ArticleRepository $articleRepository, EntityManagerInterface $em, Request $request, SerializerInterface $serializer, ValidatorInterface $validator): JsonResponse {

        
        $article = $articleRepository->find($id);

        //404 error
        if (is_null($article)) {
            return $this->entityNotFound->objectNotFound('article');
        }

        $data = $request->getContent();
        // Désérialisez les données
        $serializer->deserialize($data, Article::class, 'json', [AbstractNormalizer::OBJECT_TO_POPULATE => $article]);

        $errors = $validator->validate($article);

        if (count($errors) > 0) {
            $data = [
                'success' => false,
                'errors' => (string) $errors,
            ];

            return $this->json($data, Response::HTTP_BAD_REQUEST);
        }

        $em->persist($article);
        $em->flush();

        return $this->json($article, Response::HTTP_OK, [], ['groups' => Article::DEFAULT_SERIALIZATION_GROUP]);
    }



    #[Route('article/{id<\d+>}', name: 'delete', methods: 'DELETE')]
    public function delete(int $id, ArticleRepository $articleRepository, EntityManagerInterface $em): JsonResponse
    {

        $article = $articleRepository->find($id);

        if (is_null($article)) {
            return $this->entityNotFound->objectNotFound('article');
        }
        $em->remove($article);
        $em->flush();

        $data = [
            "success" => true,
            "message" => "article deleted",
        ];

        return $this->json($data);
    }
}
