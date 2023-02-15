<?php

namespace App\Controller;

use App\Form\OrderType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrderController extends AbstractController
{
    #[Route('/commande', name: 'app_order')]
    public function index(): Response
    {
        if (!$this->getUser()->getAddresses()->getValues()) {
            return $this->redirectToRoute('app_address_new');
        }

        $form = $this->createForm(OrderType::class, null, [
            'user' =>$this->getUser(),//Pour récuperer uniquement les adresses du User connecté.
        ]);

        return $this->render('order/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
