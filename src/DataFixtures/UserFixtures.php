<?php

namespace App\DataFixtures;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\User ;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setUsername('gynsora');
        $user->setPassword($this->passwordEncoder->encodePassword( $user,'gynsora' ));
        $user->setRoles(['ROLE_USER']);
        $manager->persist($user);

        $userAdmin = new User();
        $userAdmin->setUsername('gynsora2');
        $userAdmin->setPassword($this->passwordEncoder->encodePassword( $user,'gynsora2' ));
        $userAdmin->setRoles(['ROLE_ADMIN']);
        $manager->persist($userAdmin);
        
        $manager->flush();
    }
}
