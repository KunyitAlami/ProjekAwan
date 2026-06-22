@extends('layout.app')

@section('title', 'Admin Dashboard - MiniStack Cloud')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    <!-- Header Section -->
    <div class="mb-10">
        <h2 class="text-3xl font-bold mb-2 text-slate-900 dark:text-white">Admin Dashboard</h2>
        <p class="text-slate-500 dark:text-slate-400 text-sm">System overview and platform management.</p>
    </div>

    <!-- Quick Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-10">
        <div class="bg-white dark:bg-slate-800 p-5 rounded-lg border border-slate-200 dark:border-slate-700 shadow-sm flex flex-col">
            <span class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-1">Total Users</span>
            <span class="text-2xl font-bold text-slate-900 dark:text-white">{{ $stats['totalUsers'] }}</span>
        </div>
        <div class="bg-white dark:bg-slate-800 p-5 rounded-lg border border-slate-200 dark:border-slate-700 shadow-sm flex flex-col">
            <span class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-1">Active Users</span>
            <span class="text-2xl font-bold text-emerald-600 dark:text-emerald-400">{{ $stats['activeUsers'] }}</span>
        </div>
        <div class="bg-white dark:bg-slate-800 p-5 rounded-lg border border-slate-200 dark:border-slate-700 shadow-sm flex flex-col">
            <span class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-1">Total Resources</span>
            <span class="text-2xl font-bold text-slate-900 dark:text-white">{{ $stats['totalResources'] }}</span>
        </div>
        <div class="bg-white dark:bg-slate-800 p-5 rounded-lg border border-slate-200 dark:border-slate-700 shadow-sm flex flex-col">
            <span class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-1">Running Resources</span>
            <span class="text-2xl font-bold text-indigo-600 dark:text-indigo-400">{{ $stats['runningResources'] }}</span>
        </div>
    </div>

    <!-- Users Section -->
    <div class="mb-10">
        <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-4">Registered Accounts</h3>
        <div class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left whitespace-nowrap">
                    <thead class="text-xs text-slate-500 uppercase bg-slate-50 dark:bg-slate-900/50 border-b border-slate-200 dark:border-slate-700">
                        <tr>
                            <th scope="col" class="px-6 py-4 font-semibold">User</th>
                            <th scope="col" class="px-6 py-4 font-semibold">Role</th>
                            <th scope="col" class="px-6 py-4 font-semibold">Status</th>
                            <th scope="col" class="px-6 py-4 font-semibold">Storage Package</th>
                            <th scope="col" class="px-6 py-4 font-semibold text-right">Registered</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-700/50">
                        @forelse($users as $user)
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50">
                            <td class="px-6 py-3">
                                <div class="flex flex-col">
                                    <span class="font-medium text-slate-900 dark:text-white">{{ $user->username }}</span>
                                    <span class="text-slate-500 text-xs">{{ $user->email }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-3">
                                <span class="text-xs font-medium px-2 py-0.5 rounded {{ $user->role === 'admin' ? 'bg-indigo-100 text-indigo-800 dark:bg-indigo-900/40 dark:text-indigo-300' : 'bg-slate-100 text-slate-700 dark:bg-slate-700 dark:text-slate-300' }}">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                            <td class="px-6 py-3">
                                <span class="text-xs font-medium flex items-center gap-1.5 {{ $user->status === 'active' ? 'text-emerald-600' : 'text-red-500' }}">
                                    <div class="w-1.5 h-1.5 rounded-full {{ $user->status === 'active' ? 'bg-emerald-500' : 'bg-red-500' }}"></div>
                                    {{ ucfirst($user->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-3 text-slate-600 dark:text-slate-300">
                                {{ $user->package_name ?? '-' }}
                            </td>
                            <td class="px-6 py-3 text-right text-slate-500">
                                {{ \Carbon\Carbon::parse($user->created_at)->format('d M Y') }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-slate-500">No users found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($users->hasPages())
                <div class="px-6 py-4 border-t border-slate-200 dark:border-slate-700">
                    {{ $users->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Resources Section -->
    <div class="mb-10">
        <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-4">Provisioned Resources</h3>
        <div class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left whitespace-nowrap">
                    <thead class="text-xs text-slate-500 uppercase bg-slate-50 dark:bg-slate-900/50 border-b border-slate-200 dark:border-slate-700">
                        <tr>
                            <th scope="col" class="px-6 py-4 font-semibold">Resource Name</th>
                            <th scope="col" class="px-6 py-4 font-semibold">Owner</th>
                            <th scope="col" class="px-6 py-4 font-semibold">Type</th>
                            <th scope="col" class="px-6 py-4 font-semibold">Status</th>
                            <th scope="col" class="px-6 py-4 font-semibold text-right">Created</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-700/50">
                        @forelse($resources as $resource)
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50">
                            <td class="px-6 py-3 font-medium text-slate-900 dark:text-white">
                                {{ $resource->name }}
                            </td>
                            <td class="px-6 py-3 text-slate-600 dark:text-slate-300">
                                {{ $resource->user_name }}
                            </td>
                            <td class="px-6 py-3">
                                <span class="text-xs font-medium text-slate-500">
                                    @if($resource->type === 'compute_metadata') Compute
                                    @elseif($resource->type === 'network_metadata') Network
                                    @else Storage
                                    @endif
                                </span>
                            </td>
                            <td class="px-6 py-3">
                                @php
                                    $statusColor = match($resource->status) {
                                        'running' => 'text-emerald-600 bg-emerald-50 dark:bg-emerald-900/20',
                                        'pending' => 'text-amber-600 bg-amber-50 dark:bg-amber-900/20',
                                        'stopped' => 'text-slate-600 bg-slate-100 dark:bg-slate-700/50',
                                        default => 'text-red-600 bg-red-50 dark:bg-red-900/20'
                                    };
                                    $dotColor = match($resource->status) {
                                        'running' => 'bg-emerald-500',
                                        'pending' => 'bg-amber-500',
                                        'stopped' => 'bg-slate-500',
                                        default => 'bg-red-500'
                                    };
                                @endphp
                                <span class="text-[11px] font-semibold px-2 py-0.5 rounded-full flex items-center gap-1.5 w-max {{ $statusColor }}">
                                    <div class="w-1.5 h-1.5 rounded-full {{ $dotColor }}"></div>
                                    {{ strtoupper($resource->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-3 text-right text-slate-500">
                                {{ \Carbon\Carbon::parse($resource->created_at)->format('d M Y, H:i') }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-slate-500">No resources found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($resources->hasPages())
                <div class="px-6 py-4 border-t border-slate-200 dark:border-slate-700">
                    {{ $resources->links() }}
                </div>
            @endif
        </div>
    </div>

</div>
@endsection
