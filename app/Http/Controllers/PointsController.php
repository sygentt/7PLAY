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

        // Ambil ID voucher yang sudah dimiliki user
        $claimed_voucher_ids = UserVoucher::where('user_id', $user->id)
            ->pluck('voucher_id')
            ->toArray();

        // Hanya tampilkan voucher yang belum diklaim user
        $available_vouchers = Voucher::query()
            ->where('is_active', true)
            ->where('valid_from', '<=', now())
            ->where('valid_until', '>=', now())
            ->whereNotIn('id', $claimed_voucher_ids)
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
            
            // Cek apakah ini voucher gratis (0 poin)
            $is_free_voucher = $required === 0;
            
            // Jika bukan voucher gratis, validasi poin user
            if (!$is_free_voucher && $user_points->total_points < $required) {
                DB::rollBack();
                return response()->json(['success' => false, 'message' => 'Poin Anda tidak cukup'], 400);
            }

            // Kurangi poin jika bukan voucher gratis
            if (!$is_free_voucher) {
                $user_points->decrement('total_points', $required);

                // Catat transaksi poin
                PointTransaction::create([
                    'user_id' => $user->id,
                    'type' => 'spent',
                    'points' => $required,
                    'description' => 'Tukar voucher: ' . $voucher->name,
                    'voucher_id' => $voucher->id,
                ]);

                // Update membership level based on new points total
                $user_points->fresh()->updateMembershipLevel();
            }

            // Buat user_voucher
            $user_voucher = UserVoucher::create([
                'user_id' => $user->id,
                'voucher_id' => $voucher->id,
                'redeemed_at' => now(),
                'is_used' => false,
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => $is_free_voucher ? 'Voucher berhasil diklaim' : 'Voucher berhasil ditukar',
                'user_voucher' => $user_voucher->load('voucher'),
                'remaining_points' => $user_points->fresh()->total_points,
                'points_spent' => $required,
            ]);

        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Gagal menukar voucher: ' . $e->getMessage()], 500);
        }
    }
}


