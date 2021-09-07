<?php

namespace App\Http\Controllers\Api;

use App\Models\City;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Http\Requests\CityRequest;
use App\Filters\CitySearch\CitySearch;
use App\Http\Resources\City\CityResource;
use App\Http\Resources\City\CityCollection;
use App\Services\CityService;
use Illuminate\Support\Facades\DB;

class CityController extends ApiController
{
    private $city;

    private $service;

    public function __construct(City $city, CityService $service)
    {
        $this->city = $city;
        $this->service = $service;
    }

    public function index(Request $request)
    {
        if ($request->filled('filter.filters')) {
            return new CityCollection(CitySearch::apply($request, $this->city));
        }

        $cities = CitySearch::checkSortFilter($request, $this->city->newQuery());

        return new CityCollection($cities->paginate($request->take)); 
    }

    public function show(City $city)
    {
        return new CityResource($city); 
    }

    public function store(CityRequest $request)
    {
        DB::beginTransaction();

        try {
            $city = $this->city->create($request->all());

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return $this->respondInternalError();
        }

        return $this->respondCreated($city);
    }

    public function update(CityRequest $request, City $city)
    {
        DB::beginTransaction();

        try {
            $city->update($request->all());

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return $this->respondInternalError();
        }

        return $this->respondUpdated($city);
    }

    public function destroy(Request $request)
    {
        DB::beginTransaction();
        try {
            $data = [];
            $cities = $this->city->find($request->cities);
            foreach ($cities as $city) {
                $model = $city->secureDelete();
                if ($model) {
                    $data[] = $city;
                }
            }
            
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return $this->respondInternalError();
        }
        return $this->respondDeleted($data);
    }

    public function listPdf(Request $request)
    {
        return $this->service->manyPdfDownload($request);
    }
    
    public function listExcel(Request $request) 
    {
        return $this->service->manyExcelDownload($request);
    }

    public function listing()
    {
        $cities = $this->city->listCities();
        return $this->respond($cities);
    }
}
