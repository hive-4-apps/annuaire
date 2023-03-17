<?php

	namespace App\Controller;

	use App\Entity\DemandeContact;
	use App\Entity\Membre;
	use App\Entity\Region;
	use Doctrine\ORM\EntityManagerInterface;
	use EasyCorp\Bundle\EasyAdminBundle\Field\HiddenField;
	use Psr\Log\LoggerInterface;
	use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
	use Symfony\Component\Mailer\MailerInterface;
	use Symfony\Component\Mime\Email;
	use Symfony\Component\Routing\Annotation\Route;
	use Symfony\Component\Translation\LocaleSwitcher;
	use Symfony\Contracts\Translation\TranslatorInterface;

	class HomeController extends AbstractController {

		private object $regionRepo;
		private object $memberRepo;
		private object $demandeContactRepo;
		public array $regions;

		public function __construct(private LocaleSwitcher $localeSwitcher, EntityManagerInterface $entityManager, TranslatorInterface $translator) {
			$this->regionRepo = $entityManager->getRepository(Region::class);
			$this->memberRepo = $entityManager->getRepository(Membre::class);
			$this->demandeContactRepo = $entityManager->getRepository(DemandeContact::class);
			$data_regions = $this->regionRepo->findAll();
			$this->regions = [
				0 =>
					[
						'sigle' => 'BR',
						'nom' => 'Brasil',
						'libelle' => 'Brésil'
					]
			];
			foreach ($data_regions as $data_region) {
				$this->regions[] = [
					'sigle' => $data_region->getSigla(),
					'nom' => $data_region->getEstado(),
					'libelle' => $data_region->getLabelWithPrefix() //TODO : plus tard si besoin
				];
			}
		}

		#[Route(['/', '/{lang<%app.supported_locales%>}/'], name: 'homepage')]
		public function index(Request $request, TranslatorInterface $translator, MailerInterface $mailer, LoggerInterface $logger ) {

			$currentLocale = $this->localeSwitcher->getLocale();
			$lang_param = $request->query->get('lang');
			$chosen_lang = (!empty($lang_param)) ? $lang_param : $currentLocale;
			$this->localeSwitcher->setLocale($chosen_lang);
			$members_found = $this->memberRepo->findAllPublishedMemberByRecentlyActive($request);
			$label_contact_submit = 'Envoyer la demande';
			$demandeContact = new DemandeContact();
			$form = $this->createForm(\App\Form\MemberContactFormType::class, $demandeContact );
			$home_vars = ['regions' => $this->regions, 'member_list' => $members_found, 'total_found' => count($members_found), 'form' => $form, 'label_contact_submit' => $label_contact_submit];
			$home_vars['form'] = $form->createView();
			$form->handleRequest($request);
			if ($form->isSubmitted() && $form->isValid()) {
				// ... save the meetup, redirect etc.
				/* @var DemandeContact $data*/
				$data = $form->getData();
				$this->demandeContactRepo->save($data, true );
				$home_vars['member_concerned'] = $this->memberRepo->getMemberByEmail( $data->getMemberEmail() );
				$home_vars['saved'] = true;
				$subject = 'Demande de contactsur l´annuaire de français du Brésil !';
				$email = (new Email())
					->from('contact@annuaire-fe.com.br')
					->to( $data->getMemberEmail() )
					->subject($subject)
					->html( $this->demandeContactRepo->getEmailBody($data) );
				try {
					$mailer->send($email);
					$home_vars['sent'] = true;
				} catch (TransportExceptionInterface $e) {
					$log = sprintf('Email non envoyé - demande de contact nº %1$s - erreur : [%2$s] %3$s',
						$data->getId(),
						$e->getCode(),
					    $e->getMessage()
					);
					$logger->error($log);
					$home_vars['sent'] = false;
				}
			}
			return $this->render('home/home.html.twig', $home_vars);
		}
	}
