<?php

namespace App\Controller\Admin;

use App\Entity\ActivitePro;
use App\Entity\CentreInteret;
use App\Entity\Connaissance;
use App\Entity\Membre;
use App\Entity\PratiqueAsso;
use App\Entity\StatutPro;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
		#[IsGranted('ROLE_ADMIN')]
		#[Route('%ADMIN_ROOT_PATH%', name: 'admin')]
    public function index(): Response
    {
				// return $this->render('admin/index.html.twig');
				// return parent::index();

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        return $this->redirect($adminUrlGenerator->setController(MembreCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('some/path/my-dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Annuaire');
    }

    public function configureMenuItems(): iterable
    {
        // yield MenuItem::linkToDashboard('Tableau de bord', 'fa fa-home');
				yield MenuItem::linkToCrud('Membres', 'fa fa-user-circle', Membre::class);
				yield MenuItem::subMenu('Données', 'fa fa-list')
					->setSubItems([
						MenuItem::linkToCrud('Statuts Pro.', 'fa fa-id-badge', StatutPro::class),
						MenuItem::linkToCrud('Métiers', 'fa fa-user-nurse', ActivitePro::class),
						MenuItem::linkToCrud('Centres Intérêts', 'fa fa-person-biking', CentreInteret::class),
						MenuItem::linkToCrud('Connaissances', 'fa fa-person-chalkboard', Connaissance::class),
						MenuItem::linkToCrud('Pratiques Asso.', 'fa fa-people-group', PratiqueAsso::class),
					]);
    }
}
