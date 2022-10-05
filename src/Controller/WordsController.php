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

        if(!$words) {
            throw $this->createNotFoundException(
                'No product found'
            );
        }

        return $this->render('words/index.html.twig', [
            'controller_name' => 'WordsController',
            'words' => $words,
        ]);
    }

    #[Route('/words/definition', name: 'words_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $manager): Response
    {
        $word = new Word();
        $form = $this->createForm(WordType::class, $word);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $word->setIsPublish(false);
            $word->setIsPub(true);
            $word->setIsCrush(false);
            $word->setIsOnline(false);
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

    #[Route('/{slug}', name: 'words_show', methods: ['GET', 'POST'])]
    public function show(Word $word): Response
    {
        //$comments = $article->getComments();
        //$comment = new Comment();
        //$form = $this->createForm(CommentType::class, $comment);
        //$form->handleRequest($request);

        /*if ($form->isSubmitted() && $form->isValid()) {

            $comment->setArticle($article);
            $comment->setUser($this->getUser());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($comment);
            $entityManager->flush();

            $this->addFlash('success', 'Commentaire ajouté');
            return $this->redirectToRoute('article_show', ['slug' => $article->getSlug()], Response::HTTP_SEE_OTHER);
        }*/

        if($word->isIsPublish() == "0" && !$this->isGranted('ROLE_ADMIN')){
            $response = new Response();
            $response->setStatusCode(403);
            return $response;
        } else {
            return $this->render('words/show.html.twig', [
                //'form' => $form->createView(),
                'word' => $word,
                //'comments' => $comments
            ]);
        }
    }
}
