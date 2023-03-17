<?php

namespace App\Repository;

use App\Entity\PratiqueAsso;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PratiqueAsso>
 *
 * @method PratiqueAsso|null find($id, $lockMode = null, $lockVersion = null)
 * @method PratiqueAsso|null findOneBy(array $criteria, array $orderBy = null)
 * @method PratiqueAsso[]    findAll()
 * @method PratiqueAsso[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PratiqueAssoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PratiqueAsso::class);
    }

    public function save(PratiqueAsso $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(PratiqueAsso $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

	/**
	 * @return object[] Returns an array of PratiqueAsso labels
	 */
	public function getAllLabels(): array
	{
		$output = [];
		$find_all = $this->findAll();
		if( !empty( $find_all ) ){
			foreach ( $find_all as $pratiqueAsso ){
				$obj = new \stdClass();
				$obj->value = $pratiqueAsso->getLabel();
				$obj->text = $pratiqueAsso->getLabel();
				$output[] = $obj;
			}
		}
		return $output;
	}

//    /**
//     * @return PratiqueAsso[] Returns an array of PratiqueAsso objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?PratiqueAsso
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
