<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Voucher;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class VoucherController extends Controller
{
    public function index(Request $request): View
    {
        $query = Voucher::query()->withCount('userVouchers');

        if ($request->filled('search')) {
            $search = $request->string('search');
            $query->where('name', 'like', "%{$search}%");
        }

        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        if ($request->filled('type')) {
            $query->where('type', $request->string('type'));
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date('date_from'));
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date('date_to'));
        }

        if ($request->filled('date_filter')) {
            switch ($request->string('date_filter')->toString()) {
                case 'today':
                    $query->whereDate('created_at', today());
                    break;
                case 'this_week':
                    $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
                    break;
                case 'this_month':
                    $query->whereMonth('created_at', now()->month)
                          ->whereYear('created_at', now()->year);
                    break;
                case 'last_month':
                    $query->whereMonth('created_at', now()->subMonth()->month)
                          ->whereYear('created_at', now()->subMonth()->year);
                    break;
            }
        }

        $sort = $request->get('sort', 'created_at');
        $sortDirection = 'desc';
        
        switch ($sort) {
            case 'name':
                $query->orderBy('name', 'asc');
                break;
            case 'value':
                $query->orderBy('value', $sortDirection);
                break;
            case 'usage_count':
                $query->orderBy('user_vouchers_count', $sortDirection);
                break;
            default:
                $query->orderBy('created_at', $sortDirection);
        }

        $vouchers = $query->paginate(10)->appends($request->query());

        // Calculate statistics
        $stats = [
            'total' => Voucher::count(),
            'active' => Voucher::where('is_active', true)->count(),
            'inactive' => Voucher::where('is_active', false)->count(),
            'percentage' => Voucher::where('type', 'percentage')->count(),
            'fixed' => Voucher::where('type', 'fixed')->count(),
            'expiring_soon' => Voucher::where('is_active', true)
                                     ->whereBetween('valid_until', [now(), now()->addDays(7)])
                                     ->count(),
            'new_this_month' => Voucher::whereMonth('created_at', now()->month)
                                       ->whereYear('created_at', now()->year)
                                       ->count(),
        ];

        return view('admin.vouchers.index', compact('vouchers', 'stats'));
    }

    public function create(): View
    {
        return view('admin.vouchers.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:percentage,fixed',
            'value' => 'required|numeric|min:0',
            'min_purchase' => 'nullable|numeric|min:0',
            'max_discount' => 'nullable|numeric|min:0',
            // per voucher satu kali pakai (dimiliki user_vouchers), tidak perlu usage_limit
            'points_required' => 'nullable|integer|min:0',
            'valid_from' => 'required|date',
            'valid_until' => 'required|date|after_or_equal:valid_from',
            'is_active' => 'sometimes|boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);
        Voucher::create($validated);

        return redirect()->route('admin.vouchers.index')->with('success', 'Voucher berhasil dibuat.');
    }

    public function show(Voucher $voucher): View
    {
        return view('admin.vouchers.show', compact('voucher'));
    }

    public function edit(Voucher $voucher): View
    {
        return view('admin.vouchers.edit', compact('voucher'));
    }

    public function update(Request $request, Voucher $voucher): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:percentage,fixed',
            'value' => 'required|numeric|min:0',
            'min_purchase' => 'nullable|numeric|min:0',
            'max_discount' => 'nullable|numeric|min:0',
            // tidak pakai usage_limit
            'points_required' => 'nullable|integer|min:0',
            'valid_from' => 'required|date',
            'valid_until' => 'required|date|after_or_equal:valid_from',
            'is_active' => 'sometimes|boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        $voucher->update($validated);

        return redirect()->route('admin.vouchers.index')->with('success', 'Voucher berhasil diperbarui.');
    }

    public function destroy(Voucher $voucher): RedirectResponse
    {
        if ($voucher->userVouchers()->exists()) {
            return redirect()->route('admin.vouchers.index')->with('error', 'Voucher tidak dapat dihapus karena sudah dimiliki pengguna.');
        }

        $voucher->delete();
        return redirect()->route('admin.vouchers.index')->with('success', 'Voucher berhasil dihapus.');
    }

    public function toggleStatus(Voucher $voucher): RedirectResponse
    {
        $voucher->update(['is_active' => !$voucher->is_active]);
        $status = $voucher->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return redirect()->route('admin.vouchers.index')->with('success', "Voucher {$voucher->code} {$status}.");
    }
}


