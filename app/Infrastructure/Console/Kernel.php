<?php

namespace App\Infrastructure\Console;

use App\Infrastructure\Broker\Consumers\Kafka\PaymentCartConsumer;
use App\Infrastructure\Broker\Consumers\Kafka\PaymentStatusChangeConsumer;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        PaymentCartConsumer::class,
        PaymentStatusChangeConsumer::class,
    ];

    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('inspire')->everySecond();
    }

    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('./app/Infrastructure/Routes/console.php');
    }
}
