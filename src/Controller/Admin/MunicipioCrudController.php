<?php

namespace App\Controller\Admin;

use App\Entity\Municipio;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class MunicipioCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Municipio::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('nome')
        ];
    }
}
