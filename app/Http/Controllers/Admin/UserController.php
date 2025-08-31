<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class UserController extends Controller
{
    /**
     * Display a listing of users.
     */
    public function index(Request $request): View
    {
        $query = User::query()
            ->withCount(['orders' => function ($q) {
                $q->whereIn('status', [Order::STATUS_CONFIRMED, Order::STATUS_PAID]);
            }])
            ->withSum(['orders as total_spent' => function ($q) {
                $q->whereIn('status', [Order::STATUS_CONFIRMED, Order::STATUS_PAID]);
            }], 'total_amount');

        // Search functionality
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        // Filter by role
        if ($request->filled('role')) {
            if ($request->role === 'admin') {
                $query->admins();
            } elseif ($request->role === 'customer') {
                $query->customers();
            }
        }

        // Filter by status
        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->active();
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        // Filter by gender
        if ($request->filled('gender')) {
            $query->where('gender', $request->gender);
        }

        // Filter by age range
        if ($request->filled('min_age') && $request->filled('max_age')) {
            $maxBirthDate = Carbon::now()->subYears($request->min_age)->endOfYear();
            $minBirthDate = Carbon::now()->subYears($request->max_age)->startOfYear();
            $query->whereBetween('birth_date', [$minBirthDate, $maxBirthDate]);
        }

        // Filter by registration date
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Quick date filters
        if ($request->filled('date_filter')) {
            switch ($request->date_filter) {
                case 'today':
                    $query->whereDate('created_at', Carbon::today());
                    break;
                case 'this_week':
                    $query->whereBetween('created_at', [
                        Carbon::now()->startOfWeek(),
                        Carbon::now()->endOfWeek()
                    ]);
                    break;
                case 'this_month':
                    $query->whereBetween('created_at', [
                        Carbon::now()->startOfMonth(),
                        Carbon::now()->endOfMonth()
                    ]);
                    break;
                case 'last_month':
                    $query->whereBetween('created_at', [
                        Carbon::now()->subMonth()->startOfMonth(),
                        Carbon::now()->subMonth()->endOfMonth()
                    ]);
                    break;
            }
        }

        // Sort functionality
        $sortField = $request->get('sort', 'created_at');
        $sortDirection = $request->get('direction', 'desc');
        
        $allowedSorts = ['name', 'email', 'created_at', 'orders_count', 'total_spent'];
        if (in_array($sortField, $allowedSorts)) {
            $query->orderBy($sortField, $sortDirection);
        }

        $users = $query->paginate(15)->appends($request->all());

        // Statistics
        $stats = [
            'total' => User::count(),
            'customers' => User::customers()->count(),
            'admins' => User::admins()->count(),
            'active' => User::active()->count(),
            'inactive' => User::where('is_active', false)->count(),
            'new_this_month' => User::whereBetween('created_at', [
                Carbon::now()->startOfMonth(),
                Carbon::now()->endOfMonth()
            ])->count(),
            'verified' => User::whereNotNull('email_verified_at')->count(),
        ];

        return view('admin.users.index', compact('users', 'stats'));
    }

    /**
     * Show the form for creating a new user.
     */
    public function create(): View
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['nullable', 'string', 'max:20'],
            'birth_date' => ['nullable', 'date', 'before:today'],
            'gender' => ['nullable', 'string', 'in:male,female'],
            'password' => ['required', 'string', 'min:8'],
            'is_admin' => ['boolean'],
            'is_active' => ['boolean'],
        ]);

        $validated['password'] = bcrypt($validated['password']);
        $validated['is_admin'] = $request->has('is_admin');
        $validated['is_active'] = $request->has('is_active') ?: true;
        // Set email verification according to checkbox in form
        $validated['email_verified_at'] = $request->boolean('email_verified') ? now() : null;

        $user = User::create($validated);

        return redirect()
            ->route('admin.users.index')
            ->with('success', "User '{$user->name}' berhasil ditambahkan.");
    }

    /**
     * Display the specified user.
     */
    public function show(User $user): View
    {
        $user->load(['orders' => function ($query) {
            $query->latest()->take(10);
        }, 'orders.showtime.movie', 'orders.showtime.cinemaHall.cinema']);

        // User statistics
        $userStats = [
            'total_orders' => $user->orders()->count(),
            'completed_orders' => $user->orders()->confirmed()->count(),
            'cancelled_orders' => $user->orders()->cancelled()->count(),
            'pending_orders' => $user->orders()->pending()->count(),
            'total_spent' => $user->getTotalSpent(),
            'avg_order_value' => $user->orders()->confirmed()->avg('total_amount') ?? 0,
            'favorite_genre' => $user->getFavoriteGenre(),
            'last_order' => $user->orders()->latest()->first(),
        ];

        return view('admin.users.show', compact('user', 'userStats'));
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user): View
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone' => ['nullable', 'string', 'max:20'],
            'birth_date' => ['nullable', 'date', 'before:today'],
            'gender' => ['nullable', 'string', 'in:male,female'],
            'password' => ['nullable', 'string', 'min:8'],
            'is_admin' => ['boolean'],
            'is_active' => ['boolean'],
        ]);

        // Handle password update
        if (empty($validated['password'])) {
            unset($validated['password']);
        } else {
            $validated['password'] = bcrypt($validated['password']);
        }

        $validated['is_admin'] = $request->has('is_admin');
        $validated['is_active'] = $request->has('is_active');

        $user->update($validated);

        // Apply email verification toggle from checkbox
        $should_verified = $request->boolean('email_verified');
        if ($should_verified && !$user->email_verified_at) {
            $user->forceFill(['email_verified_at' => now()])->save();
        } elseif (!$should_verified && $user->email_verified_at) {
            $user->forceFill(['email_verified_at' => null])->save();
        }

        return redirect()
            ->route('admin.users.index')
            ->with('success', "User '{$user->name}' berhasil diperbarui.");
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(User $user): RedirectResponse
    {
        // Prevent deleting users with orders
        if ($user->orders()->count() > 0) {
            return back()->with('error', "Tidak dapat menghapus user '{$user->name}' karena memiliki riwayat order.");
        }

        // Prevent deleting admin users
        if ($user->is_admin) {
            return back()->with('error', "Tidak dapat menghapus user admin.");
        }

        $userName = $user->name;
        $user->delete();

        return redirect()
            ->route('admin.users.index')
            ->with('success', "User '{$userName}' berhasil dihapus.");
    }

    /**
     * Toggle user active status
     */
    public function toggleStatus(User $user): JsonResponse
    {
        $user->update(['is_active' => !$user->is_active]);
        
        $status = $user->is_active ? 'diaktifkan' : 'dinonaktifkan';
        
        return response()->json([
            'success' => true,
            'message' => "User '{$user->name}' berhasil {$status}.",
            'is_active' => $user->is_active,
        ]);
    }

    /**
     * Verify user email
     */
    public function verifyEmail(User $user): JsonResponse
    {
        if ($user->email_verified_at) {
            return response()->json([
                'success' => false,
                'message' => 'Email sudah terverifikasi.'
            ]);
        }

        // Hindari mass assignment pada email_verified_at
        $user->forceFill(['email_verified_at' => now()])->save();

        return response()->json([
            'success' => true,
            'message' => "Email user '{$user->name}' berhasil diverifikasi."
        ]);
    }

    /**
     * Unverify user email
     */
    public function unverifyEmail(User $user): JsonResponse
    {
        if (!$user->email_verified_at) {
            return response()->json([
                'success' => false,
                'message' => 'Email sudah dalam status belum terverifikasi.'
            ]);
        }

        $user->forceFill(['email_verified_at' => null])->save();

        return response()->json([
            'success' => true,
            'message' => "Status verifikasi email untuk '{$user->name}' telah dihapus."
        ]);
    }

    /**
     * Reset user password
     */
    public function resetPassword(Request $request, User $user): RedirectResponse
    {
        $request->validate([
            'new_password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user->update([
            'password' => bcrypt($request->new_password)
        ]);

        return back()->with('success', "Password user '{$user->name}' berhasil direset.");
    }

    /**
     * Get user statistics for AJAX requests
     */
    public function getUserStats(Request $request): JsonResponse
    {
        $dateFrom = $request->input('date_from', Carbon::now()->startOfMonth());
        $dateTo = $request->input('date_to', Carbon::now()->endOfMonth());

        $stats = [
            'new_users' => User::whereBetween('created_at', [$dateFrom, $dateTo])->count(),
            'active_users' => User::active()->whereBetween('created_at', [$dateFrom, $dateTo])->count(),
            'verified_users' => User::whereNotNull('email_verified_at')->whereBetween('created_at', [$dateFrom, $dateTo])->count(),
            'user_growth' => User::selectRaw('DATE(created_at) as date, COUNT(*) as count')
                ->whereBetween('created_at', [$dateFrom, $dateTo])
                ->groupBy('date')
                ->orderBy('date')
                ->pluck('count', 'date'),
            'gender_distribution' => User::selectRaw('gender, COUNT(*) as count')
                ->whereNotNull('gender')
                ->groupBy('gender')
                ->pluck('count', 'gender'),
            'top_spenders' => User::withSum(['orders as total_spent' => function ($q) {
                    $q->confirmed();
                }], 'total_amount')
                ->orderByDesc('total_spent')
                ->limit(10)
                ->get(['id', 'name', 'email', 'total_spent']),
        ];

        return response()->json($stats);
    }

    // Export CSV dihapus
}
