<?php

	namespace App\Autocompleter;

	use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;
	use \Symfony\UX\Autocomplete\EntityAutocompleterInterface;
	use App\Entity\Municipio;
	use Doctrine\ORM\EntityRepository;
	use Doctrine\ORM\QueryBuilder;
	use Symfony\Component\Security\Core\Security;

	#[AutoconfigureTag('ux.entity_autocompleter', ['alias' => 'municipio'])]
	class MunicipioAutocompleter implements EntityAutocompleterInterface {

		/**
		 * @inheritDoc
		 */
		public function getEntityClass(): string {
			return Municipio::class;
		}

		/**
		 * @inheritDoc
		 */
		public function createFilteredQueryBuilder(EntityRepository $repository, string $query): QueryBuilder {
			$query = $repository
				->createQueryBuilder('mun')
				->select('mun.nome')
				->andWhere('mun.nome LIKE :search')
				->setParameter('search', '%'.$query.'%')
				->distinct();
				/*->groupBy('municipio.nome')*/	;
				die($query->getQuery()->getSQL());
				return $query;
		}

		/**
		 * @inheritDoc
		 * @param Municipio $entity
		 */
		public function getLabel(object $entity): string {
			return $entity->getNome();
		}

		/**
		 * @inheritDoc
		 * @param Municipio $entity
		 */
		public function getValue(object $entity): mixed {
			return $entity->getId();
		}

		/**
		 * @inheritDoc
		 */
		public function isGranted(Security $security): bool {
			// TODO: Implement isGranted() method.
			return true;
		}
	}
