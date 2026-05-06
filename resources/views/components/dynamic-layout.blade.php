@if(Auth::user()->role === 'landlord')
    <x-employee-layout>
        @if(isset($header))
            <x-slot name="header">{{ $header }}</x-slot>
        @endif
        {{ $slot }}
    </x-employee-layout>
@else
    <x-app-layout>
        @if(isset($header))
            <x-slot name="header">{{ $header }}</x-slot>
        @endif
        {{ $slot }}
    </x-app-layout>
@endif