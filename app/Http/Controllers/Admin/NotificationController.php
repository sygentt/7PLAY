<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Str;

class NotificationController extends Controller
{
    public function index(Request $request): View
    {
        $query = Notification::query()->with('user');

        if ($request->filled('search')) {
            $search = $request->string('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('message', 'like', "%{$search}%");
            });
        }

        if ($request->filled('type')) {
            $query->where('type', $request->string('type'));
        }

        if ($request->filled('status')) {
            if ($request->status === 'unread') {
                $query->where('is_read', false);
            } elseif ($request->status === 'read') {
                $query->where('is_read', true);
            }
        }

        $notifications = $query->orderByDesc('created_at')->paginate(10)->appends($request->query());

        return view('admin.notifications.index', compact('notifications'));
    }

    public function create(): View
    {
        $users = User::orderBy('name')->select('id', 'name')->get();
        return view('admin.notifications.create', compact('users'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'user_id' => 'required',
            'type' => 'required|string|in:order,movie,system,promo',
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'data' => 'nullable|string',
        ]);

        $dataPayload = null;
        if ($request->filled('data')) {
            $decoded = json_decode($request->input('data'), true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                return back()->withInput()->withErrors(['data' => 'Data tambahan harus JSON valid.']);
            }
            $dataPayload = $decoded;
        }

        // If 'all', create notifications for all users in chunks for efficiency
        if ($validated['user_id'] === 'all') {
            $now = now();
            $batchKey = (string) Str::uuid();
            // Merge meta for broadcast
            $dataArray = is_array($dataPayload) ? $dataPayload : [];
            $dataArray['audience'] = 'all';
            $dataArray['batch_key'] = $batchKey;
            // Allow email push via checkbox in future; default true for broadcast
            if (!array_key_exists('send_email', $dataArray)) {
                $dataArray['send_email'] = true;
            }
            // On bulk insert, model casts are bypassed. Encode array to JSON string.
            $dataValue = json_encode($dataArray);
            $payload = [
                'type' => $validated['type'],
                'title' => $validated['title'],
                'message' => $validated['message'],
                'data' => $dataValue,
                'is_read' => false,
                'created_at' => $now,
                'updated_at' => $now,
            ];

            User::query()->select('id')->chunk(500, function ($users) use ($payload) {
                $toInsert = [];
                foreach ($users as $u) {
                    $row = $payload;
                    $row['user_id'] = $u->id;
                    $toInsert[] = $row;
                }
                if (!empty($toInsert)) {
                    Notification::insert($toInsert);
                }
            });
        } else {
            // otherwise, single user (validate exists)
            $request->validate([
                'user_id' => 'exists:users,id'
            ]);

            Notification::create([
                'user_id' => (int) $validated['user_id'],
                'type' => $validated['type'],
                'title' => $validated['title'],
                'message' => $validated['message'],
                'data' => $dataPayload,
                'is_read' => false,
            ]);
        }

        return redirect()->route('admin.notifications.index')->with('success', 'Notifikasi berhasil dibuat.');
    }

    public function edit(Notification $notification): View
    {
        $users = User::orderBy('name')->select('id', 'name')->get();
        return view('admin.notifications.edit', compact('notification', 'users'));
    }

    public function update(Request $request, Notification $notification): RedirectResponse
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'type' => 'required|string|in:order,movie,system,promo',
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'data' => 'nullable|string',
            'is_read' => 'sometimes|boolean',
        ]);

        $dataPayload = null;
        if ($request->filled('data')) {
            $decoded = json_decode($request->input('data'), true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                return back()->withInput()->withErrors(['data' => 'Data tambahan harus JSON valid.']);
            }
            $dataPayload = $decoded;
        }

        $notification->update([
            'user_id' => $validated['user_id'],
            'type' => $validated['type'],
            'title' => $validated['title'],
            'message' => $validated['message'],
            'data' => $dataPayload,
            'is_read' => $request->boolean('is_read', $notification->is_read),
            'read_at' => $request->boolean('is_read') ? now() : null,
        ]);

        return redirect()->route('admin.notifications.index')->with('success', 'Notifikasi berhasil diperbarui.');
    }

    public function destroy(Notification $notification): RedirectResponse
    {
        $notification->delete();
        return redirect()->route('admin.notifications.index')->with('success', 'Notifikasi berhasil dihapus.');
    }
}


