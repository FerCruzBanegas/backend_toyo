<?php

namespace App\Services;

use App\Models\City;
use Illuminate\Http\Request;
use App\Exports\PdfExport;
use App\Exports\Excel\CitiesExport;
use App\Transformers\CityTransformer;

class CityService
{
    protected $transformer;

    public function __construct(CityTransformer $transformer)
    {
        $this->transformer = $transformer;
    }

    public function manyPdfDownload(Request $request) 
    {
        if (empty($request->city)) {
            $cities = $this->transformer->collection(City::desc()->get());
        } else {
            $cities = $this->transformer->collection(City::in($request->city)->get());
        }

        $export = new PdfExport('pdf.city-list', $cities);
        return $export->setLetterLandscape()->download();
    }

    public function manyExcelDownload(Request $request) 
    {
        if (empty($request->city)) {
            $cities = $this->transformer->collection(City::desc()->get());
        } else {
            $cities = $this->transformer->collection(City::in($request->city)->get());
        }

        return (new CitiesExport($cities))->download('cities.xlsx');
    }
}
