<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 * @codeCoverageIgnore
 */
class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        // Admin
        $user = new User();
        $user->setUsername('admin')
        ->setEmail('admin@admin.fr')
        ->setRoles(['ROLE_ADMIN'])
        ->setPassword($this->passwordHasher->hashPassword($user, 'root'));
        $this->addReference('user-1', $user);
        $manager->persist($user);
        $manager->flush();


        // User
        $user = new User();
        $user->setUsername('user')
        ->setEmail('user@user.fr')
        ->setRoles(['ROLE_USER'])
        ->setPassword($this->passwordHasher->hashPassword($user, 'test'));
        $this->addReference('user-2', $user);
        $manager->persist($user);
        $manager->flush();

        //Anonymous
        $user = new User();
        $user->setUsername('anonymous')
        ->setEmail('anonymous@anonymous.fr')
        ->setRoles([])
        ->setPassword($this->passwordHasher->hashPassword($user, 'anonymous'));
        $this->addReference('user-3', $user);
        $manager->persist($user);
        $manager->flush();

        ;
    }
}
