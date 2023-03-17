<?php

namespace App\Repository;

use App\Entity\Connaissance;
use App\Entity\Etat;
use App\Enums\EtatEnum;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Connaissance>
 *
 * @method Connaissance|null find($id, $lockMode = null, $lockVersion = null)
 * @method Connaissance|null findOneBy(array $criteria, array $orderBy = null)
 * @method Connaissance[]    findAll()
 * @method Connaissance[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConnaissanceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Connaissance::class);
    }

    public function save(Connaissance $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Connaissance $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

	/**
	 * @return object[] Returns an array of Connaissance labels
	 */
	public function getAllLabels(): array
	{
		$output = [];
		$find_all = $this->findAll();
		if( !empty( $find_all ) ){
			foreach ( $find_all as $connaissance ){
				$obj = new \stdClass();
				$obj->value = $connaissance->getLabel();
				$obj->text = $connaissance->getLabel();
				$output[] = $obj;
			}
		}
		return $output;
	}

//    /**
//     * @return Connaissance[] Returns an array of Connaissance objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Connaissance
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
