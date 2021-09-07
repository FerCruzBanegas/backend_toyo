<?php

namespace App\Observers;

use App\Models\Exchange;

class ExchangeObserver
{
    public function created(Exchange $exchange): void
    {
        $exchange->tickets()->update(['status' => 0]);
    }
}
