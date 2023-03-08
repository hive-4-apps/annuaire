<?php

	namespace App\Autocompleter;

	use App\Entity\Region;
	use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;
	use \Symfony\UX\Autocomplete\EntityAutocompleterInterface;
	use Doctrine\ORM\EntityRepository;
	use Doctrine\ORM\QueryBuilder;
	use Symfony\Component\Security\Core\Security;

	#[AutoconfigureTag('ux.entity_autocompleter', ['alias' => 'region'])]
	class RegionAutocompleter implements EntityAutocompleterInterface {

		/**
		 * @inheritDoc
		 */
		public function getEntityClass(): string {
			return Region::class;
		}

		/**
		 * @inheritDoc
		 */
		public function createFilteredQueryBuilder(EntityRepository $repository, string $query): QueryBuilder {
			return $repository
				->createQueryBuilder('region')
				->andWhere('region.estado LIKE :search')
				->setParameter('search', '%'.$query.'%');
		}

		/**
		* @inheritDoc
		* @param Region $entity
		*/
		public function getLabel(object $entity): string {
			return $entity->getEstado();
		}

		/**
		 * @inheritDoc
		 * @param Region $entity
		 */
		public function getValue(object $entity): mixed {
			return $entity->getId();
		}

		/**
		 * @inheritDoc
		 */
		public function isGranted(Security $security): bool {
			return true;
		}
	}
