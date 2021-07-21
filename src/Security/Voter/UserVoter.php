<?php

namespace App\Security\Voter;

use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class UserVoter extends Voter
{
    /**
     * Defined the attribute to subject
     *
     * @param string $attribute
     * @param [type] $subject
     * @return boolean
     */
    protected function supports(string $attribute, $subject): bool
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, ['USER_READ','USER_EDIT','USER_DELETE'])
            && $subject instanceof User;
    }

    /**
     * Action for check roles
     *
     * @param string $attribute
     * @param [type] $subject
     * @param TokenInterface $token
     * @return boolean
     */
    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {

        $user = $token->getUser();


        // @codeCoverageIgnoreStart
        if (!$user instanceof UserInterface) {
            return false;
        }
        // @codeCoverageIgnoreEnd

        switch ($attribute) {
            case 'USER_READ':
                if ($user->getRoles() === ['ROLE_ADMIN']) {
                    return true;
                }
                // @codeCoverageIgnoreStart
                break;
                // @codeCoverageIgnoreEnd
            case 'USER_EDIT':
                if ($user === $subject || $user->getRoles() === ['ROLE_ADMIN']) {
                    return true;
                }
                // @codeCoverageIgnoreStart
                break;
                // @codeCoverageIgnoreEnd
            case 'USER_DELETE':
                if ($user === $subject) {
                    return false;
                } elseif ($user->getRoles() === ['ROLE_ADMIN']) {
                    return true;
                }
                // @codeCoverageIgnoreStart
                break;
                // @codeCoverageIgnoreEnd
        }
        return false;
    }
}
