<?php

namespace App\Controller\Api\V1;

use App\Entity\City;
use App\Entity\Report;
use App\Entity\SearchNotice;
//use App\Entity\City;
use App\Repository\CityRepository;
use App\Repository\ReportRepository;
use App\Repository\SearchNoticeRepository;
use App\Service\EntityNotFound;
use App\Service\UploaderService;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\ArgumentResolver\EntityValueResolver;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;


#[Route('api/v1/', name: 'app_search_notice_')]
class SearchNoticeController extends AbstractController
{
    private UploaderService $uploaderService;

    public function __construct(EntityNotFound $entityNotFound,UploaderService $uploaderService)
    {
        $this->uploaderService = $uploaderService;

    }

    #[Route('search-notice', name: 'browse', methods: ['GET'])]
    public function browse(SearchNoticeRepository $searchNoticeRepository): JsonResponse
    {
        return $this->json($searchNoticeRepository->findAll(), 200, [], ['groups' => SearchNotice::DEFAULT_SERIALIZATION_GROUP]);
    }

    #[Route('search-notice/{id<\d+>}', name: 'read', methods: ['GET'])]
    public function read(SearchNoticeRepository $searchNoticeRepository, int $id): JsonResponse
    {
        $searched = $searchNoticeRepository->find($id);

        if (!$searched) {
            throw $this->createNotFoundException('Notice not found');
        }

        return $this->json($searched, 200, [], ['groups' => SearchNotice::DEFAULT_SERIALIZATION_GROUP]);
    }

    /**
     * @param SearchNoticeRepository $searchNoticeRepository
     * @param int $id
     * @param CityRepository $cityRepository
     * @param EntityManagerInterface $entityManager
     * @param Request $request
     * @param ValidatorInterface $validator
     * @return JsonResponse
     *
     * This method takes a city, a date and a search-notice id in the request
     * it compares the city and dates with the existing data in the search-notice
     * it updates or creates a report linking the search-notice with the city
     */
    #[Route('search-notice/{id<\d+>}', name: 'report', methods: ['PUT'])]
    public function report(SearchNoticeRepository $searchNoticeRepository,
                              int $id,
                              CityRepository $cityRepository,
                              EntityManagerInterface $entityManager,
                              Request $request,
                              ValidatorInterface $validator): JsonResponse
    {
        // get the search notice from its id and check if it exists
        $searchNotice = $searchNoticeRepository->find($id);
        if (!$searchNotice) {
            throw $this->createNotFoundException('Search-notice not found');
        }

        // decode the json request into an associative array
        $spottedArray = json_decode($request->getContent(), true);

        // get the city name and the date from the array
        $cityName = $spottedArray['city'];
        $dateInput = $spottedArray['date'];
        // transform the date into a datetimeimmutable object, so it can be used by the repository
        $dateTime = DateTimeImmutable::createFromFormat('Y-m-d\TH:i:s.vP', $dateInput);

        // Initialize data to use in the following code :
        // 1. create a variable to check if the city is already in the DB
        $isAlreadyInDb = $cityRepository->findBy(['name' => $cityName]);
        // 2. get a list of all reports already existing for the search notice (if any)
        $reportList = $searchNotice->getReports();
        // 3. initialize an array to get the final objects created and/or updated
        $data = [];

        // if the city does not already exist in the DB :
        if (!$isAlreadyInDb) {
            // 1. create a new city object to put in
            $city = new City();
            $city->setName($cityName);
            // 2. create a new report and fill it with the search-notice and the city + initialize its count to 1
            $report = new Report();
            $city->addReport($report);
            $searchNotice->addReport($report);
            $report->setDate($dateTime);
            $report->setCount(1);
            // 3. persist the new city and report in the DB
            $entityManager->persist($city);
            $entityManager->persist($report);
            // 4. complete the data array
            $data[] = $city;
            $data[] = $report;
        }
        // if the city already exists in DB
        else {
            // 1. put it in an easier variable to use and complete the data array with it
            $city = $isAlreadyInDb[0];
            $data[] = $city;
            // 2. set a boolean that will check if the city already exists in the reports list
            $cityReportExist = false;
            // 3. search the reports list to see if the city exists in it
            foreach ($reportList as $report) {
                // 3.1 if it exists :
                // add one to the count and set the new date only if it's nearer in time than the date already set
                // complete the data array and set the boolean to true
                if ($city->getId() === $report->getCity()->getId()) {
                    $report->setCount($report->getCount() + 1);
                    if ($report->getDate() < $dateTime) {
                        $report->setDate($dateTime);
                    }
                    $data[] = $report;
                    $cityReportExist = true;
                }
            }
            // 3.2 if the city doesn't exist in the list :
            // create a new report and add it to the city and the search notice
            // initialize the count to 1
            // persist the new report in the DB and complete the data array
            if (!$cityReportExist) {
                $report = new Report();
                $city->addReport($report);
                $searchNotice->addReport($report);
                $report->setDate($dateTime);
                $report->setCount(1);
                $entityManager->persist($report);
                $data[] = $report;
            }
        }

        // to complete the info in the search-notice we need to check the date vs the one already in it
        // if the new date is more recent, then it'll take the place with its associated city
        $latestDate = $dateTime;
        $latestCity = $cityName;
        foreach ($reportList as $report) {
            if ($latestDate < $report->getDate()) {
                $latestDate = $report->getDate();
                $latestCity = $report->getCity()->getName();
            }
        }
        $searchNotice->setLatestDate($latestDate);
        $searchNotice->setLatestCity($latestCity);
        // complete the data array
        $data[] = $searchNotice;

        // use the data array to check if all the objects created or updated are valid
        foreach ($data as $object) {
            $errors = $validator->validate($object);
            if (count($errors) > 0) {
                return $this->json($errors, 400);
            }
        }

        // if everything is ok : update the DB
        $entityManager->flush();

        // get the elements needed to update the frontend of the app
        $highest = [];
        $highestCount = 0;
        foreach ($searchNotice->getReports() as $report) {
            if ($highestCount < $report->getCount()) {
                $highestCount = $report->getCount();
                $highest = ['city' => $report->getCity()->getName(), 'count' => $report->getCount()];
            }
        }
        $dataOutput = ['id'=> $id, 'highest' => $highest, 'latest' => [$latestDate, $latestCity]];

        return $this->json($dataOutput, 200, [], ['groups' => SearchNotice::DEFAULT_SERIALIZATION_GROUP]);
    }

