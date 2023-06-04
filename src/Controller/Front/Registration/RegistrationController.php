<?php

namespace App\Controller\Front\Registration;

use App\Entity\User;
use Http\Client\Exception;
use App\Security\EmailVerifier;
use App\Form\RegistrationFormType;
use App\Security\AppAuthenticator;
use Symfony\Component\Mime\Address;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use SymfonyCasts\Bundle\VerifyEmail\VerifyEmailHelperInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Http\Authenticator\FormLoginAuthenticator;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;

class RegistrationController extends AbstractController
{
    private EmailVerifier $emailVerifier;

    public function __construct(EmailVerifier $emailVerifier)
    {
        $this->emailVerifier = $emailVerifier;
    }

    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, UserAuthenticatorInterface $userAuthenticator, AppAuthenticator $authenticator, VerifyEmailHelperInterface $verifyEmailHelperInterface, EntityManagerInterface $entityManager): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('dashboard');
        }

        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // if ($form['agreeTerms']->getData() === true) {

            try {

                // encode the plain password
                $user->setPassword(
                    $userPasswordHasher->hashPassword(
                        $user,
                        $form->get('plainPassword')->getData()
                    )
                );

                $user->setRoles(['ROLE_USER']);

                $entityManager->persist($user);
                $entityManager->flush();

                $signatureComponents = $verifyEmailHelperInterface->generateSignature(
                    'app_verify_email',
                    $user->getId(),
                    $user->getEmail(),
                    ['id' => $user->getId()]
                );

                $this->addFlash('success', 'Your account has been created');
                //$this->addFlash('success', 'Confirm your email at: ' . $signatureComponents->getSignedUrl());

                // TODO : SEND EMAIL

                // generate a signed url and email it to the user
                // $this->emailVerifier->sendEmailConfirmation(
                //     'app_verify_email',
                //     $user,
                //     (new TemplatedEmail())
                //         ->from(new Address('noreply@vortex.com', 'Vortex'))
                //         ->to($user->getEmail())
                //         ->subject('Please Confirm your Email')
                //         ->htmlTemplate('front/registration/confirmation_email.html.twig')
                // );
                // do anything else you need here, like send an email

                // TODO : AUTH LE USER

                // return $userAuthenticator->authenticateUser(
                //     $user,
                //     $authenticator,
                //     $request
                // );
            } catch (Exception $e) {

                $this->addFlash('error', 'Account has not been created');
            }

            return $this->redirectToRoute('app_verify_email');
            // }
        }

        return $this->render('front/registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    #[Route('/verify/email', name: 'app_verify_email')]
    public function verifyUserEmail(Request $request, TranslatorInterface $translator): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        // validate email confirmation link, sets User::isVerified=true and persists
        try {
            $this->emailVerifier->handleEmailConfirmation($request, $this->getUser());
        } catch (VerifyEmailExceptionInterface $exception) {
            $this->addFlash('verify_email_error', $translator->trans($exception->getReason(), [], 'VerifyEmailBundle'));

            return $this->redirectToRoute('app_register');
        }

        // @TODO Change the redirect on success and handle or remove the flash message in your templates
        $this->addFlash('success', 'Your email address has been verified.');

        return $this->redirectToRoute('app_register');
    }
}
