<?php

	namespace App\Controller\Admin\Events;

	use App\Entity\DemandeContact;
	use App\Entity\Etat;
	use App\Entity\Membre;
	use App\Repository\MembreRepository;
	use Doctrine\ORM\EntityManager;
	use Doctrine\ORM\EntityManagerInterface;
	use EasyCorp\Bundle\EasyAdminBundle\Event\AfterEntityBuiltEvent;
	use EasyCorp\Bundle\EasyAdminBundle\Event\AfterEntityUpdatedEvent;
	use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
	use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityUpdatedEvent;
	use Psr\Log\LoggerInterface;
	use Symfony\Bundle\SecurityBundle\Security;
	use Symfony\Component\EventDispatcher\EventSubscriberInterface;
	use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
	use Symfony\Component\Mailer\MailerInterface;
	use Symfony\Component\Mime\Email;

	class MemberEvents implements EventSubscriberInterface {

		private EntityManagerInterface $em;

		protected $security;
		private MailerInterface $mailer;
		private LoggerInterface $logger;

		public function __construct(Security $security, EntityManagerInterface $entityManager, MailerInterface $mailer, LoggerInterface $logger)
		{
			$this->security = $security;
			$this->em = $entityManager;
			$this->mailer = $mailer;
			$this->logger = $logger;
		}

		public static function getSubscribedEvents() {
			return [
				BeforeEntityUpdatedEvent::class => ['sendEmailIfApproved'],
			];
		}

		public function sendEmailIfApproved(BeforeEntityUpdatedEvent $event)
		{

			$entity = $event->getEntityInstance();
			if (!($entity instanceof Membre)) {
				return;
			}

			$originalData = $this->em->getUnitOfWork()->getOriginalEntityData($entity);
			if( $originalData['etat_id'] === 1 && $entity->getEtat()->getId() === 2 ){
				$subject = 'Annuaire des Français - Compte approuvé !';
				$email = (new Email())
					->from('contact@annuaire-fe.com.br')
					->to( $entity->getEmail() )
					->subject($subject)
					->html( $this->getApprovedEmailBody($entity) );
				try {
					$this->mailer->send($email);
					// die('envoi vers ' . $entity->getEmail() );
				} catch (TransportExceptionInterface $e) {
					$log = sprintf('Email non envoyé - Approbation du membre nº %1$s - erreur : [%2$s] %3$s',
						$entity->getId(),
						$e->getCode(),
						$e->getMessage()
					);
					$this->logger->error($log);
				}
			}
		}

		private function getApprovedEmailBody(Membre $entity) {
			$html = sprintf('<h1>Annuaire des Français.es au Brésil</h1>' );
			$html .= sprintf('<h2>Votre compte a bien été approuvé</h2>' );
			$html .= sprintf('<p>Vous faites partie désormais de l\'annuaire et vous pouvez éditer à tout moment votre profil en vous connectant avec votre identifiant et mot de passe que vous avez choisi lors de votre demande.</p>' );
			$html .= '<br/><br/>>';
			$html .= sprintf('<p>Bien Cordialement,</p>' );
			$html .= sprintf('<p>L´équipe de annuaire-fe.com.br</p>' );

			return $html;
		}
	}
