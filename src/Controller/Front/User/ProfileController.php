<?php

namespace App\Controller\Front\User;

use App\Entity\User;
use App\Security\AppAuthenticator;
use App\Form\ChangePasswordType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;

class ProfileController extends AbstractController
{
    #[Route("/profile", name: "profile")]
    public function index()
    {
        return $this->render('front/user/profile.html.twig');
    }

    #[Route('/edit', name: 'edit')]
    public function changePassword(Request $request, UserPasswordHasherInterface $passwordHasher, UserAuthenticatorInterface $authenticator, AppAuthenticator $appAuthenticator): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(ChangePasswordType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $isValidPassword = $passwordHasher->isPasswordValid(
                $user,
                $form->get('currentPassword')->getData(),
            );
            if (!$isValidPassword) {
                $this->addFlash('errorPassword', 'Invalid password');

                return $this->redirectToRoute('edit');
            } else {

                $user->setPassword($passwordHasher->hashPassword(
                    $user,
                    $form->get('newPassword')->getData(),
                ));

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($user);
                $entityManager->flush();

                $this->addFlash('successPassword', 'Your password has been changed');

                return $this->redirectToRoute('edit');
                // return $authenticator->authenticateUser($user, $appAuthenticator, $request);
            }
        }

        return $this->render('front/user/password.html.twig', [
            'changePasswordForm' => $form->createView(),
        ]);
    }
}
