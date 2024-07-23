<?php

namespace App\Repository;

use App\Entity\CentreInteret;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CentreInteret>
 *
 * @method CentreInteret|null find($id, $lockMode = null, $lockVersion = null)
 * @method CentreInteret|null findOneBy(array $criteria, array $orderBy = null)
 * @method CentreInteret[]    findAll()
 * @method CentreInteret[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CentreInteretRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CentreInteret::class);
    }

    public function save(CentreInteret $entity, bool $flush = false): void
    {
		$this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(CentreInteret $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return object[] Returns an array of CentreInteret labels
     */
    public function getAllLabels(): array
    {
        $output = [];
		$find_all = $this->findAll();
		if( !empty( $find_all ) ){
			foreach ( $find_all as $centreInteret ){
				$obj = new \stdClass();
				$obj->value = $centreInteret->getLabel();
				$obj->text = $centreInteret->getLabel();
				$output[] = $obj;
			}
		}
		return $output;
    }

    public function findOneByLabel($value): ?CentreInteret
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.label = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
