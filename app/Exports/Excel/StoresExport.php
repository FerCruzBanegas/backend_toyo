<?php

namespace App\Exports\Excel;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;

class StoresExport implements FromCollection
{
	use Exportable;

	private $stores;

	public function __construct($stores)
    {
        $this->stores = $stores;
    }

    public function collection()
    {
        return collect($this->stores);
    }
}