    /**
     * @param SearchNoticeRepository $searchNoticeRepository
     * @param int $id
     * @param EntityManagerInterface $entityManager
     * @param ValidatorInterface $validator
     * @return JsonResponse
     *
     * This method takes a search-notice id and updates its status from 0 to 1 (meaning the person had been found)
     */
    #[Route('search-notice/{id<\d+>}', name: 'found', methods: ['PATCH'])]
    public function found(SearchNoticeRepository $searchNoticeRepository,
                          int $id,
                          EntityManagerInterface $entityManager,
                          ValidatorInterface $validator): JsonResponse
    {
        $foundNotice = $searchNoticeRepository->find($id);

        if (!$foundNotice) {
            throw $this->createNotFoundException('Notice not found');
        }

        $foundNotice->setStatus(1);

        $errors = $validator->validate($foundNotice);

        if (count($errors) > 0) {
            return $this->json($errors, 400);
        }

        $entityManager->flush();

        return $this->json('Person found', 200, []);
    }

    #[Route('search-notice', name: 'add', methods: ['POST'])]
    public function add(Request $request,
                        SerializerInterface $serializer,
                        ValidatorInterface $validator,
                        EntityManagerInterface $entityManager): JsonResponse
    {
        // get all the data from the request : returns an array with all the elements in string format
        $data = $request->request->all();
        // encode the data into json with a numeric check so that the strings are converted back to number when necessary (ie 'age')
        $jsonData = json_encode($data, JSON_NUMERIC_CHECK);
        // deserialize the result
        $newSearchNotice = $serializer->deserialize($jsonData, SearchNotice::class, 'json');

        $uploadResponse = $this->uploaderService->uploadFile($request, $newSearchNotice, 'searchnotices');

         // if the service returns a response, it means there's an error
         if ($uploadResponse instanceof JsonResponse) {
             return $uploadResponse;
         }

        $newSearchNotice->setStatus(0);
        $newSearchNotice->setCreatedAt(new \DateTimeImmutable('now'));

        $errors = $validator->validate($newSearchNotice);

        if (count($errors) > 0) {
            return $this->json($errors, 400);
        }

        $entityManager->persist($newSearchNotice);

        $this->uploaderService->uploadFileAfterPersit($request, $newSearchNotice, 'searchnotices');

        $entityManager->flush();

        return $this->json($newSearchNotice, 201, [], ['groups' => SearchNotice::DEFAULT_SERIALIZATION_GROUP]);
    }

    #[Route('search-notice/{id<\d+>}', name: 'delete', methods: ['DELETE'])]
    public function delete(SearchNoticeRepository $searchNoticeRepository,
                           int $id,
                           EntityManagerInterface $entityManager): JsonResponse
    {
        $searchNotice = $searchNoticeRepository->find($id);

        if (!$searchNotice) {
            throw $this->createNotFoundException('Notice not found');
        }

        $entityManager->remove($searchNotice);
        $entityManager->flush();

        return $this->json('Notice successfully deleted', 200);
    }

}

