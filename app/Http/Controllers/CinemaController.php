<?php

namespace App\Http\Controllers;

use App\Models\Cinema;
use App\Models\City;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class CinemaController extends Controller
{
    public function index(Request $request): View|JsonResponse
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

        // AJAX load more support
        if ($request->boolean('ajax')) {
            $gridHtml = view('cinemas.partials.grid-cards', compact('cinemas'))->render();
            $listHtml = view('cinemas.partials.list-cards', compact('cinemas'))->render();

            return response()->json([
                'html_grid' => $gridHtml,
                'html_list' => $listHtml,
                'next_page_url' => $cinemas->nextPageUrl(),
                'has_more' => $cinemas->hasMorePages(),
            ]);
        }

        $cities = City::query()->orderBy('name')->get(['id', 'name']);
        $current_page = 'cinemas';

        return view('cinemas.index', compact('cinemas', 'cities', 'current_page', 'search', 'cityId'));
    }
}


