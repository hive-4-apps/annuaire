<?php

	namespace App\Controller;

	use App\Entity\DemandeContact;
	use App\Entity\Etat;
	use App\Entity\Membre;
	use App\Enums\EtatEnum;
	use App\Form\type\MemberFormType;
	use App\Repository\DemandeContactRepository;
	use App\Repository\MembreRepository;
	use App\Service\CommonService;
	use Doctrine\ORM\EntityManagerInterface;
	use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
	use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
	use Symfony\Bundle\SecurityBundle\Security;
	use Symfony\Component\Form\Extension\Core\Type\SubmitType;
	use Symfony\Component\Form\Extension\Core\Type\TextType;
	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\HttpFoundation\Response;
	use Symfony\Component\Routing\Annotation\Route;
	use Symfony\Component\Translation\LocaleSwitcher;
	use Symfony\Component\Uid\UuidV4;
	use Symfony\Contracts\Translation\TranslatorInterface;

	class MemberController extends AbstractController {

		private MembreRepository $memberRepo;
		private object $etatRepo;
		private Security $security;
		private CommonService $commonService;
		private DemandeContactRepository $demandeContactRepo;

		public function __construct( EntityManagerInterface $entityManager, Security $security, private LocaleSwitcher $localeSwitcher, CommonService $commonService ) {
			$this->memberRepo = $entityManager->getRepository(Membre::class);
			$this->etatRepo = $entityManager->getRepository(Etat::class);
			$this->security = $security;
			$this->commonService = $commonService;
			$this->demandeContactRepo = $entityManager->getRepository(DemandeContact::class);
		}

		#[Route(['/inscription', '/inscription/{lang<%app.supported_locales%>}/'], name: 'app_subscription_index')]
		public function create(Request $request, TranslatorInterface $translator ) : Response {
			$user = $this->security->getUser();
			if (  $user !== null && in_array('ROLE_USER', $user->getRoles(), true)) {
				return $this->render('member/profile.html.twig');
			}
			$member = new Membre();
			$member->setPrenom('');
			$member->setNom('');
			$member->setEmail('');
			$member->setTelephone('');
			$member->setMunicipio(null);
			$member->setRegion(null);
			$member->setStatutProfessionnel(null);
			$member->setLienWeb('');
			$member->setDescription('');
			$member->setEtat( $this->etatRepo->getEtat( EtatEnum::EN_ATTENTE ) );
			$form =$this->createForm(\App\Form\MemberFormType::class, $member);
			$subcription_vars = ['form' => $form->createView()];


			$form->handleRequest($request);
			// var_dump($form);
			if ($form->isSubmitted() && $form->isValid()) {
				// ... save the meetup, redirect etc.
				/* @var Membre $data*/
				$data = $form->getData();
				$data->setReference( UuidV4::v4() );
				$this->memberRepo->save($data, true );
				$subcription_vars['saved'] = true;
			}
			return $this->render('member/subscription.html.twig', $subcription_vars);
		}


		#[Route(['/membres/{reference}', '/membres/{lang<%app.supported_locales%>}/{refrence}'], name: 'app_subscription_show')]
		public function show(Request $request) {
			$currentLocale = $this->localeSwitcher->getLocale();
			$lang_param = $request->query->get('lang');
			$chosen_lang = (!empty($lang_param)) ? $lang_param : $currentLocale;
			$this->localeSwitcher->setLocale($chosen_lang);
			$member = $this->memberRepo->getMemberByRef( $request->attributes->get('reference') );
			if( $member === null ){
				$this->redirect('/');
			}else{
				$demandeContact = new DemandeContact();
				$form = $this->createForm(\App\Form\MemberContactFormType::class, $demandeContact );
				$url_fr = $this->commonService->getFrenchUrl( $request );
				$url_br = $this->commonService->getBrazilianUrl( $request );
				$form->handleRequest($request);
				$member_vars = ['member' => $member, 'form' => $form, 'url_fr' => $url_fr, 'url_br' => $url_br];

				if ($form->isSubmitted() && $form->isValid()) {
					// ... save the meetup, redirect etc.
					/* @var DemandeContact $data*/
					$data = $form->getData();
					$member_vars = $this->demandeContactRepo->doIt($data, true, $member_vars );
				}
				return $this->render('member/member.html.twig', $member_vars);
			}
		}


		#[IsGranted('ROLE_USER')]
		#[Route(['/profile', '/profile/{lang<%app.supported_locales%>}/'], name: 'app_profile_index')]
		public function update(Request $request) {
			$member = $this->getUser();
			if( $member === null ){
				$this->redirect('/');
			}else{
				$form =$this->createForm(\App\Form\MemberFormType::class, $member);
				$profile_vars = ['form' => $form->createView() ];


				$form->handleRequest($request);
				// var_dump($form);
				if ($form->isSubmitted() && $form->isValid()) {
					// ... save the meetup, redirect etc.
					/* @var Membre $data*/
					$data = $form->getData();
					$this->memberRepo->save($data, true );
					$profile_vars['updated'] = true;
					$profile_vars = ['form' => $form->createView() ];
				}
				return $this->render('member/profile.html.twig',  $profile_vars);
			}
		}

	}
