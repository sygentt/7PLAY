<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\City;

class AboutController extends Controller
{
    /**
     * Display the about page.
     */
    public function index()
    {
        // Get cities for header dropdown
        $cities = City::query()
            ->active()
            ->orderBy('name')
            ->get(['id', 'name'])
            ->map(fn ($c) => ['id' => $c->id, 'name' => $c->name])
            ->values()
            ->all();

        return view('about.index', [
            'cities' => $cities,
            'current_page' => 'about'
        ]);
    }
}

