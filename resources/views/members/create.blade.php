<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Add New Member</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if (session('success'))
                        <div class="mb-4 font-medium text-sm text-green-600">{{ session('success') }}</div>
                    @endif

                    @if ($errors->any())
                        <div class="mb-4">
                            <ul class="list-disc list-inside text-sm text-red-600">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('members.store') }}" class="space-y-6">
                        @csrf

                        <div>
                            <h3 class="font-semibold">1. Personal Details</h3>
                            <label for="member_code" class="block font-medium text-sm text-gray-700 mt-2">Member Code (e.g., GYM001)</label>
                            <x-input id="member_code" class="block mt-1 w-full" type="text" name="member_code" :value="old('member_code')" required />
                            <x-input-error :messages="$errors->get('member_code')" class="mt-2" />

                            <label for="name" class="block font-medium text-sm text-gray-700 mt-4">Full Name</label>
                            <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />

                            <label for="phone" class="block font-medium text-sm text-gray-700 mt-4">Phone Number</label>
                            <x-input id="phone" class="block mt-1 w-full" type="text" name="phone" :value="old('phone')" />
                            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                        </div>

                        <div>
                            <h3 class="font-semibold">2. Membership Plan</h3>
                            <label for="plan_name" class="block font-medium text-sm text-gray-700 mt-2">SK Fitness Membership Plan</label>
                            <select id="plan_name" name="plan_name" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                <option value="">Select a Plan...</option>

                                <optgroup label="🔥 Limited Opening Offers">
                                    <option value="Offer - 1 Month Strength">1 Month Strength (Offer) - ₹1299</option>
                                    <option value="Offer - 1 Month Cardio+Strength">1 Month Cardio + Strength (Offer) - ₹1599</option>
                                    <option value="Offer - 3 Months Strength">3 Months Strength (Offer) - ₹3499</option>
                                    <option value="Offer - 3 Months Cardio+Strength">3 Months Cardio + Strength (Offer) - ₹4499</option>
                                </optgroup>

                                <optgroup label="1 Month Plans (30 Days)">
                                    <option value="1 Month Strength">Strength - ₹1399</option>
                                    <option value="1 Month Cardio+Strength">Cardio + Strength - ₹1799</option>
                                </optgroup>

                                <optgroup label="3 Month Plans (90 Days)">
                                    <option value="3 Months Strength">Strength - ₹3999</option>
                                    <option value="3 Months Cardio+Strength">Cardio + Strength - ₹4999</option>
                                </optgroup>

                                <optgroup label="6 Month Plans (180 Days)">
                                    <option value="6 Months Strength">Strength - ₹6999</option>
                                    <option value="6 Months Cardio+Strength">Cardio + Strength - ₹8999</option>
                                </optgroup>

                                <optgroup label="12 Month Plans (365 Days)">
                                    <option value="12 Months Strength">Strength - ₹11999</option>
                                    <option value="12 Months Cardio+Strength">Cardio + Strength - ₹13999</option>
                                </optgroup>
                            </select>
                            <x-input-error :messages="$errors->get('plan_name')" class="mt-2" />

                            <label for="start_date" class="block font-medium text-sm text-gray-700 mt-4">Start Date</label>
                            <x-text-input id="start_date" name="start_date" type="date" class="mt-1 block w-full" value="{{ date('Y-m-d') }}" required />
                            <x-input-error :messages="$errors->get('start_date')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-button type="submit">Save Member & Activate Plan</x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
