@props(['title', 'value', 'icon' => 'users'])

<div {{ $attributes->merge(['class' => 'bg-white shadow sm:rounded-lg p-4']) }}>
    <div class="flex items-center justify-between">
        <div>
            <dt class="text-sm font-medium text-gray-500">{{ $title }}</dt>
            <dd class="mt-1 text-2xl font-semibold text-gray-900">{{ $value }}</dd>
        </div>
        <div class="flex-shrink-0">
            @if($icon === 'users')
                <svg class="h-10 w-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a4 4 0 00-4-4h-1"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 20H4v-2a4 4 0 014-4h1"/><circle cx="9" cy="7" r="4"/><circle cx="17" cy="7" r="4"/></svg>
            @elseif($icon === 'active')
                <svg class="h-10 w-10 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 13l4 4L19 7"/></svg>
            @elseif($icon === 'inactive')
                <svg class="h-10 w-10 text-yellow-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3"/></svg>
            @else
                <svg class="h-10 w-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3"/></svg>
            @endif
        </div>
    </div>
</div>
