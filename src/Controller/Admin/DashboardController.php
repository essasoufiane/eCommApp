<?php

namespace App\Controller\Admin;

use App\Entity\User;

use App\Entity\Article;
use App\Entity\Category;
use App\Field\VichImageField;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{

    public function __construct(private AdminUrlGenerator $adminUrlGenerator)
    {
    }

    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $url = $this->adminUrlGenerator->setController(UserCrudController::class)->generateUrl();

        return $this->redirect($url);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('ECommApp');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::subMenu('User', 'fas fa-user')->setSubItems([
            MenuItem::linkToCrud('Show User', 'fas fa-eye', User::class)->setAction(Crud::PAGE_INDEX),
            MenuItem::linkToCrud('Create User', 'fas fa-plus', User::class)->setAction(Crud::PAGE_NEW),
        ]);

        yield MenuItem::subMenu('Category', 'fas fa-list')->setSubItems([
            MenuItem::linkToCrud('Show Category', 'fas fa-eye', Category::class)->setAction(Crud::PAGE_INDEX),
            MenuItem::linkToCrud('Create Category', 'fas fa-plus', Category::class)->setAction(Crud::PAGE_NEW),
        ]);

        yield MenuItem::subMenu('Article', 'fas fa-list')->setSubItems([
            MenuItem::linkToCrud('Show Article', 'fas fa-eye', Article::class)->setAction(Crud::PAGE_INDEX),
            MenuItem::linkToCrud('Create Article', 'fas fa-plus', Article::class)->setAction(Crud::PAGE_NEW),
        ]);

        yield MenuItem::linkToRoute('Quitter le dashboard', 'fas fa-door-open', 'app_home');
        yield MenuItem::linkToLogout('Déconnexion', 'fas fa-sign-out-alt');
    }

}
