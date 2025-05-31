<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\OrderRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class OrderCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class OrderCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Order::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/order');
        CRUD::setEntityNameStrings('order', 'orders');
        CRUD::denyAccess(['delete', 'update']);
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::column('id')->type('number')->label('Ordernummer');
        CRUD::column('table.id')->label('Tafel nummer');
        CRUD::column('take_away')->type('boolean')->label('Afhaal');
        CRUD::column('price')->type('decimal')->label('Prijs');
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(OrderRequest::class);
        $products = \App\Models\Product::all();
        foreach ($products as $product) {
            CRUD::field([
                'name' => "product_quantity_{$product->id}",
                'label' => "{$product->name} (€{$product->price})",
                'hint' => "Beschikbare voorraad: {$product->stock}",
                'type' => 'number',
                'attributes' => [
                    'min' => 0,
                    'step' => 1,
                    'max' => $product->stock,
                ],
            ]);
        }
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
        $this->setupListOperation();
        CRUD::addColumn([
            'name' => 'products_list',
            'label' => 'Producten',
            'type' => 'custom_html',
            'value' => function ($entry) {
                $value = $entry->orderDetails->map(function ($detail) {
                    $totalPricePerProduct = $detail->product->price * $detail->quantity;
                    return "<span>{$detail->product->name} - €{$detail->product->price} x {$detail->quantity} = €{$totalPricePerProduct}</span><br>";
                })->implode(' ');

                $totalPrice = $entry->orderDetails->sum(function ($detail) {
                    return $detail->product->price * $detail->quantity;
                });

                return $value . "<strong>Totaal: €{$totalPrice}</strong>";
            },
        ]);
        CRUD::column('created_at')->type('datetime')->label('Aangemaakt op');
    }
}
