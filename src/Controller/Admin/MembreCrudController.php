<?php

	namespace App\Controller\Admin;

	use App\Entity\Membre;
	use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
	use EasyCorp\Bundle\EasyAdminBundle\Config\KeyValueStore;
	use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
	use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
	use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
	use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
	use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
	use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
	use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
	use EasyCorp\Bundle\EasyAdminBundle\Field\TelephoneField;
	use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
	use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
	use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;
	use Symfony\Component\Form\Extension\Core\Type\PasswordType;
	use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
	use Symfony\Component\Form\FormBuilderInterface;
	use Symfony\Component\Form\FormEvent;
	use Symfony\Component\Form\FormEvents;
	use Symfony\Component\HttpFoundation\RedirectResponse;
	use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

	class MembreCrudController extends AbstractCrudController {
		private $pageName;

		public function __construct(public UserPasswordHasherInterface $userPasswordHasher) {

		}

		public static function getEntityFqcn(): string {
			return Membre::class;
		}

		public function configureCrud(Crud $crud): Crud {
			return $crud
				->setEntityLabelInSingular('Membre')
				->setEntityLabelInPlural('Membres');
		}

		public function configureFields(string $pageName): iterable {
			$this->pageName = $pageName;

			// Créez les différents champs
			$fields = [
					IdField::new('username')->onlyOnForms(),
					TextField::new('nom'),
					TextField::new('prenom'),
					TextareaField::new('description')->hideOnIndex(),
					TelephoneField::new('telephone'),
					EmailField::new('email'),
					UrlField::new('lien_web'),
					AssociationField::new('region', 'État')->setFormTypeOption('choice_label', 'estado')->setRequired(false),
					AssociationField::new('municipio', 'Ville')->setFormTypeOption('choice_label', 'nome')->setRequired(false),
					AssociationField::new('statut_professionnel', 'Statut Pro.')->setFormTypeOption('choice_label', 'label'),
					AssociationField::new('activites_pro', 'Métiers')->setFormTypeOption('choice_label', 'appelation_metier'),
					AssociationField::new('centres_interets', 'Centres d´Intérêts')->setFormTypeOption('choice_label', 'label'),
					AssociationField::new('connaissances', 'Compétences et Savoirs')->setFormTypeOption('choice_label', 'label'),
					AssociationField::new('pratiques_asso', 'Activités Associatives/Collectives')->setFormTypeOption('choice_label', 'label'),
					AssociationField::new('etat', 'Statut')->setFormTypeOption('choice_label', 'label'),
					BooleanField::new('termsAndConditions', 'Je confirme mon accord sur les termes et conditions d\'utilisation'),
			];

			// Gérer un champ particulier pour la page "NEW" (Mot de passe)
			if ($pageName === Crud::PAGE_NEW) {
				$fields[] = TextField::new('password')
						->setFormType(RepeatedType::class)
						->setFormTypeOptions([
								'type' => PasswordType::class,
								'first_options' => ['label' => 'Password'],
								'second_options' => ['label' => '(Repeat)'],
								'mapped' => false,
						])
						->setRequired(true)
						->onlyOnForms();
			}

			return $fields; // Retournez directement le tableau de champs
		}

		protected function getRedirectResponseAfterSave(AdminContext $context, string $action): RedirectResponse {


			return parent::getRedirectResponseAfterSave($context, $action);
		}

		public function createNewFormBuilder(EntityDto $entityDto, KeyValueStore $formOptions, AdminContext $context): FormBuilderInterface {
			$formBuilder = parent::createNewFormBuilder($entityDto, $formOptions, $context);
			return $this->addPasswordEventListener($formBuilder);
		}

		public function createEditFormBuilder(EntityDto $entityDto, KeyValueStore $formOptions, AdminContext $context): FormBuilderInterface {
			$formBuilder = parent::createEditFormBuilder($entityDto, $formOptions, $context);

			if ($this->pageName === Crud::PAGE_NEW) {
				return $this->addPasswordEventListener($formBuilder);
			} else {
				return $formBuilder;
			}
		}

		private function addPasswordEventListener(FormBuilderInterface $formBuilder): FormBuilderInterface {
			return $formBuilder->addEventListener(FormEvents::POST_SUBMIT, $this->hashPassword());
		}

		private function hashPassword() {
			return function ($event) {
				$form = $event->getForm();
				if (!$form->isValid()) {
					return;
				}
				$password = $form->get('password')->getData();
				if ($password === null) {
					return;
				}

				$hash = $this->userPasswordHasher->hashPassword($this->getUser(), $password);
				$form->getData()->setPassword($hash);
			};
		}
	}
