<?php

namespace App\DataFixtures;

use App\Entity\Resume;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
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
        $faker = Factory::create();

        for ($i = 0; $i < 50; $i++)
        {
            $user = new User();
            $user->setFirstName($faker->firstName);
            $user->setLastName($faker->lastName);
            $user->setEmail($faker->email);
            $user->setPassword($this->passwordEncoder->encodePassword($user, '123456'));
            $user->setUsername($faker->userName);
            $ran = RANDOM_INT(1, 10);
            if($ran > 8)
            {
                $user->setRole('ROLE_EMPLOYER');
            }
            else{
                $user->setRole('ROLE_EMPLOYEE');
            }
            //$user->setRole($faker->randomElement($array = array('ROLE_EMPLOYER', 'ROLE_EMPLOYEE')));
            $user->setPhoneNum($faker->phoneNumber);
            $user->setCredits(200);

            $manager->persist($user);
            $manager->flush();

            if(in_array('ROLE_EMPLOYEE', $user->getRoles()) == true)
            {
                for($j = 0; $j < RANDOM_INT(3, 8); $j++)
                {
                    $resume = new Resume();
                    $resume->setUser($user);
                    $resume->setArea($faker->randomElement($array = array('Programuotojas', 'Apsauginis', 'Analitikas', 'Vairuotojas', 'Virejas')));
                    $resume->setAboutYou($faker->sentence);
                    $resume->setCreatedAt($faker->dateTime);
                    $resume->setEducation($faker->randomElement($array = array('Pagrindinis', 'Vidurinis', 'Profesinis', 'Aukstasis')));
                    $resume->setLanguages($faker->randomElements($array = array('Lietuviskai', 'Angliskai', 'Rusiskai', 'Vokiskai'), $count = random_int(1,3)));
                    $resume->setSalary(random_int(604, 3259));
                    $resume->setUpdatedAt($resume->getCreatedAt());
                    $resume->setExperience($faker->randomElement($array = array('1', '2', '3', '4')));
                    $resume->setIsMain($faker->boolean);


                    $manager->persist($resume);
                    $manager->flush();
                    $user->setMainNum($resume->getId());
                }
            }

        }

    }

}
