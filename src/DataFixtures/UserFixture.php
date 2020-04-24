<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixture extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        // create 10 users! Bam!
        // Example email: user-0@mail.com password: user-0
        for ($i = 0; $i < 10; $i++) {
            $employee = new User();
            $employee->setFirstName('Darbuotojas-'.$i);
            $employee->setLastName('BandymasDarbuotojas-'.$i);
            $employee->setUsername('Darbuotojas-'.$i);
            $employee->setPhoneNum('489465465');
            $employee->setEmail('testasDarbuotojas-'.$i.'@mail.com');
            $employee->setRole('ROLE_EMPLOYEE');
            $employee->setPassword($this->passwordEncoder->encodePassword(
                $employee,
                '123456'
            ));
            $manager->persist($employee);
            $employer = new User();
            $employer->setFirstName('Darbdavys-'.$i);
            $employer->setLastName('BandymasDarbdavys-'.$i);
            $employer->setUsername('Darbdavys-'.$i);
            $employer->setPhoneNum('489465465');
            $employer->setEmail('testasDarbdavys-'.$i.'@mail.com');
            $employer->setRole('ROLE_EMPLOYER');
            $employer->setCredits(100);
            $employer->setPassword($this->passwordEncoder->encodePassword(
                $employer,
                '123456'
            ));
            $manager->persist($employer);
            $manager->flush();
        }
    }
}