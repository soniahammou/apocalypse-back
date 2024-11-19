<?php

namespace App\DataFixtures;

use App\DataFixtures\Providers\AppProvider;
use App\Entity\Answer;
use App\Entity\Article;
use App\Entity\Category;
use App\Entity\City;
use App\Entity\Pinpoint;
use App\Entity\Question;
use App\Entity\Report;
use App\Entity\SearchNotice;
use App\Entity\Status;
use App\Entity\Type;
use App\Entity\User;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Validator\Constraints\Length;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;
    private SluggerInterface $slugger;

    public function __construct(UserPasswordHasherInterface $hasher,SluggerInterface $slugger )
    {
        $this->hasher = $hasher;
        $this->slugger = $slugger;

    }


    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create("fr_FR");
        $faker->addProvider(new AppProvider($faker));


        // !user role : user
        $users = [];

        for ($i = 1; $i <= 10; $i++) {
            $user = (new User)
                ->setEmail($faker->email())
                ->setFirstName($faker->firstName())
                ->setLastName($faker->lastName())
                ->setRoles(['ROLE_USER']);

            $password = 'appo';
            $hashedPassword = $this->hasher->hashPassword($user, $password);
            $user->setPassword($hashedPassword);

            $manager->persist($user);
            $users[] = $user;
        }


        // ! user : role admin
        for ($i = 1; $i <= 4; $i++) {
            $user = (new User)
                ->setEmail($faker->email())
                ->setFirstName($faker->firstName())
                ->setLastName($faker->lastName())
                ->setRoles(['ROLE_ADMIN']);

            $password = 'appo';
            $hashedPassword = $this->hasher->hashPassword($user, $password);
            $user->setPassword($hashedPassword);

            $manager->persist($user);
        }
        // !TYPES (for pinpoints) //

        $typeList = [];
        foreach ($faker->types as $key => $value) {
            $type = new Type;
            $type->setName($key);
            $type->setIconUrl($value);
            $manager->persist($type);
            $typeList[] = $type;
        }

        //! PINPOINTS //

        foreach ($faker->getPinpointDescription as $description) {

            $pinpoint = new Pinpoint();
            $pinpoint->setDescription($description['description']);
            $date = new DateTimeImmutable($faker->dateTimeThisYear()->format('Y-m-d H:i:s'));

            $pinpoint->setCreatedAt($date);
            // $pinpoint->setLatitude($faker->randomFloat(6));
            // $pinpoint->setLongitude($faker->randomFloat(6));
             $pinpoint->setLatitude($description['latitude']);
            $pinpoint->setLongitude($description['longitude']);
            $pinpoint->setType($typeList[array_rand($typeList)]);
            $pinpoint->setUser($users[array_rand($users)]);

            $manager->persist($pinpoint);
        }
        // ! category
        $categories = [];

        for ($i = 0; $i < 6; $i++) {
            $category = (new Category)
                ->setName($faker->getCategoriesNames($i))
                ->setHomeOrder($i + 1)
                ->setPicture($faker->imageUrl());

            // ? dans le cas d'un upload v2 potentiel a developper
            // $imagePath = $this->params->get('kernel.project_dir') . '/public/images/category/image' . $i . '.jpg';
                //$imageUrl = $this->request->getSchemeAndHttpHost() . '/images/category/image' . $i . '.jpg';
                // $uploadedFile = new UploadedFile(
                //     $imagePath,
                //     'image'.$i.'.jpg', // Nom de fichier original
                //     'image/jpeg', // Type MIME
                //     null, // Taille du fichier (null pour laisser PHP calculer automatiquement)
                //     true // Le fichier est déjà déplacé
                // );
                
                // $category->setPictureFileCategory($uploadedFile);

                
            $manager->persist($category);
            $categories[] = $category;
        }


        // ! status pour les articles

        $statuses= [];
        for ($i = 0; $i <3 ; $i++) {
            $status = new Status();
            $status->setName($faker->getStatusNames($i));
            $manager->persist($status);
            $statuses[] = $status;

        }

        // ! article
        foreach ($faker->getarticleContent as $key => $value) {
            $summary = strlen($value) > 100 ? substr($value, 0, 50) . '...' : $value;
            $article = (new Article)

                ->setSummary($summary)
                ->setContent($value)
                ->setTitle($key)

                ->setCategory($categories[array_rand($categories)])
                ->setUser($users[array_rand($users)]);

                $date = new DateTimeImmutable($faker->dateTimeThisYear()->format('Y-m-d H:i:s'));

                $slug = $this->slugger->slug($key);
                $article->setSlug($slug)
                ->setCreatedAt($date);

            $article->setStatus($statuses[array_rand($statuses)]);

            $manager->persist($article);
        }
    

           // ! city 
           $allCity = [];

           foreach ($faker->getcity as $cityName) {
            $city = (new City)
                ->setName($cityName);
            $manager->persist($city);
            $allCity[] = $city;

            }


        // ! Search Notice
        $searchNotices = [];

        foreach ($faker->getdescriptionSearchNotice as $person) {
            $searchNotice = (new SearchNotice)
                ->setFirstName($person['prenom'])
                ->setLastName($person['nom'])
                ->setDescription($person['description'])
                ->setAge($person['age'])
                ->setPicture($faker->url())
                ->setStatus(mt_rand(0,1))
                ->setUser($users[array_rand($users)])
                ->setHome($person['ville'])
                ->setLatestCity($person['ville']);
                
                $date = new DateTimeImmutable($faker->dateTimeThisYear()->format('Y-m-d H:i:s'));
                $searchNotice ->setCreatedAt($date)
                            ->setLatestDate($date);

            $manager->persist($searchNotice);
            $searchNotices[] = $searchNotice;

        }


         // ! REPORT
         foreach ($faker->getReport as $reportName) {
            $report = (new Report)
                ->setCount($reportName['count'])
                ->setSearchNotice($searchNotices[array_rand($searchNotices)])
                ->setCity($allCity[array_rand($allCity)]);
                $date = new DateTimeImmutable($faker->dateTimeThisYear()->format('Y-m-d H:i:s'));
                $report->setDate($date);

            $manager->persist($report);

        }


        // ! Question pour v2
    //     $questions = [];
    //     for ($i = 1; $i <= 30; $i++) {
    //         $question = (new Question)
    //             ->setTitle($faker->getOneRamdonQuestionName())
    //             ->setContent($faker->paragraph())
    //             ->setCreatedAt(new DateTimeImmutable($faker->date()))
    //             ->setUser($users[array_rand($users)]);

    //         $manager->persist($question);
    //         $questions[] = $question;
    //     }



        // ! Answer pour v2
    //     for ($i = 1; $i <= 30; $i++) {
    //         $answer = (new Answer)
    //             ->setContent($faker->paragraph())
    //             ->setCreatedAt(new DateTimeImmutable($faker->date()))
    //             ->setUser($users[array_rand($users)])
    //             ->setQuestion($questions[array_rand($questions)]);

    //         $manager->persist($answer);
    //     }


     $manager->flush();
     }
}