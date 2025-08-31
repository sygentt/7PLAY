<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;

class CityController extends Controller
{
    /**
     * Display a listing of cities.
     */
    public function index(Request $request): View
    {
        $query = City::query()->withCount(['cinemas', 'active_cinemas']);

        // Search functionality
        if ($request->filled('search')) {
            $query->search($request->search);
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
        
        $allowedSorts = ['name', 'province', 'code', 'created_at'];
        if (in_array($sortField, $allowedSorts)) {
            $query->orderBy($sortField, $sortDirection);
        }

        $cities = $query->paginate(10)->appends($request->query());

        return view('admin.cities.index', compact('cities'));
    }

    /**
     * Show the form for creating a new city.
     */
    public function create(): View
    {
        return view('admin.cities.create');
    }

    /**
     * Store a newly created city in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'province' => 'required|string|max:255',
            'code' => 'required|string|max:10|unique:cities,code',
            'is_active' => 'boolean',
        ], [
            'name.required' => 'Nama kota wajib diisi.',
            'name.max' => 'Nama kota maksimal 255 karakter.',
            'province.required' => 'Provinsi wajib diisi.',
            'province.max' => 'Provinsi maksimal 255 karakter.',
            'code.required' => 'Kode kota wajib diisi.',
            'code.max' => 'Kode kota maksimal 10 karakter.',
            'code.unique' => 'Kode kota sudah digunakan.',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        City::create($validated);

        return redirect()
            ->route('admin.cities.index')
            ->with('success', "Kota {$validated['name']} berhasil ditambahkan.");
    }

    /**
     * Display the specified city.
     */
    public function show(City $city): View
    {
        $city->load(['cinemas' => function ($query) {
            $query->withCount(['cinema_halls', 'active_cinema_halls']);
        }]);

        return view('admin.cities.show', compact('city'));
    }

    /**
     * Show the form for editing the specified city.
     */
    public function edit(City $city): View
    {
        return view('admin.cities.edit', compact('city'));
    }

    /**
     * Update the specified city in storage.
     */
    public function update(Request $request, City $city): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'province' => 'required|string|max:255',
            'code' => "required|string|max:10|unique:cities,code,{$city->id}",
            'is_active' => 'boolean',
        ], [
            'name.required' => 'Nama kota wajib diisi.',
            'name.max' => 'Nama kota maksimal 255 karakter.',
            'province.required' => 'Provinsi wajib diisi.',
            'province.max' => 'Provinsi maksimal 255 karakter.',
            'code.required' => 'Kode kota wajib diisi.',
            'code.max' => 'Kode kota maksimal 10 karakter.',
            'code.unique' => 'Kode kota sudah digunakan.',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        $city->update($validated);

        return redirect()
            ->route('admin.cities.index')
            ->with('success', "Kota {$validated['name']} berhasil diperbarui.");
    }

    /**
     * Remove the specified city from storage.
     */
    public function destroy(City $city): RedirectResponse
    {
        // Check if city has cinemas
        if ($city->cinemas()->exists()) {
            return redirect()
                ->route('admin.cities.index')
                ->with('error', "Kota {$city->name} tidak dapat dihapus karena masih memiliki bioskop.");
        }

        $cityName = $city->name;
        $city->delete();

        return redirect()
            ->route('admin.cities.index')
            ->with('success', "Kota {$cityName} berhasil dihapus.");
    }

    /**
     * Get cinemas for the specified city (for AJAX requests).
     */
    public function getCinemasByCity(City $city): JsonResponse
    {
        $cinemas = $city->active_cinemas()
            ->select('id', 'name', 'brand', 'address')
            ->get();

        return response()->json($cinemas);
    }

    /**
     * Toggle city status.
     */
    public function toggleStatus(City $city): RedirectResponse
    {
        $city->update(['is_active' => !$city->is_active]);
        
        $status = $city->is_active ? 'diaktifkan' : 'dinonaktifkan';
        
        return redirect()
            ->route('admin.cities.index')
            ->with('success', "Kota {$city->name} berhasil {$status}.");
    }
}
