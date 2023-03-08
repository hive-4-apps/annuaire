<?php

	namespace App\Autocompleter;

	use App\Entity\StatutPro;
	use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;
	use \Symfony\UX\Autocomplete\EntityAutocompleterInterface;
	use Doctrine\ORM\EntityRepository;
	use Doctrine\ORM\QueryBuilder;
	use Symfony\Component\Security\Core\Security;

	#[AutoconfigureTag('ux.entity_autocompleter', ['alias' => 'statut_professionnel'])]
	class SituationProAutocompleter implements EntityAutocompleterInterface {

		/**
		 * @inheritDoc
		 */
		public function getEntityClass(): string {
			return StatutPro::class;
		}

		/**
		 * @inheritDoc
		 */
		public function createFilteredQueryBuilder(EntityRepository $repository, string $query): QueryBuilder {
			return $repository
				->createQueryBuilder('statutpro')
				->andWhere('statutpro.label LIKE :search')
				->setParameter('search', '%' . $query . '%');
		}

		/**
		 * @inheritDoc
		 * @param StatutPro $entity
		 */
		public function getLabel(object $entity): string {
			return $entity->getLabel();
		}

		/**
		 * @inheritDoc
		 * @param StatutPro $entity
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
