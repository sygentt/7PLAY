<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cinema;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;

class CinemaController extends Controller
{
    /**
     * Display a listing of cinemas.
     */
    public function index(Request $request): View
    {
        $query = Cinema::query()->with('city')->withCount(['cinema_halls', 'active_cinema_halls']);

        // Search functionality
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        // Filter by city
        if ($request->filled('city_id')) {
            $query->byCity($request->city_id);
        }

        // Filter by brand
        if ($request->filled('brand')) {
            $query->byBrand($request->brand);
        }

        // Filter by status
        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->active();
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        // Sort functionality
        $sortField = $request->get('sort', 'name');
        $sortDirection = $request->get('direction', 'asc');
        
        $allowedSorts = ['name', 'brand', 'created_at'];
        if (in_array($sortField, $allowedSorts)) {
            $query->orderBy($sortField, $sortDirection);
        }

        $cinemas = $query->paginate(10)->appends($request->query());
        
        // Get data for filters
        $cities = City::active()->orderBy('name')->get();
        $brands = Cinema::getAvailableBrands();

        return view('admin.cinemas.index', compact('cinemas', 'cities', 'brands'));
    }

    /**
     * Show the form for creating a new cinema.
     */
    public function create(): View
    {
        $cities = City::active()->orderBy('name')->get();
        $brands = Cinema::getAvailableBrands();

        return view('admin.cinemas.create', compact('cities', 'brands'));
    }

    /**
     * Store a newly created cinema in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'city_id' => 'required|exists:cities,id',
            'name' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'address' => 'required|string|max:500',
            'phone' => 'nullable|string|max:20',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'is_active' => 'boolean',
        ], [
            'city_id.required' => 'Kota wajib dipilih.',
            'city_id.exists' => 'Kota yang dipilih tidak valid.',
            'name.required' => 'Nama bioskop wajib diisi.',
            'name.max' => 'Nama bioskop maksimal 255 karakter.',
            'brand.required' => 'Brand bioskop wajib dipilih.',
            'brand.max' => 'Brand bioskop maksimal 255 karakter.',
            'address.required' => 'Alamat wajib diisi.',
            'address.max' => 'Alamat maksimal 500 karakter.',
            'phone.max' => 'Nomor telepon maksimal 20 karakter.',
            'latitude.numeric' => 'Latitude harus berupa angka.',
            'latitude.between' => 'Latitude harus antara -90 hingga 90.',
            'longitude.numeric' => 'Longitude harus berupa angka.',
            'longitude.between' => 'Longitude harus antara -180 hingga 180.',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        Cinema::create($validated);

        return redirect()
            ->route('admin.cinemas.index')
            ->with('success', "Bioskop {$validated['brand']} {$validated['name']} berhasil ditambahkan.");
    }

    /**
     * Display the specified cinema.
     */
    public function show(Cinema $cinema): View
    {
        $cinema->load(['city', 'cinema_halls' => function ($query) {
            $query->withCount('seats');
        }]);

        return view('admin.cinemas.show', compact('cinema'));
    }

    /**
     * Show the form for editing the specified cinema.
     */
    public function edit(Cinema $cinema): View
    {
        $cities = City::active()->orderBy('name')->get();
        $brands = Cinema::getAvailableBrands();

        return view('admin.cinemas.edit', compact('cinema', 'cities', 'brands'));
    }

    /**
     * Update the specified cinema in storage.
     */
    public function update(Request $request, Cinema $cinema): RedirectResponse
    {
        $validated = $request->validate([
            'city_id' => 'required|exists:cities,id',
            'name' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'address' => 'required|string|max:500',
            'phone' => 'nullable|string|max:20',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'is_active' => 'boolean',
        ], [
            'city_id.required' => 'Kota wajib dipilih.',
            'city_id.exists' => 'Kota yang dipilih tidak valid.',
            'name.required' => 'Nama bioskop wajib diisi.',
            'name.max' => 'Nama bioskop maksimal 255 karakter.',
            'brand.required' => 'Brand bioskop wajib dipilih.',
            'brand.max' => 'Brand bioskop maksimal 255 karakter.',
            'address.required' => 'Alamat wajib diisi.',
            'address.max' => 'Alamat maksimal 500 karakter.',
            'phone.max' => 'Nomor telepon maksimal 20 karakter.',
            'latitude.numeric' => 'Latitude harus berupa angka.',
            'latitude.between' => 'Latitude harus antara -90 hingga 90.',
            'longitude.numeric' => 'Longitude harus berupa angka.',
            'longitude.between' => 'Longitude harus antara -180 hingga 180.',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        $cinema->update($validated);

        return redirect()
            ->route('admin.cinemas.index')
            ->with('success', "Bioskop {$validated['brand']} {$validated['name']} berhasil diperbarui.");
    }

    /**
     * Remove the specified cinema from storage.
     */
    public function destroy(Cinema $cinema): RedirectResponse
    {
        // Check if cinema has cinema halls
        if ($cinema->cinema_halls()->exists()) {
            return redirect()
                ->route('admin.cinemas.index')
                ->with('error', "Bioskop {$cinema->full_name} tidak dapat dihapus karena masih memiliki studio.");
        }

        $cinemaName = $cinema->full_name;
        $cinema->delete();

        return redirect()
            ->route('admin.cinemas.index')
            ->with('success', "Bioskop {$cinemaName} berhasil dihapus.");
    }

    /**
     * Toggle cinema status.
     */
    public function toggleStatus(Cinema $cinema): RedirectResponse
    {
        $cinema->update(['is_active' => !$cinema->is_active]);
        
        $status = $cinema->is_active ? 'diaktifkan' : 'dinonaktifkan';
        
        return redirect()
            ->route('admin.cinemas.index')
            ->with('success', "Bioskop {$cinema->full_name} berhasil {$status}.");
    }
}
