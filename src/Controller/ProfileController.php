<?php

	namespace App\Controller;

	use App\Entity\StatutPro;
	use Doctrine\ORM\EntityManagerInterface;
	use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
	use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\Routing\Annotation\Route;

	class ProfileController extends AbstractController {

		private object $statutProRepo;
		public array $statuts_professionnels;

		public function __construct( EntityManagerInterface $entityManager ) {
			/*$this->statutProRepo = $entityManager->getRepository(StatutPro::class);
			$this->statuts_professionnels = [];
			$data_statuts_professionnels = $this->statutProRepo->findAll();

			foreach ($data_statuts_professionnels as $data_statut_professionnel) {
				$this->statuts_professionnels[] = [
					'value' => $data_statut_professionnel->getId(),
					'label' => $data_statut_professionnel->getLabel()
				];
			}*/
		}

		#[IsGranted('ROLE_USER')]
		#[Route(['/profile', '/profile/{lang<%app.supported_locales%>}/'], name: 'app_profile_index')]
		public function index(Request $request) {
			return $this->render('member/profile.html.twig', []);
		}
	}
