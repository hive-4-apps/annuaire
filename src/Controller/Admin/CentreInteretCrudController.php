<?php

	namespace App\Controller\Admin;

	use App\Entity\CentreInteret;
	use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
	use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
	use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
	use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

	class CentreInteretCrudController extends AbstractCrudController {
		public static function getEntityFqcn(): string {
			return CentreInteret::class;
		}

		public function configureCrud(Crud $crud): Crud {
			return $crud
				->setEntityLabelInSingular('Centre d´intérêt')
				->setEntityLabelInPlural('Centres d´intérêts');
		}

		public function configureFields(string $pageName): iterable {
			$fields = [];
			$fields[] = yield TextField::new('label');
			$fields[] = yield AssociationField::new('synonymes', 'Synonymes')->setFormTypeOption('choice_label', 'label');
			$fields[] = yield AssociationField::new('etat', 'Statut')->setFormTypeOption('choice_label', 'label');

			return $fields;
		}

	}
