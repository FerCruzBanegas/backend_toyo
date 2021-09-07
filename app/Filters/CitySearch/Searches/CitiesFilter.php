<?php

namespace App\Filters\CitySearch\Searches;

class CitiesFilter extends Filter
{
    protected $filterKeys = [
        'name' => 'filterByName',
    ];

    protected function filterByName()
    {
        $this->builder = $this->builder->whereRaw("MATCH (name) AGAINST (? IN BOOLEAN MODE)" , fullTextWildcardsInitEnd($this->request->input('value')));
    }
}