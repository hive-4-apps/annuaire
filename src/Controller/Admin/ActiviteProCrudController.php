<?php

namespace App\Controller\Admin;

use App\Entity\ActivitePro;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ActiviteProCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ActivitePro::class;
    }

		public function configureCrud(Crud $crud): Crud
		{
			return $crud
				->setEntityLabelInSingular('Métier')
				->setEntityLabelInPlural('Métiers');
		}

		public function configureActions(Actions $actions): Actions
		{
			return parent::configureActions($actions)
				->disable(Action::NEW)
				->disable(Action::EDIT)
				->disable(Action::DELETE);
		}

		public function configureFields(string $pageName): iterable
		{
			$fields = [
				yield IdField::new('id')->hideOnDetail()->hideOnForm(),
				yield TextField::new('appelation_metier')->setRequired(true)->setLabel('Libellé'),
				yield TextField::new('appelation_domaine')->setRequired(true)->setLabel('Domaine'),
			];
			return $fields;
		}
}
