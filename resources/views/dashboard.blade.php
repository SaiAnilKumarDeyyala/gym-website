<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <x-stat-card title="Total Members" :value="$stats['total_members']" icon="users" />
                <x-stat-card title="Active Members" :value="$stats['active_members']" icon="active" />
                <x-stat-card title="Inactive Members" :value="$stats['inactive_members']" icon="inactive" />
                <x-stat-card title="New This Month" :value="$stats['new_this_month']" icon="users" />
            </div>

            <div class="mt-6">
                <h3 class="text-lg font-medium text-gray-900">Revenue</h3>
                <div class="mt-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <x-stat-card title="All Time" :value="'₹'.number_format($stats['revenue_all_time'] ?? 0, 2)" icon="users" />
                    <x-stat-card title="This Month" :value="'₹'.number_format($stats['revenue_this_month'] ?? 0, 2)" icon="users" />
                    <x-stat-card title="Last 3 Months" :value="'₹'.number_format($stats['revenue_last_3_months'] ?? 0, 2)" icon="users" />
                    <x-stat-card title="Last 6 Months" :value="'₹'.number_format($stats['revenue_last_6_months'] ?? 0, 2)" icon="users" />
                </div>
            </div>

            <div class="mt-8 bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900">Quick Management Actions</h3>
                <div class="mt-4 flex gap-3">
                    <a href="{{ route('members.create') }}" class="bg-gray-800 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">+ Add New Gym Member</a>
                    <a href="{{ route('members.index') }}" class="border border-gray-300 hover:bg-gray-50 text-gray-800 font-medium py-2 px-4 rounded">View Member Directory</a>
                </div>
            </div>
            
            <div class="mt-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900">Expiring Soon (7 days)</h3>
                    <div class="mt-4">
                        @if(isset($expiringSoon) && is_array($expiringSoon) && count($expiringSoon) > 0)
                            <ul class="divide-y divide-gray-100">
                                @foreach($expiringSoon as $m)
                                    <li class="py-3 flex justify-between items-center">
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">{{ $m['member']['name'] ?? '—' }} <span class="text-xs text-gray-500">({{ $m['member']['member_code'] ?? '—' }})</span></div>
                                            <div class="text-sm text-gray-500">Expires on: {{ $m['end_date'] ?? '—' }}</div>
                                        </div>
                                        <div>
                                            <a href="{{ route('members.show', $m['member_id']) }}" class="text-indigo-600 hover:text-indigo-900">View</a>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <div class="text-sm text-gray-500">No memberships expiring within the next 7 days.</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
