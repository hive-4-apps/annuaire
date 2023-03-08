<?php

	namespace App\Autocompleter;

	use App\Entity\Connaissance;
	use Doctrine\ORM\EntityRepository;
	use Doctrine\ORM\QueryBuilder;
	use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;
	use Symfony\Component\Security\Core\Security;
	use Symfony\UX\Autocomplete\EntityAutocompleterInterface;
	#[AutoconfigureTag('ux.entity_autocompleter', ['alias' => 'connaissance'])]
	class ConnaissanceAutocompleter implements EntityAutocompleterInterface {

		/**
		 * @inheritDoc
		 */
		public function getEntityClass(): string {
			return Connaissance::class;
		}

		/**
		 * @inheritDoc
		 */
		public function createFilteredQueryBuilder(EntityRepository $repository, string $query): QueryBuilder {
			return $repository
				->createQueryBuilder('connaissance')
				->andWhere('connaissance.label LIKE :search')
				->setParameter('search', '%' . $query . '%');
		}

		/**
		 * @inheritDoc
		 * @param Connaissance $entity
		 */
		public function getLabel(object $entity): string {
			return $entity->getLabel();
		}

		/**
		 * @inheritDoc
		 * @param Connaissance $entity
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
