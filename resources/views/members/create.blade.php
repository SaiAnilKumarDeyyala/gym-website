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

                    <form method="POST" action="{{ route('members.store') }}">
                        @csrf

                        <div>
                            <label for="member_code" class="block font-medium text-sm text-gray-700">Member Code (e.g., GYM001)</label>
                            <x-input id="member_code" class="block mt-1 w-full" type="text" name="member_code" :value="old('member_code')" required />
                            <x-input-error :messages="$errors->get('member_code')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <label for="name" class="block font-medium text-sm text-gray-700">Full Name</label>
                            <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <label for="phone" class="block font-medium text-sm text-gray-700">Phone Number</label>
                            <x-input id="phone" class="block mt-1 w-full" type="text" name="phone" :value="old('phone')" />
                            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-button type="submit">
                                Save Member
                            </x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
