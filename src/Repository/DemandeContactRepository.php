<?php

namespace App\Repository;

use App\Entity\DemandeContact;
use App\Entity\Membre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Psr\Log\LoggerInterface;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

/**
 * @extends ServiceEntityRepository<DemandeContact>
 *
 * @method DemandeContact|null find($id, $lockMode = null, $lockVersion = null)
 * @method DemandeContact|null findOneBy(array $criteria, array $orderBy = null)
 * @method DemandeContact[]    findAll()
 * @method DemandeContact[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DemandeContactRepository extends ServiceEntityRepository
{
    private MailerInterface $mailer;
    private LoggerInterface $logger;
	private MembreRepository $memberRepo;
	public function __construct(ManagerRegistry $registry, MailerInterface $mailer, LoggerInterface $logger, EntityManagerInterface $entityManager)
    {
        parent::__construct($registry, DemandeContact::class);
		$this->mailer = $mailer;
		$this->logger = $logger;
		$this->memberRepo = $entityManager->getRepository(Membre::class);
    }

    public function save(DemandeContact $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }


    }

	public function doIt( DemandeContact $entity, bool $flush = false, $vars = []): array
    {
		$vars['submitted'] = true;
		$vars['alreadyExists'] = false;
		if( !$this->exists( $entity ) ){
			$this->save( $entity, $flush);
			$vars['saved'] = true;
			$memberConcerned = $this->memberRepo->getMemberByRef($entity->getMemberReference());
			if( is_null( $memberConcerned ) )
				return $vars;
			$vars['member_concerned'] = $memberConcerned;
			$subject = 'Demande de contactsur l´annuaire de français du Brésil !';
			$email = (new Email())
				->from('contact@annuaire-fe.com.br')
				->to( $memberConcerned->getEmail() )
				->subject($subject)
				->html( $this->getEmailBody($entity) );
			try {
				$this->mailer->send($email);
				$vars['sent'] = true;
			} catch (TransportExceptionInterface $e) {
				$log = sprintf('Email non envoyé - demande de contact nº %1$s - erreur : [%2$s] %3$s',
					$entity->getId(),
					$e->getCode(),
					$e->getMessage()
				);
				$this->logger->error($log);
				$vars['sent'] = false;
			}
		}else{
			$vars['alreadyExists'] = true;
		}
		return $vars;
    }

	public function getEmailBody( DemandeContact $entity ) : string
	{
		$html = sprintf('<h1>Annuaire des Français·es au Brésil</h1>' );
		$html .= sprintf('<h2>Demande de contact</h2>' );
		$html .= sprintf('<p>Une personne souhaite prendre contact avec vous. Voici ces coordonnées : </p>' );
		$html .= '<ul>';
		$html .= sprintf('<li>Prénom Nom : %1$s %2$s</li>', $entity->getPrenom(), $entity->getNom() );
		$html .= sprintf('<li>Email : %1$s</li>', $entity->getEmail() );
		if( !empty( $entity->getTelephone() ) ){
			$html .= sprintf('<li>Telephone : %1$s</li>', $entity->getTelephone() );
		}
		$html .= sprintf('<li>Motif contact : %1$s</li>', $entity->getMotifContact() );
		$html .= '</ul>';
		return $html;
	}
    public function remove(DemandeContact $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return DemandeContact[] Returns an array of DemandeContact objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('d.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?DemandeContact
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
	private function exists(DemandeContact $entity) {
		$demandeContact = $this->getDemandeContactByEmailAndMemberReference( $entity->getEmail(), $entity->getMemberReference() );
		return ( !is_null( $demandeContact ) );
	}

	public function getDemandeContactByEmailAndMemberReference(?string $email, ?string $memberReference) : ?DemandeContact {
		return $this->createQueryBuilder('d')
            ->andWhere('d.email = :email')
            ->setParameter('email', $email)
			->andWhere('d.member_reference = :ref')
            ->setParameter('ref', $memberReference)
            ->getQuery()
            ->getOneOrNullResult();
	}
}
