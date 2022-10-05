<?php

declare(strict_types=1);
namespace App\Controller;

use App\Repository\WordRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(WordRepository $wordRepository): Response
    {
        return $this->render('home/index.html.twig', [
            'words' => $wordRepository->findLastWords(),
        ]);
    }
}
