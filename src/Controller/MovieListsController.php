<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;
use App\Entity\MyList;
use App\Repository\MyListRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Pagerfanta\Doctrine\ORM\QueryAdapter;
use Pagerfanta\Pagerfanta;

use function Symfony\Component\String\u;

class MovieListsController extends AbstractController
{
    #[Route('/', name: 'app_homepage')]
    public function homepage(Environment $twig): Response
    {
        $movies = [
            ['title' => 'Psí ostrov', 'genre' => 'komedie'],
            ['title' => 'Fargo', 'genre' => 'akční'],
            ['title' => 'Indiana Jones', 'genre' => 'akční'],
            ['title' => 'Zelená míle', 'genre' => 'drama'],
            ['title' => 'Pelíšky', 'genre' => 'komedie'],
        ];

        $html = $twig->render('movies/homepage.html.twig', [
            'title' => 'Nové filmy',
            'movies' => $movies
        ]);

        return new Response($html);
    }

    #[Route('/browse/{slug}', name: 'app_browse')]
    public function browse(MyListRepository $myListRepository, Request $request,string $slug = null): Response
    {
        $genre = $slug ? u(str_replace('-', ' ', $slug))->title(true) : null;
        $queryBuilder = $myListRepository->createOrderedByRatingQueryBuilder($slug);
        $adapter = new QueryAdapter($queryBuilder);
        $pagerfanta = Pagerfanta::createForCurrentPageWithMaxPerPage(
            $adapter,
            $request->query->get('page', 1),
            6
        );
        return $this->render('movies/browse.html.twig', [
            'genre' => $genre,
            'pager' => $pagerfanta,
        ]);
    }

    #[Route('/myList/{slug}', name:'app_list_show')]
    public function show(MyList $list): Response
    {
        return $this->render('list/show.html.twig', [
            'myList' => $list
        ]);
    }

    #[Route('/myList/{slug}/rate', name: 'app_list_rate', methods: ['POST'])]
    public function rate(MyList $myList, Request $request, EntityManagerInterface $entityManager): Response
    {
        $rating = $request->request->get('rating', 0);
        if($rating > 0){
            $myList->setRating($rating);
        }
        $entityManager->flush();
        $this->addFlash('success', 'Hodnocení bylo přidáno');
        return $this->redirectToRoute('app_list_show', [
            'slug' => $myList->getSlug()
        ]);
    }
}