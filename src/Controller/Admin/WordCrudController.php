<?php

namespace App\Controller\Admin;

use App\Entity\Word;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class WordCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Word::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name'),
            TextEditorField::new('definition'),
            TextEditorField::new('exemple'),
            BooleanField::new('isPublish'),
            BooleanField::new('isPub'),
            BooleanField::new('isOnline'),
            BooleanField::new('isCrush'),
        ];
    }
}
