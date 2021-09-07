<?php

namespace App\Filters\CustomerSearch\Searches;

class CustomersFilter extends Filter
{
    protected $filterKeys = [
        'ci' => 'filterByCi',
        'names' => 'filterByNames',
    ];

    protected function filterByCi()
    {
        $this->builder = $this->builder->whereRaw("MATCH (ci) AGAINST (? IN BOOLEAN MODE)" , fullTextWildcardsInitEnd($this->request->input('value')));
    }

    protected function filterByNames()
    {
        $this->builder = $this->builder->whereRaw("MATCH (names, surnames) AGAINST (? IN BOOLEAN MODE)" , fullTextWildcardsInitEnd($this->request->input('value')));
    }
}