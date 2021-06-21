<?php

namespace App\Security\Voter;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class UserVoter extends Voter
{
    protected function supports($attribute, $subject)
    {
        // if supports's methods return true, voteOnAttribute is executed 
        return in_array($attribute, ['edit', 'read', 'delete'])
            && $subject instanceof \App\Entity\User;
    }

    // if voteOnAttribute() is executed, it return a boolean :
        // if return true, he allow to the user to access to the page
        // if false, the access is denied
    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();
        
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        // for each case, in UserController.php; $this->denyAccessUnlessGranted('delete', $user); deny the permission
        // if $subject =! $user
        switch ($attribute) {
            case 'edit':
            case 'read':
            case 'delete':
                if ($subject === $user) {
                    return true;
                }
                if (in_array('ROLE_ADMIN', $user->getRoles())) {
                    return true;
                }
                break;
        }

        return false;
    }
}
