<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mime\Email;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(MailerInterface $mailer, Request $request): Response
    {
        $formContact = $this->createForm(ContactType::class);
        $formContact->handleRequest($request);


        if($formContact->isSubmitted() && $formContact->isValid()) {
            $contactFormData = $formContact->getData();

            $message = (new Email())
                ->from(new Address($contactFormData['email'], $contactFormData['name']))
                ->to('matheo.zeller@gmail.com')
                ->subject('Vous avez reçu un email')
                ->text('De : '.$contactFormData['email'].\PHP_EOL.
                    $contactFormData['message'],
                    'text/plain');


            $mailer->send($message);

            $this->addFlash('success', 'Votre message a été envoyé');

            return $this->redirectToRoute('app_contact');
        }

        return $this->render('contact/index.html.twig', [
            'formContact' => $formContact->createView()
        ]);
    }
}
