<?php

namespace App\Listeners;

use App\Events\OrderPlaced;
use Illuminate\Support\Facades\Log;

class SendOrderNotification
{
    public function handle(OrderPlaced $event): void
    {
        Log::info("Сповіщення: Нове замовлення №{$event->orderId} успішно створено!");
    }
}