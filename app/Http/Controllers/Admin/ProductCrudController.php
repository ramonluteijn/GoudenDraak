<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ProductRequest;
use App\Models\Category;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class ProductCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ProductCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Product::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/product');
        CRUD::setEntityNameStrings('product', 'producten');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        $this->setupColumns();
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(ProductRequest::class);
        $this->setupFields();
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
        $this->setupColumns();
    }

    private function setupColumns()
    {
        CRUD::column('id')->label('Productnummer')->type('text');
        CRUD::column('name')->label('Product naam')->type('text');
        CRUD::column('price')->label('Prijs')->type('number')->decimals(2)->prefix('€ ');
        CRUD::column('stock')->label('Voorraad')->type('number');
        CRUD::column([
            'name'      => 'category.name',
            'label'     => 'Categorie',
            'entity'    => 'category',
            'attribute' => 'name',
            'searchLogic' => function ($query, $column, $searchTerm) {
                $query->orWhereHas('category', function ($q) use ($searchTerm) {
                    $q->where('name', 'LIKE', '%' . $searchTerm . '%');
                });
            },
        ]);
    }

    private function setupFields()
    {
        CRUD::field('name')->label('Product naam')->type('text');
        CRUD::field('price')->label('Prijs')->type('number')->decimals(2)->prefix('€ ');
        CRUD::field('stock')->label('Voorraad')->type('number');
        CRUD::field([
            'name'    => 'category_id',
            'label'   => 'Categorieën',
            'type'    => 'select_from_array',
            'options' => Category::all()->pluck('name', 'id')->toArray(),
        ]);
    }
}
