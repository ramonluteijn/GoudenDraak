<?php

namespace App\Http\Controllers;

use App\Models\{Page};

class PageController extends Controller
{
    public function index($parent = null, $child = null, $grandchild = null)
    {
        $url = request()->path();
        if ($url === '/') {
            $url = 'home';
        }
        $pages = Page::where('url', $url)->firstOrFail();
        return view('pages.custom', ['pages' => $pages]);
    }
}
