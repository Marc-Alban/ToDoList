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
        return in_array($attribute, ['Task_DELETE','Task_EDIT'])
            && $subject instanceof \App\Entity\Task;
    }

    protected function voteOnAttribute(string $attribute, $task, TokenInterface $token): bool
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        if (null == $task->getUser()) {
            return false;
        }

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case 'Task_EDIT':
                if ($task->getUser()->getId() === $user->getId()) {
                    return true;
                }
                if ($user->getUsername() === 'admin' && $task->getUser()->getRoles() === []) {
                    return true;
                }
                break;
            case 'Task_DELETE':
                if ($task->getUser()->getId() === $user->getId()) {
                    return true;
                }

                if ($user->getUsername() === 'admin' && $task->getUser()->getRoles() === []) {
                    return true;
                }
                break;
        }

        return false;
    }
}
