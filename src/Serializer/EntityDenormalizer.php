<?php
// src/Serializer/TopicNormalizer.php
namespace App\Serializer;

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
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class EntityDenormalizer implements DenormalizerInterface
{

    public function __construct(private EntityManagerInterface $entityManager) {
    }

    public function denormalize(mixed $data, string $type, ?string $format = null, array $context = []): mixed
    {
        return $this->entityManager->find($type, $data);
    }


    public function supportsDenormalization(mixed $data, string $type, ?string $format = null, array $context = []): bool
    {
        return strpos($type, 'App\\Entity\\') === 0 && (is_numeric($data) || is_string($data));

    }


    public function getSupportedTypes(?string $format): array
    {
        return
            [
                Pinpoint::class => false,
                Type::class => false,
                City::class =>false,
                SearchNotice::class => false,
                User::class => false,
                Category::class => false,
                Status::class => false,
                Article::class => false,
                Question::class => false,
                Answer::class => false,
                Report::class => false,

            ];
    }
}