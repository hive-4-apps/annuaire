<?php

namespace App\Form;

use App\Entity\ActivitePro;
use App\Entity\CentreInteret;
use App\Entity\Connaissance;
use App\Entity\Municipio;
use App\Entity\PratiqueAsso;
use App\Entity\Region;
use App\Entity\StatutPro;
use App\Form\DataTransformer\CentresInteretsToStringTransformer;
use App\Form\DataTransformer\ConnaissancesToStringTransformer;
use App\Form\DataTransformer\PratiquesAssoToStringTransformer;
use App\Repository\MunicipioRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
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

	public function __construct(EntityManagerInterface             $entityManager,
															CentresInteretsToStringTransformer $centreInteretTransformer,
															ConnaissancesToStringTransformer   $connaissancesTransformer,
															PratiquesAssoToStringTransformer   $pratiquesAssoTransformer
	) {
		$this->centreInteretTransformer = $centreInteretTransformer;
		$this->connaissancesTransformer = $connaissancesTransformer;
		$this->pratiquesAssoTransformer = $pratiquesAssoTransformer;
		$this->em = $entityManager;
	}

	public function buildForm(FormBuilderInterface $builder, array $options): void {
		$centres_interets = $this->em->getRepository(CentreInteret::class)->getAllLabels();
		$connaissances = $this->em->getRepository(Connaissance::class)->getAllLabels();
		$pratiques_asso = $this->em->getRepository(PratiqueAsso::class)->getAllLabels();
		$municipios = $this->em->getRepository(Municipio::class)->getAllMunicipiosWithoutDuplicate();
		$regions = $this->em->getRepository(Region::class)->findBy([], ['estado' => 'ASC']);
		$builder
				->add('username', TextType::class, [
						'label' => 'Identifiant',
				])->setRequired(true)
				->add('password', RepeatedType::class, [
						'type' => PasswordType::class,
						'first_options' => ['label' => 'Mot de passe', 'hash_property_path' => 'password'],
						'second_options' => ['label' => 'Confirmez mot de passe'],
						'mapped' => false,
						'required' => true
				])
				->add('nom')
				->add('prenom', TextType::class, [
						'label' => 'Prénom',
				])->setRequired(true)
				->add('email')
				->add('lien_web')->setRequired(false)
				->add('description', TextareaType::class, [
						'attr' => array(
							'placeholder' => 'Votre profil, ou dire pourquoi vous vous inscrivez à l’annuaire...'
						)
				])->setRequired(false)
				->add('telephone')->setRequired(false)
				->add('statut_professionnel', EntityType::class, [
						'class' => StatutPro::class,
						'choice_label' => 'label',
						'label' => 'Statut professionnel',
						'placeholder' => 'Selectionnez votre situation professionnelle',
						'autocomplete' => true
				])->setRequired(false)
				->add('activites_pro', EntityType::class, [
						'class' => ActivitePro::class,
						'choice_label' => 'appelation_metier',
						'label' => 'Professions',
						'placeholder' => 'Selectionnez vos activités professionnelles',
						'multiple' => true,
						'autocomplete' => true
				])->setRequired(false)
				->add('centres_interets', TextType::class, [
						'tom_select_options' => [
								'options' => $centres_interets,
								'create' => true,
								'delimiter' => ',',
								'placeholder' => 'Saisissez vos centres d´intérêts',
								'multiple' => true
						],
						'label' => 'Centres d´intérêts',
						'autocomplete' => true,
				])->setRequired(false)
				->add('connaissances', TextType::class, [
						'tom_select_options' => [
								'options' => $connaissances,
								'create' => true,
								'delimiter' => ',',
								'placeholder' => 'Quelles sont vos compétences et savoirs ?',
								'multiple' => true,
						],
					/*	'attr' => [
							'data-controller' => 'custom-autocomplete',
						],*/
						'label' => 'Compétences et Savoirs',
						'autocomplete' => true
				])->setRequired(false)
				->add('pratiques_asso', TextType::class, [
						'tom_select_options' => [
								'options' => $pratiques_asso,
								'create' => true,
								'delimiter' => ',',
								'placeholder' => 'Quelques activités associatives ou collectives ?',
								'multiple' => true
						],
						'label' => 'Activités Associatives ou Collectives',
						'autocomplete' => true
				])->setRequired(false)
				->add('region', EntityType::class, [
						'class' => Region::class,
						'choice_label' => 'estado',
						'label' => 'État',
						'choices' => $regions,
						'autocomplete' => true,
						'required' => true
				])
				->add('municipio', EntityType::class, [
						'class' => Municipio::class,
						'choice_label' => 'nome',
						'label' => 'Ville',
						'placeholder' => 'Sélectionnez votre ville',
						'autocomplete' => true,
						'choices' => $municipios
				])->setRequired(false)
				->add('save', SubmitType::class, [
						'attr' => ['class' => 'save btn waves-effect waves-light']
				]);
		$builder->get('centres_interets')
				->addModelTransformer($this->centreInteretTransformer)->setRequired(false);
		$builder->get('connaissances')
				->addModelTransformer($this->connaissancesTransformer)->setRequired(false);
		$builder->get('pratiques_asso')
				->addModelTransformer($this->pratiquesAssoTransformer)->setRequired(false);
		$builder
				->add('termsAndConditions', CheckboxType::class, [
						'label'    => 'Je confirme mon accord sur les termes et conditions d\'utilisation'
				])->setRequired(true);
	}

	public function configureOptions(OptionsResolver $resolver): void {
		$resolver->setDefaults([
			/*'centres_interets' => new ArrayCollection(),
			'connaissances' => new ArrayCollection(),
			'pratiques_asso' => new ArrayCollection(),*/
		]);
	}
}
