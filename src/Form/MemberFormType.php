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
	use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
	use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
	use EasyCorp\Bundle\EasyAdminBundle\Field\TelephoneField;
	use Symfony\Bridge\Doctrine\Form\Type\EntityType;
	use Symfony\Component\Form\AbstractType;
	use Symfony\Component\Form\Extension\Core\Type\PasswordType;
	use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
	use Symfony\Component\Form\Extension\Core\Type\SubmitType;
	use Symfony\Component\Form\Extension\Core\Type\TextareaType;
	use Symfony\Component\Form\FormBuilderInterface;
	use Symfony\Component\Form\FormTypeInterface;
	use Symfony\Component\OptionsResolver\OptionsResolver;

	class MemberFormType extends AbstractType {
		public function buildForm(FormBuilderInterface $builder, array $options): void {
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
				->add('centres_interets', EntityType::class, [
					'class' => CentreInteret::class,
					'choice_label' => 'label',
					'label' => 'Centres d´intérêts',
					'placeholder' => 'Selectionnez vos centres d´intérêts',
					'multiple' => true,
					'autocomplete' => true
				])
				->add('connaissances', EntityType::class, [
					'class' => Connaissance::class,
					'choice_label' => 'label',
					'label' => 'Connaissances',
					'placeholder' => 'Quelles sont vos connaissances',
					'multiple' => true,
					'autocomplete' => true
				])
				->add('pratiques_asso', EntityType::class, [
					'class' => PratiqueAsso::class,
					'choice_label' => 'label',
					'label' => 'Pratiques Associatives ou Collectives',
					'placeholder' => 'Quelques pratiques associatives ou collectives ?',
					'multiple' => true,
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
		}

		public function configureOptions(OptionsResolver $resolver): void {
			$resolver->setDefaults([
				'data_class' => Membre::class,
			]);
		}
	}
