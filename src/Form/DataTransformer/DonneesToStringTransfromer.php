<?php

	namespace App\Form\DataTransformer;

	use App\Entity\CentreInteret;
	use App\Entity\Connaissance;
	use App\Entity\Etat;
	use App\Entity\PratiqueAsso;
	use App\Enums\EtatEnum;
	use Doctrine\Common\Collections\ArrayCollection;
	use Doctrine\ORM\EntityManagerInterface;
	use Symfony\Component\Form\DataTransformerInterface;
	use Symfony\Component\Form\Exception\TransformationFailedException;

	abstract class DonneesToStringTransfromer implements DataTransformerInterface {
		protected string $entityName;

		public function __construct(private readonly EntityManagerInterface $entityManager)
		{}

		/**
		 * Transforms an object (CentreInteret|Connaissance|PratiqueAsso) to a string.
		 *
		 * @param  ArrayCollection<CentreInteret|Connaissance|PratiqueAsso>|CentreInteret|Connaissance|PratiqueAsso|null $data_with_status
		 */
		public function transform(mixed $data_with_status) {

			if (null === $data_with_status) {
				return '';
			}

			if( $data_with_status instanceof ArrayCollection ){
				$labels = [];
				if( !$data_with_status->isEmpty() ){
					foreach ($data_with_status->getValues() as $item ){
						$labels[] = $item->getLabel();
					}
				}
				return implode(',', $labels);
			}

			if ( method_exists( $data_with_status, 'getLabel') ){
				return $data_with_status->getLabel();
			}

			return null;

		}

		/**
		 * Transforms a string to an object (CentreInteret|Connaissance|PratiqueAsso).
		 *
		 * @param  string $value
		 * @throws TransformationFailedException if object (CentreInteret|Connaissance|PratiqueAsso) is not found.
		 */
		public function reverseTransform(mixed $value) {
			// no centre_interet string? It's optional, so that's ok
			if (!$value) {
				return new ArrayCollection();
			}
			$dataWithStatusRepository = $this->entityManager
				->getRepository($this->entityName);

			if( str_contains( $value, ',' ) ){
				$str_centres_interets = explode(',', $value );
				$centres_interets = [];
				foreach ( $str_centres_interets as $str_centre_interet ){
					$centres_interets[] = $this->getWithSaveDataWithStatus($dataWithStatusRepository, $str_centre_interet);
				}
				return $centres_interets;
			}
            $collection = new ArrayCollection();
			$entity = $this->getWithSaveDataWithStatus($dataWithStatusRepository, $value);
			$collection->add($entity);
			return $collection;
		}

		/**
		 * @param \Doctrine\ORM\EntityRepository $dataWithStatusRepository
		 * @param mixed $value
		 * @return CentreInteret|Connaissance|PratiqueAsso|null
		 */
		private function getWithSaveDataWithStatus(\Doctrine\ORM\EntityRepository $dataWithStatusRepository, mixed $value): CentreInteret|Connaissance|PratiqueAsso|null {
			$data_With_status = $dataWithStatusRepository
				// query for the data_With_status with this id
				->findOneByLabel($value);

			if (null === $data_With_status) {

				$data_With_status = new $this->entityName();
				$data_With_status->setLabel($value);
				$etatRepository = $this->entityManager->getRepository(Etat::class);
				$etat = $etatRepository->getEtat(EtatEnum::EN_ATTENTE);
				$data_With_status->setEtat($etat);
				$dataWithStatusRepository->save($data_With_status, true);
			}
			return $data_With_status;
		}

		public function __get($key)
		{
			if ( !isset(static::$$key))
			{
				throw new \Exception('Child class '.get_called_class().' failed to define static '.$key.' property');
			}

			return static::$$key;
		}
	}
