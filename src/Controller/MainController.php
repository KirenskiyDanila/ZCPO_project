<?php

namespace App\Controller;

use App\Entity\Photo;
use App\Form\PhotoType;
use App\Repository\PhotoRepository;
use App\Service\PageFormer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/')]
class MainController extends AbstractController
{
    #[Route('/{page}', name: 'app_pages_index', requirements: ['page' => '\d+'], methods: ['GET'])]
    public function indexPage(PhotoRepository $photoRepository, $page = 1): Response
    {
        $photos=$photoRepository->getAllPhotos($page);
        $totalPhotosReturned = count($photos);
        $disableRightArrow = false;
        if ($totalPhotosReturned == 0) {
            $page = 1;
            $disableRightArrow = true;
        }
        $totalPhotos = count($photoRepository->findAll());
        $maxPages = ceil($totalPhotos / 8);
        $pages = PageFormer::formPagination($page, $maxPages - 1);
        return $this->render('index.html.twig', [
            'photos' => $photos,
            'pages' => $pages,
            'thisPage'=>$page,
            'disableRightArrow' => $disableRightArrow
        ]);
    }
}