<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Doctrine\ORM\Mapping\Id;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CartController extends AbstractController
{
    #[Route('/cart', name: 'app_cart')]
    public function index(ArticleRepository $ArticleRepository): Response
    {
        return $this->render('cart/index.html.twig', [
            'articles' => $ArticleRepository->findAll(),
        ]);
    }

    #[Route('/cart_panier', name: 'app_cart_panier')]
    public function panier(ArticleRepository $ArticleRepository): Response
    {
        return $this->render('cart/panier.html.twig', [
            // 'articles' => $ArticleRepository->findAll(),
        ]);
    }

    #[Route('/add/{id}', name: 'app_cart_add')]
    public function add(Article $article, $id, SessionInterface $session): Response
    {
        // On récupère le panier actuel
        $panier = $session->get("panier", []);

        if (!empty($panier[$id])) {
            $panier[$id]++;
        } else {
            $panier[$id] = 1;
        }

        // On sauvegarde dans la session
        $session->set("panier", $panier);

        return $this->redirectToRoute("app_cart_panier");
    }
}
