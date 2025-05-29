{{-- This file is used for menu items by any Backpack v6 theme --}}
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}</a></li>

<x-backpack::menu-dropdown title="Eten" icon="la la-puzzle-piece">
    <x-backpack::menu-dropdown-item title="Orders" icon="la la-question" :link="backpack_url('order')" />
    <x-backpack::menu-dropdown-item title="Producten" icon="la la-question" :link="backpack_url('product')" />
    <x-backpack::menu-dropdown-item title="Categorieën" icon="la la-question" :link="backpack_url('category')" />
</x-backpack::menu-dropdown>

<x-backpack::menu-dropdown title="Site instellingen" icon="la la-puzzle-piece">
    <x-backpack::menu-dropdown-item title="Menu items" icon="la la-question" :link="backpack_url('menu-item')" />
    <x-backpack::menu-dropdown-item title="Pagina's" icon="la la-question" :link="backpack_url('page')" />
    <x-backpack::menu-dropdown-item title="Vragen" icon="la la-question" :link="backpack_url('question')" />
    <x-backpack::menu-dropdown-item title="Tafels" icon="la la-question" :link="backpack_url('table')" />
</x-backpack::menu-dropdown>
