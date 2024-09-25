<?php

namespace App\Controller;

use App\Entity\Avis;
use App\Entity\Category;
use App\Entity\Comment;
use App\Entity\Post;
use App\Entity\Product;
use App\Form\CommentType;
use App\Repository\CategoryRepository;
use App\Repository\CommentRepository;
use App\Repository\PostRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class FrontController extends AbstractController
{
    #[Route('/', name: 'app_front')]
    public function index(ProductRepository $ProductRepository): Response
    {
        $products = $ProductRepository->findLastProducts();

        // dd(vars: $products);

        return $this->render('front/index.html.twig', [
            // 'controller_name' => 'FrontController',
            'products' => $products,
        ]);
    }

    #[Route('/contact', name: 'app_front_contact')]
    public function contact(): Response
    {
        return $this->render('front/contact.html.twig', [
            'controller_name' => 'FrontController',
        ]);
    }

    #[Route('/about', name: 'app_front_about')]
    public function about(): Response
    {
        return $this->render('front/about.html.twig', [
            'controller_name' => 'FrontController',
        ]);
    }

    #[Route('/catalogue', name: 'app_front_catalogue')]
    public function catalogue(ProductRepository $ProductRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $dql = "SELECT a FROM AcmeMainBundle:Article a";
        $query = $ProductRepository->findAll();

        $products = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            2 /*limit per page*/
        );

        return $this->render('front/catalogue.html.twig', [
            // 'controller_name' => 'FrontController',
            'products' => $products,
        ]);
    }

    #[Route('/catalogue/{id}', name: 'app_front_catalogue_detail')]
    public function catalogueDetail(Product $product): Response
    {
        // dd($product);

        return $this->render('front/catalogue_detail.html.twig', [
            'product' => $product,
        ]);
    }

    #[Route("/categorie/{id}", name: "categorie_show")]
    public function showCategorie(Category $categorie)
    {
        // Logique pour afficher la catégorie
        return $this->render('front/categorie_show.html.twig', [
            'categorie' => $categorie,
        ]);
    }


    #[Route('/actualites', name: 'app_front_actualites')]
    public function actualites(PostRepository $postRepository): Response
    {
        $posts = $postRepository->findAll();

        // dd($posts);

        return $this->render('front/actualites.html.twig', [
            // 'controller_name' => 'FrontController',
            'posts' => $posts,
        ]);
    }
    

    #[Route('/actualites/{id}', name: 'app_front_actualites_detail')]
    public function actualites_show(Post $post, CommentRepository $commentRepository, $id, Request $request, EntityManagerInterface $em): Response
    {
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);
        $user = $this->getUser();

        // $nbr_like = 0;
        // $nbr_dislike = 0;

        // foreach ($post->getComments() as $comments) {
        //     foreach ($comments->getAvis() as $avis) {
        //         if ($avis == true) {
        //             $nbr_like++;
        //         } elseif ($avis == false) {
        //             $nbr_dislike++;
        //         }
        //     }
        // }

        if ($form->isSubmitted() && $form->isValid()) {
            $comment->setPosts($post)->setAuthor($user)->setValid(false);
            $em->persist($comment);
            $em->flush();

            return $this->redirectToRoute('app_front_actualites_detail', ['id' => $post->getId()]);

        }


        return $this->render('front/actualites_detail.html.twig', [
            // 'controller_name' => 'FrontController',
            'post' => $post,
            'form' => $form,
            // 'nbr_like' => $nbr_like,
            // 'nbr_dislike' => $nbr_dislike,
        ]);
    }

    #[Route('/dislike/{id}', name: 'user_dislike')]
    public function dislike(Comment $comment, EntityManagerInterface $em): Response
    {
        $user = $this->getUser();
        $avis = $comment->getAvis();
        $avi = null;

        $isAlreadyAct = false;

        foreach ($avis as $avi){
            if($avi->getUser() == $user){
                $avi->setLiked(false);
                $isAlreadyAct = true;
            }
        }
        if($isAlreadyAct == false){
            $avi = new Avis();
            $avi->setLiked(false)->setUser($user)->setComments($comment);
        }
        $em->persist($avi);
        $em->flush();

        return $this->redirectToRoute('app_front_actualites_detail', ['id'=> $comment->getPosts()->getId()]);

    }

    #[Route('/like/{id}', name: 'user_like')]
    public function like(Comment $comment, EntityManagerInterface $em): Response
    {
        $user = $this->getUser();
        $avis = $comment->getAvis();
        $avi = null;

        $isAlreadyAct = false;

        foreach ($avis as $avi){
            if($avi->getUser() == $user){
                $avi->setLiked(true);
                $isAlreadyAct = true;
            }
        }
        if($isAlreadyAct == false){
            $avi = new Avis();
            $avi->setLiked(true)->setUser($user)->setComments($comment);
        }
        $em->persist($avi);
        $em->flush();

        return $this->redirectToRoute('app_front_actualites_detail', ['id'=> $comment->getPosts()->getId()]);


    }
}
