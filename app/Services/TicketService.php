<?php

namespace App\Services;

use App\Models\Ticket;
use Illuminate\Http\Request;
use App\Exports\PdfExport;
use App\Exports\Excel\TicketsExport;
use App\Transformers\TicketTransformer;

class TicketService
{
    protected $transformer;

    public function __construct(TicketTransformer $transformer)
    {
        $this->transformer = $transformer;
    }

    public function manyPdfDownload(Request $request) 
    {
        if (empty($request->ticket)) {
            $tickets = $this->transformer->collection(Ticket::desc()->get());
        } else {
            $tickets = $this->transformer->collection(Ticket::in($request->ticket)->get());
        }

        $export = new PdfExport('pdf.ticket-list', $tickets);
        return $export->setLetterLandscape()->download();
    }

    public function manyExcelDownload(Request $request) 
    {
        if (empty($request->ticket)) {
            $tickets = $this->transformer->collection(Ticket::desc()->get());
        } else {
            $tickets = $this->transformer->collection(Ticket::in($request->ticket)->get());
        }

        return (new TicketsExport($tickets))->download('tickets.xlsx');
    }
}
