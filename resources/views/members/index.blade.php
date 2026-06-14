<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Member Directory</h2>
            <a href="{{ route('members.create') }}" class="bg-gray-800 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">+ Add Member</a>
        </div>
    </x-slot>

                                    
                <div class="p-6 text-gray-900">
                    @if(session('success'))
                        <div class="mb-4 font-medium text-sm text-green-600">{{ session('success') }}</div>
                    @endif
                    @if(session('error'))
                        <div class="mb-4 font-medium text-sm text-red-600">{{ session('error') }}</div>
                    @endif

                    @if(!empty($upcomingScheduled) && $upcomingScheduled->isNotEmpty())
                        <div class="mb-4 p-4 bg-yellow-50 border border-yellow-100 rounded">
                            <h4 class="font-semibold">Upcoming Scheduled Renewals</h4>
                            <div class="mt-2 text-sm text-gray-700">
                                @foreach($upcomingScheduled as $item)
                                    <div class="py-1">
                                        <strong>{{ $item->member->name ?? '—' }}</strong> — {{ $item->plan_name }} starts on {{ $item->start_date ? \Carbon\Carbon::parse($item->start_date)->format('M d, Y') : '-' }}
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Code</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Phone</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Current Plan</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Expires On</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3"></th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($members as $member)
                                @php
                                    // Grab their most recent active plan that has started
                                    $activePlan = $member->memberships->filter(function($m) {
                                        return ($m->status === 'active') && ($m->start_date && $m->start_date->lte(now()));
                                    })->first();
                                @endphp
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $member->member_code }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $member->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $member->phone }}</td>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        @if($activePlan)
                                            {{ $activePlan->plan_name }}
                                        @else
                                            <span class="text-sm text-gray-400">No Active Plan</span>
                                        @endif
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        @if($activePlan)
                                            {{ $activePlan->end_date->format('M d, Y') }}
                                        @else
                                            -
                                        @endif
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        @if($activePlan && $activePlan->end_date >= now())
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Active</span>
                                        @else
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Expired</span>
                                        @endif
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium flex items-center gap-2">
                                        <a href="{{ route('memberships.create', $member->id) }}" class="text-indigo-600 hover:text-indigo-900 bg-indigo-50 px-3 py-1 rounded-md">Renew Plan</a>
                                        @if($activePlan)
                                            @php $scheduledStart = $activePlan->end_date->copy()->addDay()->format('Y-m-d'); @endphp
                                            <a href="{{ route('memberships.create', ['member' => $member->id, 'plan_name' => $activePlan->plan_name, 'start_date' => $scheduledStart, 'schedule' => 1]) }}" class="text-yellow-700 hover:text-yellow-900 bg-yellow-50 px-3 py-1 rounded-md">Schedule Renewal</a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    @if($members->isEmpty())
                        <div class="text-center py-8 text-gray-500">No members found. Add your first member above!</div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
