<?php

namespace App\Controller;

use App\Entity\Word;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WordsController extends AbstractController
{
    private string $hexaColor;
    #[Route('/words', name: 'words')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $repo = $doctrine->getRepository(Word::class);
        $words = $repo->findAll();

        foreach($words as $word) {
            $hexaColor[] = '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
        }

        if(!$words) {
            throw $this->createNotFoundException(
                'No product found'
            );
        }

        return $this->render('words/index.html.twig', [
            'controller_name' => 'WordsController',
            'words' => $words,
            'hexa' => $hexaColor,
        ]);
    }
}
