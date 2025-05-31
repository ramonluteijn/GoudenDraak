<?php

namespace App\Exports;

use App\Models\SalesSummary;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SalesSummaryExport implements FromCollection, WithMapping, WithHeadings
{
    protected $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * Fetch the data to be exported.
     *
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return SalesSummary::where('id', $this->id)->get();
    }

    /**
     * Map the data for each row.
     *
     * @param SalesSummary $salesSummary
     * @return array
     */
    public function map($salesSummary): array
    {
        return [
            $salesSummary->created_at->format('Y-m-d'),
            $salesSummary->total_sales,
            $salesSummary->total_orders,
        ];
    }

    /**
     * Define the headings for the Excel file.
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'Date',
            'Total Sales (€)',
            'Total Orders',
        ];
    }
}
