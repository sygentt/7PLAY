<?php

namespace App\Http\Controllers;

use App\Models\UserVoucher;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class UserVoucherController extends Controller
{
    public function index(): View
    {
        $user = Auth::user();
        $user_vouchers = UserVoucher::with('voucher')
            ->where('user_id', $user->id)
            ->latest()
            ->paginate(12);

        $current_page = 'vouchers';
        return view('vouchers.index', compact('user_vouchers', 'current_page'));
    }
}


