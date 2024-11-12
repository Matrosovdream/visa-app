<?php

namespace App\Observers;

use App\Models\Order;
use App\Helpers\orderHelper;


class OrderObserver
{
    public function created(Order $order): void
    {
        orderHelper::SendMailOrderCreated($order);
    }

    public function updated(Order $order): void
    {
        //
    }

    public function deleted(Order $order): void
    {
        //
    }

    public function restored(Order $order): void
    {
        //
    }

    public function forceDeleted(Order $order): void
    {
        //
    }
}
