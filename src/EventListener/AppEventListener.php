<?php

namespace App\EventListener;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Events;
use Symfony\Component\String\Slugger\SluggerInterface;



//quand article est modifié on ajoute un ecouteur d'evenement pour modifier le slug de l'article
#[AsEntityListener(event: Events::preUpdate, method: 'updateSlug', entity: Article::class)]
class AppEventListener
{

    private $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

  
    public function updateSlug(Article $article):void
    {
        // dd($article);

        $title = $article->getTitle();
        $slug = $this->slugger->slug($title)->lower();

        $article->setSlug($slug);

    }
}
