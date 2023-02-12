<?php

namespace App\Service;


use App\Entity\Category;

class Search
{

    /**
     * @var string
     */
    public ?string $string = '';

    /**
     * @var Category[]
     */
    public  $category = [];
}