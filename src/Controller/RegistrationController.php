<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Security\BackOfficeAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class RegistrationController extends AbstractController
{
    #[Route('/api/register', name: 'api_register', methods: ['POST'])]
    public function registerAPI(Request $request, ValidatorInterface $validator, UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $entityManager): Response
    {
        // Retrieve the JSON payload from the request
        $payload = json_decode($request->getContent(), true);

        // Create a new instance of the User entity
        $user = new User();

        $user->setFirstName($payload['firstName']);
        $user->setLastName($payload['lastName']);
        $user->setRoles(['ROLE_USER']); // Set default roles

        $user->setUsername($payload['username']);
        $user->setEmail($payload['email']);

        $user->setAddress($payload['address']);
        $user->setZipcode($payload['zipcode']);
        $user->setCity($payload['city']);

        $user->setLatitude($payload['latitude']);
        $user->setLongitude($payload['longitude']);



        // Validate the user entity
        $errors = $validator->validate($user);
        if (count($errors) > 0) {
            // Handle validation errors
            $errorMessages = [];
            foreach ($errors as $error) {
                $errorMessages[] = $error->getMessage();
            }

            // Return a JSON response with the validation errors
            return new Response(json_encode(['errors' => $errorMessages]), Response::HTTP_BAD_REQUEST);
        }

        // Hash and set the user's password
        $hashedPassword = $passwordHasher->hashPassword($user, $payload['password']);
        $user->setPassword($hashedPassword);

        // Persist the user entity in the database
        $entityManager->persist($user);
        $entityManager->flush();

        // Return a JSON response indicating successful registration
        return new Response(json_encode(['message' => 'User registered successfully']), Response::HTTP_CREATED);
    }




    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, UserAuthenticatorInterface $userAuthenticator, BackOfficeAuthenticator $authenticator, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email

            return $userAuthenticator->authenticateUser(
                $user,
                $authenticator,
                $request
            );
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
