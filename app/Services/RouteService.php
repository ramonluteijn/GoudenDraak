<?php

namespace App\Services;

use App\Models\MenuItem;
use App\Models\Page;

use function Livewire\of;

class RouteService
{
    public function getRouteOptions(): array
    {
        $manualOptions = [
            '/' => 'Home',
            '/news' => 'Nieuws',
            '/contact' => 'Contact',
        ];
        $dynamicOptions = [];
        $dynamicOptions = array_merge($dynamicOptions, $this->getContentPageRouteOptions());

        $options = array_merge($manualOptions, $dynamicOptions);
        $this->predefinedRouteOptions($options);

        return $options;
    }

    private function predefinedRouteOptions($options): void
    {
        $this->predefineMenuItemRouteOptions($options);
    }

    private function getContentPageRouteOptions(): array
    {
        $dynamicOptions = [];
        $contentPages = Page::all();
        foreach ($contentPages as $contentPage) {
            if (!in_array(strtolower($contentPage->title), ['home', 'nieuws', 'contact'])) {
                $dynamicOptions[url($contentPage->url)] = ucfirst($contentPage->title);
            }
        }
        return $dynamicOptions;
    }

    private function predefineMenuItemRouteOptions($options): void
    {
        $menuItems = MenuItem::find(request()->route('id'));
        if ($menuItems !== null) {
            $menuItems->url = $menuItems->url ?? null;
            if (!array_key_exists($menuItems->url, $options)) {
                $options[$menuItems->url] = $menuItems->url;
            }
        }
    }
}
