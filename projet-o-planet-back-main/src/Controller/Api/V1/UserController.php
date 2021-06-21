<?php

namespace App\Controller\Api\V1;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\DumpRepository;
use App\Repository\RemovalRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/api/v1/users", name="api_v1_users_")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/profile", name="profile", methods={"GET"})
     */
    public function profile(): Response
    {
        // if you are log with the wrong user, you can't read this page
            // ex : log at user2, you can't read user3 profile
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $user = $this->getUser();

        // get user with fields to sent to front
        $userToSend = (object) json_decode($this->json($user, 200, [], [
            'groups' => ['user_read']
        ])->getContent());

        // set new admin field to false by default 
        $userToSend->isAdmin = false;

        foreach($user->getRoles() as $role){
            if($role == 'ROLE_ADMIN'){
                // if admin then set admin field to true
                $userToSend->isAdmin = true;
                break;
            }
        }

        // send to front
        return $this->json($userToSend, 200);

    }

     /**
     * @Route("/register", name="add", methods={"POST"})
     */
    public function add(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        // The register route : this one don't need to have JWT token because you can't have one when you are not connected
        $user = new User();
        $form = $this->createForm(UserType::class, $user, [
            'csrf_protection' => false,
        ]);
        
        $sentData = json_decode($request->getContent(), true);

        $form->submit($sentData);
        // verification with userType to valid or not the form
        if ($form->isValid()) {
            // we hash the password to put some security in database
            $password = $form->get('password')->getData();
            $user->setPassword($passwordEncoder->encodePassword($user, $password));
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->json($user, 201, [], [
                'groups' => ['user_read'],
            ]);
        } else {
            // if form is not valid, we send errors messages
                // first parameter with true : collect errors in all form'fields
                // second parameter with false : errors are organised by field
            $errors = $form->getErrors(true, false);
            // transform errors in string
            $errorString = (string) $errors;
          
            // we send http 400 error, it's an error on the validation so due to invalidates datas
            return $this->json($errorString, 400);
        }
    }

    /**
     * @Route("/profile", name="edit", methods={"PUT", "PATCH"})
     */
    public function edit(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        // retrieve user with token
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        // get user object
        $user = $this->getUser();

        $form = $this->createForm(UserType::class, $user, [
            'csrf_protection' => false,
        ]);

        $sentData = json_decode($request->getContent(), true);

        if (!key_exists('password', $sentData)){
            $sentData['password'] = $user->getPassword();
        }

        if (!key_exists('roles', $sentData)){
            $sentData['roles'] = $user->getRoles();
        }
        
        $form->submit($sentData);

        // we hash the password to put some security in database
        $password = $form->get('password')->getData();
        $user->setPassword($passwordEncoder->encodePassword($user, $password));

        if ($form->isValid()) {
            $user->setUpdatedAt(new \DateTime());
            $this->getDoctrine()->getManager()->flush();

            return $this->json($user, 200, [], [
                'groups' => ['user_read'],
            ]);
        }

        // view comments in add method
        return $this->json($form->getErrors(true, false)->__toString(), 400);
    }

    /**
     * @Route("/profile", name="delete", methods={"DELETE"})
     */
    public function delete(DumpRepository $dumpRepository, RemovalRepository $removalRepository, UserRepository $userRepository): Response
    {
        // retrieve user with token
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        // get user object
        $user = $this->getUser();

        // get anonymous user
        $anonymousUser = $userRepository->findOneBy(['email' => 'anonymous@oplanet.fr']);

        // instaciate doctrine manager
        $em = $this->getDoctrine()->getManager();

        // get list of dump for this user 
        $dumpList = $dumpRepository->findBy([
            "user" => $user
        ]);

        // replace user by anonymous user
        foreach($dumpList as $dumpElement){
            $dumpElement->setUser($anonymousUser);
            $em->persist($dumpElement);
        }

        // get list of removals for this user 
        $removalList = $removalRepository->findBy([
            "creator" => $user
        ]);

        // replace user by anonymous user
        foreach($removalList as $removalElement){
            $removalElement->setCreator($anonymousUser);
            $em->persist($removalElement);
        }

        // remove current user from database and flush manager
        $em->remove($user);
        $em->flush();

        // send no content 204 response
        return $this->json(null, 204);
    }
}
