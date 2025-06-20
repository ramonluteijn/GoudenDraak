<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\DiscountRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class DiscountCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class DiscountCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Discount::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/discount');
        CRUD::setEntityNameStrings('discount', 'discounts');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::column('id')->label('Korting ID');
        CRUD::column('start_date')->label('Startdatum')->type('date');
        CRUD::column('end_date')->label('Einddatum')->type('date');
        CRUD::column('discount')->label('Korting (%)')->type('number');
        CRUD::column([
            'name'      => 'product.name',
            'label'     => 'Productnaam',
            'entity'    => 'product',
            'attribute' => 'name',
            'searchLogic' => function ($query, $column, $searchTerm) {
                $query->orWhereHas('product', function ($q) use ($searchTerm) {
                    $q->where('name', 'LIKE', '%' . $searchTerm . '%');
                });
            },
        ]);
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
        CRUD::setValidation(DiscountRequest::class);

        CRUD::field([
            'label'     => "Products (Ctrl + Klik om meerdere te selecteren!)",
            'type'      => 'select_multiple',
            'name'      => 'product_id', // the method that defines the relationship in your Model
            'entity'    => 'product', // the method that defines the relationship in your Model
            'model'     => \App\Models\Product::class, // the related model
            'attribute' => 'name', // the column to display in the dropdown
            'options'   => (function ($query) {
                return $query->orderBy('name', 'ASC')->get();
            }),
        ]);

        CRUD::field('start_date')->label('Startdatum')->type('date');
        CRUD::field('end_date')->label('Einddatum')->type('date');
        CRUD::field('discount')->label('Korting (%)')->type('number');
        CRUD::field('active')->label('Actief')->type('checkbox')->default(0);
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

    public function store()
    {
//        $data = $this->crud->getRequest()->all();
        $data = $this->crud->validateRequest();

        if (isset($data['product_id']) && is_array($data['product_id'])) {
            foreach ($data['product_id'] as $productId) {
                $discount = new \App\Models\Discount();
                $discount->start_date = $data['start_date'];
                $discount->end_date = $data['end_date'];
                $discount->discount = $data['discount'];
                $discount->product_id = $productId;
                $discount->active = $data['active'] ?? 0; // Default to 0 if not set
                $discount->save();
            }
        }
        return redirect($this->crud->route);
    }
}
