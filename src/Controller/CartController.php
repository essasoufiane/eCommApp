<?php

namespace App\Controller;

use App\Entity\Article;
use App\Service\Search;
use App\Form\SearchType;
use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


#[Route('/cart')]
class CartController extends AbstractController
{
    #[Route('/index', name: 'app_cart')]
    public function index(ArticleRepository $ArticleRepository, Request $request): Response
    {
        $search = new Search();
        $form = $this->createForm(SearchType::class, $search);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            return $this->render('cart/index.html.twig', [
                'articles' => $ArticleRepository->findWithSearch($search),
                'form' => $form->createView(),
            ]);
        } else {
            return $this->render('cart/index.html.twig', [
                'articles' => $ArticleRepository->findAll(),
                'form' => $form->createView(),
            ]);
        }
    }

    #[Route('/cart_panier', name: 'app_cart_panier')]
    public function panier(ArticleRepository $ArticleRepository, SessionInterface $session): Response
    {
        $panier = $session->get("panier", []);

        $dataPanier = [];
        $total = 0;
        foreach ($panier as $id => $quantity) {
            $article = $ArticleRepository->find($id);
            $dataPanier[] = [
                "produit" => $article,
                "quantite" => $quantity,
            ];
            $total += $article->getPrice() * $quantity;
        }

        return $this->render('cart/panier.html.twig', compact("dataPanier", "total"));
    }

    #[Route('/add/{id}', name: 'app_cart_add')]
    public function add($id, Article $Article, SessionInterface $session): Response
    {
        // On récupère le panier actuel
        $panier = $session->get("panier", []);
        $id = $Article->getId();

        if (!empty($panier[$id])) {
            $panier[$id]++;
        } else {
            $panier[$id] = 1;
        }

        // On sauvegarde dans la session
        $session->set("panier", $panier);
        // dd($session);

        return $this->redirectToRoute("app_cart_panier");
    }

    #[Route('/remove/{id}', name: 'app_cart_remove')]
    public function remove($id, Article $Article, SessionInterface $session): Response
    {
        // On récupère le panier actuel
        $panier = $session->get("panier", []);
        $id = $Article->getId();

        if (!empty($panier[$id])) {

            if ($panier[$id] > 1) {
                $panier[$id]--;
            } else {
                unset($panier[$id]);
            }
        }

        // On sauvegarde dans la session
        $session->set("panier", $panier);

        return $this->redirectToRoute("app_cart_panier");
    }

    #[Route('/delete/{id}', name: 'app_cart_delete')]
    public function delete($id, Article $Article, SessionInterface $session): Response
    {
        // On récupère le panier actuel
        $panier = $session->get("panier", []);
        $id = $Article->getId();

        if (!empty($panier[$id])) {
            unset($panier[$id]);
        }

        // On sauvegarde dans la session
        $session->set("panier", $panier);

        return $this->redirectToRoute("app_cart_panier");
    }

    #[Route('/deleteAll/', name: 'app_cart_delete_all')]
    public function deleteAll(SessionInterface $session): Response
    {

        // on efface le panier
        $session->remove("panier");

        return $this->redirectToRoute("app_cart_panier");
    }
}
