<?php

namespace App\Http\Controllers\Api;

use App\Models\Exchange;
use App\Models\User;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Http\Requests\ExchangeRequest;
use App\Filters\ExchangeSearch\ExchangeApprovedSearch;
use App\Filters\ExchangeSearch\ExchangePendingSearch;
use App\Filters\ExchangeSearch\ExchangeRejectSearch;
use App\Http\Resources\Exchange\ExchangeResource;
use App\Http\Resources\Exchange\ExchangeCollection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Services\ExchangeService;
use App\Mail\RequestAward;

class ExchangeController extends ApiController
{
    private $exchange;

    private $service;

    public function __construct(Exchange $exchange, ExchangeService $service)
    {
        setlocale(LC_ALL, "es_ES");
        date_default_timezone_set('America/Caracas');

        $this->exchange = $exchange;
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $exchanges = $this->exchange->where('owner_id', auth()->user()->owner->id)->orderBy('created_at', $request->sort)->paginate($request->per_page);
        return new ExchangeCollection($exchanges);
    }

    public function pending(Request $request)
    {
        if ($request->filled('filter.filters')) {
            return new ExchangeCollection(ExchangePendingSearch::apply($request, $this->exchange));
        }

        $exchanges = ExchangePendingSearch::checkSortFilter($request, $this->exchange->newQuery());

        return new ExchangeCollection($exchanges->paginate($request->take)); 
    }

    public function reject(Request $request)
    {
        if ($request->filled('filter.filters')) {
            return new ExchangeCollection(ExchangeRejectSearch::apply($request, $this->exchange));
        }

        $exchanges = ExchangeRejectSearch::checkSortFilter($request, $this->exchange->newQuery());

        return new ExchangeCollection($exchanges->paginate($request->take)); 
    }

    public function approved(Request $request)
    {
        if ($request->filled('filter.filters')) {
            return new ExchangeCollection(ExchangeApprovedSearch::apply($request, $this->exchange));
        }

        $exchanges = ExchangeApprovedSearch::checkSortFilter($request, $this->exchange->newQuery());

        return new ExchangeCollection($exchanges->paginate($request->take)); 
    }

    public function show(Exchange $exchange)
    {
        return new ExchangeResource($exchange); 
    }

    public function store(ExchangeRequest $request)
    {
        DB::beginTransaction();

        try {
            $exchange = $this->exchange->create([
                'quantity' => $request->exchange['quantity'],
                'owner_id' => $request->exchange['owner_id'],
            ]);

            $exchange->tickets()->attach($request->tickets);
            
            // $exchange->tickets()->update(['status' => 0]);
            
            $users = User::where('rol', 'admin')->get();

            foreach ($users->pluck('email') as $recipient) {
                Mail::to($recipient)->queue(new RequestAward($exchange));
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return $this->respondInternalError();
        }

        return $this->respondCreated($exchange);
    }

    public function update(ExchangeRequest $request, Exchange $exchange)
    {
        DB::beginTransaction();

        try {
            $exchange->update($request->all());

            $exchange->tickets()->sync([1]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return $this->respondInternalError();
        }

        return $this->respondUpdated($exchange);
    }

    public function approvedExchange(Exchange $exchange)
    {
        DB::beginTransaction();

        try {
            $exchange->update(['state' => false]);

            $exchange->tickets()->update(['status' => 0]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return $this->respondInternalError();
        }
        return $this->respondUpdated();
    }

    public function rejectExchange(Request $request, Exchange $exchange)
    {
        DB::beginTransaction();

        try {
            $exchange->update(['state' => 2, 'reject' => date('Y-m-d H:i:s')]);

            $exchange->tickets()->whereIn('tickets.id', $request->tickets)->update(['status' => 2]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return $this->respondInternalError();
        }
        return $this->respondUpdated();
    }

    public function deliveredExchange(Exchange $exchange) 
    {
        DB::beginTransaction();

        try {
            $exchange->update(['delivered' => date('Y-m-d H:i:s')]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return $this->respondInternalError();
        }
        return $this->respondUpdated();
    }

    public function destroy(Exchange $exchange)
    {
        DB::beginTransaction();
        try {
            $exchange->delete();
            
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return $this->respondInternalError();
        }
        return $this->respondDeleted();
    }

    public function listPendingPdf(Request $request)
    {
        return $this->service->manyPdfPendingDownload($request);
    }

    public function listPendingExcel(Request $request)
    {
        return $this->service->manyExcelPendingDownload($request);
    }

    public function listRejectPdf(Request $request)
    {
        return $this->service->manyPdfRejectDownload($request);
    }

    public function listRejectExcel(Request $request)
    {
        return $this->service->manyExcelRejectDownload($request);
    }

    public function listApprovedPdf(Request $request)
    {
        return $this->service->manyPdfApprovedDownload($request);
    }

    public function listApprovedExcel(Request $request)
    {
        return $this->service->manyExcelApprovedDownload($request);
    }

    public function listMyExchanges()
    {
        $exchanges =  $this->exchange->forowner()->orderBy('id', 'DESC')->get();
        $pdf = \PDF::loadView('pdf.my-exchanges', ['exchanges' => $exchanges])->setPaper('a4', 'landscape');
        return $pdf->download('my-exchanges.pdf');
    }
}
