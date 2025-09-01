<?php

namespace App\Http\Controllers;

use App\Models\PointTransaction;
use App\Models\UserPoint;
use App\Models\UserVoucher;
use App\Models\Voucher;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PointsController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $user_points = UserPoint::firstOrCreate(['user_id' => $user->id], [
            'total_points' => 0,
            'total_orders' => 0,
            'membership_level' => 'bronze',
        ]);

        $available_vouchers = Voucher::query()
            ->where('is_active', true)
            ->where('valid_from', '<=', now())
            ->where('valid_until', '>=', now())
            ->orderBy('points_required')
            ->get();

        $user_vouchers = UserVoucher::with('voucher')
            ->where('user_id', $user->id)
            ->latest()
            ->get();

        $transactions = PointTransaction::where('user_id', $user->id)
            ->latest()
            ->limit(20)
            ->get();

        return view('points.index', compact('user_points', 'available_vouchers', 'user_vouchers', 'transactions'));
    }

    public function redeem(Request $request, Voucher $voucher)
    {
        $user = Auth::user();

        try {
            if (!$voucher->isAvailable()) {
                return response()->json(['success' => false, 'message' => 'Voucher tidak tersedia'], 400);
            }

            DB::beginTransaction();

            $user_points = UserPoint::lockForUpdate()->firstOrCreate(['user_id' => $user->id], [
                'total_points' => 0,
                'total_orders' => 0,
                'membership_level' => 'bronze',
            ]);

            $required = (int) ($voucher->points_required ?? 0);
            if ($required <= 0) {
                DB::rollBack();
                return response()->json(['success' => false, 'message' => 'Voucher tidak bisa ditukar dengan poin'], 400);
            }
            if ($user_points->total_points < $required) {
                DB::rollBack();
                return response()->json(['success' => false, 'message' => 'Poin Anda tidak cukup'], 400);
            }

            // Kurangi poin
            $user_points->decrement('total_points', $required);

            // Catat transaksi poin
            PointTransaction::create([
                'user_id' => $user->id,
                'type' => 'spent',
                'points' => $required,
                'description' => 'Tukar voucher: ' . $voucher->name,
                'voucher_id' => $voucher->id,
            ]);

            // Buat user_voucher
            $user_voucher = UserVoucher::create([
                'user_id' => $user->id,
                'voucher_id' => $voucher->id,
                'redeemed_at' => now(),
                'is_used' => false,
            ]);

            // Tambah used_count voucher jika ada limit
            if (!is_null($voucher->usage_limit)) {
                $voucher->increment('used_count');
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Voucher berhasil ditukar',
                'user_voucher' => $user_voucher->load('voucher'),
                'remaining_points' => $user_points->fresh()->total_points,
            ]);

        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Gagal menukar voucher: ' . $e->getMessage()], 500);
        }
    }
}


