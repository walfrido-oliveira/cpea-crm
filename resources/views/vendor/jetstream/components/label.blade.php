@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-medium text-sm text-gray-700']) }}>
    {!! $value ?? $slot !!} <span style="color: rgba(185, 28, 28, var(--tw-text-opacity));">{{ $attributes['required'] ? '*' : ''}}</span>
</label>
