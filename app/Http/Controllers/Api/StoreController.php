<?php

namespace App\Http\Controllers\Api;

use App\Models\Store;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Http\Requests\StoreRequest;
use App\Filters\StoreSearch\StoreSearch;
use App\Http\Resources\Store\StoreResource;
use App\Http\Resources\Store\StoreCollection;
use App\Http\Resources\Store\StoreListCollection;
use App\Services\StoreService;
use Illuminate\Support\Facades\DB;

class StoreController extends ApiController
{
    private $store;

    private $service;

    public function __construct(Store $store, StoreService $service)
    {
        $this->store = $store;
        $this->service = $service;
    }

    public function index(Request $request)
    {
        if ($request->filled('filter.filters')) {
            return new StoreCollection(StoreSearch::apply($request, $this->store));
        }

        $stores = StoreSearch::checkSortFilter($request, $this->store->newQuery());

        return new StoreCollection($stores->paginate($request->take)); 
    }

    public function show(Store $store)
    {
        return new StoreResource($store); 
    }

    public function store(StoreRequest $request)
    {
        DB::beginTransaction();

        try {
            $store = $this->store->create($request->all());

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return $this->respondInternalError();
        }

        return $this->respondCreated();
    }

    public function update(StoreRequest $request, Store $store)
    {
        DB::beginTransaction();

        try {
            $store->update($request->all());

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return $this->respondInternalError();
        }

        return $this->respondUpdated($store);
    }

    public function destroy(Request $request)
    {
        DB::beginTransaction();
        try {
            $data = [];
            $stores = $this->store->find($request->stores);
            foreach ($stores as $store) {
                $model = $store->secureDelete();
                if ($model) {
                    $data[] = $store;
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
        $stores = $this->store->listStores();
        return new StoreListCollection($stores);
    }
}