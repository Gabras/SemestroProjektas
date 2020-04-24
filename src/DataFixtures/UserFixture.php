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

        for ($i = 0; $i < 10; $i++)
        {
            $user = new User();
            $user->setFirstName($faker->firstName);
            $user->setLastName($faker->lastName);
            $user->setEmail($faker->email);
            $user->setPassword($this->passwordEncoder->encodePassword($user, '123456'));
            $user->setUsername($faker->userName);
            $user->setRole($faker->randomElement($array = array('ROLE_EMPLOYER', 'ROLE_EMPLOYEE')));
            $user->setPhoneNum($faker->phoneNumber);
            $user->setCredits(200);

            $manager->persist($user);
            $manager->flush();

            if(in_array('ROLE_EMPLOYEE', $user->getRoles()) == true)
            {
                for($i = 0; $i < RANDOM_INT(1, 15); $i++)
                {
                    $resume = new Resume();
                    $resume->setUser($user);
                    $resume->setArea($faker->text);
                    $resume->setAboutYou($faker->sentence);
                    $resume->setCreatedAt($faker->dateTime);
                    $resume->setEducation($faker->country);
                    $resume->setLanguages($faker->randomElements($array = array('Lithuanian', 'Russian', 'English', 'Polish'), $count = random_int(1,3)));
                    $resume->setSalary(random_int(604, 3259));
                    $resume->setUpdatedAt($resume->getCreatedAt());
                    $resume->setExperience(random_int(0, 5));
                    $resume->setIsMain(true);


                    $manager->persist($resume);
                    $manager->flush();
                }
            }

        }

    }

}
