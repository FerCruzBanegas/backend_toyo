<?php

namespace App\Http\Controllers\Api;

use App\Models\Customer;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Http\Requests\CustomerRequest;
use App\Filters\CustomerSearch\CustomerSearch;
use App\Http\Resources\Customer\CustomerResource;
use App\Http\Resources\Customer\CustomerCollection;
use App\Filters\CustomerSearch\Searches\CustomersFilter;
use App\Services\CustomerService;
use Illuminate\Support\Facades\DB;

class CustomerController extends ApiController
{
    private $customer;

    private $service;

    public function __construct(Customer $customer, CustomerService $service)
    {
        $this->customer = $customer;
        $this->service = $service;
    }

    public function index(Request $request)
    {
        if ($request->filled('filter.filters')) {
            return new CustomerCollection(CustomerSearch::apply($request, $this->customer));
        }

        $customers = CustomerSearch::checkSortFilter($request, $this->customer->newQuery());

        return new CustomerCollection($customers->paginate($request->take)); 
    }

    public function show(Customer $customer)
    {
        return new CustomerResource($customer); 
    }

    public function store(CustomerRequest $request)
    {
        DB::beginTransaction();

        try {
            $customer = $this->customer->create($request->all());

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return $this->respondInternalError();
        }

        return $this->respondCreated($customer);
    }

    public function update(CustomerRequest $request, Customer $customer)
    {
        DB::beginTransaction();

        try {
            $customer->update($request->all());

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return $this->respondInternalError();
        }

        return $this->respondUpdated($customer);
    }

    public function destroy(Customer $customer)
    {
        DB::beginTransaction();
        try {
            $customer->delete();
            
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return $this->respondInternalError();
        }
        return $this->respondDeleted();
    }

    public function search(CustomersFilter $filters)
    {
        $customers = $this->customer->filter($filters)->get();
        return $this->respond($customers);
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
        $customers = $this->customer->listCustomers();
        return $this->respond($customers);
    }
}
