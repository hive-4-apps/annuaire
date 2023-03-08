<?php

	namespace App\Autocompleter;

	use App\Entity\ActivitePro;
	use Doctrine\ORM\EntityRepository;
	use Doctrine\ORM\QueryBuilder;
	use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;
	use Symfony\Component\Security\Core\Security;
	use Symfony\UX\Autocomplete\EntityAutocompleterInterface;

	#[AutoconfigureTag('ux.entity_autocompleter', ['alias' => 'activite_professionnelle'])]
	class ProfessionAutocompleter implements EntityAutocompleterInterface {

		/**
		 * @inheritDoc
		 */
		public function getEntityClass(): string {
			return ActivitePro::class;
		}

		/**
		 * @inheritDoc
		 */
		public function createFilteredQueryBuilder(EntityRepository $repository, string $query): QueryBuilder {
			return $repository
				->createQueryBuilder('activitepro')
				->andWhere('activitepro.appelation_metier LIKE :search')
				->setParameter('search', '%' . $query . '%');
		}

		/**
		 * @inheritDoc
		 * @param ActivitePro $entity
		 */
		public function getLabel(object $entity): string {
			return $entity->getAppelationMetier();
		}

		/**
		 * @inheritDoc
		 * @param ActivitePro $entity
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
