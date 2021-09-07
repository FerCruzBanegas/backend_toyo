<?php

namespace App\Services;

use App\Models\Owner;
use Illuminate\Http\Request;
use App\Exports\PdfExport;
use App\Exports\Excel\OwnersExport;
use App\Transformers\OwnerTransformer;

class OwnerService
{
    protected $transformer;

    public function __construct(OwnerTransformer $transformer)
    {
        $this->transformer = $transformer;
    }

    public function manyPdfDownload(Request $request) 
    {
        if (empty($request->owner)) {
            $owners = $this->transformer->collection(Owner::desc()->get());
        } else {
            $owners = $this->transformer->collection(Owner::in($request->owner)->get());
        }

        $export = new PdfExport('pdf.owner-list', $owners);
        return $export->setLetterLandscape()->download();
    }

    public function manyExcelDownload(Request $request) 
    {
        if (empty($request->owner)) {
            $owners = $this->transformer->collection(Owner::desc()->get());
        } else {
            $owners = $this->transformer->collection(Owner::in($request->owner)->get());
        }

        return (new OwnersExport($owners))->download('owners.xlsx');
    }
}
