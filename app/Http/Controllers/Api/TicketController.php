<?php

namespace App\Http\Controllers\Api;

use App\Models\Ticket;
use App\Models\Customer;
use App\Models\Exchange;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Http\Requests\TicketRequest;
use App\Filters\TicketSearch\TicketSearch;
use App\Http\Resources\Ticket\TicketResource;
use App\Http\Resources\Ticket\TicketCollection;
use App\Services\TicketService;
use Illuminate\Support\Facades\DB;

class TicketController extends ApiController
{
    private $ticket;

    private $service;

    public function __construct(Ticket $ticket, TicketService $service)
    {
        $this->ticket = $ticket;
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $tickets = $this->ticket->forowner()->orderBy('created_at', $request->sort)->paginate($request->per_page);
        return new TicketCollection($tickets);
    }

    public function general(Request $request)
    {
        if ($request->filled('filter.filters')) {
            return new TicketCollection(TicketSearch::apply($request, $this->ticket));
        }

        $tickets = TicketSearch::checkSortFilter($request, $this->ticket->newQuery());

        return new TicketCollection($tickets->paginate($request->take)); 
    }

    public function available()
    {
        $quantity = auth()->user()->owner->store->city->quantity;

        $tickets = $this->ticket->where('status', 1)->forowner()->get(); 
        return ['data' => new TicketCollection($tickets), 'quantity' => $quantity];
    }

    public function report()
    {
        $quantity = auth()->user()->owner->store->city->quantity;

        $data = [
            'quantity' => $quantity,
            'total' => $this->ticket->forowner()->count(),
            'pending' => $this->ticket->forowner()->where('status', true)->count(),
            'reclaimed' => $this->ticket->forowner()->where('status', false)->count(),
            'exchange' => Exchange::forowner()->where('state', false)->count(),
        ];

        return $this->respond($data);
    }

    public function show(Ticket $ticket)
    {
        return new TicketResource($ticket); 
    }

    public function store(TicketRequest $request)
    {
       
            if($request->filled('customer.id')) {
                $customer = $request->customer;
            } else {
                $customer = Customer::create([
                    'names' => $request->customer['names'],
                    'surnames' => $request->customer['surnames'],
                    'phone' => $request->customer['phone'],
                    'ci' => $request->customer['ci'],
                    'address' => $request->customer['address'],
                ]);
            }
            $ticket = $this->ticket->create([
                'battery_code' => $request->ticket['battery_code'],
                'owner_id' => auth()->user()->owner->id,
                'customer_id' => $customer['id'],
            ]);

        

        return $this->respondCreated($ticket);
    }

    public function update(TicketRequest $request, Ticket $ticket)
    {
        DB::beginTransaction();

        try {
            $ticket->update($request->all());

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return $this->respondInternalError();
        }

        return $this->respondUpdated($ticket);
    }

    public function destroy(Ticket $ticket)
    {
        DB::beginTransaction();
        try {
            $ticket->delete();
            
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return $this->respondInternalError();
        }
        return $this->respondDeleted();
    }

    public function listPdf(Request $request)
    {
        return $this->service->manyPdfDownload($request);
    }
    
    public function listExcel(Request $request) 
    {
        return $this->service->manyExcelDownload($request);
    }

    public function listMyTickets()
    {
        $tickets =  $this->ticket->forowner()->orderBy('id', 'DESC')->get();
        $pdf = \PDF::loadView('pdf.my-tickets', ['tickets' => $tickets])->setPaper('a4', 'landscape');
        return $pdf->download('my-tickets.pdf');
    }
}
