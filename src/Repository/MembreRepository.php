<?php

	namespace App\Repository;

	use App\Entity\Etat;
	use App\Entity\Membre;
	use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
	use Doctrine\Common\Collections\Criteria;
	use Doctrine\Persistence\ManagerRegistry;
	use http\Client\Request;
	use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
	use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
	use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

	/**
	 * @extends ServiceEntityRepository<Membre>
	 *
	 * @method Membre|null find($id, $lockMode = null, $lockVersion = null)
	 * @method Membre|null findOneBy(array $criteria, array $orderBy = null)
	 * @method Membre[]    findAll()
	 * @method Membre[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
	 */
	class MembreRepository extends ServiceEntityRepository implements PasswordUpgraderInterface {
		public function __construct(ManagerRegistry $registry) {
			parent::__construct($registry, Membre::class);
		}

		public function save(Membre $entity, bool $flush = false): void {
			$this->getEntityManager()->persist($entity);

			if ($flush) {
				$this->getEntityManager()->flush();
			}
		}

		public function remove(Membre $entity, bool $flush = false): void {
			$this->getEntityManager()->remove($entity);

			if ($flush) {
				$this->getEntityManager()->flush();
			}
		}

		/**
		 * Used to upgrade (rehash) the user's password automatically over time.
		 */
		public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void {
			if (!$user instanceof Membre) {
				throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
			}

			$user->setPassword($newHashedPassword);

			$this->save($user, true);
		}

		public function findAllPublishedMemberByRecentlyActive(\Symfony\Component\HttpFoundation\Request $request) {
			$state_filter = $request->query->get('fr'); //fr = filtre region
			$search_filter = $request->query->get('q'); //q = filtre query

			$queryBuilder = $this->createQueryBuilder('m');
			if (!empty($state_filter) && $state_filter !== 'BR') {
				$queryBuilder
					->leftJoin('m.region', 'region')
					->where('region.sigla = :sigla')
					->setParameter('sigla', $state_filter );
			}
			if (!empty(trim($search_filter))) {
				$items_filter = explode( ' ', trim($search_filter));

				$queryBuilder->leftJoin('m.statut_professionnel', 'statut_professionnel');
				$queryBuilder->leftJoin('m.activites_pro', 'activites_pro');
				$queryBuilder->leftJoin('m.centres_interets', 'centres_interets');
				$queryBuilder->leftJoin('m.connaissances', 'connaissances');
				$queryBuilder->leftJoin('m.pratiques_asso', 'pratiques_asso');
				$queryBuilder->leftJoin('m.municipio', 'municipio');
				$orStatements = $queryBuilder->expr()->orX();
				foreach ( $items_filter as $item_filter ){
					if( !empty( trim($item_filter) )){
						$queryBuilder->setParameter('key', '%' . trim($item_filter) . '%' );

						$statutProfessionnelAndStatement = $queryBuilder->expr()->andX(
							$queryBuilder->expr()->eq('statut_professionnel.etat', '2'),
							$queryBuilder->expr()->like('statut_professionnel.label',':key')
						);
						$orStatements->add( $statutProfessionnelAndStatement );

						$activitesProAndStatement = $queryBuilder->expr()->andX(
							$queryBuilder->expr()->like('activites_pro.appelation_metier',  ':key')
						);
						$orStatements->add( $activitesProAndStatement );

						$centreInteretAndStatement = $queryBuilder->expr()->andX(
							$queryBuilder->expr()->eq('centres_interets.etat', '2'),
							$queryBuilder->expr()->like('centres_interets.label',  ':key')
						);
						$orStatements->add( $centreInteretAndStatement );

						$pratiquesAssoAndStatement = $queryBuilder->expr()->andX(
							$queryBuilder->expr()->eq('pratiques_asso.etat', '2'),
							$queryBuilder->expr()->like('pratiques_asso.label',  ':key')
						);
						$orStatements->add( $pratiquesAssoAndStatement );

						$municipioAndStatement = $queryBuilder->expr()->andX(
							$queryBuilder->expr()->like('municipio.nome',  ':key')
						);
						$orStatements->add( $municipioAndStatement );

						$nameAndStatement = $queryBuilder->expr()->andX(
							$queryBuilder->expr()->like('m.prenom',  ':key'),
							$queryBuilder->expr()->like('m.nom',  ':key')
						);
						$orStatements->add( $nameAndStatement );
					}
				}
				$queryBuilder->andWhere($orStatements);
			}
			$queryBuilder
				->andWhere('m.etat = :etat')
				->setParameter('etat', '2')
				->orderBy('m.id', 'DESC')
				->setMaxResults(10);
			// echo $queryBuilder->getQuery()->getSQL();
			return $queryBuilder->getQuery()->getResult();

		}

//    /**
//     * @return Membre[] Returns an array of Membre objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('m.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Membre
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
	}
