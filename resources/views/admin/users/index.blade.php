@extends('admin.layouts.app')

@section('title', 'Kelola Users')

@section('content')
<div class="container mx-auto px-6 py-8">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
        <div class="mb-4 sm:mb-0">
            <h1 class="text-3xl font-bold text-gray-900 flex items-center gap-3">
                <x-heroicon-o-users class="w-8 h-8 text-indigo-600" />
                Kelola Users
            </h1>
            <p class="mt-2 text-gray-600">Manage semua pengguna sistem (admin & customer)</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.users.export', request()->all()) }}" 
               class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:outline-none focus:border-green-900 focus:ring ring-green-300 transition ease-in-out duration-150">
                <x-heroicon-o-document-arrow-down class="w-4 h-4 mr-2" />
                Export CSV
            </a>
            <a href="{{ route('admin.users.create') }}" 
               class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 transition ease-in-out duration-150">
                <x-heroicon-o-plus class="w-4 h-4 mr-2" />
                Tambah User
            </a>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 xl:grid-cols-7 gap-4 mb-8">
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-4">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <x-heroicon-o-users class="h-5 w-5 text-gray-400" />
                    </div>
                    <div class="ml-3 w-0 flex-1">
                        <dl>
                            <dt class="text-xs font-medium text-gray-500 truncate">Total Users</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ number_format($stats['total']) }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-4">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <x-heroicon-o-user class="h-5 w-5 text-blue-400" />
                    </div>
                    <div class="ml-3 w-0 flex-1">
                        <dl>
                            <dt class="text-xs font-medium text-gray-500 truncate">Customers</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ number_format($stats['customers']) }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-4">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <x-heroicon-o-shield-check class="h-5 w-5 text-purple-400" />
                    </div>
                    <div class="ml-3 w-0 flex-1">
                        <dl>
                            <dt class="text-xs font-medium text-gray-500 truncate">Admins</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ number_format($stats['admins']) }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-4">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <x-heroicon-o-check-circle class="h-5 w-5 text-green-400" />
                    </div>
                    <div class="ml-3 w-0 flex-1">
                        <dl>
                            <dt class="text-xs font-medium text-gray-500 truncate">Active</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ number_format($stats['active']) }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-4">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <x-heroicon-o-x-circle class="h-5 w-5 text-red-400" />
                    </div>
                    <div class="ml-3 w-0 flex-1">
                        <dl>
                            <dt class="text-xs font-medium text-gray-500 truncate">Inactive</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ number_format($stats['inactive']) }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-4">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <x-heroicon-o-user-plus class="h-5 w-5 text-green-500" />
                    </div>
                    <div class="ml-3 w-0 flex-1">
                        <dl>
                            <dt class="text-xs font-medium text-gray-500 truncate">New This Month</dt>
                            <dd class="text-sm font-medium text-gray-900">{{ number_format($stats['new_this_month']) }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-4">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <x-heroicon-o-check-circle class="h-5 w-5 text-blue-500" />
                    </div>
                    <div class="ml-3 w-0 flex-1">
                        <dl>
                            <dt class="text-xs font-medium text-gray-500 truncate">Verified</dt>
                            <dd class="text-sm font-medium text-gray-900">{{ number_format($stats['verified']) }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Search and Filter -->
    <div class="bg-white shadow rounded-lg p-6 mb-6">
        <form method="GET" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Search -->
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-700">Cari User</label>
                    <div class="mt-1 relative">
                        <input type="text" 
                               name="search" 
                               id="search"
                               value="{{ request('search') }}"
                               placeholder="Nama, email, phone..."
                               class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md pl-10">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <x-heroicon-o-magnifying-glass class="h-5 w-5 text-gray-400" />
                        </div>
                    </div>
                </div>

                <!-- Role Filter -->
                <div>
                    <label for="role" class="block text-sm font-medium text-gray-700">Role</label>
                    <select name="role" id="role" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                        <option value="">Semua Role</option>
                        <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="customer" {{ request('role') == 'customer' ? 'selected' : '' }}>Customer</option>
                    </select>
                </div>

                <!-- Status Filter -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                    <select name="status" id="status" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                        <option value="">Semua Status</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>

                <!-- Gender Filter -->
                <div>
                    <label for="gender" class="block text-sm font-medium text-gray-700">Gender</label>
                    <select name="gender" id="gender" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                        <option value="">Semua Gender</option>
                        <option value="male" {{ request('gender') == 'male' ? 'selected' : '' }}>Male</option>
                        <option value="female" {{ request('gender') == 'female' ? 'selected' : '' }}>Female</option>
                    </select>
                </div>

                <!-- Date From -->
                <div>
                    <label for="date_from" class="block text-sm font-medium text-gray-700">Registered From</label>
                    <input type="date" 
                           name="date_from" 
                           id="date_from"
                           value="{{ request('date_from') }}"
                           class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>

                <!-- Date To -->
                <div>
                    <label for="date_to" class="block text-sm font-medium text-gray-700">Registered To</label>
                    <input type="date" 
                           name="date_to" 
                           id="date_to"
                           value="{{ request('date_to') }}"
                           class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>

                <!-- Quick Date Filter -->
                <div>
                    <label for="date_filter" class="block text-sm font-medium text-gray-700">Quick Filter</label>
                    <select name="date_filter" id="date_filter" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                        <option value="">Pilih Periode</option>
                        <option value="today" {{ request('date_filter') == 'today' ? 'selected' : '' }}>Hari Ini</option>
                        <option value="this_week" {{ request('date_filter') == 'this_week' ? 'selected' : '' }}>Minggu Ini</option>
                        <option value="this_month" {{ request('date_filter') == 'this_month' ? 'selected' : '' }}>Bulan Ini</option>
                        <option value="last_month" {{ request('date_filter') == 'last_month' ? 'selected' : '' }}>Bulan Lalu</option>
                    </select>
                </div>

                <!-- Sort -->
                <div>
                    <label for="sort" class="block text-sm font-medium text-gray-700">Sort By</label>
                    <select name="sort" id="sort" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                        <option value="created_at" {{ request('sort') == 'created_at' ? 'selected' : '' }}>Registration Date</option>
                        <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Name</option>
                        <option value="email" {{ request('sort') == 'email' ? 'selected' : '' }}>Email</option>
                        <option value="orders_count" {{ request('sort') == 'orders_count' ? 'selected' : '' }}>Order Count</option>
                        <option value="total_spent" {{ request('sort') == 'total_spent' ? 'selected' : '' }}>Total Spent</option>
                    </select>
                </div>
            </div>

            <div class="flex items-center gap-2">
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 transition ease-in-out duration-150">
                    <x-heroicon-o-magnifying-glass class="w-4 h-4 mr-2" />
                    Cari
                </button>
                <a href="{{ route('admin.users.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400 focus:outline-none focus:border-gray-500 focus:ring ring-gray-300 transition ease-in-out duration-150">
                    <x-heroicon-o-arrow-path class="w-4 h-4 mr-2" />
                    Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Users Table -->
    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        @if($users->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                User
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Contact & Profile
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Role & Status
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Activity
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Registered
                            </th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($users as $user)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <img class="h-10 w-10 rounded-full object-cover" 
                                                 src="{{ $user->getAvatarUrl() }}" 
                                                 alt="{{ $user->name }}">
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $user->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div>
                                        <div class="text-sm text-gray-900">{{ $user->phone ?? '-' }}</div>
                                        <div class="text-sm text-gray-500">
                                            @if($user->birth_date)
                                                {{ $user->getFormattedBirthDate() }} ({{ $user->getAge() }} tahun)
                                            @else
                                                -
                                            @endif
                                        </div>
                                        <div class="text-xs text-gray-400">
                                            {{ $user->gender ? ucfirst($user->gender) : '-' }}
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex flex-col gap-1">
                                        @php $badge = $user->getStatusBadge() @endphp
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $badge['class'] }}">
                                            {{ $badge['text'] }}
                                        </span>
                                        
                                        @if(!$user->email_verified_at)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                                                <x-heroicon-o-exclamation-triangle class="w-3 h-3 mr-1" />
                                                Not Verified
                                            </span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <div>
                                        <div class="text-sm font-medium">{{ $user->orders_count ?? 0 }} orders</div>
                                        <div class="text-sm text-gray-500">Rp {{ number_format($user->total_spent ?? 0, 0, ',', '.') }}</div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $user->created_at->format('d M Y') }}</div>
                                    <div class="text-sm text-gray-500">{{ $user->created_at->diffForHumans() }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('admin.users.show', $user) }}" 
                                           class="text-indigo-600 hover:text-indigo-900 p-1 rounded">
                                            <x-heroicon-o-eye class="w-4 h-4" />
                                        </a>
                                        <a href="{{ route('admin.users.edit', $user) }}" 
                                           class="text-indigo-600 hover:text-indigo-900 p-1 rounded">
                                            <x-heroicon-o-pencil-square class="w-4 h-4" />
                                        </a>
                                        <button onclick="toggleStatus({{ $user->id }}, '{{ $user->name }}')"
                                                class="text-gray-600 hover:text-gray-900 p-1 rounded">
                                            @if($user->is_active)
                                                <x-heroicon-o-eye-slash class="w-4 h-4" />
                                            @else
                                                <x-heroicon-o-eye class="w-4 h-4" />
                                            @endif
                                        </button>
                                        @if(!$user->email_verified_at)
                                            <button onclick="verifyEmail({{ $user->id }}, '{{ $user->name }}')"
                                                    class="text-blue-600 hover:text-blue-900 p-1 rounded">
                                                <x-heroicon-o-check-circle class="w-4 h-4" />
                                            </button>
                                        @endif
                                        @if(!$user->is_admin && $user->orders()->count() == 0)
                                            <button onclick="deleteUser({{ $user->id }}, '{{ $user->name }}')"
                                                    class="text-red-600 hover:text-red-900 p-1 rounded">
                                                <x-heroicon-o-trash class="w-4 h-4" />
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                {{ $users->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <x-heroicon-o-users class="mx-auto h-12 w-12 text-gray-400" />
                <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada user</h3>
                <p class="mt-1 text-sm text-gray-500">
                    {{ request()->anyFilled(['search', 'role', 'status', 'gender', 'date_from', 'date_to', 'date_filter']) 
                        ? 'Tidak ada user yang sesuai dengan filter yang dipilih.' 
                        : 'Mulai dengan menambahkan user baru.' }}
                </p>
                @if(!request()->anyFilled(['search', 'role', 'status', 'gender', 'date_from', 'date_to', 'date_filter']))
                    <div class="mt-6">
                        <a href="{{ route('admin.users.create') }}" 
                           class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <x-heroicon-o-plus class="w-4 h-4 mr-2" />
                            Tambah User
                        </a>
                    </div>
                @endif
            </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
    function toggleStatus(userId, userName) {
        if (confirm(`Apakah Anda yakin ingin mengubah status user "${userName}"?`)) {
            fetch(`{{ url('admin/users') }}/${userId}/toggle-status`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Terjadi kesalahan: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat mengubah status user.');
            });
        }
    }

    function verifyEmail(userId, userName) {
        if (confirm(`Verifikasi email untuk user "${userName}"?`)) {
            fetch(`{{ url('admin/users') }}/${userId}/verify-email`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Terjadi kesalahan: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat verifikasi email.');
            });
        }
    }

    function deleteUser(userId, userName) {
        if (confirm(`Apakah Anda yakin ingin menghapus user "${userName}"?\n\nPerhatian: User dengan riwayat order tidak dapat dihapus.`)) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `{{ url('admin/users') }}/${userId}`;
            form.innerHTML = `
                @csrf
                @method('DELETE')
            `;
            document.body.appendChild(form);
            form.submit();
        }
    }
</script>
@endpush
@endsection
