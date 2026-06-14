<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Assign Membership Plan to: {{ $member->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-100 p-6">

                @if(session('error'))
                    <div class="mb-4 text-sm text-red-700">{{ session('error') }}</div>
                @endif

                <form method="POST" action="{{ route('memberships.store', $member->id) }}" class="space-y-6 max-w-xl">
                    @csrf

                    <div>
                        <x-input-label for="plan_name">SK Fitness Membership Plan</x-input-label>
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
                        <x-input-error class="mt-2" :messages="$errors->get('plan_name')" />
                    </div>

                    <div>
                        <x-input-label for="duration_days">Duration (in days)</x-input-label>
                        <x-text-input id="duration_days" name="duration_days" type="number" class="mt-1 block w-full" placeholder="e.g., 30" required />
                        <x-input-error class="mt-2" :messages="$errors->get('duration_days')" />
                    </div>

                    <div>
                        <x-input-label for="start_date">Start Date</x-input-label>
                        <x-text-input id="start_date" name="start_date" type="date" class="mt-1 block w-full" value="{{ date('Y-m-d') }}" required />
                        <x-input-error class="mt-2" :messages="$errors->get('start_date')" />
                    </div>

                    <div>
                        <x-input-label for="payment_amount">Payment Amount (optional)</x-input-label>
                        <x-text-input id="payment_amount" name="payment_amount" type="number" step="0.01" class="mt-1 block w-full" placeholder="e.g., 1399" />
                        <x-input-error class="mt-2" :messages="$errors->get('payment_amount')" />
                    </div>

                    <div class="flex items-center gap-4">
                        <x-primary-button>Activate Plan</x-primary-button>
                        <a href="{{ route('members.index') }}" class="text-sm text-gray-600 hover:text-gray-900">Cancel</a>
                    </div>
                </form>

                <script>
                    (function(){
                        const prices = {
                            'Offer - 1 Month Strength': 1299,
                            'Offer - 1 Month Cardio+Strength': 1599,
                            'Offer - 3 Months Strength': 3499,
                            'Offer - 3 Months Cardio+Strength': 4499,
                            '1 Month Strength': 1399,
                            '1 Month Cardio+Strength': 1799,
                            '3 Months Strength': 3999,
                            '3 Months Cardio+Strength': 4999,
                            '6 Months Strength': 6999,
                            '6 Months Cardio+Strength': 8999,
                            '12 Months Strength': 11999,
                            '12 Months Cardio+Strength': 13999
                        };

                        const planSelect = document.getElementById('plan_name');
                        const paymentInput = document.getElementById('payment_amount');
                        const durationInput = document.getElementById('duration_days');

                        if (!planSelect) return;

                        planSelect.addEventListener('change', function(e){
                            const val = e.target.value;
                            if (prices.hasOwnProperty(val)) {
                                paymentInput.value = prices[val];
                            }

                            // optional: suggest duration based on plan label
                            if (val.includes('1 Month')) {
                                durationInput.value = 30;
                            } else if (val.includes('3 Months')) {
                                durationInput.value = 90;
                            } else if (val.includes('6 Months')) {
                                durationInput.value = 180;
                            } else if (val.includes('12 Months')) {
                                durationInput.value = 365;
                            }
                        });
                    })();
                </script>

            </div>
        </div>
    </div>
</x-app-layout>
