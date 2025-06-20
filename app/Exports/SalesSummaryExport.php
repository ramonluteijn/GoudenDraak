<?php

namespace App\Exports;

use App\Models\SalesSummary;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SalesSummaryExport implements FromCollection, WithMapping, WithHeadings, WithStyles
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
        return SalesSummary::with('products')->where('id', $this->id)->get();
    }

    /**
     * Map the data for each row.
     *
     * @param SalesSummary $salesSummary
     * @return array
     */
    public function map($salesSummary): array
    {
        $rows = [];

        foreach ($salesSummary->products as $product) {
            $rows[] = [
                $product->name,
                $product->pivot->quantity,
                number_format($product->pivot->quantity * $product->pivot->price, 2),
            ];
        }

        $rows[] = [
            'Totale Verkoop (€)',
            '',
            $salesSummary->total_sales,
        ];

        $rows[] = [
            'Aantal Bestellingen',
            $salesSummary->total_orders,
            '',
        ];

        return $rows;
    }

    /**
     * Define the headings for the Excel file.
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'Productnaam',
            'Aantal',
            'Totale prijs per product (€)',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:C1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => 'solid',
                'startColor' => ['rgb' => '4CAF50'],
            ],
        ]);

        $highestRow = $sheet->getHighestRow();
        for ($row = 2; $row <= $highestRow; $row++) {
            $color = $row % 2 === 0 ? 'F1F1F1' : 'FFFFFF';
            $sheet->getStyle("A{$row}:C{$row}")->applyFromArray([
                'fill' => [
                    'fillType' => 'solid',
                    'startColor' => ['rgb' => $color],
                ],
            ]);
        }

        $sheet->getStyle("A1:C{$highestRow}")->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
        ]);

        foreach (range('A', 'C') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        $sheet->getStyle("C2:C{$highestRow}")->getNumberFormat()->setFormatCode('_-€ * #,##0.00_-;-€ * #,##0.00_-;_-€ * "-"_-;_-@_-');
    }
}
