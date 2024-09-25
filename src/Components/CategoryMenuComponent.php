<?php

namespace App\Components;
use App\Repository\CategoryRepository;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('categoryMenu')]
class CategoryMenuComponent
{
    public function __construct(private CategoryRepository $categoryRepository)
    {

    }

    public function getCategories(){
        return $this->categoryRepository->findAll();
    }

}