<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


/**
 * @codeCoverageIgnore
 */
class UserFixtures extends Fixture 
{

    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }
    
    public function load(ObjectManager $manager)
    {
        // Admin
        $user = new User;
        $user->setUsername('admin')
        ->setEmail('admin@admin.fr')
        ->setRoles(['ROLE_ADMIN'])
        ->setPassword($this->encoder->encodePassword($user, 'root'));
        $this->addReference('user-1', $user);
        $manager->persist($user);
        $manager->flush();


        // User
        $user = new User;
        $user->setUsername('user')
        ->setEmail('user@user.fr')
        ->setRoles(['ROLE_USER'])
        ->setPassword($this->encoder->encodePassword($user, 'test'));
        $this->addReference('user-2', $user);
        $manager->persist($user);
        $manager->flush();


        // Anonymous user
        $user = new User;
        $user->setUsername('anonymous')
        ->setEmail('anonymous@anonymous.fr')
        ->setRoles(['ROLE_ANONYMOUS'])
        ->setPassword($this->encoder->encodePassword($user, 'anonymous'));
        $this->addReference('user-3', $user);
        $manager->persist($user);
        $manager->flush();
    }
}