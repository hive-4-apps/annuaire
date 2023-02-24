<?php

namespace App\Controller\Admin;

use App\Entity\StatutPro;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class StatutProCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return StatutPro::class;
    }

		public function configureCrud(Crud $crud): Crud
		{
			return $crud
				->setEntityLabelInSingular('Statut Professionnel')
				->setEntityLabelInPlural('Statuts Professionnels');
		}

		public function configureFields(string $pageName): iterable
    {
			return [
				yield TextField::new('label')->setRequired(true),
				yield NumberField::new('ordre')->setNumDecimals(0),
				yield AssociationField::new('etat','État')->setFormTypeOption('choice_label', 'label')
			];
    }
}
