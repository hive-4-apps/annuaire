<?php

	namespace App\Form;

	use App\Entity\ActivitePro;
	use App\Entity\CentreInteret;
	use App\Entity\Connaissance;
	use App\Entity\Membre;
	use App\Entity\Municipio;
	use App\Entity\PratiqueAsso;
	use App\Entity\Region;
	use App\Entity\StatutPro;
	use App\Form\DataTransformer\CentresInteretsToStringTransformer;
	use App\Form\DataTransformer\ConnaissancesToStringTransformer;
	use App\Form\DataTransformer\PratiquesAssoToStringTransformer;
	use Doctrine\ORM\EntityManagerInterface;
	use Symfony\Bridge\Doctrine\Form\Type\EntityType;
	use Symfony\Component\Form\AbstractType;
	use Symfony\Component\Form\Extension\Core\Type\TextType;
	use Symfony\Component\Form\Extension\Core\Type\PasswordType;
	use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
	use Symfony\Component\Form\Extension\Core\Type\SubmitType;
	use Symfony\Component\Form\Extension\Core\Type\TextareaType;
	use Symfony\Component\Form\FormBuilderInterface;
	use Symfony\Component\OptionsResolver\OptionsResolver;

	class MemberFormType extends AbstractType {

		public CentresInteretsToStringTransformer $centreInteretTransformer;
		private EntityManagerInterface $em;
		public ConnaissancesToStringTransformer $connaissancesTransformer;
		public PratiquesAssoToStringTransformer $pratiquesAssoTransformer;

		public function __construct( EntityManagerInterface $entityManager,
									 CentresInteretsToStringTransformer $centreInteretTransformer,
									 ConnaissancesToStringTransformer $connaissancesTransformer,
									 PratiquesAssoToStringTransformer $pratiquesAssoTransformer
		)
		{
			$this->centreInteretTransformer = $centreInteretTransformer;
			$this->connaissancesTransformer = $connaissancesTransformer;
			$this->pratiquesAssoTransformer = $pratiquesAssoTransformer;
			$this->em = $entityManager;
		}
		public function buildForm(FormBuilderInterface $builder, array $options): void {
			$centres_interets = $this->em->getRepository( CentreInteret::class )->getAllLabels();
			$connaissances = $this->em->getRepository( Connaissance::class )->getAllLabels();
			$pratiques_asso = $this->em->getRepository( PratiqueAsso::class )->getAllLabels();
			$builder
				->add('username')
				->add('password', RepeatedType::class, [
					'type' => PasswordType::class,
					'first_options'  => ['label' => 'Mot de passe', 'hash_property_path' => 'password'],
					'second_options' => ['label' => 'Confirmez mot de passe'],
					'mapped' => false,
				] )
				->add('nom')
				->add('prenom')
				->add('email')
				->add('lien_web')
				->add('description', TextareaType::class )
				->add('telephone')
				->add('statut_professionnel', EntityType::class, [
					'class' => StatutPro::class,
					'choice_label' => 'label',
					'label' => 'Statut professionnel',
					'placeholder' => 'Selectionnez votre situation professionnelle',
					'autocomplete' => true
				])
				->add('activites_pro', EntityType::class, [
					'class' => ActivitePro::class,
					'choice_label' => 'appelation_metier',
					'label' => 'Professions',
					'placeholder' => 'Selectionnez vos activités professionnelles',
					'multiple' => true,
					'autocomplete' => true
				])
				->add('centres_interets', TextType::class, [
					'tom_select_options' => [
						'options' => $centres_interets,
						'create' => true,
						'delimiter' => ',',
						'placeholder' => 'Selectionnez vos centres d´intérêts',
						'multiple' => true
					],
					'label' => 'Centres d´intérêts',
					'autocomplete' => true,
				])
				->add('connaissances', TextType::class, [
					'tom_select_options' => [
						'options' => $connaissances,
						'create' => true,
						'delimiter' => ',',
						'placeholder' => 'Quelles sont vos connaissances',
						'multiple' => true
					],
					'label' => 'Connaissances',
					'autocomplete' => true
				])
				->add('pratiques_asso', TextType::class, [
					'tom_select_options' => [
						'options' => $pratiques_asso,
						'create' => true,
						'delimiter' => ',',
						'placeholder' => 'Quelques pratiques associatives ou collectives ?',
						'multiple' => true
					],
					'label' => 'Pratiques Associatives ou Collectives',
					'autocomplete' => true
				])
				->add('region', EntityType::class, [
					'class' => Region::class,
					'choice_label' => 'estado',
					'label' => 'État',
					'placeholder' => 'Selectionnez l´état de résidence',
					'autocomplete' => true
				])
				->add('municipio', EntityType::class, [
					'class' => Municipio::class,
					'choice_label' => 'nome',
					'label' => 'Municipio',
					'placeholder' => 'Selectionnez votre municipalité',
					'autocomplete' => true
				])
				->add('save', SubmitType::class, [
					'attr' => ['class' => 'save btn waves-effect waves-light']
				]);
			$builder->get('centres_interets')
				->addModelTransformer($this->centreInteretTransformer);
			$builder->get('connaissances')
				->addModelTransformer($this->connaissancesTransformer);
			$builder->get('pratiques_asso')
				->addModelTransformer($this->pratiquesAssoTransformer);
		}

		public function configureOptions(OptionsResolver $resolver): void {
			$resolver->setDefaults([
				'data_class' => Membre::class,
			]);
		}
	}
