<?php

namespace App\Controller;

use App\Entity\Word;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WordsController extends AbstractController
{
    #[Route('/words', name: 'words')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $repo = $doctrine->getRepository(Word::class);
        $words = $repo->findAll();

        if(!$words) {
            throw $this->createNotFoundException(
                'No product found'
            );
        }

        return $this->render('words/index.html.twig', [
            'controller_name' => 'WordsController',
            'words' => $words
        ]);
    }
}
