<?php

namespace App\Controller;

use App\Entity\Wish;
use App\Form\WishType;
use App\Helper\Censurator;
use App\Helper\UploaderFile;
use App\Repository\WishRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/wish')]
#[IsGranted('ROLE_USER')]
class WishController extends AbstractController
{
    #[Route('/list', name: 'wish_list')]
    public function list(WishRepository $wish, EntityManagerInterface $em, Censurator $censurator): Response {
        $list = $wish->findWithCategories($em);
        $sortedList = [];
        $censurator->_1984("merde, de pute!");
        foreach ($list as $wishItem) {
            if(!isset($sortedList[$wishItem->getCategory()->getName()])) {
                $sortedList[$wishItem->getCategory()->getName()] = [];
            }
           $sortedList[$wishItem->getCategory()->getName()][] = $wishItem;
        }
        return $this->render('wish/list.html.twig', [
            'my_list' => $sortedList,
        ]);
    }

    #[Route('/detail/{id}', name: 'detail_wish_list')]
    public function detail(Wish $wish): Response {
        return $this->render('wish/detail.html.twig', [
            'detail' => $wish
        ]);
    }
    #[Route('/create', name: 'wishForm')]
    public function newWish(Request $request, EntityManagerInterface $em, UploaderFile $uploaderFile, Censurator $censurator):Response {
        $wish = new Wish();
        $form = $this->createForm(WishType::class, $wish);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            if($form->get('image_file')->getData() instanceof UploadedFile) {
                $file = $form->get('image_file')->getData();
                $newFileName = $uploaderFile->upload($file, $this->getParameter('upload_dir'), $wish->getAuthor());
                $wish->setImage($newFileName);
            }
            $wish->setDescription($censurator->_1984($form->get('description')->getData()));
            $em->persist($wish);
            $em->flush();
            $this->addFlash('success', 'NEW WISH BABYYY');
            return $this->redirectToRoute('wish_list');
        }

        return $this->render('wish/edit.html.twig', [
            'form' => $form
        ]);
    }
#[Route('rm/{id}', name: 'wishRemove', methods: 'POST')]
    public function removeWish(EntityManagerInterface $em, Wish $wish): Response {
        $em->remove($wish);
        $em->flush();
        $this->addFlash('success', 'Le voeux a été exaucé et est donc supprimé de la bdd');
        return $this->redirectToRoute('wish_list');
    }
}
