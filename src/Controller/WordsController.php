<?php

namespace App\Controller;

use App\Entity\Word;
use App\Form\WordType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class WordsController extends AbstractController
{
    private string $hexaColor;
    private ValidatorInterface $validator;

    public function __construct(ValidatorInterface $validator) {
        $this->validator = $validator;
    }

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

    #[Route('/words/definition', name: 'words_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $manager): Response
    {
        $word = new Word();
        $form = $this->createForm(WordType::class, $word);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $user = $this->getUser();
            $word = $form->getData();

            if($user) {
                $word->setUser($user);
            }

            $manager->persist($word);
            $manager->flush();

            return $this->redirectToRoute('words');
        }

        return $this->renderForm('words/new.html.twig', [
            'form' => $form,
        ]);
    }
}
