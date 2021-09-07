<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CityController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\OwnerController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\StoreController;
use App\Http\Controllers\Api\TicketController;
use App\Http\Controllers\Api\ExchangeController;


Route::get('/test', function (Request $request) {
    // $ex = \App\Models\Exchange::find(29);
    // return $ex->tickets()->update(['status' => 1]);

    $data = \App\Models\Store::find(17);

    $collection = collect($data->owners);

    $total = $collection->reduce(function ($carry, $item) {
        return $carry + $item->tickets->count();
    });

    return $total;
});

Route::prefix('v1')->group(function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
    Route::get('email/verify/{id}', [AuthController::class, 'verify'])->name('verification.verify');
    Route::post('email/resend', [AuthController::class, 'resend'])->name('verification.resend');
    Route::post('password/email', [AuthController::class, 'forgot']);
    Route::post('password/reset', [AuthController::class, 'reset']);

    //listing
    Route::get('cities/listing', [CityController::class, 'listing']);
    Route::get('customers/listing', [CustomerController::class, 'listing']);
    Route::get('owners/listing', [OwnerController::class, 'listing']);
    Route::get('stores/listing', [StoreController::class, 'listing']);

    Route::middleware('auth:api')->group(function () {
        Route::post('logout', [AuthController::class, 'logout']);

        //cities
        Route::get('cities', [CityController::class, 'index']);
        Route::get('cities/{city}',  [CityController::class, 'show']);
        Route::post('cities', [CityController::class, 'store']);
        Route::post('cities/list-pdf', [CityController::class, 'listPdf']);
        Route::post('cities/list-excel', [CityController::class, 'listExcel']);
        Route::put('cities/{city}', [CityController::class, 'update']);
        Route::delete('cities', [CityController::class, 'destroy']);

        //User
        Route::get('users', [UserController::class, 'index']);
        Route::post('users', [UserController::class, 'store']);
        //Route::put('users/state/{user}', [UserController::class, 'changeState']);
        //Route::get('users/{user}/edit', [UserController::class, 'show']);
        Route::put('users/{user}', [UserController::class, 'update']);
        Route::put('users/{user}/password', [UserController::class, 'password']);
        //Route::delete('users', [UserController::class, 'destroy']);

        //owners  verified
        Route::get('owners', [OwnerController::class, 'index']);
        Route::get('owners/{owner}',  [OwnerController::class, 'show']);
        Route::post('owners', [OwnerController::class, 'store']);
        Route::post('owners/verified', [OwnerController::class, 'verified']);
        Route::post('owners/list-pdf', [OwnerController::class, 'listPdf']);
        Route::post('owners/list-excel', [OwnerController::class, 'listExcel']);
        Route::put('owners/{owner}', [OwnerController::class, 'update']);
        Route::delete('owners/{owner}', [OwnerController::class, 'destroy']);

        //stores
        Route::get('stores', [StoreController::class, 'index']);
        Route::get('stores/{store}',  [StoreController::class, 'show']);
        Route::post('stores', [StoreController::class, 'store']);
        Route::post('stores/list-pdf', [StoreController::class, 'listPdf']);
        Route::post('stores/list-excel', [StoreController::class, 'listExcel']);
        Route::put('stores/{store}', [StoreController::class, 'update']);
        Route::delete('stores', [StoreController::class, 'destroy']);

        //customers
        Route::get('customers', [CustomerController::class, 'index']);
        Route::get('customers/search', [CustomerController::class, 'search']);
        Route::get('customers/{customer}',  [CustomerController::class, 'show']);
        Route::post('customers', [CustomerController::class, 'store']);
        Route::post('customers/list-pdf', [CustomerController::class, 'listPdf']);
        Route::post('customers/list-excel', [CustomerController::class, 'listExcel']);
        Route::put('customers/{customer}', [CustomerController::class, 'update']);
        Route::delete('customers/{customer}', [CustomerController::class, 'destroy']);

        //tickets
        Route::get('tickets', [TicketController::class, 'index']);
        Route::get('tickets/general', [TicketController::class, 'general']);
        Route::get('tickets/available', [TicketController::class, 'available']);
        Route::get('tickets/report', [TicketController::class, 'report']);
        Route::get('tickets/{ticket}',  [TicketController::class, 'show']);
        Route::post('tickets', [TicketController::class, 'store']);
        Route::post('tickets/list-pdf', [TicketController::class, 'listPdf']);
        Route::post('tickets/list-excel', [TicketController::class, 'listExcel']);
        Route::post('/tickets/list-mi-tickets-pdf', [TicketController::class, 'listMyTickets']);
        Route::put('tickets/{ticket}', [TicketController::class, 'update']);
        Route::delete('tickets/{ticket}', [TicketController::class, 'destroy']);

        //exchanges
        Route::get('exchanges', [ExchangeController::class, 'index']);
        Route::get('exchanges/pending', [ExchangeController::class, 'pending']);
        Route::get('exchanges/reject', [ExchangeController::class, 'reject']);
        Route::get('exchanges/approved', [ExchangeController::class, 'approved']);
        Route::get('exchanges/{exchange}',  [ExchangeController::class, 'show']);
        Route::post('exchanges', [ExchangeController::class, 'store']);
        Route::post('exchanges/pending/list-pdf', [ExchangeController::class, 'listPendingPdf']);
        Route::post('exchanges/pending/list-excel', [ExchangeController::class, 'listPendingExcel']);
        Route::post('exchanges/reject/list-pdf', [ExchangeController::class, 'listRejectPdf']);
        Route::post('exchanges/reject/list-excel', [ExchangeController::class, 'listRejectExcel']);
        Route::post('exchanges/approved/list-pdf', [ExchangeController::class, 'listApprovedPdf']);
        Route::post('exchanges/approved/list-excel', [ExchangeController::class, 'listApprovedExcel']);
        Route::post('/exchanges/list-mi-exchanges-pdf', [ExchangeController::class, 'listMyExchanges']);
        Route::put('exchanges/{exchange}', [ExchangeController::class, 'update']);
        Route::put('exchanges/approved/{exchange}', [ExchangeController::class, 'approvedExchange']);
        Route::put('exchanges/reject/{exchange}', [ExchangeController::class, 'rejectExchange']);
        Route::put('exchanges/delivered/{exchange}', [ExchangeController::class, 'deliveredExchange']);
        Route::delete('exchanges/{exchange}', [ExchangeController::class, 'destroy']);
    });
});
