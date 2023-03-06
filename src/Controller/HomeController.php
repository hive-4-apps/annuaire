<?php

	namespace App\Controller;

	use App\Entity\Membre;
	use App\Entity\Region;
	use ContainerXszImKQ\getRegionRepositoryService;
	use Doctrine\ORM\EntityManagerInterface;
	use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\Routing\Annotation\Route;
	use Symfony\Component\Translation\LocaleSwitcher;
	use Symfony\Contracts\Translation\TranslatorInterface;

	class HomeController extends AbstractController{

		private object $regionRepo;
		private object $memberRepo;
		public array $regions;

		public function __construct(private LocaleSwitcher $localeSwitcher, EntityManagerInterface $entityManager, TranslatorInterface $translator) {
			$this->regionRepo = $entityManager->getRepository(Region::class);
			$this->memberRepo = $entityManager->getRepository(Membre::class);
			$data_regions = $this->regionRepo->findAll();
			$this->regions = [
				0 =>
					[
						'sigle' => 'BR',
						'nom' => 'Brasil',
						'libelle' => $translator->trans( 'au Brésil' )
					]
			];
			foreach ( $data_regions as $data_region ){
				$this->regions[] = [
					'sigle' => $data_region->getSigla(),
					'nom' => $data_region->getEstado(),
					'libelle' => $data_region->getLabelWithPrefix()
				];
			}
		}

		#[Route(['/','/{lang<%app.supported_locales%>}/'], name: 'homepage')]
		public function index( Request $request )
		{

			$currentLocale = $this->localeSwitcher->getLocale();
			$lang_param = $request->query->get('lang');
			$chosen_lang = ( !empty($lang_param)) ? $lang_param : $currentLocale;
			$this->localeSwitcher->setLocale($chosen_lang);
			$members_found = $this->memberRepo->findAllPublishedMemberByRecentlyActive($request);
			return $this->render('home/home.html.twig', [ 'regions'=> $this->regions, 'member_list' => $members_found, 'total_found' => count($members_found) ]);
		}

	}
