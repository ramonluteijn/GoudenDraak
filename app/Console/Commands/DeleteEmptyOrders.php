<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DeleteEmptyOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:delete-empty-orders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete orders that have no items associated with them';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Deleting empty orders...');

        $deletedCount = \App\Models\Order::doesntHave('orderDetails')->where('created_at', '<', now()->subHour())->delete();

        if ($deletedCount > 0) {
            $this->info("Deleted {$deletedCount} empty orders successfully.");
        } else {
            $this->info('No empty orders found.');
        }

        $this->info('Empty orders deletion completed.');
    }
}
