<?php

namespace App\DataFixtures;

use App\Entity\Anniversary;
use App\Entity\User;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordHasherInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager): void
    {

        $lastname = ['Martin', 'Dupont', 'Leroy', 'Dubois', 'Laurent', 'Lambert', 'Girard', 'Moreau', 'Lefevre', 'Lemoine'];
        $firstname = ['Lea', 'Hugo', 'Emma', 'Gabriel', 'Chloe', 'Louis', 'Manon', 'Nathan', 'Camille', 'Ethan'];
        $date = ['1988-03-15', '1995-11-7', '1979-09-22', '2002-03-03', '1990-02-28', '1985-04-05', '1998-12-18', '1973-03-09', '1982-05-27', '1991-10-14'];
        $users = [];

        $emailList = ['admin@admin', 'aa@aa'];

        foreach ($emailList as $email) {
            $user = new User();
            $user->setEmail($email);
            $password = $this->passwordEncoder->hashPassword($user, '123456');
            $user->setPassword($password);
            $user->setRoles(["ROLE_USER"]);
            $manager->persist($user);
            $this->addReference('user_' . $email, $user); // Ajoute une référence pour pouvoir le récupérer plus tard
        }

        $manager->flush();

        for ($i = 0; $i < 15; $i++) {
            $anniversary = new Anniversary();
            $anniversary->setLastname($lastname[array_rand($lastname)]);
            $anniversary->setFirstname($firstname[array_rand($firstname)]);
            $anniversaryDate = new DateTime($date[array_rand($date)]);
            $anniversary->setDate($anniversaryDate);

            // Calculer la dateYears
            $currentDate = new DateTime();
            $currentYear = $currentDate->format('Y');
            $anniversary->setDateYears(new DateTime("$currentYear-{$anniversaryDate->format('m-d')}"));

            // Sélectionnez un utilisateur aléatoire parmi ceux créés précédemment
            $randomUserReference = 'user_' . $emailList[array_rand($emailList)];
            $randomUser = $this->getReference($randomUserReference);
            $anniversary->setUser($randomUser);

            $manager->persist($anniversary);
        }

        $manager->flush();
    }
}
