<?php

namespace App\Repository;

use App\Entity\DemandeContact;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

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
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DemandeContact::class);
    }

    public function save(DemandeContact $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }


    }

	public function getEmailBody( DemandeContact $entity ) : string
	{
		$html = sprintf('<h1>Annuaire des Français.es au Brésil</h1>' );
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
}
