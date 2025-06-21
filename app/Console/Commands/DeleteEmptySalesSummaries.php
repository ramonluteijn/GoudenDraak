<?php

namespace App\Console\Commands;

use App\Models\SalesSummary;
use Illuminate\Console\Command;

class DeleteEmptySalesSummaries extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:delete-empty-sales-summaries';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete sales summaries that have no associated orders';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Deleting empty sales summaries...');

        $deletedCount = SalesSummary::whereNull('total_orders')->orWhere('total_orders', 0)->orWhereNull('total_sales')->orWhere('total_sales', 0.00)->delete();

        if ($deletedCount > 0) {
            $this->info("Deleted {$deletedCount} empty sales summaries successfully.");
        } else {
            $this->info('No empty sales summaries found.');
        }

        $this->info('Empty sales summaries deletion completed.');
    }
}
