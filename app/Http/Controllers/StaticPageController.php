<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\City;

class StaticPageController extends Controller
{
    /**
     * Get cities data for header dropdown
     */
    private function getCitiesData(): array
    {
        return City::query()
            ->active()
            ->orderBy('name')
            ->get(['id', 'name'])
            ->map(fn ($c) => ['id' => $c->id, 'name' => $c->name])
            ->values()
            ->all();
    }

    /**
     * Display the FAQ page.
     */
    public function faq()
    {
        return view('static.faq', [
            'cities' => $this->getCitiesData(),
            'current_page' => 'faq'
        ]);
    }

    /**
     * Display the Contact Us page.
     */
    public function contact()
    {
        return view('static.contact', [
            'cities' => $this->getCitiesData(),
            'current_page' => 'contact'
        ]);
    }

    /**
     * Display the How to Book page.
     */
    public function howToBook()
    {
        return view('static.how-to-book', [
            'cities' => $this->getCitiesData(),
            'current_page' => 'how-to-book'
        ]);
    }

    /**
     * Display the Privacy Policy page.
     */
    public function privacyPolicy()
    {
        return view('static.privacy-policy', [
            'cities' => $this->getCitiesData(),
            'current_page' => 'privacy-policy'
        ]);
    }

    /**
     * Display the Terms and Conditions page.
     */
    public function termsAndConditions()
    {
        return view('static.terms-and-conditions', [
            'cities' => $this->getCitiesData(),
            'current_page' => 'terms-and-conditions'
        ]);
    }
}

