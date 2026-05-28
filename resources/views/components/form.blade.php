@props([
    'post' => null,
    'delete' => null,
    'put' => null,
    'flat' => false,
    'patch'=> false
])


@php

    $method = ($post or $patch or $delete or $put) ? 'POST' : 'GET';

@endphp

<form {{ $attributes->class(['gap-4 flex flex-col' => !$flat]) }} method="{{ $method }}">
    @if ($method != 'GET')
        @csrf
    @endif
    @if ($delete)
        @method('DELETE')
    @endif
    @if ($put)
        @method('PUT')
    @endif
    @if ($patch)
        @method('PATCH')
    @endif
    {{ $slot }}
</form>
