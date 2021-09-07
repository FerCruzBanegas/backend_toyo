<?php

namespace App\Exports\Excel;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;

class OwnersExport implements FromCollection
{
	use Exportable;

	private $owners;

	public function __construct($owners)
    {
        $this->owners = $owners;
    }

    public function collection()
    {
        return collect($this->owners);
    }
}
