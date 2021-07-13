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
        for ($i = 1; $i <= 10; $i++) {
            $user = new User();

            $user->setUsername($i < 10 ? "User$i" : 'Admin')
                ->setEmail($i < 10 ? "User$i@email.fr" : 'Admin@email.fr')
                ->setPassword($i < 10 ? $this->passwordHasher->hashPassword($user, 'test') : $this->passwordHasher->hashPassword($user, 'root'))
                ->setRoles($i < 10 ? ['ROLE_USER'] : ['ROLE_ADMIN'])
            ;
            $this->addReference('user-' . $i, $user);
            $manager->persist($user);
        }

            $user2 = new User();
            $user2->setUsername('anonymous')
            ->setEmail('anonymous@gmail.com')
            ->setPassword($this->passwordHasher->hashPassword($user2, 'test'))
            ->setRoles(['']);
            $this->addReference('user-11', $user2);
            $manager->persist($user2);

        $manager->flush();
    }
}
