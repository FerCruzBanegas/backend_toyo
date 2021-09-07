<?php

namespace App\Exports\Excel;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;

class ExchangesExport implements FromCollection
{
	use Exportable;

	private $exchanges;

	public function __construct($exchanges)
    {
        $this->exchanges = $exchanges;
    }

    public function collection()
    {
        return collect($this->exchanges);
    }
}
