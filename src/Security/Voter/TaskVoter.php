<?php

namespace App\Security\Voter;

use App\Entity\Task;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class TaskVoter extends Voter
{
    protected function supports(string $attribute, $subject): bool
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, ['TASK_DELETE','TASK_EDIT'])
            && $subject instanceof Task;
    }

    protected function voteOnAttribute(string $attribute, $task, TokenInterface $token): bool
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case 'TASK_EDIT':
                if ($task->getUser() === $user || $user->getRoles() === ['ROLE_ADMIN']) {
                    return true;
                }
                break;
            case 'TASK_DELETE':
                if ($task->getUser() === $user || $user->getRoles() === ['ROLE_ADMIN']) {
                    return true;
                }
                break;
        }
        return false;
    }
}
