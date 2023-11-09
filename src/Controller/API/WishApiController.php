<?php

namespace App\Controller\API;

use ApiPlatform\Doctrine\Orm\Paginator;
use App\Repository\WishRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class WishApiController extends AbstractController {
    public function __invoke(Request $request, WishRepository $wishRepository) {
        $page = 0;
        $w = $wishRepository->createQueryBuilder('w')->orderBy('')
            ->setMaxResults(5)
            ->setFirstResult(($page -1) *5)
            ->getQuery()->getResult();
        return new Paginator($w);
    }
}