<?php

namespace App\Controller\Front;

use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'contact')]
    public function index(Request $request, \Swift_Mailer $mailer): Response
    {
        $form = $this->createForm(ContactType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $contactFormData = $form->getData();

            $message = (new \Swift_Message('New email from Vortex'))
                // We set the sender
                ->setFrom($contactFormData['mail'])
                // We set the recipient
                ->setTo('alexandre.desmot@gmail.com')
                // We create the body of the mail
                ->setBody(
                    $this->renderView(
                        'email/email.html.twig',
                        compact('contactFormData')
                    ),
                    'text/html'
                );

            $mailer->send($message);

            $this->addFlash('success', 'Thank you for your email, we will respond soon !');

            return $this->redirectToRoute('contact');
        }

        return $this->render('front/contact.html.twig', [
            'contact_form' => $form->createView(),
        ]);
    }
}
