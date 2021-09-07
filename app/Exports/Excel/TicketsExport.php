<?php

namespace App\Exports\Excel;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;

class TicketsExport implements FromCollection
{
	use Exportable;

	private $tickets;

	public function __construct($tickets)
    {
        $this->tickets = $tickets;
    }

    public function collection()
    {
        return collect($this->tickets);
    }
}
