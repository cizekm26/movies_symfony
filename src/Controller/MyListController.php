<?php

namespace App\Controller;

use App\Entity\MyList;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MyListController extends AbstractController
{
    public function __construct(
        private bool $isDebug
    ){}

    #[Route('/list/new', name:'app_list_new')]
    public function new(EntityManagerInterface $entityManager): Response
    {
        $list = new MyList();
        $list->setTitle('Náhodný seznam filmů');
        $list->setDescription('Seznam oblíbených filmů');
        $genres = ['akční', 'komedie', 'drama'];
        $list->setGenre($genres[array_rand($genres)]);
        $list->setMovieCount(rand(5, 20));
        $list->setRating(rand(1, 10));

        $entityManager->persist($list);
        $entityManager->flush();

        return new Response(sprintf(
            'New list %d with %d movies was added',
            $list->getId(),
            $list->getMovieCount()
        ));
    }
}