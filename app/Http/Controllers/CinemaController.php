<?php

namespace App\Http\Controllers;

use App\Models\Cinema;
use App\Models\City;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CinemaController extends Controller
{
    public function index(Request $request): View
    {
        $search = (string) $request->get('q', '');
        $cityId = $request->integer('city_id');

        $query = Cinema::query()->with('city')->active();

        if ($search !== '') {
            $query->search($search);
        }

        if (!empty($cityId)) {
            $query->byCity($cityId);
        }

        /** @var LengthAwarePaginator $cinemas */
        $cinemas = $query->orderBy('brand')->orderBy('name')->paginate(12)->appends($request->query());

        $cities = City::query()->orderBy('name')->get(['id', 'name']);
        $current_page = 'cinemas';

        return view('cinemas.index', compact('cinemas', 'cities', 'current_page', 'search', 'cityId'));
    }
}


