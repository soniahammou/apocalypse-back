<?php

namespace App\Controller;

use App\Repository\QuestionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/question', name: 'app_question_')]
class QuestionController extends AbstractController
{
    #[Route('/', name: 'browse', methods: ['GET'])]
    public function browse(QuestionRepository $questionRepository): Response
    {
        $questionList = $questionRepository->findAll();

        return $this->render('question/browse.html.twig', [
            'questionList' => $questionList,
        ]);
    }
}
