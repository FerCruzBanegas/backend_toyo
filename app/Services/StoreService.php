<?php

namespace App\Services;

use App\Models\Store;
use Illuminate\Http\Request;
use App\Exports\PdfExport;
use App\Exports\Excel\StoresExport;
use App\Transformers\StoreTransformer;

class StoreService
{
    protected $transformer;

    public function __construct(StoreTransformer $transformer)
    {
        $this->transformer = $transformer;
    }

    public function manyPdfDownload(Request $request) 
    {
        if (empty($request->store)) {
            $stores = $this->transformer->collection(Store::desc()->get());
        } else {
            $stores = $this->transformer->collection(Store::in($request->store)->get());
        }

        $export = new PdfExport('pdf.store-list', $stores);
        return $export->setLetterLandscape()->download();
    }

    public function manyExcelDownload(Request $request) 
    {
        if (empty($request->store)) {
            $stores = $this->transformer->collection(Store::desc()->get());
        } else {
            $stores = $this->transformer->collection(Store::in($request->store)->get());
        }

        return (new StoresExport($stores))->download('stores.xlsx');
    }
}
