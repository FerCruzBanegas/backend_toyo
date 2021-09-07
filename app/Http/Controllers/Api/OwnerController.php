<?php

namespace App\Http\Controllers\Api;

use App\Models\Owner;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Http\Requests\OwnerRequest;
use App\Filters\OwnerSearch\OwnerSearch;
use App\Http\Resources\Owner\OwnerResource;
use App\Http\Resources\Owner\OwnerCollection;
use App\Services\OwnerService;
use Illuminate\Support\Facades\DB;

class OwnerController extends ApiController
{
    private $owner;

    private $service;

    public function __construct(Owner $owner, OwnerService $service)
    {
        $this->owner = $owner;
        $this->service = $service;
    }

    public function index(Request $request)
    {
        if ($request->filled('filter.filters')) {
            return new OwnerCollection(OwnerSearch::apply($request, $this->owner));
        }

        $owners = OwnerSearch::checkSortFilter($request, $this->owner->newQuery());

        return new OwnerCollection($owners->paginate($request->take)); 
    }

    public function show(Owner $owner)
    {
        return new OwnerResource($owner); 
    }

    public function store(OwnerRequest $request)
    {
        DB::beginTransaction();

        try {
            $owner = $this->owner->create($request->all());

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return $this->respondInternalError();
        }

        return $this->respondCreated($owner);
    }

    public function update(OwnerRequest $request, Owner $owner)
    {
        DB::beginTransaction();

        try {
            $owner->update($request->all());

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return $this->respondInternalError();
        }

        return $this->respondUpdated($owner);
    }

    public function verified(Request $request)
    {
        try {
            $this->owner->whereIn('id', $request->owners)->update(['verified' => true]);
        } catch (\Exception $e) {
            return $this->respondInternalError();
        }
        return $this->respondUpdated();
    }

    public function destroy(Owner $owner)
    {
        DB::beginTransaction();
        try {
            $owner->delete();
            
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

    public function listing()
    {
        $owners = $this->owner->listOwners();
        return $this->respond($owners);
    }
}
