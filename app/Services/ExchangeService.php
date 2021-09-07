<?php

namespace App\Services;

use App\Models\Exchange;
use Illuminate\Http\Request;
use App\Exports\PdfExport;
use App\Exports\Excel\ExchangesExport;
use App\Transformers\ExchangeTransformer;

class ExchangeService
{
    protected $transformer;

    public function __construct(ExchangeTransformer $transformer)
    {
        $this->transformer = $transformer;
    }

    public function manyPdfPendingDownload(Request $request) 
    {
        if (empty($request->pending)) {
            $exchanges = $this->transformer->collection(Exchange::desc()->pending()->get());
        } else {
            $exchanges = $this->transformer->collection(Exchange::in($request->pending)->pending()->get());
        }

        $export = new PdfExport('pdf.exchange-pending-list', $exchanges);
        return $export->setLetterLandscape()->download();
    }

    public function manyPdfRejectDownload(Request $request) 
    {
        if (empty($request->reject)) {
            $exchanges = $this->transformer->customCollection(Exchange::desc()->reject()->get(), 'reject');
        } else {
            $exchanges = $this->transformer->customCollection(Exchange::in($request->reject)->reject()->get(), 'reject');
        }

        $export = new PdfExport('pdf.exchange-reject-list', $exchanges);
        return $export->setLetterLandscape()->download();
    }

    public function manyPdfApprovedDownload(Request $request) 
    {
        if (empty($request->approved)) {
            $exchanges = $this->transformer->customCollection(Exchange::desc()->approved()->get(), 'approved');
        } else {
            $exchanges = $this->transformer->customCollection(Exchange::in($request->approved)->approved()->get(), 'approved');
        }

        $export = new PdfExport('pdf.exchange-approved-list', $exchanges);
        return $export->setLetterLandscape()->download();
    }

    public function manyExcelPendingDownload(Request $request) 
    {
        if (empty($request->pending)) {
            $exchanges = $this->transformer->collection(Exchange::desc()->pending()->get());
        } else {
            $exchanges = $this->transformer->collection(Exchange::in($request->pending)->pending()->get());
        }

        return (new ExchangesExport($exchanges))->download('exchanges.xlsx');
    }

    public function manyExcelRejectDownload(Request $request) 
    {
        if (empty($request->reject)) {
            $exchanges = $this->transformer->customCollection(Exchange::desc()->reject()->get(), 'reject');
        } else {
            $exchanges = $this->transformer->customCollection(Exchange::in($request->reject)->reject()->get(), 'reject');
        }

        return (new ExchangesExport($exchanges))->download('exchanges.xlsx');
    }

    public function manyExcelApprovedDownload(Request $request) 
    {
        if (empty($request->approved)) {
            $exchanges = $this->transformer->customCollection(Exchange::desc()->approved()->get(), 'approved');
        } else {
            $exchanges = $this->transformer->customCollection(Exchange::in($request->approved)->approved()->get(), 'approved');
        }

        return (new ExchangesExport($exchanges))->download('exchanges.xlsx');
    }
}
