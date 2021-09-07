<?php

namespace App\Exports\Excel;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;

class CitiesExport implements FromCollection
{
	use Exportable;

	private $cities;

	public function __construct($cities)
    {
        $this->cities = $cities;
    }

    public function collection()
    {
        return collect($this->cities);
    }
}
