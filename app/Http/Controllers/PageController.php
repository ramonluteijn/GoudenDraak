<?php

namespace App\Http\Controllers;

use App\Models\{Page};

class PageController extends Controller
{
    public function index($parent = null, $child = null, $grandchild = null)
    {
        $url = request()->path();
        preg_match('/pages\/(.*)/', $url, $url);
        $pages = Page::where('url', $url[1])->firstOrFail();
        if ($pages->url === 'home') {
            return to_route('home');
        }

        return view('pages.custom', ['pages' => $pages]);
    }
}
