<?php

namespace App\Http\Controllers\Admin;

use App\Exports\SalesSummaryExport;
use App\Http\Requests\SalesSummaryRequest;
use App\Models\Order;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Maatwebsite\Excel\Facades\Excel;

/**
 * Class SalesSummaryCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class SalesSummaryCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\SalesSummary::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/sales-summary');
        CRUD::setEntityNameStrings('sales summary', 'sales summaries');
        CRUD::denyAccess(['create', 'update', 'delete']);
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::column('created_at')->label('Datum')->type('date');
        CRUD::column('total_sales')->label('Totale Verkoop')->type('number')->decimals(2)->prefix('€ ');
        CRUD::column('total_orders')->label('Aantal Bestellingen')->type('number');
        CRUD::addButtonFromModelFunction('line', 'ExportButton', 'Export', 'end');


        /**
         * Columns can be defined using the fluent syntax:
         * - CRUD::column('price')->type('number');
         */
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(SalesSummaryRequest::class);
        CRUD::setFromDb();

        /**
         * Fields can be defined using the fluent syntax:
         * - CRUD::field('price')->type('number');
         */
    }

    /**
     * Define what happens when the Update operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }

    /**
     * Define what happens when the Show operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-show
     * @return void
     */
    protected function setupShowOperation()
    {
        CRUD::column('created_at')->label('Datum')->type('date');
        CRUD::column('total_sales')->label('Totale Verkoop')->type('number')->decimals(2)->prefix('€ ');
        CRUD::column('total_orders')->label('Aantal Bestellingen')->type('number');
        CRUD::addButtonFromModelFunction('line', 'ExportButton', 'Export', 'end');
        CRUD::addColumn([
            'name' => 'products_list',
            'label' => 'Producten',
            'type' => 'custom_html',
            'value' => function ($entry) {
                $productsSold = Order::where('created_at', '>=', now()->startOfDay())
                    ->with('orderDetails.product')
                    ->get()
                    ->flatMap(function ($order) {
                        return $order->orderDetails;
                    })
                    ->groupBy('product_id')
                    ->map(function ($details) {
                        return [
                            'quantity' => $details->sum('quantity'),
                            'total_price' => $details->sum(function ($detail) {
                                return $detail->product ? $detail->product->price * $detail->quantity : 0;
                            }),
                        ];
                    });

                $value = $productsSold->map(function ($data, $productId) {
                    $product = \App\Models\Product::find($productId);
                    if ($product) {
                        return "<span>{$product->name} - Aantal: {$data['quantity']} - Totaalprijs: €{$data['total_price']}</span><br>";
                    }
                    return "<span>Product ID {$productId} - Aantal: {$data['quantity']} - Totaalprijs: €{$data['total_price']}</span><br>";
                })->implode(' ');

                return $value;
            },
        ]);
    }

    public function Export($id)
    {
        return Excel::download(new SalesSummaryExport($id), 'verkoopsamenvatting_'.date('d-m-y').'.xlsx');
    }
}
